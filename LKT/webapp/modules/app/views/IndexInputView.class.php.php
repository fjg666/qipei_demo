<?php
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("banner",$request->getAttribute("banner"));
		$this->setAttribute("news_list",$request->getAttribute("news_list"));
		$this->setTemplate("index.tpl");
    }
}
?>