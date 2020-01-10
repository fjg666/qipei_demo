<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("id",$request->getAttribute("id"));
        $this->setAttribute("range_zfc",$request->getAttribute("range_zfc"));
        $this->setAttribute("position_zfc",$request->getAttribute("position_zfc"));
        $this->setAttribute("product",$request->getAttribute("product"));
        $this->setAttribute("product_json",$request->getAttribute("product_json"));

        $this->setAttribute("title",$request->getAttribute("title"));
		$this->setAttribute("name",$request->getAttribute("name"));
        $this->setAttribute("subtraction_range",$request->getAttribute("subtraction_range"));
        $this->setAttribute("subtraction_parameter",$request->getAttribute("subtraction_parameter"));
        $this->setAttribute("subtraction_type",$request->getAttribute("subtraction_type"));
        $this->setAttribute("subtraction",$request->getAttribute("subtraction"));
        $this->setAttribute("starttime",$request->getAttribute("starttime"));
        $this->setAttribute("endtime",$request->getAttribute("endtime"));
        $this->setAttribute("position_zfc1",$request->getAttribute("position_zfc1"));
        $this->setAttribute("image",$request->getAttribute("image"));
		$this->setTemplate("Modify.tpl");
    }
}
?>
