<?php
include("../../helplib.php");
echo help_header("N�pov�da: Nastaven� protokolov�n�");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
<tr class="fieldnameback">
	<td class="tngshadow">
		<p style="float:right; text-align:right" class="smaller menu">
			<a href="http://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
			<a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br />
			<a href="pedconfig_help.php" class="lightlink">&laquo; N�pov�da: Nastaven� sch�mat</a> &nbsp; | &nbsp;
			<a href="importconfig_help.php" class="lightlink">N�pov�da: Nastaven� importu &raquo;</a>
		</p>
		<span class="largeheader">N�pov�da: Nastaven� protokolov�n�</span>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
		<div id="google_translate_element" style="float:right"></div><script type="text/javascript">
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
		}
		</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
		<span class="optionhead">N�zev souboru protokolu (Ve�ejn� oblast)</span>
		<p>Soubor protokolu je soubor, kam jsou zaznamen�v�ny akce n�v�t�vn�k�. P�vodn� n�zev "genlog.txt" byste nem�li m�nit.</p>

		<span class="optionhead">N�zev souboru protokolu (Administrace)</span>
		<p>Soubor protokolu je soubor, kam jsou zaznamen�v�ny akce v administrativn� oblasti. P�vodn� n�zev "adminlog.txt" byste nem�li m�nit.</p>

		<p>Pozn.: Pro v�t�� zabezpe�en� va�ich soubor� protokolu za�krtn�te pol��ko ozna�en� "Ulo�it v konfigura�n� cest�", aby TNG ulo�il soubory protokolu v tomto um�st�n�. Soubory protokolu mus�te do tohoto um�st�n� p�esunout sami p�ed ulo�en�m t�to hodnoty nebo bezprost�edn� pot�.</p>

		<span class="optionhead">Maxim�ln� po�et ��dk� v protokolu (Ve�ejn� oblast)</span>
		<p>Maxim�ln� po�et ��dk� v protokolu ud�v�, kolik akc� t�kaj�c�ch se ve�ejn� oblasti by m�l protokol aktu�ln� uchov�vat.
		Pokud je toto ��slo p��li� vysok�, m��e doj�t ke sn�en� v�konu.</p>
    
    <span class="optionhead">Maxim�ln� po�et ��dk� v protokolu (Administrace)</span>
		<p>Maxim�ln� po�et ��dk� v protokolu ud�v�, kolik akc� t�kaj�c�ch administrace by m�l protokol aktu�ln� uchov�vat.
		Pokud je toto ��slo p��li� vysok�, m��e doj�t ke sn�en� v�konu.</p>

		<span class="optionhead">Vylou�it n�zvy hostitele</span>
		<p>P�ed proveden�m z�pisu do protokolu TNG tento seznam otestuje. Pokud hostitel n�v�t�vn�ka podl�haj� p��padn�mu z�pisu do protokolu
		je v seznamu, nebude proveden ��dn� z�pis. N�zvy hostitel� by m�ly b�t odd�leny ��rkami (bez mezer) a maj� obsahovat �pln�
		n�zev hostitele, IP adresu nebo ��sti obou. Nap�. "googlebot" bude blokovat "crawler4.googlebot.com".</p>

		<span class="optionhead">Vylou�it u�ivatelsk� jm�na</span>
		<p>P�ed proveden�m z�pisu do protokolu TNG tento seznam otestuje tak�. Pokud je p�ihl�en� u�ivatel
		v seznamu, nebude proveden ��dn� z�pis. U�ivatelsk� jm�na by m�la b�t odd�lena ��rkami (bez mezer).</p>

		<span class="optionhead">Zablokovat n�vrhy nebo nov� u�ivatelsk� registrace</span></p>

		<span class="optionhead">Adresa obsahuje</span>
		<p>Blokuje v�echny p��choz� n�vrhy nebo nov� u�ivatelsk� registrace, kde emailov� adresa odes�latele obsahuje n�jak� ze zapsan�ch slov nebo ��st� slov.
		V�ce slov odd�lujte ��rkou.</p>

		<span class="optionhead">Zpr�va obsahuje</span>
		<p>Blokuje v�echny p��choz� n�vrhy nebo nov� u�ivatelsk� registrace, kde t�lo zpr�vy obsahuje n�jak� ze zapsan�ch slov nebo ��st� slov.
		V�ce slov odd�lujte ��rkou.</p>
	</td>
</tr>

</table>
</body>
</html>
