<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class EditInputView extends SmartyView {

    public function execute() {

		$request = $this->getContext()->getRequest();

        $this->setAttribute('user',$request->getAttribute('user'));
        $this->setAttribute('level',$request->getAttribute('level'));

		$this->setTemplate("Edit.tpl");

    }

}

?>