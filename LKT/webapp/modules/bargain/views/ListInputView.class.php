<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ListInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("record",$request->getAttribute("record"));
		$this->setAttribute("list",$request->getAttribute("list"));
		$this->setTemplate("List.tpl");
    }
}
?>
