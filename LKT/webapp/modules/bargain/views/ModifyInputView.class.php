<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("class",$request->getAttribute("class"));
		$this->setAttribute("msg",$request->getAttribute("msg"));
		$this->setAttribute("list",$request->getAttribute("list"));
		$this->setAttribute("proattr",$request->getAttribute("proattr"));
		$this->setAttribute("goods_id",$request->getAttribute("goods_id"));
		$this->setAttribute("sp_type",$request->getAttribute("sp_type"));
		$this->setAttribute("status_data",$request->getAttribute("status_data"));
		$this->setTemplate("Modify.tpl");
    }
}
?>
