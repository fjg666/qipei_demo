<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class RecordInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("starttime",$request->getAttribute("starttime"));
        $this->setAttribute("user_id",$request->getAttribute("user_id"));
        $this->setAttribute("endtime",$request->getAttribute("endtime"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setTemplate("Record.tpl");
    }
}
?>
