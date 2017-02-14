// Translations of long texts EN/FI/SE. Gettext isn't good for multi line/paragraph texts.
$(document).ready(function() {
  var language = $('#locale_lang_code option:selected').text();
  if (language == 'FI') {
    $('#primary #front-page')
    .html('Lönnrot oli ammatiltaan lääkäri ja valmistui lääkäriksi Helsingin yliopistosta. Opinnot hän oli aloittanut \
    Turun Akatemiassa, mutta Turun palon jälkeen oppilaitos siirrettiin Helsinkiin. Ennen valmistumistaan hänet määrättiin \
    koleraepidemian aikaan kesken runonkeruumatkansa Helsinkiin hoitamaan potilaita Hietalahden lasarettiin. Sairaalassa \
    oli 40 vuodepaikkaa, jotka olivat kaikki täynnä. Myös Lönnrot sairastui epidemian aikana, mutta parani. Hän myös huomasi,\
    että herrasväestä hyvin harva sairastui koleraan. Ansioidensa vuoksi Lönnrot sai Venäjän keisarilta kunnianosoituksen, \
    briljanttisormuksen.<br><br>Lönnrotin elinaikana lääketiede kehittyi varsin huomattavasti. Akateemista opetusta ja \
    tutkimusta olivat siihen asti hallinneet spekulatiiviset opit. Opit saattoivat aiheuttaa toimenpiteitä, jotka nykytietämyksen\
    mukaan olivat joko merkityksettömiä tai vahingollisempia kuin itse hoidettava tauti. Vielä 1800-luvulla oli käytössä \
    antiikista peräisin oleva hoitokeino, suoneniskentä. Suoneniskennän ja kuppauksen tarkoituksina olivat poistaa likaiseksi \
    luultu veri. Ruumiita puhdistettiin myös oksennusaineilla. Hypnotisoinnilla, homeopatialla ja luonnonfilosofialla oli vielä \
    ajoittain vahva asema, mutta Lönnrotin aikana menetelmiin suhtauduttiin kriittisemmin.');
  } else if (language == 'SE') {
    $('#primary #front-page').
    html('Elias Lönnrot var son till byskräddare Fredrik Johan Lönnrot och Ulrika Wahlberg och var det fjärde av sju barn. \
    Han växte upp i anspråkslösa förhållanden, men lärde sig läsa och skriva sitt finska modersmål redan som femåring. \
    Lönnrot lärde sig även svenska, inte minst för att det i den tidens Finland var ett måste för att skaffa sig en utbildning \
    av värde. Åren 1814-1815 gick han i Ekenäs pedagogi och fortsatte sedan 1816-18 vid katedralskolan i Åbo. Studierna avbröts\
    på grund av penningbrist. Istället tog han 1820 anställning som apotekarlärling.<br><br>\År 1822 började Lönnrot studera \
    filosofi och annan humaniora vid Kungliga Akademien i Åbo. Han visade redan då ett intresse för finländsk folkdiktning och\
    det blev temat för magistersavhandlingen De Väinämöine, priscorum Fennorum numine. Lönnrot skrev sig in som medicine \
    studerande år 1829 vid Alexandersuniversitet i Helsingfors och blev medicine doktor i juni 1832. Hans doktorsavhandling \
    hette Finnarnes Magiska Medicin. Efter vissa omständigheter blev han 1833 utnämnd till landskapsläkare i Kajanaland.');
  } else if (language == 'EN') {
    $('#primary #front-page').
    html('Lönnrot got a job as district doctor of Kajaani in Eastern Finland during a time of famine and pestilence in the \
    district. The famine had prompted the previous doctor to resign, making it possible for a very young doctor to get such \
    a position. Several consecutive years of crop failure resulted in losses of population and livestock. In addition, lack \
    of a hospital further complicated Lönnrot\'s work. He was the sole doctor for 4,000 or so people, most of whom lived in \
    small rural communities scattered across the district. As physicians and novel drugs were expensive at the time, most \
    people relied on their village healers and locally available remedies. Lönnrot himself was keen on traditional remedies \
    and also administered them. However, he believed strongly that preventive measures such as good hygiene, breastfeeding \
    babies and vaccines were the most effective cures for most of his patients.');
  }
});
