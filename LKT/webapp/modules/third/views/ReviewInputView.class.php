<?php

class ReviewInputView extends SmartyView{


	public function execute(){
		$request = $this->getContext()->getRequest();
        
        $this->setAttribute("nick_name",$request->getAttribute("nick_name"));
     	$this->setAttribute("res",$request->getAttribute("res"));
     	$this->setAttribute("pages_show",$request->getAttribute("pages_show"));
     	$this->setAttribute("status",$request->getAttribute("status"));
     	$this->setAttribute("issue_mark",$request->getAttribute("issue_mark"));
        $this->setTemplate("Review.tpl");
	}
}