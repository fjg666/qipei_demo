<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();

        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("coupon_type",$request->getAttribute("coupon_type"));
        $this->setAttribute("activity_type",$request->getAttribute("activity_type"));
        $this->setAttribute("name",$request->getAttribute("name"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("status",$request->getAttribute("status"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setTemplate("Index.tpl");

    }
}
?>
