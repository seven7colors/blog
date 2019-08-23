<?php
namespace app\admin\model;
use think\Model;
class Article extends Model
{
	protected $createTime = 'time';
    protected $updateTime = 'time';
	public function cate(){
		return $this->belongsTo('cate','cateid');
	}



}
