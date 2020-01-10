<?php

class AuthInputView extends SmartyView{

		 public function execute(){


		 	$request = $this->getContext()->getRequest();
		 	$this->setAttribute("url",$request->getAttribute("url"));
		 	$this->setTemplate("Auth.tpl");
		 }

}