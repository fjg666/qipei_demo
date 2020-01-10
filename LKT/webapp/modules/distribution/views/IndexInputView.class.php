<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("now_data",date("Y/m/d h:i"));
		$this->setAttribute("pages_show",$request->getAttribute("pages_show"));
		$this->setAttribute("level",$request->getAttribute("level"));
		$this->setAttribute("distributors",$request->getAttribute("distributors"));
		$this->setAttribute("user_name",$request->getAttribute("user_name"));
		$this->setAttribute("r_name",$request->getAttribute("r_name"));
		$this->setAttribute("p_name",$request->getAttribute("p_name"));
		$this->setAttribute("startdate",$request->getAttribute("startdate"));
		$this->setAttribute("enddate",$request->getAttribute("enddate"));
        $this->setAttribute("list",$request->getAttribute("list"));

		$pageto = $request->getAttribute('pageto');
		if($pageto != ''){
			$r = rand();
			header("Content-type: application/msexcel;charset=utf-8");
			header("Content-Disposition: attachment;filename=users-$r.xls");
			$this->setTemplate("Excel.tpl");
		} else {
			$this->setTemplate('Index.tpl');
		}
    }
}
?>
