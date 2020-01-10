<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class ListInputView extends SmartyView {

    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("list",$request->getAttribute("list"));
		$this->setAttribute("review_status",$request->getAttribute("review_status"));
		$this->setAttribute("name",$request->getAttribute("name"));

        $pageto = $request->getAttribute('pageto');
        if($pageto != ''){
            $r = rand();
            header("Content-type: application/msexcel;charset=utf-8");
            header("Content-Disposition: attachment;filename=userlist-$r.xls");
            $this->setTemplate("List_excel.tpl");
        } else {
            $this->setTemplate("List.tpl");
        }
    }

}

?>