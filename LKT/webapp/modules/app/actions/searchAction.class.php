<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class searchAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();
        return;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();

        return;
    }

	public function getRequestMethods(){
		return Request :: POST;
	}

    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        //查询商品并分类显示返回JSON至小程序
        $sql_c = 'select cid,pname,img,bg from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 and sid=0 order by sort desc';
        $r_c = $db->select($sql_c);
        $icons = array();

        foreach ($r_c as $key => $value) {
            $sql_e = 'select cid,pname,img from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 and sid=\''.$value->cid.'\' order by sort desc';
            $r_e = $db->select($sql_e);
            $son = array();
            if($r_e){
                foreach ($r_e as $ke => $ve) {
                    if($ve->img){
                        $imgurl = ServerPath::getimgpath($ve->img,$store_id);
                    }else{
                        $imgurl = '';
                    }
                    $son[$ke] = array('child_id' => $ve->cid,'name' => $ve->pname,'picture' => $imgurl);
                }
                $type = true;
            }else{
                $type =false;
            }
            if($value->bg){
                $cimgurl = ServerPath::getimgpath($value->bg,$store_id);
            }else{
                $cimgurl = '';
            }
            $icons[$key] = array('cate_id' => $value->cid,'cate_name' => $value->pname,'ishaveChild'=> $type,'children' => $son,'cimgurl' => $cimgurl);
        }

        echo json_encode(array('code'=>200,'List'=>$icons,'message'=>'成功'));
        exit;
    }

    public function listdetail(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID

        $id = trim($request->getParameter('cid')); //  '分类ID'
        $paegr = trim($request->getParameter('page')); //  '页面'

        if(!$paegr){
            $paegr = 1;
        }
        $start = ($paegr-1)*10;
        $end = 10;
        $sql0 = "select pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            $pname = $r0[0]->pname;
        }else{
            $pname = '';
        }

        if(empty($shop_id)){
            $sql = "select a.id,a.product_title,a.subtitle,a.imgurl,volume,min(c.price) as price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.active = 1 and a.status = 2 and a.mch_status = 2 and a.product_class like '%-$id-%' group by c.pid  order by a.search_num desc,a.add_date desc LIMIT $start,$end ";
        }else{
            $sql = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.active = 1 and a.mch_id = '$shop_id' and a.status = 2 and a.mch_status = 2 and a.product_class like '%-$id-%' group by c.pid  order by a.search_num desc,a.add_date desc LIMIT $start,$end";
        }
        $r = $db->select($sql);
        $product = array();

        if($r){
            foreach ($r as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->imgurl,$store_id);/* end 保存*/
                $names = ' '.$v->name . $v->color ;
                if($v->name == $v->color || $v->name == '默认'){
                    $names = '';
                }
                $product[$k] = array('id' => $v->id,'name' => $v->product_title . $names,'subtitle'=>$v->subtitle,'price' => $v->yprice,'price_yh' => $v->price,'imgurl' => $imgurl,'size'=>$v->sizeid,'volume' => $v->volume,'s_type' => $v->s_type);
            }
        }

        echo json_encode(array('code'=>200,'pro'=>$product,'pname'=>$pname,'message'=>'成功'));
        exit;
    }

    // 搜索
    public function search(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $type = trim($request->getParameter('type'));
        $keyword = trim($request->getParameter('keyword')); // 关键词
        $num = trim($request->getParameter('num')); //  '次数'

        $list = [];
        $start = 10*($num-1);
        $end = 10;
        if($type == '0'){
            //查出所有产品分类
            $sql = "select pname,cid from lkt_product_class where store_id = '$store_id' and recycle = 0";
            $res = $db -> select($sql);
            foreach ($res as $key => $value) {
                $types[$value -> pname] = $value -> cid;
            }
            if(array_key_exists($keyword, $types)){
                $cid = $types[$keyword];

                $sqlb = "select a.id,product_title,a.subtitle,a.imgurl,a.volume,a.s_type,c.id as cid,c.yprice,c.img,c.name,c.color,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.active = 1 and a.product_class like '%-$cid-%' and a.status = 2 and a.mch_status = 2 group by c.pid order by a.search_num desc,a.add_date desc  LIMIT $start,$end";
                $data = $db -> select($sqlb);
                if($data){
                    foreach ($data as $k => $v){
                        $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                        $list[] = $v;
                    }
                }
            }
//            else{   //如果不是商品分类名称，则直接搜产品
                $keyword = addslashes($keyword);
                $sqlb = "select a.id,a.product_title,a.subtitle,a.product_class,a.imgurl,a.volume,a.s_type,c.id as cid,c.yprice,c.img,c.name,c.color,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.active = 1 and (a.product_title like '%$keyword%' or a.keyword like '%$keyword%') and a.status = 2 and a.mch_status = 2 group by c.pid order by a.search_num desc,a.add_date desc LIMIT $start,$end";
                $data = $db -> select($sqlb);
                foreach ($data as $k => $v){
                    $sql = "update lkt_product_list set search_num = search_num+1 where id = '$v->id'";
                    $db->update($sql);
                }
//            }
            if($data){
                foreach ($data as $k => $v){
                    $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                    $list[] = $v;
                }
            }
        }else{
            $sql0 = "select id,name,logo,collection_num from lkt_mch where store_id = '$store_id' and review_status = 1 and name like '%$keyword%' order by collection_num desc LIMIT $start,$end";
            $r0 = $db->select($sql0);
            if($r0){
                foreach ($r0 as $k => $v){
                    $shop_id = $v->id; // 店主ID
                    $v->logo = ServerPath::getimgpath($v->logo,$store_id); // 店铺logo
                    $sql1 = "select id,product_class from lkt_product_list where store_id = '$store_id' and mch_id = '$shop_id' and mch_status = 2 and status = 2 and recycle = 0 and active = 1 order by search_num desc,add_date desc ";
                    $r1 = $db->select($sql1);
                    $v->quantity_on_sale = count($r1); // 在售数量

                    $quantity_sold = 0;
                    $sql2 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid ";
                    $r2 = $db->select($sql2);
                    if($r2){
                        foreach($r2 as $k1 => $v1){
                            $quantity_sold += $v1->volume;  // 已售数量
                        }
                    }
                    $v->quantity_sold = $quantity_sold;

                    $sql3 = "select id from lkt_user_collection where store_id = '$store_id' and mch_id = '$shop_id'";
                    $r3 = $db->select($sql3);
                    $v->follow = count($r3);

                    $list[] = $v;
                }
            }
        }

        echo json_encode(array('code'=>200,'data'=>$list,'message'=>'成功'));
        exit;
    }
    // 输入一部分，返回字符串全部
    public function input_search(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $type = trim($request->getParameter('type'));

        $keyword = trim($request->getParameter('keyword')); // 关键词
        $list = [];
        if($type == '0'){
            $sql1 = "select product_title from lkt_product_list where store_id = '$store_id' and recycle = 0 and a.active = 1 and product_title LIKE '%$keyword%' and status = 2 and mch_status = 1 order by search_num desc,add_date desc";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    $list[] = $v->product_title;
                }
            }

            $sql2 = "select keyword from lkt_product_list where store_id = '$store_id' and recycle = 0 and a.active = 1 and keyword LIKE '%$keyword%' and status = 2 and mch_status = 1 order by search_num desc,add_date desc";
            $r2 = $db->select($sql2);
            if($r2){
                foreach ($r2 as $k => $v){
                    $list[] = $v->keyword;
                }
            }

            $sql3 = "select pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and pname LIKE '%$keyword%' order by sort desc";
            $r3 = $db->select($sql3);
            if($r3){
                foreach ($r3 as $k => $v){
                    $list[] = $v->pname;
                }
            }
            $list = array_unique($list);
        }else{
            $sql0 = "select name from lkt_mch where store_id = '$store_id' and review_status = 1 and name like '%$keyword%' order by collection_num desc";
            $r0 = $db->select($sql0);
            if($r0){
                foreach ($r0 as $k => $v){
                    $list[] = $v->name;
                }
            }
        }

        echo json_encode(array('code'=>200,'data'=>$list,'message'=>'成功'));
        exit;
    }
    // 热门搜索
    public function hot_search(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $type = trim($request->getParameter('type'));

        $list = [];

        $sql = "select * from lkt_hotkeywords where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $is_open = $r[0]->is_open; // 是否开启
            $num = $r[0]->num; // 关键词上限
            $keyword = $r[0]->keyword; // 关键词
            $mch_keyword = $r[0]->mch_keyword; // 关键词
        }else{
            $is_open = 0;
        }
        if($type == '0'){
            if($is_open == 1){
                $keyword =explode(',',$keyword);
                if(count($keyword) < $num){
                    $num = count($keyword);
                }
                for ($i=0;$i<$num;$i++){
                    $list[] = $keyword[$i];
                }
            }else{
                $sql0 = "select keyword from lkt_product_list where store_id = '$store_id' and recycle = 0 and a.active = 1 and keyword != '' and num > 0 and status = 2 order by search_num desc,add_date desc limit 6";
                $r0 = $db->select($sql0);
                if($r0){
                    foreach ($r0 as $k => $v){
                        if($v->keyword){
                            $list[] = $v->keyword;
                        }
                    }
                }
                $list = array_unique($list);
            }
        }else{
            if($is_open == 1){
                $mch_keyword =explode(',',$mch_keyword);
                for ($i=0;$i<$num;$i++){
                    $list[] = $mch_keyword[$i];
                }
            }else{
                $sql0 = "select name from lkt_mch where store_id = '$store_id' and review_status = 1 order by collection_num desc limit 6";
                $r0 = $db->select($sql0);
                if($r0){
                    foreach ($r0 as $k => $v){
                        $list[] = $v->name;
                    }
                }
            }
        }

        echo json_encode(array('code'=>200,'data'=>$list,'is_open'=>$is_open,'message'=>'成功'));
        exit;
    }

    public function _getFirstCharter($str){
        if(empty($str)){return '';}
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return null;
    }
}

?>