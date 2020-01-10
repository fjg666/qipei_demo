<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class SeeInputView extends SmartyView {
    public function execute() {
		$request = $this->getContext()->getRequest();
        $this->setAttribute("serverURL",$request->getAttribute("serverURL"));
        $this->setAttribute('id',$request->getAttribute('id'));
        $this->setAttribute('mch_id',$request->getAttribute('mch_id'));
        $this->setAttribute('product_title',$request->getAttribute('product_title'));
        $this->setAttribute('subtitle',$request->getAttribute('subtitle'));
        $this->setAttribute('keyword',$request->getAttribute('keyword'));
        $this->setAttribute('weight',$request->getAttribute('weight'));
        $this->setAttribute('product_number',$request->getAttribute('product_number'));
        $this->setAttribute('scan',$request->getAttribute('scan'));
        $this->setAttribute('product_class_name',$request->getAttribute('product_class_name'));
        $this->setAttribute('brand_class_name',$request->getAttribute('brand_class_name'));
        $this->setAttribute('imgurls',$request->getAttribute('imgurls'));

        $this->setAttribute('initial',$request->getAttribute('initial'));
        $this->setAttribute('status',$request->getAttribute('status'));
        $this->setAttribute('unit',$request->getAttribute('unit'));
        $this->setAttribute('attr_group_list',$request->getAttribute('attr_group_list'));
        $this->setAttribute('checked_attr_list',$request->getAttribute('checked_attr_list'));

        $this->setAttribute('min_inventory',$request->getAttribute('min_inventory'));
        $this->setAttribute('freight_name',$request->getAttribute('freight_name'));
        $this->setAttribute('sort',$request->getAttribute('sort'));
        $this->setAttribute('sp_type',$request->getAttribute('sp_type'));
        $this->setAttribute('active',$request->getAttribute('active'));
        $this->setAttribute('Plugin_arr',$request->getAttribute('Plugin_arr'));
        $this->setAttribute('show_adr',$request->getAttribute('show_adr'));
        $this->setAttribute('is_hexiao',$request->getAttribute('is_hexiao'));
        $this->setAttribute('hxaddress',$request->getAttribute('hxaddress'));

        $this->setAttribute('content',$request->getAttribute('content'));

        $this->setAttribute('del_str',$request->getAttribute('del_str'));


        $this->setTemplate("See.tpl");
    }
}
?>
