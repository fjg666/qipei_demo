<?php

class IndexInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("appid",$request->getAttribute("appid"));
		$this->setAttribute("appsecret",$request->getAttribute("appsecret"));

		$this->setTemplate("Index.tpl");
    }

}

?>