var desktop = {
    widget : {
        refresh : function(){
            $.ajax({
                url : "status",
                dataType: 'json',
                error: function(XHR,message){
$.tinyNotice("AJAX client error","ارتباط با سرور جهت بروز رسانی اطلاعات ویجت ها دچار مشکل شده است! <br> message : "+message,"error",6000); 
                },
                success: function(response){
                    $(".sp-shower #desktop_NumOfRoles").text(response.blogsCount);
                    $(".sp-shower #desktop_NumOfUser").text(response.usersCount);
                }
            });
            
        }
    },
    view:{
        exchange : function(operation,mod){
            if(operation == "showContent"){
                if($("#sp-contentWrap").is(":visible")){
                    /*zamani ke yeki az tab ha dar hale namayesh ast*/
                    $("#sp-contentWrap #sp-contentContainer").empty();		
                }else{
                    /*zamani ke desktop dar hale namayesh ast*/
                    $("#sp-desktopWrap").fadeOut(300,function(){
                            $("#sp-contentWrap").delay(100).fadeIn(300);		
                    });	
                }
            }
            else if(operation == "showDesktop"){
                desktop.widget.refresh();
                $("#sp-contentWrap").fadeOut(300,function(){
                        $("#sp-contentWrap #sp-contentContainer").empty();
                        $("#sp-desktopWrap").fadeIn(300);		
                });	
            }
        }
    }
}


$(document).ready(function(e) {
    //first wedget value config
    desktop.widget.refresh();
    
    /*
    * clock
    * get timeStamp form serverTimestamp variable
    * and show dynamic clock 
    */
    var nowTimeStamp = serverTimestamp * 1000 - new Date().getTime();
    setInterval(function(){time()}, 1000);
    time();
    function time(){
        var date = new Date(new Date().getTime() + nowTimeStamp);
        $("#sp-clockWrap time").text(date.getHours()+":"+date.getMinutes()+":"+date.getSeconds());
    }

    /*
    * Calendar
    * show now date
    */
    var dateForCalendar = new Date(new Date().getTime() + nowTimeStamp);
    $("#sp-clockWrap span").text(dateForCalendar.toDateString());

    /*
    *last login
    *set last login labale
    */
    var lastLoginTimeData = new Date(lastLoginTime*1000);
    $("#sp-topBar time").text(lastLoginTimeData.toDateString()+" - " + lastLoginTimeData.getHours()+":"+lastLoginTimeData.getMinutes()+":"+lastLoginTimeData.getSeconds());

	
    /*
    *show content
    */
    $("#sp-tabBar span[data-URL]").click(function(e) {
            if($(this).attr("data-active")){
                    $(this).removeAttr("data-active");
                    desktop.view.exchange("showDesktop"); 
            }else{
                    $this = this;
                    $.ajax({
                        url:window[$($this).attr("data-URL")],
                        error: function(XHR,message){ 
$.tinyNotice("AJAX client error","در روند درخواست بررسی نام کاربری خطایی رخ داده است! <br> message : "+message,"error",6000); 
                        },
                        success: function(x){
                                $("#sp-tabBar span[data-active]").removeAttr("data-active");
                                $($this).attr("data-active","true");
                                desktop.view.exchange("showContent"); 
                                $("#sp-contentWrap #sp-contentContainer").html(x);
                        }				
                    });
            }
    });
	
    $("#sp-contencClose").click(function(e) {
        $("#sp-tabBar span[data-active]").removeAttr("data-active");
	desktop.view.exchange("showDesktop"); 
    });	
	
});

