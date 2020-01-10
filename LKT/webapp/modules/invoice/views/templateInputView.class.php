<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class templateInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("tpl",$request->getAttribute("tpl"));
		$this->setAttribute("name",$request->getAttribute("name"));
		$this->setAttribute("type",$request->getAttribute("type"));
		$this->setAttribute("all_tpl",$request->getAttribute("all_tpl"));
       
        $this->setTemplate("template.tpl");

    }

}

?>