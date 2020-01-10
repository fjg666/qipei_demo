<?php
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('brand_id',$request->getAttribute('brand_id'));
        $this->setAttribute('brand_name', $request->getAttribute('brand_name'));
        $this->setAttribute('brand_pic', $request->getAttribute('brand_pic'));
        $this->setAttribute('producer', $request->getAttribute('producer'));
        $this->setAttribute('remarks', $request->getAttribute('remarks'));
        $this->setAttribute('categories', $request->getAttribute('categories'));
        $this->setAttribute('list', $request->getAttribute('list'));
        $this->setAttribute('class_name', $request->getAttribute('class_name'));
		$this->setTemplate("Modify.tpl");
    }
}
?>