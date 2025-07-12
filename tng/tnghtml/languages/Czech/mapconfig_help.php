<?php
include("../../helplib.php");
echo help_header("N�pov�da: Nastaven� mapy");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
<tr class="fieldnameback">
	<td class="tngshadow">
		<p style="float:right; text-align:right" class="smaller menu">
			<a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
			<a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br />
			<a href="importconfig_help.php" class="lightlink">&laquo; N�pov�da: Nastaven� importu dat</a> &nbsp; | &nbsp;
			<a href="templateconfig_help.php" class="lightlink">N�pov�da: Nastaven� �ablony &raquo;</a>
		</p>
		<span class="largeheader">N�pov�da: Nastaven� mapy</span>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
		<div id="google_translate_element" style="float:right"></div><script type="text/javascript">
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
		}
		</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

		<span class="optionhead">Kl�� k map�</span>
		<p>Chcete-li na sv�m webu pou��vat Mapy Google, mus�te od spole�nosti Google z�skat <strong>kl��</strong>. Chcete-li z�skat kl�� k map�, mus�te tak�
      m�t u�ivatelsk� ID Google. Pokud jste ji� zaregistrov�ni do slu�by Google Mail, m��ete pou��t toto u�ivatelsk� ID, jinak si budete muset vytvo�it nov�
      ��et Google. Na sv�m ��tu Google mus�te tak� povolit fakturaci. Jakmile budete m�t ��et s povolenou fakturac�, m��ete z�skat kl�� zde:
			<a href="https://console.cloud.google.com/" target="_blank">https://console.cloud.google.com/</a>.</p>

		<p>Jakmile tam budete, nejprve vyberte sv�j projekt. Z knihovny API (vyberte APIs &amp; Slu�by dole a pot� vlevo Knihovna) vyberte a povolte n�sleduj�c� t�i kl��e:
      Maps JavaScript API, Geocoding API a Places API. Maps JavaScript API je pot�eba k zobrazen� mapy Google n�v�t�vn�k�m va�eho webu,
      se zna�kou na r�zn�ch m�stech (m�sto narozen�, �mrt�, svatby atd.). Geocoding API se pou��v� v administr�torsk� sekci va�eho
      webov� str�nky pro p�i�azen� m�st k sou�adnic�m. V�ce <a href="https://tng.lythgoes.net/wiki/index.php/Google_Maps_-_Getting_Started">https://tng.lythgoes.net/wiki/index.php/Google_Maps_-_Getting_Started</a> pro v�ce informac�.</p>
      
		<p>Nakonec vygenerujte kl�� API kliknut�m na mo�nost P�ihla�ovac� �daje vlevo (tak� v ��sti API &amp; slu�by) a p�idejte adresu sv�ho webu jako �HTTP referrer�. 
       D�vejte pozor, abyste zapsali spr�vnou dom�nu.      
		</p>
          
		<p>Po z�sk�n� va�eho kl��e jej zkop�rujte a vlo�te do pole <strong>Kl�� k map�</strong> na str�nce Administrace > Nastaven� > Nastaven� map. Pokud se pozd�ji rozhodnete, �e mapy z Google Maps ji� pou��vat nechcete,
		kl�� z tohoto pole jednodu�e odstra�te a mapy a pole s mapami spojen� se v�m ji� nebudou zobrazovat. V�ce informac� o pr�ci s Google Maps najdete na TNG Wiki: 
    <a href="http://tng.lythgoes.net/wiki/index.php/Google_Maps_-_Getting_Started" target="_blank">http://tng.lythgoes.net/wiki/index.php/Google_Maps_-_Getting_Started</a>.</p>

		<span class="optionhead">Umo�nit mapy</span>
		<p>Chcete-li na va�ich str�nk�ch tam, kde jsou sou�adnice zem�pisn� ���ky a d�lky, zobrazit Google Maps, nastavte tuto volby na "Ano" (jin�mi slovy, i kdy� jste umo�nili
		tuto volby, mapu neuvid�te, pokud z�znamy va�ich m�st neobsahuj� sou�adnice zem�pisn� ���ky a d�lky (nebyly tzv. geok�dov�ny)).</p>

		<span class="optionhead">Typ mapy</span>
		<p>Vyberte, kter� typ mapy bude zobrazen nejd��ve: Ter�nn�, Cestovn� mapa, Satelitn� nebo Hybridn� (satelitn� mapa s ulicemi na povrchu).</p>

		<span class="optionhead">V�choz� zem�pisn� ���ka, V�choz� zem�pisn� d�lka</span>
		<p>Tyto sou�adnice ur�uj�, kde je v�choz� "st�ed" mapy u m�st, kter� je�t� nemaj� p�ipojeny zem�pisn� sou�adnice. �pendl�k bude zobrazen
		v tomto m�st�.</p>

		<span class="optionhead">V�choz� p�ibl�en�</span>
		<p>Toto ��slo ozna�uje, jak bl�zko nebo daleko bude p�i zah�jen� zobrazena v administr�torsk� oblasti nov� mapa. Ni��� ��slo znamen�, �e
		pohled bude d�l, zat�mco je-li ��slo vy���, pohled bude bl�. Pokud bude p�ibl�en� ulo�eno s ur�itou mapou, bude s touto mapou ulo�eno.</p>

		<span class="optionhead">P�ibl�en� m�sta</span>
		<p>Toto ��slo ozna�uje, jak bl�zko nebo daleko bude na Google Maps zobrazeno v administr�torsk� oblasti m�sto, po jeho vyhled�n� a nalezen�.</p>

		<span class="optionhead">Rozm�ry na str�nk�ch osob</span>
		<p>Zadejte rozm�ry (���ka mus� b�t v pixelech s ozna�en�m "px" na konci nebo v procentech; v��ka mus� b�t v pixelech s ozna�en�m "px" na konci) map
		zobrazen�ch na str�nk�ch osob. Nap�. chcete-li vytvo�it mapu vysokou 500 pixel�, nastavte <strong>v��ku</strong> na 500px. Chcete-li vytvo�it mapu, kter� m� obs�hnout 80 procent
		m�sta z p�id�len� oblasti, nastavte <strong>���ku</strong> na 80%.</p>

		<span class="optionhead">Rozm�ry na str�nk�ch n�hrobk�</span>
		<p>Zadejte rozm�ry (���ka mus� b�t v pixelech s ozna�en�m "px" na konci nebo v procentech; v��ka mus� b�t v pixelech s ozna�en�m "px" na konci) map
		zobrazen�ch na v�ech str�nk�ch, kter� jsou spojeny s n�hrobky.</p>

		<span class="optionhead">Rozm�ry na str�nk�ch administr�tora</span>
		<p>Zadejte rozm�ry (���ka mus� b�t v pixelech s ozna�en�m "px" na konci nebo v procentech; v��ka mus� b�t v pixelech s ozna�en�m "px" na konci) map
		zobrazen�ch na v�ech administr�torsk�ch str�nk�ch.</p>

		<span class="optionhead">Skr�t na za��tku mapy v administr�torsk� oblasti</span>
		<p>Chcete-li na str�nk�ch administr�tora skr�t mapy, dokud jste neklikli na tla��tko <span class="emphasis">Zobrazit/Skr�t</span>, vyberte zde volbu <span class="choice">Ano</span>.
		Chcete-li zobrazit mapy ihned po zobrazen� t�chto str�nek, vyberte volbu <span class="choice">Ne</span>.</p>

		<span class="optionhead">Skr�t na za��tku mapy ve ve�ejn� oblasti</span>
		<p>Chcete-li zpozdit zobrazen� mapy na str�nk�ch osoby, dokud je u�ivatel nezavol�, vyberte zde volbu <span class="choice">Ano</span>. Umo�n� to
		na��st str�nku rychleji. Mapa pak bude na�tena po kliknut� na tla��tko <span class="emphasis">Zobrazit mapu</span>.  
		Pokud vyberete volbu <span class="choice">Ne</span>, mapa na str�nce osoby bude na�tena hned po zobrazen� t�to str�nky.</p>

		<span class="optionhead">Slou�it duplicitn� �pendl�ky</span>
		<p>Pokud se na stejn�m m�st� objev� v�ce ud�lost�, nastaven�m t�to volby na <span class="emphasis">Ano</span> zabr�n�m vytvo�en� duplicitn�ch �pendl�k�
		u nejednozna�n�ch n�zv� m�st. Pozn.: Nastaven�m t�to volby na <span class="emphasis">Ne</span> zp�sob�, �e si duplicitn� �pendl�ky budou vz�jemn� p�ek�et.</p>

		<span class="optionhead">�pendl�ky �rovn� s�del: Ozna�en� a barvy</span>
		<p>Ka�d� m�sto se zem�pisn�mi sou�adnicemi m��e b�t spojeno s jedn�m ze �esti <strong>�rovn� s�dla</strong> (nap�. M�sto, M�sto/obec, Okres, atd.). Ozna�en� pro tyto �rovn�
		naleznete v souboru "alltext.php", kter� se nach�z� ve slo�ce p��slu�n�ho jazyka a p�epsat je m��ete ve va�em souboru "cust_text.php" (tak� v ka�d� jazykov� slo�ce).</p>

		<p>Barvy �pendl�k� ur�uj� hodnoty v souboru mapconfig.php. Chcete-li barvy �pendl�k� zm�nit, jd�te na str�nku TNG download
		a st�hn�te si �plnou paletu 216 r�zn�ch barev �pendl�k�, pot� otev�ete v textov�m editoru sv�j soubor mapconfig.php a zadejte ��slo
		nov� barvy �pendl�k� vedle prom�nn� odpov�daj�c� �rovni s�dla. Nakonec nahrajte soubor s novou barvou �pendl�ku do slo�ky <span class="emphasis">googlemaps</span> na va�ich str�nk�ch.</p>

	</td>
</tr>

</table>
</body>
</html>
