<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class YueInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("name",$request->getAttribute("name"));
		$this->setAttribute("source",$request->getAttribute("source"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("starttime",$request->getAttribute("starttime"));
		$this->setAttribute("group_end_time",$request->getAttribute("group_end_time"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("button",$request->getAttribute("button"));
        $pageto = $request->getAttribute('pageto');
        if($pageto != ''){
			$r = rand();
			header("Content-type: application/msexcel;charset=utf-8");
			header("Content-Disposition: attachment;filename=userlist-$r.xls");
			$this->setTemplate("Excel_yue.tpl");
		} else {
			$this->setTemplate('Yue.tpl');
		}
    }

}

?>
