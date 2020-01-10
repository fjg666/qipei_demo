<?php

class Agreement_modifyInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
        $this->setAttribute("id",$request->getAttribute("id"));
        $this->setAttribute("type",$request->getAttribute("type"));
		$this->setAttribute("content",$request->getAttribute("content"));

		$this->setTemplate("Agreement_modify.tpl");
    }
    
}

?>