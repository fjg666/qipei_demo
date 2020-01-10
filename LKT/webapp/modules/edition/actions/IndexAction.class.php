<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
class IndexAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $sql = "select * from lkt_edition where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $appname = $r[0]->appname; // APP名称
            $edition = $r[0]->edition; // 版本号
            $android_url = $r[0]->android_url;  // android路径
            $ios_url = $r[0]->ios_url;  // ios路径
            $type = $r[0]->type;  // 是否是热更新
            $content = $r[0]->content;  // 更新内容
        }

        $request->setAttribute('appname', isset($appname) ? $appname : '');
        $request->setAttribute('edition', isset($edition) ? $edition : '');
        $request->setAttribute('android_url', isset($android_url) ? $android_url : '');
        $request->setAttribute('ios_url', isset($ios_url) ? $ios_url : '');
        $request->setAttribute('type', isset($type) ? $type : 0);
        $request->setAttribute('content', isset($content) ? $content : '');
        return View :: INPUT;
    }

    public function execute(){

        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //取得参数
        $appname = addslashes(trim($request->getParameter('appname'))); // APP名称
        $edition = addslashes(trim($request->getParameter('edition'))); // 版本号
        $ios_url = addslashes(trim($request->getParameter('ios_url'))); // ios路径
        $android_url = addslashes(trim($request->getParameter('android_url'))); // android路径
        $type = addslashes(trim($request->getParameter('type'))); // 是否自动更新提示
        $content = addslashes(trim($request->getParameter('content'))); // 更新内容

        if($appname == ''){
            header("Content-type:text/html;charset=utf-8");
            echo "<script type='text/javascript'>" .
                "alert('APP名称不能为空！');" .
                "location.href='index.php?module=edition&action=Index';</script>";exit;
        }
        if($edition == ''){
            header("Content-type:text/html;charset=utf-8");
            echo "<script type='text/javascript'>" .
                "alert('版本号不能为空！');" .
                "location.href='index.php?module=edition&action=Index';</script>";exit;
        }

        if($android_url == '' || $ios_url == ''){
            header("Content-type:text/html;charset=utf-8");
            echo "<script type='text/javascript'>" .
                "alert('下载地址不能为空！');" .
                "location.href='index.php?module=edition&action=Index';</script>";exit;
        }

        $sql0 = "select edition from lkt_edition where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $edition1 = $r0[0]->edition;
            if($edition1 > $edition){
                header("Content-type:text/html;charset=utf-8");
                echo "<script type='text/javascript'>" .
                    "alert('版本号低于当前版本！');" .
                    "location.href='index.php?module=edition&action=Index';</script>";exit;
            }
            $sql2 = "update lkt_edition set appname = '$appname',edition = '$edition',android_url = '$android_url',ios_url = '$ios_url',type = '$type',content = '$content',add_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
            $r2 = $db->update($sql2);
            if($r2 == -1){
                $db->admin_record($store_id,$admin_name,'修改版本配置失败',2);
                header("Content-type:text/html;charset=utf-8");
                echo "<script type='text/javascript'>" .
                    "alert('未知原因，修改失败！！');" .
                    "location.href='index.php?module=edition&action=Index';</script>";exit;
            }else{
                $db->admin_record($store_id,$admin_name,'修改版本配置',2);
                header("Content-type:text/html;charset=utf-8");
                echo "<script type='text/javascript'>" .
                    "alert('修改成功！');" .
                    "location.href='index.php?module=edition&action=Index';</script>";exit;
            }
        }else{
            $sql1 = "insert into lkt_edition(store_id,appname,edition,android_url,ios_url,type,content,add_date) values ('$store_id','$appname','$edition','$android_url','$ios_url','$type','$content',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql1);
            if($r1 > 0){
                $db->admin_record($store_id,$admin_name,'添加版本配置',1);
                header("Content-type:text/html;charset=utf-8");
                echo "<script type='text/javascript'>" .
                    "alert('添加成功！');" .
                    "location.href='index.php?module=edition&action=Index';</script>";exit;
            }else{
                $db->admin_record($store_id,$admin_name,'添加版本配置失败',1);
                header("Content-type:text/html;charset=utf-8");
                echo "<script type='text/javascript'>" .
                    "alert('未知原因，添加失败！！');" .
                    "location.href='index.php?module=edition&action=Index';</script>";exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>