<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class ViewInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute('list',$request->getAttribute('list'));
		$this->setAttribute('record',$request->getAttribute('record'));
		$this->setAttribute('imgs',$request->getAttribute('imgs'));
		$this->setAttribute('rdata',$request->getAttribute('rdata'));
		$this->setTemplate("view.tpl");
    }

}

?>