(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-pay-orderDetailsr~pagesB-integral-integral_order~pagesB-seckill-seckillDetailsr"],{"15d4":function(e,a,o){"use strict";var t=o("288e");Object.defineProperty(a,"__esModule",{value:!0}),a.laikeUseyue=d,a.laikePayThree=r,a.laikeChooseWay=s,a.laikeSwitchChange=c,a.laikeChangeValue=l,a.laikePayAtOnce=u,a.laikeGetPayType=p,a.laikeShowCoupon=_,a.laikeCloseCoupon=g,a.laikeChooseCoupon=m,o("c5f6");var i=t(o("f499")),n=t(o("59ad"));function d(e){var a=e;if("jp"==a.pay_name){var o=(0,n.default)(a.jp_zong-a.value).toFixed(2);console.log("me.needpay=================5"),console.log(a.needpay),o>0?(a.needpay=o,console.log("me.needpay=================6"),console.log(a.needpay)):(a.needpay=0,console.log("me.needpay=================7"),console.log(a.needpay))}else if(a.bargain){var t=(0,n.default)(a.products_total+a.freight-a.value).toFixed(2);t>0?(a.needpay=t,console.log("me.needpay=================8"),console.log(a.needpay)):(a.needpay=0,console.log("me.needpay=================9"),console.log(a.needpay))}else{console.log(a.coupon_name);var i=(0,n.default)((a.products_total-a.coupon_name-a.reduce_money)*a.discount*a.grade_rate+a.freight-a.value).toFixed(2);i>0?(a.needpay=i,console.log("me.needpay=================10"),console.log(a.needpay)):(a.needpay=0,console.log("me.needpay=================11"),console.log(a.needpay))}}function r(e){var a=e;if(a.useWallte)a.wxPayStatue?a.pay_wx():(uni.showToast({title:"请选择支付方式！",duration:1e3,icon:"none"}),a.firstFlag=!0);else if(a.wxPayStatue||a.aliPayStatue||a.baidupayStatue){if(console.log("jcex3==============="),"jp"==a.pay_name){var o={module:"app",action:"order",app:"payment",access_id:a.access_id,address_id:a.address_id,type:"JP",auction_id:a.bind_id,coupon_id:a.coupon_id};a.cpId&&(o.product=a.cpId,o.cart_id="")}else if("MS"==a.otype){o={module:"app",action:"order",app:"payment",type:"MS",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,coupon_id:a.coupon_id,activity_id:a.activity_id,time_id:a.time_id};a.cpId&&(o.product=a.cpId,o.cart_id="")}else if(a.bargain){o={module:"app",action:"order",app:"payment",type:"KJ",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,bargain_id:a.bargain_id,bargain_order_no:a.order_no};a.cpId&&(o.product=a.cpId,o.cart_id="")}else{o={module:"app",action:"order",app:"payment",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,coupon_id:a.coupon_id};a.cpId&&(o.product=a.cpId,o.cart_id="")}a.wxPayStatue?(o.pay_type="jsapi_wechat",o.store_type=2):a.aliPayStatue||a.baidupayStatue,a.afhalen_translateX>5&&(""==a.shop_address_id?(uni.showToast({title:"请选择门店！",duration:1e3,icon:"none"}),a.firstFlag=!0):o.shop_address_id=a.shop_address_id),uni.request({data:o,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){console.log(e);var o=e.data,t=o.status,n=o.data;a.order_list=(0,i.default)(n),0!=t?1==t&&(a.sNo=e.data.data.sNo,a.price1=e.data.data.total,a.order_id=e.data.data.order_id,a.wxPayStatue?a.pay_wx("wx"):a.aliPayStatue?a.pay_wx("ali"):a.baidupayStatue&&a.pay_wx("baidu_pay")):uni.showToast({title:e.data.err,duration:1500,icon:"none"})},error:function(e){uni.hideLoading(),a.firstFlag=!0,uni.showToast({title:"创建订单失败,请稍后再试!",duration:1500,icon:"none"}),setTimeout(function(){uni.navigateBack({delta:1})},1500)}})}else uni.showToast({title:"请选择支付方式！",duration:1e3,icon:"none"}),a.firstFlag=!0}function s(e,a){console.log("======laikeChooseWay======"),uni.getProvider({service:"payment",success:function(e){console.log(e)}});var o=e;"wxPay"==a?o.wxPayStatue?o.wxPayStatue=!1:(o.wxPayStatue=!0,o.aliPayStatue=!1,o.baidupayStatue=!1):"aliPay"==a?o.aliPayStatue?o.aliPayStatue=!1:(o.wxPayStatue=!1,o.aliPayStatue=!0,o.baidupayStatue=!1):"baidu"==a&&(o.baidupayStatue?o.baidupayStatue=!1:(o.wxPayStatue=!1,o.aliPayStatue=!1,o.baidupayStatue=!0))}function c(e,a){var o=a;if(!(Number(o.user_money)<=0))if(o.useWallte=e.detail.value,o.useWallte)if(o.total>=Number(o.user_money))o.value=o.user_money,console.log("me.value=================1"),console.log(o.value),o.needpay=(0,n.default)(o.total-Number(o.user_money)).toFixed(2),console.log("me.needpay=================12"),console.log(o.needpay);else if(o.bargain)o.value=Number(o.products_total)+Number(o.freight),console.log("me.value=================2"),console.log(o.value),o.needpay=0,console.log("me.needpay=================13"),console.log(o.needpay);else{o.value=(0,n.default)((o.products_total-o.coupon_name-o.reduce_money)*o.discount*o.grade_rate+o.freight).toFixed(2),console.log("me.value=================3"),console.log(o.value);var t=(o.products_total-o.coupon_name-o.reduce_money)*o.discount*o.grade_rate+o.freight;o.total=t,o.needpay=0,console.log("me.needpay=================14"),console.log(o.needpay),""===o.value&&(o.value=o.value2),t-o.value>0&&(o.needpay=t-o.value,console.log("me.needpay=================15"),console.log(o.needpay))}else o.value2=o.value,o.value="",o.needpay=""}function l(e,a,o){var t=e;t.$nextTick(function(){t.price1=(t.products_total-t.coupon_name-t.reduce_money)*t.discount*t.grade_rate,console.log("计算price1"+t.products_total+"===="+t.discount+"===="+t.freight+"===="+t.coupon_name+"===="+t.reduce_money),t.price2=t.price1.toFixed(2),console.log(t.price2),t.price2<0?(t.price2=.01+t.freight,t.price2=t.price2.toFixed(2),t.price2=Number(t.price2).toFixed(2)):(t.price2=t.price2+0+t.freight,t.price2=Number(t.price2).toFixed(2));var e=(t.products_total-t.coupon_name-t.reduce_money)*t.discount*t.grade_rate;if(e<=0?(e=.01+t.freight,t.price2=.01+t.freight,t.price2=Number(t.price2).toFixed(2),t.value=.01+t.freight,t.isdx=!0):e=e+0+t.freight,console.log(e>=0),console.log("计算should_pay"+t.products_total+"===="+t.discount+"===="+t.freight+"===="+t.coupon_name+"===="+t.reduce_money),console.log("Number(me.value)"),console.log(Number(t.value)),console.log("should_pay------"+e.toFixed(2)+"---Number(me.value)----"+Number(t.value)),t.price2=e.toFixed(2),Number(t.value)>t.user_money&&(t.value=t.user_money),Number(t.value)>e.toFixed(2)?(console.log("me.value=================999"),e<=t.user_money?(t.value=e.toFixed(2),console.log(e),console.log("me.value=================4"),console.log(t.value)):(t.value=t.user_money,console.log("me.value=================6"),console.log(t.value)),Number(t.value).toFixed(2)>e.toFixed(2)&&e.toFixed(2)>0&&(console.log("===========是否超过最大金额"),console.log(Number(t.value)),console.log(e),uni.showToast({title:"已超过最大金额",icon:"none",duration:1500}))):Number(t.value)<e&&Number(t.value)>t.user_money&&(t.value=t.user_money,console.log("me.value=================7"),console.log(t.value),uni.showToast({title:"已超过最大金额",icon:"none",duration:1500})),t.price2<.0099999999&&console.log("me.value=================888"),0==Math.abs(a-o)){console.log("me.value=================777");var i=String(a).indexOf(".")+1,n=String(a).length-i;n>2&&0!=i&&(t.value=Number(a).toFixed(2),console.log("me.value=================8"),console.log(t.value))}else Math.abs(a-o)<.009999999999&&(t.value=Number(t.value).toFixed(2),console.log("me.value=================9"),console.log(t.value))})}function u(e){var a=e;if(!a.can_pay)return!1;if(console.log("click"),a.can_pay=!1,setTimeout(function(){a.can_pay=!0},1500),a._gotPayType(),a.firstFlag)if(a.firstFlag=!1,a.value||(a.value=0),a.bargain||a.seckill?a.price1=a.products_total+a.freight-Number(a.value):a.price1=a.products_total+a.freight-a.coupon_name-Number(a.reduce_money)-Number(a.value),a.price1=a.price1.toFixed(2),a.afhalen_translateX>5)if(a.shop_address_id)if(a.useWallte)if(0==a.password_status)uni.showModal({title:"提示",content:"请先设置支付密码",showCancel:!0,success:function(e){a.firstFlag=!0,e.confirm&&uni.navigateTo({url:"../../pagesB/setUp/payment"})}});else{var o=(Number(a.products_total)-Number(a.coupon_name)-Number(a.reduce_money))*Number(a.discount)*Number(a.grade_rate)+Number(a.freight);if((0!=Number(a.needpay)||Number(o).toFixed(2)>Number(a.value).toFixed(2))&&!(a.wxPayStatue||a.aliPayStatue||a.baidupayStatue))return uni.showToast({title:"金额不足以支付商品价格!",icon:"none",duration:1500}),!1;if("jp"==a.pay_name)var t={module:"app",action:"order",app:"payment",access_id:a.access_id,address_id:a.address_id,type:"JP",auction_id:a.bind_id,coupon_id:a.coupon_id,remarks:a.remarks};else if(a.bargain){console.log("me.bargain");t={module:"app",action:"order",app:"payment",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,type:"KJ",coupon_id:a.coupon_id,bargain_id:a.bargain_id,bargain_order_no:a.order_no,remarks:a.remarks}}else if(a.seckill){console.log("me.seckill");t={module:"app",action:"order",app:"payment",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,type:"MS",coupon_id:a.coupon_id,bargain_id:"",bargain_order_no:"",remarks:a.remarks,activity_id:a.activity_id,time_id:a.time_id};console.log("1me.activity_id:"+a.activity_id),console.log("1me.time_id:"+a.time_id)}else t={module:"app",action:"order",app:"payment",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,coupon_id:a.coupon_id,bargain_id:a.bargain_id,bargain_order_no:a.order_no,remarks:a.remarks,shop_address_id:a.shop_address_id};if(a.cpId&&(t.product=a.cpId,t.cart_id=""),a.wxPayStatue?(t.pay_type="jsapi_wechat",t.store_type=2):a.aliPayStatue?t.pay_type="aliPay":a.baidupayStatue&&(t.pay_type="baidu_pay"),uni.request({data:t,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){if(404!=e.data.code){var o=e.data,t=o.status,n=o.data;1==t?(a.makeOrd=!0,a.sNo=e.data.data.sNo,a.order_list=(0,i.default)(n)):(a.firstFlag=!0,uni.hideLoading(),uni.showToast({title:"创建订单失败,请稍后再试!",duration:1500,icon:"none"}),setTimeout(function(){uni.navigateBack({url:"../good/goodsDetailed"})},1500))}else uni.hideLoading()}}),a.price1>0){console.log("立即支付6");var n=(Number(a.products_total)-Number(a.coupon_name)-Number(a.reduce_money))*Number(a.discount)*Number(a.grade_rate)+Number(a.freight);if(n=n.toFixed(2),0!=Number(a.needpay)||n>a.value){if(!(a.wxPayStatue||a.aliPayStatue||a.baidupayStatue))return a.firstFlag=!0,uni.showToast({title:"金额不足以支付商品价格!2",icon:"none",duration:1500}),!1;a.pay_display=!0,console.log("立即支付7")}else console.log("立即支付8"),a.pay_display=!0}else a.pay_display=!0}else uni.showLoading({title:"正在请求支付...",mask:!0}),a.payThree();else uni.showToast({title:"请选择门店！",duration:1e3,icon:"none"});else if(a.adds_f)if(a.useWallte)if(console.log("立即支付5"),0==a.password_status)uni.showModal({title:"提示",content:"请先设置支付密码",showCancel:!0,success:function(e){a.firstFlag=!0,e.confirm&&uni.navigateTo({url:"../../pagesB/setUp/payment"})}});else{var d=(Number(a.products_total)-Number(a.coupon_name)-Number(a.reduce_money))*Number(a.discount)*Number(a.grade_rate)+Number(a.freight);if(console.log("isdx:"+a.isdx),a.isdx&&a.user_money>.01&&(a.needpay=0),console.log(d),console.log(a.needpay),console.log(Number(d).toFixed(2)>Number(a.value).toFixed(2)),(0!=Number(a.needpay)||Number(d).toFixed(2)>Number(a.value).toFixed(2))&&!(a.wxPayStatue||a.aliPayStatue||a.baidupayStatue))return uni.showToast({title:"金额不足以支付商品价格!3",icon:"none",duration:1500}),!1;if(console.log("jcex2============"),"jp"==a.pay_name)t={module:"app",action:"order",app:"payment",access_id:a.access_id,address_id:a.address_id,type:"JP",auction_id:a.bind_id,coupon_id:a.coupon_id,remarks:a.remarks};else if(a.bargain)t={module:"app",action:"order",app:"payment",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,type:"KJ",coupon_id:a.coupon_id,bargain_id:a.bargain_id,bargain_order_no:a.order_no,remarks:a.remarks};else if(a.seckill){console.log("me.seckill");t={module:"app",action:"order",app:"payment",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,type:"MS",coupon_id:a.coupon_id,bargain_id:"",bargain_order_no:"",remarks:a.remarks,activity_id:a.activity_id,time_id:a.time_id}}else t={module:"app",action:"order",app:"payment",cart_id:a.cart_id,access_id:a.access_id,address_id:a.address_id,coupon_id:a.coupon_id,bargain_id:a.bargain_id,bargain_order_no:a.order_no,remarks:a.remarks,shop_address_id:a.shop_address_id};if(a.cpId&&(t.product=a.cpId,t.cart_id=""),a.wxPayStatue?(t.pay_type="jsapi_wechat",t.store_type=2):a.aliPayStatue?t.pay_type="aliPay":a.baidupayStatue&&(t.pay_type="baidu_pay"),uni.request({data:t,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){if(404!=e.data.code){var o=e.data,t=o.status,n=o.data;if(1==t)a.makeOrd=!0,a.sNo=e.data.data.sNo,a.order_list=(0,i.default)(n);else{if(""!=e.data.redis_name&&a.seckill)return uni.showToast({title:"手速慢了哦，已经就被抢完了!",duration:1500,icon:"none"}),setTimeout(function(){uni.navigateBack({delta:2})},1500),!1;a.firstFlag=!0,uni.hideLoading(),uni.showToast({title:"创建订单失败,请稍后再试!",duration:1500,icon:"none"}),setTimeout(function(){uni.navigateBack({url:"../good/goodsDetailed"})},1500)}}else uni.hideLoading()}}),a.price1>0){console.log("立即支付6");var r=(Number(a.products_total)-Number(a.coupon_name)-Number(a.reduce_money))*Number(a.discount)*Number(a.grade_rate)+Number(a.freight);if(r=r.toFixed(2),0!=Number(a.needpay)||r>a.value){if(!(a.wxPayStatue||a.aliPayStatue||a.baidupayStatue))return a.firstFlag=!0,uni.showToast({title:"金额不足以支付商品价格!4",icon:"none",duration:1500}),!1;a.pay_display=!0,console.log("立即支付7")}else console.log("立即支付8"),a.pay_display=!0}else a.pay_display=!0}else uni.showLoading({title:"正在请求支付...",mask:!0}),console.log("me.otype"),console.log(a.otype),a.payThree();else uni.showToast({title:"请完善收货地址！",duration:1e3,icon:"none"})}function p(e){var a=e;console.log(a.useWallte),console.log(a.wxPayStatue),console.log(a.aliPayStatue),a.useWallte||a.wxPayStatue||a.aliPayStatue||a.baidupayStatue?a.firstFlag=!0:(uni.showToast({title:"请选择支付方式！",duration:1e3,icon:"none"}),a.firstFlag=!1)}function _(e){var a=e;a.use_coupon=!0;var o={module:"app",action:"Coupon",app:"my_coupon",access_id:a.access_id,cart_id:a.cart_id,product:a.cpId};uni.request({data:o,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){if(200==e.data.code){var o=e.data.list;a.coupon_list=o}else uni.showToast({title:e.data.message,duration:1500,icon:"none"})},error:function(e){console.log(e)}})}function g(e){var a=e;a.use_coupon=!1;var o={module:"app",action:"Coupon",app:"getvou",access_id:a.access_id,cart_id:a.cart_id,address_id:a.address_id,coupon_id:a.coupon_id,product:a.cpId};a.coupon_id.length>0&&uni.request({data:o,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){if(200==e.data.code){e.data.money;a.freightt=(0,n.default)(e.data.freight).toFixed(2),a.freight=e.data.freight,a.coupon_name1=e.data.coupon_name;var o=Number(a.products_total)+Number(a.freight)-Number(a.coupon_name)-Number(a.reduce_money);a.total=o}else uni.showToast({title:e.data.message,duration:1500,icon:"none"});if(200==e.statusCode){a.coupon_name=e.data.money,a.total=a.products_total+a.freight-a.coupon_name-a.reduce_money;var t=a.products_total-a.coupon_name-a.reduce_money;console.log(a.products_total),console.log(a.freight),console.log(a.coupon_name),console.log(a.reduce_money),a.useWallte?a.total>=Number(a.user_money)?(a.value=a.user_money,console.log("me.value=================10"),console.log(a.value),a.needpay=(0,n.default)(a.products_total-Number(a.user_money)).toFixed(2),console.log("me.needpay=================1"),console.log(a.needpay)):(a.value=a.total,console.log("me.value=================11"),console.log(a.value),a.needpay=0,console.log("me.needpay=================2"),console.log(a.needpay)):t>0?(a.needpay=(0,n.default)(a.total).toFixed(2),console.log("me.needpay=================3"),console.log(a.needpay)):t<=0&&a.total>0?(a.needpay=(0,n.default)(a.total).toFixed(2)+.01,console.log("me.needpay=================33"),console.log(a.needpay)):(a.needpay=.01,console.log("me.needpay=================4"),console.log(a.needpay))}}})}function m(e,a,o,t){var i=e;if(1==t){i.coupon_list.length;i.coupon_id.length>0?i.coupon_id=0==o?[0]:o:i.coupon_id=o}else uni.showToast({title:"不能使用该优惠券",icon:"none",duration:1500})}},"179c":function(e,a,o){"use strict";var t=function(){var e=this,a=e.$createElement,o=e._self._c||a;return e.display?o("div",{staticClass:"mask",on:{touchmove:function(a){a.stopPropagation(),a.preventDefault(),arguments[0]=a=e.$handleEvent(a)}}},[o("div",{staticClass:"mask_content"},[o("p",[e._v(e._s(e.content))]),o("div",[o("div",{staticClass:"cancel",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e._click("取消")}}},[e._v("取消")]),o("div",{staticClass:"confirm",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e._click("确认")}}},[e._v("确认")])])])]):e._e()},i=[];o.d(a,"a",function(){return t}),o.d(a,"b",function(){return i})},"36bf":function(e,a,o){var t=o("5ba3");"string"===typeof t&&(t=[[e.i,t,""]]),t.locals&&(e.exports=t.locals);var i=o("4f06").default;i("9f42c6ac",t,!0,{sourceMap:!1,shadowMode:!1})},"3b61":function(e,a,o){"use strict";var t=o("c332"),i=o.n(t);i.a},4205:function(e,a,o){"use strict";o.r(a);var t=o("179c"),i=o("ad6a");for(var n in i)"default"!==n&&function(e){o.d(a,e,function(){return i[e]})}(n);o("3b61");var d=o("2877"),r=Object(d["a"])(i["default"],t["a"],t["b"],!1,null,"3fdc30bc",null);a["default"]=r.exports},"453f":function(e,a,o){"use strict";var t=o("36bf"),i=o.n(t);i.a},5152:function(e,a,o){"use strict";var t=function(){var e=this,a=e.$createElement,o=e._self._c||a;return o("div",{style:"display:flex;height:"+e.BoxHeight},[o("div",{staticClass:"head",class:{head_w:"秒杀"==e.title}},[o("div",{class:{white:!e.navWhite},style:{height:e.halfWidth}}),o("div",{staticClass:"header"},[e.flag&&!e.returnFlag?o("div",{on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e._back1.apply(void 0,arguments)}}},["秒杀"==e.title?o("img",{attrs:{src:e.back1}}):o("img",{attrs:{src:e.back}})]):e._e(),e.flag||e.returnFlag?e._e():o("img",{staticClass:"header_img",attrs:{src:e.bback},on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e._back1.apply(void 0,arguments)}}}),o("p",{class:{title_w:"秒杀"==e.title}},[e._v(e._s(e.title))])])])])},i=[];o.d(a,"a",function(){return t}),o.d(a,"b",function(){return i})},"5ba3":function(e,a,o){a=e.exports=o("2350")(!1),a.push([e.i,".head[data-v-2dde4b93]{position:fixed;left:0;top:0;background-color:#fff;width:100%;z-index:9999;border-bottom:1px solid #eee}.head .white[data-v-2dde4b93]{background:#fff}.header[data-v-2dde4b93]{color:#fff;border:none}.header img[data-v-2dde4b93]{position:absolute;top:%?26?%;left:%?20?%;width:%?24?%;height:%?36?%}.header a[data-v-2dde4b93]{position:absolute;width:%?36?%;height:%?36?%;border-radius:50%}.header_img[data-v-2dde4b93]{top:%?46?%!important;left:%?10?%!important;width:%?64?%!important;height:%?64?%!important}.header p[data-v-2dde4b93]{text-align:center;width:100%;height:100%;line-height:%?88?%;color:#020202;font-size:%?32?%}.header>div[data-v-2dde4b93]{height:%?88?%;width:%?160?%;position:absolute;z-index:9999}.head_w[data-v-2dde4b93]{background:transparent;border-bottom:0}.title_w[data-v-2dde4b93]{color:#fff!important}",""])},6042:function(e,a,o){"use strict";o.r(a);var t=o("5152"),i=o("8b1f");for(var n in i)"default"!==n&&function(e){o.d(a,e,function(){return i[e]})}(n);o("453f");var d=o("2877"),r=Object(d["a"])(i["default"],t["a"],t["b"],!1,null,"2dde4b93",null);a["default"]=r.exports},"859d":function(e,a,o){"use strict";var t=o("288e");Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,o("c5f6");var i=t(o("cebc")),n=t(o("e814")),d=o("2f62"),r=o("aa16"),s={data:function(){return{flag:!0,bback:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon/bback.png",back:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png",back1:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png"}},computed:{halfWidth:function(){var e=(0,r.getStorage)("data_height")?(0,r.getStorage)("data_height"):this.$store.state.data_height,a=(0,n.default)(e);return a+"px"},BoxHeight:function(){var e=(0,r.getStorage)("data_height")?(0,r.getStorage)("data_height"):this.$store.state.data_height,a=0,o=(0,n.default)(e)+uni.upx2px(88);return a=o&&o>0?o:uni.upx2px(88),a+"px"}},onLoad:function(e){console.log("header"),console.log(this.returnR)},props:["title","returnR","navWhite","returnFlag"],methods:(0,i.default)({},(0,d.mapMutations)({status:"data_height"}),{_back:function(){this.flag=!1,console.log(this.returnR)},_back1:function(){switch(this.flag=!1,Number(this.returnR)){case 1:uni.navigateBack({delta:2});break;case 2:uni.switchTab({url:"../tabBar/shoppingCart"});break;case 3:uni.redirectTo({url:"../login/login.vue"});break;case 4:uni.navigateBack({delta:3});break;case 5:uni.redirectTo({url:"../order/myOrder"});break;case 6:uni.switchTab({url:"../../pages/tabBar/home"});break;case 7:uni.switchTab({url:"../../pages/tabBar/my"});break;case 8:uni.switchTab({url:"../tabBar/my"});break;case 9:uni.redirectTo({url:"/pagesA/myStore/myStore"});break;default:getCurrentPages().length>1?uni.navigateBack({delta:1}):uni.switchTab({url:"/pages/tabBar/home"})}this.flag=!0}})};a.default=s},"8b1f":function(e,a,o){"use strict";o.r(a);var t=o("859d"),i=o.n(t);for(var n in t)"default"!==n&&function(e){o.d(a,e,function(){return t[e]})}(n);a["default"]=i.a},ad6a:function(e,a,o){"use strict";o.r(a);var t=o("c2f3"),i=o.n(t);for(var n in t)"default"!==n&&function(e){o.d(a,e,function(){return t[e]})}(n);a["default"]=i.a},b76e:function(e,a,o){a=e.exports=o("2350")(!1),a.push([e.i,".mask[data-v-3fdc30bc]{height:100vh;width:100%;background-color:rgba(0,0,0,.5);position:fixed;top:0;left:0;z-index:999;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.mask_content[data-v-3fdc30bc]{width:%?550?%;height:%?250?%;background-color:#fff;text-align:center;font-size:%?30?%;border-radius:%?23?%;position:relative}.mask_content>div[data-v-3fdc30bc]{border-top:1px solid #eee;width:100%;font-size:%?34?%;color:#005edf;height:%?94?%;position:absolute;bottom:0;left:0}.cancel[data-v-3fdc30bc]{border-right:1px solid #eee;color:#999}.cancel[data-v-3fdc30bc],.confirm[data-v-3fdc30bc]{width:50%;float:left;height:100%;line-height:%?98?%;font-size:%?34?%}.confirm[data-v-3fdc30bc]{color:#020202}.mask_content>p[data-v-3fdc30bc]{font-size:%?30?%;color:#333;line-height:%?160?%}",""])},c2f3:function(e,a,o){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var t={props:["content","display"],data:function(){return{mask_value:""}},created:function(){console.log(this.display)},methods:{_click:function(e){this.mask_value=e,this.$emit("mask_value",this.mask_value)}}};a.default=t},c332:function(e,a,o){var t=o("b76e");"string"===typeof t&&(t=[[e.i,t,""]]),t.locals&&(e.exports=t.locals);var i=o("4f06").default;i("42d556fa",t,!0,{sourceMap:!1,shadowMode:!1})}}]);