<?php  
require_once(MO_LIB_DIR . '/DBAction.class.php');

class distribution
{
    public $store_id = null;   //公共属性,商户id
    public $db = null;   //公共属性,db实例
    public $user_id = null;   //公共属性,用户id
    /**
     * 分消方法封装
     * @param   $store_id string 商户号
     * @param   $sNo string 订单号    
     * @param   $user_id string 用户id       
     */
    public function distri($store_id,$sNo,$user_id)
    {
        $db = DBAction::getInstance();
        $this -> store_id = $store_id;
        $this -> db = $db;
        $this -> user_id = $user_id;

        //--------分销开关--------
        $sqlldc = "select * from lkt_distribution_config where store_id = '$store_id' ";
        $res_ldc = $db->select($sqlldc);
        $ldc_sets = unserialize($res_ldc[0]->sets);
        $c_cengji = $ldc_sets['c_cengji'];
        if($c_cengji < 1){
            return false;
        }

        //开启事务
        $db->begin();

        //查询用户是否是会员
        $userd = $this->find_fenxiao($user_id);
        
        if($userd){   //有记录说明有推荐人
           $lt = $jben_res->lt;
           $rt = $jben_res->rt;
           //查询订单中是否有会员产品
            $sql01 = "select lo.z_price,lo.user_id,lod.p_price,lod.p_id from lkt_order_details as lod LEFT JOIN lkt_order as lo ON lo.sNo = lod.r_sNo where lod.store_id = '$store_id' and lod.r_sNo = '$sNo' and lod.r_status not in(0,4) and EXISTS(select l.id from lkt_product_list as l where l.is_distribution=1 and l.id=lod.p_id and l.store_id = '$store_id')";
            $rew = $db->select($sql01);
            if($rew) {     //有会员产品
                $z_price = $rew[0]->z_price;   //得到实付款金额            
                $isup = $this -> isuplevel($user_id);
                if($isup == true){    //符合条件,升级
                     
                }
            }else{         //没有买会员产品

            }
            $yongjin = $this->jc_distribution($lt, $rt, $user_id, $z_price, $sNo,$c_cengji);      //发放基本佣金

        }           
           $db->commit();
    }

    public function userup() {
        
    }
    
    /**
     * 获取用户升级条件
     * @param   $user_id string 用户id
     * return   用户返回bool,是否升级.      
     */
    public function isuplevel($user_id){
        $store_id = $this -> store_id;
        $db = $this -> db;
        
        $grade = $this -> getgrade();
        $userd = $this->find_fenxiao($user_id);
        
        $xfsql = "select sum(z_price) as xf from lkt_order where store_id = '$store_id' and user_id='$user_id'";
        $xfres = $db -> select($xfsql);            //查询用户累计消费
        if($xfres){
            $xfres = floatval($xfres[0] -> xf);
        }else{
            $xfres = 0;
        }
        if($userd){
            $ulevel = intval($userd -> level);
            // lt
            $lt = $userd->lt;
            // rt
            $rt = $userd->rt;
            // 分销层级
            $level = $userd->uplevel;
        }else{
            $ulevel = 0;
        }
        if($ulevel > 0){            //会员用户
            $upcondition = null;
            //查询用户下一等级条件
            foreach ($grade as $k => $v) {
                if($ulevel == $v["levelid"]){
                    if(isset($grade[$k+1])){        //如果存在下一等级则赋值
                        $upcondition = $grade[$k+1];
                    }
                }
            }
            
            if($upcondition != null){   //有上升空间
               if(isset($upcondition['manybuy'])){            //下一等级如果有累计消费要求,则比较是否完成
                  if($xfres < intval($upcondition['manybuy'])){
                     return false;
                  }
               }
               $dowpuser = $this -> getdowpusers($lt,$rt,$level,$cengji);
               if(isset($upcondition['manyyeji'])){           //下一等级如果有累计业绩要求,则查询后比较
                  list($yeji,$cengji) = explode(',',$upcondition['manyyeji']);   //用两个变量装载数额和层级限定
                 
                    $dowpuser = $dowpuser . "'$user_id'";    //拼接上自已的id查业绩
                     $sql = "select sum(CAST(d.p_price*d.num AS DECIMAL(8,2))) as sum from lkt_order_details as d where d.store_id = '$store_id' and user_id in($dowpuser) and EXISTS(select * from lkt_product_list as p where p.store_id = '$store_id' and p.id=d.p_id and p.is_distribution=1)";
                     $teamyeji = $db -> select($sql);
                     $teamyeji = $teamyeji[0] -> sum;
                     if($teamyeji < $yeji){                 //业绩没达到
                        return false;
                     }              
               }
               if(isset($upcondition['manypeople'])){        //下一等级如果有团队人数要求
                  list($teamnum,$cengji) = explode(',',$upcondition['manypeople']);
                  if($dowpuser != ''){      //有下线
                      $dowparr = explode(',',$dowpuser);
                      $team = count($dowparr);
                  }else{
                      $team = 1;
                  }
                  if($team < $teamnum){
                    return false;                        //团队人数没达到
                  }
               }
               return true;   
            }else{           //没有上升空间
                return false;
            }
                   
        }else{                 //普通用户
            $levelid = 0;
            $gradelen = count($grade);
            //按等级从低往高找,直到不符合条件为止
            if($gradelen > 0){
    //             $i = 0;
    // 　　　　　　while($i<=$gradelen){
    //                if(isset($grade[$i]['manyyeji']) || isset($grade[$i]['manypeople']) || (isset($grade[$i]['manybuy']) && $xfres < intval($grade[$i]['manybuy']))){
    //                    $levelid = $grade[$i]['levelid'];
    //                    break;
    //                }
    //                $i++;
    //                $levelid = $gradelen;
    //            }
               return  true;
            }else{
               return  false; 
            }
        }

    }
    
