<?php

require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');

class TemplateModifyAction extends Action{

	public function getDefaultView(){

        	$db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
            $store_id = addslashes(trim($request->getParameter('store_id')));
            $id = addslashes(trim($request->getParameter('id')));//主键id
            $sql_c = "select id,title,trade_data,img_url,template_id,lk_desc from lkt_third_template  where  id = '$id'";
            $res_c = $db->select($sql_c);

            if($res_c){

            	foreach($res_c as $k => $v){

            		$v->image = ServerPath::getimgpath($v->img_url,1);
                    $v->trade_text = $this->getTrade($v->trade_data);//获取选中的行业文字内容
            	}
            }
            
            $res = $this->getAllTrade();//获取所有模板行业


            $request->setAttribute('res_c',$res_c[0]);
            $request->setAttribute('res',$res);
            
         
            return View :: INPUT;

	}

	public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();

	}

    public function edit(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $id = addslashes(trim($request->getParameter('id')));//模板id
        $title = addslashes(trim($request->getParameter('title')));//模板名称
        $trade_data = addslashes(trim($request->getParameter('trade_data')));//行业
        $img_url = addslashes(trim($request->getParameter('img_url')));//图片
        $template_id = addslashes(trim($request->getParameter('template_id')));//微信模板id
        $lk_desc = addslashes(trim($request->getParameter('lk_desc')));


         //切割图片路径
        if($img_url){
            $img_url = preg_replace('/.*\//','',$img_url);
        }

        $sql = "update lkt_third_template set title = '$title',trade_data = '$trade_data',img_url = '$img_url',template_id = '$template_id',lk_desc = '$lk_desc' where  id = '$id'";
        $res = $db->update($sql);

        if($res > 0){
                $db->admin_record(1,$admin_name,'修改模板'.$id.'成功！',5);
                echo  json_encode(array('suc'=>1,'msg'=>'修改模板成功！'));
                exit;
        }else{

               $db->admin_record(1,$admin_name,'修改模板'.$id.'失败！',5);
               echo json_encode(array('msg'=>'修改模板失败！'));
               exit;
        }

    }

    public function del(){

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $id = addslashes(trim($request->getParameter('id')));//模板id

        $sql = "delete from lkt_third_template where  id = '$id'";
        $res = $db->delete($sql);
        
        if($res > 0){

                $db->admin_record(1,$admin_name,'删除模板'.$id.'成功',5);
                echo json_encode(array('status'=>1,'info'=>'删除模板成功！'));
                exit;
        }else{
                $db->admin_record(1,$admin_name,'删除模板'.$id.'失败',5);
                echo json_encode(array('status'=>0,'info'=>'删除模板失败！'));
                exit;
        }
    }

	public function getRequestMethods(){

		return Request :: POST;
	}
    
    //获取选中的小程序模板行业文字内容
    private function getTrade($code){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $sql = "select code,value from lkt_data_dictionary where recycle = 0 and status = 1 and code = '$code'";
        $res = $db->select($sql);

        if($res){
            $value =$res[0]->value;
            $value_arr = explode(',', $value);
            $trade_text = $value_arr[1];
            return $trade_text;
        }else{
            return false;
        }
    }

    //获取数据字典中的全部行业数据
    private function getAllTrade(){


        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
   

        //查询数据字典的模板行业
        $sql_data = "select code,value from lkt_data_dictionary where name = '小程序模板行业' and status = 1 and recycle = 0";
        $res_data = $db->select($sql_data);

        $trade_arr = array();
        if($res_data){

            foreach($res_data as $k => $v){

                $value = $v->value;//键,值
                $value_arr = explode(',',$value);

                $my_obj = new stdClass();
                $my_obj->trade_text = $value_arr[1];//显示的行业
                $my_obj->trade_code = $v->code;//对应数据编码

                $trade_arr[$k] = $my_obj;

            }

        }  
        return $trade_arr;
    }


}