<?php
class AboutusInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("aboutus",$request->getAttribute("aboutus"));
        $this->setAttribute("button",$request->getAttribute("button"));
		$this->setTemplate("Aboutus.tpl");
    }
}
?>