<?php
function arr_unique($arr2d){
	//join方法用逗号拼接值形成一个一维数组
	foreach ($arr2d as $k=>$v) {
		$v=join(',',$v);
		$temp[]=$v;
	}
	if($temp){
		//将一维数组进行去重
		$temp=array_unique($temp);
		foreach ($temp as $k=>$v) {
			//分隔逗号形成二维数组
			$temp[$k]=explode(',', $v);
		}
		return $temp;
	}
}
