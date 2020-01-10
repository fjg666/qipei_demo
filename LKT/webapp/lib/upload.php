<?php

//文件上传函数封装
/*
 * @param1 array $file,要上传的文件信息，包含5个元素
 *@param2 string $path,存储位置
 * @param3 $string error,错误信息
 * @param4 array $type=array(),MIME类型限定
 * @param5 int $size=2000000,默认2M
 *  @return mixed, 成功返回文件名，失败返回false
 */
function fileUpload($file,$path,&$error,$type=array(),$size=2000000 ){
//判断本身文件是否有效
    if(!isset($file['error'])){
        $error='文件无效';
        return false;
    }
    //有效路径的判断
    if(!is_dir($path)){
        $error='存储路径无效';
        return false;
    }
    //判断文件本身上传是否成功
    switch ($file['error']){
        case 1:
        case 2:
            $error='文件超过服务器允许大小';
            return false;
        case 3:
            $error='文件只有部分上传';
            return false;
        case 4:
            $error='用户没有选择文件上传';
            return false;
        case 6:
        case 7:
            $error='服务器操作失败';
            return false;
    }
    //判断类型是否符合
    if (!empty($type) && !in_array($file['type'],$type)){
        $error='当前上传的文件类型不符合';
        return false;
    }
    //大小判断
    if ($file['size']>$size){
        $error='文件大小超过当前允许范围.当前允许大小是：'.string($size/1000000).'M';
        return false;
    }
    //转存，移动文件
    $newfilename=getNewName($file['name']);
    if(@move_uploaded_file($file['tmp_name'],$path.''.$newfilename)){
        return $newfilename;
    }
    else{
        $error='文件上传失败';
        return false;
    }

}
//随机产生一个文件名
function getNewName($filename,$rand=6){
    $newname=date('YmdHis');//时间日期部分
    //随机部分
    $old=array_merge(range('a','z'),range('A','Z'));
    shuffle($old);
    for ($i=0;$i<$rand;$i++){
        $newname.=$old[$i];
    }
    return $newname.strstr($filename,'.');//组织有效文件名
}