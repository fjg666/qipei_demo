<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class Distribution_configInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("re",$request->getAttribute("re"));
		$this->setAttribute("status",$request->getAttribute("status"));
		$this->setTemplate("Distribution_config.tpl");
    }
}
?>