    /**
     * 获取一个用户的所有下线用户
     * @param   $lt int 用户id
     * @param   $rt int 用户id
     * @param   $uplevel int 当前第几代
     * @param   $cengji int 需要获取的层级
     * return   下线用户数组集合 
     */
    public function getdowpusers($lt, $rt,$uplevel,$cengji){
        $store_id = $this -> store_id;
        $db = $this -> db;
        $uplevel = $uplevel + $cengji;
        $sqlxj = "select * from lkt_user_distribution where store_id = '$store_id' and lt>'$lt' and rt<'$rt' and uplevel <= '$uplevel' ";
        $obj = $db -> select($sqlxj);      
        $users = '';
        if($obj){
           foreach($obj as $v){
             $users .= "'" . $v -> user_id . "',";
           }
           //$users = trim($users,',');
        }
         return $users;    
    }

    public function getgrade(){         //获取当前升级条件
       $store_id = $this->store_id;
       $db = $this->db;
       $qsql = "select id,sets from lkt_distribution_grade where store_id = '$store_id' order by sort asc";
       $qres = $db->select($qsql);
       $grade = array();
       if($qres){       
         foreach ($qres as $k => $v) {
            $sets = unserialize($v->sets);
            $levelobj = $sets['levelobj'];
            $levelobj['levelid'] = $v -> id;
            $grade[] = $levelobj;
         }
         ksort($grade);    //排好序
       }
       return $grade;
    }

    //创建分销等级和会员信息
    public function create_level($db, $user_id, $distributor_id)
    {
        $store_id = $this->store_id;
        $t_user_id = '0';
        //初始会员
        $sqlc = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$t_user_id'";
        $resc = $db->select($sqlc);
        //分销推荐
        if ($resc) {
            $sqlqw = "select user_id from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
            $resqw = $db->select($sqlqw);
            if (!$resqw) {
                $rt = $resc[0]->rt;
                $level = $distributor_id;
                $uplevel = $resc[0]->uplevel + 1;
                $ups01 = "update lkt_user_distribution set lt = lt + 2 where store_id = '$store_id' and lt>='$rt'";
                $ups02 = "update lkt_user_distribution set rt = rt + 2 where store_id = '$store_id' and rt>='$rt'";
                $lrt = $rt + 1;
                $ups03 = "INSERT INTO lkt_user_distribution ( `store_id`,`user_id`, `pid`, `level`, `lt`, `rt`, `uplevel`, `add_date`) VALUES ( '$store_id','$user_id', '$t_user_id', '$level', '$rt', '$lrt', '$uplevel', CURRENT_TIMESTAMP)";
                $beres1 = $db->update($ups01);
                $beres2 = $db->update($ups02);
                $beres3 = $db->insert($ups03);
                //事务
                if ($beres3 < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:30', 'sql' => $ups03 . $ups01 . $ups02));
                    exit;
                }
            }
        }
    }


