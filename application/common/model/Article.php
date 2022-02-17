<?php


namespace app\common\model;


use traits\model\SoftDelete;

class Article extends \think\Model
{
    use  SoftDelete;
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

}