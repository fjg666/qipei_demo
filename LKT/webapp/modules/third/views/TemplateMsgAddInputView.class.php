<?php

class TemplateMsgAddInputView extends SmartyView{

	public function execute(){
		$request = $this->getContext()->getRequest();
        
      
        $this->setTemplate("TemplateMsgAdd.tpl");
	}
}
