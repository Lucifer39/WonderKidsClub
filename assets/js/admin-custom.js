$(document).ready(function () {
	"use strict";
	leftmenu_navigation();
	toggle_bar();
});

$(window).resize(function () {
	"use strict";
	$('#m_aside_left').perfectScrollbar();
});

$(window).load(function () {
	"use strict";
	$('#m_aside_left').perfectScrollbar();
});

//Leftside Menu
function leftmenu_navigation() {
	"use strict";
	$(".m_menu_item_submenu").click(function () {
		if ($(this).hasClass("open") === false) {
			$(".m_menu_submenu").slideUp("slow");
			$(".m_menu_item_submenu").removeClass("open");
			$(this).find(".m_menu_submenu").slideDown("slow");
			$(this).addClass("open");
		} else {
			$(this).removeClass("open");
			$(this).find(".m_menu_submenu").slideUp("fast");

		}
	});
}

// Toggle Bar
function toggle_bar() {
	"use strict";
	$("#bars_button").click(function () {
		if ($(this).hasClass("active") === false) {
			$(this).addClass("active");
			$("#m_aside_left").animate({
				width: "50px"
			}, 100);
			$("#m_aside_left").find(".m-menu_link_title .name").animate({
				opacity: "0"
			}, 100);
			$("#m_aside_left").find(".m_menu_link").addClass("hide");
			$(".dashboard-panel").animate({
				marginLeft: "50px"
			}, 100);
			$(".m_menu_item_submenu").removeClass("open");
			$("#m_aside_left").find(".m_menu_submenu").hide();
			$("#m_aside_left").click(function () {
				$("#bars_button").removeClass("active");
				$("#m_aside_left").animate({
					width: "230px"
				}, 0);
				$("#m_aside_left").find(".m-menu_link_title .name").animate({
					opacity: "1"
				}, 100);
				$("#m_aside_left").find(".m_menu_link").removeClass("hide");
				$(".dashboard-panel").animate({
					marginLeft: "230px"
				}, 200);
				$(".m_menu_item_submenu>a.m_menu_link,.m_menu_item_heading").animate({
					padding: "9px 10px"
				});
			});

			$(".m_menu_item_submenu>a.m_menu_link,.m_menu_item_heading").animate({
				padding: "9px 10px"
			}, 100);
		} else {
			$(this).removeClass("active");
			$("#m_aside_left").animate({
				width: "230px"
			}, 0);
			$("#m_aside_left").find(".m-menu_link_title .name").animate({
				opacity: "1"
			}, 100);
			$("#m_aside_left").find(".m_menu_link").removeClass("hide");
			$(".dashboard-panel").animate({
				marginLeft: "230px"
			}, 200);
			$(".m_menu_item_submenu>a.m_menu_link,.m_menu_item_heading").animate({
				padding: "9px 10px"
			});
		}
	});
}

/*$('#datepicker input').datepicker({
	
	        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true
});

$(document).ready(function(){
	"use strict";
  $('[data-toggle="tooltip"]').tooltip(); 
});*/

$('.table-responsive').on('show.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "inherit" );
});

$('.table-responsive').on('hide.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "auto" );
})

$(document).on('click','#editpermalink',function(){
	$(this).addClass('off').html('Close');
	$('#editable-post-name').removeClass('hide');
});

$(document).on('click','#editpermalink.off',function(){
	$(this).removeClass('off').html('Edit');
	$('#editable-post-name').addClass('hide');
});