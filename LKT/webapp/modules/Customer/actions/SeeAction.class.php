<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');

class SeeAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $id = intval($request->getParameter("id")); // 商城id
        $r_1_1 = array();
        // 根据新闻id，查询新闻新闻信息
        $sql = "select * from lkt_customer where id = '$id'";
        $r = $db->select($sql);
        if ($r) {
            $sql = "select * from lkt_admin where store_id = '$id' and type = 1";
            $rr = $db->select($sql);
            if ($rr) {
                $r[0]->set_admin_name = $rr[0]->name;
                $r[0]->password = $rr[0]->password;
                $role = explode(',', $rr[0]->role);
                $permission = $rr[0]->permission;
                $permission = explode(',',$permission);

                $sql = "select id,name from lkt_role where status = 1 and store_id = 0";
                $r_1 = $db->select($sql);
                if ($r_1) {
                    foreach ($role as $k => $v) {
                        foreach ($r_1 as $ke => $va) {
                            if ($v == $va->id) {
                                $va->status = 1;
                            }
                        }
                    }
                }
                $sql = "select * from lkt_plug_ins";
                $rrr = $db->select($sql);
                if($rrr){
                    foreach ($rrr as $k => $v){
                        if($permission != ''){
                            foreach ($permission as $ke => $va){
                                if($va == $v->id){
                                    $v->status = 1;
                                }
                            }
                        }
                    }
                }
            }
            $customer = $r[0];
        } else {
            $customer = array();
        }

        $request->setAttribute("customer", $customer);
        $request->setAttribute('id', $id);

        $request->setAttribute("role", $r_1);
        $request->setAttribute("list", $rrr);

        return View :: INPUT;
    }

    public function execute()
    {

    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}

?>