    //基本分销佣金发放
    public function jc_distribution($lt, $rt, $user_id, $price, $sNo,$c_cengji)
    {
        $db = $this -> db;
        $store_id = $this->store_id;
        $c_cengji = intval($c_cengji);
        //基本分销佣金发放
        $sqlxj = "select * from lkt_user_distribution as lud LEFT JOIN lkt_distribution_grade as ldg ON ldg.id = lud.level where lud.store_id = '$store_id' and lud.lt<'$lt' and lud.rt>'$rt' ORDER BY lud.uplevel desc LIMIT 0,$c_cengji ";
        $obj = $db->select($sqlxj);
        //查找和发放分销佣金
        $code = 1;
        if(!empty($obj)){
        
        foreach ($obj as $key => $value) {
            $lsets = unserialize($value->sets);
            $bili = $lsets['levelmoney'];
            $luser = $value->user_id;
            if ($luser) {
                $price_type = $lsets['price_type'];
                if ($price_type) {
                    $yj = $bili[$key+1];
                } else {
                    $yj = $price * $bili[$key+1] / 100;
                }
                //写入佣金记录表
                if ($yj) {
                    $sql = "update lkt_user set money = money+'$yj' where store_id = '$store_id' and user_id = '$luser'";
                    $beres = $db->update($sql);
                    //事务
                    if ($beres < 1) {
                        $code = 0;
                        return $code;
                    }
                    //发钱 写记录
                    $event = $luser . '获得了' . $yj . '元佣金 ' . $sNo;
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$luser','$yj','$price','$event',7)";
                    $beres = $db->insert($sqll);
                    //事务
                    if ($beres < 1) {
                        $code = 0;
                        return $code;
                    }
                    //佣金表
                    $ldr_level = $key + 1;
                    $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$luser','$user_id','$yj','$sNo','$ldr_level','$event','1',CURRENT_TIMESTAMP)";
                    $beres = $db->insert($sqlldr);
                    //事务
                    if ($beres < 1) {
                        $code = 0;
                        return $code;
                    }
                }
            }
         }

       }
       return $code;
        //基础分销佣金发放完毕
    }

