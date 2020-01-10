<?php
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("uploadImg",$request->getAttribute("uploadImg"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("button",$request->getAttribute("button"));

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
