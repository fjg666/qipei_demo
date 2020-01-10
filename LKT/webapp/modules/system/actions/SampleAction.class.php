<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class SampleAction extends Action {

    public function getDefaultView() {
        return View :: INPUT;
    }

    public function execute(){

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>