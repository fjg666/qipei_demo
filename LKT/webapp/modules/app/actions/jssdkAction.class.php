<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JSSDK.class.php');


class jssdkAction extends Action
{

    public function getDefaultView()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //接受参数
        $store_id = addslashes(trim($request->getParameter('store_id')));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = addslashes(trim($request->getParameter('access_id')));
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
    }

    public function getData(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //接受参数
        $store_id = addslashes(trim($request->getParameter('store_id')));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = addslashes(trim($request->getParameter('access_id')));
        $url = addslashes(trim($request->getParameter('url')));

        $jssdk = new JSSDK($store_id,$url);
        $a = $jssdk->getSignPackage();

    }


}

?>