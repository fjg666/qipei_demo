<?php

class OrderNumInputView extends SmartyView{

	public function execute(){
		$request = $this->getContext()->getRequest();

		//渲染模板
		$this->setAttribute('order_all',$request->getAttribute('order_all'));
		$this->setAttribute('order_valid',$request->getAttribute('order_valid'));
		$this->setAttribute('z_price_all',$request->getAttribute('z_price_all'));
		$this->setAttribute('z_price_valid',$request->getAttribute('z_price_valid'));


		$this->setAttribute('day_arr',$request->getAttribute('day_arr'));
		$this->setAttribute('sum_arr',$request->getAttribute('sum_arr'));
		$this->setAttribute('price_arr',$request->getAttribute('price_arr'));



	    $this->setTemplate('OrderNum.tpl');
	}
	
}