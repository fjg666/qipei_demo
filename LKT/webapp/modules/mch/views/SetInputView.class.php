<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class SetInputView extends SmartyView {

    public function execute() {
        $request = $this->getContext()->getRequest();
        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("logo",$request->getAttribute("logo"));
        $this->setAttribute("settlement",$request->getAttribute("settlement"));
        $this->setAttribute("min_charge",$request->getAttribute("min_charge"));
        $this->setAttribute("max_charge",$request->getAttribute("max_charge"));
        $this->setAttribute("service_charge",$request->getAttribute("service_charge"));
        $this->setAttribute("illustrate",$request->getAttribute("illustrate"));
        $this->setAttribute("agreement",$request->getAttribute("agreement"));
        $this->setTemplate("Set.tpl");
    }
}
?>