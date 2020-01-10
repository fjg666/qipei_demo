<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class AjaxAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $can = addslashes(trim($request->getParameter('can'))); // 字母
        $name = addslashes(trim($request->getParameter('name'))); // 搜索
        $str = addslashes(trim($request->getParameter('str'))); // 已选中的字符串
        $str = explode(',',$str);
        $Tools = new Tools($db, $store_id, 1);

        $num = 0;
        $class_list = array();
        $class_list0 = array();
        $class_list1 = array();
        $class_list2 = array();
        $zm = array();
        $zm1 = array();
        $sql0 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc";
        $r0 = $db->select($sql0);
        if($r0){
            foreach($r0 as $k=>$val){
                $rew0 = mb_substr($val->pname,0,1); // 获取第一个字符
                $res0 = $Tools->shuzi($rew0); // 数字转拼音
                if($res0){
                    $first0 = $Tools->_getFirstCharter($res0);
                }else{
                    $first0 = $Tools->_getFirstCharter($val->pname);
                }
                $class_list0[$first0.$k] = $val;
            }
            ksort($class_list0);
            foreach ($class_list0 as $k => $v){
                $k1 = substr($k,0,1);
                $zm1[] = $k1;
            }
            $zm1 = array_unique($zm1);
            foreach ($zm1 as $k => $v){
                $zm[] = $v;
            }
        }
        if($name){
            $sql1 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 and pname like '%$name%' order by sort desc";
        }else{
            $sql1 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc";
        }
        $r1 = $db->select($sql1);
        if($r1){
            foreach($r1 as $k=>$val){
                $rew = mb_substr($val->pname,0,1); // 获取第一个字符
                $res = $Tools->shuzi($rew); // 数字转拼音
                if($res){
                    $first = $Tools->_getFirstCharter($res);
                }else{
                    $first = $Tools->_getFirstCharter($val->pname);
                }
                $class_list1[$first.$k] = $val;
            }
            ksort($class_list1);

            foreach ($class_list1 as $k => $v){
                $k1 = substr($k,0,1);
                $class_list2[$num]['zm'] = $k1;
                $class_list2[$num]['cid'] = $v->cid;
                $class_list2[$num]['pname'] = $v->pname;
                $class_list2[$num]['status'] = false;
                $num = $num + 1;
            }

            foreach ($class_list2 as $k => $v){
                if($can){
                    if($v['zm'] == $can){
                        $class_list[] = $v;
                    }
                }else if($name){
                    $class_list[] = $v;
                }else{
                    if($v['zm'] == $zm[0]){
                        $class_list[] = $v;
                    }
                }
            }
            foreach ($class_list as $k => $v){
                foreach ($str as $ke => $va){
                    if($v['cid'] == $va){
                        $class_list[$k]['status'] = true;
                    }
                }
            }
        }

        echo json_encode(array('zm'=>$zm,'class_list'=>$class_list));
        return;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>