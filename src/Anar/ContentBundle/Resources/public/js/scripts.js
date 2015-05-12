/**
 * Executing script for various functions.
 *
 * @name executing_script
 * @version 1.0.0
 * @requires jQuery v1.2.3+
 * @author Verve Themes
 * @license All right reserved.
 *
 * Copyright (c) 2014
 */
 
jQuery(document).ready(function($) {

/* ==============================================================
/*	Header NavBar 
/* ============================================================== */	

if($(window).width()>991) {
	$('header .navbar-nav > li.menu-item-has-children').hover(function(){
		$(this).children('ul.sub-menu').stop().css('margin-top',25);
		$(this).children('ul.sub-menu').fadeIn({queue: false, duration: 600});
		$(this).children('ul.sub-menu').animate({'margin-top':0}, 700, 'easeOutExpo');
	}, function() {
		$(this).children('ul.sub-menu').stop().fadeOut({queue: false, duration: 600});
		$(this).children('ul.sub-menu').animate({'margin-top':25}, 1000, 'easeOutExpo');
	});
} else {
	$('header .navbar-nav > li.menu-item-has-children').hover(function(){
		$(this).children('ul.sub-menu').css('display','block');
	}, function() {
		$(this).children('ul.sub-menu').css('display','none');
	});
}
if($(window).width()>991) {
	$('header ul.sub-menu > li.menu-item-has-children').hover(function(){
		$(this).children('ul.sub-menu').stop().css('margin-left',-25);
		$(this).children('ul.sub-menu').fadeIn({queue: false, duration: 600});
		$(this).children('ul.sub-menu').animate({'margin-left':0}, 700, 'easeOutExpo');
	}, function() {
		$(this).children('ul.sub-menu').stop().fadeOut({queue: false, duration: 600});
		$(this).children('ul.sub-menu').animate({'margin-left':-25}, 1000, 'easeOutExpo');
	});
} else {
	$('header ul.sub-menu > li.menu-item-has-children').hover(function(){
		$(this).children('ul.sub-menu').css('display','block');
	}, function() {
		$(this).children('ul.sub-menu').css('display','none');
	});
}

/* ===================================================================
/*	Isotope
/* =================================================================== */

if($('.blog-listing').hasClass('p-normal')) {
	$('.isotope > .row').isotope({
		masonry: {
			columnWidth: '.blog-listing.p-normal'
		}
	});
} else {
	$('.isotope > .row').isotope({
		masonry: {
			columnWidth: '.blog-listing'
		}
	});
}

if($(window).width()<=1200 && $(window).width()>991) { 
	$('.p-high').addClass('p-normal p-high-disabled col-md-8').removeClass('p-high col-md-16');
	$('.p-high').queue(function(){
		$('.isotope > .row').isotope('reloadItems').isotope();
	});
	
}

$('.isotope > .row').isotope('bindResize');
// $( window ).resize(function() {
// 	if($(window).width()<=1200 && $(window).width()>991) { 
// 		$('.p-high').addClass('p-normal p-high-disabled col-md-8').removeClass('p-high col-md-16');
// 		$('.isotope > .row').isotope('reloadItems').isotope();
// 	} else { 
// 		$('.p-high-disabled').addClass('p-high col-md-16').removeClass('p-high-disabled p-normal col-md-8');
// 		$('.isotope > .row').isotope('reloadItems').isotope();
// 	}
// });



/* ===================================================================
/*	Much wow
/* =================================================================== */

// var anim = new WOW(
//   {
//     boxClass:     'anim',      // animated element css class (default is wow)
//     animateClass: 'animated', // animation css class (default is animated)
//     offset:       0,          // distance to the element when triggering the animation (default is 0)
//     mobile:       false,       // trigger animations on mobile devices (default is true)
//     live:         true        // act on asynchronously loaded content (default is true)
//   }
// );
// if($(window).width()>1024) { anim.init(); }

/* ===================================================================
/*	Quote Slider
/* =================================================================== */

$('.entry-quotes-list').carousel({interval:7000});
$('.entry-quotes-list').bind('slid', function (e) {
    $('.isotope > .row').isotope('reloadItems').isotope();
});


/* ===================================================================
/*	Top Search
/* =================================================================== */

$('.tp-search i.fa-search').toggle(function(){
	$(this).parents('.tp-search').addClass('tp-search-open');
	$('header nav').animate({'left':+18, 'opacity':0},200,'easeInOutExpo');
}, function() {
	$(this).parents('.tp-search').removeClass('tp-search-open');
	$('header nav').animate({'left':0, 'opacity':1},200,'easeInOutExpo');
});

/* ==============================================================
/*	Hide addressbar on mobile devices
/* ============================================================== */
    
window.scrollTo(0,1);

/* ==============================================================
/*	Alert boxes
/* ============================================================== */

$(".alert").delegate(".close", "click", function(event) {
event.preventDefault();
  $(this).closest(".alert").fadeOut(function(event){
    $(this).remove();
  });
});

/* ==============================================================
/*	Tabs
/* ============================================================== */

$('ul.tabber').find('.dummy-content-tab').each(function(){
	var tab_content = $(this).html();
	$(this).parent().siblings('.tab-content').append(tab_content);
	$(this).remove();
});
$('.tabber-on-left').addClass('media').find('ul.tabber').addClass('pull-left').siblings('.tab-content').addClass('media-body');
$('.tabber-on-right').addClass('media').find('ul.tabber').addClass('pull-right').siblings('.tab-content').addClass('media-body');

/* ==============================================================
/*	Accordions
/* ============================================================== */

$('.accordion-wrapper p.toggler').click(function(){
	var toggler = $(this);
	var toggler_parent = $(this).parent();
	var to_close = $(toggler).parents('.accordion-wrapper').children('.accordion-single').not(toggler_parent);
	
	$(to_close).each(function(){
		$(this).find('p.toggler .toggle-icon').html('<i class="fa fa-plus-square">');
		$(this).find('.toggle-content').slideUp('200',function(){
			$(this).parent().removeClass('active');
		});
	});
	
	
	
	if($(toggler_parent).hasClass('active')) { 
		$(toggler_parent).find('p.toggler .toggle-icon').html('<i class="fa fa-plus-square">');
		$(toggler).siblings('.toggle-content').slideUp(200,function(){ 
			$(toggler_parent).removeClass('active'); 
		}); 
	}
	else {
		$(toggler_parent).find('p.toggler .toggle-icon').html('<i class="fa fa-minus-square">');
		$(this).siblings('.toggle-content').slideDown('200',function(){
			$(this).parent().addClass('active');
		});
	}
	
});

/* ==============================================================
/*	AJAX Live Search
/* ============================================================== */

$('.form-search input[name=s]').keyup(function(event) {
if (ptypes!=null) {
	var ignoredKeys = new Array(32, 16, 17, 18, 91, 93, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121);
	var keyCode = event.keyCode;
    var value = $(this).val();
    var length = value.length;
    var resultsWrapper = $(this).parents('.form-search').find('.ajax-results-wrapper');
    var resultsDiv = $(this).parents('.form-search').find('.ajax-results');
    
    
    if(length>=3 && $.inArray(keyCode, ignoredKeys) == -1) {
        $.post(ajaxurl, { action: 'ajax_search', s: value, ptypes: ptypes, nor: nor }, function(output) { //ptypes and nor are obtained from the global variable in wp-head, coded in functions.php
            $(resultsDiv).html(output);
            $(resultsWrapper).slideDown(250);
            //$(resultsWrapper).css({'height':$(resultsDiv).height(),'display':'block'});
            
        });
    } else {
        $(resultsDiv).empty();
        $(resultsWrapper).slideUp(150);
        //$(resultsWrapper).css({'height':$(resultsDiv).height(),'display':'none'});
    }
    
}
});
	
	
/* ==============================================================
/*	Advanced search
/* ============================================================== */

$('#advsearchform').submit(function(e){
	e.preventDefault();
	var keywords = $('#advsearch_keywords').val();
	var exact_phrase = $('#advsearch_exact').val();
	var match = $('#advsearch_match').val();
	var posttypes = new Array();
	var temp = $('.advsearch_ptypes:checked').map(function () { return this.value; }).get()+''; 
	posttypes = temp.split(',');
	var author = $('#advsearch_author').val();
	var find_from = $('#advsearch_from').val();
	var newer_older = $('#advsearch_newerolder').val();
	var date_sort = $('#advsearch_sort').val();
    if(keywords!="" || exact_phrase!="") {
        $.post(ajaxurl, { action: 'verve_advanced_search', s: keywords, exact_phrase: exact_phrase, match: match, posttypes: posttypes, find_from: find_from, newer_older: newer_older, date_sort: date_sort }, function(adv_search_results) { 
            $('#adv-search-results').html(adv_search_results);
        });
    } else {
        $('#adv-search-results').html('Enter some keywords');
    }
});

/* ==============================================================
/*	Smooth scrolls
/* ============================================================== */

$('.scrollUp').click(function(){
	$("html, body").animate({ scrollTop: 0 }, 1200, 'easeInOutExpo');
	return false;
});

$('#add-your-comment').click(function(){
	$('html, body').animate({ scrollTop: $("#respond").offset().top }, 1200, 'easeInOutExpo');
	return false;
});

/* ==============================================================
/*	Blog structure
/* ============================================================== */

/* Adding classes to tables in content */
$('article .post-content table').addClass('table table-bordered table-striped');

/* Adding classes to Comment submit */
$('#comment-form input#submit').addClass('btn btn-lg btn-primary').attr('tabindex','5');

/* ul.children comments padding */
$('#comment-section ul.children').css('padding-left',$('.comment-author-avatar img').width() + 25);

/* Maintain height of content and aside */
if (($('#content').outerHeight()<$('aside#sidebar').outerHeight()) && $(window).outerWidth() > 991) {
	$('#content').css('height',$('aside#sidebar').outerHeight());
}

/* ==============================================================
/*	Widgets
/* ============================================================== */

/* Add classes to default calendar widget */
$('.widget_calendar table').addClass('table table-striped table-bordered table-condensed');

/* ==================== ...closing document.ready() ======================= */

});

jQuery(window).load(function() {
	jQuery('.isotope > .row').isotope('reloadItems').isotope();
});