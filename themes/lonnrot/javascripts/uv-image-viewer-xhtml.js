// Functions in UniversalViewer + XHTML-translated TEI file

$(document).ready(function() {

  // loop through comments.js as key/value pairs
  $.each(comments, function(key, value) {
    // find first occurrence of key
    var first = $('.textFrame').text().indexOf(key);
    // check for occurrence of key in tooltip text
    var firstTooltip = $('.tooltip span').text().indexOf(key);
    // get substring from start of key to following space, excluding occurrences in tooltip texts
    if (first >= 0 && firstTooltip <= 0) {
      var last = first + key.length;
      var ext = $('.textFrame').text().indexOf(' ', last);
      var ending = $('.textFrame').text().substring(last, ext);

      var str = "";
      // key with secific ending or followed by specific characters
      var endings = ['a','n','sta','lta','lla','in','lle'];


      if (ending.indexOf(",") >= 0) {
        ending = ending.substring(0, ending.indexOf(","));
      } else if (ending.indexOf(".") >= 0) {
        ending = ending.substring(0, ending.indexOf("."));
      } else if (ending.indexOf(";") >= 0) {
        ending = ending.substring(0, ending.indexOf(";"));
      } else if (ending.indexOf(":") >= 0) {
        ending = ending.substring(0, ending.indexOf(":"));
      }

      // Exceptions for specific surnames: multiple people with same surname, surnames part of other strings
      var st_before = $('.textFrame').text().substring(first-15, first);
      var st_after = $('.textFrame').text().substring(first, first+15);

      // key + ending, exceptions for 'Borg'
      var borg = ['Borgå','Borgm','Borgmestar','Borgmestare','Borgmestaren','Borgoensi','Borgmäst','Borgmestarilla','Borgesmän'];

      // key + ending, exceptions for 'Frans'
      var frans = ['Fransyska','Fransyskt','Franska','Fransos','Fransoser','Fransoserna'];

      // Exceptions for certain strings appearing before or after key or key + ending forming certain strings
      if (key == 'Ilmoni' && !endings.includes(ending)) {
        str = key;
      } else if (key == 'Rein' && (key + ending == 'Reine' || key + ending == 'Reinholm' || key + ending == 'Reinholms')) {
        str = '';
      } else if (key == 'Cajan' && key + ending == 'Cajander') {
        str = '';
      } else if (key == 'Hedberg' && key + ending == 'Hedbergiläisyyden') {
        str = '';
      } else if (key == 'Borg' && (st_before.indexOf('Aron') >= 0 || st_before.indexOf('A.') >= 0
        || st_before.indexOf('Dompr.') >= 0 || st_after.indexOf('Aron') >= 0 || borg.includes(key + ending)))  {
        str = '';
      } else if (key == 'Castrén' && (st_before.indexOf('Ulric') >= 0 || st_before.indexOf('Ulrik') >= 0
        || st_before.indexOf('Zacharias') >= 0 || st_before.indexOf('Zachris') >= 0 || st_before.indexOf('Länsman') >= 0
        || st_before.indexOf('Ledam. M.') >= 0)) {
        str = '';
      } else if (key == 'Roos' && (st_before.indexOf('A. J.') >= 0 || st_before.indexOf('Höfdingan') >= 0
        || st_before.indexOf('Hhfd.') >= 0 || st_before.indexOf('Hhofd') >= 0 || st_before.indexOf('Ida') >= 0)) {
        str = '';
      } else if (key == 'Ståhlberg' && (st_before.indexOf('F. A.') >= 0 || st_before.indexOf('Länsman') >= 0
        || st_before.indexOf('Kronof') >= 0 || st_before.indexOf('J. G.') >= 0)) {
        str = '';
      } else if (key == 'Ticklén' && (st_before.indexOf('Pehr') >= 0 || st_before.indexOf('Prosten') >= 0
        || st_before.indexOf('G.') >= 0)) {
        str = '';
      } else if (key == 'Collan' && (st_before.indexOf('Claës') >= 0 || st_before.indexOf('Studerande') >= 0
        || st_before.indexOf('Doktor') >= 0 || key + ending == 'Collander')) {
        str = '';
      } else if (key == 'Europaeus' && st_before.indexOf('Prosten') >= 0) {
        str = '';
      } else if (key == 'Lindfors' && (st_before.indexOf('Rector') >= 0 || st_before.indexOf('Conrector') >= 0 || st_before.indexOf('Phil') >= 0)) {
        str = '';
      } else if (key == 'Elfving' && st_before.indexOf('Axel') >= 0) {
        str = '';
      } else if (key == 'Korhonen' && st_before.indexOf('Elsa') >= 0) {
        str = '';
      } else if (key == 'Flander' && (st_before.indexOf('Fr.') >= 0 || st_before.indexOf('Stud.') >= 0 || st_before.indexOf('Borgm') >= 0)) {
        str = '';
      } else if (key == 'Runeberg' && st_before.indexOf('Fru') >= 0) {
        str = '';
      } else if (key == 'Ida' && st_after.indexOf('Roos') >= 0) {
        str = '';
      } else if (key == 'Maria' && (st_after.indexOf('Holm') >= 0 || st_after.indexOf('Nissinen') >= 0
        || st_after.indexOf('Tervonen') >= 0 || st_after.indexOf('Piponius') >= 0 || st_after.indexOf('Pipponius') >= 0
        || st_after.indexOf('Magdalenae') >= 0 || st_before.indexOf('Diakonissan') >= 0 || st_before.indexOf('Elfving, ') >= 0)) {
        str = '';
      } else if (key == 'Frans' && (frans.includes(key + ending) || st_after.indexOf('J. Rabbe') >= 0 || st_after.indexOf('Johan Rabbe') >= 0
        || st_after.indexOf('och Atte') >= 0 || st_after.indexOf('Munkin') >= 0 || st_after.indexOf('Muck') >= 0
        || st_after.indexOf('Becker') >= 0)) {
        str = '';
      } else if (key == 'Lagi' && st_before.indexOf('Prostinnan') >= 0) {
        str = '';
      } else if (key == 'Mellin' && (st_before.indexOf('Fru') >= 0 || st_before.indexOf('Mamsell') >= 0 || st_before.indexOf('Robert') >= 0)) {
        str = '';
      } else if (key == 'Friman' && st_before.indexOf('Skolläraren') >= 0) {
        str = '';
      } else if (key == 'Thauvon' && (st_before.indexOf('Fru') >= 0 || st_before.indexOf('Augusta') >= 0 || st_before.indexOf('Augusta Sophia') >= 0)) {
        str = '';
      } else if (key == 'Porthan' && key + ending == 'Porthansmonumentet') {
        str = '';
      } else if (key == 'Morgonbladet' && st_before.indexOf('Helsingfors') >= 0) {
        str = '';
      } else if (key == 'Tähti' && st_after.indexOf('taivahi') >= 0) {
        str = '';
      } else if (key == 'Lindström' && key + ending == 'Lindströmar') {
        str = '';
      } else {
        str = key + ending;
      }

      // insert popup
      $('.textFrame')
      .html($('.textFrame')
      .html()
      .replace(str, '<a class="comm tooltip bt" href="#">' + str + '</a><span>' + value + '</span>'));
    }

  });

  // Variable page count, initialized to 1
  var i = 0;

  // Arrow back disabled at start
  $('#btPrevXML').addClass('disabled-arrow');

  // Browse backwards
  $('#btPrevXML').click(function() {
    if (i == 0) {
      $('#btPrevXML').addClass('disabled-arrow');
      return false;
    } else {
      $('#btPrevXML').removeClass('disabled-arrow');
      $('#btNextXML').removeClass('disabled-arrow');
    }

    // get current and previous page; hide current, show previous, hide others
    var current = $('#exhibit3b').find('.page:eq(' + i + ')');
    var prev = current.prev();

    current.hide();
    if (prev) {
      prev.show().prevAll().hide();
    }

    // Find UniversalViewer back button
    var bt = $("#exhibit3a").find('iframe').contents().find("div.paging.btn.prev");
    var prevClass = prev.find('.pb').attr('class');
    var currentClass = current.find('.pb').attr('class');
    // Trigger back button if previous page is not for same picture as current one
    if (prevClass.slice(0, -1) != currentClass.slice(0, -1)) {
      bt.trigger("click");
    }
    // Decrease page count by 1
    i--;
  });

  // Browse forward
  $('#btNextXML').click(function() {

    if (i == $('#exhibit3b').find('.pb').length-1) {
      $('#btNextXML').addClass('disabled-arrow');
      return false;
    } else {
      $('#btNextXML').removeClass('disabled-arrow');
      $('#btPrevXML').removeClass('disabled-arrow');
    }

    // Find current and next page
    var current = $('#exhibit3b').find('.page:eq(' + i + ')');
    var next = current.next();

    // Find UniversalViewer's forward button
    var nextBt = $("#exhibit3a").find('iframe').contents().find("div.paging.btn.next");

    // Hide current page, show next page, hide other pages
    current.hide();
    if (next) {
      next.show().siblings('.page').hide();
    }

    // Trigger UniversalViewer's next button if next page is not for same image as current page
    var nextClass = next.find('.pb').attr('class');
    var currentClass = current.find('.pb').attr('class');
    if (typeof next != undefined && nextClass.slice(0, -1) != currentClass.slice(0, -1)) {
      nextBt.trigger('click');
    } else if (typeof next == undefined) {
      return false;
    }
    // Increase page count by 1
    i++;
  });

});
