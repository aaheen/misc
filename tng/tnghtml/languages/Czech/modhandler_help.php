<?php
include("../../helplib.php");
echo help_header("Help: N�pov�da m�d�");
?>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
<tr class="fieldnameback">
	<td class="tngshadow">
		<p style="float:right; text-align:right" class="smaller menu">
			<a href="https://tng.community" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
			<a href="https://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br />
			<a href="backuprestore_help.php" class="lightlink">&laquo; N�pov�da: Obslu�n� programy</a> &nbsp; | &nbsp;
			<a href="index_help.php" class="lightlink">N�pov�da: Za��n�me &raquo;</a>
		</p>
		<span class="largeheader">N�pov�da: Mana�er m�d�</span>
		<p class="smaller menu">
			<a href="#overview" class="lightlink">P�ehled</a> &nbsp; | &nbsp;
			<a href="#modlist" class="lightlink">Seznam m�d�</a> &nbsp; | &nbsp;
			<a href="#editor" class="lightlink">Editor m�d�</a> &nbsp; | &nbsp;
			<a href="#viewlog" class="lightlink">Zobrazit protokol</a> &nbsp; | &nbsp;
			<a href="#options" class="lightlink">Mo�nosti</a> &nbsp; | &nbsp;
			<a href="#analyzer" class="lightlink">Anal�za soubor� TNG</a> &nbsp; | &nbsp;
			<a href="#parser" class="lightlink">Tabulka parseru</a> &nbsp; | &nbsp;
      <a href="#recommended" class="lightlink">Doporu�en� aktualizace</a> &nbsp; | &nbsp;
			<a href="#credits" class="lightlink">Pod�kov�n�</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
		<div id="google_translate_element" style="float:right"></div><script type="text/javascript">
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
		}
		</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

		<a name="overview"><p class="subheadbold">P�ehled</p></a>

    <p>Pokud jste v TNG nov�, Mana�er m�d� je n�stroj pro administr�tory, kter� jim umo��uje instalovat, spravovat a odstra�ovat �pravy softwarov�ho bal��ku TNG, a to bu� sta�en�m a instalac� "m�d�" vytvo�en�ch ostatn�mi z TNGWiki, nebo vytvo�en�m vlastn�ch m�d� (a mo�n� tak� jejich sd�len�m).</p>    

    <p><b>M�d</b> je textov� soubor s p��ponou .cfg napsan� pomoc� editoru k�du. Obsahuje "p��kazy", kter� ��kaj� Mana�eru m�d� (MM), jak jeho instalac� upravit k�d v c�lov�ch souborech. M��e tak� kop�rovat soubory z doprovodn� podp�rn� slo�ky nebo dokonce vytv��et nov� soubory. -- podrobnosti najdete na str�nce<i><a href="https://tng.lythgoes.net/wiki/index.php/Mod_Manager" target="_blank"> TNGWiki Mod Manager (v angli�tin�)</a></i>.</p>

	</td>
</tr>

