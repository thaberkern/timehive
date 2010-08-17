/*******************************************************************************
 jquery.mb.components
 Copyright (c) 2001-2010. Matteo Bicocchi (Pupunzi); Open lab srl, Firenze - Italy
 email: info@pupunzi.com
 site: http://pupunzi.com

 Licences: MIT, GPL
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 ******************************************************************************/

/*
 * Name:jquery.mb.tooltip
 * Version: 1.6
 * dependencies: jquery.timers.js, jquery.dropshadow.js
*/

(function($){
  jQuery.fn.mbTooltip = function (options){
    return this.each (function () {
      this.options = {
        live:true,
        opacity : .9,
        wait:2000,
        timePerWord:70,
        cssClass:"default",
        hasArrow:true,
        imgPath:"images/",
        hasShadow:true,
        shadowColor:"black",
        shadowLeft:1,
        anchor:"mouse", //"parent",
        shadowTop:1,
        mb_fade:200
      };
      $.extend (this.options, options);
      if (this.options.live)$("[title]").live("mouseover",function(){$(this).mbTooltip(options);});
      var ttEl=$(this).is("[title]")? $(this): $(this).find("[title]");
      var wait=this.options.wait;
      var hasShadow=this.options.hasShadow;
      var fade=this.options.mb_fade;
      var myOptions=this.options;
      $(ttEl).each(function(){
/*
        $(this).hover(function(){
          $(this).css("cursor","help");
        },function(){
          $(this).css("cursor","default");
        });
*/
        $(this).attr("tooltip", $(this).attr("title"));
        $(this).removeAttr("title");
        $(this).attr("tooltipEnable","true");
        var theEl=$(this);
        var ttCont= theEl.attr("tooltip");
        var hover=$.browser.msie?"mouseenter":"mouseover";
        $(this).bind(hover,function(e){
          if (myOptions.anchor=="mouse") $(document).mb_getXY();
          $(this).one("mouseout",function(){
            $(this).stopTime();
            $(this).deleteTooltip(hasShadow,fade);
          }).one("click",function(){
            $(this).stopTime();
            $(this).deleteTooltip(hasShadow,fade);
          });
          $(this).oneTime(wait, function() {
            if ($(this).attr("tooltipEnable")=="true")
              $(this).buildTooltip(ttCont,myOptions,e);
          });
        });
      });
    });
  };

  var mbX = 0;
  var mbY = 0;

  $.fn.extend({
    mb_getXY:function(){
      $(document).bind("mousemove", function(e) {
        mbX = e.pageX;
        mbY = e.pageY;
      });
      return {x:mbX,y:mbY};
    },
    buildTooltip: function(cont,options){
      this.options={};
      $.extend (this.options, options);
      var parent=$(this);
      $("body").append("<div id='tooltip'></div>");
      var imgUrl=this.options.imgPath+"up.png";
      $("#tooltip").html(cont);
      $("#tooltip").addClass(this.options.cssClass);
      if (this.options.hasArrow){
        $("#tooltip").prepend("<img id='ttimg' src='"+imgUrl+"'>");
        $("#ttimg").css({
          position:"absolute",
          opacity:.5
        });

        $("#ttimg").addClass("top");
      }
      $("#tooltip").css({
        position:"absolute",
        top:  this.options.anchor=="mouse"?$(document).mb_getXY().y +7:parent.offset().top+(parent.outerHeight()),
        left:this.options.anchor=="mouse"?$(document).mb_getXY().x+7:parent.offset().left,
        opacity:0
      });

      $("#tooltip").findBestPos(parent,this.options.imgPath,this.options.anchor);
      if (this.options.anchor=="mouse") $(document).unbind("mousemove");
      if (this.options.hasShadow) {
        $("#tooltip").dropShadow({left: this.options.shadowLeft, top: this.options.shadowTop, blur: 2, opacity: 0.3, color:this.options.shadowColor});
        $(".dropShadow").css("display","none");
        $(".dropShadow").mb_bringToFront();
        $(".dropShadow").fadeIn(this.options.mb_fade);
      }
      $("#tooltip").mb_bringToFront();
      $("#tooltip").fadeTo(this.options.mb_fade,this.options.opacity,function(){});
      var timetoshow=3000+cont.length*this.options.timePerWord;
      var hasShadow=this.options.hasShadow;
      var fade=this.options.mb_fade;
      $(this).oneTime(timetoshow,function(){$(this).deleteTooltip(hasShadow,fade);});
    },
    deleteTooltip: function(hasShadow,fade){
      var sel=hasShadow?"#tooltip,.dropShadow":"#tooltip";
      $(sel).fadeOut(fade,function(){$(sel).remove();});
    },
    findBestPos:function(parent,imgPath,anchor){
      var theEl=$(this);
      var ww= $(window).width()+$(window).scrollLeft();
      var wh= $(window).height()+$(window).scrollTop();
      var w=theEl.outerWidth();
      theEl.css({width:w});
      var t=((theEl.offset().top+theEl.outerHeight(true))>wh)? theEl.offset().top-(anchor!="mouse"? parent.outerHeight():0)-theEl.outerHeight()-20 : theEl.offset().top;
      t=t<0?0:t;
      var l=((theEl.offset().left+w)>ww-5) ? theEl.offset().left-(w-(anchor!="mouse"?parent.outerWidth():0)) : theEl.offset().left;
      l=l<0?0:l;
      if (theEl.offset().top+theEl.outerHeight(true)>wh){
        $("#ttimg").attr("src",imgPath+"bottom.png");
        $("#ttimg").removeClass("top").addClass("bottom");
      }
      theEl.css({width:w, top:t, left:l});
    },
    disableTooltip:function(){
      $(this).find("[tooltip]").attr("tooltipEnable","false");
    },
    enableTooltip:function(){
      $(this).find("[tooltip]").attr("tooltipEnable","true");
    }
  });

  jQuery.fn.mb_bringToFront= function(){
    var zi=10;
    $('*').each(function() {
      if($(this).css("position")=="absolute"){
        var cur = parseInt($(this).css('zIndex'));
        zi = cur > zi ? parseInt($(this).css('zIndex')) : zi;
      }
    });
    $(this).css('zIndex',zi+=100);
  };

  $(function(){
    //due to a problem of getter/setter for select
    $("select[title]").each(function(){
      var selectSpan=$("<span></span>");
      selectSpan.attr("title",$(this).attr("title"));
      $(this).wrapAll(selectSpan);
      $(this).removeAttr("title");
    });
  });

})(jQuery);

