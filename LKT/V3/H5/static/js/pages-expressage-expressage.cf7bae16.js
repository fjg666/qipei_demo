(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-expressage-expressage"],{"080c":function(e,t,a){"use strict";a.r(t);var i=a("e478"),n=a("0a6e");for(var s in n)"default"!==s&&function(e){a.d(t,e,function(){return n[e]})}(s);a("94a0");var o=a("2877"),r=Object(o["a"])(n["default"],i["a"],i["b"],!1,null,"12a55132",null);t["default"]=r.exports},"0a6e":function(e,t,a){"use strict";a.r(t);var i=a("7eb0"),n=a.n(i);for(var s in i)"default"!==s&&function(e){a.d(t,e,function(){return i[e]})}(s);t["default"]=n.a},"25db":function(e,t,a){var i=a("feaa");"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var n=a("4f06").default;n("796f6bb1",i,!0,{sourceMap:!1,shadowMode:!1})},"36bf":function(e,t,a){var i=a("5ba3");"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var n=a("4f06").default;n("9f42c6ac",i,!0,{sourceMap:!1,shadowMode:!1})},"453f":function(e,t,a){"use strict";var i=a("36bf"),n=a.n(i);n.a},5152:function(e,t,a){"use strict";var i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{style:"display:flex;height:"+e.BoxHeight},[a("div",{staticClass:"head",class:{head_w:"秒杀"==e.title}},[a("div",{class:{white:!e.navWhite},style:{height:e.halfWidth}}),a("div",{staticClass:"header"},[e.flag&&!e.returnFlag?a("div",{on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e._back1.apply(void 0,arguments)}}},["秒杀"==e.title?a("img",{attrs:{src:e.back1}}):a("img",{attrs:{src:e.back}})]):e._e(),e.flag||e.returnFlag?e._e():a("img",{staticClass:"header_img",attrs:{src:e.bback},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e._back1.apply(void 0,arguments)}}}),a("p",{class:{title_w:"秒杀"==e.title}},[e._v(e._s(e.title))])])])])},n=[];a.d(t,"a",function(){return i}),a.d(t,"b",function(){return n})},"5ba3":function(e,t,a){t=e.exports=a("2350")(!1),t.push([e.i,".head[data-v-2dde4b93]{position:fixed;left:0;top:0;background-color:#fff;width:100%;z-index:9999;border-bottom:1px solid #eee}.head .white[data-v-2dde4b93]{background:#fff}.header[data-v-2dde4b93]{color:#fff;border:none}.header img[data-v-2dde4b93]{position:absolute;top:%?26?%;left:%?20?%;width:%?24?%;height:%?36?%}.header a[data-v-2dde4b93]{position:absolute;width:%?36?%;height:%?36?%;border-radius:50%}.header_img[data-v-2dde4b93]{top:%?46?%!important;left:%?10?%!important;width:%?64?%!important;height:%?64?%!important}.header p[data-v-2dde4b93]{text-align:center;width:100%;height:100%;line-height:%?88?%;color:#020202;font-size:%?32?%}.header>div[data-v-2dde4b93]{height:%?88?%;width:%?160?%;position:absolute;z-index:9999}.head_w[data-v-2dde4b93]{background:transparent;border-bottom:0}.title_w[data-v-2dde4b93]{color:#fff!important}",""])},6042:function(e,t,a){"use strict";a.r(t);var i=a("5152"),n=a("8b1f");for(var s in n)"default"!==s&&function(e){a.d(t,e,function(){return n[e]})}(s);a("453f");var o=a("2877"),r=Object(o["a"])(n["default"],i["a"],i["b"],!1,null,"2dde4b93",null);t["default"]=r.exports},"7eb0":function(e,t,a){"use strict";var i=a("288e");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;i(a("7c44"));var n=i(a("6042")),s=(a("aa16"),a("d5ce")),o={data:function(){return{title:"物流信息",sNo:"",arr:new Array(5),access_id:"",courier_num:"",name:"",expressage:"",source:"",msg:"",zwwl:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/zwwl.png"}},onLoad:function(e){if(this.access_id=uni.getStorageSync("access_id")?uni.getStorageSync("access_id"):this.$store.state.access_id,e.list){var t=JSON.parse(e.list);this.courier_num=t.courier_num,this.name=t.kuaidi_name,this.expressage=t.list||[],0==this.expressage.length&&(this.msg="暂无物流信息")}},onShow:function(){this.$nextTick(function(){this.$refs.lktAuthorizeComp.handleAfterAuth(this,"../login/login?landing_code=1")})},methods:{changeLoginStatus:function(){this.access_id=uni.getStorageSync("access_id"),this._axios()},onCopy:function(){(0,s.copyText)("#courier_num input",this.courier_num)},onError:function(e){uni.showToast({title:"无法复制文本！",duration:1e3,icon:"none"})},_axios:function(){var e=this;uni.showLoading({title:"数据加载中..."});var t={module:"app",action:"order",app:"logistics",id:this.sNo,access_id:this.access_id,type:""};1==this.source&&(t.type="pond"),uni.request({url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},data:t,method:"POST",success:function(t){if(uni.hideLoading(),200==t.data.code){var a=t.data.res;e.courier_num=a[0].courier_num,e.name=a[0].kuaidi_name,e.expressage=a[0].list||[],0==e.expressage.length&&(e.msg="暂无物流信息")}else uni.showToast({title:t.data.message,duration:1500,icon:"none"})},fail:function(e){uni.showToast({title:"数据加载失败！",duration:2e3,icon:"none"})}})}},components:{heads:n.default}};t.default=o},"859d":function(e,t,a){"use strict";var i=a("288e");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,a("c5f6");var n=i(a("cebc")),s=i(a("e814")),o=a("2f62"),r=a("aa16"),c={data:function(){return{flag:!0,bback:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon/bback.png",back:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png",back1:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png"}},computed:{halfWidth:function(){var e=(0,r.getStorage)("data_height")?(0,r.getStorage)("data_height"):this.$store.state.data_height,t=(0,s.default)(e);return t+"px"},BoxHeight:function(){var e=(0,r.getStorage)("data_height")?(0,r.getStorage)("data_height"):this.$store.state.data_height,t=0,a=(0,s.default)(e)+uni.upx2px(88);return t=a&&a>0?a:uni.upx2px(88),t+"px"}},onLoad:function(e){console.log("header"),console.log(this.returnR)},props:["title","returnR","navWhite","returnFlag"],methods:(0,n.default)({},(0,o.mapMutations)({status:"data_height"}),{_back:function(){this.flag=!1,console.log(this.returnR)},_back1:function(){switch(this.flag=!1,Number(this.returnR)){case 1:uni.navigateBack({delta:2});break;case 2:uni.switchTab({url:"../tabBar/shoppingCart"});break;case 3:uni.redirectTo({url:"../login/login.vue"});break;case 4:uni.navigateBack({delta:3});break;case 5:uni.redirectTo({url:"../order/myOrder"});break;case 6:uni.switchTab({url:"../../pages/tabBar/home"});break;case 7:uni.switchTab({url:"../../pages/tabBar/my"});break;case 8:uni.switchTab({url:"../tabBar/my"});break;case 9:uni.redirectTo({url:"/pagesA/myStore/myStore"});break;default:getCurrentPages().length>1?uni.navigateBack({delta:1}):uni.switchTab({url:"/pages/tabBar/home"})}this.flag=!0}})};t.default=c},"8b1f":function(e,t,a){"use strict";a.r(t);var i=a("859d"),n=a.n(i);for(var s in i)"default"!==s&&function(e){a.d(t,e,function(){return i[e]})}(s);t["default"]=n.a},"94a0":function(e,t,a){"use strict";var i=a("25db"),n=a.n(i);n.a},aa16:function(e,t,a){"use strict";function i(e,t){uni.setStorage({key:e,data:t,success:function(){console.log("setSuccess")}})}function n(e){var t;return uni.getStorage({key:e,success:function(e){t=e.data,console.log("getSuccess")}}),t}function s(e){uni.removeStorage({key:e,success:function(e){console.log("removeSuccess")}})}Object.defineProperty(t,"__esModule",{value:!0}),t.setStorage=i,t.getStorage=n,t.removeStorage=s},e478:function(e,t,a){"use strict";var i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("lktauthorize",{ref:"lktAuthorizeComp",on:{pChangeLoginStatus:function(t){arguments[0]=t=e.$handleEvent(t),e.changeLoginStatus.apply(void 0,arguments)}}}),a("heads",{attrs:{title:e.title}}),a("div",{staticClass:"expressage_name"},[a("div",[a("p",[e._v("物流公司："),a("span",[e._v(e._s(e.name))])]),a("p",[e._v("物流单号："+e._s(e.courier_num))])]),a("div",{staticClass:"copy",attrs:{type:"button"},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.onCopy()}}},[e._v("复制")])]),a("v-uni-input",{staticClass:"courier_num_opacity",attrs:{id:"courier_num",type:"text"},model:{value:e.courier_num,callback:function(t){e.courier_num=t},expression:"courier_num"}}),a("div",{staticClass:"lines"}),e.expressage.length>0?a("ul",[e.expressage.length?e._l(e.expressage,function(t,i){return a("li",{key:i},[a("div",{staticClass:"expressage_right"},[a("p",[e._v(e._s(t.context)),a("span",{staticClass:"expressage_phone"})]),a("p",{staticClass:"expressage_time"},[a("span",[e._v(e._s(t.ftime))])])]),a("div",{staticClass:"expressage_left"},[a("div",{staticClass:"expressage_yuan"}),a("div",{ref:"expressage__xian",refInFor:!0,staticClass:"expressage__xian"})])])}):e._e(),e.expressage.length?e._e():a("li",[a("div",{staticClass:"expressage_right"}),a("div",{staticClass:"expressage_left"},[a("div",{staticClass:"expressage_yuan"}),a("div",{ref:"expressage__xian",staticClass:"expressage__xian"})])])],2):e._e(),e.expressage.length?e._e():a("div",{staticClass:"zwwl"},[a("img",{staticStyle:{width:"200upx",height:"227upx","margin-bottom":"20upx"},attrs:{src:e.zwwl}}),e._v("暂时还没有物流信息哦~")])],1)},n=[];a.d(t,"a",function(){return i}),a.d(t,"b",function(){return n})},feaa:function(e,t,a){t=e.exports=a("2350")(!1),t.push([e.i,".copy[data-v-12a55132]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.expressage_name[data-v-12a55132]{margin:%?30?%;position:relative}.expressage_name>div[data-v-12a55132]:first-child{padding-top:%?20?%}.expressage_name>div p[data-v-12a55132]{font-size:%?28?%;color:#9d9d9d}.expressage_name>div p[data-v-12a55132]:first-child{margin-bottom:%?16?%}.courier_num_opacity[data-v-12a55132]{opacity:0;position:absolute}.expressage_name>div span[data-v-12a55132]{color:#020202}.copy[data-v-12a55132]{width:%?100?%;height:%?40?%;border:1px solid #bbb;border-radius:%?8?%;color:#bbb;font-size:%?22?%;position:absolute;right:0;bottom:%?-10?%}ul[data-v-12a55132]{margin:%?30?%}li[data-v-12a55132]{padding-left:%?30?%;position:relative;height:%?180?%}.expressage_right p[data-v-12a55132]{font-size:%?28?%;color:#020202}.expressage_right p[data-v-12a55132]:first-child{margin-bottom:%?16?%}.expressage_right[data-v-12a55132]{margin-left:%?30?%}.expressage_time span[data-v-12a55132]{font-size:%?22?%;color:#9d9d9d}.expressage_phone[data-v-12a55132]{font-size:%?26?%;color:#0080ff}.expressage_left[data-v-12a55132]{position:absolute;left:0;bottom:%?10?%;margin-right:%?30?%}.expressage_yuan[data-v-12a55132]{width:%?20?%;height:%?20?%;border-radius:50%;background-color:#020202}.expressage__xian[data-v-12a55132]{height:%?124?%;border-left:1px solid #9d9d9d;position:absolute;left:%?9?%;bottom:%?35?%}li:last-child>div[data-v-12a55132]:last-child{border:none}.copy_input[data-v-12a55132]{border:none}\r\n\r\n/* 优化 */.lines[data-v-12a55132]{height:%?30?%;background-color:#eee;width:100%}.zwwl[data-v-12a55132]{text-align:center;color:#909090;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;padding-top:%?224?%;font-size:%?28?%;color:#888;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}",""])}}]);