<tr class="databack">
	<td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="modlist"><p class="subheadbold">Seznam m�d�</p></a>

    <p>Na str�nce Administrace TNG zobraz� Mana�er m�d� (MM) seznam v�ech mod� ve slo�ce "mods". Tuto slo�ku m��ete p�ejmenovat v Nastaven� >> Z�kladn� nastaven� >> Um�st�n� a slo�ky.</p>    

    <p>Pokud jste je�t� ��dn� m�dy do slo�ky "mods" na va�em webu nena�etli, bude v�pis MM pr�zdn�. Ze str�nek TNGWiki si m��ete st�hnout stovky mod�. P�ich�zej� ve form� soubor� zip, kter� budete muset rozbalit a nahr�t do slo�ky "mods" na va�em webu pomoc� programu FTP, jako je FileZilla nebo WinSCP, kter� m��ete z�skat zdarma z internetu</p>

    <p>P�ed zobrazen�m mod� Mana�er m�d� zkontroluje ka�d� z nich, zda je ji� nainstalov�n nebo zda jej lze nainstalovat, a hled� chyby, kter� by br�nily jeho <i>instalaci</i> nebo <i>odstran�n�</i>. V�sledek se zobraz� ve v�pisu m�du ve sloupci <i>Stav</i>. Podrobnosti zobraz�te kliknut�m na ikonu �ipky nebo stavov� text a pot� na tla��tko <i>Podrobnosti</i>.</p>

    <p>V�echny uveden� mody maj� barevn� ozna�en� stav instalace:
      <ul>
        <li>
          <b>Lze instalovat</b> (b�l�) -- MM potvrdil, �e v�echny p��kazy v konfigura�n�m souboru m�du lze nainstalovat bez chyby.
        </li>
        <li>
          <b>Instalov�no </b> (zelen�) -- v�echny komponenty z konfigura�n�ho souboru m�du jsou nainstalov�ny.
        </li>
        <li>
          <b>��ste�n� instalov�no</b> (oran�ov�) -- n�kter� komponenty m�du jsou nainstalov�ny a n�kter� ne. To se m��e st�t, pokud obnov�te soubor TNG, kter� byl sou��st� instalace Modu.
        </li>
        <li>
          <b>Nelze nainstalovat</b> (�erven�) -- n�kter� konfigura�n� soubory m�du nelze nainstalovat, nap��klad proto, �e c�lov� soubor chyb�.
        </li>
      </ul>
    </p>

    <h3>Panel filtr�</h3>

    <p>V horn� ��sti seznamu mod� je panel filtr�, kter� omezuje zobrazen� na m�dy s vybran�m stavem nebo na <b>V�echny</b> m�dy nebo pouze ty, kter� <b>Vyberete</b>. V�b�r libovoln�ho filtru krom� <b>V�ech</b> zobraz� seznam se za�krt�vac�m pol��kem pro ka�d� zobrazen� m�d. Za�krtnut� jednoho nebo v�ce pol� umo��uje dal�� zpracov�n� vybran�ch m�d�.</p>

    <p>Pokud nap��klad vyfiltrujete mody, kter� jsou ve stavu <i>Lze instalovat</i> a pot� stisknete <i>Prov�st</i>, v� seznam bude obsahovat pouze ty m�dy, kter� jsou p�ipraveny k instalaci. Pomoc� za�krt�vac�ch pol��ek ve filtrovan�m seznamu m��ete vybrat jedno, n�kolik nebo v�echny z nich, pot� stisknout tla��tko Instalovat a m�dy se nainstaluj� hromadn�. V�imn�te si tla��tek <i>Vybrat v�e</i> a <i>Vy�istit v�e</i>, kter� v�m pomohou se za�krt�vac�mi pol��ky.</p>


