$(function(){
	//点击切换常用语
	$('#live-audience-oftenBtn').click(function(){   
  	$('#live-audience-showList').toggle();
  	});

	//点击窗口隐藏
	$("#live-audience-hideBtn").click(function(){
        if ($('#live-Audience').css('display') == 'none') {
            $('#live-Audience').show();
            $(this).find('img').attr('src', 'images/hide.png');
        } else {
            $('#live-Audience').hide();
            $(this).find('img').attr('src', 'images/place.png');
        }
	});

	$("#live-audience-exitBtn").click(function(){
        $("#live-audience-allexit").hide();
        $("#live-audience-hideBtn").hide();
	});


});



(function ($){

    // 弹幕内容样式库
    var options = {
        color : ['red', 'black', 'blue', '#333', '#dfdfdf', '#s3s3s3'], // 文字颜色
        position : [0, 1, 2], // 弹幕位置 “0”为滚动 “1” 为顶部 “2”为底部
        size : [0, 1], // “0”为小字 ”1”为大字
        danmuBox : '',
        danmuButton : '',
        danmuInput : ''
    }

    // 随机获取一个属性值
    var getRandomOptions = function(key) {
        var val = options[key], len, index;
        len = val.length - 1;
        index = Math.floor(Math.random()*len);

        return val[index];
    }

    // 拼接弹幕内容
    var getDanmuText = function(text) {
        var color = getRandomOptions('color');
        var size = getRandomOptions('size');
        var position = getRandomOptions('position');
        var time = $('#' + options.danmuBox).data("nowtime")+5;
        var textObj = '{ "text":"'+text+'","color":"'+color+'","size":"'+size+'","position":"'+position+'","time":'+time+'}';

        return eval('(' + textObj + ')');
    }

    // 输入弹幕
    var inputDanmuText = function() {
        var val = $.trim( $('#' + options.danmuInput).val() );
        if (val == '') {
            return false;
        }
        var textObj = getDanmuText(val);

        $('#' + options.danmuBox).danmu("add_danmu", textObj);
        $('#' + options.danmuInput).val('');
    }

    // 开启/关闭弹幕
    var switchDanmu = function() {
        var object = $('#' + options.switchButton);
        if (object.attr('is_open') == '1') {
            $('#' + options.danmuBox).danmu('danmu_stop');
            object.attr('is_open', '0');
            $('#' + options.danmuButton).off('click');
        } else {
            $('#' + options.danmuBox).danmu('danmu_start');
            object.attr('is_open', '1');
            $('#' + options.danmuButton).on('click', inputDanmuText);
        }
    }

    // 初始化
    var init = function(parames) {
        options = $.extend(options, parames);
        // 为弹幕区域绑定弹幕插件
        $('#' + options.danmuBox).danmu({
            width : 735,
            height : 272,
            zindex : -1
        });

        // 为发送弹幕按钮绑定click事件
        $('#' + options.danmuButton).on('click', inputDanmuText);

        // 开启/关闭弹幕
        $('#' + options.switchButton).on('click', switchDanmu);

    }

    init({
        danmuBox : 'live-audience-flowWord-box',
        danmuButton : 'live-audience-send',
        danmuInput : 'live-audience-input',
        switchButton : 'live-audience-flowWordBtn'
    });

})(jQuery);






// 弹幕
// var a_danmu={ "text":"2333333" , "color":"green" ,"size":"1","position":"0","time":60};

// $('#live-audience-flowWord-box').danmu({
//     width : 735,
//     height : 309,
//     zindex : 100,
//     danmuss : { 1:[ { "text":"sa'd'h'f'ka'sh'f" , "color":"red" ,"size":"0","position":"0"}, 
// { "text":"233333" , "color":"red" ,"size":"0","position":"2"} ],
//  3:[ { "text":"poi" , "color":"red" ,"size":"0","position":"1"}, 
// { "text":"2333" , "color":"red" ,"size":"0","position":"0"} ],
//  50:[ { "text":"XXX真好" , "color":"red" ,"size":"0","position":"2"}, ] }
// });

// $('#live-audience-flowWord-box').danmu('danmu_start');

 
	
