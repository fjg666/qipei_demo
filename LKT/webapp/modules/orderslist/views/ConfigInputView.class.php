<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class ConfigInputView extends SmartyView
{
    public function execute()
    {
        $request = $this->getContext()->getRequest();
        $this->setAttribute("auto_the_goods", $request->getAttribute("auto_the_goods"));
        $this->setAttribute("order_failure", $request->getAttribute("order_failure"));
        $this->setAttribute("order_after", $request->getAttribute("order_after"));
        $this->setAttribute("day", $request->getAttribute("day"));
        $this->setAttribute("hour", $request->getAttribute("hour"));
        $this->setAttribute("remind_day", $request->getAttribute("remind_day"));
        $this->setAttribute("remind_hour", $request->getAttribute("remind_hour"));
        $this->setAttribute("accesscode", $request->getAttribute("accesscode"));
        $this->setAttribute("checkword", $request->getAttribute("checkword"));
        $this->setAttribute("custid", $request->getAttribute("custid"));

        $this->setTemplate("Config.tpl");
    }
}

?>
