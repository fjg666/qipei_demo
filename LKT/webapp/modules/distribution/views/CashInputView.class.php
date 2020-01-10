<?php
class CashInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("mobile",$request->getAttribute("mobile"));
        $this->setAttribute("name",$request->getAttribute("name"));
        $this->setAttribute("source",$request->getAttribute("source"));
		$this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("startdate",$request->getAttribute("startdate"));
        $this->setAttribute("enddate",$request->getAttribute("enddate"));
		$pageto = $request->getAttribute('pageto');
		if($pageto != ''){
			$r = rand();
			header("Content-type: application/msexcel;charset=utf-8");
			header("Content-Disposition: attachment;filename=cash-$r.xls");
			$this->setTemplate("Cash_excel.tpl");
		} else {
			$this->setTemplate('Cash.tpl');
		}
    }
}
?>
