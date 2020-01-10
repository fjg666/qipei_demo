<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');


class jifenAction extends Action
{


    public function getDefaultView()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_software_jifen where store_id = '$store_id'";

        $res = $db->select($sql);

        // $sql01 = 'select lever,ordernum,scorenum from lkt_setscore where store_id = '.$store_id.' order by lever';
        // $res = $db->select($sql01);

        $str = '[';
        //$res = array_reverse($res);
        if(!empty($res)){
            list($res) = $res;
          if($res -> xiaofeiguize){
             $data = unserialize($res -> xiaofeiguize);
             
             foreach ($data  as $k => $v) {
                $arr = explode('~',$v);
                $str .= '{"lever":' . $arr[1] . ',"ordernum":' . $k . ',"scorenum":' . $arr[0] . '},';    
             }
             $str = substr($str, 0, -1);
          }
        }
        
        $str .= ']';
        
        $request->setAttribute("res", $res);
        $request->setAttribute("str", $str);

        return View :: INPUT;

    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        

        $jifennum = $request->getParameter('jifennum');
        $switch = $request->getParameter('switch');
        $rule = trim($request->getParameter('rule'));
        $bili = addslashes(trim($request->getParameter('bili')));
        $data = json_decode($request->getParameter('data'));


        $data = serialize($data);
        //var_dump($data);die;

        $res = $db -> select("select * from lkt_software_jifen where store_id = '$store_id'");
        if(empty($res)){
            $istsql = "insert into lkt_software_jifen(store_id,jifennum,switch,rule,xiaofeibili,xiaofeiguize) values('$store_id',$jifennum,$switch,'$rule',$bili,'$data')";
            $ist = $db->insert($istsql);
        }else{
            $updsql = "update lkt_software_jifen set jifennum=$jifennum,switch=$switch,rule='$rule',xiaofeibili=$bili,xiaofeiguize='$data' where store_id = '$store_id'";
            $ist = $db->update($updsql);
        }
        
        if ($ist >= 0) {
            echo json_encode(array('code' => 1,'msg' => '修改成功!'));
            exit;
        }else{
            echo json_encode(array('code' => 0,'msg' => '修改失败!'));
            exit;
        }

    }


    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>