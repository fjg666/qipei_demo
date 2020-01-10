<?php
class AddInputView extends SmartyView {
	
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("type",$request->getAttribute("type"));

        $this->setTemplate("Add.tpl");
    }
}
?>