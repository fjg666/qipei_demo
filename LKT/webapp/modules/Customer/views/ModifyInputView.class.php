<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class ModifyInputView extends SmartyView {

    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute('customer',$request->getAttribute('customer'));
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('domain',$request->getAttribute('domain'));

        $this->setTemplate("Modify.tpl");
    }
}
?>