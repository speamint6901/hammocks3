;(function($){

 var CommonJS = window.CommonJS || {};

 //**************************** Scroll to Top
 CommonJS.scrollToTop = function(){
  // hide #back-top first
  $("#back-top").hide();
  // fade in #back-top
  $(function () {
   $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
     $('#back-top').fadeIn();
    } else {
     $('#back-top').stop(true, true).fadeOut();
    }
   });
   // scroll body to 0px on click
   $('#back-top a').click(function () {
    $('body,html').animate({
     scrollTop: 0
    }, 800);
    return false;
   });
  });

 }//end

 //**************************** collapse
 CommonJS.collapse = function(){

  $('.collapse .toggle_btn').click(function () {
   $(this).toggleClass('open');
   //$(this).next('ul').slideToggle();
   //$(this).next('ul').siblings('ul').slideUp();
   //$(this).siblings('.toggle_btn').removeClass('open');
  });
 }//end

 //**************************** Mobilephone Num - auto link
 CommonJS.autoPhoneNumberlink = function(){
  var ua = navigator.userAgent;
  if(ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0){
   $('.tel-link').each(function(){
    var str = $(this).text();
    $(this).html($('<a>').attr('href', 'tel:' + str.replace(/-/g, '')).append(str + '</a>'));
   });
  }
 }//end

 //**************************** Page Fade
 CommonJS.PageEffectFade = function(){
  $('body').fadeMover({
   'effectType': 1,
   'inSpeed': 800,
   'outSpeed': 800,
   'inDelay' : '0',
   'outDelay' : '0',
   'nofadeOut' : 'nonmover'
  });
 }//end

 //**************************** hamburger_menu
 CommonJS.HamburgerMenu = function(){
  $('#menuToggle, .menu-close').on('click', function(){
   $('#menuToggle').toggleClass('active');
   $('body').toggleClass('body-push-toleft');
   $('#theMenu').toggleClass('menu-open');
  });
 }//end

 //**************************** Loading?
 CommonJS.jpreLoader = function(){
  $('body').jpreLoader({
   splashID: "#jSplash",
   showSplash: true,
   showPercentage: true,
   autoClose: true,
   splashFunction: function() {
    $('#circle').delay(250).animate({'opacity' : 1}, 500, 'linear');
   }
  });
 }//end

 //**************************** SearchBar
 CommonJS.SearchBar = function(){
'use strict';
var searchWrapper = document.querySelector('.search-wrapper'), searchInput = document.querySelector('.search-input');
document.addEventListener('click', function (e) {
    if (~e.target.className.indexOf('search')) {
        searchWrapper.classList.add('focused');
        searchInput.focus();
    } else {
        searchWrapper.classList.remove('focused');
    }
});
 }//end


 //**************************** fixed_menu
 CommonJS.FixedMenu = function(){

  $("#SettingMenu-btn").click(function(){
   var clickPanel = $("+.panl_theme",this);
   clickPanel.toggle();
   $("#SettingMenu").not(clickPanel).slideUp(0);
   $('#UserMenu,#ItemEditMenu').css('display','none')
   return false;
  });

  $("#UserMenu-btn").click(function(){
   var clickPanel = $("+.panl_theme",this);
   clickPanel.toggle();
   $("#UserMenu").not(clickPanel).slideUp(0);
   $('#SettingMenu,#ItemEditMenu').css('display','none')
   return false;
  });


  $("#ItemEdit-btn").click(function(){
   var clickPanel = $("#ItemEditMenu");
   clickPanel.toggle();
   $("#ItemEditMenu").not(clickPanel).slideUp(0);
   $('#SettingMenu,#UserMenu').css('display','none')
   return false;
  });

  $("body").click(function(){
   $('#SettingMenu,#UserMenu,#ItemEditMenu').css('display','none')
  });

 }//end


 //* ==================================================
 //   Init
 //================================================== */

 $(document).ready(function(){
  //CommonJS.scrollToTop();
  //CommonJS.collapse();
  CommonJS.FixedMenu();

 });

})(jQuery);//jQuery End

