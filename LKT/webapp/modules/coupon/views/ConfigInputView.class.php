<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ConfigInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("is_status",$request->getAttribute("is_status"));
        $this->setAttribute("coupon_del",$request->getAttribute("coupon_del"));
        $this->setAttribute("coupon_day",$request->getAttribute("coupon_day"));
        $this->setAttribute("activity_del",$request->getAttribute("activity_del"));
        $this->setAttribute("activity_day",$request->getAttribute("activity_day"));
        $this->setAttribute("payment_type",$request->getAttribute("payment_type"));
		$this->setAttribute("limit_type",$request->getAttribute("limit_type"));
        $this->setAttribute("coupon_type",$request->getAttribute("coupon_type"));
		$this->setTemplate("Config.tpl");
    }
}
?>
