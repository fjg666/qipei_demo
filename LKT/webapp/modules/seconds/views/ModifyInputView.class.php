<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();

        $this->setAttribute("activity_id",$request->getAttribute("activity_id"));
        $this->setAttribute("time_id",$request->getAttribute("time_id"));
			$this->setTemplate('Modify.tpl');
    }
}
?>
