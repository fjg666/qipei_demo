(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pagesA-myStore-QRdraw"],{"02fd":function(t,e,a){"use strict";var i=a("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=i(a("e814")),o=i(a("6042")),r=(a("aa16"),{data:function(){return{title:"验证码提取",access_id:"",shop_code:"",order_id:"",p_price:"",sNo:"",placeStyle:"color:#888888;"}},computed:{halfWidth:function(){var t=uni.getStorageSync("data_height")?uni.getStorageSync("data_height"):this.$store.state.data_height,e=(0,n.default)(t),a=2*e;return uni.upx2px(a)+"px"}},onLoad:function(t){t.order_id&&(this.order_id=t.order_id)},onShow:function(){var t=this;t.access_id=uni.getStorageSync("access_id")?uni.getStorageSync("access_id"):t.$store.state.access_id,t.shop_id=uni.getStorageSync("shop_id")?uni.getStorageSync("shop_id"):t.$store.state.shop_id},methods:{_navigateTo:function(t){uni.navigateTo({url:t})},QRsuccess:function(t){uni.showLoading({title:"加载中"});var e=this;if(""!=e.shop_code){var a={module:"app",action:"mch",m:"verification_extraction_code",access_id:e.access_id,shop_id:e.shop_id,order_id:e.order_id,extraction_code:e.shop_code};uni.request({data:a,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(t){uni.hideLoading(),200==t.data.code?(e.order_id=t.data.order_id,e.p_price=t.data.p_price,e.sNo=t.data.sNo,uni.showToast({title:t.data.message,duration:1500,icon:"none"}),uni.redirectTo({url:"QRsuccess?p_price="+e.p_price+"&sNo="+e.sNo+"&order_id="+e.order_id})):uni.showToast({title:t.data.message,duration:1500,icon:"none"})}})}else uni.showToast({title:"请填写提货码",duration:1500,icon:"none"})}},components:{heads:o.default}});e.default=r},"36bf":function(t,e,a){var i=a("5ba3");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("9f42c6ac",i,!0,{sourceMap:!1,shadowMode:!1})},"453f":function(t,e,a){"use strict";var i=a("36bf"),n=a.n(i);n.a},5152:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{style:"display:flex;height:"+t.BoxHeight},[a("div",{staticClass:"head",class:{head_w:"秒杀"==t.title}},[a("div",{class:{white:!t.navWhite},style:{height:t.halfWidth}}),a("div",{staticClass:"header"},[t.flag&&!t.returnFlag?a("div",{on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t._back1.apply(void 0,arguments)}}},["秒杀"==t.title?a("img",{attrs:{src:t.back1}}):a("img",{attrs:{src:t.back}})]):t._e(),t.flag||t.returnFlag?t._e():a("img",{staticClass:"header_img",attrs:{src:t.bback},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t._back1.apply(void 0,arguments)}}}),a("p",{class:{title_w:"秒杀"==t.title}},[t._v(t._s(t.title))])])])])},n=[];a.d(e,"a",function(){return i}),a.d(e,"b",function(){return n})},"5ba3":function(t,e,a){e=t.exports=a("2350")(!1),e.push([t.i,".head[data-v-2dde4b93]{position:fixed;left:0;top:0;background-color:#fff;width:100%;z-index:9999;border-bottom:1px solid #eee}.head .white[data-v-2dde4b93]{background:#fff}.header[data-v-2dde4b93]{color:#fff;border:none}.header img[data-v-2dde4b93]{position:absolute;top:%?26?%;left:%?20?%;width:%?24?%;height:%?36?%}.header a[data-v-2dde4b93]{position:absolute;width:%?36?%;height:%?36?%;border-radius:50%}.header_img[data-v-2dde4b93]{top:%?46?%!important;left:%?10?%!important;width:%?64?%!important;height:%?64?%!important}.header p[data-v-2dde4b93]{text-align:center;width:100%;height:100%;line-height:%?88?%;color:#020202;font-size:%?32?%}.header>div[data-v-2dde4b93]{height:%?88?%;width:%?160?%;position:absolute;z-index:9999}.head_w[data-v-2dde4b93]{background:transparent;border-bottom:0}.title_w[data-v-2dde4b93]{color:#fff!important}",""])},6042:function(t,e,a){"use strict";a.r(e);var i=a("5152"),n=a("8b1f");for(var o in n)"default"!==o&&function(t){a.d(e,t,function(){return n[t]})}(o);a("453f");var r=a("2877"),d=Object(r["a"])(n["default"],i["a"],i["b"],!1,null,"2dde4b93",null);e["default"]=d.exports},7161:function(t,e,a){"use strict";a.r(e);var i=a("02fd"),n=a.n(i);for(var o in i)"default"!==o&&function(t){a.d(e,t,function(){return i[t]})}(o);e["default"]=n.a},"7ff6":function(t,e,a){e=t.exports=a("2350")(!1),e.push([t.i,".container[data-v-2b55202a]{background:#f8f8f8;min-height:100VH}.QR-content[data-v-2b55202a]{display:-webkit-box;display:-webkit-flex;display:flex;width:100%;height:%?90?%;background:#fff;margin-top:%?10?%}.QR-content p[data-v-2b55202a],.QR-content uni-input[data-v-2b55202a]{font-size:%?28?%;color:#242424;height:100%}.QR-content p[data-v-2b55202a]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:%?32?% %?70?% %?32?% %?32?%;box-sizing:border-box}.QR-content uni-input[data-v-2b55202a]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.QR-btn[data-v-2b55202a]{margin:%?40?%;height:%?90?%;line-height:%?90?%;background:#242424;border-radius:%?5?%;color:#fff;font-size:%?30?%;font-weight:500}",""])},"859d":function(t,e,a){"use strict";var i=a("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,a("c5f6");var n=i(a("cebc")),o=i(a("e814")),r=a("2f62"),d=a("aa16"),s={data:function(){return{flag:!0,bback:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon/bback.png",back:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png",back1:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png"}},computed:{halfWidth:function(){var t=(0,d.getStorage)("data_height")?(0,d.getStorage)("data_height"):this.$store.state.data_height,e=(0,o.default)(t);return e+"px"},BoxHeight:function(){var t=(0,d.getStorage)("data_height")?(0,d.getStorage)("data_height"):this.$store.state.data_height,e=0,a=(0,o.default)(t)+uni.upx2px(88);return e=a&&a>0?a:uni.upx2px(88),e+"px"}},onLoad:function(t){console.log("header"),console.log(this.returnR)},props:["title","returnR","navWhite","returnFlag"],methods:(0,n.default)({},(0,r.mapMutations)({status:"data_height"}),{_back:function(){this.flag=!1,console.log(this.returnR)},_back1:function(){switch(this.flag=!1,Number(this.returnR)){case 1:uni.navigateBack({delta:2});break;case 2:uni.switchTab({url:"../tabBar/shoppingCart"});break;case 3:uni.redirectTo({url:"../login/login.vue"});break;case 4:uni.navigateBack({delta:3});break;case 5:uni.redirectTo({url:"../order/myOrder"});break;case 6:uni.switchTab({url:"../../pages/tabBar/home"});break;case 7:uni.switchTab({url:"../../pages/tabBar/my"});break;case 8:uni.switchTab({url:"../tabBar/my"});break;case 9:uni.redirectTo({url:"/pagesA/myStore/myStore"});break;default:getCurrentPages().length>1?uni.navigateBack({delta:1}):uni.switchTab({url:"/pages/tabBar/home"})}this.flag=!0}})};e.default=s},"8b1f":function(t,e,a){"use strict";a.r(e);var i=a("859d"),n=a.n(i);for(var o in i)"default"!==o&&function(t){a.d(e,t,function(){return i[t]})}(o);e["default"]=n.a},aa16:function(t,e,a){"use strict";function i(t,e){uni.setStorage({key:t,data:e,success:function(){console.log("setSuccess")}})}function n(t){var e;return uni.getStorage({key:t,success:function(t){e=t.data,console.log("getSuccess")}}),e}function o(t){uni.removeStorage({key:t,success:function(t){console.log("removeSuccess")}})}Object.defineProperty(e,"__esModule",{value:!0}),e.setStorage=i,e.getStorage=n,e.removeStorage=o},defe:function(t,e,a){var i=a("7ff6");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("54efada7",i,!0,{sourceMap:!1,shadowMode:!1})},e54d:function(t,e,a){"use strict";a.r(e);var i=a("f4b9"),n=a("7161");for(var o in n)"default"!==o&&function(t){a.d(e,t,function(){return n[t]})}(o);a("f0aa");var r=a("2877"),d=Object(r["a"])(n["default"],i["a"],i["b"],!1,null,"2b55202a",null);e["default"]=d.exports},f0aa:function(t,e,a){"use strict";var i=a("defe"),n=a.n(i);n.a},f4b9:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"container"},[a("lktauthorize",{ref:"lktAuthorizeComp"}),a("heads",{attrs:{title:t.title}}),a("div",{staticClass:"QR-content"},[a("p",[t._v("验证码")]),a("v-uni-input",{attrs:{type:"text",placeholder:"请输入提取验证码","placeholder-style":t.placeStyle},model:{value:t.shop_code,callback:function(e){t.shop_code=e},expression:"shop_code"}})],1),a("v-uni-button",{staticClass:"QR-btn",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.QRsuccess.apply(void 0,arguments)}}},[t._v("验证")])],1)},n=[];a.d(e,"a",function(){return i}),a.d(e,"b",function(){return n})}}]);