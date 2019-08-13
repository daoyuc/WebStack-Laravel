<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
            <title>
                {{config('app.name')}}
            </title>
            <meta content="webkit" name="renderer">
                <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
                    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
                        <link href="{{asset('css/layui.css')}}" media="all" rel="stylesheet">
                        </link>
                    </meta>
                </meta>
            </meta>
        </meta>
    </head>
    <body>
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>
                垂直导航菜单
            </legend>
        </fieldset>
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
        <div class="layui-tab" id="layui-tab" lay-filter="demoTitle">
            <div class="layui-body layui-tab-content site-demo site-demo-body">
                @foreach($categories as $category)
                    @if(count($category->sites) != 0)
                <fieldset class="layui-elem-field layui-field-title" id="cate_{{$category->id}}" style="margin-top: 50px;">
                    <legend>
                        {{$category->title}}
                    </legend>
                </fieldset>
                <table class="layui-table" lay-size="lg">
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
                            <th width="60%">
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
                                <img alt="{{$site->title}}" lay-src="{{Storage::url($site->thumb)}}" width="40" />
                            </td>
                            <td>
                                <a href="javascript:void(0);" onclick="window.open('{{$site->url}}', '_blank')">
                                    {{$site->url}}
                                </a>
                            </td>
                            <td>
                                {{$site->describe}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <br>
                    @endforeach
                    <div class="layui-footer footer footer-demo">
                        <div class="layui-main">
                            <p>
                                © 2019
                                <a href="https://www.mouha.net" target="_blank">
                                    mouha.net
                                </a>
                                MIT license
                            </p>
                        </div>
                    </div>
                </br>
            </div>
        </div>
        <script charset="utf-8" src="{{asset('js/layui.js')}}"></script>
        
        <script>
            layui.use(['flow', 'element'], function(){
              var element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块
              //监听导航点击
              element.on('nav(demo)', function(elem){
                console.log(elem.text())
                //layer.msg(elem.text());
              });

              var flow = layui.flow;
              flow.lazyimg({scrollElem:'.layui-body'});
            });
        </script>
        <script>
            var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?16d95c7d296b357710564bba98f8efb9";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
        </script>
    </body>
</html>