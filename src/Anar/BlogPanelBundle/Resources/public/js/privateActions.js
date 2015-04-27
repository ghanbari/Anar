// JavaScript Document
$(document).ready(function(e) {

    //در حالت ریسپانسیو - دکمه استک  - باز و بسته کردن منو
	$("#rp-nowRoleShowerWrap").find("i.fa-bars").click(function() {
        $("#rp-menuWrap").find("ul").slideToggle(300);
    });
	
	$("#rp-toolbarWrap > ul > li").mouseenter(function() {
        $(this).find("ul").fadeIn(200);
    }).mouseleave(function() {
        $(this).find("ul").fadeOut(200);
    });
	/*
	* clock
	* get timeStamp form serverTimestamp variable
	* and show dynamic clock 
	*/
	var timeStampDifference = serverTimestamp - new Date().getTime();
	setInterval(function(){time()}, 1000);
	time();
	function time(){
		var date = new Date(new Date().getTime() + timeStampDifference);
		$("#rp-clockWrap").find("time").text(date.getHours()+":"+date.getMinutes()+":"+date.getSeconds());
	}
	
	/*
	* Calendar
	* show now date
	*/
	$("#rp-clockWrap").find("span").text(window["TodayDate"]);
	

	

	
	/*
	*last login
	*set last login labale
	*/
	//$(".rp-shower #desktop_NumOfRoles").text(window["desktop_NumOfRoles"]);
	//$(".rp-shower #desktop_NumOfUser").text(window["desktop_NumOfUser"]);
	
	
	
	/*
	*show content
	*/
	$("[role=appLinke]").click(function() {
		if($(this).attr("data-active")){
			$(this).removeAttr("data-active");
			exchangeView("showDesktop");
		}else{
			$this = this;
			$.ajax({
				url:window[$($this).attr("data-URL")],
                async:false,
				error: function(XHR,message){
                    $.tinyNotice("AJAX client error","در روند درخواست برنامه از سرور خطایی رخ داده است! <br> message : "+message,"error");
                },
				success: function(x){
					$("#rp-menuWrap").find("ul li[data-active]").removeAttr("data-active");
					$($this).attr("data-active","true");
					exchangeView("showContent");
					$("#rp-contentWrap").find("#rp-contentContainer").html(x);
				}
			});
		}
    });
	
	$("#rp-contencClose,#rp-desktopTab").click(function() {
		$("[data-active]").removeAttr("data-active");
		exchangeView("showDesktop"); 
    });
	
	/*
	* desktop and content switch
	*/
	function exchangeView(operation){
		if(operation == "showContent"){
			if($("#rp-contentWrap").is(":visible")){
				/*zamani ke yeki az tab ha dar hale namayesh ast*/
				$("#rp-contentWrap").find("#rp-contentContainer").empty();
			}else{
				/*zamani ke desktop dar hale namayesh ast*/
				$("#rp-desktopWrap").fadeOut(300,function(){
					$("#rp-contentWrap").delay(100).fadeIn(300);		
				});	
			}
		}
		else if(operation == "showDesktop"){
			$("#rp-contentWrap").fadeOut(300,function(){
				$("#rp-contentWrap").find("#rp-contentContainer").empty();
				$("#rp-desktopWrap").fadeIn(300);	
				$("#rp-desktopTab").attr("data-active","true");	
			});	
		}
	}
	
	
	
	
});