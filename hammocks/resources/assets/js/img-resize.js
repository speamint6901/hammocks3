;(function($){
 $.fn.resizeAll = function(){

  console.log(this);
  var elements = this;
  $(elements).css('display', 'inline');
  elements.each(function(){
  console.log("each");
   this.onload = function() {
   console.log("img onload");
   var img_width = $(this).width();
   var img_height = $(this).height();

   var div_width = $(this).parent().width();
   var div_height = $(this).parent().height();

   var img_per = img_width >= img_height ? img_width / img_height : img_height / img_width ;
   var div_per = div_width >= div_height ? div_width / div_height : div_height / div_width ;

   if(img_width >= img_height){
    if(img_per <= div_per){
     var mt = Math.round(((div_width / img_per) - div_height) / 2);
     $(this).attr('width', div_width).css('margin-top', '-'+mt+'px');
     $(this).css('width', div_width+'px');

    }else if(img_per > div_per){
     var ml = Math.round(((div_height * img_per) - div_width) / 2);
     $(this).attr('height', div_height).css('margin-left', '-'+ml+'px');
     $(this).css('height', div_width+'px');
    }
   }else if(img_width < img_height){
    var mt = Math.round(((div_width * img_per) - div_height) / 2);
    $(this).attr('width', div_width).css('margin-top', '-'+mt+'px');
    $(this).css('width', div_width+'px');
   }
   }
  });
 };

 $.fn.resizeOne = function(){

  var elements = this;
  $(elements).css('display', 'inline');
   this.bind("load", function() {
   console.log("img onload");
   var img_width = $(this).width();
   var img_height = $(this).height();

   var div_width = $(this).parent().width();
   var div_height = $(this).parent().height();

   var img_per = img_width >= img_height ? img_width / img_height : img_height / img_width ;
   var div_per = div_width >= div_height ? div_width / div_height : div_height / div_width ;

   if(img_width >= img_height){
    if(img_per <= div_per){
     var mt = Math.round(((div_width / img_per) - div_height) / 2);
     $(this).attr('width', div_width).css('margin-top', '-'+mt+'px');
     $(this).css('width', div_width+'px');

    }else if(img_per > div_per){
     var ml = Math.round(((div_height * img_per) - div_width) / 2);
     $(this).attr('height', div_height).css('margin-left', '-'+ml+'px');
     $(this).css('height', div_width+'px');
    }
   }else if(img_width < img_height){
    var mt = Math.round(((div_width * img_per) - div_height) / 2);
    $(this).attr('width', div_width).css('margin-top', '-'+mt+'px');
    $(this).css('width', div_width+'px');
   }
   });
 };
})(jQuery);
