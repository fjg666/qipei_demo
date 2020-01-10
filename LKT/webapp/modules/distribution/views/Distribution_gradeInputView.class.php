<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class Distribution_gradeInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("re",$request->getAttribute("re"));
		$this->setAttribute("re02",$request->getAttribute("re02"));
		$this->setAttribute("pages_show",$request->getAttribute("pages_show"));
		$this->setTemplate("Distribution_grade.tpl");
    }
}
?>
