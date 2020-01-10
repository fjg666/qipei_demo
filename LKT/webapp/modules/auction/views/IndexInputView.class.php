<?php

class IndexInputView extends SmartyView
{
    public function execute()
    {
        $request = $this->getContext()->getRequest();
        $this->setAttribute('num', $request->getAttribute('num'));
        $this->setAttribute('list', $request->getAttribute('list'));
        $this->setAttribute('title', $request->getAttribute('title'));
        $this->setAttribute('status', $request->getAttribute('status'));
        $this->setAttribute('pages_show', $request->getAttribute('pages_show'));
        $this->setTemplate('Index.tpl');
    }
}
