@include('admin/common/header')
	<ul class="nav nav-tabs">
		<!--{if $id}
		<li class="active"><a href="{php echo create_url('account/post', array('id' => $id))}"><i class="icon-edit"></i> 编辑公众号</a></li>
		<li><a href="{php echo create_url('account/payment', array('id' => $id))}"><i class="icon-money"></i> 编辑支付选项</a></li>
		{else}-->
		<li class="active"><a href=""><i class="icon-plus"></i> 添加公众号</a></li>
		<li><a href="{{URL('display')}}">管理公众号</a></li>
	</ul>
	<div class="main">
	<div class="stat">
		<div class="stat-div">
			<form action="{{URL('add')}}" method="post" class="form-horizontal tab-content" enctype="multipart/form-data">
			<div id="accont-common" class="tab-pane fade active in">
				<div class="sub-item">
					<h4 class="sub-title">普通模式</h4>
				</div>
				<div class="sub-item" id="table-list">
					<div class="sub-content">
						<table class="tb">
							<tr>
								<th><label for="">公众号名称</label></th>
								<td>
									<input type="text" name="name" class="span6" value="" autocomplete="off">
									<!--label for="adv-setting" class="checkbox inline">
										<input type="checkbox" id="adv-setting" hideclass="adv-setting"{if $wechat['key'] && $wechat['secret']} checked='true'{/if}> 服务号
									</label-->
									<span class="help-block">您可以给此公众号起一个名字, 方便下次修改和查看.</span>
								</td>
							</tr>
							<!--{if !empty($id)}
							<tr>
								<th style="color:red">接口地址</th>
								<td>
									<input type="text" class="span6" value="{$_W['siteroot']}api.php?hash={$wechat['hash']}" readonly="readonly" autocomplete="off"/>
									<div class="help-block">设置“微信公众平台接口”配置信息中的接口地址</div>
								</td>
							</tr>
							<tr>
								<th style="color:red">微信Token</th>
								<td>
									<input type="text" name="wetoken" class="span6" value="{$wechat['token']}" readonly="readonly" /> <a href="javascript:;" onclick="tokenGen();">生成新的</a>
									<div class="help-block">与微信公众平台接入设置值一致，必须为英文或者数字，长度为3到32个字符. 请妥善保管, Token 泄露将可能被窃取或篡改微信平台的操作数据.</div>
								</td>
							</tr>
							{/if}-->
							<tr class="">
								<th>公众号AppId</th>
								<td>
									<input type="text" name="key" class="span6" value="" autocomplete="off"/>
									<div class="help-block">请填写微信公众平台后台的AppId</div>
								</td>
							</tr>
							<tr class="">
								<th>公众号AppSecret</th>
								<td>
									<input type="text" name="secret" class="span6" value="" autocomplete="off"/>
									<div class="help-block">请填写微信公众平台后台的AppSecret, 只有填写这两项才能管理自定义菜单</div>
								</td>
							</tr>
							<tr>
								<th><label for="">微信号</label></th>
								<td>
									<input type="text" name="account" class="span6" value="" autocomplete="off" />
									<span class="help-block">您的微信帐号，本平台支持管理多个微信公众号</span>
								</td>
							</tr>
							<tr>
								<th><label for="">原始帐号</label></th>
								<td>
									<input type="text" name="original" class="span6" value="" autocomplete="off" />
									<span class="help-block">微信公众帐号的原ID串，</span>
								</td>
							</tr>
							<tr>
								<th></th>
								<td>
									<input name="submit" type="submit" value="提交" class="btn btn-primary span2" />
								</td>
							</tr>
                            <input type="hidden" name="_token"         value="<?php echo csrf_token() ?>"/>
						</table>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	</div>
<script type="text/javascript">

</script>
@include('admin/common/footer')
