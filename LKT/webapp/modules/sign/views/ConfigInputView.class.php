<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
class ConfigInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
		$this->setAttribute("is_status",$request->getAttribute("is_status"));
		$this->setAttribute("score_num",$request->getAttribute("score_num"));
        $this->setAttribute("starttime",$request->getAttribute("starttime"));
        $this->setAttribute("endtime",$request->getAttribute("endtime"));
        $this->setAttribute("is_remind",$request->getAttribute("is_remind"));
        $this->setAttribute("reset_h",$request->getAttribute("reset_h"));
        $this->setAttribute("reset_i",$request->getAttribute("reset_i"));
        $this->setAttribute("score",$request->getAttribute("score"));
        $this->setAttribute("continuity",$request->getAttribute("continuity"));
        $this->setAttribute("detail",$request->getAttribute("detail"));
        $this->setAttribute("Instructions",$request->getAttribute("Instructions"));
        $this->setAttribute("is_many_time",$request->getAttribute("is_many_time"));
        $this->setAttribute("num",$request->getAttribute("num"));

		$this->setTemplate("Config.tpl");
    }
}
?>