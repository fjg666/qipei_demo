<?php
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('name',$request->getAttribute('name'));
        $this->setAttribute('Identification',$request->getAttribute('Identification'));
        $this->setAttribute('sort',$request->getAttribute('sort'));
		$this->setTemplate("Modify.tpl");
    }
}
?>