    //便携查找分销员信息
    public function find_fenxiao($user_id)
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $sql = "select g.*,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where d.store_id = '$store_id' and d.user_id = '$user_id' ";
        $res = $db->select($sql);
        if ($res) {
            return $res[0];
        } else {
            return false;
        }

    }

    // 对比等级发放佣金和消费金 *高推低按低  低推高按照本等级*-------------05
    public function contrast_rating($db, $contrast_id, $user_id, $from_id, $sNo, $r_f, $qid, $paixu, $price)
    {
        $store_id = $this->store_id;
        //查找等级比例
        $r_d = $this->find_fenxiao($db, $contrast_id);
        if ($r_d) {
            $cmoneys = [];
            //会员佣金
            $member_proportion_str = $r_d->member_proportion;
            $member_Arr = explode(',', $member_proportion_str);
            if ($member_Arr) {
                foreach ($member_Arr as $ka => $va) {
                    if ($va > 1) {
                        $cmoney = $va;
                    } else {
                        $cmoney = $price * $va;
                    }
                    $cmoneys[$ka] = $cmoney;
                }
            } else {
                $cmoneys[0] = $member_proportion_str;
            }

            

            $cmoney = $cmoneys[0];//佣金
            $shaosje = $cmoneys[0];


            //如果是分销商的话 就设置id
            if ($r_f->level == $qid) {
                $this->find_partner('区域管理佣金', $db, $sNo, $user_id, $user_id, $qid, $cmoney, 0.1);
            }

            $sql = "update lkt_user set money = money+'$cmoney' where store_id = '$store_id' and user_id = '$user_id'";
            $db->update($sql);

            //写日志
            $event = $user_id . '获得了' . $cmoney . '元推荐人佣金--- code:12';
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$cmoney','$cmoney','$event',7)";
            $beres = $db->insert($sqll);
            //事务
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:13'));
                exit;
            }
            //佣金表
            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$cmoney','$sNo','1','$event','1',CURRENT_TIMESTAMP)";
            $beres = $db->insert($sqlldr);
            //事务
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:14'));
                exit;
            }

            $shangji_id2 = $r_f->pid;
            $r_ff = $this->find_fenxiao($db, $shangji_id2);
            if ($r_ff) {
                $sort02 = $r_ff->sort;
                $cmoney_users = '';
                //判断购买人和上级的等级
                if ($sort02 > $paixu) {
                    $cmoney_users = $from_id;
                } else {
                    $cmoney_users = $shangji_id2;
                }
                //推荐人上级佣金发放
                if ($shangji_id2) {
                    $this->contrast_fating($db, $cmoney_users, $shangji_id2, $from_id, $sNo, $r_ff, $qid, $paixu);
                }
            }

        }
    }

    //推荐人上级佣金发放
    public function contrast_fating($db, $contrast_id, $user_id, $from_id, $sNo, $r_f, $qid, $paixu)
    {
        $store_id = $this->store_id;
        //查找等级比例
        $r_d = $this->find_fenxiao($db, $contrast_id);
        if ($r_d) {
            $cmoneys = [];
            //会员佣金
            $member_proportion_str = $r_d->member_proportion;
            $member_Arr = explode(',', $member_proportion_str);
            if ($member_Arr) {
                foreach ($member_Arr as $ka => $va) {
                    if ($va > 1) {
                        $cmoney = $va;
                    } else {
                        $cmoney = $price * $va;
                    }
                    $cmoneys[$ka] = $cmoney;
                }
            } else {
                $cmoneys[0] = $member_proportion_str;
            }

            $cmoney = $cmoneys[0];//佣金
            $shaosje = $cmoneys[0];

            //如果是分销商的话 就设置id
            if ($r_f->level == $qid) {
                $this->find_partner('区域管理佣金', $db, $sNo, $user_id, $user_id, $qid, $cmoneys[0], 0.1);
            }

            if (isset($cmoneys[1])) {

                $cmoney1 = $cmoneys[1];
                $sql = "update lkt_user set money = money+'$cmoney1' where store_id = '$store_id' and user_id = '$user_id'";
                $beres = $db->update($sql);

                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:22'));
                    exit;
                }

                //写日志
                $event = $user_id . '获得了' . $cmoney1 . '元荐人上级的佣金 code:23';
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$cmoney1','$cmoney1','$event',7)";
                $beres = $db->insert($sqll);
                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:24'));
                    exit;
                }
                //佣金表
                $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$cmoney1','$sNo','2','$event','1',CURRENT_TIMESTAMP)";
                $beres = $db->insert($sqlldr);
                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:25'));
                    exit;
                }
            }

        }
    }

    //对比上级 按照实际情况发放佣金和消费金
    public function contrast_level($shangji_id, $user_id, $db, $distributorid, $sNo, $qid, $price)
    {
        $store_id = $this->store_id;
        //查找推荐人 返佣金
        $r_f = $this->find_fenxiao($db, $shangji_id);
        //查询购买人自己所在的分销等级和排序号
        $r_u = $this->find_fenxiao($db, $user_id);
        $cmoney = 0;
        //记录烧伤金额
        $shaosje = 0;

        if ($r_f) {
            //推荐人消费金变现------------------------06
            $paixu_1 = $r_f->sort;//推荐人的排序号
            $paixu = $r_u->sort;    //购买人的排序号
            if ($paixu_1 >= $paixu) {
                //消费金转余额
                //$this->realization_consumer($db, $user_id, $shangji_id, $user_id, $sNo, $price);
                //发放佣金
                $this->contrast_rating($db, $user_id, $shangji_id, $user_id, $sNo, $r_f, $qid, $paixu, $price);
            } else {
                //消费金转余额
                //$this->realization_consumer($db, $shangji_id, $shangji_id, $user_id, $sNo, $price);
                //发放佣金
                $this->contrast_rating($db, $shangji_id, $shangji_id, $user_id, $sNo, $r_f, $qid, $paixu, $price);
            }
            //推荐人消费金变现结束------------------------06
        }

        //--------烧伤佣金开关--------
        $sqlldc = "select * from lkt_distribution_config where store_id = '$store_id' ";
        $res_ldc = $db->select($sqlldc);
        $ldc_sets = unserialize($res_ldc[0]->sets);
        $partner_burn = $ldc_sets['partner_burn'];

        if ($partner_burn) {
            //2.在根据id判断是否是代理商
            if ($distributorid == $qid) {
                //3.如果是的话 就查找上级最近的一个代理商
                $sjqydl = $this->quyudaili($shangji_id, $qid, $db);
                if ($sjqydl) {
                    //4.然后把原本的钱减去烧伤的钱发放给上级代理商
                    $sql_ersan = "select g.member_proportion from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_product_list as lpl ON lpl.distributor_id = g.id where d.store_id = '$store_id' and d.user_id = '$sjqydl' ";
                    $r_san = $db->select($sql_ersan);
                    $member_proportion_str = $r_san[0]->member_proportion;
                    $member_Arr = explode(',', $member_proportion_str);
                    $ssyj = [];
                    foreach ($member_Arr as $ka => $va) {
                        if ($va > 1) {
                            $cmoney = $va;
                        } else {
                            $cmoney = $price * $va;
                        }
                        $ssyj[$ka] = $cmoney;
                    }
                    //查询 原本代理商 的一级佣金
                    $shprice = $ssyj[0] - $shaosje;
                    if ($shprice > 0) {
                        // 判断用户是否存在
                        if ($db->select("select id from lkt_user where store_id = '$store_id' and user_id = '$sjqydl'")) {
                            $sql = "update lkt_user set money = money+'$shprice' where store_id = '$store_id' and user_id = '$sjqydl'";
                            $beres = $db->update($sql);
                            //事务
                            if ($beres < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:38', 'sql' => $sql));
                                exit;
                            }
                            $event = $sjqydl . '获得了' . $shprice . '元代理商烧伤佣金' . $ssyj[0] . '---' . $shaosje;
                            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$sjqydl','$user_id','$shprice','$sNo','5','$event','1',CURRENT_TIMESTAMP)";
                            $beres = $db->insert($sqlldr);

                            $ref_t = $this->find_partner('代理商烧伤佣金', $db, $sNo, $sjqydl, $sjqydl, $qid, $shprice, 0.1);
                            //事务
                            if ($beres < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:39', 'sql' => $sqlldr));
                                exit;
                            }
                        }

                    }
                }
            }

        }
    }

    //等级升级
    public function grade_upgrading($db, $distributorid, $user_id, $sNo, $info_user, $order_detail, $qid, $price)
    {
        $store_id = $this->store_id;
        //检查是否该用户是否是分销商
        if ($info_user) {
            $tj_id = $info_user->pid;//推荐人id
            $sets = unserialize($info_user->sets); //反序列化出提成比例数组
            $lt = $info_user->lt;
            $rt = $info_user->rt;
            $uplevel = $info_user->uplevel;// 分销层级
            $num = [$sets['b_yi'], $sets['b_er'], $sets['b_san']];// 三级的比例

            //------------------------------------关键部分------------------------------------

            //送消费金,积分-------02
            
            $integral = $info_user->integral;
            if ($integral > 0) {
                $sql = "update lkt_user set score = score+'$integral' where store_id = '$store_id' and user_id = '$user_id'";
                $beres = $db->update($sql);
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:41', 'sql' => $sql));
                    exit;
                }
                $event = "会员" . $user_id . "充值了" . $integral . "积分";
                //类型 1:转入(收入) 2:提现 3:管理佣金 4:使用消费金 5收入消费金 6 系统扣款 7:充值积分 8使用积分
                $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$user_id','$integral','$sNo','0','$event','8',CURRENT_TIMESTAMP)";
                $beres = $db->insert($sqlldr);
                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:42', 'sql' => $sqlldr));
                    exit;
                }

                $sqll = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$integral','$event',CURRENT_TIMESTAMP,6)";
                $beres = $db->insert($sqll);                              //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:43', 'sql' => $sqll));
                    exit;
                }

            }
        } else {
            //不是分销商
            $db->rollback();
            echo json_encode(array('status' => 0, 'err' => '参数错误 不是分销商 code:47'));
            exit;
        }
        //消费金转余额------------05

    }
    
}


?>