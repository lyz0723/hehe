$(function(){
	
	//点击切换常用语列表
	$("#chat-btnhide").click(function(){
    $("#chat-often").toggle();
	});
	//点击切换常用表情显示隐藏
	$("#chat-lookBtntoggle").click(function(){
    $("#chat-lookbox").toggle();
	});
	//点击左右切换表情列表
	var aI=$('#chat-lookbox div i');
	var aUl=$('#chat-lookbox ul');

	aI.click(function(){
		aI.removeClass('chat-lookBtn');
		aUl.removeClass('chat-lookShowbox');

		$(this).addClass('chat-lookBtn');
		// alert($(this).index());
		aUl.eq($(this).index()).addClass('chat-lookShowbox');
	});
	//点击切换侧边栏聊天窗口
	var aDiv=$('#chat-contentbox .chat-content');
	var aBtn=$('.chat-sidebar a');

	aBtn.click(function(){
		aBtn.removeClass('chat-sidebarBtn');
		aDiv.removeClass('chat-content-showbox');

		$(this).addClass('chat-sidebarBtn');
		
		aDiv.eq($(this).index()).addClass('chat-content-showbox');
	});
	//点击关闭当前页面
	$(".chat-box-close").click(function(){
    $(".chat-box").hide();
	});
	
	
})