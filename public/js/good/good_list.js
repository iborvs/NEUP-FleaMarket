$(document).ready(function(){
    switch ($("#nm").prop("className")){
        case "p":
            $("#nm").text('按价格从低到高');break;
        case "pd":
            $("#nm").text("按价格从高到低");break;
        case "c":
            $("#nm").text("按库存从少到多");break;
        case "cd":
            $("#nm").text("按库存从多到少");break;
    }
});

$(".good").mouseenter(function(){
    $(this).stop().animate({opacity:'0.5'},"fast");
});
$(".good").mouseleave(function(){
    $(".good").stop().animate({opacity:'1.0'},"fast");
});

$("#ppx").click(function(){
    $(this).attr("href","/good/?sort=pd");
})
function sq(px,sx){
    $.get("/good/",function(data,status){
        alert("Data: " + data + "nStatus: " + status);
    });
}
function setprice(){
    var hr="/good/?";
    if($("#priceSet1").val()!=""){
        hr=hr+"start_price="+$("#priceSet1").val();
    }
    if($("#priceSet2").val()!=""){
        if($("#priceSet1").val()!=""){
            hr=hr+"&";
        }
        hr=hr+"end_price="+$("#priceSet2").val();
    }
    location.href=hr;
}
function setc(ha){
    var hr="/good/?";
    if($("#priceSet1").val()!=""){
        hr=hr+"&start_price="+$("#priceSet1").val();
    }
    if($("#priceSet2").val()!=""){
        hr=hr+"&end_price="+$("#priceSet2").val();
    }
    if($("#pricec").val()!=""){
        hr=hr+"&start_count="+$("#pricec").val();
    }
    if(ha!="a"){
        hr=hr+"&sort="+ha;
    }
    else if($("#nm").prop("className")!=""){
        hr=hr+"&sort="+$("#nm").prop("className");
    }
    if($("#searchq").val()!=""){
        hr=hr+"&query="+$("#searchq").val();
    }
    location.href=hr;
}