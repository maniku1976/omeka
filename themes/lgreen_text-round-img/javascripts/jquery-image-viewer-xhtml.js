// Jquery viewer and transcription, functions

$(document).ready(function() {

  // Popup comments in transcription

  $.each(comments, function(key, value) { // Loop through comments.js as key/value pairs
    // Find first occurrence of key, get substring from start of key to following space
    var first = $('#exhibit2b').text().indexOf(key);
    if (first >= 0) {
      var last = first + key.length;
      var ext = $('#exhibit2b').text().indexOf(' ', last);
      var ending = $('#exhibit2b').text().substring(last, ext);

      // Key followed by specific characters
      if (ending.indexOf(",") >= 0) {
        ending = ending.substring(0, ending.indexOf(","));
      } else if (ending.indexOf(".") >= 0) {
        ending = ending.substring(0, ending.indexOf("."));
      } else if (ending.indexOf(";") >= 0) {
        ending = ending.substring(0, ending.indexOf(";"));
      } else if (ending.indexOf(":") >= 0) {
        ending = ending.substring(0, ending.indexOf(":"));
      }

      var str = key + ending;

      // Insert popup
      $('#exhibit2b')
      .html($('#exhibit2b')
      .html()
      .replace(str, '<a class="comm tooltip bt" href="#">' + str + '<span>' + value + '</span></a>'));
    }
  });


  // Hide all but first picture
  $('.pic').not('.pic:first').hide();

  // Arrow back disabled at the start
  $('#prevPic').addClass('disabled-arrow');

  // Needs different variables page and picture counts
  var i = 0;
  var j = 0;

  // Browse forward
  $('#nextPic').click(function() {

    if (i == $('#exhibit2b').find('.page').length-1) {
      $('#nextPic').addClass('disabled-arrow');
      return false;
    } else {
      $('#nextPic').removeClass('disabled-arrow');
      $('#prevPic').removeClass('disabled-arrow');
    }

    // Get current and next page/picture
    var currentPage = $('#exhibit2b').find('.page:eq(' + i + ')');
    var nextPage = currentPage.next();
    var currentPic = $('.pic:eq(' + j + ')');
    var nextPic = currentPic.next();

    if (nextPage) {
      // Show next page, hide others
      nextPage.show().siblings('.page').hide();
      var nextClass = nextPage.find('.pb').attr('class');
      var currentClass = currentPage.find('.pb').attr('class');
      // Show next picture, hide others, if next page is not for same picture as current
      if (nextClass.slice(0, -1) != currentClass.slice(0, -1)) {
        nextPic.show().siblings('.pic').hide();
        // increase picture count by 1
        j++;
      }
    }

    // increase page count by 1
    i++;

  });

  // Browse backwards
  $('#prevPic').click(function() {

    if (i == 0) {
      $('#prevPic').addClass('disabled-arrow')
      return false;
    } else {
      $('#prevPic').removeClass('disabled-arrow');
      $('#nextPic').removeClass('disabled-arrow');
    }

    // Get current and previous page
    var currentPage = $('#exhibit2b').find('.page:eq(' + i + ')');
    var prevPage = currentPage.prev();
    var currentPic = $('.pic:eq(' + j + ')');
    var prevPic = currentPic.prev();

    if (prevPage) {
      // Show previous page, hide others
      prevPage.show().siblings('.page').hide();
      var prevClass = prevPage.find('.pb').attr('class');
      var currentClass = currentPage.find('.pb').attr('class');
      // Show previous picture, hide others, if previous page is not for same picture
      // as current one
      if (prevClass.slice(0, -1) != currentClass.slice(0, -1)) {
        prevPic.show().siblings('.pic').hide();
        // Decrease picture count by 1
        j--;
      }
    }
    //Decrease page count by 1
    i--;
  });

  // Image zooming, calculations in

  // Initialize image scale to 1, location measurements to 0
  var scale = 1; // scale of image
  var xLast = 0; // last x location on screen
  var yLast = 0; // last y location on screen
  var xImage = 0; // last x location on image
  var yImage = 0; // last y location on image
  var xScreen, yScreen;

  // Mousewheel detection from jquery.mousewheel.min.js, bind to image display frame
  $('#picframe').bind('mousewheel', function(e, delta) {

    // Find current location on screen
    if ($('#picframe').hasClass('fullscreen')) {
      // Different x calculation if fullscreen on.
      xScreen = e.pageX - ($(this).width()/2) + ($('.pic').width()/2);
      yScreen = e.pageY - $(this).offset().top;
    } else {
      xScreen = e.pageX - $(this).offset().left;
      yScreen = e.pageY - $(this).offset().top;
    }

    // Find current location on image at current scale
    xImage = xImage + ((xScreen - xLast) / scale);
    yImage = yImage + ((yScreen - yLast) / scale);

    // Determine new scale
    if (delta > 0) {
      scale += 0.2;
    } else {
      scale -= 0.2;
    }
    scale = scale < 1 ? 1 : (scale > 20 ? 20 : scale);

    // Determine location on screen at new scale
    var xNew = (xScreen - xImage) / scale;
    var yNew = (yScreen - yImage) / scale;

    // Save current screen location
    xLast = xScreen;
    yLast = yScreen;

    // Redraw image
    $('.pic')
    .css('transform', 'scale(' + scale + ')' + 'translate(' + xNew + 'px, ' + yNew + 'px' + ')')
    .css('transform-origin', xImage + 'px ' + yImage + 'px')
    return false;

  });

  // Draggable image, from jquery-ui.js
  $('.pic').draggable();

  // Re-center image and reset image scale, otherwise calculations in zooming incorrect
  $('#origSize').click(function() {
    $('.pic').css({'transform':'', 'left': '', 'top': ''});
    scale = 1;
    xLast = 0;
    yLast = 0;
    xImage = 0;
    yImage = 0;
  });

  // Fullscreen view, hide fullscreen and metadata buttons; re-center image reset image
  // scale, otherwise calculations in zooming incorrect
  $('#fullScreen').click(function() {
    $('#picframe').addClass('fullscreen');
    $('#fullScreen').hide();
    $('#closeFull').show();
    $('#metadata').hide();
    $('#buttons').css('left', '93%');
    if (!$('#infopanel').is(':hidden')) {
      $('#infopanel').slideUp('fast');
    }
    $('.pic').css({'transform':'', 'left': '', 'top': ''});
    scale = 1;
    xLast = 0;
    yLast = 0;
    xImage = 0;
    yImage = 0;
  });

  // Exit fullscreen view; re-center image reset image
  // scale, otherwise calculations in zooming incorrect
  $('#closeFull').click(function() {
    $('#picframe').removeClass('fullscreen');
    $('#fullScreen').show();
    $('#closeFull').hide();
    $('#metadata').show();
    $('#buttons').css('left', '');
    $('.pic').css({'transform':'', 'left': '', 'top': ''});
    scale = 1;
    xLast = 0;
    yLast = 0;
    xImage = 0;
    yImage = 0;
  });

  // Show metadata menu
  $('#metadata').click(function() {
    if ($('#infopanel').is(':hidden')) {
      $('#infopanel').slideDown('fast');
    } else {
      $('#infopanel').slideUp('fast');
    }
  });

  // Block right-clicking on images to prevent download
  $('.pic').on('contextmenu', function() {
    return false;
  });

});
