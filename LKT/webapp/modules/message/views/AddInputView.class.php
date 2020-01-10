<?php
class AddInputView extends SmartyView {
	
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('select1',$request->getAttribute('select1'));

        $this->setTemplate("Add.tpl");
    }
}
?>