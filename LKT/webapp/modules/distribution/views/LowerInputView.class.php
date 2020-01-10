<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class LowerInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("pages_show",$request->getAttribute("pages_show"));
		$this->setAttribute("list",$request->getAttribute("list"));
		$this->setAttribute("id",$request->getAttribute("id"));
		$this->setAttribute("now_data",date("Y/m/d h:i"));
		$pageto = $request->getAttribute('pageto');
		if($pageto != ''){
			$r = time();
			header("Content-type: application/msexcel;charset=utf-8");
			header("Content-Disposition: attachment;filename=users-$r.xls");
			$this->setTemplate("Excel.tpl");
		} else {
			$this->setTemplate('Lower.tpl');
		}
    }
}
?>
