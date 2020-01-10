<?php

class FuploadAction extends Action {

    public function getDefaultView() {
        $this->execute();
    }

    public function execute(){

        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $page = intval($request->getParameter('page')); //页码
        $group_id = $this->getContext()->getRequest()->getParameter('group_id') ? $this->getContext()->getRequest()->getParameter('group_id'):'-1';//分组ID
        //软件类型
        $store_type = $this->getContext()->getStorage()->read('store_type');
        //用户id
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $store_id = $store_id ? $store_id:0;

        $sql1 = "select attr,attrvalue from lkt_upload_set where type = '本地'";
        $r1 = $db->select($sql1);
        foreach ($r1 as $k => $v){
            if($v->attr == 'uploadImg_domain'){
                $uploadImg_domain = $v->attrvalue; // 图片上传域名
            }else if($v->attr == 'uploadImg'){
                $uploadImg = $v->attrvalue; // 图片上传位置
            }
        }
        if(empty($uploadImg)){
            $uploadImg = "./images";
        }
        if(is_dir($uploadImg) == ''){ // 如果文件不存在
            mkdir($uploadImg); // 创建文件
        }
        if(strpos($uploadImg,'./') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{
            $img = $uploadImg_domain . substr($uploadImg,1); // 图片路径
        }

        $files = $this->getfiles($db,$img,$store_id,$page,$group_id);
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($files);
        exit;
    }



    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    function getfiles($db,$img,$store_id,$page = 0,$group_id = -1)
    {
        $list = [];

        if(!$page || $page < 0){
            $page = 1;
        }
        $start = ($page-1)*20;
        $and = '';
        if($group_id != -1){
            $and .= " and `group` = '$group_id' ";
        }

        $sql = "select * from lkt_files_record where store_id = '$store_id' $and order by add_time desc LIMIT $start,20 ";
        $files_record = $db->select($sql);

        if($files_record){
            $code = 0;
            $msg = 'success';
            foreach ($files_record as $key => $value) {
                //不同上传类型更改url
                if($value->upload_mode == 1){
                    $url = $img.'image_'.$value->store_id.'/';
                }else if($value->upload_mode == 2){
                    $dir = $store_id . '/' . $value->store_type . '/';
                    $common = LKTConfigInfo::getOSSConfig();
                    $url = 'https://' . $common["bucket"] . '.' . $common["endpoint"] . '/' . $dir;
                }else{
                    $url = $img;
                }
                $arrayName = array('file_url' => $url.$value->image_name, 'id' => $value->id, 'selected' => 0);
                array_push($list, $arrayName);
            }            
        }else{
            $code = 1;
            $msg = 'fail';
        }
        $files = [
            'code' => $code,
            'msg' => $msg,
            'data' => [
                'list' => $list,
            ],
        ];
        return $files;

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}
?>