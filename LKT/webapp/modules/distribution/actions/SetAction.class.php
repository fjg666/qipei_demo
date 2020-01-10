<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class SetAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $m = trim($request->getParameter('m'));
        if ($m) {
            $keyword = trim($request->getParameter('keyword'));
            if ($keyword) {
                $and = "and (u.user_id like '%$keyword%' OR u.wx_name like '%$keyword%' OR u.mobile like '%$keyword%')";
            } else {
                $and = '';
            }
            $sql = "select u.user_id,u.user_name,u.headimgurl,u.mobile,d.level from lkt_user as u left join lkt_user_distribution as d on u.user_id=d.user_id where u.store_id='$store_id' $and";
            $r = $db->select($sql);
            //var_dump($r);die;
            if ($r) {
                echo json_encode($r);
                exit;
            }
        }
        $sql = "select * from lkt_distribution_grade where store_id='$store_id'";
        $r_1 = $db->select($sql);
        if (!empty($r_1)) {
            foreach ($r_1 as $key => $value) {
                $set = $value->sets;
                $data = unserialize($set);
                $arr['id'] = $value->id;
                $arr['name'] = $data['s_dengjiname'];
                $grade[$key] = (object)$arr;
            }
            $request->setAttribute("grade", (object)$grade);
        }
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        $db->begin();
        // 接收数据 
        $uid = addslashes(trim($request->getParameter('uid')));
        $pid = addslashes(trim($request->getParameter('pid')));
        if ($uid == '') {
               $db->rollback();
               echo json_encode(array('status' => 0,'msg'=>'用户id不能为空！'));exit;
        }
        if ($uid == $pid) {
               $db->rollback();
               echo json_encode(array('status' => 0,'msg'=>'用户id和推荐人id不能为相同！'));exit;
        }
        if ($pid == '') {
               $db->rollback();
               echo json_encode(array('status' => 0,'msg'=>'请填写推荐人id！'));exit;
        }

        //查询用户id是否存在
        $sql1 = "select user_id from lkt_user where store_id='$store_id' and user_id = '$uid'";
        $r1 = $db->select($sql1);
        if (!$r1) {
               $db->rollback();
               echo json_encode(array('status' => 0,'msg'=>'用户id不存在！'));exit;
        }

        // 查询推荐人是否存在
        $sql2 = "select g.*,d.id as ldid,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where g.store_id='$store_id' and d.user_id = '$pid' ";
        $r2 = $db->select($sql2);
        if (!$r2) {
               $db->rollback();
               echo json_encode(array('status' => 0,'msg'=>'推荐人id不存在！'));exit;
        }
        $ppid = $r2[0]->pid;
        if ($ppid == $uid) {
               $db->rollback();
               echo json_encode(array('status' => 0,'msg'=>'推荐人的推荐人id不能为该用户的id！'));exit;
        }

        //判断用户是否已经是分销商  是则修改 不是则添加
        $sql5 = "select g.*,d.id as ldid,d.* from lkt_distribution_grade as g left join lkt_user_distribution AS d ON d.level = g.id where g.store_id='$store_id' and d.user_id = '$uid' ";
        $r5 = $db->select($sql5);

        if ($r5) {

            $sql7 = "select * from lkt_user_distribution where store_id='$store_id' and user_id='$pid'";
            $r7 = $db->select($sql7);
            $uplevel = intval($r7[0]->uplevel);
            $level = intval($r7[0]->uplevel)+1;
            $lt = $r7[0]->lt;
            $rt = $r7[0]->rt;

            $db->update("UPDATE lkt_user_distribution SET pid='$pid',uplevel='$level' WHERE store_id='$store_id' and user_id ='$uid'");

            $sql6 = "select user_id,lt,rt from lkt_user_distribution where store_id='$store_id' and lt<='$lt' and rt>='$rt' and uplevel=0";
            $r6 = $db->select($sql6);

            $res = $this->rebuild_tree($r6[0]->user_id,$r6[0]->lt,$db,0);
            if ($res == -1) {
                $db->rollback();
                $db->admin_record($store_id,$admin_name,'修改分销关系失败',2);
                echo json_encode(array('status' => 0,'msg'=>'修改失败！'));exit;
            } else {

                $db->commit();
                $db->admin_record($store_id,$admin_name,'修改分销关系成功',2);
                echo json_encode(array('status' => 1,'msg'=>'修改成功！'));exit;
            }
        } else {

            $r = $db->update("UPDATE lkt_user SET Referee='$pid' WHERE store_id='$store_id' and user_id ='$uid'");
            if ($r == -1) {
                $db->rollback();
                $db->admin_record($store_id,$admin_name,'修改分销关系失败',2);
                echo json_encode(array('status' => 0,'msg'=>'修改失败！'));exit;
            } else {
                $db->commit();
                $db->admin_record($store_id,$admin_name,'修改分销关系成功',2);
                echo json_encode(array('status' => 1,'msg'=>'修改成功！'));exit;
            }
        }

        return;

    }

    //$this->rebuild_tree('10000',0,$db,1); 
    //每一次改动某个人的上级pid之后，一定要执行这一个方法，来重造整个体系的lt,rt,level
    public function rebuild_tree($parent, $left, $db, $level)
    {
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $db->update("UPDATE lkt_user_distribution SET uplevel=$level WHERE store_id = '$store_id' and user_id = '" . $parent . "';");
        // the right value of this node is the left value + 1
        $right = $left + 1;
        // get all children of this node
        $sql = "select * from lkt_user_distribution where store_id = '$store_id' and pid='$parent'";
        $userlist = $db->select($sql);
        foreach ($userlist as $key => $value) {
            $right = $this->rebuild_tree($value->user_id, $right, $db, $level + 1);
        }

        // we've got the left value, and now that we've processed
        // the children of this node we also know the right value
        $db->update("UPDATE lkt_user_distribution SET lt = '" . $left . "',rt= '" . $right . "' WHERE store_id = '" .$store_id. "' and user_id = '" . $parent . "';");

        // return the right value of this node + 1
        return $right + 1;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }


}


?>