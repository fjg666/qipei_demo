<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ConfigInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("bg_img",$request->getAttribute("bg_img"));
		$this->setAttribute("content",$request->getAttribute("content"));
		$this->setAttribute("status",$request->getAttribute("status"));
		$this->setTemplate("Config.tpl");
    }
}
?>
