<?php

class AddInputView extends SmartyView
{
    public function execute()
    {
        $request = $this->getContext()->getRequest();
        $this->setAttribute('class', $request->getAttribute('class'));
        $this->setAttribute('sp_type', $request->getAttribute('sp_type'));
        $this->setTemplate("Add.tpl");
    }
}
