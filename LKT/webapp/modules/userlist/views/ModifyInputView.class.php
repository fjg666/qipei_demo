<?php

class ModifyInputView extends SmartyView{

	public function execute(){
		$request = $this->getContext()->getRequest();

        $this->setAttribute('user',$request->getAttribute('user'));
        $this->setAttribute('end',$request->getAttribute('end'));
	 
		$this->setTemplate("Modify.tpl");
	}
}