<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class AddInputView extends SmartyView {
    public function execute() {
        $request = $this->getContext()->getRequest();
        $this->setAttribute("product_number",$request->getAttribute("product_number"));
        $this->setAttribute("Plugin_arr",$request->getAttribute("Plugin_arr"));
        $this->setAttribute("ctypes",$request->getAttribute("ctypes"));
        $this->setAttribute("brand_class",$request->getAttribute("brand_class"));
        $this->setAttribute("freight",$request->getAttribute("freight"));
        $this->setAttribute("sp_type",$request->getAttribute("sp_type"));
        $this->setAttribute("show_adr",$request->getAttribute("show_adr"));
        $this->setAttribute("unit",$request->getAttribute("unit"));
        $this->setTemplate("Add.tpl");
    }
}
?>