<?php

class RecordInputView extends SmartyView
{
    public function execute()
    {
        $request = $this->getContext()->getRequest();
        $this->setAttribute("id", $request->getAttribute("id"));
        $this->setAttribute("user_name", $request->getAttribute("user_name"));
        $this->setAttribute("list", $request->getAttribute("list"));
        $this->setAttribute("pages_show", $request->getAttribute("pages_show"));
        $this->setAttribute("status", $request->getAttribute("status"));
        $this->setAttribute("is_buy", $request->getAttribute("is_buy"));
        $this->setAttribute("pepole", $request->getAttribute("pepole"));
        $this->setAttribute("low_pepole", $request->getAttribute("low_pepole"));
        $this->setAttribute("first_id", $request->getAttribute("first_id"));
        $this->setAttribute("count", $request->getAttribute("count"));

        $this->setTemplate("Record.tpl");
    }
}
