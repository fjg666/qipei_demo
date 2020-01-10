<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class ModifyAction extends Action{
    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-27T18:36:47+0800
     * @return  修改评论
     */
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

        $tt_sql = "select * from lkt_reply_comments where cid = '$cid' and store_id = '$store_id' ";
        $res = $db->select($tt_sql);

        $img_sql = "select * from lkt_comments_img where comments_id = '$cid' ";
        $res_i = $db->select($img_sql);
        if($res_i){
            foreach ($res_i as $key => $value) {
                $res_i[$key]->comments_url = ServerPath::getimgpath($value->comments_url,$store_id);
            }
        }

        $rec = $res ? $res[0]:'';
        $request->setAttribute("rec", (object)$rec);
        $request->setAttribute("cid", $cid);
        $request->setAttribute("headimgurl", $headimgurl);
        $request->setAttribute("add_time", $add_time);
        $request->setAttribute("user_name", $user_name);
        $request->setAttribute("content", $content);
        $request->setAttribute("CommentType", $CommentType);
        $request->setAttribute("images",$res_i);
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $id = addslashes(trim($request->getParameter('id')));
        $comment_input = addslashes(trim($request->getParameter('comment_input')));
        $comment_type = addslashes(trim($request->getParameter('comment-type')));
        $imgurls = $request->getParameter('imgurls');

        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/comments.log");
        // 1.开启事务
        $db->begin();

        $db->delete("delete from lkt_comments_img where comments_id = '$id'");
        if ($imgurls) {
            if(count($imgurls) <= 5){
                foreach ($imgurls as $key => $value) {
                    $imgURL_name = preg_replace('/.*\//','',$value);
                    $sql = "insert into lkt_comments_img(comments_url,comments_id,add_time) VALUES ('$imgURL_name','$id',CURRENT_TIMESTAMP)";
                    $res = $db->insert($sql);
                }
            }
        }

        $sql = "update lkt_comments set content= '$comment_input' ,CommentType='$comment_type'  where store_id = '$store_id' and id= '$id' ";
        $up = $db->update($sql);
        if($up || $res){
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改评论id为'.$id.'的信息成功',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改评论id为'.$id.'的信息成功';
            $lktlog->customerLog($Log_content);

            $db->commit();
            echo 1;exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改评论id为'.$id.'的信息失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改评论id为'.$id.'的信息失败';
            $lktlog->customerLog($Log_content);

            $db->rollback();
            echo 0;exit;
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}

?>