<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once('Apimiddle.class.php');

class plugsAction extends Apimiddle {

    public function getDefaultView() {

        echo "getDefaultView------------";
    }

    public function execute(){
        echo "execute-------------";
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    public function pay()
    {
        echo "string";
    }

}
?>