$(function(){
	
	$('#switch_qlogin').click(function(){
		$('#switch_login').removeClass("switch_btn_focus").addClass('switch_btn');
		$('#switch_qlogin').removeClass("switch_btn").addClass('switch_btn_focus');
		$('#switch_bottom').animate({left:'0px',width:'70px'});
		$('#qlogin').css('display','none');
		$('#web_qr_login').css('display','block');
		
		});
	$('#switch_login').click(function(){
		
		$('#switch_login').removeClass("switch_btn").addClass('switch_btn_focus');
		$('#switch_qlogin').removeClass("switch_btn_focus").addClass('switch_btn');
		$('#switch_bottom').animate({left:'154px',width:'70px'});
		
		$('#qlogin').css('display','block');
		$('#web_qr_login').css('display','none');
		});
if(getParam("a")=='0')
{
	$('#switch_login').trigger('click');
}

	});
	
function logintab(){
	scrollTo(0);
	$('#switch_qlogin').removeClass("switch_btn_focus").addClass('switch_btn');
	$('#switch_login').removeClass("switch_btn").addClass('switch_btn_focus');
	$('#switch_bottom').animate({left:'154px',width:'96px'});
	$('#qlogin').css('display','none');
	$('#web_qr_login').css('display','block');
	
}


//根据参数名获得该参数 pname等于想要的参数名 
function getParam(pname) { 
    var params = location.search.substr(1); // 获取参数 平且去掉？
    var ArrParam = params.split('&'); 
    if (ArrParam.length == 1) { 
        //只有一个参数的情况 
        return params.split('=')[1]; 
    } 
    else { 
         //多个参数参数的情况 
        for (var i = 0; i < ArrParam.length; i++) { 
            if (ArrParam[i].split('=')[0] == pname) { 
                return ArrParam[i].split('=')[1]; 
            } 
        } 
    } 
}  


var reMethod = "GET",
	pwdmin = 6;

$(document).ready(function() {


	$('#reg').click(function() {

		if ($('#user').val() == "") {
			$('#user').focus().css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×用户名不能为空</b></font>");
			return false;
		}



		if ($('#user').val().length < 4 || $('#user').val().length > 16) {

			$('#user').focus().css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×用户名位4-16字符</b></font>");
			return false;

		}
		$.ajax({
			type: reMethod,
			url: "/member/ajaxyz.php",
			data: "uid=" + $("#user").val() + '&temp=' + new Date(),
			dataType: 'html',
			success: function(result) {

				if (result.length > 2) {
					$('#user').focus().css({
						border: "1px solid red",
						boxShadow: "0 0 2px red"
					});$("#userCue").html(result);
					return false;
				} else {
					$('#user').css({
						border: "1px solid #D7D7D7",
						boxShadow: "none"
					});
				}

			}
		});


		if ($('#passwd').val().length < pwdmin) {
			$('#passwd').focus();
			$('#userCue').html("<font color='red'><b>×密码不能小于" + pwdmin + "位</b></font>");
			return false;
		}
		if ($('#passwd2').val() != $('#passwd').val()) {
			$('#passwd2').focus();
			$('#userCue').html("<font color='red'><b>×两次密码不一致！</b></font>");
			return false;
		}

		var sqq = /^[1-9]{1}[0-9]{4,9}$/;
		if (!sqq.test($('#qq').val()) || $('#qq').val().length < 5 || $('#qq').val().length > 12) {
			$('#qq').focus().css({
				border: "1px solid red",
				boxShadow: "0 0 2px red"
			});
			$('#userCue').html("<font color='red'><b>×QQ号码格式不正确</b></font>");return false;
		} else {
			$('#qq').css({
				border: "1px solid #D7D7D7",
				boxShadow: "none"
			});
			
		}

		$('#regUser').submit();
	});
    $('#btn').click(function() {
        var name=$('#u').val();
        var pwd=$('#p').val();
        var code=$('#code').val();
        if(name==''){
            $('#userGue').html('请输入用户名').css('color','red').show(1).delay(3000).hide(1);
            $('#u').css('border-color','red');
            return false;
        }
        if(pwd==''){
            $('#userGue').html('请输入密码').css('color','red').show(1).delay(3000).hide(1);
            $('#p').css('border-color','red');
            return false;
        }
        if(code=='' && ad_error!=0){
            $('#userGue').html('请输入验证码').css('color','red').show(1).delay(3000).hide(1);
            $('#code').css('border-color','red');
            return false;
        }
        var arr={name:name,pwd:pwd,code:code};
        $.post(add,arr,function(data){
            var n=3;
            if(data=='c'){
                window.location.href=ad_index;
            }else if(data=='a'){
                $('#userGue').html('您输入的验证码错误').css('color','red').show(1).delay(3000).hide(1);
            }else if(data=='b'){
                $('#userGue').html('您的账号已被锁定，请明日再来').css('color','red').show(1).delay(3000).hide(1);
            }else if(data=='d'){
                $('#userGue').html('用户名不存在').css('color','red').show(1).delay(3000).hide(1);
            }else{
                $('#cod').css('display','block');
                $('#web_qr_login').css('overflow','visible');
                data=parseInt(data);
                if(data==3){
                    $('#userGue').html('您的账号已被锁定，请明日再来').css('color','red').show(1).delay(3000).hide(1);
                }else{
                    $('#userGue').html('用户名或密码错误，今日还可以输入'+(n-data)+'次').css('color','red').show(1).delay(3000).hide(1);
                }
            }
        });
        $('#gb_version').attr('src',ad_code+'?id='+Math.random())
    });
    $('.inputstyle').blur(function(){
        $(this).css('border-color','#D7D7D7')
    });
    $('.inputstyle').focus(function(){
        $(this).css('border-color','#198BD4')
    });
    if(ad_error!=0){
        $('#web_qr_login').css('overflow','visible');
    }
});