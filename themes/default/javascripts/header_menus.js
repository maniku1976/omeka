$(document).ready(function() {

   /* Open/close extended search form */
   $('#searchbtn').click(function() {

     if ($('#ext-search').is(':hidden')) {
       $('#ext-search').slideDown('fast', function() {});
       $('select[title = "Hakutyyppi"]')
       .find('option[value="contains"]')
       .attr('selected', true)
       /*$('select[title = "Hakutyyppi"]').hide();*/
     } else {
       $('#ext-search').slideUp('fast', function() {});
     }
   });

   /* Open/close instruction links menu */
   $('#infobtn').click(function() {

     if ($('#instructions').is(':hidden')) {
       $('#instructions').slideDown('fast', function() {});
     } else {
       $('#instructions').slideUp('fast', function() {});
     }
   });

   /* Add placeholder and title attributes in Solr search input box */
   $('#query').attr('placeholder', 'Hae kirjeitä (katkaisu: *)');
   $('#query').attr('title', 'Huom. katkaisumerkki: * (esim. mehil*)');

});
