<?php
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('name',$request->getAttribute('name'));
        $this->setAttribute('status',$request->getAttribute('status'));
        $this->setAttribute('list',$request->getAttribute('list'));

		$this->setTemplate("Modify.tpl");
    }
}
?>