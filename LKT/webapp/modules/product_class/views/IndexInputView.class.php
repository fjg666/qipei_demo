<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("cid",$request->getAttribute("cid"));
        $this->setAttribute("pname",$request->getAttribute("pname"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("level",$request->getAttribute("level"));
        $this->setAttribute("level_xs",$request->getAttribute("level_xs"));
        $this->setAttribute("uploadImg",$request->getAttribute("uploadImg"));
		$this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("del_str",$request->getAttribute("del_str"));
        $this->setAttribute("list1",$request->getAttribute("list1"));
        $this->setAttribute("level_num",$request->getAttribute("level_num"));

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
