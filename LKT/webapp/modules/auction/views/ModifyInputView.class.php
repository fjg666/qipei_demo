<?php

class ModifyInputView extends SmartyView
{
    public function execute()
    {
        $request = $this->getContext()->getRequest();
        //已选择商品数据
        $this->setAttribute("product_title", $request->getAttribute("product_title"));
        $this->setAttribute("attr", $request->getAttribute("attr"));
        $this->setAttribute("mch_name", $request->getAttribute("mch_name"));
        $this->setAttribute("num", $request->getAttribute("num"));
        $this->setAttribute("min_inventory", $request->getAttribute("min_inventory"));
        $this->setAttribute("price", $request->getAttribute("price"));
        $this->setAttribute("imgurl", $request->getAttribute("imgurl"));

        //竞拍参数
        $this->setAttribute("id", $request->getAttribute("id"));
        $this->setAttribute("title", $request->getAttribute("title"));
        $this->setAttribute("start_price", $request->getAttribute("start_price"));
        $this->setAttribute("add_price", $request->getAttribute("add_price"));
        $this->setAttribute("promise", $request->getAttribute("promise"));
        $this->setAttribute("sp_type", $request->getAttribute("sp_type"));
        $this->setAttribute("is_show", $request->getAttribute("is_show"));
        $this->setAttribute("starttime", $request->getAttribute("starttime"));
        $this->setAttribute("endtime", $request->getAttribute("endtime"));
        $this->setAttribute("status", $request->getAttribute("status"));


        $this->setTemplate("Modify.tpl");
    }
}
