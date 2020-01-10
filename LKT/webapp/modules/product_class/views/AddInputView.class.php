<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class AddInputView extends SmartyView {

    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("cid",$request->getAttribute("cid"));
        $this->setAttribute("str_option",$request->getAttribute("str_option"));
        $this->setAttribute('level', $request->getAttribute('level'));
        $this->setAttribute("superCid",$request->getAttribute("superCid"));
        $this->setAttribute("level_list",$request->getAttribute("level_list"));
        $this->setTemplate("Add.tpl");
    }
}
?>