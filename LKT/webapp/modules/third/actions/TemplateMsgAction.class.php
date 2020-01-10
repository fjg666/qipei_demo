<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
/**
* <p>Copyright (c) 2019-2020</p>
* <p>Company: www.laiketui.com</p>
* @author 凌烨棣
* @content 小程序模板消息
* @date 2019年3月5日
* @version v2.2.1
*/

class TemplateMsgAction extends Action
{

	public function getDefaultView(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();

		$sql = "select * from lkt_notice_config ";
        $res = $db->select($sql);

        $request->setAttribute('res',$res);


        return View :: INPUT;


	}

   

	public function execute(){


	}

	public function getRequestMethods(){

        return Request :: NONE;

	}


}