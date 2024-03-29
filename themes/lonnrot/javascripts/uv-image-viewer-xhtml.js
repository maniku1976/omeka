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
      var endings = ['a','n','sta','lta','lla','in','lle', 'emen'];


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
      var borg = ['Borgå','Borgm','Borgmestar','Borgmestarn','Borgmestare','Borgmestaren','Borgoensi','Borgmäst','Borgmestarilla','Borgesmän',
      'Borgmästarinnan','Borgmästaren', 'Borgmästaretjänsten','Borgen','Borgmestaria','Borgströmin','Borgesman', 
      'Borgströmska', 'Borgström', 'Borgströms','Borgo','Borgoossa','Borgoon','Borgå-stifts','Borgåstifts','Borgenärerna',
      'Borgarmålet','Borgmästar','Borgmästare','Borgo','Borgmästartjensten','Borgesmännen','Borgesmannen','Borgoënsis'];

      // key + ending, exceptions for 'Frans'
      var frans = ['Fransyska','Fransyskan','Fransyskt','Franskan','Franska','Fransos','Fransoser','Fransoserna','Fransk',
      'Fransmännen','Franskan','Franskt'];

      // Exceptions for certain strings appearing before or after key or key + ending forming certain strings
      if (key == 'Ilmoni' && endings.indexOf(ending) < 0) {
        str = key;
      } else if (key == 'Krank' && (key + ending == 'Kranke' || key + ending == 'Krankheiten' 
        || key + ending == 'Krankaa' || key + ending == 'Krankan' || st_before.indexOf('Robert') >= 0
        || key + ending == 'Krankh' || st_before.indexOf('Juhana') >= 0 || st_before.indexOf('Robert') >= 0
        || st_before.indexOf('maan') >= 0)) {
        str = '';
      } else if (key == 'Jurva' && st_before.indexOf('Petteri R.') >= 0) {
        str = '';
      } else if (key == 'Ingerman' && (key + ending == 'Ingermandland' || key + ending == 'Ingermandlands'
        || key + ending == 'Ingermandlandin') || key + ending == 'Ingermannaland') {
        str = '';
      } else if (key == 'Neovius' && (st_before.indexOf('Thure') >= 0 || st_before.indexOf('Adolf') >= 0)) {
        str = '';
      } else if (key == 'Wasenius' && (st_before.indexOf('Johan') >= 0 || st_before.indexOf('Valfrid') >= 0)) {
        str = '';
      } else if (key == 'Ilmoni' && key + ending == 'Ilmoniemen') {
        str = '';
      } else if (key == 'Dahl' && (key + ending == 'Dahlberg' || key + ending == 'Dahlbergi' || 
        key + ending == 'Dahlbergille' || key + ending == 'Dahlbergila' || key + ending == 'Dahlbergiltä' || 
        key + ending == 'Dahlbergin' || key + ending == 'Dahlström' || st_before.indexOf('Nummen') >= 0
        || key + ending == 'Dahlb' || key + ending == 'Dahlbergs' || key + ending == 'Dahlbergilla' 
        || key + ending == 'Dahlberginki')) {
        str = '';
      } else if (key == 'Rein' && (key + ending == 'Reine' || key + ending == 'Reinholm' || key + ending == 'Reinholms'
        || key + ending == 'Reinholm' || key + ending == 'Reinholmin' || key + ending == 'Reinhold' 
        || key + ending == 'Reinholdt' || st_before.indexOf('Emmi') >= 0 || key + ending == 'Reinh'
        || key + ending == 'Reinholdin' || st_before.indexOf('Th.') >= 0)) {
        str = '';
      } else if (key == 'Reinholm' && st_before.indexOf('Maalari') >= 0) {
        str = '';
      } else if (key == 'Porthan' && st_before.indexOf('Heders') >= 0) {
        str = '';
      } else if (key == 'Cajan' && (key + ending == 'Cajander' || key + ending == 'Cajana' 
        || key + ending == 'Cajanus' || key + ending == 'Cajanaresa' || key + ending == 'Cajanernas' 
        || key + ending == 'Cajaneborgs' || key + ending == 'Cajanensis')) {
        str = '';
      } else if (key == 'Asp' && (key + ending == 'Aspar' || key + ending == 'Aspelund' || st_before.indexOf('Hofrätts-Rådet') >= 0)) {
        str = '';
      } else if (key == 'Hedberg' && (key + ending == 'Hedbergiläisyyden' 
        || st_before.indexOf('J. V.') >= 0 || st_before.indexOf('prosten') >= 0
        || st_before.indexOf('Fredr.') >= 0 || st_before.indexOf('F. G.') >= 0)) {
        str = '';
      } else if (key == 'Borg' && (st_before.indexOf('Aron') >= 0 || st_before.indexOf('A.') >= 0
        || st_before.indexOf('Dompr.') >= 0 || st_before.indexOf('Wilhelm') >= 0 
        || st_before.indexOf('Pastor') >= 0 || st_before.indexOf('Lehtorin') >= 0
        || st_before.indexOf('E. W.') >= 0 || st_before.indexOf('L.') >= 0 || st_before.indexOf('Fredr.')
        || st_after.indexOf('Vicarius') >= 0 || borg.indexOf(key + ending) >= 0))  {
        str = '';
      } else if (key == 'Saima' && st_after.indexOf('Kanawa') >= 0) {
        str = '';
      } else if (key == 'Castrén' && (st_before.indexOf('Ulric') >= 0 || st_before.indexOf('Ulrik') >= 0
        || st_before.indexOf('Zacharias') >= 0 || st_before.indexOf('Zachris') >= 0 || st_before.indexOf('Länsman') >= 0
        || st_before.indexOf('Ledam. M.') >= 0 || st_before.indexOf('Alrik') >= 0 
        || st_before.indexOf('Eric') >= 0 || st_before.indexOf('Ja\u00C7ob') >= 0 
        || st_before.indexOf('Kaptén') >= 0 || st_before.indexOf('Vallesm') >= 0 
        || st_before.indexOf('systerson') >= 0 || st_before.indexOf('Kyrkoherde') >= 0
        || st_before.indexOf('Juljus') >= 0 || st_before.indexOf('KronoLänsmannen') >= 0 
        || st_before.indexOf('Alrik') >= 0 || st_before.indexOf('HäradsHöfd.') >= 0
        || st_before.indexOf('Kaptén') >= 0)) {
        str = '';
      } else if (key == 'Roos' && (st_before.indexOf('A. J.') >= 0 || st_before.indexOf('Höfdingan') >= 0
        || st_before.indexOf('Hhfd.') >= 0 || st_before.indexOf('Hhofd') >= 0 || st_before.indexOf('Ida') >= 0
        || key + ending == 'Roosens' || st_before.indexOf('Ivar') >= 0 || st_before.indexOf('A. B.') >= 0
        || st_before.indexOf('Hkdf') >= 0)) {
        str = '';
      } else if (key == 'Ståhlberg' && (st_before.indexOf('F. A.') >= 0 || st_before.indexOf('Länsman') >= 0
        || st_before.indexOf('Kronof') >= 0 || st_before.indexOf('J. G.') >= 0 || st_before.indexOf('C. B.') >= 0
        || st_before.indexOf('C.B.') >= 0 || st_before.indexOf('Benjamin') >= 0)) {
        str = '';
      } else if (key == 'Ticklén' && (st_before.indexOf('Pehr') >= 0 || st_before.indexOf('Prosten') >= 0
        || st_before.indexOf('G.') >= 0 || st_before.indexOf('Erik') >= 0 || st_before.indexOf('Sanmarck') >= 0)) {
        str = '';
      } else if (key == 'Collan' && (st_before.indexOf('Claës') >= 0 || st_before.indexOf('Studerande') >= 0
        || st_before.indexOf('Doktor') >= 0 || st_before.indexOf('Apotekari A.') >= 0 || key + ending == 'Collander'
        || st_before.indexOf('Karl') >= 0)) {
        str = '';
      } else if (key == 'Europaeus' && st_before.indexOf('Prosten') >= 0) {
        str = '';
      } else if (key == 'Lindfors' && (st_before.indexOf('Rector') >= 0 
        || st_before.indexOf('Conrector') >= 0 || st_before.indexOf('Phil') >= 0
        || st_before.indexOf('seminaristen') >= 0 || st_before.indexOf('August') >= 0
        || st_before.indexOf('Kaarle') >= 0 || st_before.indexOf('Evert E.') >= 0
        || st_before.indexOf('Fru') >= 0)) {
        str = '';
      } else if (key == 'Elfving' && st_before.indexOf('Axel') >= 0) {
        str = '';
      } else if (key == 'Korhonen' && st_before.indexOf('Elsa') >= 0) {
        str = '';
      } else if (key == 'Flander' && (st_before.indexOf('Fr.') >= 0 || st_before.indexOf('Stud.') >= 0 
      || st_before.indexOf('Borgm') >= 0 || key + ending == 'Flandern')) {
        str = '';
      } else if (key == 'Runeberg' && st_before.indexOf('Fru') >= 0) {
        str = '';
      } else if (key == 'Ida' && (st_after.indexOf('Roos') >= 0 || key + ending == 'Idag')) {
        str = '';
      } else if (key == 'Maria' && (st_after.indexOf('Holm') >= 0 || st_after.indexOf('Nissinen') >= 0
        || st_after.indexOf('Tervonen') >= 0 || st_after.indexOf('Piponius') >= 0 || st_after.indexOf('Pipponius') >= 0
        || st_after.indexOf('Magdalenae') >= 0 || st_before.indexOf('Diakonissan') >= 0 || st_before.indexOf('Elfving, ') >= 0
        || st_before.indexOf('J.') >= 0 || st_after.indexOf('Johanin') >= 0 || st_after.indexOf('Sparf') >= 0
        || st_after.indexOf('seuraa') >= 0 || key + ending == 'Marianpäivän' || st_before.indexOf('diakonissan') >= 0
        || st_before.indexOf('Jungfru') >= 0 || st_after.indexOf('Magdalenae') >= 0 || st_after.indexOf('Ulrica') >= 0
        || st_before.indexOf('kusin,') >= 0 || st_before.indexOf('Storfurstinnan') >= 0
        || st_before.indexOf('(Svägerska?)') >= 0 || st_before.indexOf('Anna') >= 0)) {
        str = '';
      } else if (key == 'Elina' && (st_after.indexOf('Neitsy') >= 0 || st_after.indexOf('neion') >= 0 
        || st_after.indexOf('neito') >= 0 || key + ending == 'Elinaikuinen')) {
        str = '';
      } else if (key == 'Frans' && (frans.includes(key + ending) || st_after.indexOf('J. Rabbe') >= 0 || st_after.indexOf('Johan') >= 0
        || st_after.indexOf('och Atte') >= 0 || st_after.indexOf('Munkin') >= 0 || st_after.indexOf('Muck') >= 0
        || st_after.indexOf('Becker') >= 0 || st_after.indexOf('Be\u00C7ker') >= 0 || st_after.indexOf('von Becker') >= 0 
        || st_after.indexOf('Wilhelm') > 0 || st_after.indexOf('Schauman') >= 0)) {
        str = '';
      } else if (key == 'Selin' && (st_before.indexOf('Carin') >= 0
        || st_before.indexOf('frouva') >= 0
        || key + ending == 'Selinsfastrar')) {
        str = '';
      } else if (key == 'Lagi' && (st_before.indexOf('Prostinnan') >= 0 || st_before.indexOf('Prosten') >= 0
        || st_before.indexOf('Wilh.') >= 0 || st_before.indexOf('Doctorinnan') >= 0)) {
        str = '';
      } else if (key == 'Mellin' && (st_before.indexOf('Fru') >= 0 || st_before.indexOf('Mamsell') >= 0 
        || st_before.indexOf('Robert') >= 0 || st_before.indexOf('Rob.') >= 0 || st_before.indexOf('R.') >= 0)) {
        str = '';
      } else if (key == 'Friman' && st_before.indexOf('Skolläraren') >= 0) {
        str = '';
      } else if (key == 'Thauvon' && (st_before.indexOf('Fru') >= 0 || st_before.indexOf('Augusta') >= 0 || st_before.indexOf('Augusta Sophia') >= 0)) {
        str = '';
      } else if (key == 'Porthan' && key + ending == 'Porthansmonumentet') {
        str = '';
      } else if (key == 'Morgonbladet' && st_before.indexOf('Helsingfors') >= 0) {
        str = '';
      } else if (key == 'Tähti' && (st_after.indexOf('taivahi') >= 0 || key + ending == 'Tähtimies')) {
        str = '';
      } else if (key == 'Lindström' && (key + ending == 'Lindströmar' || st_before.indexOf('Eva') >= 0 
      || st_before.indexOf('Alex.') >= 0 || key + ending == 'Lindströmskan')) {
        str = '';
      } else if (key == 'Grot' && key + ending == 'Grotii') {
        str = '';
      } else if (key == 'Haartman' && st_before.indexOf('Wallenius och') >= 0) {
        str = '';
      } else if (key == 'Keckmann' && st_before.indexOf('Samuel') >= 0) {
        str = '';
      } else if (key == 'Johansson' && (st_before.indexOf('J. V.') >= 0 
        || st_before.indexOf('A:W: ') >= 0 || st_before.indexOf('Josua') >= 0)) {
        str = '';
      } else if (key == 'Asp' && (key + ending == 'Aspelin' || key + ending == 'Aspelins')) {
        str = '';
      } else if (key == 'Ehrström' && st_before.indexOf('Prof') >= 0) {
        str = '';
      } else if (key == 'Sirén' && st_before.indexOf('Olga') >= 0) {
        str = '';
      } else if (key == 'Laurell' && (st_before.indexOf('Evert') >= 0 || st_before.indexOf('Gustaf') >= 0)) {
        str = '';
      } else if (key == 'Planting' && st_before.indexOf('Mi\u00C7hel') >= 0) {
        str = '';
      } else if (key == 'Strömborg' && st_before.indexOf('G. J.') >= 0) {
        str = '';
      } else if (key == 'Strömberg' && st_before.indexOf('vikarien') >= 0) {
        str = '';
      } else if (key == 'Avellan' && st_before.indexOf('Edvin') >= 0) {
        str = '';
      } else if (key == 'Karsten' && st_before.indexOf('Major') >= 0) {
        str = '';
      } else if (key == 'Lille' && key + ending == 'Lilleputs') {
        str = '';
      } else if (key == 'Bark' && key + ending == 'Barkerna') {
        str = '';
      } else if (key == 'Kanava' && (key + ending == 'Kanavat' || st_before.indexOf('Marinskaja') >= 0)) {
        str = '';
      } else if (key == 'Fabritius' && (st_before.indexOf('apteekari') >= 0 || st_after.indexOf('mamselli') >= 0)) {
        str = '';
      } else {
        str = key + ending;
      }

      // insert popup
      $('.textFrame') 
      .html($('.textFrame')
      .html()
      .replace(str, '<span class="comm tooltip bt" href="#">' + str + '<span>' + value + '</span></span>'));
    }

  });

  // Adjust position for popups close to container edges
  $('.textFrame').find('span.tooltip').each(function() {
    $(this).hover(function() {
      if ($(this).position().left >= 200 && $(this).position().left <= 230) {
        $(this).find('span').css('left','-30px');
      } else if ($(this).position().left > 230) {
        $(this).find('span').css('left','-200px');
      }

      if ($(this).position().top > 580) {
        $(this).find('span').css('top','-100px');
      }
    });
  });

  // Variable page count, initialized to 1
  var i = 0;

  // Arrow back disabled at start
  $('#btPrevXML').addClass('disabled-arrow');

  // Browse backwards, mouse click
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

  // Browse backwards, enter
  $('#btPrevXML').keypress(function(e) {
    if (i == 0) {
      $('#btPrevXML').addClass('disabled-arrow');
      return false;
    } else {
      $('#btPrevXML').removeClass('disabled-arrow');
      $('#btNextXML').removeClass('disabled-arrow');
    }

    if (e.which == 13) {
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
    }
  });

  // Browse forward, mouse click
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

  // browse forward, enter
  $('#btNextXML').keypress(function(e) {

    if (i == $('#exhibit3b').find('.pb').length-1) {
      $('#btNextXML').addClass('disabled-arrow');
      return false;
    } else {
      $('#btNextXML').removeClass('disabled-arrow');
      $('#btPrevXML').removeClass('disabled-arrow');
    }

    if (e.which == 13) {
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

    }
  });

});
