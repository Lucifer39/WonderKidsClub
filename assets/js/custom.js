//Accordian
$(document).on('click', '.accordion-tabs .accordion-list.plus', function () {
  if ($(this).hasClass('plus')) {
    $('.accordion-tabs .accordion-list').removeClass('minus').removeClass('on').addClass('off');
    $(this).addClass('minus').removeClass('off').addClass('on');
    $('.accordion-tabs .accordion-list .content').hide();
    $(this).find('.content').show();
  }
});

$(document).on('click', '.accordion-tabs .accordion-list.minus', function () {
  if ($(this).hasClass('minus')) {
    $('.accordion-tabs .accordion-list').removeClass('minus').removeClass('on').addClass('off');
    $(this).addClass('plus').removeClass('on').addClass('off');
    $('.accordion-tabs .accordion-list .content').hide();
    $(this).find('.details').hide();
  }
});

// SwiperCenter
var swiperCenter = new Swiper(".swiperCenter", {
  slidesPerView: 4,
  spaceBetween: 30,
  centeredSlides: false,
loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
300: {
  slidesPerView: 1
},
480: {
  slidesPerView: 2
},
767: {
  slidesPerView: 3
},
1024: {
  slidesPerView: 3
}
}
});

$(document).ready(function () {
	"use strict";
	toggle_bar();
});

$(window).load(function() {
  $('ul.btn-list li a.tooltitle').mouseover(function(){
    var vl = $(this).attr('aria-describedby');
    $('#'+vl+'').addClass('hide');
    });
});

function toggle_bar() {
	"use strict";
	$(".menu-bar .menu-toggle").click(function () {
		if ($(this).hasClass("active") === false) {
			$(this).addClass("active");
			$(".left-nav").animate({width: "88px"}, 100);
			$(".lt-260").animate({paddingLeft: "88px"	}, 100);
      $('.left-nav .logo,.left-nav .btn-tabs,.btn-list span,.lt-bt-widget .lg-txt span,.lt-bt-widget .md-txt').addClass('hide');
      $('ul.btn-list li a svg,.menu-toggle').css('marginRight','0');
      $('.menu-bar').css('width','100%');
      $('ul.btn-list li a.tooltitle').mouseover(function(){
        var vl = $(this).attr('aria-describedby');
        $('#'+vl+'').removeClass('hide');
        });

		} else {
			$(this).removeClass("active");
			$(".left-nav").animate({width: "260px"}, 0);
			$(".lt-260").css({paddingLeft: "260px"});
      $('.left-nav .logo,.left-nav .btn-tabs,.btn-list span,.lt-bt-widget .lg-txt span,.lt-bt-widget .md-txt').removeClass('hide');
      $('ul.btn-list li a svg,.menu-toggle').css('marginRight','1em');
      $('.menu-bar').css('width','auto');
      $('ul.btn-list li a.tooltitle').mouseover(function(){
        var vl = $(this).attr('aria-describedby');
        $('#'+vl+'').addClass('hide');
        });
      }
	});
}


/*$(document).on('change','#school', function(){
  if($('#school').val() == 'others') {
      $('.others').removeClass('hide'); 
  } else {
      $('.others').addClass('hide'); 
  }
});*/

$(document).ready(function() {
  // initiate all tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
});


