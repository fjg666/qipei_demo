<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class IndexInputView extends SmartyView {

    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("list",$request->getAttribute("list"));
		$this->setAttribute("is_open",$request->getAttribute("is_open"));
		$this->setAttribute("name",$request->getAttribute("name"));
        $this->setTemplate("Index.tpl");
    }

}

?>