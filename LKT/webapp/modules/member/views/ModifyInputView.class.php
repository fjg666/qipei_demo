<?php
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('customer_number',$request->getAttribute('customer_number'));
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('name',$request->getAttribute('name'));
        $this->setAttribute('admin_type',$request->getAttribute('admin_type'));
        $this->setAttribute('type',$request->getAttribute('type'));
        $this->setAttribute('list',$request->getAttribute('list'));
        $this->setAttribute('role_id',$request->getAttribute('role_id'));

		$this->setTemplate("Modify.tpl");
    }
}
?>