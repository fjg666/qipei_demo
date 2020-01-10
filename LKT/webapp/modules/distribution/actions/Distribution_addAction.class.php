

<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class Distribution_addAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_distribution_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        $re01 = $r_1?unserialize($r_1[0]->sets):array();

        $sql = "select * from lkt_distribution_grade where store_id = '$store_id' order by sort asc";
        $rrr = $db->select($sql);
        $levels = array();
        if ($rrr) {
            foreach ($rrr as $k => $v) {
                $levels[$v->id] = unserialize($v->sets)['s_dengjiname'];
            }
        }
        
        $cengji = !empty($re01)?intval($re01['c_cengji']):1;
        $request->setAttribute("re",$re01);
        $request->setAttribute("cengji",$cengji);
        $request->setAttribute("levels", $levels);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $data['s_dengjiname'] = empty($request->getParameter('s_dengjiname'))?'默认等级':$request->getParameter('s_dengjiname');// 等级名称     
        $data['zhekou'] = empty($request->getParameter('zhekou'))?0:$request->getParameter('zhekou');//分销折扣
        $data['price_type'] = empty($request->getParameter('price_type'))?0:$request->getParameter('price_type');//分销比例发放模式 0.百分比 1.固定金额
        $data['levelobj'] = empty($request->getParameter('levelobj'))?'':$request->getParameter('levelobj');//晋级条件
        $data['levelmoney'] = empty($request->getParameter('levelmoney'))?0:$request->getParameter('levelmoney');//佣金收益
        $data['different'] = empty($request->getParameter('different'))?0:$request->getParameter('different')?$request->getParameter('different'):0;//级差奖
        $data['sibling'] = empty($request->getParameter('sibling'))?0:$request->getParameter('sibling')?$request->getParameter('sibling'):0;//平级奖
        $member_proportion = empty(trim($request->getParameter('member_proportion')))?0:trim($request->getParameter('member_proportion'));//会员专区比例
        $integral = empty(trim($request->getParameter('integral')))?0:trim($request->getParameter('integral'));// 升级奖励积分
        $discount = empty(trim($request->getParameter('discount')))?0:trim($request->getParameter('discount'));// 分销折扣
        $datetime = date('Y-m-d H:i:s',time());

        $log = new LaiKeLogUtils('common/distribution.log');// 日志

        if (empty($data['s_dengjiname'])) {
            $log -> customerLog(__LINE__.":新增分销等级失败：等级名称不能为空！\r\n");
            echo json_encode(array('status' => 0,'msg'=>'等级名称不能为空！'));exit;
        }
        $dengji = $db -> select("select sets from lkt_distribution_grade where store_id = '$store_id'");
        foreach ($dengji as $k => $v) {
            $v = unserialize($v -> sets)["s_dengjiname"];
            $dengji[$k] = $v;
        }
        if(in_array($data['s_dengjiname'], $dengji)){
            $log -> customerLog(__LINE__.":新增分销等级失败：等级".$data['s_dengjiname']."名称重复\r\n");
            echo json_encode(array('status' => 0,'msg'=>'等级名称重复!'));exit;
        }
        // 查询排序号
        $sql = "select sort from lkt_distribution_grade where store_id = '$store_id' order by sort desc limit 0,1";
        $r = $db->select($sql);
        if ($r) {
            $sort = intval($r[0]->sort)+1;
        }else{
            $sort = 1;
        }
        $info=serialize($data);
        
        $sql01 = "insert into lkt_distribution_grade(store_id,sets,datetime,sort,integral,discount,member_proportion) values('$store_id','$info','$datetime','$sort','$integral','$discount','$member_proportion')";
        $rr = $db->insert($sql01);
        
        if($rr>0){
            $db->admin_record($store_id,$admin_name,'添加分销等级'.$data['s_dengjiname'],1);
            $log -> customerLog(__LINE__.":新增分销等级".$data['s_dengjiname']."成功！\r\n");
            echo json_encode(array('status' =>1,'msg'=>'添加成功！'));exit;
        }else{
            $db->admin_record($store_id,$admin_name,'添加分销等级'.$data['s_dengjiname'].'失败',1);
            $log -> customerLog(__LINE__.":新增分销等级失败：添加".$data['s_dengjiname']."失败！\r\n");
            echo json_encode(array('status' => 0,'msg'=>'添加失败！'));exit;
        }

    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>