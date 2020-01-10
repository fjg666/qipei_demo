<?php
class MemberRecordInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("name",$request->getAttribute("name"));
        $this->setAttribute("startdate",$request->getAttribute("startdate"));
        $this->setAttribute("enddate",$request->getAttribute("enddate"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setAttribute("store_type",$request->getAttribute("store_type"));
        $this->setAttribute("button",$request->getAttribute("button"));

        $pageto = $request->getAttribute('pageto');
        if($pageto != ''){
            $r = rand();
            header("Content-type: application/msexcel;charset=utf-8");
            header("Content-Disposition: attachment;filename=orderlist-$r.xls");
            $this->setTemplate("excel.tpl");
        } else {
            $this->setTemplate('MemberRecord.tpl');
        }
    }
}
?>
