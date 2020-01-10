<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class indexxInputView extends SmartyView {
    public function execute() {
        $request = $this->getContext()->getRequest();
        $this->setAttribute("tpl",$request->getAttribute("tpl"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("sNo",$request->getAttribute("sNo"));
        $this->setAttribute("r_mobile",$request->getAttribute("r_mobile"));
        $this->setAttribute("recipient",$request->getAttribute("recipient"));
        $this->setAttribute("r_time",$request->getAttribute("r_time"));
        $this->setAttribute("startdate",$request->getAttribute("startdate"));
        $this->setAttribute("enddate",$request->getAttribute("enddate"));
        $this->setAttribute("print_type",$request->getAttribute("print_type"));
        $this->setAttribute("o_status",$request->getAttribute("o_status"));
        $this->setAttribute("expresssn",$request->getAttribute("expresssn"));
        $this->setAttribute("open",$request->getAttribute("open"));

        $pageto = $request->getAttribute('pageto');
        if($pageto != ''){
            $r = time();
            header("Content-type: application/msexcel;charset=utf-8");
            header("Content-Disposition: attachment;filename=orders-$r.xls");
            $this->setTemplate("excel.tpl");
        } else {
            $this->setTemplate('indexx.tpl');
        }
    }
}
?>
