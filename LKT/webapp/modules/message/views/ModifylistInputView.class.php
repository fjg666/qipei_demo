<?php
class ModifylistInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('SignName',$request->getAttribute('SignName'));
        $this->setAttribute('name',$request->getAttribute('name'));
        $this->setAttribute('TemplateCode',$request->getAttribute('TemplateCode'));
        $this->setAttribute('content',$request->getAttribute('content'));
        $this->setAttribute('select1',$request->getAttribute('select1'));
        $this->setAttribute('select2',$request->getAttribute('select2'));

		$this->setTemplate("Modifylist.tpl");
    }
}
?>