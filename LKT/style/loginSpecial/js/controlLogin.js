// \lkj20180323
var canGetCookie = 1;//是否支持存储Cookie 0 不支持 1 支持
var ajaxmockjax = 1;//是否启用虚拟Ajax的请求响 0 不启用  1 启用
//默认账号密码
// var web_name = window.location.origin + '/test/';
var web_name = window.location.origin+'/';
var url = "index.php?module=Login";
var authorization_code = '';
var laike_num = false;
var CodeVal = 0;

function showCheck(a) {
    CodeVal = a;
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.clearRect(0, 0, 1000, 1000);
    ctx.font = "80px 'Hiragino Sans GB'";
    ctx.fillStyle = "#E8DFE8";
    ctx.fillText(a, 0, 100);
}

$(document).keypress(function (e) {
    // 回车键事件
    if (e.which == 13) {
        $('input[type="button"]').click();
    }
});


function jqtoast(text) {
    var errText = $(".errText");
    errText.show();
    $(".errText_box").text(text);
    setTimeout(function () {
        $('.errText').fadeOut(function () {
            errText.hide();
        });
        _this = '';
    }, 5000);
}

$('input[name="pwd"]').focus(function () {
    $(this).attr('type', 'password');
});
$('input[type="text"]').focus(function () {
    $(this).prev().animate({'opacity': '1'}, 200);
});
$('input[type="text"],input[type="password"]').blur(function () {
    $(this).prev().animate({'opacity': '.5'}, 200);
});
$('input[name="login"],input[name="pwd"]').keyup(function () {
    var Len = $(this).val().length;
    if (!$(this).val() == '' && Len >= 5) {
        $(this).next().animate({
            'opacity': '1',
            'right': '30'
        }, 200);
    } else {
        $(this).next().animate({
            'opacity': '0',
            'right': '20'
        }, 200);
    }
});

var open = 0;
layui.use('layer', function () {
    //非空验证
    $('.login_fields__submit').click(function () {
        var customer_number = $('.num').val();
        var login = $('.username').val();
        var pwd = $('.passwordNumder').val();
        
        var telltype = $('#telltype').val();
        if(telltype == 1){                          //有系统维护的通知
            var startdate1 = $('#startdate').val();
            var enddate1 = $('#enddate').val();
            var startdate = new Date(startdate1).getTime();
            var enddate = new Date(enddate1).getTime();
            var now = new Date().getTime();
            
            if(now > startdate && now < enddate){
               $('#showattr').removeClass('modalshow');
               jqtoast('系统维护期间从' + startdate1 + '至' + enddate1 + ',不能登录!');
               return false;
            }
        }
        
        if (login == '') {
            jqtoast('请输入用户名!');
            return false;
        } else if (pwd == '') {
            jqtoast('请输入密码!');
            return false;
        } else {
            //认证中..
            $('.login').addClass('test'); //倾斜特效
            setTimeout(function () {
                $('.login').addClass('testtwo'); //平移特效
            }, 300);
            setTimeout(function () {
                $('.authent').show().animate({right: -320}, {
                    easing: 'easeOutQuint',
                    duration: 600,
                    queue: false
                });
                $('.authent').animate({opacity: 1}, {
                    duration: 200,
                    queue: false
                }).addClass('visible');
            }, 500);

            //登陆
            var JsonData = {customer_number:customer_number,login: login, pwd: pwd};
            //此处做为ajax内部判断

            setTimeout(function () {
                $('.authent').show().animate({right: 90}, {
                    easing: 'easeOutQuint',
                    duration: 600,
                    queue: false
                });
                $('.authent').animate({opacity: 0}, {
                    duration: 200,
                    queue: false
                }).addClass('visible');
                $('.login').removeClass('testtwo'); //平移特效
            }, 2000);
            $.ajax({
                type: "POST",
                url: web_name + url,
                data: JsonData,
                dataType: "json",
                success: function (msg) {
                    setTimeout(function () {
                        $('.authent').hide();
                        $('.login').removeClass('test');
                        if(msg.status == 1){
                            layer.msg(msg.info);
                            // 登录成功
                            $('.login div').fadeOut(100);
                            $('.success').fadeIn(1000);
                            setTimeout(function () {
                                location.href = web_name + "index.php?module=AdminLogin";
                            },1000)
                        }else{
                            jqtoast(msg.info);
                        }
                    }, 2400);
                }
            });
        }
        return false;
    })
})
