/**
 phpf5网址导航
*/

layui.define(['element', 'table', 'util'], function(exports){
  var $ = layui.jquery
  ,element = layui.element
  ,layer = layui.layer
  ,form = layui.form
  ,util = layui.util
  ,device = layui.device()

  ,$win = $(window), $body = $('body');


  //阻止IE7以下访问
  if(device.ie && device.ie < 8){
    layer.alert('Layui最低支持ie8，您当前使用的是古老的 IE'+ device.ie + '，你丫的肯定不是程序猿！');
  }
 
  //窗口scroll
  ;!function(){
    var main = $('.site-tree').parent(), scroll = function(){
      var stop = $(window).scrollTop();

      if($(window).width() <= 750) return;
      var bottom = $('.footer').offset().top - $(window).height();
      if(stop > 211 && stop < bottom){
        if(!main.hasClass('site-fix')){
          main.addClass('site-fix');
        }
        if(main.hasClass('site-fix-footer')){
          main.removeClass('site-fix-footer');
        }
      } else if(stop >= bottom) {
        if(!main.hasClass('site-fix-footer')){
          main.addClass('site-fix site-fix-footer');
        }
      } else {
        if(main.hasClass('site-fix')){
          main.removeClass('site-fix').removeClass('site-fix-footer');
        }
      }
      stop = null;
    };
    scroll();
    $(window).on('scroll', scroll);
  }();

  //示例页面滚动
  $('.site-demo-body').on('scroll', function(){
    var elemDate = $('.layui-laydate,.layui-colorpicker-main')
    ,elemTips = $('.layui-table-tips');
    if(elemDate[0]){
      elemDate.each(function(){
        var othis = $(this);
        if(!othis.hasClass('layui-laydate-static')){
          othis.remove();
        }
      });
      $('input').blur();
    }
    if(elemTips[0]) elemTips.remove();

    if($('.layui-layer')[0]){
      layer.closeAll('tips');
    }
  });


  //让导航在最佳位置
  var setScrollTop = function(thisItem, elemScroll){
    if(thisItem[0]){
      var itemTop = thisItem.offset().top
      ,winHeight = $(window).height();
      if(itemTop > winHeight - 120){
        elemScroll.animate({'scrollTop': itemTop/2}, 200)
      }
    }
  }
  setScrollTop($('.site-demo-nav').find('dd.layui-this'), $('.layui-side-scroll').eq(0));
  setScrollTop($('.site-demo-table-nav').find('li.layui-this'), $('.layui-side-scroll').eq(1));
  

  //手机设备的简单适配
  var treeMobile = $('.site-tree-mobile')
  ,shadeMobile = $('.site-mobile-shade')

  treeMobile.on('click', function(){
    $('body').addClass('site-mobile');
  });

  shadeMobile.on('click', function(){
    $('body').removeClass('site-mobile');
  });

  exports('global', {});
});