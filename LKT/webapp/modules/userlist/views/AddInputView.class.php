<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class AddInputView extends SmartyView
{
	public function execute(){
		$request = $this->getContext()->getRequest();
		$this->setAttribute('wx_name',$request->getAttribute('wx_name'));
		$this->setAttribute('wx_headimgurl',$request->getAttribute('wx_headimgurl'));
		$this->setAttribute('str_grade',$request->getAttribute('str_grade'));
		$this->setAttribute('str_method',$request->getAttribute('str_method'));
		$this->setTemplate("Add.tpl");
	}
}