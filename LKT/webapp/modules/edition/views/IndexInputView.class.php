<?php
class IndexInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("appname",$request->getAttribute("appname"));
		$this->setAttribute("edition",$request->getAttribute("edition"));
        $this->setAttribute("android_url",$request->getAttribute("android_url"));
        $this->setAttribute("ios_url",$request->getAttribute("ios_url"));
        $this->setAttribute("type",$request->getAttribute("type"));
        $this->setAttribute("content",$request->getAttribute("content"));
		$this->setTemplate("Index.tpl");
    }
}
?>