<?php
class TemplateInfoInputView extends SmartyView
{

	public function execute(){

		 $request = $this->getContext()->getRequest();

		 $this->setAttribute("res_list",$request->getAttribute("res_list"));
		 $this->setTemplate("TemplateInfo.tpl");
       
	}
}