<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class showPager {
    public $total_record; //记录总数
    public $pagesize; //每一页显示的记录数
    public $total_pages; //总页数
    public $cur_page; //当前页码
    public $offset; //记录偏移量
    public $_pernum = 10; //页码偏移量，这里可随意更改


    public function __construct($total, $pagesize, $cur_page) {
        $this->total_record = intval($total);
        $this->pagesize = intval($pagesize);
        $this->cur_page = intval($cur_page);
        $this->_count();
    }

    private function _count() //计算
    {
        if($this->total_record <= 0 || $this->pagesize <= 0){
            $this->total_record = 0;
            $this->pagesize = 0;
            $this->total_pages = 0;
            $this->cur_page = 0;
            $this->offset = 0;
            return;
        }
        $this->total_pages = ceil($this->total_record / $this->pagesize);
        if($this->cur_page < 1 || $this->cur_page > $this->total_pages ){
            $this->cur_page = 1;
        }
        $this->offset = ($this->cur_page - 1) * $this->pagesize;
    }

    //html数字连接的标签
    public function num_link($url) {
        if($this->total_pages == 0){
            return '';
        }
        if($this->total_pages == 1){
            return '';
        }
        $start = floor(($this->cur_page - 1) / $this->_pernum) * $this->_pernum + 1;
        $end = $start + $this->_pernum;
        $text[] = '共有 ' . $this->total_record . '条记录 | 当前' .$this->cur_page."/". $this->total_pages . '页';
        if($this->total_pages > $this->_pernum){
            if( $this->cur_page != 1){
                $text[] = "[<a class='page' href='index.php?{$url}&page=1'>首页</a>]";
            } else {
                $text[] = '[<a>首页</a>]';
            }
            $up = $start - $this->_pernum;
            if( $up > 0 ){
                $text[] = "[<a class='page' href='index.php?{$url}&page=$up'>←</a>]";
            } else {
                $text[] = '[<a>←</a>]';
            }
        }
        for($i = $start;$i<$end&&$i<=$this->total_pages;$i++){
            if($i != $this->cur_page){
                $text[] = "<a class='page' href='index.php?{$url}&page=$i'>$i</a>";
            } else {
                $text[] = "<a><strong>$i</strong></a>";
            }

        }
        if($this->total_pages > $this->_pernum){
            $down = $this->total_pages - $end;
            if($down >= 0){
                $text[] = "[<a class='page' href='index.php?{$url}&page=$end'>→</a>]";
            } else {
                $text[] = '[<a>→</a>]';
            }
            if($this->cur_page != $this->total_pages){
                $text[] = "[<a class='page' href='index.php?{$url}&page=" .
                    $this->total_pages . "'>尾页</a>]";
            } else {
                $text[] = '[<a>尾页</a>]';
            }
        }
        return implode(' ',$text);
    }

    /**
     * @param $maxpage  总页数
     * @param $page    当前页
     * @param string $para  翻页参数(不需要写$page),如http://www.example.com/article.php?page=3&id=1，$para参数就应该设为'&id=1'
     * @return string  返回的输出分页html内容
     */
    function multipage($url,$total, $page,$pagesize,$start, $para = '') {
        if ($start > $total) {
            $page = 1;
            $start = 0;
        }
    	if($total <= 10){
    		return '';    	
    	}
        $maxpage = ceil($total/$pagesize);
        $end = $start+$pagesize;
        $start = $start+1;

        if($end >= $total){
            $end = $total;
        }
        if($page == ''){
            $page = 1;
        }
        $multipage = '';  //输出的分页内容
        $listnum = 5;     //同时显示的最多可点击页面
        if($maxpage == 0){ // 最大页码等于0时
            $multipage = '';
        }else if($maxpage <= 7 && $maxpage > 0){ // 当最大页码低于或等于5页,并且大于0时
            if($page == 1){ // 当页码为第一页时，上一页点击不能跳转
                $multipage .= "";
            }else{ // 当页码不为第一页，上一页点击跳转
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page - 1).$para."'\' >上一页</a></li>";
            }
            for($i = 1; $i <= $maxpage; $i++) {
                $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>';
            }
            if($page == $maxpage){
                $multipage .= "";
            }else{
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page + 1).$para."'\' >下一页</a></li>";
            }
        }else{ // 当最大页码大于5页时
            if($page < 5){ // 当前页低于5时
                if($page == 1){ // 当页码为第一页时，上一页点击不能跳转
                    $multipage .= "";
                }else{ // 当页码不为第一页，上一页点击跳转
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page - 1).$para."'\' >上一页</a></li>";
                }
                for($i = 1; $i <= 5; $i++) {
                    $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>';
                }
                $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                    "<li style='padding: 0px 2px;'><a href='$url&page=".($maxpage).$para."'\' >$maxpage</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page + 1).$para."'\' >下一页</a></li>";
            }else if($maxpage - $page < 5){ // 当最大页码-当前页<5时
                $i_page = $maxpage - $page;
                if($i_page > 3){
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page - 1).$para."'\' >上一页</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a href='$url&page=".(1).$para."'\' >1</a></li>".
                        "<li style='padding: 0px 2px;'>...</li>";
                    for($i = $page-1; $i <= $page+1; $i++) {
                        $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>';
                    }
                    $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                        "<li style='padding: 0px 2px;'><a href='$url&page=".($maxpage).$para."'\' >$maxpage</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page + 1).$para."'\' >下一页</a></li>";
                }else{
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page - 1).$para."'\' >上一页</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a href='$url&page=".(1).$para."'\' >1</a></li>".
                        "<li style='padding: 0px 2px;'>...</li>";
                    for($i = $maxpage-4; $i <= $maxpage; $i++) {
                        $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>';
                    }
                    if($page == $maxpage){
                        $multipage .= "";
                    }else{
                        $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page + 1).$para."'\' >下一页</a></li>";
                    }
                }
            }else{
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page - 1).$para."'\' >上一页</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a href='$url&page=".(1).$para."'\' >1</a></li>".
                    "<li style='padding: 0px 2px;'>...</li>";
                for($i = $page-1; $i <= $page+1; $i++) {
                    $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a href='$url&page=".$i.$para.'\' >'.$i.'</a></li>';
                }
                $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                    "<li style='padding: 0px 2px;'><a href='$url&page=".($maxpage).$para."'\' >$maxpage</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' href='$url&page=".($page + 1).$para."'\' >下一页</a></li>";
            }
        }
        $db = DBAction::getInstance();
        $select = Tools::data_dictionary($db,'分页',$pagesize);

        if($multipage){
            $multipage = '<div class="paginationDiv"> <div class="changePaginationNum">显示
            	<select id="ajaxSe">'.$select.'</select>
            	条</div> <div class="showDataNum">显示 '.$start.' 到 '.$end.' ，共 '.$total.' 条</div><ul class="pagination"><li class=""></li>'.$multipage.'<li></li></ul><div class="clearfix"></div></div>';
        }else{
            $multipage = '<div class="paginationDiv"> <div class="changePaginationNum">显示
            	<select id="ajaxSe">'.$select.'</select>
            	条</div> <div class="showDataNum">显示 '.$start.' 到 '.$end.' ，共 '.$total.' 条</div><div class="clearfix"></div></div>';
        }
        return $multipage;
    }

    function multipage1($url,$total, $page,$pagesize,$start, $para = '') {
        if($total <= 1){
            return '';
        }
        $maxpage = ceil($total/$pagesize);
        $end = $start+$pagesize;
        $start = $start+1;

        if($end >= $total){
            $end = $total;
        }
        if($page == ''){
            $page = 1;
        }
        $multipage = '';  //输出的分页内容
        $listnum = 5;     //同时显示的最多可点击页面
        if($maxpage == 0){ // 最大页码等于0时
            $multipage = '';
        }else if($maxpage <= 7 && $maxpage > 0){ // 当最大页码低于或等于5页,并且大于0时
            if($page == 1){ // 当页码为第一页时，上一页点击不能跳转
                $multipage .= "";
            }else{ // 当页码不为第一页，上一页点击跳转
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page - 1).$para."') >上一页</a></li>";
            }
            for($i = 1; $i <= $maxpage; $i++) {
                $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>" : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>";
            }
            if($page == $maxpage){
                $multipage .= "";
            }else{
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page + 1).$para."') >下一页</a></li>";
            }
        }else{ // 当最大页码大于5页时
            if($page < 5){ // 当前页低于5时
                if($page == 1){ // 当页码为第一页时，上一页点击不能跳转
                    $multipage .= "";
                }else{ // 当页码不为第一页，上一页点击跳转
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page - 1).$para."') >上一页</a></li>";
                }
                for($i = 1; $i <= 5; $i++) {
                    $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>" : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>";
                }
                $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                    "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".($maxpage).$para."') >$maxpage</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page + 1).$para."') >下一页</a></li>";
            }else if($maxpage - $page < 5){ // 当最大页码-当前页<5时
                $i_page = $maxpage - $page;
                if($i_page > 3){
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page - 1).$para."') >上一页</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".(1).$para."') >1</a></li>".
                        "<li style='padding: 0px 2px;'>...</li>";
                    for($i = $page-1; $i <= $page+1; $i++) {
                        $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>" : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>";
                    }
                    $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                        "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".($maxpage).$para."') >$maxpage</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page + 1).$para."') >下一页</a></li>";
                }else{
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page - 1).$para."') >上一页</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".(1).$para."') >1</a></li>".
                        "<li style='padding: 0px 2px;'>...</li>";
                    for($i = $maxpage-4; $i <= $maxpage; $i++) {
                        $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>" : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>";
                    }
                    if($page == $maxpage){
                        $multipage .= "";
                    }else{
                        $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page + 1).$para."') >下一页</a></li>";
                    }
                }
            }else{
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page - 1).$para."') >上一页</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".(1).$para."') >1</a></li>".
                    "<li style='padding: 0px 2px;'>...</li>";
                for($i = $page-1; $i <= $page+1; $i++) {
                    $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>" : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".$i.$para."') >".$i."</a></li>";
                }
                $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                    "<li style='padding: 0px 2px;'><a onclick=tiaozhuan('$url&page=".($maxpage).$para."') >$maxpage</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan('$url&page=".($page + 1).$para."') >下一页</a></li>";
            }
        }
        $db = DBAction::getInstance();
        $select = Tools::data_dictionary($db,'分页',$pagesize);

        if($multipage){
            $multipage = '<div class="paginationDiv"> <div class="changePaginationNum">显示
                <span>3</span>
            	条</div> <div class="showDataNum">显示 '.$start.' 到 '.$end.' ，共 '.$total.' 条</div><ul class="pagination"><li class=""></li>'.$multipage.'<li></li></ul><div class="clearfix"></div></div>';
        }else{
            $multipage = '<div class="paginationDiv"> <div class="changePaginationNum">显示
                <span>3</span>
            	条</div> <div class="showDataNum">显示 '.$start.' 到 '.$end.' ，共 '.$total.' 条</div><div class="clearfix"></div></div>';
        }
        return $multipage;
    }
    function multipage2($url,$total, $page,$pagesize,$start, $para = '') {
        if($total <= 1){
            return '';
        }
        $maxpage = ceil($total/$pagesize);
        $end = $start+$pagesize;
        $start = $start+1;

        if($end >= $total){
            $end = $total;
        }
        if($page == ''){
            $page = 1;
        }
        $multipage = '';  //输出的分页内容
        $listnum = 5;     //同时显示的最多可点击页面
        if($maxpage == 0){ // 最大页码等于0时
            $multipage = '';
        }else if($maxpage <= 7 && $maxpage > 0){ // 当最大页码低于或等于5页,并且大于0时
            if($page == 1){ // 当页码为第一页时，上一页点击不能跳转
                $multipage .= "";
            }else{ // 当页码不为第一页，上一页点击跳转
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page - 1).$para."') >上一页</a></li>";
            }
            for($i = 1; $i <= $maxpage; $i++) {
                $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>';
            }
            if($page == $maxpage){
                $multipage .= "";
            }else{
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page + 1).$para."') >下一页</a></li>";
            }
        }else{ // 当最大页码大于5页时
            if($page < 5){ // 当前页低于5时
                if($page == 1){ // 当页码为第一页时，上一页点击不能跳转
                    $multipage .= "";
                }else{ // 当页码不为第一页，上一页点击跳转
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page - 1).$para."'\') >上一页</a></li>";
                }
                for($i = 1; $i <= 5; $i++) {
                    $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>';
                }
                $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                    "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".($maxpage).$para."'\') >$maxpage</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page + 1).$para."'\') >下一页</a></li>";
            }else if($maxpage - $page < 5){ // 当最大页码-当前页<5时
                $i_page = $maxpage - $page;
                if($i_page > 3){
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page - 1).$para."'\') >上一页</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".(1).$para."'\') >1</a></li>".
                        "<li style='padding: 0px 2px;'>...</li>";
                    for($i = $page-1; $i <= $page+1; $i++) {
                        $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>';
                    }
                    $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                        "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".($maxpage).$para."'\') >$maxpage</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page + 1).$para."'\') >下一页</a></li>";
                }else{
                    $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page - 1).$para."'\') >上一页</a></li>";
                    $multipage .= "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".(1).$para."'\') >1</a></li>".
                        "<li style='padding: 0px 2px;'>...</li>";
                    for($i = $maxpage-4; $i <= $maxpage; $i++) {
                        $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>';
                    }
                    if($page == $maxpage){
                        $multipage .= "";
                    }else{
                        $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page + 1).$para."'\') >下一页</a></li>";
                    }
                }
            }else{
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page - 1).$para."'\') >上一页</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".(1).$para."'\') >1</a></li>".
                    "<li style='padding: 0px 2px;'>...</li>";
                for($i = $page-1; $i <= $page+1; $i++) {
                    $multipage .= $i == $page ? "<li class='active' style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>' : "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".$i.$para.'\') >'.$i.'</a></li>';
                }
                $multipage .= "<li style='padding: 0px 2px;'>...</li>".
                    "<li style='padding: 0px 2px;'><a onclick=tiaozhuan1('$url&page=".($maxpage).$para."'\') >$maxpage</a></li>";
                $multipage .= "<li style='padding: 0px 2px;'><a style='width:80px' onclick=tiaozhuan1('$url&page=".($page + 1).$para."'\') >下一页</a></li>";
            }
        }
        $db = DBAction::getInstance();
        $select = Tools::data_dictionary($db,'分页',$pagesize);

        if($multipage){
            $multipage = '<div class="paginationDiv"> <div class="changePaginationNum">显示
            	<select id="ajaxSe">'.$select.'</select>
            	条</div> <div class="showDataNum">显示 '.$start.' 到 '.$end.' ，共 '.$total.' 条</div><ul class="pagination"><li class=""></li>'.$multipage.'<li></li></ul><div class="clearfix"></div></div>';
        }else{
            $multipage = '<div class="paginationDiv"> <div class="changePaginationNum">显示
            	<select id="ajaxSe">'.$select.'</select>
            	条</div> <div class="showDataNum">显示 '.$start.' 到 '.$end.' ，共 '.$total.' 条</div><div class="clearfix"></div></div>';
        }
        return $multipage;
    }
}
?>