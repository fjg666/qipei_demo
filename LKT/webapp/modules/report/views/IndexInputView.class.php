<?php
class IndexInputView extends SmartyView{

	public function execute(){
		$request=$this->getContext()->getRequest();
		//日期数组，人数数组
		$this->setAttribute('day_arr',$request->getAttribute('day_arr'));
		$this->setAttribute('sum_arr_wx',$request->getAttribute('sum_arr_wx'));
		$this->setAttribute('sum_arr_app',$request->getAttribute('sum_arr_app'));
		$this->setAttribute('res',$request->getAttribute('res'));
		//新增会员列表，分页样式
		$this->setAttribute('list',$request->getAttribute('list'));
		$this->setAttribute('pages_show',$request->getAttribute('pages_show'));
		

		$this->setTemplate('Index.tpl');

	}

}