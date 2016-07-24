@include('admin/common/header')
<script type="text/javascript" src="{{URL::asset('/')}}script/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript">
	var pIndex = 1;
	var currentEntity = null;
	$(function(){
		$('tbody.mlist').sortable({handle: '.icon-move'});
		$('.smlist').sortable({handle: '.icon-move'});
		$('.mlist .hover').each(function(){
			$(this).data('do', $(this).attr('data-do'));
			$(this).data('url', $(this).attr('data-url'));
			$(this).data('forward', $(this).attr('data-forward'));
		});
		$('.mlist .hover .smlist div').each(function(){
			$(this).data('do', $(this).attr('data-do'));
			$(this).data('url', $(this).attr('data-url'));
			$(this).data('forward', $(this).attr('data-forward'));
		});
		$(':radio[name="ipt"]').click(function(){
			if(this.checked) {
				if($(this).val() == 'url') {
					$('#url-container').show();
					$('#forward-container').hide();
                    $('#forward-content').hide();
				} else {
					$('#url-container').hide();
					$('#forward-container').show();
                    $('#forward-content').hide();
				}
			}
		});
		$('#dialog').modal({keyboard: false, show: false});
		$('#dialog').on('hide', saveMenuAction);
	});
	function addMenu() {
		if($('.mlist .hover').length >= 3) {
			return;
		}
		var html = '<tr class="hover">'+
						'<td>'+
							'<div>'+
								'<input type="text" class="span4" value=""> &nbsp; &nbsp; '+
								'<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp; '+
								'<a href="javascript:;" onclick="setMenuAction($(this).parent().parent().parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp; '+
								'<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a> &nbsp; '+
								'<a href="javascript:;" onclick="addSubMenu($(this).parent().next());" title="添加子菜单" class="icon-plus-sign" title="添加菜单"></a> '+
							'</div>'+
							'<div class="smlist"></div>'+
						'</td>'+
					'</tr>';
		$('tbody.mlist').append(html);
	}
	function addSubMenu(o) {
		if(o.find('div').length >= 5) {
			return;
		}
		var html = '' +
				'<div style="margin-top:20px;padding-left:80px;background:url("{{URL::asset('/')}}}/image/bg_repno.gif") no-repeat -245px -545px;">'+
					'<input type="text" class="span3" value=""> &nbsp; &nbsp; '+
					'<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp; '+
					'<a href="javascript:;" onclick="setMenuAction($(this).parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp; '+
					'<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a> '+
				'</div>';
		o.append(html);
	}
	function deleteMenu(o) {
		if($(o).parent().parent().hasClass('smlist')) {
            var key=$(o).parent().data('forward');
			$(o).parent().remove();
		} else {
            key=$(o).parent().parent().parent().data('forward');
			$(o).parent().parent().parent().remove();
		}
        if(key!=''){
            var url='';
            $.post(url,{key:key},function(data){

            })
        }
	}
	function setMenuAction(o) {
		if(o == null) return;
		if(o.find('.smlist div').length > 0) {
			return;
		}
		currentEntity = o;
		$('#ipt-url').val($(o).data('url'));
		$('#ipt-forward').val($(o).data('forward'));
		if($(o).data('do') != 'forward') {
			$(':radio').eq(0).attr('checked', 'checked');
		} else {
			$(':radio').eq(1).attr('checked', 'checked');
		}
		$(':radio:checked').trigger('click');
		$('#dialog').modal('show');
	}
	function saveMenuAction(e) {
		var o = currentEntity;
		var t = $(':radio:checked').val();
		t = t == 'url' ? 'url' : 'forward';
		if(o == null) return;
		$(o).data('do', t);
		$(o).data('url', $('#ipt-url').val());
		$(o).data('forward', $('#ipt-forward').val());
            console.log($('input[type=file]'))
	}
	function saveMenu() {
		if($('.span4:text').length > 3) {
			message('不能输入超过 3 个主菜单才能保存.', '', 'error');
			return;
		}
		if($('.span4:text,.span3:text').filter(function(){ return $.trim($(this).val()) == '';}).length > 0) {
			message('存在未输入名称的菜单.', '', 'error');
			return;
		}
		if($('.span4:text').filter(function(){ return $.trim($(this).val()).length > 5;}).length > 0) {
			message('主菜单的名称长度不能超过5个字.', '', 'error');
			return;
		}
		if($('.span3:text').filter(function(){ return $.trim($(this).val()).length > 8;}).length > 0) {
			message('子菜单的名称长度不能超过8个字.', '', 'error');
			return;
		}
		var dat = '[';
		var error = false;
		$('.mlist .hover').each(function(){
			var name = $.trim($(this).find('.span4:text').val()).replace(/"/g, '\"');
			var type = $(this).data('do') != 'forward' ? 'view' : 'click';
			var url = $(this).data('url');
			if(!url) {
				url = '';
			}
			var forward = $.trim($(this).data('forward'));
			if(!forward) {
				forward = '';
			}
			dat += '{"name": "' + name + '"';
			if($(this).find('.smlist div').length > 0) {
				dat += ',"sub_button": [';
				$(this).find('.smlist div').each(function(){
					var sName = $.trim($(this).find('.span3:text').val()).replace(/"/g, '\"');
					var sType = $(this).data('do') != 'forward' ? 'view' : 'click';
					var sUrl = $(this).data('url');
					if(!sUrl) {
						sUrl = '';
					}
					var sForward = $.trim($(this).data('forward'));
					if(!sForward) {
						sForward = '';
					}
					dat += '{"name": "' + sName + '"';
					if((sType == 'click' && sForward == '') || (sType == 'view' && !sUrl)) {
						message('子菜单项 “' + sName + '”未设置对应规则.', '', 'error');
						error = true;
						return false;
					}
					if(sType == 'click') {
						dat += ',"type": "click","key": "' + encodeURIComponent(sForward) + '"';
					}
					if(sType == 'view') {
						dat += ',"type": "view","url": "' + sUrl + '"';
					}
					dat += '},';
				});
				if(error) {
					return false;
				}
				dat = dat.slice(0,-1);
				dat += ']';
			} else {
				if((type == 'click' && forward == '') || (type == 'view' && !url)) {
					message('菜单 “' + name + '”不存在子菜单项, 且未设置对应规则.', '', 'error');
					error = true;
					return false;
				}
				if(type == 'click') {
					dat += ',"type": "click","key": "' + encodeURIComponent(forward) + '"';
				}
				if(type == 'view') {
					dat += ',"type": "view","url": "' + url + '"';
				}
			}
			dat += '},';
		});
		if(error) {
			return;
		}
		dat = dat.slice(0,-1);
		dat += ']';
//		var aa = $('#do').val(dat);
        var dats=('{"button":'+dat+"}");
        $('#do').val(dats);
        $('#key').val(dat);
//		$('#form').submit();
        var id=$("#user").val();
        var _token=$("#_token").val();
        var data={'id':id,'_token':_token,'aa':dats};
        $("#di").val(dat);
        //$('#form')[0].submit();
        $.post("{{URL('token')}}",data,
                function(data){
                    console.log(data);
                    if(data.errcode=='0'){
                        alert("修改成功");
                    }else if(data=='40013'){
                        alert("您的Appid 或 Appsecret 错误");
                    }else{
                        alert("您的公众号API功能未授权");
                    }
                },'json');
	}
</script>
<style type="text/css">
	.table-striped td{padding-top: 10px;padding-bottom: 10px}
	a{font-size:14px;}
	a:hover, a:active{text-decoration:none; color:red;}
	.hover td{padding-left:10px;}
</style>
<div class="main" id="mai">
	<div class="form form-horizontal">
		<h4>菜单设计器 <small>编辑和设置微信公众号码, 必须是服务号才能编辑自定义菜单。</small></h4>
		<table class="tb table-striped">
			<tbody class="mlist">
            当前APP：
            <select id="user">
                <?php
                $p_id=Session::get('p_id');
                if($p_id){
                    //echo $p_id;
                    $row= DB::table('we_pub')->where('p_id',$p_id)->first();
                }else{

                }

                ?>

                @if($p_id)
                        <option value="<?php echo $row->p_id ?>">{{$row->p_name}}</option>
                @else
                    <span id="current-account">请切换公众号</span>
                @endif
            </select>

			<tr class="hover" data-do="" data-url="" data-forward="">
					<td>
						<div>
							<input type="text" class="span4" value=""> &nbsp; &nbsp;
							<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp;
							<a href="javascript:;" onclick="setMenuAction($(this).parent().parent().parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp;
							<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a> &nbsp;
							<a href="javascript:;" onclick="addSubMenu($(this).parent().next());" title="添加子菜单" class="icon-plus-sign" title="添加菜单"></a>
						</div>
						<div class="smlist">

							<div style="margin-top:20px;padding-left:80px;background:url('{{URL::asset('/')}}image/bg_repno.gif') no-repeat -245px -545px;" data-do="" data-url="" data-forward="">
								<input type="text" class="span3" value=""> &nbsp; &nbsp;
								<a href="javascript:;" class="icon-move" title="拖动调整此菜单位置"></a> &nbsp;
								<a href="javascript:;" onclick="setMenuAction($(this).parent());" class="icon-edit" title="设置此菜单动作"></a> &nbsp;
								<a href="javascript:;" onclick="deleteMenu(this)" class="icon-remove-sign" title="删除此菜单"></a>
							</div>

						</div>
					</td>
				</tr>

			</tbody>
		</table>
		<div class="well well-small" style="margin-top:20px;">
			<a href="javascript:;" onclick="addMenu();">添加菜单 <i class="icon-plus-sign" title="添加菜单"></i></a> &nbsp; &nbsp; &nbsp;  <span class="help-inline">可以使用 <i class="icon-move"></i> 进行拖动排序</span>
		</div>

		<h4>操作 <small>设计好菜单后再进行保存操作</small></h4>
		<table class="tb">
			<tbody>
				<tr>
					<td>
                        <input type="hidden" name="_token"    id="_token"     value="<?php echo csrf_token() ?>"/>
						<input type="button" value="保存菜单结构" class="btn btn-primary span3" onclick="saveMenu();"/>
						<span class="help-block">保存当前菜单结构至公众平台, 由于缓存可能需要在24小时内生效</span>
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" value="删除" class="btn btn-primary span3" onclick="$('#do').val('remove');$('#form')[0].submit();" />
						<div class="help-block">清除自定义菜单</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<form action="{{URL('token')}}" method="post" id="form">
    <input type="hidden" name="_token"    id="_token"     value="<?php echo csrf_token() ?>"/>
    <input id="do" name="do" type="hidden" />
    <input id="key" name="key" type="hidden"/>
</form>
<div id="dialog" class="modal hide" style="position: absolute">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>选择要执行的操作</h3>
	</div>
	<div class="tab-pane{$current['url']}" id="url">
		<div class="well">
			<label class="radio inline">
				<input type="radio" name="ipt" value="url" checked="checked"> 链接
			</label>
			<label class="radio inline">
				<input type="radio" name="ipt" value="forward"> 模拟关键字
			</label>
            <hr/>
			<div id="url-container">
				<input class="span6" id="ipt-url" type="text" value="" />
				<span class="help-block">指定点击此菜单时要跳转的链接（注：链接需加http://）</span>
				<span class="help-block"><strong>注意: 由于接口限制. 如果你没有网页oAuth接口权限, 这里输入链接直接进入微站个人中心时将会有缺陷(有可能获得不到当前访问用户的身份信息. 如果没有oAuth接口权限, 建议你使用图文回复的形式来访问个人中心)</strong></span>
			</div>
            <form action="{{URL('token')}}" method="post" id="form1" enctype="multipart/form-data" target="">
                <input type="hidden" name="_token"    id="_token"     value="<?php echo csrf_token() ?>"/>
                <div id="forward-container" class="hide">
                    <input class="span6" id="ipt-forward" name="ipt-forward" type="text" />
                    <span class="help-block">指定点击此菜单时要执行的操作, 你可以在这里输入关键字, 那么点击这个菜单时就就相当于发送这个内容至微E系统</span>
                    <span class="help-block"><strong>这个过程是程序模拟的, 比如这里添加关键字: 优惠券, 那么点击这个菜单是, 微E系统相当于接受了粉丝用户的消息, 内容为"优惠券"</strong></span>
                    <span class="help-block" style="display: inline-block;"><strong>点击下一步进行关键字回复设置：</strong></span>
                    <p style="margin-top: 10px;text-align: center;"><input type="button" class="btn btn-primary span2" id="btn" value="下一步"/></p>
                </div>
                <div id="forward-content" class="hide">
                   <table class="tb" id="tb">
                        <tr>
                            <th width="100"><label for="">回复类型</label></th>
                            <td>
                                <select name="module" id="module" class="span5">
                                    @foreach($arr as $val)
                                        <option value="{{$val->t_id}}">{{$val->t_name}}</option>
                                      @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr id="huifu">
                            <th width="100"><label for="">回复</label></th>
                            <td>
                                <input type="text" class="span5" placeholder="" name="content" value="" /> &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <input type="button" class="btn btn-primary span2" id="btna" value="确定"/>
                            </td>
                        </tr>
                    </table>
                  </div>
            </form>
		</div>
	</div>
	<div class="tab-pane{$current['rule']}" id="rules"></div>
</div>
<script type="text/javascript">
    $(function(){
        $('#btn').click(function(){
            $('#url-container').hide();
            $('#forward-container').hide();
            $('#forward-content').show();
            $('.tu').remove();
            $('#huifu').show();
            $('#module').val(1);
        });
        $('#module').change(function(){
            module=$(this).val();
            if($(this).val()==2){
                $('.tu').remove();
                $('#huifu').hide();
                var biao='<tr class="tu"><th width="100"><label for="">图文标题</label></th><td><input type="text" class="span5" placeholder="" name="tit[]" value="" /> &nbsp;</td></tr>';
                var tu='<tr class="tu"><th width="100"><label for="">选择图片</label></th><td><input type="file" class="span5" placeholder="" name="pic[]" value="" /> &nbsp;</td></tr>';
                var nei='<tr class="tu"><th width="100"><label for="">图文内容</label></th><td><input type="text" class="span5" placeholder="" name="nei[]" value="" /> &nbsp;</td></tr>';
                var ur='<tr class="tu"><th width="100"><label for="">图文连接</label></th><td><input type="text" class="span5" placeholder="" name="lian[]" value="" /> &nbsp; <a href="javascript:;" title="添加子菜单" class="icon-plus-sign" name="icon" title="添加菜单"></a></td></tr>';
                $('#huifu').after(biao+tu+nei+ur);
            }
            if($(this).val()==1){
                $('.tu').remove();
                $('#huifu').show();
            }
            if($(this).val()==3){
                $('.tu').remove();
                $('#huifu').hide();
                var biao='<tr class="tu"><th width="100"><label for="">音乐标题</label></th><td><input type="text" class="span5" placeholder="" name="tit[]" value="" /> &nbsp;</td></tr>';
                var nei='<tr class="tu"><th width="100"><label for="">音乐名称</label></th><td><input type="text" class="span5" placeholder="" name="nei[]" value="" /> &nbsp;</td></tr>';
                var tu='<tr class="tu"><th width="100"><label for="">选择音乐</label></th><td><input type="file" class="span5" placeholder="" name="pic[]" value="" /> &nbsp;</td></tr>';
                $('#huifu').after(biao+nei+tu);
            }
        });
        $('#tb').on('click','a[name=icon]',function(){
            if($('a[name=icon]').length<3){
                var biao='<tr class="tu"><th width="100"><label for="">图文标题</label></th><td><input type="text" class="span5" placeholder="" name="tit[]" value="" /> &nbsp;</td></tr>';
                var tu='<tr class="tu"><th width="100"><label for="">选择图片</label></th><td><input type="file" class="span5" placeholder="" name="pic[]" value="" /> &nbsp;</td></tr>';
                var nei='<tr class="tu"><th width="100"><label for="">图文内容</label></th><td><input type="text" class="span5" placeholder="" name="nei[]" value="" /> &nbsp;</td></tr>';
                var ur='<tr class="tu"><th width="100"><label for="">图文连接</label></th><td><input type="text" class="span5" placeholder="" name="lian[]" value="" /> &nbsp; <a href="javascript:;" title="添加子菜单" class="icon-plus-sign" name="icon" title="添加菜单"></a></td></tr>';
                $(this).parent().parent().after(biao+tu+nei+ur);
            }
            var dialog=parseInt($('#dialog').css('height'))+200;
            var mai=parseInt($('#mai').css('height'));
            if(dialog>mai){
                $('#mai').css('height',dialog)
            }
        });
        $('#btna').click(function(){

            if($(':file')[0]!=undefined){
                var num=parseInt($(':file')[0].files[0].size);
                var max=parseInt(6291456);
                if(num>max){
                    alert('您选择的文件不能超过6M');
                    return false;
                }
            }
            var ifmname = 'ifm' + Math.random();
            var ifm = $('<iframe width="0" height="0" frameborder="0" name="'+ ifmname +'">');
            ifm.appendTo($('#mai'));

            $('#form1').attr('target',ifmname);
            $('#form1').submit();

            //$('#progress').html('<img src="http://linux.zixue.it/images/loading.gif" border="0">');
            ifm.load(function(){
                this.remove();
            })
        });
    })
</script>
@include('admin/common/footer')
