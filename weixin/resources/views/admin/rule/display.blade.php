
@include('admin/common/header')
<ul class="nav nav-tabs">
	<li class="active"><a href="{{URL('rule')}}">管理规则</a></li>
	<li><a href="{{URL('add_rule')}}"><i class="icon-plus"></i> 添加规则</a></li>
</ul>
<div class="main">
	<div class="search">
		<form action="rule.php" method="get">
		<input type="hidden" name="act" value="display" />
		<table class="table table-bordered tb">
			<tbody>
				<!--tr>
					<th>规则类型</th>
					<td>
					<ul class="nav nav-pills">
						<li {if 'all' == $module}class='active'{/if}><a href="{php echo create_url('rule/display', array('module' => 'all', 'keyword' => $_GPC['keyword']))}">全部</a></li>
						{loop $modules $row}
						{if $row['issystem']}<li {if $row['name'] == $module}class='active'{/if}><a href="{php echo create_url('rule/display', array('module' => $row['name'], 'keyword' => $_GPC['keyword']))}">{$row['title']}</a></li>{/if}
						{/loop}
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">更多 <b class="caret"></b></a>
							<ul class="dropdown-menu">
								{loop $modules $row}
								{if !$row['issystem']}<li {if $row['name'] == $_GPC['module']}class='active'{/if}><a href="{php echo create_url('rule/display', array('module' => $row['name'], 'keyword' => $_GPC['keyword']))}">{$row['title']}</a></li>{/if}
								{/loop}
							</ul>
						</li>
					</ul>
					</td>
				</tr-->
				<tr>
					<th>状态</th>
					<td>
						<select name="status">
							<option value="1">启用</option>
							<option value="0">禁用</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>关键字</th>
					<td>
							<input class="span6" name="keyword" id="" type="text" value="">
					</td>
				</tr>
				 <tr class="search-submit">
					<td colspan="2"><button class="btn pull-right span2" disabled><i class="icon-search icon-large"></i> 搜索</button></td>
				 </tr>
			</tbody>
		</table>
		</form>
	</div>
	<div class="rule">

		<table class="tb table table-bordered">
			<tr class="control-group">
				<td class="rule-content">
					<h4>
						<span class="pull-right"><a onclick="return confirm('删除规则将同时删除关键字与回复，确认吗？');return false;" href="">删除</a></span>
						 <small></small>
					</h4>
				</td>
			</tr>
            <volist name="arr" id="arr">
                <tr class="control-group">
                    <td class="rule-kw">
                        <div>
                            <b>关键字：　</b><span></span>
                        </div>
                        <div>
                            <b>回　复：　</b><span>
                        </span>
                        </div>
                    </td>
                </tr>
            </volist>

		</table>

	</div>
</div>
@include('admin/common/footer')
