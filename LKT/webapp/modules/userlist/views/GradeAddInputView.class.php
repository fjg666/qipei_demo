<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class GradeAddInputView extends SmartyView
{
	public function execute(){
		$request = $this->getContext()->getRequest();
		$this->setAttribute('upgrade',$request->getAttribute('upgrade'));
		$this->setAttribute('method',$request->getAttribute('method'));
		$this->setAttribute('is_product',$request->getAttribute('is_product'));
		$this->setTemplate("GradeAdd.tpl");
	}
}