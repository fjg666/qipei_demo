<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class RecordInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("list",$request->getAttribute("list"));
		$this->setAttribute("username",$request->getAttribute("username"));
		$this->setAttribute("goods_id",$request->getAttribute("goods_id"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("goodsid",$request->getAttribute("goodsid"));
        $this->setAttribute("type",$request->getAttribute("type"));
		$this->setTemplate("Record.tpl");
    }
}
?>