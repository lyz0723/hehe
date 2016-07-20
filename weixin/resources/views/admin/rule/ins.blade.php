@include('admin/common/header')
<ul class="nav nav-tabs">
	<li><a href="">管理规则</a></li>
	<!--{if $rid}<li class="active"><a href="{php echo create_url('rule/post', array('id' => $rid))}"><i class="icon-edit"></i> 编辑规则</a></li>{/if}-->
	<li class="active"><a href=""><i class="icon-plus"></i> 添加规则</a></li>
</ul>
<div class="main">
	<form class="form-horizontal form" action="{{URL('add_text')}}" method="post" enctype="multipart/form-data">
		<h4>添加规则 <small>删除，修改规则、关键字以及回复后，请提交规则以保存操作。</small></h4>
		<table class="tb" id="tb">
			<tr>
				<th><label for="">规则名称</label></th>
				<td>
					<input type="text" id="rule-name" class="span6" placeholder="" name="name" value="" /> &nbsp;
                    <!--<label for="adv-setting" class="checkbox inline">
						<input type="checkbox" id="adv-setting" hideclass="adv-setting"{if $rule['rule']['displayorder'] > 0} checked='true'{/if}> 高级设置
					</label>-->
					<span class="help-block">您可以给这条规则起一个名字, 方便下次修改和查看.<!--<a class="iconEmotion" href="javascript:;" inputid="rule-name"><i class="icon-github-alt"></i> 表情</a>--></span>
				</td>
			</tr>
			<!--<tr class="hide adv-setting">
				<th><label for="">状态</label></th>
				<td>
					<label for="status_1" class="radio inline"><input type="radio" name="status" id="status_1" value="1" {if $rule['rule']['status'] == 1 || empty($rule['rule']['status'])} checked="checked"{/if} /> 启用</label>
					<label for="status_0" class="radio inline"><input type="radio" name="status" id="status_0" value="0" {if !empty($rule) && $rule['rule']['status'] == 0} checked="checked"{/if} /> 禁用</label>
					<span class="help-block"></span>
				</td>
			</tr>
			<tr class="hide adv-setting">
				<th><label for="">是否置顶</label></th>
				<td>
					<label for="radio_1" class="radio inline"><input type="radio" name="istop" id="radio_1" onclick="$('#displayorder').hide();" value="1" {if !empty($rule['rule']['displayorder']) && $rule['rule']['displayorder'] == 255} checked="checked"{/if} /> 置顶</label>
					<label for="radio_0" class="radio inline"><input type="radio" name="istop" id="radio_0" onclick="$('#displayorder').show();$('#rule-displayorder').val(0)" value="0" {if $rule['rule']['displayorder'] < 255} checked="checked"{/if} /> 普通</label>
					<span class="help-block">“置顶”时无论在什么情况下均能触发且使终保持最优先级，<span style="color:red">置顶设置过多，会影响系统效率，建议不要超过100个</span>；否则参考设置的“优先级”值</span>
				</td>
			</tr>
			<tr id="displayorder" class="hide adv-setting" {if !empty($rule['rule']['displayorder']) && $rule['rule']['displayorder'] == 255} style="display:none;"{/if}>
				<th><label for="">优先级</label></th>
				<td>
					<input type="text" id="rule-displayorder" class="span2" placeholder="" name="displayorder" value="{$rule['rule']['displayorder']}">
					<span class="help-block">规则优先级，越大则越靠前，最大不得超过254</span>
				</td>
			</tr>-->
			<tr>
				<th><label for="">回复类型</label></th>
				<td>
					<select name="module" id="module" class="span6">
                        @foreach($arr as $val)
                            <option value="{{$val->t_id}}">{{$val->t_name}}</option>
                        @endforeach
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="">触发关键字</label></th>
				<td>
					<input type="text" class="span6" placeholder="" name="keywords" value="" /> &nbsp;
					<span class="help-block">当用户的对话内容符合以上的关键字定义时，会触发这个回复定义。多个关键字请使用逗号隔开。</span>
				</td>
			</tr>
			<tr id="huifu">
				<th><label for="">回复</label></th>
				<td>
                    <input type="text" class="span6" placeholder="" name="content" value="" /> &nbsp;
				</td>
			</tr>
			<tr>
                <input type="hidden" name="_token"         value="<?php echo csrf_token() ?>"/>
				<th></th>
				<td>
					<button type="submit" class="btn btn-primary span3" name="submit" value="提交">提交</button>
				</td>
			</tr>
		</table>
	</form>
</div>

<script>
    $("#module").change(function(){
            var r_type=$(this).val();
            if(r_type=='2'){
                $("#huifu").hide();
                var biao='<tr class="tu"><th><label for="">图文标题</label></th><td><input type="text" class="span6" placeholder="" name="tit[]" value="" /> &nbsp;</td></tr>';
                var tu='<tr class="tu"><th><label for="">选择图片</label></th><td><input type="file" class="span6" placeholder="" name="pic[]" value="" /> &nbsp;</td></tr>';
                var nei='<tr class="tu"><th><label for="">图文内容</label></th><td><input type="text" class="span6" placeholder="" name="nei[]" value="" /> &nbsp;</td></tr>';
                var ur='<tr class="tu"><th><label for="">图文连接</label></th><td><input type="text" class="span6" placeholder="" name="lian[]" value="" /> &nbsp; <a href="javascript:;" title="添加子菜单" class="icon-plus-sign" title="添加菜单"></a></td></tr>';
                $('#huifu').after(biao+tu+nei+ur);
            }
        if(r_type=='1'){
            $('.tu').remove();
            $('#huifu').show();
        }
        if(r_type=='3'){
            $('.tu').remove();
            $('#huifu').hide();
            var biao='<tr class="tu"><th><label for="">音乐标题</label></th><td><input type="text" class="span6" placeholder="" name="tit[]" value="" /> &nbsp;</td></tr>';
            var nei='<tr class="tu"><th><label for="">音乐名称</label></th><td><input type="text" class="span6" placeholder="" name="nei[]" value="" /> &nbsp;</td></tr>';
            var tu='<tr class="tu"><th><label for="">选择音乐</label></th><td><input type="file" class="span6" placeholder="" name="pic[]" value="" /> &nbsp;</td></tr>';
            $('#huifu').after(biao+nei+tu);
        }
        
    });

</script>


@include('admin/common/footer')
