<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class ModifyInputView extends SmartyView {

    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute("coupon_type",$request->getAttribute("coupon_type"));
        $this->setAttribute("limit_type",$request->getAttribute("limit_type"));
        $this->setAttribute("activity_type",$request->getAttribute("activity_type"));
        $this->setAttribute("name",$request->getAttribute("name"));
        $this->setAttribute("grade_id",$request->getAttribute("grade_id"));
        $this->setAttribute("money",$request->getAttribute("money"));
        $this->setAttribute("discount",$request->getAttribute("discount"));
        $this->setAttribute("z_money",$request->getAttribute("z_money"));
        $this->setAttribute("circulation",$request->getAttribute("circulation"));
        $this->setAttribute("type",$request->getAttribute("type"));
        $this->setAttribute("skip_type",$request->getAttribute("skip_type"));
        $this->setAttribute("url",$request->getAttribute("url"));
        $this->setAttribute("day",$request->getAttribute("day"));
        $this->setAttribute("Instructions",$request->getAttribute("Instructions"));
        $this->setAttribute("start_time",$request->getAttribute("start_time"));
        $this->setAttribute("end_time",$request->getAttribute("end_time"));
        $this->setAttribute("receive",$request->getAttribute("receive"));
        $this->setAttribute("product_class_name",$request->getAttribute("product_class_name"));
        $this->setAttribute("product_name",$request->getAttribute("product_name"));
        $this->setAttribute("res",$request->getAttribute("res"));
        $this->setAttribute("type_type",$request->getAttribute("type_type"));
		$this->setTemplate("Modify.tpl");
    }
}
?>