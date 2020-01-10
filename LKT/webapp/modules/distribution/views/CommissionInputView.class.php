<?php
class CommissionInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("sNo",$request->getAttribute("sNo"));
        $this->setAttribute("phone",$request->getAttribute("phone"));
        $this->setAttribute("name",$request->getAttribute("name"));
		$this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setAttribute("z_price",$request->getAttribute("z_price"));
        $this->setAttribute("startdate",$request->getAttribute("startdate"));
        $this->setAttribute("enddate",$request->getAttribute("enddate"));
		$pageto = $request->getAttribute('pageto');
		if($pageto != ''){
			$r = rand();
			header("Content-type: application/msexcel;charset=utf-8");
			header("Content-Disposition: attachment;filename=userlist-$r.xls");
			$this->setTemplate("Commission_excel.tpl");
		} else {
			$this->setTemplate('Commission.tpl');
		}
    }
}
?>
