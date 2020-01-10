<?php
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("is_open",$request->getAttribute("is_open"));
        $this->setAttribute("num",$request->getAttribute("num"));
        $this->setAttribute("keyword",$request->getAttribute("keyword"));
        $this->setAttribute("mch_keyword",$request->getAttribute("mch_keyword"));
		$this->setTemplate("Index.tpl");
    }
}
?>