<p><strong><font color="#990000">Upozorn�n�: D�vkov� operace byste m�li prov�d�t pouze v p��pad�, �e m�te dobrou z�lohu sv�ch webov�ch str�nek a m��ete ji rychle obnovit, pokud d�vkov� operace zp�sob� nefunk�nost va�eho webu. To se m��e snadno st�t, kdy� neodstran�te p�edchoz� verze mod�.</font></strong></p>

  <p><strong>Pozn�mka: P�ed upgradem TNG doporu�ujeme d�vkov� odinstalovat v�echny nainstalovan� m�dy a pot� d�vkov� vy�istit v�echny zb�vaj�c� ��ste�n� nainstalovan� m�dy.</strong></p>

   <p>Filtr <b>Vybrat</b> zobraz� v�echny m�dy a p�id� za�krt�vac� pol��ka. Vyberte jeden nebo v�ce z nich a stiskn�te tla��tko <i>Vybrat</i>. Mana�er m�d� zobraz� pouze vybran� m�dy. To m��e b�t u�ite�n� pro izolaci a testov�n� jednoho m�du bez zobrazen� nebo zpracov�n� ostatn�ch.</p>

  <p>Pokud za�krtnete pol��ko <b>Zamknout</b> u jak�hokoli filtrovan�ho z�znamu, z�stane filtrovan� i po obnoven� str�nky. Z�pis z�stane uzam�en, dokud jej nezru��te nebo nepou�ijete jin� filtr.</p>

    <h3>Sloupce seznamu m�d�</h3>

    <p>Prvn� t�i sloupce jsou samoz�ejm�. V z�vislosti na nastaven� zobrazen� Mana�era mod� na <i>kart� Mo�nosti</i> m��ete kliknout na N�zev m�du a m�d se zobraz� v tabulce parseru. Kliknut�m na N�zev konfigura�n�ho souboru zobraz�te na nov� kart� obsah konfigura�n�ho souboru m�du.</p>

    <p>Pokud sloupec <b>Wiki</b> obsahuje ikonu wiki (W), m��ete na ni kliknout a p�ej�t na �l�nek TNGWiki, kter� obsahuje popis a dal�� informace o m�du a tak� odkaz ke sta�en� m�du.</p>

    <p>P�t� sloupec je sloupec <b>Stav</b>. Zobrazuje barevn� odli�en� stav instalace m�du, jak je vysv�tleno v��e. Kliknut�m na text stavu se otev�e panel s popisem a p��slu�n�mi ovl�dac�mi prvky pro spr�vu m�du. Pokud je k dispozici tla��tko <i>Podrobnosti</i>, m��ete vid�t podrobn� seznam v�ech akc�, kter� byly nebo maj� b�t provedeny pro spr�vu m�du. Budou zobrazeny v�echny chyby.</p>

    <p>Pro pokro�il� u�ivatele jsou chybov� zpr�vy �asto doprov�zeny ��slem E. To odkazuje na ��slo ��dku v souboru MM, kde do�lo k chyb�. E-��sla v seznamu mod� jsou v�echna generov�na souborem classes/modlister.class.php. V bl�zkosti tohoto ��sla ��dku se �asto objev� koment�� vysv�tluj�c� povahu chyby a n�vrh mo�n�ch oprav.</p>

    <p>Pokud se nevyskytnou ��dn� chyby, jednodu�e stiskn�te p��slu�n� ovl�dac� prvek pro instalaci nebo odinstalov�n� (odstran�n�) m�du.</p>
    <p>N�kter� m�dy jsou ��ste�n� nainstalov�ny. Kdy� uvid�te tento stav, stiskn�te tla��tko <i>Vy�istit</i> a MM odstran� v�echny nainstalovan� sou��sti. Obvykle v�m z�stane �ist� m�d, kter� lze znovu pln� nainstalovat.</p>

  <p>Pokud m�d z�st�v� ��ste�n� nainstalov�n i po n�kolika pokusech o jeho vy�i�t�n�, m�li byste upozornit v�voj��e m�du. Chcete-li upozornit v�voj��e, klikn�te na ikonu Wiki (W) a p�ejd�te na str�nku TNGWiki a pot� klikn�te na odkaz <i>Mod Support</i>. Pokud neexistuje odkaz na podporu, <a href="#morehelp" >kliknut�m sem</a> z�sk�te dal�� pomoc.</p>


    <p>Posledn� sloupec, <i>Soubory</i>, obsahuje ikonu pro dal�� informace. Um�st�te na n�j kurzor a vyskakovac� okno v�m sd�l� v�echny soubory, kter� jsou nebo budou upraveny t�mto modem.</p>

    <a name="morehelp"><h3>Hled�n� dal�� pomoci</h3></a>

    <p>Pokud pot�ebujete dal�� pomoc, a� u� se Mana�erem m�d�, nebo s konkr�tn�m m�dem, m��ete prov�st jednu z n�sleduj�c�ch akc�:
    <ul>
      <li>Pot�ebujete-li pomoc s chybami nebo probl�my v <b>Mana�eru m�d�</b>
      <ul>
        <li>kontaktujte Rick Bisbee <a href="https://bisbeefamily.com/suggest.php?page=Mod Manager Issues" target="_blank">zde</a></li>
        <li>kontaktujte Ken Roy: <a href="mailto:ken@royandboucher.com?subject=Mod&nbsp;Manager&nbsp;Help">zde</a></li>
      </ul>
      <li>Pot�ebujete-li pomoc s n�jak�m m�dem</li>
        <ul>
          <li>kontaktujte v�voj��e modu ze str�nky TNGWiki spojen� s modem</li>
          <li>p�ejd�te na <a href="https://tng.community/index.php?/forums/" target="_blank"> TNG F�rum</a> a vyhledejte n�zev m�du. Pokud nenajdete nic u�ite�n�ho, m��ete si vytvo�it ��et a zanechat ��dost o pomoc na ostatn� u�ivatele.</li>
          <li>pou�ijte <b>Seznam e-mailov�ch diskuz�</b> a polo�te ot�zku. <a href="https://tng.lythgoes.net/wiki/index.php/TNG_Discussion_Forums" target="_blank">Za�n�te kliknut�m sem</a>.</li>
        </ul>
    </ul>
    </p>

	</td>
