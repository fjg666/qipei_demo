(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pagesA-bargain-bargain"],{"0d93":function(t,a,i){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,i("c5f6");var e={name:"load-more",props:{loadingType:{type:Number,default:0},showImage:{type:Boolean,default:!0},color:{type:String,default:"#777777"},contentText:{type:Object,default:function(){return{contentdown:"上拉显示更多",contentrefresh:"正在加载...",contentnomore:"没有更多数据了"}}}},data:function(){return{}}};a.default=e},"36bf":function(t,a,i){var e=i("5ba3");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var o=i("4f06").default;o("9f42c6ac",e,!0,{sourceMap:!1,shadowMode:!1})},"453f":function(t,a,i){"use strict";var e=i("36bf"),o=i.n(e);o.a},5152:function(t,a,i){"use strict";var e=function(){var t=this,a=t.$createElement,i=t._self._c||a;return i("div",{style:"display:flex;height:"+t.BoxHeight},[i("div",{staticClass:"head",class:{head_w:"秒杀"==t.title}},[i("div",{class:{white:!t.navWhite},style:{height:t.halfWidth}}),i("div",{staticClass:"header"},[t.flag&&!t.returnFlag?i("div",{on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t._back1.apply(void 0,arguments)}}},["秒杀"==t.title?i("img",{attrs:{src:t.back1}}):i("img",{attrs:{src:t.back}})]):t._e(),t.flag||t.returnFlag?t._e():i("img",{staticClass:"header_img",attrs:{src:t.bback},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t._back1.apply(void 0,arguments)}}}),i("p",{class:{title_w:"秒杀"==t.title}},[t._v(t._s(t.title))])])])])},o=[];i.d(a,"a",function(){return e}),i.d(a,"b",function(){return o})},"5ba3":function(t,a,i){a=t.exports=i("2350")(!1),a.push([t.i,".head[data-v-2dde4b93]{position:fixed;left:0;top:0;background-color:#fff;width:100%;z-index:9999;border-bottom:1px solid #eee}.head .white[data-v-2dde4b93]{background:#fff}.header[data-v-2dde4b93]{color:#fff;border:none}.header img[data-v-2dde4b93]{position:absolute;top:%?26?%;left:%?20?%;width:%?24?%;height:%?36?%}.header a[data-v-2dde4b93]{position:absolute;width:%?36?%;height:%?36?%;border-radius:50%}.header_img[data-v-2dde4b93]{top:%?46?%!important;left:%?10?%!important;width:%?64?%!important;height:%?64?%!important}.header p[data-v-2dde4b93]{text-align:center;width:100%;height:100%;line-height:%?88?%;color:#020202;font-size:%?32?%}.header>div[data-v-2dde4b93]{height:%?88?%;width:%?160?%;position:absolute;z-index:9999}.head_w[data-v-2dde4b93]{background:transparent;border-bottom:0}.title_w[data-v-2dde4b93]{color:#fff!important}",""])},6042:function(t,a,i){"use strict";i.r(a);var e=i("5152"),o=i("8b1f");for(var n in o)"default"!==n&&function(t){i.d(a,t,function(){return o[t]})}(n);i("453f");var s=i("2877"),r=Object(s["a"])(o["default"],e["a"],e["b"],!1,null,"2dde4b93",null);a["default"]=r.exports},"6b2e":function(t,a,i){"use strict";i.r(a);var e=i("82f6"),o=i("8f4c");for(var n in o)"default"!==n&&function(t){i.d(a,t,function(){return o[t]})}(n);i("c441");var s=i("2877"),r=Object(s["a"])(o["default"],e["a"],e["b"],!1,null,"27c470fc",null);a["default"]=r.exports},"75fc":function(t,a,i){"use strict";i.r(a);var e=i("a745"),o=i.n(e);function n(t){if(o()(t)){for(var a=0,i=new Array(t.length);a<t.length;a++)i[a]=t[a];return i}}var s=i("774e"),r=i.n(s),c=i("c8bb"),d=i.n(c);function l(t){if(d()(Object(t))||"[object Arguments]"===Object.prototype.toString.call(t))return r()(t)}function u(){throw new TypeError("Invalid attempt to spread non-iterable instance")}function g(t){return n(t)||l(t)||u()}i.d(a,"default",function(){return g})},"82f6":function(t,a,i){"use strict";var e=function(){var t=this,a=t.$createElement,i=t._self._c||a;return i("div",{staticClass:"yh-page"},[i("lktauthorize",{ref:"lktAuthorizeComp",on:{pChangeLoginStatus:function(a){arguments[0]=a=t.$handleEvent(a),t.changeLoginStatus.apply(void 0,arguments)}}}),i("heads",{attrs:{title:t.title,returnR:t.doodsreturn}}),t.load?i("div",{staticClass:"load"},[i("div",[i("img",{attrs:{src:t.loadGif}}),i("p",[t._v("加载中…")])])]):i("div",{staticStyle:{position:"relative"}},[t.brHeadImg?i("img",{directives:[{name:"show",rawName:"v-show",value:t.topTabBar,expression:"topTabBar"}],staticClass:"yh-brHeadImg",attrs:{src:t.brHeadImg}}):t._e(),t.topTabBar?i("div",[t.noBargain?t._e():i("div",{staticClass:"spacer"}),t._l(t.list,function(a,e){return i("div",{key:e,staticClass:"brDiv",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.goGoods(a.goods_id,a.attr_id,a.status,a.order_no,a.leftTime,a.bargain_id,a.hasorder,a.sNo_id,a.isbegin)}}},[i("div",{staticClass:"leftBrDiv"},[i("img",{attrs:{src:a.img}})]),i("div",{staticClass:"rightBrDiv"},[i("div",{staticClass:"proTitle"},[t._v(t._s(a.title))]),i("div",{staticClass:"proPrice"},[i("span",{staticClass:"newPrice"},[t._v("¥"+t._s(a.min_price))]),i("span",{staticClass:"oldPrice"},[t._v("¥"+t._s(a.price))])]),i("div",{staticClass:"group_num"},[i("v-uni-text",{staticClass:"g_n_num dayNum"},[t._v(t._s(a.day))]),i("v-uni-text",{staticClass:"yh-day"},[t._v("天")]),i("v-uni-text",{staticClass:"g_n_num"},[t._v(t._s(a.hour))]),i("span",{staticClass:"g_n_dian"},[t._v(":")]),i("v-uni-text",{staticClass:"g_n_num"},[t._v(t._s(a.mniuate))]),i("span",{staticClass:"g_n_dian"},[t._v(":")]),i("v-uni-text",{staticClass:"g_n_num yh-g-n-num"},[t._v(t._s(a.second))]),i("v-uni-text",{staticStyle:{color:"#999"}},[t._v(t._s(0==a.isbegin?"后开始":"后结束"))])],1),a.isbegin&&a.leftTime>0?i("div",{staticClass:"brBtn",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.toBargainIng(a.goods_id,a.attr_id,a.status,a.order_no,a.bargain_id,a.hasorder,a.leftTime)}}},[0==a.status?i("v-uni-text",[t._v("立即砍价")]):1==a.status?i("v-uni-text",[t._v("继续砍价")]):i("v-uni-text",[t._v("查看详情")])],1):a.isbegin?a.leftTime<0?i("div",{staticClass:"brBtn getGray"},[t._v("已结束")]):t._e():i("div",{staticClass:"brBtn getGray"},[t._v("未开始")])]),i("div",{staticClass:"spacer"})])}),i("v-uni-button",{staticClass:"btn-fixed",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.changeTabBar(!1)}}},[t._v("我的砍价")])],2):i("div",{staticClass:"mt-2"},t._l(t.list,function(a,e){return i("div",{key:e,staticClass:"brDiv",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.goGoods(a.goods_id,a.attr_id,a.status,a.order_no,a.leftTime,a.bargain_id,a.hasorder,a.sNo_id,a.isbegin)}}},[i("div",{staticClass:"leftBrDiv"},[i("img",{attrs:{src:a.img,alt:""}})]),i("div",{staticClass:"rightBrDiv"},[i("div",{staticClass:"proTitle"},[t._v(t._s(a.title))]),1==a.status&&a.original_price>0?i("div",{staticClass:"proPrice",staticStyle:{color:"#ff1818"}},[i("div",[i("span",{staticClass:"newPrice"},[t._v("¥"+t._s(a.min_price))]),i("span",{staticClass:"oldPrice",staticStyle:{color:"#999999"}},[t._v("¥"+t._s(a.price))])]),i("div",{staticClass:"yh-length"},[t._v("已砍"),i("span",[t._v(t._s(a.success_money))]),t._v("元，还差"),i("span",[t._v(t._s(a.original_price))]),t._v("元")])]):a.leftTime>0&&2==a.status&&1==a.gopay?i("div",{staticClass:"proPrice",staticStyle:{color:"#ff1818"}},[t._v("砍价成功，待付款")]):a.leftTime>0&&2==a.status?i("div",{staticClass:"proPrice",staticStyle:{color:"#ff1818"}},[t._v("已砍至最低价，砍价成功")]):-1==a.status?i("div",{staticClass:"proPrice",staticStyle:{color:"#ff1818"}},[a.original_price>0?i("v-uni-text",[t._v("未砍至最低价，砍价失败")]):i("v-uni-text",[t._v("砍价失败，付款超时")])],1):i("div",{staticClass:"proPrice",staticStyle:{color:"#ff1818"}},[2!=a.status||a.hasorder?1==a.gopay&&1==a.hasorder?i("v-uni-text",[t._v("砍价成功，待付款")]):3==a.status?i("v-uni-text",[t._v("砍价成功,已付款！")]):t._e():i("v-uni-text",[t._v("砍价成功，去付款")])],1),i("div",{staticClass:"group_num"},[a.day?i("span",[i("span",{staticClass:"g_n_num dayNum"},[t._v(t._s(a.day))]),i("span",{staticStyle:{margin:"0 5upx",color:"#020202"}},[t._v("天")])]):t._e(),i("v-uni-text",{staticClass:"g_n_num"},[t._v(t._s(a.hour))]),i("span",{staticClass:"g_n_dian"},[t._v(":")]),i("v-uni-text",{staticClass:"g_n_num"},[t._v(t._s(a.mniuate))]),i("span",{staticClass:"g_n_dian"},[t._v(":")]),i("v-uni-text",{staticClass:"g_n_num",staticStyle:{"margin-right":"10upx"}},[t._v(t._s(a.second))]),2==a.status?i("v-uni-text",{staticStyle:{color:"#999"}},[t._v("后取消订单")]):1==a.status?i("v-uni-text",{staticStyle:{color:"#999"}},[t._v("后结束")]):i("v-uni-text",{staticStyle:{color:"#999"}})],1),a.leftTime>0&&1==a.status?i("div",{staticClass:"brBtn",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.contBr(a.goods_id,a.attr_id,a.status,a.order_no,a.bargain_id,a.isbegin)}}},[t._v("继续砍价")]):2!=a.status||a.hasorder?1==a.gopay&&1==a.hasorder?i("div",{staticClass:"brBtn",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.lodingPay(a.sNo_id)}}},[t._v("待付款")]):a.leftTime<=0?i("div",{staticClass:"brBtn getGray"},[t._v("已结束")]):2==a.status||3==a.status||-1==a.status?i("div",{staticClass:"brBtn getGray",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.contBr(a.goods_id,a.attr_id,a.status,a.order_no,a.bargain_id,a.isbegin)}}},[t._v("查看详情")]):i("div",{staticClass:"brBtn getGray"},[t._v("查看详情")]):i("div",{staticClass:"brBtn",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.toPay(a.goods_id,a.attr_id,a.status,a.order_no,a.bargain_id,a.isbegin)}}},[t._v("去付款")])]),i("div",{staticClass:"spacer"})])}),0),t.noBargain?i("v-uni-view",{staticClass:"no-bargain"},[i("img",{attrs:{src:t.nobargainImg}}),i("p",[t._v("暂无砍价商品~")])]):t._e()],1),t.uniLoadMore?i("uni-load-more",{attrs:{loadingType:t.loadingType}}):t._e(),i("transition",{attrs:{name:"fade"}},[i("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:t.isShow,expression:"isShow"}],staticClass:"dialog"},[i("v-uni-view",{staticClass:"dialog-box"},[i("v-uni-view",{staticClass:"dialog-header"},[t._v("提示")]),i("v-uni-view",{staticClass:"dialog-content"},[i("p",[t._v(t._s(t.dialogContent))])]),i("v-uni-view",{staticClass:"dialog-footer"},[i("v-uni-view",{staticClass:"dialog-cancel",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.closeDialog.apply(void 0,arguments)}}},[t._v("否")]),i("v-uni-view",{staticClass:"dialog-confirm",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.clickConfirm.apply(void 0,arguments)}}},[t._v("是")])],1)],1)],1)],1)],1)},o=[];i.d(a,"a",function(){return e}),i.d(a,"b",function(){return o})},"859d":function(t,a,i){"use strict";var e=i("288e");Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,i("c5f6");var o=e(i("cebc")),n=e(i("e814")),s=i("2f62"),r=i("aa16"),c={data:function(){return{flag:!0,bback:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon/bback.png",back:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png",back1:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png"}},computed:{halfWidth:function(){var t=(0,r.getStorage)("data_height")?(0,r.getStorage)("data_height"):this.$store.state.data_height,a=(0,n.default)(t);return a+"px"},BoxHeight:function(){var t=(0,r.getStorage)("data_height")?(0,r.getStorage)("data_height"):this.$store.state.data_height,a=0,i=(0,n.default)(t)+uni.upx2px(88);return a=i&&i>0?i:uni.upx2px(88),a+"px"}},onLoad:function(t){console.log("header"),console.log(this.returnR)},props:["title","returnR","navWhite","returnFlag"],methods:(0,o.default)({},(0,s.mapMutations)({status:"data_height"}),{_back:function(){this.flag=!1,console.log(this.returnR)},_back1:function(){switch(this.flag=!1,Number(this.returnR)){case 1:uni.navigateBack({delta:2});break;case 2:uni.switchTab({url:"../tabBar/shoppingCart"});break;case 3:uni.redirectTo({url:"../login/login.vue"});break;case 4:uni.navigateBack({delta:3});break;case 5:uni.redirectTo({url:"../order/myOrder"});break;case 6:uni.switchTab({url:"../../pages/tabBar/home"});break;case 7:uni.switchTab({url:"../../pages/tabBar/my"});break;case 8:uni.switchTab({url:"../tabBar/my"});break;case 9:uni.redirectTo({url:"/pagesA/myStore/myStore"});break;default:getCurrentPages().length>1?uni.navigateBack({delta:1}):uni.switchTab({url:"/pages/tabBar/home"})}this.flag=!0}})};a.default=c},"8b1f":function(t,a,i){"use strict";i.r(a);var e=i("859d"),o=i.n(e);for(var n in e)"default"!==n&&function(t){i.d(a,t,function(){return e[t]})}(n);a["default"]=o.a},"8f4c":function(t,a,i){"use strict";i.r(a);var e=i("dc71"),o=i.n(e);for(var n in e)"default"!==n&&function(t){i.d(a,t,function(){return e[t]})}(n);a["default"]=o.a},"9c7d":function(t,a,i){var e=i("c428");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var o=i("4f06").default;o("70326944",e,!0,{sourceMap:!1,shadowMode:!1})},aa16:function(t,a,i){"use strict";function e(t,a){uni.setStorage({key:t,data:a,success:function(){console.log("setSuccess")}})}function o(t){var a;return uni.getStorage({key:t,success:function(t){a=t.data,console.log("getSuccess")}}),a}function n(t){uni.removeStorage({key:t,success:function(t){console.log("removeSuccess")}})}Object.defineProperty(a,"__esModule",{value:!0}),a.setStorage=e,a.getStorage=o,a.removeStorage=n},abad:function(t,a,i){var e=i("d26d");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var o=i("4f06").default;o("86062bf6",e,!0,{sourceMap:!1,shadowMode:!1})},c428:function(t,a,i){a=t.exports=i("2350")(!1),a.push([t.i,".load-more[data-v-0baca7bc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;height:%?80?%;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.loading-img[data-v-0baca7bc]{height:24px;width:24px;margin-right:10px}.loading-text[data-v-0baca7bc]{font-size:%?28?%;color:#777}.loading-img>uni-view[data-v-0baca7bc]{position:absolute}.load1[data-v-0baca7bc],.load2[data-v-0baca7bc],.load3[data-v-0baca7bc]{height:24px;width:24px}.load2[data-v-0baca7bc]{-webkit-transform:rotate(30deg);transform:rotate(30deg)}.load3[data-v-0baca7bc]{-webkit-transform:rotate(60deg);transform:rotate(60deg)}.loading-img>uni-view uni-view[data-v-0baca7bc]{width:6px;height:2px;border-top-left-radius:1px;border-bottom-left-radius:1px;background:#777;position:absolute;opacity:.2;-webkit-transform-origin:50%;transform-origin:50%;-webkit-animation:load-data-v-0baca7bc 1.56s ease infinite}.loading-img>uni-view uni-view[data-v-0baca7bc]:first-child{-webkit-transform:rotate(90deg);transform:rotate(90deg);top:2px;left:9px}.loading-img>uni-view uni-view[data-v-0baca7bc]:nth-child(2){-webkit-transform:rotate(180deg);top:11px;right:0}.loading-img>uni-view uni-view[data-v-0baca7bc]:nth-child(3){-webkit-transform:rotate(270deg);transform:rotate(270deg);bottom:2px;left:9px}.loading-img>uni-view uni-view[data-v-0baca7bc]:nth-child(4){top:11px;left:0}.load1 uni-view[data-v-0baca7bc]:first-child{-webkit-animation-delay:0s;animation-delay:0s}.load2 uni-view[data-v-0baca7bc]:first-child{-webkit-animation-delay:.13s;animation-delay:.13s}.load3 uni-view[data-v-0baca7bc]:first-child{-webkit-animation-delay:.26s;animation-delay:.26s}.load1 uni-view[data-v-0baca7bc]:nth-child(2){-webkit-animation-delay:.39s;animation-delay:.39s}.load2 uni-view[data-v-0baca7bc]:nth-child(2){-webkit-animation-delay:.52s;animation-delay:.52s}.load3 uni-view[data-v-0baca7bc]:nth-child(2){-webkit-animation-delay:.65s;animation-delay:.65s}.load1 uni-view[data-v-0baca7bc]:nth-child(3){-webkit-animation-delay:.78s;animation-delay:.78s}.load2 uni-view[data-v-0baca7bc]:nth-child(3){-webkit-animation-delay:.91s;animation-delay:.91s}.load3 uni-view[data-v-0baca7bc]:nth-child(3){-webkit-animation-delay:1.04s;animation-delay:1.04s}.load1 uni-view[data-v-0baca7bc]:nth-child(4){-webkit-animation-delay:1.17s;animation-delay:1.17s}.load2 uni-view[data-v-0baca7bc]:nth-child(4){-webkit-animation-delay:1.3s;animation-delay:1.3s}.load3 uni-view[data-v-0baca7bc]:nth-child(4){-webkit-animation-delay:1.43s;animation-delay:1.43s}@-webkit-keyframes load-data-v-0baca7bc{0%{opacity:1}to{opacity:.2}}",""])},c441:function(t,a,i){"use strict";var e=i("abad"),o=i.n(e);o.a},c566:function(t,a,i){"use strict";i.r(a);var e=i("0d93"),o=i.n(e);for(var n in e)"default"!==n&&function(t){i.d(a,t,function(){return e[t]})}(n);a["default"]=o.a},d26d:function(t,a,i){a=t.exports=i("2350")(!1),a.push([t.i,".head[data-v-27c470fc]{height:%?88?%;padding:0 %?30?%;border-bottom:1px solid #eee;font-size:%?40?%;color:#242424;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.head_img[data-v-27c470fc]{width:%?24?%;height:%?36?%}.getGray[data-v-27c470fc]{border:1px solid #999!important;color:#999!important}.dayNum[data-v-27c470fc]{display:inline-block;text-align:center;border-radius:%?5?%}.group_num[data-v-27c470fc]{font-size:%?22?%;color:#999;position:absolute;bottom:%?30?%}.g_n_num[data-v-27c470fc]{background:#020202;border-radius:%?6?%;width:%?38?%;display:inline-block;text-align:center;color:#fff;height:%?34?%;line-height:%?34?%}.g_n_dian[data-v-27c470fc]{margin:%?0?% %?4?%;color:#020202}.brBtn[data-v-27c470fc]{font-size:%?30?%;height:%?56?%;width:%?140?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;border:1px solid #242424;color:#242424;border-radius:%?5?%;position:absolute;right:0;bottom:%?30?%;font-weight:700}.brNum[data-v-27c470fc]{color:#242424;font-size:%?24?%;position:absolute;bottom:0}.oldPrice[data-v-27c470fc]{font-size:%?24?%!important;text-decoration:line-through}.newPrice[data-v-27c470fc]{color:#ff1818;font-size:%?35?%;margin:0 %?10?%;font-weight:700}.proPrice[data-v-27c470fc]{color:#999;font-size:%?26?%;position:absolute;top:0;bottom:0;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-flex-wrap:wrap;flex-wrap:wrap;-webkit-align-content:center;align-content:center}.proPrice1[data-v-27c470fc]{color:#ff1818;font-size:%?26?%;margin-top:%?5?%}.proTitle[data-v-27c470fc]{font-size:%?28?%;color:#000;font-weight:700}.rightBrDiv[data-v-27c470fc]{width:%?490?%;height:%?230?%;text-align:left;position:relative}.leftBrDiv[data-v-27c470fc]{width:%?150?%;height:%?200?%;margin-right:%?30?%}.leftBrDiv img[data-v-27c470fc]{width:%?150?%;height:%?150?%}.brDiv[data-v-27c470fc]{background-color:#fff;padding:%?20?% %?40?%;height:%?270?%;width:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding-top:%?40?%;position:relative}.topTabBar[data-v-27c470fc]{height:%?90?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-justify-content:space-around;justify-content:space-around;border-bottom:1px solid #eee;font-size:%?30?%;background-color:#fff;color:#999}.topTabBar div[data-v-27c470fc]{height:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:0 %?10?%;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.active[data-v-27c470fc]{border-bottom:2px solid #000;color:#242424!important;font-weight:800}.no-bargain[data-v-27c470fc]{pointer-events:none;width:100%;text-align:center;padding-top:%?199?%;background-color:#f6f6f6}.no-bargain p[data-v-27c470fc]{height:%?29?%;line-height:%?36?%;color:#666;font-size:%?30?%;font-weight:500}.no-bargain img[data-v-27c470fc]{display:block;width:%?240?%;height:%?238?%;margin:auto;margin-bottom:%?45?%}.spacer[data-v-27c470fc]{height:%?10?%;background-color:#f6f6f6;width:100%;position:absolute;bottom:0;left:0}.btn-fixed[data-v-27c470fc]{display:-webkit-box;display:-webkit-flex;display:flex;position:fixed;right:%?30?%;bottom:%?120?%;width:%?80?%;height:%?80?%;border-radius:50%;background-color:rgba(36,36,36,.8);color:#fff;font-size:%?25?%;line-height:%?30?%;padding:%?10?%;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.btn-fixed[data-v-27c470fc]:after{border:0}.mt-2[data-v-27c470fc]{margin-top:%?20?%}.uni-modal[data-v-27c470fc]{border-radius:%?23?%}.uni-modal__hd[data-v-27c470fc]{border-bottom:1px #eee solid}.dialog[data-v-27c470fc]{position:fixed;top:0;right:0;bottom:0;left:0;background-color:rgba(0,0,0,.4);z-index:999}.dialog .dialog-box[data-v-27c470fc]{width:%?520?%;min-height:%?288?%;background-color:#fff;border-radius:%?23?%;margin:%?468?% auto auto}.dialog .dialog-header[data-v-27c470fc]{height:%?78?%;line-height:%?78?%;text-align:center;font-size:%?32?%;font-weight:700;color:#242424;border-bottom:%?4?% #eee solid}.dialog .dialog-content[data-v-27c470fc]{line-height:%?44?%;min-height:%?126?%;padding:%?22?% %?100?%;font-size:%?26?%;font-weight:500;color:#444;text-align:center;box-sizing:border-box}.dialog .dialog-footer[data-v-27c470fc]{height:%?80?%;border-top:%?1?% #eee solid;box-sizing:border-box;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.dialog .dialog-footer uni-view[data-v-27c470fc]{width:50%;height:%?78?%;line-height:%?78?%;color:#888;font-size:%?30?%;text-align:center}.dialog .dialog-footer .dialog-confirm[data-v-27c470fc]{border-left:%?1?% #eee solid;color:#000}.fade-enter-active[data-v-27c470fc],.fade-leave-active[data-v-27c470fc]{-webkit-transition:all .3s;transition:all .3s}.fade-enter[data-v-27c470fc],.fade-leave-to[data-v-27c470fc]{-webkit-transform:scale(1.2);transform:scale(1.2);opacity:0}.heads[data-v-27c470fc]{display:-webkit-box;display:-webkit-flex;display:flex;width:100%;height:%?88?%;line-height:%?88?%;-webkit-box-align:start;-webkit-align-items:flex-start;align-items:flex-start;-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;-webkit-box-align:baseline;-webkit-align-items:baseline;align-items:baseline;background-color:#fff;border-bottom:1px solid #eee;z-index:9999;box-sizing:initial}.heads .head-right[data-v-27c470fc],.heads .heads-left[data-v-27c470fc]{width:%?60?%;min-width:%?60?%;height:%?88?%;text-align:center}.heads-centent[data-v-27c470fc]{width:%?630?%;text-align:center;font-size:%?32?%;color:#020202}.heads-img[data-v-27c470fc]{width:%?24?%;height:%?36?%}.data_h_h[data-v-27c470fc]{position:fixed;top:0;left:0;right:0;background:#fff;z-index:9999}.yh-length[data-v-27c470fc]{width:%?320?%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}\r\n\r\n/* 优化 */.yh-page[data-v-27c470fc]{min-height:100vh;background-color:#f6f6f6}.yh-brHeadImg[data-v-27c470fc]{height:%?320?%;width:100%}.yh-day[data-v-27c470fc]{margin:0 %?5?%;color:#020202}.yh-g-n-num[data-v-27c470fc]{margin-right:%?10?%}",""])},d5a1:function(t,a,i){"use strict";var e=i("9c7d"),o=i.n(e);o.a},dc71:function(t,a,i){"use strict";var e=i("288e");Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var o=e(i("75fc")),n=e(i("e814")),s=e(i("f499")),r=e(i("795b")),c=e(i("6042")),d=(i("2f62"),e(i("e6ce"))),l={data:function(){return{doodsreturn:0,timeid:0,groupList:[],title:"热门砍价",access_id:"",loadGif:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"/images/icon1/loading.gif",nobargainImg:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"/images/icon1/noFind.png",brHeadImg:"",load:!1,topTabBar:!0,list:"",page1:1,page2:1,noBargain:!1,loadingType:0,daodi:!1,obj:{},isShow:!1,dialogContent:"",uniLoadMore:!1,hasorder:0}},onLoad:function(t){var a=this;t.topTabBar?(console.log("转发"),this.doodsreturn=6):(a.topTabBar=!1,uni.setNavigationBarTitle({title:"我的砍价"}),a.title="我的砍价"),a.access_id=uni.getStorageSync("access_id")},onShow:function(){var t=this;t.access_id=uni.getStorageSync("access_id"),t.page1=1,t.page2=1;var a=new r.default(function(a,i){t.LaiKeTuiCommon.getLKTApiUrl().then(function(){a(1231)})});a.then(function(){t.$nextTick(function(){t.access_id=uni.getStorageSync("access_id")?uni.getStorageSync("access_id"):t.$store.state.access_id,t._axios()})})},methods:{_back:function(){this.topTabBar?uni.switchTab({url:"../../pages/tabBar/home"}):uni.switchTab({url:"../../pages/tabBar/my"})},changeLoginStatus:function(){var t=this;t.access_id=t.$store.state.access_id,t._axios()},toPay:function(t,a,i,e,o){var n=[];n.push({pid:t}),n.push({cid:a}),n.push({num:1}),n.push({bargain:!0}),n.push({bargain_id:o}),n.push({order_no:e}),n=(0,s.default)(n);var r=window.localStorage;r.product=n,r.bargain=!0,r.bargain_id=o,r.order_no=e,uni.setStorageSync("bargain",!0),uni.navigateTo({url:"../../pages/pay/orderDetailsr?product="+n+"&bargain=true&bargain_id="+o+"&order_no="+e})},contBr:function(t,a,i,e,o){uni.navigateTo({url:"bargainIng?proId="+t+"&attr_id="+a+"&brStatus="+i+"&order_no="+e+"&bargain_id="+o})},goGoods:function(t,a,i,e,o,n,s,r,c){this.$store.state.pro_id=t;var d=3;0==i?d=4:1==i?d=0:2==i?d=1:3==i&&(d=2),o<=0&&(d=3),o>0&&2==i&&s?uni.navigateTo({url:"../../pages/goods/goodsDetailed?bargain=true&isbegin="+c+"&pro_id="+t+"&brStatus="+d+"&attr_id="+a+"&order_no="+e+"&leftTime="+o+"&bargain_id="+n+"&hasorder="+s+"&sNo_id="+r}):uni.navigateTo({url:"../../pages/goods/goodsDetailed?bargain=true&pro_id="+t+"&brStatus="+d+"&attr_id="+a+"&order_no="+e+"&leftTime="+o+"&bargain_id="+n+"&isbegin="+c})},lodingPay:function(t){uni.navigateTo({url:"../../pages/order/order?order_id="+t+"&showPay=true"})},setTimeData:function(){var t=this;if(0===t.groupList.length)return!1;for(var a=0;a<t.groupList.length;a++){var i=!0;if(t.topTabBar){var e=--t.groupList[a].leftTime;t.groupList[a].leftTime<0&&(i=!1)}else if(2==t.groupList[a].status){e=--t.groupList[a].canbuy;t.groupList[a].canbuy<=0&&(i=!1)}else{e=--t.groupList[a].leftTime;(t.groupList[a].leftTime<=0||3==t.groupList[a].status||-1==t.groupList[a].status)&&(i=!1)}if(i){var o=Math.floor((0,n.default)(e)/86400),s=Math.floor(e/3600-24*o),r=Math.floor((e-60*s*60-24*o*60*60)/60),c=e%60;s<10&&(s="0"+s),r<10&&(r="0"+r),c<10&&(c="0"+c),0==o&&(o="0"),t.groupList[a].hour=isNaN(s)?"00":s,t.groupList[a].mniuate=isNaN(s)?"00":r,t.groupList[a].second=isNaN(s)?"00":c,t.groupList[a].day=isNaN(s)?"00":o}else t.groupList[a].hour="00",t.groupList[a].mniuate="00",t.groupList[a].second="00",t.groupList[a].day="0"}0===t.timeid&&(t.timeid=setInterval(function(){for(var a=0;a<t.groupList.length;a++){var i=!0;if(t.topTabBar){var e=--t.groupList[a].leftTime;t.groupList[a].leftTime<0&&(i=!1)}else if(2==t.groupList[a].status){e=--t.groupList[a].canbuy;t.groupList[a].canbuy<=0&&(i=!1)}else{e=--t.groupList[a].leftTime;(t.groupList[a].leftTime<=0||3==t.groupList[a].status||-1==t.groupList[a].status)&&(i=!1)}if(i){var o=Math.floor((0,n.default)(e)/86400),s=Math.floor(e/3600-24*o),r=Math.floor((e-60*s*60-24*o*60*60)/60),c=e%60;s<10&&(s="0"+s),r<10&&(r="0"+r),c<10&&(c="0"+c),0==o&&(o="0"),t.groupList[a].hour=s,t.groupList[a].mniuate=r,t.groupList[a].second=c,t.groupList[a].day=o}else t.groupList[a].hour="00",t.groupList[a].mniuate="00",t.groupList[a].second="00",t.groupList[a].day="0"}},1e3)),setTimeout(function(){t.list=t.groupList},0)},closeDialog:function(){this.isShow=!1},clickConfirm:function(){var t=this;this.closeDialog(),uni.navigateTo({url:"bargainIng?proId="+t.obj.proId+"&attr_id="+t.obj.attr_id+"&brStatus="+t.obj.brStatus+"&bargain_id="+t.obj.bargain_id+"&order_no="+t.obj.order_no+"&hasorder="+t.hasorder})},toBargainIng:function(t,a,i,e,o,n,s){if(!(s<=0)){var r=this,c={module:"app",action:"login",app:"token",access_id:this.access_id};uni.request({url:uni.getStorageSync("url"),data:c,success:function(c){if(200==c.data.code&&1===c.data.login_status)if(console.log(i+"---leftTime----"+s),0!=i&&s>0){var d={4:"砍价失败，是否查看详情？",0:"此商品砍价结束，是否查看详情？",1:"您已参与此商品的砍价活动，是否查看详情？",2:"您已完成砍价，是否查看详情？",3:"您已付款此商品，是否查看详情？"};r.obj={proId:t,attr_id:a,brStatus:i,order_no:e,bargain_id:o,hasorder:n},r.dialogContent=i<0?-1==i?d[0]:d[4]:d[i],r.isShow=!0}else 0==i&&uni.navigateTo({url:"bargainIng?proId="+t+"&attr_id="+a+"&brStatus="+i+"&bargain_id="+o+"&order_no="+e});else r.$refs.lktAuthorizeComp.handleAfterAuth(r,"../../pages/login/login?landing_code=1")}})}},timeout:function(){uni.showToast({title:"未登录，请先登录!",duration:1e3,icon:"none"}),setTimeout(function(){uni.navigateTo({url:"../../pages/login/login?landing_code=1"})},1e3)},changeTabBar:function(t){var a=this;a.$refs.lktAuthorizeComp.handleAfterAuth(a,"../../pages/login/login?landing_code=1",function(){a.list="",a.topTabBar=t,a._axios()})},_axios:function(){var t=this;t.groupList=[],t.loadingType=0,t.daodi=!1;var a={access_id:t.access_id,module:"app",action:"bargain"};this.topTabBar?(a.m="bargainhome",a.page=this.page1):(a.m="mybargain",a.page=this.page2),uni.request({url:uni.getStorageSync("url"),data:a,header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(a){var i;200==a.data.code?(t.uniLoadMore=!0,t.brHeadImg=a.data.img,t.list=a.data.list,console.log(t.list),(i=t.groupList).push.apply(i,(0,o.default)(a.data.list)),t.setTimeData(),t.noBargain=!a.data.list.length,a.data.list.length<10&&(t.loadingType=2,t.daodi=!0)):404==a.data.code?(t.topTabBar=!0,console.log("#########################")):(t.list=[],uni.showToast({title:a.data.message,icon:"none",duration:1500}))}})}},onReachBottom:function(){var t=this;if(this.daodi)return!1;var a={access_id:this.access_id,module:"app",action:"bargain"};this.topTabBar?(a.m="bargainhome",a.page=++this.page1):(a.m="mybargain",a.page=++this.page2),this.loadingType=1,this.$req.post({data:a}).then(function(a){var i;200==a.code&&(a.list.length?(t.list=t.list.concat(a.list),(i=t.groupList).push.apply(i,(0,o.default)(a.list)),a.list.length<10&&(t.loadingType=2,t.topTabBar?t.page1=1:t.page2=1,t.daodi=!0)):t.loadingType=2)})},computed:{halfWidth:function(){var t=uni.getStorageSync("data_height")?uni.getStorageSync("data_height"):this.$store.state.data_height,a=(0,n.default)(t),i=2*a;return uni.upx2px(i)+"px"}},components:{uniLoadMore:d.default,heads:c.default}};a.default=l},e6ce:function(t,a,i){"use strict";i.r(a);var e=i("fb8f"),o=i("c566");for(var n in o)"default"!==n&&function(t){i.d(a,t,function(){return o[t]})}(n);i("d5a1");var s=i("2877"),r=Object(s["a"])(o["default"],e["a"],e["b"],!1,null,"0baca7bc",null);a["default"]=r.exports},fb8f:function(t,a,i){"use strict";var e=function(){var t=this,a=t.$createElement,i=t._self._c||a;return i("v-uni-view",{staticClass:"load-more"},[i("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:1===t.loadingType&&t.showImage,expression:"loadingType === 1 && showImage"}],staticClass:"loading-img"},[i("v-uni-view",{staticClass:"load1"},[i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}})],1),i("v-uni-view",{staticClass:"load2"},[i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}})],1),i("v-uni-view",{staticClass:"load3"},[i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}}),i("v-uni-view",{style:{background:t.color}})],1)],1),i("v-uni-text",{staticClass:"loading-text",style:{color:t.color}},[t._v(t._s(0===t.loadingType?t.contentText.contentdown:1===t.loadingType?t.contentText.contentrefresh:t.contentText.contentnomore))])],1)},o=[];i.d(a,"a",function(){return e}),i.d(a,"b",function(){return o})}}]);