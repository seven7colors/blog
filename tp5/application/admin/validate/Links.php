<?php
namespace app\admin\validate;
use think\Validate;
class Links extends Validate
{
    protected $rule =   [
        'title'  => 'require|max:25',
        'url'   => 'require',   
    ];
    
    protected $message  =   [
        'title.require' => '标题不能为空',
        'title.max'     => '标题最多不能超过25个字符',
        'url.require'   =>  '链接不能为空'
    ];

    protected $scene = [
        'edit'  =>  ['title','url'],
        'add'   =>  ['title','url'],
    ];



}
