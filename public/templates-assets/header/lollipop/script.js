$(document).ready(function(){
  $body = $('body');  
  $body.on('click', 'header .mini-cart-content',function(e) {
    $('header .mini-cart-content').find(".mini-cart-dropdown").addClass('open');
    e.preventDefault();
  });
  
  $body.on('click', 'header .mini-cart-content .close-cart', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('header .mini-cart-content').find(".mini-cart-dropdown").removeClass('open');
  });
  
  $body.on('click', 'header .mini-cart-content .title, header .mini-cart-content .img, header .mini-cart-content .delete, header .mini-cart-content .cart-bottom .checkout, header .mini-cart-content .cart-bottom .cart', function(e) {
    e.preventDefault();
    e.stopPropagation();
    window.location.href = $(this).find('a').attr('href');
  });

  inputCounter();
  
  // breakpoint and up  
  $(window).resize(function(){
    if ($(window).width() >= 980){	
      // when you hover a toggle show its dropdown menu
      $("header .header-content-menu .navbar .dropdown-toggle").hover(function () {
         $(this).parent().toggleClass("show");
         $(this).parent().find(".dropdown-menu").toggleClass("show"); 
       });

        // hide the menu when the mouse leaves the dropdown
      $( "header .header-content-menu .navbar .dropdown-menu" ).mouseleave(function() {
        $(this).removeClass("show");  
      });
    }	
  });
  
  //sticky
window.onscroll = function() {stickyFunction()};

var navbar = document.getElementById("sticky_nav");
var sticky = navbar.offsetTop + 100;

function stickyFunction() {
  if ($(window).width() >= 1025){	
    if (window.pageYOffset >= sticky) {
      navbar.classList.add("sticky")
      navbar.classList.add("sticky-nav")
    } else {
      navbar.classList.remove("sticky");
      navbar.classList.remove("sticky-nav");
    }
  }
}
});

function inputCounter() {
  $('header .mini-cart-content .input-counter').find('.minus-btn, .plus-btn').click(function( e ) {
      var $input = $(this).parent().find('input');
      var count = parseInt($input.val(), 10) + parseInt(e.currentTarget.className === 'plus-btn' ? 1 : -1, 10);
      $input.val(count).change();
  });
  
  $('header .mini-cart-content .input-counter').find("input").change(function() {
      var _ = $(this);
      var min = 1;
      var val = parseInt(_.val(), 10);
      var max = parseInt(_.attr('size'), 10);
      val = Math.min(val, max);
      val = Math.max(val, min);
      _.val(val);
  })
  .on("keypress", function( e ) {
      if (e.keyCode === 13) {
          e.preventDefault();
      }
  });
};