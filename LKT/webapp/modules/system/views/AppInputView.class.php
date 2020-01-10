<?php

class AppInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("app_domain_name",$request->getAttribute("app_domain_name"));

		$this->setTemplate("App.tpl");
    }
    
}

?>