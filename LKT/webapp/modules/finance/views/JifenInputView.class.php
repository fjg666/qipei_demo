<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class JifenInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
        $this->setAttribute("user_name",$request->getAttribute("user_name"));
        $this->setAttribute("mobile",$request->getAttribute("mobile"));
        $this->setAttribute("startdate",$request->getAttribute("startdate"));
        $this->setAttribute("enddate",$request->getAttribute("enddate"));
		$this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("button",$request->getAttribute("button"));
        $pageto = $request->getAttribute('pageto');
		if($pageto != ''){
			$r = rand();
			header("Content-type: application/msexcel;charset=utf-8");
			header("Content-Disposition: attachment;filename=userlist-$r.xls");
			$this->setTemplate("Excel_jifen.tpl");
		} else {
			$this->setTemplate('Jifen.tpl');
		}
    }

}

?>
