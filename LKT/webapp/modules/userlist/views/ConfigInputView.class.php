<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

 class ConfigInputView extends SmartyView
 {
 	 public function execute() {

		$request = $this->getContext()->getRequest();
		$this->setAttribute('active',$request->getAttribute('active'));
		$this->setAttribute('str_method',$request->getAttribute('str_method'));
		$this->setAttribute('wait',$request->getAttribute('wait'));
		$this->setAttribute('rule',$request->getAttribute('rule'));
		$this->setAttribute('wx_name',$request->getAttribute('wx_name'));
		$this->setAttribute('wx_headimgurl',$request->getAttribute('wx_headimgurl'));
		$this->setAttribute('upgrade',$request->getAttribute('upgrade'));
		$this->setAttribute('is_auto',$request->getAttribute('is_auto'));
		$this->setAttribute('auto_time',$request->getAttribute('auto_time'));
		$this->setAttribute('is_wallet',$request->getAttribute('is_wallet'));
		$this->setAttribute('is_birthday',$request->getAttribute('is_birthday'));
		$this->setAttribute('bir_multiple',$request->getAttribute('bir_multiple'));
		$this->setAttribute('is_product',$request->getAttribute('is_product'));
		$this->setAttribute('is_jifen',$request->getAttribute('is_jifen'));
		$this->setAttribute('jifen_m',$request->getAttribute('jifen_m'));
		$this->setAttribute('back',$request->getAttribute('back'));
		$this->setAttribute('back_scale',$request->getAttribute('back_scale'));
		$this->setAttribute('poster',$request->getAttribute('poster'));
		$this->setAttribute('is_limit',$request->getAttribute('is_limit'));
		$this->setAttribute('level',$request->getAttribute('level'));
		$this->setAttribute('distribute_l',$request->getAttribute('distribute_l'));
		$this->setAttribute('distribute_l',$request->getAttribute('distribute_l'));
		$this->setAttribute('valid',$request->getAttribute('valid'));
		$this->setAttribute('grade',$request->getAttribute('grade'));
		$this->setAttribute('score',$request->getAttribute('score'));
		$this->setTemplate("Config.tpl");

    }
 }