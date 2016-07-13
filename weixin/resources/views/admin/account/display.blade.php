
@include('admin/common/header')

	<script type="text/javascript" src="{{URL::asset('/')}}script/jquery.zclip.min.js"></script>
	<ul class="nav nav-tabs">
		<!--ul class="pull-right unstyled">
			<li><a href="{php echo create_url('account/post')}">添加公众号</a></li>
			<li class="active"><a href="{php echo create_url('account/display')}">管理公众号</a></li>
		</ul-->
		<li><a href="{{URL('post')}}"><i class="icon-plus"></i> 添加公众号</a></li>
		<li><a href="{{URL('display')}}">微信公众号</a></li>
	</ul>
	<div class="main">
		<div class="account">
        @foreach($list as $val)
			<div class="navbar-inner thead">
				<h4>
					<span class="pull-right">
                        <a onclick="return confirm('删除帐号将同时删除全部规则及回复，确认吗？');return false;" href="{{URL('del')}}?id={{$val->p_id}}">删除</a>
                    </span>
					<span class="pull-left"><small>（微信号：{{$val->w_num}}）<span>创始人</span>]</small></span>
				</h4>
			</div>
			<div class="tbody">
				<div class="con">
					<div class="name pull-left">API地址</div>
					<div class="input-append pull-left" id="">
						<input id="" type="text" value="{{$val->address}}">
						<button class="btn" type="button">复制</button>
					</div>
				</div>
				<div class="con">
					<div class="name pull-left">Token</div>
					<div class="input-append pull-left" id="">
						<input id="" type="text" value="{{$val->token}}">
						<button class="btn" type="button">复制</button>
					</div>
				</div>
			</div>
            @endforeach
		</div>
	</div>
@include('admin/common/footer')