</tr>

<tr class="databack">
	<td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="editor"><p class="subheadbold">Editor m�d�</p></a>

    <p>Editor mod� (parametr�) je p��stupn� ze str�nky se seznamy mod�. Pokud m� nainstalovan� m�d upraviteln� parametry, uvid�te to ve sloupci Stav v seznamu mod� jako -- <i>Instalov�no [Mo�nosti]</i>. Chcete-li upravit parametry m�du, otev�ete panel Stav a klikn�te na tla��tko "Upravit mo�nosti". Editovateln� parametry jsou u�ivatelsk� mo�nosti m�du, nap��klad nastaven� barvy pro n�co.</p>

    <p>Chov�n� c�lov�ho souboru lze ��dit hodnotou parametr�. U�ivatel m�du m��e b�t nap��klad po��d�n, aby zadal po�et dn�, po kter� si p�eje uchov�vat ur�it� soubory protokolu.</p>

    <p>Po�et parametr�, kter� m��e m�d pou��t, nen� omezen. Ka�d� parametr m� v�choz� hodnotu zobrazenou na panelu popisu editoru m�du vlevo. Panel vpravo obsahuje oblast pro zm�nu hodnoty parametru. Jsou zde tak� dv� tla��tka, jedno pro aktualizaci c�lov�ho souboru s hodnotou ve vstupn�m poli a druh� pro resetov�n� parametru na v�choz� hodnotu.</p>

    <p><b>A� u� zad�v�te �et�zce nebo cel� ��sla, nen� nutn� je uzav�rat do uvozovek</b>. Editor m�d� to zjist� p�i aktualizaci hodnot.</p>
	</td>
</tr>

<tr class="databack">
	<td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="viewlog"><p class="subheadbold">Zobrazit protokol</p></a>
    <p>V z�vislosti na u�ivatelsk�ch preferenc�ch na kart� Mo�nosti se p�i chyb�ch generovan�ch b�hem instalace nebo odstran�n� m�du automaticky otev�e protokol chyb, tak�e administr�tor m��e vid�t, co se pokazilo. Jinak m��ete otev��t protokol a zobrazit podrobnosti o sv�ch operac�ch.</p>

    <p>��dek protokolu zobrazuje datum a �as, pokus o operaci, n�zev a verzi m�du, v�sledek a funkcion��e (spr�vce webu), kter� operaci provedl.
    </p>

    <p>Chcete-li zobrazit podrobnosti, klikn�te na ��dek protokolu. Otev�e se panel. Ka�d� p��kaz (za��naj�c� znakem %) zobrazuje ��slo ��dku v konfigura�n�m souboru m�du, kde byl p��kaz proveden, a v�sledek.
    </p>

    <p>Jak bylo uvedeno d��ve, chyby jsou doprov�zeny ��slem E odkazuj�c�m na ��slo ��dku v souboru TNG Mana�eru m�d�, kde k chyb� do�lo. Pokud k tomu do�lo b�hem pokusu o instalaci, E-��slo bude odkazovat na soubor classes/modinstaller.class.php. Kdy� tento soubor otev�ete s ��slem ��dku, �asto uvid�te pobl� koment�� vysv�tluj�c� chybu a navrhuj�c� �e�en�.</p>

    <p>N�pov�du k p��kaz�m a jejich pou�it� naleznete na TNGWiki. M��ete tak� kliknout na odkaz <b>Syntaxe m�d�</b> p��mo pod z�lo�kami Mana�era m�d� na v�t�in� obrazovek MM.</p>

</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="options"><p class="subheadbold">Mo�nosti</p></a>
    <p>Karta <strong>Mo�nosti</strong> otev�e obrazovku u�ivatelsk�ch preferenc� rozd�lenou do t�� ��st�.</p>
