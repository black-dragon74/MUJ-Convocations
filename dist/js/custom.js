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

// Counts real fast. Recommended for larger values
$('.count-fast').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 500,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

// Count slowly. Don't use for large values
$('.count-slow').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 1000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});