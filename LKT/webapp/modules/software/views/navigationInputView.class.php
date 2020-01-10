<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class navigationInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();

		$this->setAttribute("Navbar",$request->getAttribute("Navbar"));

		$this->setTemplate("navigation.tpl");

    }

}

?>

