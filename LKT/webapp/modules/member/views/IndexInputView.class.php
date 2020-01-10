<?php
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("list",$request->getAttribute("list"));
        $this->setAttribute("pages_show",$request->getAttribute("pages_show"));
        $this->setAttribute("store_type",$request->getAttribute("store_type"));
        $this->setAttribute("customer_number",$request->getAttribute("customer_number"));
        $this->setAttribute("button",$request->getAttribute("button"));
		$this->setTemplate("Index.tpl");
    }
}
?>
