<?php

//小程序界面控制和界面路径

class Navbar{
	//加密
    public function encode($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
    //解密
    public function decode($value)
    {
        $res = json_decode($value, true);
        if ($res === null) {
            if (json_last_error() == JSON_ERROR_NONE) {
                return $res;
            }
            if (json_last_error() != JSON_ERROR_SYNTAX) {
                $error = json_last_error_msg();
            }
            // var_dump($value);exit;
            $res = unserialize($value);
            if ($res === false) {
                $value = preg_replace_callback(
                    '/s:([0-9]+):\"(.*?)\";/',
                    function ($matches) {
                        return "s:" . strlen($matches[2]) . ':"' . $matches[2] . '";';
                    },
                    $value
                );
                $res = unserialize($value);
            }
        }
        if (!is_object($res) && !is_array($res)) {
            return $res;
        }

    }	

    /**
     * 去除账号没有权限的链接
     * @param $link
     * @param $userAuth
     * @return mixed
     */
    public function resetPickLink($link, $userAuth)
    {
        $newData = [];
        foreach ($link as $k => $item) {
            // if (isset($item['sign']) == false || in_array($item['sign'], $userAuth) == true) {
            $newData[] = $item;
            // }
        }
        return $newData;
    }

    
    /**
     * 底部导航可选的链接
     * @return array
     */
    public function navLink()
    {
        return [
            [
                'name' => '首页',
                'url' => '/pages/index/index',
                'params' => []
            ],
            [
                'name' => '分类',
                'url' => '/pages/listdetail/listdetail?title=分类',
                'params' => [
                    [
                        'key' => "class",
                        'value' => "",
                        'desc' => "class请填写在商品分类中相关分类的ID"
                    ]
                ]
            ],
            [
                'name' => '购物车',
                'url' => '/pages/cart/cart',
                'params' => []
            ],
            [
                'name' => '用户中心',
                'url' => '/pages/user/user',
                'params' => []
            ],
            [
                'name' => '新品',
                'url' => '/pages/new/new',
                'params' => []
            ],
            [
                'name' => '搜索',
                'url' => '/pages/search/search',
                'params' => []
            ],
            [
                'sign' => 'pintuan',
                'name' => '拼团',
                'url' => '/pages/group_buy/group',
                'params' => [],
            ],
            [
                'sign' => 'pintuan',
                'name' => "我的拼团",
                'url' => "/pages/order/order?currentTab=0&otype=pay6",
                'params' => []
            ],
            [
                'sign' => 'share',
                'name' => '分销中心',
                'url' => '/pages/distribution/core',
                'params' => []
            ],
            [
                'name' => '客服',
                'url' => 'contact',
                'open_type' => 'contact',
                'params' => []
            ],
            [
                'sign' => 'integralmall',
                'name' => '签到',
                'url' => '/pages/sign_in/sign_in',
                'params' => []
            ]
        ];
    }
    //设置设置导航栏
    public function setNavbar($navbar)
    {

        if(isset($navbar['navs'])){
            foreach ($navbar['navs'] as $index => $value) {
                if ($value['open_type'] == 'web') {
                    $navbar['navs'][$index]['web'] = urlencode($value['web']);
                }
            }
        }
        return $navbar;
    }


    //获取用户所有界面
    public function get_user_pages()
    {
        return [
            "user_center_bg"=> "https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/app/1543370924623.jpeg",
            "orders"=> [
                "status_0"=> [
                    "text"=> "待付款",
                    "icon"=> "https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/app/1543308139500.png"
                ],
                "status_1"=> [
                    "text"=> "待发货",
                    "icon"=> "https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/app/1543308149489.png"
                ],
                "status_2"=> [
                    "text"=> "待收货",
                    "icon"=> "https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/app/1543308155521.png"
                ],
                "status_3"=> [
                    "text"=> "待评价",
                    "icon"=> "https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/app/1543308165855.png"
                ],
                "status_4"=> [
                    "text"=> "售后",
                    "icon"=> "https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/app/1543308173615.png"
                ]
            ],
            "menus"=> [[
                "sign"=> "coupon",
                "name"=> "我的钱包",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/1529469638544.png",
                "link"=> "/pages/user/wallet",
                "open_type"=> "navigate",
                "params"=> []
            ], [
                "sign"=> "coupon",
                "name"=> "我的优惠券",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/1529470554595.png",
                "link"=> "/pages/coupon/index?currentTab=1",
                "open_type"=> "navigate",
                "params"=> []
            ], [
                "sign"=> "integralmall",
                "name"=> "我的积分",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/1529469676267.png",
                "link"=> "/pages/user/score",
                "open_type"=> "navigate",
                "params"=> []
            ],[
                "name"=> "完善资料",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/icon-user-bangding.png",
                "link"=> "/pages/bangding/bangding",
                "open_type"=> "navigate",
                "params"=> []
            ], [
                "name"=> "我的收藏",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/wdsc.png",
                "link"=> "/pages/collection/collection",
                "open_type"=> "navigate",
                "params"=> []
            ], [
                "name"=> "历史记录",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/zj.png",
                "link"=> "/pages/footprint/footprint",
                "open_type"=> "navigate",
                "params"=> []
            ], [
                "name"=> "地址管理",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/dz.png",
                "link"=> "/pages/address/index",
                "open_type"=> "navigate",
                "params"=> []
            ], [
                "name"=> "设置",
                "icon"=> "https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/sz.png",
                "link"=> "/pages/set/set",
                "open_type"=> "navigate",
                "params"=> []
            ]],
            "copyright"=> [
                "text"=> "",
                "icon"=> "",
                "url"=> "",
                "open_type"=> "",
                "is_phone"=> 0,
                "phone"=> ""
            ],
            "menu_style"=> 0,
            "top_style"=> "1",
            "is_wallet"=> 1,
            "is_order"=> 1,
            "manual_mobile_auth"=> 0
        ];
    }

    
    /**
     * @return array
     *查询显示可用导航图标
     */
    public function getNavbar($db,$img,$Navbar = [])
    {
			if($Navbar){
                    $default_navbar = json_decode( $this->setNavbar($Navbar[0]->value));
			}else{
					$default_navbar = [
							'background_image' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEX///+nxBvIAAAACklEQVQI12NgAAAAAgAB4iG8MwAAAABJRU5ErkJggg==',
							'border_color' => 'rgba(0,0,0,.1)',
							'navs' => [
									[
											'url' => '/pages/index/index',
											'icon' => $img . '/appnavbar/nav-icon-index.png',
											'active_icon' => $img . '/appnavbar/nav-icon-index.active.png',
											'text' => '首页',
											'color' => '#888',
											'active_color' => '#ff4544',
									],
                                    [
                                            'url' => '/pages/new/new',
                                            'icon' => $img . '/appnavbar/nav-icon-new.png',
                                            'active_icon' => $img . '/appnavbar/nav-icon-new.active.png',
                                            'text' => '新品',
                                            'color' => '#888',
                                            'active_color' => '#ff4544',
                                    ],
									[
											'url' => '/pages/search/search',
											'icon' => $img . '/appnavbar/nav-icon-search.png',
											'active_icon' => $img . '/appnavbar/nav-icon-search.active.png',
											'text' => '搜索',
											'color' => '#888',
											'active_color' => '#ff4544',
									],
									[
											'url' => '/pages/cart/cart',
											'icon' => $img . '/appnavbar/nav-icon-cart.png',
											'active_icon' => $img . '/appnavbar/nav-icon-cart.active.png',
											'text' => '购物车',
											'color' => '#888',
											'active_color' => '#ff4544',
									],
									[
											'url' => '/pages/user/user',
											'icon' => $img . '/appnavbar/nav-icon-user.png',
											'active_icon' => $img . '/appnavbar/nav-icon-user.active.png',
											'text' => '我',
											'color' => '#888',
											'active_color' => '#ff4544',
									],
							],
					];
			}

        return $default_navbar;
    }


    /**
     * 导航链接
     * @return array
     */
    public function link()
    {
        return [
            [
                'name' => "商城首页", 
                'icon'=>"homeopen.png",
                'link' => "/pages/tabBar/home",
                'open_type' => "switchTab",
                'params' => []
            ],
            [
                'name' => "购物车",
                'icon'=>"seachopen.png",
                'link' => "/pages/tabBar/shoppingCart",
                'open_type' => "switchTab",
                'params' => []
            ],
            [
                'name' => "用户中心",
                'icon'=>"meopen.png",
                'link' => "/pages/tabBar/my",
                'open_type' => "switchTab",
                'params' => []
            ],
            [
                'name' => "全部商品",
                'icon'=>"seachopen.png",
                'link' => "/pages/tabBar/allGoods",
                'open_type' => "switchTab",
                'params' => []
            ],
            [
                'name' => "商品详情",
                'icon'=>"meopen.png",
                'link' => "/pages/goods/goodsDetailed",
                'open_type' => "navigate",
                'params' => [
                    [
                        'key' => "productId",
                        'value' => "",
                        'desc' => "productId请填写在商品列表中相关商品的ID"
                    ]
                ]
            ],
            [
                'name' => "所有订单",
                'icon'=>"icon-user-bangding.png",
                'link' => "/pages/order/myOrder?currentTab=0&otype=pay",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "待付款",
                'icon'=>"5.png",
                'link' => "/pages/order/myOrder?currentTab=1&order_type1=payment&otype=pay",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "待发货",
                'icon'=>"1.png",
                'link' => "/pages/order/myOrder?currentTab=2&order_type1=send&otype=pay",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "待收货",
                'icon'=>"3.png",
                'link' => "/pages/order/myOrder?currentTab=3&order_type1=receipt&otype=pay",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "待评价",
                'icon'=>"4.png",
                'link' => "/pages/order/myOrder?currentTab=4&order_type1=evaluate&otype=pay",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "售后",
                'icon'=>"2.png",
                'link' => "/pagesA/afterSale/afterSale?currentTab=0&otype=whole",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => "share",
                'name' => "分销中心",
                'icon'=>"fx.png",
                'link' => "/pages/distribution/core",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'coupon',
                'name' => "我的钱包",
                'icon'=>"1529469638544.png",
                'link' => "/pages/myWallet/myWallet",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'integralmall',
                'name' => "我的积分",
                'icon'=>"1529469676267.png",
                'link' => "/pages/user/score",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'coupon',
                'name' => "我的优惠券",
                'icon'=>"1529470554595.png",
                'link' => "/pages/my/mycoupon?currentTab=1",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "我的收藏",
                'icon'=>"wdsc.png",
                'link' => "/pages/collection/collection",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "关于我们",
                'icon'=>"icon-user-bangding.png",
                'link' => "/pages/my/aboutMe?id=1",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'coupon',
                'name' => "领券中心",
                'icon'=>"1529470554595.png",
                'link' => "/pagesA/shop/coupon?currentTab=0&type=receive",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'pintuan',
                'name' => "拼团",
                'icon'=>"pt.png",
                'link' => "/pages/group_buy/group",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'pintuan',
                'name' => "我的拼团",
                'icon'=>"pt.png",
                'link' => "/pages/order/order?currentTab=0&otype=pay6",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "充值",
                'icon'=>"1529470572549.png",
                'link' => "/pages/myWallet/recharge",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "完善资料",
                'icon'=>"icon-user-bangding.png",
                'link' => "/pages/bangding/bangding",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'integralmall',
                'name' => "签到",
                'icon'=>"1529469676267.png",
                'link' => "/pagesA/shop/sign",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "搜索页",
                'icon'=>"seachopen.png",
                'link' => "/pages/search/search",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'sign' => 'pond',
                'name' => "幸运抽奖",
                'icon'=>"1529470605370.png",
                'link' => "/pageA/shop/draw",
                'open_type' => "navigate",
                'params' => []
            ],
            [
                'name' => "我的订单",
                'icon'=>"icon-user-bangding.png",
                'link' => "/pages/order/myOrder?currentTab=0&otype=pay",
                'open_type' => "navigate",
                'params' => [],
            ],
            [
                'name' => "设置",
                'icon'=>"sz.png",
                'link' => "/pages/setUp/setUp",
                'open_type' => "navigate",
                'params' => [],
            ],
            [
                'name' => "地址管理",
                'icon'=>"dz.png",
                'link' => "/pages/address/receivingAddress",
                'open_type' => "navigate",
                'params' => [],
            ],
            [
                'name' => "历史记录",
                'icon'=>"zj.png",
                'link' => "/pages/footprint/footprint",
                'open_type' => "navigate",
                'params' => [],
            ],
            [
                'name' => "发红包",
                'icon'=>"fhb.png",
                'link' => "/pages/red_packet/red_packet",
                'open_type' => "navigate",
                'params' => [],
            ],
            [
                'name' => "客服",
                'icon'=>"kefu.png",
                'link' => "/page/message/service",
                'open_type' => "contact",
                'params' => [],
            ],
        ];
    }


    //小程序所有界面
    public function mini_program_pages()
    {
        return [
            "pages/index/index" => '首页',
            "pages/pond/index"=>'十二宫格',
            "pages/pond/details"=>'抽奖详情界面',
            "pages/pond/rank"=>'抽奖排行榜',
            "pages/pond/record"=>'中奖记录',
            "pages/distribution/core"=>'分销中心',
            "pages/distribution/orders"=>'我的订单',
            "pages/distribution/mycode"=>'我的二维码',
            "pages/distribution/myteam"=>'我的客户',
            "pages/distribution/product_list"=>'我的产品',
            "pages/distribution/product"=>'商品详情',
            "pages/distribution/record"=>'销售明细',
            "pages/search/search"=>'搜索',
            "pages/user/user"=>'个人中心',
            "pages/new/new"=>'新品',
            "pages/set/set"=>'设置',
            "pages/user/score"=>'我的积分',
            "pages/user/wallet"=>'钱包',
            "pages/user/recharge"=>'充值',
            "pages/article/article"=>'文章',
            "pages/listdetail/listdetail"=>'分类',
            "pages/product/detail"=>'商品详情',
            "pages/envelope/envelope"=>'分享',
            "pages/user/withdrawals"=>'提现',
            "pages/about/about"=>'关于',
            "pages/share/index"=>'打开分享',
            "pages/share/share"=>'分享界面',
            "pages/address/index"=>'地址管理',
            "pages/address/address"=>'添加地址',
            "pages/address/upaddress/upaddress"=>'修改地址',
            "pages/cart/cart"=>'购物车',
            "pages/order/pay"=>'订单支付',
            "pages/order/detail"=>'订单详情',
            "pages/order/order"=>'全部订单',
            "pages/return_goods/index"=>'售后',
            "pages/return_goods/return_goods"=>'申请售后',
            "pages/collection/collection"=>'我的收藏',
            "pages/comment/comment"=>'添加评论',
            "pages/coupon/index"=>'优惠券',
            "pages/footprint/footprint"=>'我的足迹',
            "pages/logistics/logistics"=>'物流详情',
            "pages/sign_in/sign_in"=>'签到',
            "pages/draw/draw"=>'抽奖',
            "pages/draw/cantuan"=>'参加抽奖',
            "pages/group_buy/group"=>'拼团',
            "pages/group_buy/detail"=>'拼团详情',
            "pages/group_buy/payfor"=>'拼团支付',
            "pages/group_buy/cantuan"=>'参团',
            "pages/group_buy/comment"=>'拼团评价',
            "pages/red_packet/red_packet"=>'发红包',
            "pages/red_packet/red_record"=>'打开红包',
            "pages/red_packet/red_envelopes"=>'红包记录',
            "pages/user/transfer"=>'添加转账',
            "pages/user/transfer1"=>'转账金额',
            "pages/user/transfer_jifen"=>'积分转账',
            "pages/user/transfer_jifen1"=>'转账',
            "pages/login/login"=>'授权登入',
            "pages/bangding/bangding"=>'信息绑定'
          ];
    }

    public static function module_list($type){
        $array = [
            // 这些是必须有的，无需进行权限判断
            'mustModule' => [
                [
                    'name' => 'banner',
                    'display_name' => '轮播图',
                ],
                [
                    'name' => 'search',
                    'display_name' => '搜索框',
                ],
                [
                    'name' => 'nav',
                    'display_name' => '导航图标',
                ],
                [
                    'name' => 'notice',
                    'display_name' => '公告',
                ]
            ],
            // 需要根据插件权限来显示，根据key值
            'authModule' => [
                [
                    'key' => 'coupon',
                    'name' => 'coupon',
                    'display_name' => '领券中心',
                ],
                [
                    'key' => 'pintuan',
                    'name' => 'pintuan',
                    'display_name' => '拼团',
                ]
            ]
        ];
        if(array_key_exists($type, $array)){
           return $array[$type];
        }else{
           return []; 
        }
    }

}



?>
