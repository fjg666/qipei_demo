<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');

class XiaofeijindelAction extends Action {

    public function getDefaultView() {

        return View :: INPUT;
    }

    public function execute() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $id = $request->getParameter('id');// 记录ID

        $log = new LaiKeLogUtils('common/finance.log'); // 日志

        $sql = "delete from lkt_distribution_record where id = '$id'";
        $r = $db->delete($sql);
        if ($r < 0) {
            $db->admin_record($admin_id,' 删除消费金记录id为 '.$id.' 的数据失败！',3);
            $log -> customerLog(__LINE__.":【".$id."】删除消费金记录失败：$sql \r\n");
            header("Content-type:text/html;charset=utf-8");
            echo "<script type='text/javascript'>" .
                "alert('删除失败！');" .
                "location.href='index.php?module=finance&action=Xiaofeijin';</script>";
            return;
        }else{
            $db->admin_record($admin_id,' 删除消费金记录id为 '.$id.' 的数据成功！',3);
            $log -> customerLog(__LINE__.":【".$id."】删除消费金记录成功！ \r\n");
            header("Content-type:text/html;charset=utf-8");
            echo "<script type='text/javascript'>" .
                "alert('删除成功！');" .
                "location.href='index.php?module=finance&action=Xiaofeijin';</script>";
            return;
        }

    }
    public function getRequestMethods(){
         return Request :: GET;
    }

}

?>