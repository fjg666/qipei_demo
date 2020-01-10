<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class navInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute("navs",$request->getAttribute("navs"));
		$id = $request->getAttribute("id");
		$this->setAttribute("id",$id);
		if($id){
			$this->setTemplate("nav_edit.tpl");
		}else{
			$this->setTemplate("nav_add.tpl");
		}

    }

}

?>

