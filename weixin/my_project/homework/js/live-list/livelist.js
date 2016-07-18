
$(function(){
	//点击切换观战内容
	var aBtn=$('#livelist-toggle h3 span');
	var aShow=$('#livelist-toggle .livelist-mainbox');

	aBtn.click(function(){
		aBtn.removeClass('livelist-active');
		aShow.removeClass('livelist-show');

		$(this).addClass('livelist-active');
		// alert($(this).index());
		aShow.eq($(this).index()).addClass('livelist-show');
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	})