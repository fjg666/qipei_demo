<?php

class TemplateModifyInputView extends SmartyView{


	public function execute(){

		$request = $this->getContext()->getRequest();
		$this->setAttribute("res_c",$request->getAttribute("res_c"));
		$this->setAttribute("res",$request->getAttribute("res"));
		$this->setTemplate("TemplateModify.tpl");
	}
}