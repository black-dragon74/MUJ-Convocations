// Handle the scroll top functionality
$(document).ready(function () {
    $('#scrolltop').hide();
});

$(window).scroll(function () {
    let scrollVal = $(window).scrollTop();
    if (scrollVal > 100){
        // Show scroll-top
        $('#scrolltop').fadeIn();
    }
    else {
        // Hide scroll-top
        $('#scrolltop').fadeOut();
    }
});

$('#scrolltop').on('click', function () {
   $('html, body').animate({
      scrollTop: 0
   }, 200);
});