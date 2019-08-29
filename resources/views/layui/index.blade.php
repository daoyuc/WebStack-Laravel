<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{config('app.name')}}</title>
<meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="apple-mobile-web-app-status-bar-style" content="black"> 
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="format-detection" content="telephone=no">

  <link href="{{asset('layui/css/layui.css')}}" media="all" rel="stylesheet">
  <link href="{{asset('css/global.css')}}" media="all" rel="stylesheet">
</head>
<body>
<div class="layui-layout layui-layout-admin">
  


<div class="layui-header header header-demo" summer>
  <div class="layui-main">
    <a class="logo" href="/">
      <img src="{{ asset('img/logo@2x.png') }}" alt="">
    </a>
    <div class="layui-form component" lay-filter="LAY-site-header-component"></div>
    <ul class="layui-nav">
      <li class="layui-nav-item layui-this">
        <a href="/">首页</a> 
      </li>

      <li class="layui-nav-item layui-hide-xs">
        <a href="{{config('common.github')}}" target="_blank">Github</a>
      </li>

    </ul>
  </div>
</div>
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]--> 
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="demo" style="margin-right: 10px;">
	        @foreach ($categories as $categorie)

	        @if (count($categorie->children) == 0 && $categorie->parent_id == 0)
	        <li class="layui-nav-item">
	            <a href="#cate_{{$categorie->id}}">
	                {{ $categorie->title }}
	            </a>
	        </li>
	        @elseif (count($categorie->children) != 0 && $categorie->parent_id == 0)
	        <li class="layui-nav-item layui-nav-itemed">
	            <a href="javascript:;">
	                {{ $categorie->title }}
	            </a>
	            <dl class="layui-nav-child">
	                @foreach ($categorie->children as $child)
	                <dd>
	                    <a href="#cate_{{ $child->id }}">
	                        {{ $child->title }}
	                    </a>
	                </dd>
	                @endforeach
	            </dl>
	        </li>
	        @endif
	        @endforeach
	    </ul>
    </div>
  </div>
  

    <div class="layui-tab layui-tab-brief site-demo-table" lay-filter="demoTitle">
		<div class="layui-body layui-tab-content site-demo site-demo-body">	
			@foreach($categories as $category)
                    @if(count($category->sites) != 0)
                <fieldset class="layui-elem-field layui-field-title" id="cate_{{$category->id}}" style="margin-top: 50px;">
                    <legend>
                        {{$category->title}}
                    </legend>
                </fieldset>
                <table class="layui-table" lay-size="sm">
                    <colgroup>
                        <col width="150">
                            <col width="200">
                                <col>
                                </col>
                            </col>
                        </col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th width="15%">
                                名称
                            </th>
                            <th width="5%">
                                logo
                            </th>
                            <th width="20%">
                                网址
                            </th>
                            <th width="60%" class="layui-hide-xs">
                                签名
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->sites as $site)
                        <tr>
                            <td>
                                {{$site->title}}
                            </td>
                            <td>
                            	<a href="javascript:void(0);" onclick="window.open('{{$site->url}}', '_blank')">
                                @if ($site->thumb)
                                <img alt="{{$site->title}}" lay-src="{{Storage::url($site->thumb)}}" width="40" height="40" />
                                @else
                                <img alt="{{$site->title}}" src="{{config('common.default_img')}}" width="40" />
                                @endif
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0);" onclick="window.open('{{$site->url}}', '_blank')">
                                    {{$site->url}}
                                </a>
                            </td>
                            <td class="layui-hide-xs">
                                {{$site->describe}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <br>
            @endforeach
        </div>

        <div class="layui-footer footer footer-demo">
		  <div class="layui-main">
		    <p>&copy; 2019 <a href="/">phpf5.com</a> MIT license</p>
		    <p>
		      <a href="https://github.com/sentsin/layui/" target="_blank" rel="nofollow">Layui</a>
		      <a href="{{config('common.github')}}" target="_blank" rel="nofollow">WebStack</a>
		      <a href="javascript:void(0);" target="_blank" rel="nofollow">Mars ICP备 000000 号</a>
		    </p>
		    <p class="site-union">
		      <a href="javascript:void(0);" target="_blank" rel="nofollow" upyun><img src="{{asset('img/aliyun.png')}}" alt="aliyun"></a>
		      <span>图片加速 阿里云CDN</span>
		    </p>
		  </div>
		</div>
    </div>
  </div>
   
<div class="site-tree-mobile layui-hide">
  <i class="layui-icon">&#xe602;</i>
</div>
<div class="site-mobile-shade"></div>
<script charset="utf-8" src="{{asset('layui/layui.js')}}"></script>
        
<script>
layui.config({
  base: '/layui/lay/modules/'
  ,version: '20190828'
}).use(['global','flow', 'element'], function(){
  var element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块
  //监听导航点击
  element.on('nav(demo)', function(elem){
    //console.log(elem.text())
    document.getElementsByClassName("site-mobile-shade")[0].click()
    //layer.msg(elem.text());
  });

  var flow = layui.flow;
  flow.lazyimg({scrollElem:'.layui-body'});
});
</script>
 
</div>
@if (config('app.env') == 'production')
<script>
    var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "https://hm.baidu.com/hm.js?16d95c7d296b357710564bba98f8efb9";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
</script>
@endif
</body>
</html>