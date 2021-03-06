<?php
class ModifyInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('title',$request->getAttribute('title'));
        $this->setAttribute('url',$request->getAttribute('url'));
        $this->setAttribute('sort',$request->getAttribute('sort'));
        $this->setAttribute('level',$request->getAttribute('level'));
        $this->setAttribute('image',$request->getAttribute('image'));
        $this->setAttribute('image1',$request->getAttribute('image1'));
        $this->setAttribute('type',$request->getAttribute('type'));
        $this->setAttribute('is_core',$request->getAttribute('is_core'));
        $this->setAttribute('is_plug_in',$request->getAttribute('is_plug_in'));
        $this->setAttribute('status',$request->getAttribute('status'));

        $this->setAttribute('cid',$request->getAttribute('cid'));
        $this->setAttribute('level',$request->getAttribute('level'));
        $this->setAttribute('list',$request->getAttribute('list'));
        $this->setAttribute('list1',$request->getAttribute('list1'));
        $this->setAttribute('list2',$request->getAttribute('list2'));
        $this->setAttribute('status',$request->getAttribute('status'));

		$this->setTemplate("Modify.tpl");
    }
}
?>