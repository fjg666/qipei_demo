﻿<?phpclass IndexInputView extends SmartyView {    public function execute() {		$request = $this->getContext()->getRequest();        $this->setAttribute("list",$request->getAttribute("list"));        $this->setAttribute("num",$request->getAttribute("num"));        $this->setAttribute("code",$request->getAttribute("code"));        $this->setAttribute("name",$request->getAttribute("name"));        $this->setAttribute("attribute_value",$request->getAttribute("attribute_value"));        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));		$this->setTemplate("Index.tpl");    }}?>