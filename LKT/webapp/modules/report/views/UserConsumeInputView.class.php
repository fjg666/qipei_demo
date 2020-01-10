<?php
class UserConsumeInputView extends SmartyView{
	public function execute(){
		$request = $this->getContext()->getRequest();
		$this->setAttribute('name',$request->getAttribute('name'));
		$this->setAttribute('source',$request->getAttribute('source'));
		$this->setAttribute('startdate',$request->getAttribute('startdate'));
		$this->setAttribute('enddate',$request->getAttribute('enddate'));
		$this->setAttribute('res',$request->getAttribute('res'));
		$this->setAttribute('pages_show',$request->getAttribute('pages_show'));
		$this->setAttribute('now_date',date('Y-m-d'));
		$this->setAttribute("title",$request->getAttribute("title"));
        $this->setAttribute("title1",$request->getAttribute("title1"));
		$pageto=$request->getAttribute('pageto');
		if($pageto == 'all'){
				$r=time();
				header("Content-type: application/msexcel;charset=utf-8");
			    header("Content-Disposition: attachment;filename=user-consume-$r.xls");
			    $this->setTemplate('excle.tpl');
		}else{
			$this->setTemplate('UserConsume.tpl');
		}
	}




}