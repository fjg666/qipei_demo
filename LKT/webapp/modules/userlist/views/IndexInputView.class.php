<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("name",$request->getAttribute("name"));
        $this->setAttribute("tel",$request->getAttribute("tel"));
        $this->setAttribute("source",$request->getAttribute("source"));//来源下拉框
        $this->setAttribute("grade",$request->getAttribute("grade"));//会员等级下拉框
        $this->setAttribute("method_str",$request->getAttribute("method_str"));//充值时长下拉框
		$this->setAttribute("list",$request->getAttribute("list"));
		$this->setAttribute("user_name",$request->getAttribute("user_name"));
		$this->setAttribute("user_id",$request->getAttribute("user_id"));
		$this->setAttribute("is_out",$request->getAttribute("is_out"));
		$this->setAttribute("is_app",$request->getAttribute("is_app"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setAttribute("button",$request->getAttribute("button"));
		$this->setAttribute("now_data",date("Y/m/d h:i"));
		$pageto = $request->getAttribute('pageto');
		if($pageto != ''){
			$r = time();
			header("Content-type: application/msexcel;charset=utf-8");
			header("Content-Disposition: attachment;filename=user-$r.xls");
			$this->setTemplate("excel.tpl");
		} else {
			$this->setTemplate('Index.tpl');
		}
    }
}
?>
