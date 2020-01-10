<?php

class UserSourceInputView extends SmartyView{

	public function execute(){
		$request = $this->getContext()->getRequest();
		//渲染模板
		$this->setAttribute('num_wx',$request->getAttribute('num_wx'));
		$this->setAttribute('num_app',$request->getAttribute('num_app'));
		
		$this->setTemplate('UserSource.tpl');
	}
}