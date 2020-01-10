<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/version.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class IndexAction extends Action{

    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @date 2018年1月2日
     * @version 1.0
     */
    
    public function getDateFromRange($startdate, $enddate){

        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);

        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;

        // 保存每天日期
        $date = array();

        for($i=0; $i<$days; $i++){
            $date[] = date('Y-m-d', $stimestamp+(86400*$i));
        }

        return $date;
    }
   //返回分页样式
    public function getPager($page,$pagesize,$startdate,$enddate,$store_id,$db){
        if($page){
            $start = ($page-1)*10;
        }else{
            $page = 1;
            $start = 0;
        }
        $pagesize = $pagesize ? $pagesize : 10;
        $sql2 = "select COUNT(*) as total from lkt_user where store_id = '{$store_id}' and Register_data between '{$startdate} 00:00:00' and '{$enddate} 23:59:59' order by Register_data desc";
        $res2 = $db->select($sql2);
        $total = intval($res2[0]->total);
        //实例化分页类
        $showpager=new ShowPager($total,$pagesize,$page);
        $offset=$showpager -> offset;//设置开始查询位置
        $url="index.php?module=report&action=Index&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate);
        //获得分页样式
        $pages_show=$showpager->multipage($url,$total,$page,$pagesize,$start,$para=''); 
        //获取元素内容
        $sql1 = "select id,user_name,Register_data,source from lkt_user where store_id = '$store_id' and Register_data between '{$startdate} 00:00:00' and '{$enddate} 23:59:59' order by Register_data desc limit $offset,$pagesize";
        $res1 = $db->select($sql1);
        $arr['page']=$pages_show;
        $arr['res']=$res1;
        return $arr;
        
    }
     //计算两天时间之差   $day1-------开始时间，$day2----------结束时间
    function diffBetweenTwoDays ($day1, $day2){
          $second1 = strtotime($day1);
          $second2 = strtotime($day2);
            
          if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
          }
          return ($second1 - $second2) / 86400;
    }


    public function getDefaultView(){
        //初始化
        $db=DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //接受时间参数

        $startdate = addslashes(trim($request->getParameter('startdate')));
        $enddate = addslashes(trim($request->getParameter('enddate')));
         //按分页显示数据
        //接受并设置分页类需要的参数
        $page=$request->getParameter('page');//页码
        $pagesize=$request->getParameter('pagesize');//每页个数
        


        //没有时间参数，默认返回七天的数据
        if(empty($startdate)||empty($enddate)){
            $enddate = date("Y-m-d");
            $startdate_1 = strtotime('-6 day');
            $startdate = date("Y-m-d",$startdate_1);

            $showpagers=$this->getPager($page,$pagesize,$startdate,$enddate,$store_id,$db);//截取时间之前获取分页内容
             //---------------------------------------------------------获取截取时间之前的每页数据
            $list=$showpagers['res'];
            // var_dump($list);
            //---------------------------------------------------------获取截取时间之前的分页样式
            $pages_show=$showpagers['page'];
            // var_dump($pages_show);

        }else{
            $showpagers=$this->getPager($page,$pagesize,$startdate,$enddate,$store_id,$db);//截取时间之前获取分页内容
            //---------------------------------------------------------获取截取时间之前的每页数据
            $list=$showpagers['res'];
            //---------------------------------------------------------获取截取时间之前的分页样式
            $pages_show=$showpagers['page'];
            $days=$this->diffBetweenTwoDays($startdate,$enddate);
            if($days>31){
                $enddate = $enddate;
                $startdate = date("Y-m-d",strtotime('-31 day'));
            } 

        }
        //时间段内，每日日期获取函数
        $day_arr=$this->getDateFromRange($startdate,$enddate);


       

        //查询时间段内每天的新增----------微信会员数
        $sql = "select COUNT(*) as sum,DATE_FORMAT(Register_data,'%Y-%m-%d') as rdate from lkt_user where store_id = '$store_id' and source = 1 group by rdate having rdate between '{$startdate}' and '{$enddate}' order by rdate desc ";
        $res_wx = $db->select($sql);
       
      
        //给日期数组中没有新增人数的日期，设置新增人数为0
        $sum_arr_wx=[];
        foreach ($day_arr as $k => $v) {
           $sum_arr_wx[$k] = 0;
        }
        foreach ($day_arr as $k => $v) {
            foreach ($res_wx as $k1 => $v1) {
                if($v == $v1->rdate){
                    $sum_arr_wx[$k] = intval($v1->sum);
                }
            }
        }

        $sum_arr_wx1 = json_encode($sum_arr_wx);

         //查询时间段内每天的新增----------app会员数
        $sql = "select COUNT(*) as sum,DATE_FORMAT(Register_data,'%Y-%m-%d') as rdate from lkt_user where store_id = '$store_id' and source = 2 group by rdate having rdate between '{$startdate}' and '{$enddate}' order by rdate desc ";
        $res_app = $db->select($sql);
       
      
        //给日期数组中没有新增人数的日期，设置新增人数为0
        $sum_arr_app=[];
        foreach ($day_arr as $k => $v) {
           $sum_arr_app[$k] = 0;
        }
        foreach ($day_arr as $k => $v) {
            foreach ($res_app as $k1 => $v1) {
                if($v == $v1->rdate){
                    $sum_arr_app[$k] = intval($v1->sum);
                }
            }
        }
        $sum_arr_app1 = json_encode($sum_arr_app);

        //将日期的年份去掉
        $day_arr_0=array();
        foreach ($day_arr as $k => $v) {
            $day_arr_0[$k] = substr($v,(strpos($v, '-')+1));
           
        }
        $day_arr = $day_arr_0;
     
        $day_arr1 = json_encode($day_arr);

       
       
        


      
       
       

        
        $request->setAttribute('day_arr',$day_arr1);
        $request->setAttribute('sum_arr_wx',$sum_arr_wx1);
        $request->setAttribute('sum_arr_app',$sum_arr_app1);
        $request->setAttribute('list',$list);
        $request->setAttribute('pages_show',$pages_show);
       


       
         

       
        
       
      
         return View :: INPUT;


        
    }
     public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }


}