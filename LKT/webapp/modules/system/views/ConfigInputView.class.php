<?php

class ConfigInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
        $this->setAttribute("logo",$request->getAttribute("logo"));
		$this->setAttribute("logo1",$request->getAttribute("logo1"));
        $this->setAttribute("wx_name",$request->getAttribute("wx_name"));
        $this->setAttribute("user_id",$request->getAttribute("user_id"));
		$this->setAttribute("company",$request->getAttribute("company"));
		$this->setAttribute("H5_domain",$request->getAttribute("H5_domain"));
        $this->setAttribute("message_day",$request->getAttribute("message_day"));
        $this->setAttribute("is_register",$request->getAttribute("is_register"));
		$this->setAttribute("wx_headimgurl",$request->getAttribute("wx_headimgurl"));
		$this->setAttribute("wx_headimgurl1",$request->getAttribute("wx_headimgurl1"));
        $this->setAttribute("customer_service",$request->getAttribute("customer_service"));
        $this->setAttribute("button",$request->getAttribute("button"));

		$this->setTemplate("Config.tpl");
    }

}

?>