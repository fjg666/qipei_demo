<?php 
class TemplateAddInputView extends SmartyView{

	public function execute(){
		$request = $this->getContext()->getRequest();
		$this->setAttribute("trade_arr",$request->getAttribute("trade_arr"));

		$this->setTemplate('TemplateAdd.tpl');
	}


}