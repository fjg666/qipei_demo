(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-address-receivingAddress"],{"00b1":function(e,t,a){"use strict";a.r(t);var i=a("983b"),d=a.n(i);for(var s in i)"default"!==s&&function(e){a.d(t,e,function(){return i[e]})}(s);t["default"]=d.a},"1d25":function(e,t,a){"use strict";var i=a("4a2f"),d=a.n(i);d.a},"36bf":function(e,t,a){var i=a("5ba3");"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var d=a("4f06").default;d("9f42c6ac",i,!0,{sourceMap:!1,shadowMode:!1})},3811:function(e,t,a){"use strict";var i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return e.show?a("v-uni-view",{staticClass:"delmodel"},[a("v-uni-view",{staticClass:"delmodel-card"},[a("v-uni-view",{staticClass:"delmodel-card-body"},[e._v(e._s(e.content||e.text))]),a("v-uni-view",{staticClass:"delmodel-card-btn"},[a("v-uni-view",{staticClass:"cancel",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.cancel.apply(void 0,arguments)}}},[e._v("取消")]),a("v-uni-view",{staticClass:"confirm",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.handleClick.apply(void 0,arguments)}}},[e._v("确认")])],1)],1)],1):e._e()},d=[];a.d(t,"a",function(){return i}),a.d(t,"b",function(){return d})},"3eed":function(e,t,a){var i=a("c118");"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var d=a("4f06").default;d("eb487402",i,!0,{sourceMap:!1,shadowMode:!1})},45179:function(e,t,a){"use strict";var i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticStyle:{"min-height":"100vh","background-color":"#F6f6f6"}},[a("lktauthorize",{ref:"lktAuthorizeComp",on:{pChangeLoginStatus:function(t){arguments[0]=t=e.$handleEvent(t),e.changeLoginStatus.apply(void 0,arguments)}}}),a("div",{staticStyle:{position:"relative"}},[a("heads",{attrs:{title:e.title}}),e.manage?a("div",{staticClass:"manage",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e._manage.apply(void 0,arguments)}}},[e._v(e._s(e.address_m))]):e._e()],1),e.address?e._e():a("div",{staticClass:"address_wu",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e._uni_navigateTo("addAddress?state_addre=1")}}},[a("img",{attrs:{src:e.add}}),a("p",[e._v("添加地址")])]),!e.address?e._e():a("ul",{staticClass:"address"},e._l(e.address,function(t,i){return a("li",{key:t.id},[a("div",{staticClass:"address_top",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e._state_manage(t)}}},[a("div",[a("div",{staticClass:"address_user"},[a("span",{staticStyle:{"margin-right":"30upx"}},[e._v(e._s(t.name))]),a("span",[e._v(e._s(t.tel))])]),a("div",{staticClass:"address_xs"},[a("div",{directives:[{name:"show",rawName:"v-show",value:0!=t.is_default,expression:"item.is_default==0?false:true"}],staticClass:"address_ms"},[e._v("默认")]),a("p",[e._v(e._s(t.address_xq))])])]),e.re_img?a("img",{staticClass:"quan_img",attrs:{src:e.addre_id==t.addr_id?e.circle_hei:e.circle_hui}}):e._e()]),e.del?a("div",{staticClass:"address_foot"},[a("div",{staticClass:"address_left",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e._default(t.addr_id,i)}}},[a("img",{staticClass:"quan_img",attrs:{src:0==t.is_default?e.circle_hui:e.circle_hei}}),a("span",[e._v("默认地址")])]),a("div",{staticClass:"address_right",staticStyle:{display:"flex"}},[a("div",{on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e._addAddress(t.addr_id)}}},[a("img",{staticClass:"quan_img",attrs:{src:e.edtAdd}}),a("span",{staticStyle:{"margin-right":"30upx"}},[e._v("编辑")])]),a("div",{on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e.delAddress(t.addr_id,i)}}},[a("img",{staticClass:"quan_img",attrs:{src:e.delAdd}}),a("span",[e._v("删除")])])])]):e._e()])}),0),a("div",{staticClass:"bottom",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e._uni_navigateTo("addAddress?state_addre=1")}}},[e._v("添加新地址")]),a("lkdelModel",{attrs:{content:e.text},on:{"on-click":function(t){arguments[0]=t=e.$handleEvent(t),e._delAddress.apply(void 0,arguments)}},model:{value:e.lkdelModel,callback:function(t){e.lkdelModel=t},expression:"lkdelModel"}})],1)},d=[];a.d(t,"a",function(){return i}),a.d(t,"b",function(){return d})},"453f":function(e,t,a){"use strict";var i=a("36bf"),d=a.n(i);d.a},"4a2f":function(e,t,a){var i=a("94f2");"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var d=a("4f06").default;d("e24ee180",i,!0,{sourceMap:!1,shadowMode:!1})},5152:function(e,t,a){"use strict";var i=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{style:"display:flex;height:"+e.BoxHeight},[a("div",{staticClass:"head",class:{head_w:"秒杀"==e.title}},[a("div",{class:{white:!e.navWhite},style:{height:e.halfWidth}}),a("div",{staticClass:"header"},[e.flag&&!e.returnFlag?a("div",{on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e._back1.apply(void 0,arguments)}}},["秒杀"==e.title?a("img",{attrs:{src:e.back1}}):a("img",{attrs:{src:e.back}})]):e._e(),e.flag||e.returnFlag?e._e():a("img",{staticClass:"header_img",attrs:{src:e.bback},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e._back1.apply(void 0,arguments)}}}),a("p",{class:{title_w:"秒杀"==e.title}},[e._v(e._s(e.title))])])])])},d=[];a.d(t,"a",function(){return i}),a.d(t,"b",function(){return d})},"5ba3":function(e,t,a){t=e.exports=a("2350")(!1),t.push([e.i,".head[data-v-2dde4b93]{position:fixed;left:0;top:0;background-color:#fff;width:100%;z-index:9999;border-bottom:1px solid #eee}.head .white[data-v-2dde4b93]{background:#fff}.header[data-v-2dde4b93]{color:#fff;border:none}.header img[data-v-2dde4b93]{position:absolute;top:%?26?%;left:%?20?%;width:%?24?%;height:%?36?%}.header a[data-v-2dde4b93]{position:absolute;width:%?36?%;height:%?36?%;border-radius:50%}.header_img[data-v-2dde4b93]{top:%?46?%!important;left:%?10?%!important;width:%?64?%!important;height:%?64?%!important}.header p[data-v-2dde4b93]{text-align:center;width:100%;height:100%;line-height:%?88?%;color:#020202;font-size:%?32?%}.header>div[data-v-2dde4b93]{height:%?88?%;width:%?160?%;position:absolute;z-index:9999}.head_w[data-v-2dde4b93]{background:transparent;border-bottom:0}.title_w[data-v-2dde4b93]{color:#fff!important}",""])},6042:function(e,t,a){"use strict";a.r(t);var i=a("5152"),d=a("8b1f");for(var s in d)"default"!==s&&function(e){a.d(t,e,function(){return d[e]})}(s);a("453f");var n=a("2877"),o=Object(n["a"])(d["default"],i["a"],i["b"],!1,null,"2dde4b93",null);t["default"]=o.exports},"7ef5":function(e,t,a){"use strict";a.r(t);var i=a("45179"),d=a("00b1");for(var s in d)"default"!==s&&function(e){a.d(t,e,function(){return d[e]})}(s);a("9a85");var n=a("2877"),o=Object(n["a"])(d["default"],i["a"],i["b"],!1,null,"5d50d1cc",null);t["default"]=o.exports},"859d":function(e,t,a){"use strict";var i=a("288e");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,a("c5f6");var d=i(a("cebc")),s=i(a("e814")),n=a("2f62"),o=a("aa16"),r={data:function(){return{flag:!0,bback:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon/bback.png",back:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png",back1:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/back2x.png"}},computed:{halfWidth:function(){var e=(0,o.getStorage)("data_height")?(0,o.getStorage)("data_height"):this.$store.state.data_height,t=(0,s.default)(e);return t+"px"},BoxHeight:function(){var e=(0,o.getStorage)("data_height")?(0,o.getStorage)("data_height"):this.$store.state.data_height,t=0,a=(0,s.default)(e)+uni.upx2px(88);return t=a&&a>0?a:uni.upx2px(88),t+"px"}},onLoad:function(e){console.log("header"),console.log(this.returnR)},props:["title","returnR","navWhite","returnFlag"],methods:(0,d.default)({},(0,n.mapMutations)({status:"data_height"}),{_back:function(){this.flag=!1,console.log(this.returnR)},_back1:function(){switch(this.flag=!1,Number(this.returnR)){case 1:uni.navigateBack({delta:2});break;case 2:uni.switchTab({url:"../tabBar/shoppingCart"});break;case 3:uni.redirectTo({url:"../login/login.vue"});break;case 4:uni.navigateBack({delta:3});break;case 5:uni.redirectTo({url:"../order/myOrder"});break;case 6:uni.switchTab({url:"../../pages/tabBar/home"});break;case 7:uni.switchTab({url:"../../pages/tabBar/my"});break;case 8:uni.switchTab({url:"../tabBar/my"});break;case 9:uni.redirectTo({url:"/pagesA/myStore/myStore"});break;default:getCurrentPages().length>1?uni.navigateBack({delta:1}):uni.switchTab({url:"/pages/tabBar/home"})}this.flag=!0}})};t.default=r},"87a1":function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i={props:["value","content"],data:function(){return{text:"确认将这个地址删除？",show:!1}},watch:{value:function(e){this.show=e},show:function(e){console.log(e),this.$emit("input",e)}},methods:{cancel:function(){this.show=!this.show},handleClick:function(){this.$emit("on-click")}}};t.default=i},"8b1f":function(e,t,a){"use strict";a.r(t);var i=a("859d"),d=a.n(i);for(var s in i)"default"!==s&&function(e){a.d(t,e,function(){return i[e]})}(s);t["default"]=d.a},"94f2":function(e,t,a){t=e.exports=a("2350")(!1),t.push([e.i,".delmodel[data-v-acf53e46]{width:100%;min-height:100vh;position:fixed;background:rgba(0,0,0,.6);top:0;z-index:9999;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.delmodel-card[data-v-acf53e46]{width:%?550?%;height:%?250?%;background:#fff;border-radius:%?23?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column}.delmodel-card-body[data-v-acf53e46]{-webkit-box-flex:1;-webkit-flex:1;flex:1;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;color:#020202;font-size:%?30?%}.delmodel-card-btn[data-v-acf53e46]{border-top:%?2?% solid #eee;-webkit-column-count:2;column-count:2;-webkit-column-rule:%?2?% solid #eee;column-rule:%?2?% solid #eee;text-align:center}.delmodel-card-btn .cancel[data-v-acf53e46]{color:#999;font-size:%?34?%;line-height:%?100?%}.delmodel-card-btn .confirm[data-v-acf53e46]{color:#020202;font-size:%?34?%;line-height:%?100?%}",""])},"983b":function(e,t,a){"use strict";var i=a("288e");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var d=i(a("cebc")),s=i(a("795b")),n=i(a("6042")),o=a("2f62"),r=i(a("9f04")),c={data:function(){return{title:"收货地址",add:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/tianjiadizhi2x.png",edtAdd:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/bianjidizhi2x.png",delAdd:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/shanchudizhi2x.png",fastTap:!0,manage:"",del:"",del_index:-1,state_manage:"",access_id:"",address:"",circle_hui:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/xuanzehui2x.png",circle_hei:this.LaiKeTuiCommon.LKT_ROOT_VERSION_URL+"images/icon1/xuanzehei2x.png",order_id:"",re_img:"",addre_id:"",address_m:"管理",flag:!0,lkdelModel:!1,delobj:{},text:""}},beforeDestroy:function(){},onShow:function(){var e=this,t=new s.default(function(t,a){e.LaiKeTuiCommon.getLKTApiUrl().then(function(){t(1231)})});t.then(function(){e.$nextTick(function(){e.$refs.lktAuthorizeComp.handleAfterAuth(e,"../login/login?landing_code=1",function(){e._axios(),e.address_id=e.$store.state.address_id})})})},onLoad:function(e){this.order_id=this.$store.state.order_id,this.access_id=uni.getStorageSync("access_id")?uni.getStorageSync("access_id"):this.$store.state.access_id,this.state_manage=e.state_manage,this.addre_id=e.addre_id,uni.setStorageSync("canshu","false"),1==this.state_manage?(this.manage=!0,this.del=!1,this.re_img=!0):2==this.state_manage&&(this.manage=!1,this.del=!0,this.re_img=!1)},components:{Heads:n.default,lkdelModel:r.default},methods:(0,d.default)({changeLoginStatus:function(){var e=this;e.access_id=uni.getStorageSync("access_id"),e._axios()},_uni_navigateTo:function(e){uni.navigateTo({url:e})},_state_manage:function(e){this.addre_id=e.id;var t=this;t.$store.state.address_id=e.id,uni.setStorageSync("chooseAddress",e)},_manage:function(){this.del=!this.del,this.del?this.address_m="完成":this.address_m="管理"},delAddress:function(e,t){this.delobj={addr_id:e,index:t},1==this.address[t].is_default?this.text="确认删除默认地址吗?":this.text="",this.lkdelModel=!0},_delAddress:function(){var e=this.delobj,t=e.addr_id,a=e.index;if(this.fastTap){this.fastTap=!1;var i=this,d={module:"app",action:"address",app:"del_adds",access_id:this.access_id,addr_id:t};1==this.address.length?uni.request({data:d,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){i.fastTap=!0;var t=e.data.code;200==t?(i.$store.state.address_id_def="",uni.setStorageSync("lkt_address_id_def",""),uni.showToast({title:"删除成功",icon:"none",duration:1e3}),i._axios()):uni.showToast({title:e.data.message,duration:1500,icon:"none"})}}):1==this.address[a].is_default?uni.request({data:d,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){i.fastTap=!0,console.log(e);var t=e.data.code;200==t?(uni.showToast({title:"删除成功",icon:"none",duration:1e3}),i.$store.state.address_id_def="",console.log("设置lkt_address_id_def为空2"),uni.setStorageSync("lkt_address_id_def",""),i._axios()):(i.fastTap=!0,uni.showToast({title:e.data.message,duration:1500,icon:"none"}))}}):uni.request({data:d,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){i.fastTap=!0,console.log(e);var t=e.data.code;200==t?(uni.showToast({title:"删除成功",icon:"none",duration:1e3}),i._axios()):uni.showToast({title:e.data.message,duration:1500,icon:"none"})},error:function(e){i.fastTap=!0}}),this.lkdelModel=!1}},_addAddress:function(e){uni.navigateTo({url:"addAddress?state_addre=2&addr_id="+e})},_default:function(e,t){if(this.fastTap){this.fastTap=!1;var a=this,i={module:"app",action:"address",app:"set_default",access_id:this.access_id,addr_id:e};uni.request({data:i,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(e){a.fastTap=!0,console.log(e);var i=e.data,d=i.code;i.message;if(console.log(a.address[t].id),200==d){for(var s=0;s<a.address.length;s++)a.address[s].is_default=0;a.address[t].is_default=1,a.$store.state.address_id_def=a.address[t].id,console.log("1设置lkt_address_id_def为"+a.address[t].id)}else uni.showToast({title:e.data.message,duration:1500,icon:"none"})},error:function(e){a.fastTap=!0}})}},_axios:function(){var e=this,t={module:"app",action:"address",app:"index",access_id:this.access_id};uni.request({data:t,url:uni.getStorageSync("url"),header:{"content-type":"application/x-www-form-urlencoded"},method:"POST",success:function(t){var a=t.data.adds||[];if(console.log(a),200==t.data.code){if(e.address=a,uni.getStorageSync("address_default")){for(var i=0;i<a.length;i++)if(1==a[i].is_default){e.addre_id=a[i].id;break}uni.removeStorageSync("address_default")}}else e.address="",uni.showToast({title:t.data.message,duration:1500,icon:"none"});e.$store.state.address_id_def;if(a.length>0&&""==e.$store.state.address_id_def)if(""==e.$store.state.address_id_def)for(var d in a)1==a[d].is_default&&(e.$store.state.address_id_def=a[d].id,uni.setStorageSync("lkt_address_id_def",a[d].id),e.$store.state.address_id=a[d].id);else e.$store.state.address_id_def=e.$store.state.address_id_def,uni.setStorageSync("lkt_address_id_def",e.$store.state.address_id_def)}})}},(0,o.mapMutations)({address_id:"SET_ADDRESS_ID"}))};t.default=c},"9a85":function(e,t,a){"use strict";var i=a("3eed"),d=a.n(i);d.a},"9f04":function(e,t,a){"use strict";a.r(t);var i=a("3811"),d=a("e861");for(var s in d)"default"!==s&&function(e){a.d(t,e,function(){return d[e]})}(s);a("1d25");var n=a("2877"),o=Object(n["a"])(d["default"],i["a"],i["b"],!1,null,"acf53e46",null);t["default"]=o.exports},aa16:function(e,t,a){"use strict";function i(e,t){uni.setStorage({key:e,data:t,success:function(){console.log("setSuccess")}})}function d(e){var t;return uni.getStorage({key:e,success:function(e){t=e.data,console.log("getSuccess")}}),t}function s(e){uni.removeStorage({key:e,success:function(e){console.log("removeSuccess")}})}Object.defineProperty(t,"__esModule",{value:!0}),t.setStorage=i,t.getStorage=d,t.removeStorage=s},c118:function(e,t,a){t=e.exports=a("2350")(!1),t.push([e.i,".address_foot[data-v-5d50d1cc],.address_top[data-v-5d50d1cc],.address_xs[data-v-5d50d1cc],.head[data-v-5d50d1cc]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-flow:row;flex-flow:row;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.head[data-v-5d50d1cc]{padding:%?20?% %?30?%;font-size:%?40?%;border-bottom:1px solid #f6f6f6;height:%?88?%;position:fixed;top:0;left:0;width:100%;background-color:#fff;color:#020202}\r\n\t/* 加入 border: 20upx solid transparent;border-left: 0;background-clip: padding-box;解决返回箭头的点击区域太小问题*/.head img[data-v-5d50d1cc]{width:%?24?%;height:%?36?%;border:%?20?% solid transparent;border-left:0;background-clip:padding-box}.manage1[data-v-5d50d1cc]{width:%?120?%;height:%?70?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;font-size:%?30?%;color:#020202;margin-left:auto}\r\n\t/* .head p{text-align: center;width: 100%;position: absolute;left: 0;} */.head p[data-v-5d50d1cc]{text-align:center;position:absolute;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%)}.manage[data-v-5d50d1cc]{position:absolute;font-size:%?30?%;right:%?20?%;bottom:0;width:%?100?%;height:%?88?%;line-height:%?88?%;z-index:999999}.address_wu[data-v-5d50d1cc]{margin:%?60?% %?30?%;border:1px dashed #ddd;padding:%?34?% 0;text-align:center;font-size:%?30?%;color:#9d9d9d}.address_wu img[data-v-5d50d1cc]{width:%?62?%;height:%?62?%;margin-bottom:%?20?%}.address[data-v-5d50d1cc]{background-color:#f6f6f6;padding-bottom:%?100?%;position:relative}.address li[data-v-5d50d1cc]{background-color:#fff;padding:%?20?% %?30?% 0 %?30?%;margin-bottom:%?20?%}.address li[data-v-5d50d1cc]:last-child{margin-bottom:0}.address_top[data-v-5d50d1cc]{padding-bottom:%?30?%}.address_user span[data-v-5d50d1cc]{font-weight:700;font-size:%?30?%;color:#020202}.address_xs[data-v-5d50d1cc]{-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;margin-top:%?10?%}.address_xs p[data-v-5d50d1cc]{font-size:%?24?%;color:#9d9d9d;margin-right:%?40?%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;width:%?530?%}.address_ms[data-v-5d50d1cc]{width:%?52?%;text-align:center;color:#fff;background-color:#020202;font-size:%?20?%;margin-right:%?20?%;padding-top:%?2?%}.address_foot[data-v-5d50d1cc]{height:%?60?%;border-top:1px solid #f6f6f6;font-size:%?24?%;color:#020202}.quan_img[data-v-5d50d1cc]{width:%?30?%;height:%?30?%;margin-right:%?10?%;vertical-align:sub}.bottom[data-v-5d50d1cc]{height:%?98?%;width:100%;font-size:%?30?%;color:#fff;text-align:center;line-height:%?98?%;position:fixed;left:0;bottom:0;background-color:#020202}",""])},e861:function(e,t,a){"use strict";a.r(t);var i=a("87a1"),d=a.n(i);for(var s in i)"default"!==s&&function(e){a.d(t,e,function(){return i[e]})}(s);t["default"]=d.a}}]);