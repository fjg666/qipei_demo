<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class seeAction extends Action {

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        // 接收信息
        $id = $request->getParameter("id"); // 角色id
        // 根据角色id查询角色信息
        $sql0 = "select * from lkt_role where store_id = '$store_id'and id = '$id'";
        $r0 = $db->select($sql0);
        $name = $r0[0]->name;

        $sql1 = "select menu_id from lkt_role_menu where role_id = '$id'";
        $r1 = $db->select($sql1);
        if($r1){
            $list = Tools::menu1($db,$r1);

            foreach ($list as $k => $v){
                $list1[$v->type][] = $v;
            }
            foreach ($list1 as $k => $v){
                $list2[$k]['title'] = Tools::header_data_dictionary($db,'导航栏',$k);
                $list2[$k]['id'] = $k;
                $list2[$k]['spread'] = false;
                $list2[$k]['checked'] = false;
                $list2[$k]['disabled'] = 'disabled';
                $list2[$k]['field'] = 'name1';
                $list2[$k]['children'] = $v;
            }
            foreach ($list2 as $k => $v){
                $list3[] = (object)$v;
            }
        }else{
            $list3 = array();
        }

        $list4 = json_encode($list3);

        $request->setAttribute('id', $id);
        $request->setAttribute('name', $name);
        $request->setAttribute("list", $list4);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>