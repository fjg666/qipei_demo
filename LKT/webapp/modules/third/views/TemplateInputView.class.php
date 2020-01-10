<?php

class TemplateInputView extends SmartyView{

	public function execute(){

		$request = $this->getContext()->getRequest();
        
        $this->setAttribute("res",$request->getAttribute("res"));
        $this->setAttribute("res_trade",$request->getAttribute("res_trade"));
        $this->setAttribute("trade_data",$request->getAttribute("trade_data"));
        $this->setAttribute('is_use',$request->getAttribute("is_use"));
        $this->setAttribute('title',$request->getAttribute("title"));
        $this->setAttribute('num',$request->getAttribute("num"));
        $this->setAttribute('pages_show',$request->getAttribute('pages_show'));

        $this->setTemplate("Template.tpl");
	}
} 