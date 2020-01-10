<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute('pid',$request->getAttribute('pid'));     
        $this->setAttribute("list",$request->getAttribute("list"));		
        $this->setAttribute("class_name",$request->getAttribute("class_name"));
        $this->setAttribute("mrnotify_url",$request->getAttribute("mrnotify_url"));
		$this->setTemplate("Modify.tpl");
    }
}
?>