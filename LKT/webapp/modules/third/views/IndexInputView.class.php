<?php
class IndexInputView extends SmartyView {
// getContext() 检索当前应用程序上下文。
// getRequest() 检索请求。
// setAttribute() 设置一个属性。
// getAttribute() 方法返回指定属性名的属性值。
// getError() 检索一个错误消息。
// setTemplate() 为该视图设置模板。
    public function execute() {
        $request = $this->getContext()->getRequest();
       
        $this->setAttribute("status",$request->getAttribute('status'));
        $this->setAttribute("reason",$request->getAttribute('reason'));
        $this->setAttribute("nick_name",$request->getAttribute('nick_name'));
        $this->setAttribute("head_img",$request->getAttribute('head_img'));
        $this->setAttribute("issue_mark",$request->getAttribute('issue_mark'));
        $this->setAttribute("qr_code",$request->getAttribute('qr_code'));

        
        $this->setTemplate("Index.tpl");
    }
}
?>