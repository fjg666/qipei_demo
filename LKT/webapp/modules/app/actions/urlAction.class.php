<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');

class urlAction extends Action {

    public function getDefaultView() {
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();
        return ;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));

        $this->$app();
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    public function geturl(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $get = trim($request->getParameter('get'));

        $sql = "select $get from lkt_third where id = 1";
        $r = $db->select($sql);
        if ($r) {
            if (!empty($r[0]->kefu_url)) {
                $r[0]->kefu_url = htmlspecialchars_decode($r[0]->kefu_url).'&store_id='.$store_id;
            }else if (!empty($r[0]->mini_url)) {
                $r[0]->mini_url = htmlspecialchars_decode($r[0]->mini_url).'?store_id='.$store_id;
            }

            if (strpos($get, 'H5')) {
                $sql = "select H5_domain from lkt_config where store_id = '$store_id'";
                $rr = $db->select($sql);
                if (!empty($rr[0]->H5_domain)) {
                    $r[0]->H5 = $rr[0]->H5_domain;
                }
            }
            
            echo json_encode(array('code'=>200,'url'=>$r[0],'message'=>'成功!'));
            exit;
        }else{
            echo json_encode(array('code'=>404,'message'=>'暂未配置!'));
            exit;
        }
    }
}
?>