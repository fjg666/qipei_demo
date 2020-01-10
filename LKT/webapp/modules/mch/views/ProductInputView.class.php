<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ProductInputView extends SmartyView {
    public function execute() {
        $request = $this->getContext()->getRequest();
        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("mch_status",$request->getAttribute("mch_status"));
        $this->setAttribute("product_title",$request->getAttribute("product_title"));
        $this->setAttribute("mch_id",$request->getAttribute("mch_id"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setTemplate("Product.tpl");
    }
}
?>
