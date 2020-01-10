<?php

class IndexInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("upserver",$request->getAttribute("upserver"));
		
		$this->setTemplate("Index.tpl");
    }

}

?>