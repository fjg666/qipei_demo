<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("num",$request->getAttribute("num"));
		$this->setAttribute("list",$request->getAttribute("list"));
		$this->setAttribute("bstatus",$request->getAttribute("bstatus"));
		$this->setAttribute("proname",$request->getAttribute("proname"));
		$this->setAttribute("pages_show",$request->getAttribute("pages_show"));
		$this->setTemplate("Index.tpl");
    }
}
?>