</p>V sekci <b>Protokol Mana�eru m�d�</b> m��ete zadat preference t�kaj�c� se souboru protokolu. Pod <i>N�zev souboru protokolu</i> m��ete ve skute�nosti zadat cestu k serveru, abyste um�stili sv�j protokol mimo oblast webov�ch str�nek, kter� je p��stupn� z prohl�e�e. V�choz� nastaven� je um�stit jej do ko�enov�ho adres��e TNG.</p>
    <p><b>Nastaven� zobrazen�</b> je m�sto, kde m��ete zobrazit nebo skr�t karty na str�nce Mana�eru m�d�.</p>
    <p><b>Jin�</b> v�m umo��uje rozhodnout, jak nakonfigurovat schopnost Mana�eru m�d� mazat mody a jejich podp�rn� slo�ky.</p>
    <p>
			<ul>
 				<li><strong>Povolit Vymazat vybran� pro ��ste�n� nainstalovan� m�dy</strong> - povol� zobrazen� tla��tka <strong>Vymazat</strong> v seznamu vybran�ch ��ste�n� nainstalovan�ch m�d�, pomoc� kter�ho lze vymazat v�ce m�d� najednou, jako nap�. vymaz�n� p�edchoz�ch verz� mod�, kter� nebyly vymaz�ny p�ed instalac� nov�j�� verz�. V�choz� volbou je <strong>Ne</strong>. Tuto volbu doporu�ujeme povolit pouze v p��pad�, �e pot�ebujete vymazat v�ce mod�, ani� byste museli odinstalovat aktu�ln� verze, abyste odstranili p�edchoz� verze m�du, kdy� jste zapomn�li odinstalovat a vymazat p�edchoz� verze modu p�ed instalac� nov� verze. Norm�ln� tuto volbu nechte nastavenou na Ne a volbu Ne obnovte po odstran�n� p�edchoz�ch verz� m�du, kter� se zobrazuj� jako ��ste�n� nainstalovan�.</li>
				<li><strong>Povolit Vymazat pro samostatn� nainstalovan� m�dy</strong> - umo�n� zapnut� volby zobrazen� tla��tka <strong>Vymazat</strong> vedle tla��tka Odinstalovat u samostatn� instalovan�ch m�d�, nap�. pro vymaz�n� p�edchoz� verze m�du, kter� nebyla vymaz�na p�ed instalac� nov�j�� verze. V�choz� volbou je <strong>Ne</strong>.  Doporu�ujeme, abyste tuto volbu povolili pouze v p��pad�, kdy je pot�eba vymazat p�edchoz� verzi m�du, bez nutnosti odinstalov�n� aktu�ln� verze za ��elem vymaz�n� p�edchoz� verze, a za norm�ln�ch okolnost� ponechte tuto volbu nastavenou na <strong>Ne</strong> a volbu Ne obnovte po odstran�n� p�edchoz�ch verz� m�du, kter� se zobrazuj� jako nainstalovan�.</li>
				<li><strong>Povolit smaz�n� podp�rn� slo�ky po vymaz�n� modu</strong> - umo�n� zapnut� volby smaz�n� slo�ky (slo�ek) p�idru�en�ch k m�du p�i maz�n� m�du. V�choz� volbou je <strong>Ne</strong>. Doporu�ujeme tuto mo�nost povolit jen tehdy, pokud ch�pete nebezpe�� vymaz�n� nezam��len�ch slo�ek. V���me, �e toto riziko je velmi mal�.</li>
		</ul>
  </p>
    <p>Nastavte p�edvolby, jak pot�ebujete, a stiskn�te tla��tko <i>Ulo�it</i>.</p>
</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="analyzer"><p class="subheadbold">Anal�za soubor� TNG</p></a>
    <p>Karta <strong>Anal�za soubor� TNG</strong> je voliteln� karta, kterou lze povolit na obrazovce Mo�nosti.</p>

<p>Toto je pokro�il� n�stroj, kter� v�m umo��uje vybrat soubor TNG a zobrazit, kter� m�dy m�n� nebo zm�n� tento konkr�tn� soubor TNG. Pokud se soubor neobjev� v seznamu vlevo, znamen� to, �e na n�j nec�l� ��dn� mody.</p>

