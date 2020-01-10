<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ConfigInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("buy_time",$request->getAttribute("buy_time"));
		$this->setAttribute("imgUrl",$request->getAttribute("imgUrl"));
		$this->setAttribute("show_time",$request->getAttribute("show_time"));
		$this->setAttribute("rule",$request->getAttribute("rule"));
		$this->setAttribute("status",$request->getAttribute("status"));
		$this->setTemplate("Config.tpl");
    }
}
?>
