<?php

class ProductNumInputView extends SmartyView{
	public function execute(){
		$request = $this->getContext()->getRequest();

		$this->setAttribute('product_num',$request->getAttribute('product_num'));
		$this->setAttribute('customer_num',$request->getAttribute('customer_num'));

		$this->setAttribute('res_top_title_0',$request->getAttribute('res_top_title_0'));
		$this->setAttribute('res_top_title_1',$request->getAttribute('res_top_title_1'));
		$this->setAttribute('res_top_title_2',$request->getAttribute('res_top_title_2'));
		$this->setAttribute('res_top_title_3',$request->getAttribute('res_top_title_3'));
		$this->setAttribute('res_top_title_4',$request->getAttribute('res_top_title_4'));
		$this->setAttribute('res_top_title_5',$request->getAttribute('res_top_title_5'));
		$this->setAttribute('res_top_title_6',$request->getAttribute('res_top_title_6'));
		$this->setAttribute('res_top_title_7',$request->getAttribute('res_top_title_7'));
		$this->setAttribute('res_top_title_8',$request->getAttribute('res_top_title_8'));
		$this->setAttribute('res_top_title_9',$request->getAttribute('res_top_title_9'));

		$this->setAttribute('res_top_volume_0',$request->getAttribute('res_top_volume_0'));
		$this->setAttribute('res_top_volume_1',$request->getAttribute('res_top_volume_1'));
		$this->setAttribute('res_top_volume_2',$request->getAttribute('res_top_volume_2'));
		$this->setAttribute('res_top_volume_3',$request->getAttribute('res_top_volume_3'));
		$this->setAttribute('res_top_volume_4',$request->getAttribute('res_top_volume_4'));
		$this->setAttribute('res_top_volume_5',$request->getAttribute('res_top_volume_5'));
		$this->setAttribute('res_top_volume_6',$request->getAttribute('res_top_volume_6'));
		$this->setAttribute('res_top_volume_7',$request->getAttribute('res_top_volume_7'));
		$this->setAttribute('res_top_volume_8',$request->getAttribute('res_top_volume_8'));
		$this->setAttribute('res_top_volume_9',$request->getAttribute('res_top_volume_9'));


		$this->setAttribute('res_stock',$request->getAttribute('res_stock'));
		$this->setAttribute('in_out',$request->getAttribute('in_out'));
		


	    $this->setTemplate('ProductNum.tpl');
		

	}
} 