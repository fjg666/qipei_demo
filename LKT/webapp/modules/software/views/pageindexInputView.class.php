<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class pageindexInputView extends SmartyView {

	

    public function execute() {

		$request = $this->getContext()->getRequest();
		// var_dump($request->getAttribute("home_page_data"));
		$this->setAttribute("lkt_index_page",$request->getAttribute("lkt_index_page"));

		$this->setAttribute("uploadImg",$request->getAttribute("uploadImg"));

		$this->setAttribute("module_list",$request->getAttribute("module_list"));

        $this->setTemplate("pageindex.tpl");

    }

}

?>