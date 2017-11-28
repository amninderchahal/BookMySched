$(document).ready(function(){
    $('.sidebar-link').click(function(){
        $(this).toggleClass('w3-light-gray w3-blue-gray');
    });
    $('.msg-fadeout').delay(15000).slideUp();

    $(".navbar-toggle").click(function(){
        $(".sidebar-inner").slideToggle();
    });
    $(window).resize(function(){
        if($(window).width()>971)
           $(".sidebar-inner").slideDown();
    });
    $('.disabled').click(function(e){
        e.preventDefault();
    });
    $('[data-toggle="tooltip"]').tooltip();
});

function responsiveTable(){
  $('.w3-table').cardtable({myClass:'hidden-table'});
}

function validatePassword(){

  var password = document.getElementById("password"),
  confirm_password = document.getElementById("confirm_password");

  if(password.value.length <6) {
    password.setCustomValidity("Must be atleast 6 characters");
    return false;
  }
  else if(confirn_password.value.length <6) {
    confirm_password.setCustomValidity("Must be atleast 6 characters");
    return false;
  }
  else if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
    return false;
  }
  else {
    confirm_password.setCustomValidity('');
      return true;
  }
}
