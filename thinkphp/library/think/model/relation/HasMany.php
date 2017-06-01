<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think\model\relation;

use think\Db;
use think\db\Query;
use think\Loader;
use think\Model;
use think\model\Relation;

class HasMany extends Relation
{
    /**
     * 架构函数
     * @access Public
     * @param Model  $parent     上级模型对象
     * @param string $model      模型名
     * @param string $foreignKey 关联外键
     * @param string $localKey   关联主键
     */
    public function __construct(Model $parent, $model, $foreignKey, $localKey)
    {
        $this->parent     = $parent;
        $this->model      = $model;
        $this->foreignKey = $foreignKey;
        $this->localKey   = $localKey;
        $this->query      = (new $model)->db();
    }

    /**
     * 延迟获取关联数据
     * @param string   $subRelation 子关联名
     * @param \Closure $closure     闭包查询条件
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getRelation($subRelation = '', $closure = null)
    {
        if ($closure) {
            call_user_func_array($closure, [& $this->query]);
        }
        return $this->relation($subRelation)->select();
    }

    /**
     * 预载入关联查询
     * @access   Public
     * @param array    $resultSet   数据集
     * @param string   $relation    当前关联名
     * @param string   $subRelation 子关联名
     * @param \Closure $closure     闭包
     * @return void
     */
    public function eagerlyResultSet(&$resultSet, $relation, $subRelation, $closure)
    {
        $localKey = $this->localKey;
        $range    = [];
        foreach ($resultSet as $result) {
            // 获取关联外键列表
            if (isset($result->$localKey)) {
                $range[] = $result->$localKey;
            }
        }

        if (!empty($range)) {
            $data = $this->eagerlyOneToMany($this, [
                $this->foreignKey => [
                    'in',
                    $range,
                ],
            ], $relation, $subRelation, $closure);
            // 关联属性名
            $attr = Loader::parseName($relation);
            // 关联数据封装
            foreach ($resultSet as $result) {
                if (!isset($data[$result->$localKey])) {
                    $data[$result->$localKey] = [];
                }
                $result->setAttr($attr, $this->resultSetBuild($data[$result->$localKey]));
            }
        }
    }

    /**
     * 预载入关联查询
     * @access   Public
     * @param Model    $result      数据对象
     * @param string   $relation    当前关联名
     * @param string   $subRelation 子关联名
     * @param \Closure $closure     闭包
     * @return void
     */
    public function eagerlyResult(&$result, $relation, $subRelation, $closure)
    {
        $localKey = $this->localKey;

        if (isset($result->$localKey)) {
            $data = $this->eagerlyOneToMany($this, [$this->foreignKey => $result->$localKey], $relation, $subRelation, $closure);
            // 关联数据封装
            if (!isset($data[$result->$localKey])) {
                $data[$result->$localKey] = [];
            }
            $result->setAttr(Loader::parseName($relation), $this->resultSetBuild($data[$result->$localKey]));
        }
    }

    /**
     * 关联统计
     * @access Public
     * @param Model    $result  数据对象
     * @param \Closure $closure 闭包
     * @return integer
     */
    public function relationCount($result, $closure)
    {
        $localKey = $this->localKey;
        $count    = 0;
        if (isset($result->$localKey)) {
            if ($closure) {
                call_user_func_array($closure, [& $this->query]);
            }
            $count = $this->query->where([$this->foreignKey => $result->$localKey])->count();
        }
        return $count;
    }

    /**
     * 创建关联统计子查询
     * @access Public
     * @param \Closure $closure 闭包
     * @return string
     */
    public function getRelationCountQuery($closure)
    {
        if ($closure) {
            call_user_func_array($closure, [& $this->query]);
        }

        return $this->query->where([
            $this->foreignKey => [
                'exp',
                '=' . $this->parent->getTable() . '.' . $this->parent->getPk()
            ]
        ])->fetchSql()->count();
    }

    /**
     * 一对多 关联模型预查询
     * @access Public
     * @param object $model       关联模型对象
     * @param array  $where       关联预查询条件
     * @param string $relation    关联名
     * @param string $subRelation 子关联
     * @param bool   $closure
     * @return array
     */
    protected function eagerlyOneToMany($model, $where, $relation, $subRelation = '', $closure = false)
    {
        $foreignKey = $this->foreignKey;
        // 预载入关联查询 支持嵌套预载入
        if ($closure) {
            call_user_func_array($closure, [& $model]);
        }
        $list = $model->where($where)->with($subRelation)->select();

        // 组装模型数据
        $data = [];
        foreach ($list as $set) {
            $data[$set->$foreignKey][] = $set;
        }
        return $data;
    }

    /**
     * 保存（新增）当前关联数据对象
     * @access Public
     * @param mixed $data 数据 可以使用数组 关联模型对象 和 关联对象的主键
     * @return integer
     */
    public function save($data)
    {
        if ($data instanceof Model) {
            $data = $data->getData();
        }
        // 保存关联表数据
        $data[$this->foreignKey] = $this->parent->{$this->localKey};
        $model                   = new $this->model;
        return $model->save($data);
    }

    /**
     * 批量保存当前关联数据对象
     * @access Public
     * @param array $dataSet 数据集
     * @return integer
     */
    public function saveAll(array $dataSet)
    {
        $result = false;
        foreach ($dataSet as $key => $data) {
            $result = $this->save($data);
        }
        return $result;
    }

    /**
     * 根据关联条件查询当前模型
     * @access Public
     * @param string  $operator 比较操作符
     * @param integer $count    个数
     * @param string  $id       关联表的统计字段
     * @return Query
     */
    public function has($operator = '>=', $count = 1, $id = '*')
    {
        $table = $this->query->getTable();
        return $this->parent->db()->alias('a')
            ->join($table . ' b', 'a.' . $this->localKey . '=b.' . $this->foreignKey, $this->joinType)
            ->group('b.' . $this->foreignKey)
            ->having('count(' . $id . ')' . $operator . $count);
    }

    /**
     * 根据关联条件查询当前模型
     * @access Public
     * @param mixed $where 查询条件（数组或者闭包）
     * @return Query
     */
    public function hasWhere($where = [])
    {
        $table    = $this->query->getTable();
        $model    = basename(str_replace('\\', '/', get_class($this->parent)));
        $relation = basename(str_replace('\\', '/', $this->model));
        if (is_array($where)) {
            foreach ($where as $key => $val) {
                if (false === strpos($key, '.')) {
                    $where[$relation . '.' . $key] = $val;
                    unset($where[$key]);
                }
            }
        }
        return $this->parent->db()->alias($model)
            ->field($model . '.*')
            ->join($table . ' ' . $relation, $model . '.' . $this->localKey . '=' . $relation . '.' . $this->foreignKey)
            ->where($where);
    }

    /**
     * 执行基础查询（进执行一次）
     * @access protected
     * @return void
     */
    protected function baseQuery()
    {
        if (empty($this->baseQuery)) {
            if (isset($this->parent->{$this->localKey})) {
                // 关联查询带入关联条件
                $this->query->where($this->foreignKey, $this->parent->{$this->localKey});
            }
            $this->baseQuery = true;
        }
    }

}