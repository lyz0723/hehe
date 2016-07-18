$(function(){
	//点击窗口隐藏
	$('#live-host-hide').click(function(){   
        if ($('#live-Host').css('display') == 'none') {
            $('#live-Host').show();
            $(this).find('img').attr('src', 'images/hide.png');
        } else {
            $('#live-Host').hide();
            $(this).find('img').attr('src', 'images/place.png');
        }
  	});
	//点击窗口关闭
	$("#live-host-close").click(function(){
        $("#live-Host").hide();
        $('#live-host-hide').hide();
        $('#live-host-living').show();
	});

    $('#live-host-bottom-box-switch').click(function(){

    });

    // 开始直播以后
    $('#live-host-switch-button').click(function(){
        $(this).attr('src', 'images/playbtn2.png');
        $('#live-host-video-button').attr('src', 'images/viedeo.png');
        $('#live-host-suspended-button').attr('src', 'images/playbtn3.png');
    });

    // 开启摄像头以后
    $('#live-host-video-button').click(function(){
        $(this).attr('src', 'images/viedeo-2.png');
    });
	
})