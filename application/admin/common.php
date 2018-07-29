<?php

//@防止后台 这里后台使用 注需配置config. 放app/common/中可前后台使用
function removeXSS($val){

    static $obj = null;

    if($obj === null){

        require '../extend/HTMLPurifier/HTMLPurifier.includes.php';

        $obj = new HTMLPurifier();
    }

    return $obj->purify($val);
}