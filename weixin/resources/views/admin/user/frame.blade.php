@include('admin/common/header')
<div id="content1">
    <div id="header">
        <div class="logo pull-left">OneTeam微信管理系统</div>
        <!-- 导航 -->
        <div class="hnav clearfix">
            <div class="row-fluid">
                <ul class="hnav-main text-center unstyled pull-left" style="width:55%;">
                    <li class="hnav-parent">
                        <a  href="javascript:void(0)" id="pid">当前公众号</a>
                    </li>

                    <li class="hnav-parent">
                        <a id="qid" >全局设置</a>
                    </li>
                    <li class="hnav-parent">
                        <a href="https://mp.weixin.qq.com/" target="_blank">公众平台</a>
                    </li>
                </ul>
                <!-- 右侧管理菜单 -->
                <ul class="hnav-manage text-center unstyled pull-right">

                    <li class="hnav-parent" id="hnav-right">

                        <a href="javascript:;"><i class="icon-chevron-down icon-large"></i>
                            <?php
                            $p_id=Session::get('p_id');
                            if($p_id){
                                //echo $p_id;
                                $row= DB::table('we_pub')->where('p_id',$p_id)->lists('p_name');
                                $p_name=$row[0];
                            }else{

                            }

                            ?>

                            @if($p_id)
                                <li><a href="" class="p_name"><?php echo $p_name?></a></li>
                            @else
                                <span id="current-account">请切换公众号</span>
                            @endif

                            {{--<span id="current-account">请切换公众号</span>--}}

                            <!--隐藏域传公众账号id-->
                            <input type="hidden" value="<?php echo $p_id?>" id="g_id"/>
                        </a>
                        <ul class="hnav-child unstyled text-left" id="hnav-ul" style="margin-left: 14px;">

                            <li><a href="" class="p_name"></a></li>

                        </ul>
                    </li>

                    <li class="hnav-parent">
                        <a href=""><i class="icon-user icon-large"></i></a>
                    </li>
                    <li class="hnav-parent">
                        <a href=""><i class="icon-signout icon-large"></i>退出</a>
                    </li>

                </ul>
                <!-- end -->

                <script type="text/javascript">
                    $(function(){
                        var j=0;
                        $("#hnav-right").click(function(){

                            if(j%2==0){
                                var url="{{URL('nav')}}";
                                $.get(url,function(msg){
                                    //alert(msg)
                                    $("#hnav-ul").html(msg)
                                });
                                $('#hnav-ul').css('display','block');
                            }
                            else{
                                $('#hnav-ul').css('display','none');
                            }
                            j++;
                        })

                    })


                    function check(p_id){
                        var url="{{URL('update')}}";
                        var data={'p_id':p_id};
                        $.get(url,data,function(msg){
                            $("#current-account").html(msg)
                            location.href='{{URL('index')}}';
                        })
                    }

                    //判断当前是否选择公众号
                    $("#pid").click(function(){
                        var p_id=$("#g_id").val();
                        var url="{{URL('welcome1')}}";
                        //alert(url)
                        var id=1;
                        var data={'id':id}
                        //alert(url)
                        if(p_id==0){
                            alert('请选择公众账号');
                            return  false;
                        }else{
                            $.get(url,data,function(msg){
                                $("#content").html(msg)
                            })
                        }
                    });
                    $("#qid").click(function(){
                        var url="{{URL('frame1')}}";
                        $.get(url,function(msg){
                            //alert(msg)
                            $("#content1").html(msg)
                        })
                    })

                </script>
            </div>
        </div>
        <!-- end -->
    </div>
    <!-- 头部 end -->
    <div class="content-main">
        <table width="100%"   cellspacing="0" cellpadding="0" id="frametable">
            <tbody>
            <tr>
                <td valign="top" height="100%" class="content-left">


                    @if($p_id)

                        <div class="sidebar-nav" style="" id="left">
                            @foreach($list as $val)

                                <span class="snav-big">
                            <i class="icon-folder-open">{{$val->m_name}}</i>
                        </span>
                                @foreach($val->two as $v)
                                    <ul class="snav unstyled">

                                        <li class="snav-header-list">
                                            <a href="{{URL("{$v->m_controller}")}}" target="main">
                                                <i class="arrow">{{$v->m_name}}</i>
                                            </a>
                                        </li>
                                        @endforeach
                                        <li class="snav-header" > </li>


                                        <li class="snav-list" name="">
                                            <a href="" target="main"><i class="arrow"></i></a>
                                        </li>

                                    </ul>
                                @endforeach
                        </div>
                    @else
                        <div class="sidebar-nav" style="">
                            @foreach($obj as $val)

                                <span class="snav-big">
                            <i class="icon-folder-open">{{$val->m_name}}</i>
                        </span>
                                @foreach($val->two as $v)
                                    <ul class="snav unstyled">

                                        <li class="snav-header-list">
                                            <a href="{{URL('display')}}" target="main">
                                                <i class="arrow">{{$v->m_name}}</i>
                                            </a>
                                        </li>
                                        @endforeach
                                        <li class="snav-header" > </li>


                                        <li class="snav-list" name="">
                                            <a href="" target="main"><i class="arrow"></i></a>
                                        </li>

                                    </ul>
                                @endforeach
                        </div>
                        @endif


                                <!-- 右侧管理菜单上下控制按钮 -->
                        <div class="scroll-button">
                            <span class="scroll-button-up"><i class="icon-caret-up"></i></span>
                            <span class="scroll-button-down"><i class="icon-caret-down"></i></span>
                        </div>
                        <!-- end -->
                </td>
                <td valign="top" height="100%" style="">
                    <div id="content">
                        <iframe width="100%" scrolling="yes" height="100%" frameborder="0"
                                style="min-width:800px; overflow:visible; height:565px;" name="main" id="main" src="{{URL('welcome')}}">
                        </iframe>
                    </div>

                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.snav-header').click(function(){
                var name='lt-'+$(this).attr('lid');
                if($(this).hasClass("open")){
                    $(this).removeClass('open');
                    $('.snav-list').css('display','none');
                }else{
                    $('.snav-header').removeClass('open');
                    $('.snav-list').css('display','none');
                    $(this).addClass('open');
                    $('li[name='+name+']').css('display','block');
                }
            });
        });
    </script>
</div>



