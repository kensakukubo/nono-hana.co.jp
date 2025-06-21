$(function () {
    $(window).on("scroll", function () {
      const sliderHeight = $(".header-line").height();
      if (sliderHeight - 0 < $(this).scrollTop()) {
        $(".header-focus").addClass("header-on");
      } else {
        $(".header-focus").removeClass("header-on");
      }
    });
  });

$(function(){
  var pagetop = $('#page-top');
  pagetop.hide();
  $(window).scroll(function () {
     if ($(this).scrollTop() > 100) {
          pagetop.fadeIn();
     } else {
          pagetop.fadeOut();
     }
  });
  pagetop.click(function () {
     $('body, html').animate({ scrollTop: 0 }, 500);
     return false;
  });
});

$(function () {
    $(".qa .ttl").on("click", function() {
      $(".qa .ttl").not(this).removeClass("open");
      $(".qa .ttl").not(this).next().slideUp(200);
      $(this).toggleClass("open");
      $(this).next().slideToggle(200);
    });
  });

  const $mask = $(".mask")
  const $lock = $("body")
  
  $(function(){
    $(".menu-btn").on("click",function(){
        $mask.toggleClass("show");        
        $lock.toggleClass("lock");        
    });   
  });

  $(function(){
    $('#nav .main').on("click",function(){
        $mask.removeClass("show");
        $lock.removeClass("lock");
        $("#active").removeAttr("checked").prop("checked", false).change();
    });
  });