<p>Kdy� vyberete soubor v lev�m sloupci, zobraz� se v prav�m sloupci s n�zvy a stavem mod�, kter� jej ovlivn�. Odtud m��ete kliknout na odkaz "Zobrazit �pravu" a zobrazit skute�nou zm�nu, kterou provede v c�lov�m souboru. <i>Nen� v rozsahu tohoto souboru n�pov�dy prob�rat p��kazy konfigurace m�d� a jak funguj�</i>. Informace naleznete na TNGWiki.</p>

<p>Pokud jste zvolili na kart� Mo�nosti, Nastaven� zobrazen�, "Zobrazit akce v analyz�toru mod�", uvid�te tak� odkazy, kter� v�m umo�n� nainstalovat, odinstalovat nebo smazat m�d p��mo z t�to obrazovky, v z�vislosti na aktu�ln�m stavu. </p>
<p>V horn� ��sti seznamu uvid�te panel filtr� s v�b�ry pro <i>V�echny mody</i>, <i>Pouze nainstalovan� mody</i> nebo <i>Instalovan�+��ste�n� nainstalovan� mody</i>. V�b�rem <i>Pouze nainstalovan� mody</i> a kliknut�m na <i>Odeslat dotaz</i> omez�te soubory v lev�m sloupci na ty, kter� jsou ovlivn�ny pouze aktu�ln� nainstalovan�mi mody.</p>

    <p>Tento n�stroj je u�ite�n� nejen pro nalezen� konflikt� mezi dv�ma m�dy, ale tak� pro zji�t�n�, kter� m�dy je t�eba po nahrazen� dan�ho c�lov�ho souboru vy�istit a znovu nainstalovat. </p>

    <p>The TNG Wiki provides additional information for the mod developers on <a href="https://tng.lythgoes.net/wiki/index.php?title=Using_the_Mod_Analyzer" target="_blank">Using the Mod Analyzer</a>.</p>
    <p>Dal�� informace o <a href="https://tng.lythgoes.net/wiki/index.php?title=Using_the_Mod_Analyzer" target="_blank">Pou�it� analyz�toru m�d�< /a> poskytuje v�voj���m m�d� TNG Wiki.</p>

</td>
</tr>

<tr class="databack">
	<td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="parser"><p class="subheadbold">Tabulka parseru</p></a>
    <p>Tento n�stroj je ur�en hlavn� pro lad�n� mod�. Tabulka parseru ukazuje, jak Mana�er m�d� zanalyzoval p��kazy konfigura�n�ho souboru m�du (.cfg). Je to zobrazeno ve form� tabulky, p�i�em� ka�d� ��dek p�edstavuje p��kaz m�du. Data uveden� v tabulce jsou p�ed�na dal��m skript�m mana�eru m�d� k dal��mu zpracov�n� - instalaci, odstran�n� atd. Pokud se vyskytne probl�m s m�dem, je dobr� za��t s tabulkou parseru, abyste zjistili, zda jsou v�echny p��kazy a argumenty m�du spr�vn� zachyceny.</p>

      <p>Tuto kartu m��ete pou��t k v�b�ru m�du ze seznamu, jeho� tabulku chcete zobrazit, nebo m��ete kliknout na n�zev modu v seznamu m�d� a zobrazit tabulku parseru pro tento m�d, <i>pokud jste povolili mo�nost Zobrazit dal�� n�stroje pro v�voj��e</i>.</p>

      <p>Zobrazen� t�to karty je voliteln�. Chcete-li jej pou��t, vyberte na kart� Mo�nosti "Zobrazit dal�� n�stroje pro v�voj��e". Pokud je mo�nost karty vypnut�, bude tak� deaktivov�n odkaz na str�nce seznamu.</p>

      <p><i>Nen� v rozsahu tohoto souboru n�pov�dy prob�rat p��kazy konfigurace m�d� a jak funguj�</i>. Informace naleznete na TNGWiki.</p>

    </td>
</tr>

