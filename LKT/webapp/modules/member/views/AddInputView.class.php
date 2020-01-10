<?php
class AddInputView extends SmartyView {
	
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('customer_number',$request->getAttribute('customer_number'));
        $this->setAttribute('list',$request->getAttribute('list'));

        $this->setTemplate("Add.tpl");
    }
}
?>