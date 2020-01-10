<?php
class IndexInputView extends SmartyView {
// setTemplate() 为该视图设置模板。
    public function execute() {
        $request = $this->getContext()->getRequest();
        $this->setAttribute('version',$request->getAttribute('version'));
        $this->setAttribute('list',$request->getAttribute('list'));
        $this->setAttribute('admin_name',$request->getAttribute('admin_name'));
        $this->setAttribute('admin_type',$request->getAttribute('admin_type'));
        $this->setAttribute('type',$request->getAttribute('type'));
        $this->setAttribute('login_time',$request->getAttribute('login_time'));
        $this->setAttribute('domain',$request->getAttribute('domain'));
        $this->setAttribute('admin_role',$request->getAttribute('admin_role'));
        $this->setAttribute('store_id',$request->getAttribute('store_id'));
        $this->setAttribute('mch_id',$request->getAttribute('mch_id'));
        $this->setAttribute('role_list',$request->getAttribute('role_list'));
        $this->setAttribute('express',$request->getAttribute('express'));
        
        $store_id = $request->getAttribute('store_id');
        if($store_id != ''){
            $this->setTemplate("index.tpl");
        }else{
            $this->setTemplate("index1.tpl");
        }

    }
}
?>