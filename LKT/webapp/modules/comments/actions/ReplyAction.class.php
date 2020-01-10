<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ReplyAction extends Action{

    public function getDefaultView(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = addslashes(trim($request->getParameter('id')));

        $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.size,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id where a.store_id = '$store_id' and a.id = '$id'";
        $r_c = $db->select($sql_c);

        $cid = $r_c[0]->id;
        $headimgurl = $r_c[0]->headimgurl;
        $user_name = $r_c[0]->user_name;
        $content = $r_c[0]->content;
        $add_time = $r_c[0]->add_time;
        $CommentType = $r_c[0]->CommentType;
        if ($CommentType == 5) {
            $CommentType = 'GOOD';
        } elseif ($CommentType == 4) {
            $CommentType = 'GOOD';
        } elseif ($CommentType == 3) {
            $CommentType = 'NOTBAD';
        } elseif ($CommentType == 2) {
            $CommentType = 'BAD';
        } elseif ($CommentType == 1) {
            $CommentType = 'BAD';
        } elseif ($CommentType == 'GOOD') {
            $CommentType = 'GOOD';
        } elseif ($CommentType == 'NOTBAD') {
            $CommentType = 'NOTBAD';
        } else {
            $CommentType = 'BAD';
        }

        $request->setAttribute("cid", $cid);
        $request->setAttribute("headimgurl", $headimgurl);
        $request->setAttribute("add_time", $add_time);
        $request->setAttribute("user_name", $user_name);
        $request->setAttribute("content", $content);
        $request->setAttribute("CommentType", $CommentType);
        return View :: INPUT;
    }


    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = addslashes(trim($request->getParameter('id')));
        $comment_input = addslashes(trim($request->getParameter('comment_input')));

        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/comments.log");
        // 1.开启事务
        $db->begin();

        $sql = "INSERT INTO lkt_reply_comments (`store_id`,`cid`, `uid`, `content`, `add_time`) VALUES ('$store_id','$id', 'admin', '$comment_input', CURRENT_TIMESTAMP) ";
        $up = $db->insert($sql);
        if($up > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'回复评论ID为'.$id.'成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 回复评论ID为'.$id.'成功';
            $lktlog->customerLog($Log_content);

            $db->commit();
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'回复评论ID为'.$id.'失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 回复评论ID为'.$id.'失败';
            $lktlog->customerLog($Log_content);

            $db->rollback();
        }
        echo $up;
        exit;
    }


    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>