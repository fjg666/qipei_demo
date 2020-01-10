<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

class AddInputView extends SmartyView {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/21 14:48
     * @version 1.
     *
     */
    public function execute() {

		$request = $this->getContext()->getRequest();

        $this->setAttribute("coupon_type",$request->getAttribute("coupon_type"));
        $this->setAttribute("limit_type",$request->getAttribute("limit_type"));
        $this->setAttribute("res",$request->getAttribute("res"));

        $this->setTemplate("Add.tpl");
    }
}
?>