<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
 class GradeModifyInputView extends SmartyView
{
	public function execute(){
		$request = $this->getContext()->getRequest();
		$this->setAttribute('name',$request->getAttribute('name'));
		$this->setAttribute('imgurl',$request->getAttribute('imgurl'));
		$this->setAttribute('imgurl_my',$request->getAttribute('imgurl_my'));
		$this->setAttribute('imgurl_s',$request->getAttribute('imgurl_s'));
		$this->setAttribute('rate',$request->getAttribute('rate'));
		$this->setAttribute('money',$request->getAttribute('money'));
		$this->setAttribute('id',$request->getAttribute('id'));
		$this->setAttribute('money_j',$request->getAttribute('money_j'));
		$this->setAttribute('money_n',$request->getAttribute('money_n'));
		$this->setAttribute('remark',$request->getAttribute('remark'));
		$this->setAttribute('upgrade',$request->getAttribute('upgrade'));
		$this->setAttribute('method',$request->getAttribute('method'));
		$this->setAttribute('pro_id',$request->getAttribute('pro_id'));
		$this->setAttribute('pro_name',$request->getAttribute('pro_name'));
		$this->setAttribute('font_color',$request->getAttribute('font_color'));
		$this->setAttribute('date_color',$request->getAttribute('date_color'));
		$this->setAttribute('is_product',$request->getAttribute('is_product'));
		$this->setTemplate("GradeModify.tpl");
	}
}