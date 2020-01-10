var template_id = '';//模板id
var trade_no = '';
// var status = $("#status").attr('value');//审核状态
var status = $("input[name='status']").val();

window.onload = function() {
	var myTab = document.getElementById("tab"); //整个div
	var myUl = myTab.getElementsByTagName("ul")[0]; //一个节点
	var myLi = myUl.getElementsByTagName("li"); //数组
	var myDiv = myTab.getElementsByTagName("div"); //数组

	$(".kid").css('display','none');

	console.log('status',status)

	first_no =  $(".pid:eq(0)").attr('trade_code');
	console.log('123');
	$('.kid'+first_no).css('display','block');
	$('.pid'+first_no).addClass('on');


	$(".pid").click(function(){
		trade_no = $(this).attr('trade_code');
		$('.pid').removeClass('on');
		$(this).addClass('on');

		console.log(trade_no);
		$(".kid").css('display','none');
        $(".kid"+trade_no).css('display','block');


	});

	$('.img').each(function() {
		$(this).mouseover(function() {
			$(this).children('.cover-div').show();
		})
		$(this).mouseout(function() {
			$(this).children('.cover-div').hide();
		})
	})

	$('.nowUse').each(function() {
		$(this).click(function() {
		
			if(status === '0'){//审核通过状态下，不可选择模板
				layer.msg('审核已通过，不可选择模板',{time:4000});
				return false;
		    }	
						
			$('.select-div').hide();
			$(this).parent('.cover-div').parent('.img').children('.select-div').show();
			var src = $(this).parent('.cover-div').parent('.img').children('img').attr("src");
			template_id = $(this).parent('.cover-div').parent('.img').children('input').val();
			console.log(template_id);
			$('#preSrc').attr('src', src);
		})
	})
	

}

function check_template(){
     
	$.ajax({

		cache:true,
		type:"POST",
		dataType:"json",
		url:'index.php?module=third&action=CheckTemplate',
		data:{template_id:template_id},
		async:true,
		success:function(data){
			console.log(data)
			if(data.suc == 1){

				layer.msg(data.info,{time:2000});
				location.href='index.php?module=third&action=Index';
			}else{
				console.log(location.href);
				layer.msg(data.info,{time:2000});
				window.location.href ='index.php?module=third&action=CheckTemplate';
			}
		}


	});

	
  }

  function fabu(auditid){
	
	 $.ajax({

	 	cache:true,
	 	type:"POST",
	 	dataType:"json",
	 	url:'index.php?module=third&action=Review',
	 	data:{auditid:auditid},
	 	success:function(data){

				if(data.suc == 1){

					 layer.msg(data.msg,{time:2000});
					 window.location.href="index.php?module=third&action=Index";
				}else{

					layer.msg(data.msg,{time:2000});
					
				}
			}
	 });	
  }

function del(obj, id, url, content) {
	console.log('4534153')
	$('.maskNew').addClass('blockView');
	$('.maskNewContent').addClass('blockView');
	// confirm('确定要发布？', id, url, content);

}

function my_cansel(){
	$('.maskNew').removeClass('blockView');
	$('.maskNewContent').removeClass('blockView');

}
//取消选择模板
function calChoose() {
	var list = document.getElementsByClassName('img')[0];
	var lists = document.getElementsByClassName('img');
	
	$(lists).children('.cover-div').hide();
	$(lists).children('.select-div').hide();
	$(list).children('.select-div').show();
	
	var src = $(list).children('img').attr("src");
	$('#preSrc').attr('src', src)
}
