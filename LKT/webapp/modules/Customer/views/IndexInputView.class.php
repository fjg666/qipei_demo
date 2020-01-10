<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("name",$request->getAttribute("name"));
        $this->setAttribute("startdate",$request->getAttribute("startdate"));
        $this->setAttribute("enddate",$request->getAttribute("enddate"));
        $this->setAttribute("list",$request->getAttribute("list"));

        $this->setAttribute("pageto",$request->getAttribute("pageto"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setAttribute("subaccount",$request->getAttribute("subaccount"));

        $pageto = $request->getAttribute('pageto');
        if($pageto != ''){
            $r = rand();
            header("Content-type: application/msexcel;charset=utf-8");
            header("Content-Disposition: attachment;filename=userlist-$r.xls");
            $this->setTemplate("Excel.tpl");
        } else {
            $this->setTemplate("Index.tpl");
        }
    }
}
?>
