<?php
class ConfigInputView extends SmartyView
{
    public function execute()
    {
        $request = $this->getContext()->getRequest();
        $this->setAttribute('low_pepole', $request->getAttribute('low_pepole'));
        $this->setAttribute('wait_time', $request->getAttribute('wait_time'));
        $this->setAttribute('days', $request->getAttribute('days'));
        $this->setAttribute('content', $request->getAttribute('content'));
        $this->setAttribute('is_open', $request->getAttribute('is_open'));
        $this->setTemplate('Config.tpl');
    }
}
