<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class DeliveryInputView extends SmartyView {

	

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("express",$request->getAttribute("express"));
		$this->setAttribute("goods",$request->getAttribute("goods"));
		$this->setAttribute("put",$request->getAttribute("put"));
       
        $this->setTemplate("Delivery.tpl");

    }

}

?>