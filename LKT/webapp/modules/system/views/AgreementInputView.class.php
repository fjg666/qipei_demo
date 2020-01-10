<?php

class AgreementInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("button",$request->getAttribute("button"));

		$this->setTemplate("Agreement.tpl");
    }

}

?>