<tr class="databack">
	<td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="recommended"><p class="subheadbold">Doporu�en� aktualizace</p></a>
    <p>Z�lo�ka <strong>Doporu�en� aktualizace</strong> je voliteln� a lze ji povolit na obrazovce Mo�nosti. Umo��uje aktualizovat soubory cust_text.php, pokud jste tak neu�inili v r�mci readme aktualizace TNG. </p>



<p>Dal�� informace (v angli�tin�) naleznete v �l�nku <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager" target="_blank">Mod Manager</a> a v kategorie �l�nk� <a href="https://tng.lythgoes.net/wiki/index.php?title=Category:TNG_Mod_Manager" target="_blank">TNG Mod Manager</a> na TNG Wiki.</p>
<p>V TNG Wiki si m��ete prohl�dnout �l�nek <a href="https://tng.lythgoes.net/wiki/index.php?title=Mod_Manager_Enhancements" target="_blank">Mod Manager</a> jak� vylep�en� byla provedena v TNG v12.</p>

	</td>
</tr>

<tr class="databack">
  <td class="tngshadow">
    <p style="float:right"><a href="#top">Nahoru</a></p>
    <a name="credits"><p class="subheadbold">Pod�kov�n�</p></a>

      <table style='table-layout:fixed;width:100%'>
        <tr>
          <td style='width:20%;vertical-align:top;'>
            Brian McFadyen
          </td>
          <td style='width:80%'>
            <ul><li>autor</li></ul>
          </td>
        </tr>

        <tr>
          <td style='vertical-align:top;'>
            Sean Schwoere
          </td>
          <td>
            <ul>
                <li>integrace pro Joomla</li>
                <li>lep�� integrace pro instalaci, odeb�r�n� a spr�vu m�d�</li>
            </ul>
          </td>
        </tr>

        <tr>
          <td style='vertical-align:top;'>
            Ken Roy
          </td>
          <td>
            <ul>
                <li>vedouc� v�vojov�ho t�mu, verze 12 - 14</li>
                <li>vytvo�il kartu Zobrazit protokol</li>
                <li>vytvo�il kartu Mo�nosti</li>
            </ul>
          </td>
        </tr>

        <tr>
          <td style='vertical-align:top;'>
            Rick Bisbee
          </td>
          <td>
            <ul>
                <li>vedouc� program�tor, verze 12 - 14</li>
                <li>p�idal d�vkov� zpracov�n�</li>
                <li>p�idal kartu Zobrazit tabulku parseru</li>
                <li>p�idal kartu Analyzovat soubory TNG</li>
                <li>refaktoroval k�d TNG pro �dr�bu, v14</li>
            </ul>
          </td>
        </tr>

        <tr>
          <td style='vertical-align:top;'>
            Jeff Robson
          </td>
          <td>
            <ul>
                <li>beta testovac� t�m, verze 12</li>
                <li>p�idal kartu Ovlivn�n� soubory</li>
                <li>hlavn� p��sp�vky ke stylu</li>
            </ul>
          </td>
        </tr>

        <tr>
          <td style='vertical-align:top;'>
            Robin Richmond
          </td>
          <td>
            <ul>
                <li>beta testovac� t�m, verze 12</li>
                <li>poskytl k�d pro p�eru�en� dlouh�ch ��dk� textu bez mezer, kter� se pou��v� p�edev��m ve sloupci Stav MM</li>
                <li>hlavn� p��sp�vky k zobrazen� protokolu MM</li>
            </ul>
          </td>
        </tr>


        <tr>
          <td style='vertical-align:top;'>
            Michel Kirsh
          </td>
          <td>
            <ul>
                <li>beta testovac� t�m, verze 14</li>
                <li>hlavn� aktualizace Anal�zy soubor� TNG</li>
            </ul>
          </td>
        </tr>

        <tr>
          <td style='vertical-align:top;'>
              beta testovac� t�m TNG v14
          </td>
          <td>

            <ul>
                <li>Mogens C. Fenger</li>
                <li>William Herndon</li>
                <li>Michel Kirsch</li>
                <li>Ron Krzmarzick</li>
                <li>Roger Moffat</li>
                <li>Jan-Thore Solem</li>
            </ul>
          </td>
        </tr>
      </table>
  </td>
</tr>
</table>
</body>