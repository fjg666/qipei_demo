<?php
class kefuInputView extends SmartyView {
	
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('customer_service',$request->getAttribute('customer_service'));

        $this->setTemplate("kefu.tpl");
    }
}
?>