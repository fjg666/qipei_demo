<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class ModifyInputView extends SmartyView {

    public function execute() {
        $request = $this->getContext()->getRequest();
        $this->setAttribute('class', $request->getAttribute('class'));
        $this->setAttribute('str_option',$request->getAttribute('str_option'));
        $this->setAttribute('level_list',$request->getAttribute('level_list'));
        $this->setAttribute('del_str',$request->getAttribute('del_str'));
        $this->setTemplate("Modify.tpl");
    }
}
?>