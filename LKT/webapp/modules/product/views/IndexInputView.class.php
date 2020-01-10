<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class IndexInputView extends SmartyView {
    public function execute() {
        $request = $this->getContext()->getRequest();
        $this->setAttribute("class_id",$request->getAttribute("class_id"));
        $this->setAttribute("ctypes",$request->getAttribute("ctypes"));
        $this->setAttribute("brand_class",$request->getAttribute("brand_class"));
        $this->setAttribute("brand_id",$request->getAttribute("brand_id"));

        $this->setAttribute("product_title",$request->getAttribute("product_title"));
        $this->setAttribute("mch_name",$request->getAttribute("mch_name"));
        $this->setAttribute("store_id",$request->getAttribute("store_id"));
        $this->setAttribute("active",$request->getAttribute("active"));
        $this->setAttribute("status",$request->getAttribute("status"));
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("min_inventory",$request->getAttribute("min_inventory"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("pagesize",$request->getAttribute("pagesize"));
        $this->setAttribute("select2",$request->getAttribute("select2"));
        $this->setAttribute("select3",$request->getAttribute("select3"));
        $this->setAttribute("select4",$request->getAttribute("select4"));
        $this->setAttribute("button",$request->getAttribute("button"));
        $this->setAttribute("mch_id",$request->getAttribute("mch_id"));
        $this->setAttribute("shop_name",$request->getAttribute("shop_name"));
        $this->setAttribute("show_adr",$request->getAttribute("show_adr"));
        $this->setAttribute("del_str",$request->getAttribute("del_str"));
        
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
