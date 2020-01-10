<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ConfigInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("is_subtraction",$request->getAttribute("is_subtraction"));
        $this->setAttribute("range_zfc",$request->getAttribute("range_zfc"));
        $this->setAttribute("pro_id",$request->getAttribute("pro_id"));
        $this->setAttribute("position_zfc",$request->getAttribute("position_zfc"));
        $this->setAttribute("is_shipping",$request->getAttribute("is_shipping"));
        $this->setAttribute("z_money",$request->getAttribute("z_money"));
        $this->setAttribute("address_id",$request->getAttribute("address_id"));
		$this->setTemplate("Config.tpl");
    }
}
?>
