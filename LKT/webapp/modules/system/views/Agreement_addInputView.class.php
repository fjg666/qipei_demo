<?php

class Agreement_addInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();

		$this->setTemplate("Agreement_add.tpl");
    }

}

?>