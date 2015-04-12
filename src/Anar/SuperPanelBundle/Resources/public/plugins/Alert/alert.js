/**
 * Created by OMID.N on 12/20/2014.
 */

var html = '<div id="dialog-overlay"></div>' +
           '<div id="dialog-box">' +
               '<div id="dialog-box-head"></div>' +
               '<div id="dialog-box-body"></div>' +
               '<div id="dialog-box-footer"></div>' +
           '</div>';

function CustomAlert(){
    this.render = function(dialog){
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialog_overlay = document.getElementById('dialog-overlay');
        var dialog_box = document.getElementById('dialog-box');
        dialog_overlay.style.display = "block";
        dialog_overlay.style.height = winH + "px";
        dialog_box.style.left = (winW/2) - (550 * .5) + "px";
        dialog_box.style.top = "100px";
        dialog_box.style.display = "block";
        document.getElementById('dialog-box-head').innerHTML = "پیام سیستم";
        document.getElementById('dialog-box-body').innerHTML = dialog;
        document.getElementById('dialog-box-footer').innerHTML = "<span class='R_butt_blue' onclick='Alert.ok()'>تایید</span>";
    };
    this.ok = function(){
        document.getElementById('dialog-box').style.display = "none";
        document.getElementById('dialog-overlay').style.display = "none";
    }
}

var bd = document.getElementsByTagName('body')[0];
bd.innerHTML += html;

var Alert = new CustomAlert();