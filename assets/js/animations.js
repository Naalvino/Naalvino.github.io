function showprojects(){
    $("#projects_container").css("display","inherit");
    $("#projects_container").addClass("animated slideInLeft");
    setTimeout(function(){
        $("#projects_container").removeClass("animated slideInLeft");
    },800);
}
function closeprojects(){
    $("#projects_container").addClass("animated slideOutLeft");
    setTimeout(function(){
        $("#projects_container").removeClass("animated slideOutLeft");
        $("#projects_container").css("display","none");
    },800);
}
function showgallery(){
    $("#gallery_container").css("display","inherit");
    $("#gallery_container").addClass("animated slideInRight");
    setTimeout(function(){
        $("#gallery_container").removeClass("animated slideInRight");
    },800);
}
function closegallery(){
    $("#gallery_container").addClass("animated slideOutRight");
    setTimeout(function(){
        $("#gallery_container").removeClass("animated slideOutRight");
        $("#gallery_container").css("display","none");
    },800);
}
function showcontact(){
    $("#contact_container").css("display","inherit");
    $("#contact_container").addClass("animated slideInUp");
    setTimeout(function(){
        $("#contact_container").removeClass("animated slideInUp");
    },800);
}
function closecontact(){
    $("#contact_container").addClass("animated slideOutDown");
    setTimeout(function(){
        $("#contact_container").removeClass("animated slideOutDown");
        $("#contact_container").css("display","none");
    },800);
}

function showabout(){
    $("#about_container").css("display","inherit");
    $("#about_container").addClass("animated slideInDown");
    setTimeout(function(){
        $("#about_container").removeClass("animated slideInDown");
    },800);
}
function closeabout(){
    $("#about_container").addClass("animated slideOutUp");
    setTimeout(function(){
        $("#about_container").removeClass("animated slideOutUp");
        $("#about_container").css("display","none");
    },800);
}

setTimeout(function(){
    $("#loading").addClass("animated fadeOut");
    setTimeout(function(){
      $("#loading").removeClass("animated fadeOut");
      $("#loading").css("display","none");
      $("#box").css("display","none");
      $("#projects").removeClass("animated fadeIn");
      $("#about").removeClass("animated fadeIn");
      $("#contact").removeClass("animated fadeIn");
      $("#gallery").removeClass("animated fadeIn");
    },1000);
},1500);
