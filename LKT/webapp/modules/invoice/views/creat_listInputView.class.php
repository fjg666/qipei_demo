<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class creat_listInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("goods",$request->getAttribute("goods"));
		$this->setAttribute("ids",$request->getAttribute("ids"));
       
        $this->setTemplate("creat_list.tpl");

    }

}

?>