<?php
class CheckTemplateInputView extends SmartyView {

    public function execute() {

        $request = $this->getContext()->getRequest();
        
        $this->setAttribute("res",$request->getAttribute("res"));
        $this->setAttribute("status",$request->getAttribute("status"));
        $this->setAttribute("auditid",$request->getAttribute("auditid"));
        $this->setAttribute("trade_all",$request->getAttribute("trade_all"));
        $this->setTemplate("CheckTemplate.tpl");
    }
}
?>