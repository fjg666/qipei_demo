<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("local",$request->getAttribute("local"));
        $this->setAttribute("oss",$request->getAttribute("oss"));
		$this->setAttribute("qiniu",$request->getAttribute("qiniu"));
		$this->setAttribute("tenxun",$request->getAttribute("tenxun"));
		$this->setAttribute("upserver",$request->getAttribute("upserver"));
		$this->setTemplate("Index.tpl");
    }
}
?>
