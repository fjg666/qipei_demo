<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');


class groupAction extends Action
{

    public function getDefaultView()
    {
        $this->execute();
    }


    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $m = addslashes(trim($request->getParameter('m')));
        $this->db = $db;
        $this->$m();
        exit;
    }


    public function getRequestMethods()
    {
        return Request :: POST;
    }

    /**
     * [list_group description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-16T15:38:28+0800
     * @return  展示分组
     */
    public function list_group()
    {
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $db = $this->db;
        $sql = "select * from lkt_img_group where store_id = '$store_id' order by sort desc";
        $group = $db->select($sql);
        $array = array('id' => '-1', "name"=>"全部","is_default"=>1);
        $group_array = [$array];
        if($group){
            foreach ($group as $key => $value) {
               $garray = array('id' => $value->id, "name"=>$value->name,"is_default"=>$value->is_default);
               array_push($group_array, $garray);
            }
        }
        echo json_encode(array('code' => 0,'data' => $group_array));
    }

    /**
     * [save_group description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-16T15:38:16+0800
     * @return  修改图片
     */
    public function save_group()
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $sdata =  $request->getParameter('data');
        $data = json_decode($sdata);

        if(isset($data->is_delete) && isset($data->id)){
            $sql = "DELETE FROM `lkt_img_group` WHERE (`id`='$data->id')";
            $res = $db->delete($sql);
        }else if(isset($data->name) && isset($data->id)){
             $modify = array('name' =>$data->name);
             $db->modify($modify, 'lkt_img_group', " `id` ='$data->id' and `store_id` = '$store_id' ");
        }else{
             $sql = "INSERT INTO `lkt_img_group` (`store_id`, `name`,`is_default`) VALUES ('$store_id', '$data->name','$data->is_default')";
             $res = $db->insert($sql);
        }

        $this->list_group();
    }

    /**
     * [move description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-16T15:37:49+0800
     * @return  移动图片
     */
    public function move()
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $sdata =  $request->getParameter('data');
        $group_id = $request->getParameter('group_id');
        $data = json_decode($sdata);
        $in = '';
        foreach ($data as $key => $value) {
           $in .=  $value->id.',';
        }
        $in = trim($in,',');
        $sql = "UPDATE `lkt_files_record` SET `group`='$group_id' WHERE id in ($in) ";
        $res = $db->update($sql);
        $this->list_group();
    }

    /**
     * @return  删除图片
     */
    public function  delete(){
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $sdata =  $request->getParameter('data');
        $data = json_decode($sdata);
        $in = '';
        foreach ($data as $key => $value) {
            $in .=  $value->id.',';
        }
        $in = trim($in,',');
        $sql = "DELETE FROM `lkt_files_record` WHERE id in ($in) ";
        $this->db->begin();
        $res = $db->update($sql);
        if($res > 0){
            $this->db->commit();
        } else {
            $this->db->rollback();
        }
        $this->list_group();
    }


}


?>