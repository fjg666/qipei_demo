<?php
class IndexInputView extends SmartyView {
// getContext() 检索当前应用程序上下文。
// getRequest() 检索请求。
// setAttribute() 设置一个属性。
// getAttribute() 方法返回指定属性名的属性值。
// setTemplate() 为该视图设置模板。
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('version',$request->getAttribute('version'));
        $this->setAttribute('uploadImg',$request->getAttribute('uploadImg'));		
		$this->setAttribute('admin_id',$request->getAttribute('admin_id'));
		$this->setAttribute('dfk',$request->getAttribute('dfk'));//--待付款
        $this->setAttribute('dp',$request->getAttribute('dp'));//--待发货
        $this->setAttribute('yth',$request->getAttribute('yth'));//--待收货
        $this->setAttribute('pj',$request->getAttribute('pj'));//评价订单 
        $this->setAttribute('th',$request->getAttribute('th'));//退货订单 
        $this->setAttribute('wc',$request->getAttribute('wc'));//完成订单
        $this->setAttribute('tm01',$request->getAttribute('tm01'));//这个月的营业额
        $this->setAttribute('tm',$request->getAttribute('tm'));//这个月的总订单
        $this->setAttribute('tm02',$request->getAttribute('tm02'));//总收入
        $this->setAttribute('re',$request->getAttribute('re'));//最近购买 24小时内
        $this->setAttribute('yingye',$request->getAttribute('yingye'));//营业额百分比
        $this->setAttribute('dingdan',$request->getAttribute('dingdan'));//订单百分比
        $this->setAttribute('day_yy',$request->getAttribute('day_yy'));//当日的营业额
        $this->setAttribute('yes_yy',$request->getAttribute('yes_yy'));//昨日的营业额
        $this->setAttribute('yingye_day',$request->getAttribute('yingye_day'));//当日的营业额百分比
        $this->setAttribute('daydd',$request->getAttribute('daydd'));//当日的总订单
        $this->setAttribute('yesdd',$request->getAttribute('yesdd'));//昨日的总订单
        $this->setAttribute('dingdan_day',$request->getAttribute('dingdan_day'));//当日的订单百分比

        $this->setAttribute('leiji_dd',$request->getAttribute('leiji_dd'));//累计订单数
        $this->setAttribute('user_num01',$request->getAttribute('user_num01'));//1注册会员人数
        $this->setAttribute('user_num02',$request->getAttribute('user_num02'));//2
        $this->setAttribute('user_num03',$request->getAttribute('user_num03'));//3
        $this->setAttribute('user_num04',$request->getAttribute('user_num04'));//4
        $this->setAttribute('user_num05',$request->getAttribute('user_num05'));//5
        $this->setAttribute('user_num06',$request->getAttribute('user_num06'));//6
        $this->setAttribute('user_num07',$request->getAttribute('user_num07'));//7
        $this->setAttribute('res_notice',$request->getAttribute('res_notice'));//活动信息
        $this->setAttribute('today',$request->getAttribute('today'));//1
        $this->setAttribute('day_show_1',$request->getAttribute('day_show_1'));//2
        $this->setAttribute('day_show_2',$request->getAttribute('day_show_2'));//3
        $this->setAttribute('day_show_3',$request->getAttribute('day_show_3'));//4
        $this->setAttribute('day_show_4',$request->getAttribute('day_show_4'));//5
        $this->setAttribute('day_show_5',$request->getAttribute('day_show_5'));//6
        $this->setAttribute('day_show_6',$request->getAttribute('day_show_6'));//7
        $this->setAttribute('user_num',$request->getAttribute('user_num'));//会员总人数
        //访客人数
        $this->setAttribute('fangke',$request->getAttribute('fangke'));//5
        $this->setAttribute('fangke01',$request->getAttribute('fangke01'));//
        $this->setAttribute('fangke02',$request->getAttribute('fangke02'));//
        $this->setAttribute('fangkebizhi',$request->getAttribute('fangkebizhi'));//fangke比值
        //本月
        $this->setAttribute('fangke03',$request->getAttribute('fangke03'));//
        //订单统计
        $this->setAttribute('order01',$request->getAttribute('order01'));//今天有效订单数
        $this->setAttribute('order02',$request->getAttribute('order02'));//2
        $this->setAttribute('order03',$request->getAttribute('order03'));//3
        $this->setAttribute('order04',$request->getAttribute('order04'));//4
        $this->setAttribute('order05',$request->getAttribute('order05'));//5
        $this->setAttribute('order06',$request->getAttribute('order06'));//6
        $this->setAttribute('order07',$request->getAttribute('order07'));//7
        $this->setTemplate("Index.tpl");

    }
}
?>