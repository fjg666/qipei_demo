<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class AddInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("range_zfc",$request->getAttribute("range_zfc"));
        $this->setAttribute("position_zfc",$request->getAttribute("position_zfc"));
        $this->setAttribute("product",$request->getAttribute("product"));
        $this->setAttribute("product_json",$request->getAttribute("product_json"));
		$this->setTemplate("Add.tpl");
    }
}
?>
