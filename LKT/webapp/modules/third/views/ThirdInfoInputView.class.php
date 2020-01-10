<?php
class ThirdInfoInputView  extends SmartyView
{
	public function execute(){
		$request = $this->getContext()->getRequest();
        
        $this->setAttribute("id",$request->getAttribute("id"));
        $this->setAttribute("appid",$request->getAttribute("appid"));
        $this->setAttribute("appsecret",$request->getAttribute("appsecret"));
        $this->setAttribute("check_token",$request->getAttribute("check_token"));
        $this->setAttribute("encrypt_key",$request->getAttribute("encrypt_key"));
        $this->setAttribute("serve_domain",$request->getAttribute("serve_domain"));
        $this->setAttribute("work_domain",$request->getAttribute("work_domain"));
        $this->setAttribute("redirect_url",$request->getAttribute("redirect_url"));
        $this->setAttribute("mini_url",$request->getAttribute("mini_url"));
        $this->setAttribute("kefu_url",$request->getAttribute("kefu_url"));
        $this->setAttribute("qr_code",$request->getAttribute("qr_code"));
        $this->setAttribute("H5",$request->getAttribute("H5"));
        $this->setAttribute("endurl",$request->getAttribute("endurl"));

        $this->setTemplate("ThirdInfo.tpl");
	}

}