(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pagesB-expressage-expressage"],{"1d1c":function(t,e,a){"use strict";a.r(e);var i=a("f31c"),n=a.n(i);for(var o in i)"default"!==o&&function(t){a.d(e,t,function(){return i[t]})}(o);e["default"]=n.a},"36bf":function(t,e,a){var i=a("5ba3");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("9f42c6ac",i,!0,{sourceMap:!1,shadowMode:!1})},"3c6d":function(t,e,a){e=t.exports=a("2350")(!1),e.push([t.i,".container[data-v-208ef510]{min-height:100vh;background:#f6f6f6}.wl_content[data-v-208ef510]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;height:%?240?%;padding:%?30?%;background:#fff;margin-bottom:%?20?%}.wl_img[data-v-208ef510]{width:%?31?%;height:%?31?%;margin-right:%?14?%}.wx_title[data-v-208ef510]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;font-size:%?28?%;line-height:%?28?%;color:#020202}.scroll_view[data-v-208ef510]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.scroll_view_data[data-v-208ef510]{display:-webkit-box;display:-webkit-flex;display:flex;padding-top:%?32?%}.scroll_view_data>div[data-v-208ef510]{position:relative;width:%?120?%;height:%?120?%;margin-right:%?30?%;border:1px solid #e6e6e6}.scroll_view_data .img[data-v-208ef510]{width:100%;height:100%}.scroll_view_num[data-v-208ef510]{position:absolute;border-radius:50%;border:1px solid #f33;font-size:%?22?%;color:#f33;width:%?30?%;height:%?30?%;line-height:%?30?%;text-align:center;right:%?-13?%;top:%?-13?%;background:#fff}",""])},"453f":function(t,e,a){"use strict";var i=a("36bf"),n=a.n(i);n.a},5152:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{style:"display:flex;height:"+t.BoxHeight},[a("div",{staticClass:"head",class:{head_w:"秒杀"==t.title}},[a("div",{class:{white:!t.navWhite},style:{height:t.halfWidth}}),a("div",{staticClass:"header"},[t.flag&&!t.returnFlag?a("div",{on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t._back1.apply(void 0,arguments)}}},["秒杀"==t.title?a("img",{attrs:{src:t.back1}}):a("img",{attrs:{src:t.back}})]):t._e(),t.flag||t.returnFlag?t._e():a("img",{staticClass:"header_img",attrs:{src:t.bback},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t._back1.apply(void 0,arguments)}}}),a("p",{class:{title_w:"秒杀"==t.title}},[t._v(t._s(t.title))])])])])},n=[];a.d(e,"a",function(){return i}),a.d(e,"b",function(){return n})},"5ba3":function(t,e,a){e=t.exports=a("2350")(!1),e.push([t.i,".head[data-v-2dde4b93]{position:fixed;left:0;top:0;background-color:#fff;width:100%;z-index:9999;border-bottom:1px solid #eee}.head .white[data-v-2dde4b93]{background:#fff}.header[data-v-2dde4b93]{color:#fff;border:none}.header img[data-v-2dde4b93]{position:absolute;top:%?26?%;left:%?20?%;width:%?24?%;height:%?36?%}.header a[data-v-2dde4b93]{position:absolute;width:%?36?%;height:%?36?%;border-radius:50%}.header_img[data-v-2dde4b93]{top:%?46?%!important;left:%?10?%!important;width:%?64?%!important;height:%?64?%!important}.header p[data-v-2dde4b93]{text-align:center;width:100%;height:100%;line-height:%?88?%;color:#020202;font-size:%?32?%}.header>div[data-v-2dde4b93]{height:%?88?%;width:%?160?%;position:absolute;z-index:9999}.head_w[data-v-2dde4b93]{background:transparent;border-bottom:0}.title_w[data-v-2dde4b93]{color:#fff!important}",""])},6042:function(t,e,a){"use strict";a.r(e);var i=a("5152"),n=a("8b1f");for(var o in n)"default"!==o&&function(t){a.d(e,t,function(){return n[t]})}(o);a("453f");var r=a("2877"),s=Object(r["a"])(n["default"],i["a"],i["b"],!1,null,"2dde4b93",null);e["default"]=s.exports},"859d":function(t,e,a){"use strict";var i=a("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,a("c5f6");var n=i(a("cebc")),o=i(a("e814")),r=a("2f62"),s=a("aa16"),c={data:function(){return{flag:!0,bback:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon/bback.png",back:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png",back1:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png"}},computed:{halfWidth:function(){var t=(0,s.getStorage)("data_height")?(0,s.getStorage)("data_height"):this.$store.state.data_height,e=(0,o.default)(t);return e+"px"},BoxHeight:function(){var t=(0,s.getStorage)("data_height")?(0,s.getStorage)("data_height"):this.$store.state.data_height,e=0,a=(0,o.default)(t)+uni.upx2px(88);return e=a&&a>0?a:uni.upx2px(88),e+"px"}},onLoad:function(t){console.log("header"),console.log(this.returnR)},props:["title","returnR","navWhite","returnFlag"],methods:(0,n.default)({},(0,r.mapMutations)({status:"data_height"}),{_back:function(){this.flag=!1,console.log(this.returnR)},_back1:function(){switch(this.flag=!1,Number(this.returnR)){case 1:uni.navigateBack({delta:2});break;case 2:uni.switchTab({url:"../tabBar/shoppingCart"});break;case 3:uni.redirectTo({url:"../login/login.vue"});break;case 4:uni.navigateBack({delta:3});break;case 5:uni.redirectTo({url:"../order/myOrder"});break;case 6:uni.switchTab({url:"../../pages/tabBar/home"});break;case 7:uni.switchTab({url:"../../pages/tabBar/my"});break;case 8:uni.switchTab({url:"../tabBar/my"});break;case 9:uni.redirectTo({url:"/pagesA/myStore/myStore"});break;default:getCurrentPages().length>1?uni.navigateBack({delta:1}):uni.switchTab({url:"/pages/tabBar/home"})}this.flag=!0}})};e.default=c},"86f7":function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"container"},[a("lktauthorize",{ref:"lktAuthorizeComp",on:{pChangeLoginStatus:function(e){arguments[0]=e=t.$handleEvent(e),t.changeLoginStatus.apply(void 0,arguments)}}}),a("heads",{attrs:{title:t.title}}),t._l(t.list,function(e,i){return a("div",{key:i,staticClass:"wl_content",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t._goEx(i)}}},[a("div",{staticClass:"wx_title"},[a("img",{staticClass:"wl_img",attrs:{src:t.wl_img}}),t._v("物流单号："+t._s(e.courier_num))]),a("v-uni-scroll-view",{staticClass:"scroll_view",attrs:{"scroll-x":""}},[a("div",{staticClass:"scroll_view_data"},t._l(e.pro_list,function(e,i){return a("div",{key:i},[e.num>1?a("span",{staticClass:"scroll_view_num"},[t._v(t._s(e.num))]):t._e(),a("img",{staticClass:"img",attrs:{src:e.img}})])}),0)])],1)})],2)},n=[];a.d(e,"a",function(){return i}),a.d(e,"b",function(){return n})},"8b1f":function(t,e,a){"use strict";a.r(e);var i=a("859d"),n=a.n(i);for(var o in i)"default"!==o&&function(t){a.d(e,t,function(){return i[t]})}(o);e["default"]=n.a},"9d72":function(t,e,a){"use strict";var i=a("d3a1"),n=a.n(i);n.a},aa16:function(t,e,a){"use strict";function i(t,e){uni.setStorage({key:t,data:e,success:function(){console.log("setSuccess")}})}function n(t){var e;return uni.getStorage({key:t,success:function(t){e=t.data,console.log("getSuccess")}}),e}function o(t){uni.removeStorage({key:t,success:function(t){console.log("removeSuccess")}})}Object.defineProperty(e,"__esModule",{value:!0}),e.setStorage=i,e.getStorage=n,e.removeStorage=o},d3a1:function(t,e,a){var i=a("3c6d");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=a("4f06").default;n("389e2a2a",i,!0,{sourceMap:!1,shadowMode:!1})},f31c:function(t,e,a){"use strict";var i=a("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=i(a("f499")),o=i(a("6042")),r={data:function(){return{title:"查看物流",access_id:"",wl_img:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon/wuliu2x.png",list:[]}},components:{heads:o.default},onLoad:function(t){var e=this;if(t.sNo){var a=t.sNo,i={module:"app",action:"order",app:"logistics",id:a,access_id:this.access_id,type:""};1==this.source&&(i.type="pond"),uni.request({url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},data:i,method:"POST",success:function(t){uni.hideLoading(),200==t.data.code?e.list=t.data.res:uni.showToast({title:t.data.message,duration:1500,icon:"none"})},fail:function(t){uni.showToast({title:"数据加载失败！",duration:2e3,icon:"none"})}})}},methods:{_goEx:function(t){var e=this.list[t];uni.navigateTo({url:"../../pages/expressage/expressage?list="+(0,n.default)(e)})}}};e.default=r},fa4b:function(t,e,a){"use strict";a.r(e);var i=a("86f7"),n=a("1d1c");for(var o in n)"default"!==o&&function(t){a.d(e,t,function(){return n[t]})}(o);a("9d72");var r=a("2877"),s=Object(r["a"])(n["default"],i["a"],i["b"],!1,null,"208ef510",null);e["default"]=s.exports}}]);