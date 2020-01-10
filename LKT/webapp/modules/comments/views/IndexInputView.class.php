<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("comments_str",$request->getAttribute("comments_str"));
        $this->setAttribute("otype",$request->getAttribute("otype"));
        $this->setAttribute("status",$request->getAttribute("status"));
        $this->setAttribute("ostatus",$request->getAttribute("ostatus"));
        $this->setAttribute("sNo",$request->getAttribute("sNo"));
        $this->setAttribute("startdate",$request->getAttribute("startdate"));
        $this->setAttribute("enddate",$request->getAttribute("enddate"));

		$this->setAttribute("order",$request->getAttribute("order"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("button",$request->getAttribute("button"));

		$this->setTemplate('Index.tpl');
    }
}
?>
