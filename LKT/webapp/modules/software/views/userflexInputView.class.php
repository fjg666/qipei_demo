<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class userflexInputView extends SmartyView {

    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("home_page_data",$request->getAttribute("home_page_data"));
		$this->setAttribute("uploadImg",$request->getAttribute("uploadImg"));
		$this->setAttribute("module_list",$request->getAttribute("module_list"));
        $this->setTemplate("userflex.tpl");
    }

}

?>