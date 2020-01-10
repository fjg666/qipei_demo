<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class SeeInputView extends SmartyView {

    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute('customer',$request->getAttribute('customer'));
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('uploadImg',$request->getAttribute('uploadImg'));
        $this->setAttribute('role',$request->getAttribute('role'));
        $this->setAttribute('list',$request->getAttribute('list'));

        $this->setTemplate("See.tpl");
    }
}
?>