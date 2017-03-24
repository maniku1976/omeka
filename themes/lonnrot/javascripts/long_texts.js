// Translations of long texts EN/FI/SE. Gettext isn't good for multi line/paragraph texts.
$(document).ready(function() {
  var language = $('#locale_lang_code option:selected').text();
  if (language == 'FI') {
    $('#primary #front-page')
    .html('Elias Lönnrotin (1802 - 1884) kirjeenvaihto avaa ainutlaatuisen näkymän 1800-luvun suomalaisen oppisivistyneistön \
    maailmaan. Suomalaisen Kirjallisuuden Seura julkaisee kirjeiden faksimilet ja transkriptiot, joita on täydennetty \
    kommentaarein. Aineisto on vapaasti käytettävissä ja muokattavissa xml-tiedostoina. Ensimmäisessä vaiheessa julkaistaan \
    Lönnrotin kirjoittamat noin 1800 yksityiskirjettä vaastanottaja kerrallaan. Kokoelma täydentyy jatkuvasti.');
  } else if (language == 'SE') {
    $('#primary #front-page').
    html('Elias Lönnrotin (1802 - 1884) kirjeenvaihto avaa ainutlaatuisen näkymän 1800-luvun suomalaisen oppisivistyneistön \
    maailmaan. Suomalaisen Kirjallisuuden Seura julkaisee kirjeiden faksimilet ja transkriptiot, joita on täydennetty \
    kommentaarein. Aineisto on vapaasti käytettävissä ja muokattavissa xml-tiedostoina. Ensimmäisessä vaiheessa julkaistaan \
    Lönnrotin kirjoittamat noin 1800 yksityiskirjettä vaastanottaja kerrallaan. Kokoelma täydentyy jatkuvasti.');
  } else if (language == 'EN') {
    $('#primary #front-page').
    html('Elias Lönnrotin (1802 - 1884) kirjeenvaihto avaa ainutlaatuisen näkymän 1800-luvun suomalaisen oppisivistyneistön \
    maailmaan. Suomalaisen Kirjallisuuden Seura julkaisee kirjeiden faksimilet ja transkriptiot, joita on täydennetty \
    kommentaarein. Aineisto on vapaasti käytettävissä ja muokattavissa xml-tiedostoina. Ensimmäisessä vaiheessa julkaistaan \
    Lönnrotin kirjoittamat noin 1800 yksityiskirjettä vaastanottaja kerrallaan. Kokoelma täydentyy jatkuvasti.');
  }
});
