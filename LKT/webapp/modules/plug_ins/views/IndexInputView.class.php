<?php
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("pages_show",$request->getAttribute("pages_show"));
		$this->setAttribute("list",$request->getAttribute("list"));
		$this->setTemplate("Index.tpl");
    }
}
?>
