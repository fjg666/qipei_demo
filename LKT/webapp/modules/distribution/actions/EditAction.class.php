<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class EditAction extends Action{
        
    public function getDefaultView(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $m = trim($request->getParameter('m'));
        if ($m) {
            $res = array();
            $pid = trim($request->getParameter('pid'));// 用户ID
            if (!empty($pid)) {
                $p = "select user_name from lkt_user where store_id = '$store_id' and user_id = '$pid'";
                $pr = $db->select($p);
                if ($pr) {
                    $res['p_name'] = $pr[0]->user_name;// 返回用户名称
                }
            }
            echo json_encode($res);exit;
        }

        $id = $request->getParameter("id");// 用户ID
        $sql = "select a.id as uid,a.user_name,a.headimgurl,a.Register_data,a.mobile,b.* from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.user_id = '$id'";
        $user = $db->select($sql);

        //推荐人信息
        if ($user[0]->pid) {
            $p = "select user_name from lkt_user where store_id = '$store_id' and user_id = '".$user[0]->pid."'";
            $pr = $db->select($p);
            $user[0]->p_name = !empty($pr)?$pr[0]->user_name:'未设置';
        }else{
            $user[0]->pid = '';
            $user[0]->p_name = '总店';
        }

        //分销等级
        $l = "select sets from lkt_distribution_grade where store_id = '$store_id' and id='".$user[0]->level."'";
        $lr = $db->select($l);
        $sets = unserialize($lr[0]->sets);
        $user[0]->levelname = $sets['s_dengjiname']?$sets['s_dengjiname']:'默认等级';
        //预计佣金
        $sql44 = "select sum(a.money) as yjyj from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.status=0 and a.user_id='$id' and b.status in (1,2,3,5,7)";
        $yjyj = $db->select($sql44);
        $user[0]->yjyj = $yjyj[0]->yjyj?number_format($yjyj[0]->yjyj,2):'0.00';
        //累计佣金
        $sql33 = "select sum(a.money) as ljyj from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.user_id='$id' and a.status=1 and b.status in (1,2,3,5,7)";
        $ljyj = $db->select($sql33);
        $user[0]->ljyj = $ljyj[0]->ljyj?number_format($ljyj[0]->ljyj,2):'0.00';

        // 拼接分销等级下拉框
        $sql = "select id,sets from lkt_distribution_grade where store_id = '$store_id' order by sort asc";
        $level = $db->select($sql);
        $res = '';
        foreach ($level as $k => $v) {
            $sets = unserialize($v->sets);
            $levelname = $sets['s_dengjiname'];

            if ($levelname == $user[0]->levelname) {
                $res .= '<option selected="selected" value="' . $v->id . '">' . $levelname . '</option>';
            }else{
                $res .= '<option value="' . $v->id . '">' . $levelname . '</option>';
            }
        }

        $request->setAttribute('user', $user);
        $request->setAttribute('level', $res);

        return View :: INPUT;
    }

    public function execute(){
        $db=DBAction::getInstance();
        $request=$this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id=$this->getContext()->getStorage()->read('store_id');
        //1.接受用户传来的修改数据
        $id=trim($request->getParameter("id"));// 分销ID
        $user_name=trim($request->getParameter("user_name"));// 昵称
        $pid=trim($request->getParameter("pid"));// 推荐人ID
        $mobile=trim($request->getParameter("mobile"));// 手机号码
        $rlevel=trim($request->getParameter("level"));// 分校等级

        $log = new LaiKeLogUtils('common/distribution.log');

        $sql="select a.source,a.zhanghao,a.user_id,b.uplevel from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.id = '$id'";
        $r=$db->select($sql);
        $user_zhanghao = $r[0]->zhanghao;// 会员账号
        $uplevel = $r[0]->uplevel;// 分销层级
        $uid = $r[0]->user_id;// 用户ID
        
        //手机号唯一判定
        $sql_m = "select user_name,mobile,zhanghao from lkt_user where store_id = '$store_id' and id != '$id'";
        $res_m = $db->select($sql_m);
        if($res_m){
            foreach($res_m as $k => $v){
                $all_zhanghao = $v->zhanghao;
                $all_mobile = $v->mobile;
                if($user_zhanghao == $mobile){
                    if($mobile == $all_mobile || $mobile == $all_zhanghao){
                        $log -> customerLog(__LINE__.":修改分销商信息失败：手机号已被注册！\r\n");
                        echo json_encode(array('status'=>'手机号已被注册！'));exit;
                    }
                }else{
                    if($mobile == $all_mobile || $mobile == $all_zhanghao){
                        $log -> customerLog(__LINE__.":修改分销商信息失败：手机号已被注册！\r\n");
                        echo json_encode(array('status'=>'手机号已被注册！'));exit;
                    }
                }
            }
        } 

        // 开始事物
        $db->begin();
        if ($uid == $pid) {
           $db->rollback();
           $log -> customerLog(__LINE__.":修改分销商信息失败：用户ID和推荐人ID不能为相同！\r\n");
           echo json_encode(array('status' => '用户ID和推荐人ID不能为相同！'));exit;
        }

        // 如果不是主号
        if (intval($uplevel) != 0) {
            
            // 查询推荐人是否存在
            $sql2 = "select g.*,d.id as ldid,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where g.store_id='$store_id' and d.user_id = '$pid' ";
            $r2 = $db->select($sql2);
            if (!$r2) {
               $db->rollback();
               $log -> customerLog(__LINE__.":修改分销商信息失败：推荐人ID不存在！\r\n");
               echo json_encode(array('status' => '推荐人ID不存在！'));exit;
            }
            $ppid = $r2[0]->pid;
            if ($ppid == $uid) {
               $db->rollback();
               $log -> customerLog(__LINE__.":修改分销商信息失败：推荐人的推荐人ID不能为该用户的ID！\r\n");
               echo json_encode(array('status' => '推荐人的推荐人ID不能为该用户的ID！'));exit;
            }
            $i = 0;
            $xxx = $ppid;
            while ($i <= 1000) {
                
                $sql = "select pid from lkt_user_distribution where store_id='$store_id' and user_id='$xxx'";
                $rrr = $db->select($sql);
                if ($rrr && !empty($rrr[0]->pid)) {
                    $xxx = $rrr[0]->pid;
                    if ($xxx == $uid) {
                       $db->rollback();
                       $log -> customerLog(__LINE__.":修改分销商信息失败：推荐人的上级不能为该用户的下级！\r\n");
                       echo json_encode(array('status' => '推荐人的上级不能为该用户的下级！'));exit;
                    }else{
                        $i++;
                    }
                }else{
                    break;
                }
            }
        }else{// 如果是主号
            if (!empty($pid)) {
                $db->rollback();
                $log -> customerLog(__LINE__.":修改分销商信息失败：主号无法更改推荐人！\r\n");
                echo json_encode(array('status' => '主号无法更改推荐人！'));exit;
            }
        }

        $sql5 = "select g.*,d.id as ldid,d.* from lkt_distribution_grade as g left join lkt_user_distribution AS d ON d.level = g.id where g.store_id='$store_id' and d.user_id = '$uid' ";
        $r5 = $db->select($sql5);
        if ($r5 && intval($uplevel) > 0) {// 如果用户存在，并且不是主号

            $sql7 = "select * from lkt_user_distribution where store_id='$store_id' and user_id='$pid'";
            $r7 = $db->select($sql7);
            $uplevel = intval($r7[0]->uplevel);
            $level = intval($r7[0]->uplevel)+1;
            $lt = $r7[0]->lt;
            $rt = $r7[0]->rt;

            $db->update("update lkt_user_distribution SET pid='$pid',uplevel='$level',level='$rlevel' WHERE store_id='$store_id' and user_id ='$uid'");
            $db->update("update lkt_user SET user_name='$user_name',mobile='$mobile' WHERE store_id='$store_id' and user_id ='$uid'");

            $sql6 = "select user_id,lt,rt from lkt_user_distribution where store_id='$store_id' and lt<='$lt' and rt>='$rt' and uplevel=0";
            $r6 = $db->select($sql6);
            $res = $this->rebuild_tree($r6[0]->user_id,$r6[0]->lt,$db,0);// 重新排列推荐关系树
            if ($res == -1) {
                $db->rollback();
                $db->admin_record($store_id,$admin_name,'修改分销商信息失败',2);
                $log -> customerLog(__LINE__.":修改分销商信息失败：$sql6\r\n");
                echo json_encode(array('status' => '修改失败！'));exit;
            } else {

                $db->commit();
                $db->admin_record($store_id,$admin_name,'修改分销商信息成功',2);
                $log -> customerLog(__LINE__.":修改分销商信息成功！\r\n");
                echo json_encode(array('code' => 200, 'status' => '修改成功！'));exit;
            }
        }else{// 如果是主号
            if ($r5) {
                $sql1 = "update lkt_user_distribution SET level='$rlevel' WHERE store_id='$store_id' and user_id ='$uid'";
                $r1 = $db->update($sql1);// 修改分销等级
                $sql2 = "update lkt_user SET user_name='$user_name',mobile='$mobile' WHERE store_id='$store_id' and user_id ='$uid'";
                $r2 = $db->update($sql2);// 修改用户信息
                if ($r1 < 0 || $r2 < 0) {
                    $db->rollback();
                    $db->admin_record($store_id,$admin_name,'修改分销商信息失败',2);
                    $log -> customerLog(__LINE__.":修改分销商信息失败：$sql1 || $sql2\r\n");
                    echo json_encode(array('status' => '修改失败！'));exit;
                }else{
                    $db->commit();
                    $db->admin_record($store_id,$admin_name,'修改分销商信息成功',2);
                    $log -> customerLog(__LINE__.":修改分销商信息成功！\r\n");
                    echo json_encode(array('code' => 200, 'status' => '修改成功！'));exit;
                }
            }else{
                $db->rollback();
                $db->admin_record($store_id,$admin_name,'修改分销商信息失败',2);
                $log -> customerLog(__LINE__.":修改分销商信息失败：用户不存在！\r\n");
                echo json_encode(array('status' => '修改失败！'));exit;
            }
        }

        return ;

    }
    public function getRequestMethods(){

            return Request :: POST;
    }

    public function rebuild_tree($parent, $left, $db, $level)
    {
        $request=$this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $db->update("UPDATE lkt_user_distribution SET uplevel=$level WHERE store_id = '$store_id' and user_id = '" . $parent . "';");
        $right = $left + 1;

        $sql = "select * from lkt_user_distribution where store_id = '$store_id' and pid='$parent'";
        $userlist = $db->select($sql);
        foreach ($userlist as $key => $value) {
            $right = $this->rebuild_tree($value->user_id, $right, $db, $level + 1);
        }

        $db->update("UPDATE lkt_user_distribution SET lt = '" . $left . "',rt= '" . $right . "' WHERE store_id = '" .$store_id. "' and user_id = '" . $parent . "';");
        return $right + 1;
    }

} 