<?php
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('type',$request->getAttribute('type'));
        $this->setAttribute('type1',$request->getAttribute('type1'));
        $this->setAttribute('list',$request->getAttribute('list'));
        $this->setAttribute('content',$request->getAttribute('content'));
        $this->setAttribute('select1',$request->getAttribute('select1'));
        $this->setAttribute('select2',$request->getAttribute('select2'));

		$this->setTemplate("Modify.tpl");
    }
}
?>