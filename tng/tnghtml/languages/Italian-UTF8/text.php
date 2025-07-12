<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Tutte le Fonti";
		$text['shorttitle'] = "Titolo Breve";
		$text['callnum'] = "Numero d'archivio";
		$text['author'] = "Autore";
		$text['publisher'] = "Editore";
		$text['other'] = "Altre Informazioni";
		$text['sourceid'] = "Fonte ID";
		$text['moresrc'] = "Altre Fonti";
		$text['repoid'] = "ID del Luogo di Deposito";
		$text['browseallrepos'] = "Cerca i Luoghi di Deposito";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nuova Lingua ";
		$text['changelanguage'] = "Cambia la Lingua";
		$text['languagesaved'] = "Lingua Salvata";
		$text['sitemaint'] = "Sito in Manutenzione.";
		$text['standby'] = "Il sito è temporaneamente non disponibile, stiamo aggiornando il DataBase. Prova ancora fra alcuni minuti. Se il sito rimane offline per un periodo esteso, contatta il <a href=\"suggest.php\">webmaster</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "Avvio GEDCOM da";
		$text['producegedfrom'] = "Produrre un archivio GEDCOM da";
		$text['numgens'] = "Numero di Generazioni";
		$text['includelds'] = "Includi informazione LDS";
		$text['buildged'] = "Costruire GEDCOM";
		$text['gedstartfrom'] = "GEDCOM inizia da";
		$text['nomaxgen'] = "Devi precisare un numero massimo di generazioni. Premi sul tasto 'Indietro' e correggi";
		$text['gedcreatedfrom'] = "GEDCOM creato da";
		$text['gedcreatedfor'] = "creato per";
		$text['creategedfor'] = "Crea un file GEDCOM";
		$text['email'] = "La tua email";
		$text['suggestchange'] = "Suggerisci una modifica";
		$text['yourname'] = "Il tuo nome";
		$text['comments'] = "Note / Commenti";
		$text['comments2'] = "Commenti";
		$text['submitsugg'] = "Invia una Proposta";
		$text['proposed'] = "Modifica Proposta";
		$text['mailsent'] = "Grazie. Il tuo messaggio è stato inoltrato.";
		$text['mailnotsent'] = "Spiacente, non è stato possibile inviare il tuo messaggio. Contatta direttamente xxx a yyy ";
		$text['mailme'] = "Invia una copia a questo indirizzo";
		$text['entername'] = "Indica il tuo nome";
		$text['entercomments'] = "Scrivi i tuoi commenti";
		$text['sendmsg'] = "Invia il Messaggio";
		//added in 9.0.0
		$text['subject'] = "Oggetto";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Foto e Cronistoria di";
		$text['indinfofor'] = "Informazioni personali di";
		$text['pp'] = "pp."; //page abbreviation
		$text['age'] = "Età";
		$text['agency'] = "Agenzia";
		$text['cause'] = "Causa";
		$text['suggested'] = "Suggerito";
		$text['closewindow'] = "Chiudi questa finestra";
		$text['thanks'] = "Grazie";
		$text['received'] = "Il tuo suggerimento è stato inviato all'amministratore per la revisione.";
		$text['indreport'] = "Rapporto individuale";
		$text['indreportfor'] = "Rapporto individuale per";
		$text['bkmkvis'] = "<strong>Nota:</strong> Questi segnalibri sono visibili solo su questo computer ed in questo browser.";
        //added in 9.0.0
		$text['reviewmsg'] = "C'è un suggerimento che necessita la tua revisione. Il suggerimento riguarda:";
        $text['revsubject'] = "Il suggerimento necessita della tua revisione";
        break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
	case "connections":
		$text['relcalc'] = "Calcolatore Parentela";
		$text['findrel'] = "Ricerca Parentela";
		$text['person1'] = "Persona 1:";
		$text['person2'] = "Persona 2:";
		$text['calculate'] = "Calcola";
		$text['select2inds'] = "Scegli due individui.";
		$text['findpersonid'] = "Trova ID della persona";
		$text['enternamepart'] = "Inserisci parte del nome o cognome";
		$text['pleasenamepart'] = "Inserisci una porzione del nome o del cognome.";
		$text['clicktoselect'] = "Premi per selezionare";
		$text['nobirthinfo'] = "Nessuna informazione di nascita";
		$text['relateto'] = "Parentela con";
		$text['sameperson'] = "I due individui sono la stessa persona";
		$text['notrelated'] = "I due individui non sono collegati su xxx generazioni."; //xxx will be replaced with number of generations
		$text['findrelinstr'] = "Per visualizzare la parentela tra due persone, utilizza il tasto 'Cerca' qui sotto per trovare gli individui (o mantenere la visualizzazione), poi premi 'Elabora'.";
		$text['sometimes'] = "(a volte il fatto di verificare un altro numero di generazioni dà un risultato diverso)";
		$text['findanother'] = "Trovare un altro legame";
		$text['brother'] = "il fratello di";
		$text['sister'] = "la sorella di";
		$text['sibling'] = "fratello/sorella di";
		$text['uncle'] = "il xxx zio di";
		$text['aunt'] = "la xxx zia di";
		$text['uncleaunt'] = "il xxx zio/zia di";
		$text['nephew'] = "il xxx nipote di";
		$text['niece'] = "la xxx nipote di";
		$text['nephnc'] = "il/la xxx nipote di";
		$text['removed'] = "di Secondo";
		$text['rhusband'] = "il Marito di ";
		$text['rwife'] = "la Moglie di ";
		$text['rspouse'] = "lo Sposo(a) di ";
		$text['son'] = "il Figlio di";
		$text['daughter'] = "la Figlia di";
		$text['rchild'] = "il Bimbo/a di";
		$text['sil'] = "il Genero di";
		$text['dil'] = "la Nuora di";
		$text['sdil'] = "il Genero o la Nuora di";
		$text['gson'] = "il xxx Nipote di";
		$text['gdau'] = "la xxx Nipote di";
		$text['gsondau'] = "il xxx Nipote di";
		$text['great'] = "bis";
		$text['spouses'] = "sono Coniugi";
		$text['is'] = "è";
		$text['changeto'] = "Cambia in (inserisci l'ID):";
		$text['notvalid'] = "L' ID della Persona non è valido o non esiste in questo database. Riprova.";
		$text['halfbrother'] = "Il mezzo fratello di";
		$text['halfsister'] = "La mezza sorella di";
		$text['halfsibling'] = "Il mezzo figlio di ";
		//changed in 8.0.0
		$text['gencheck'] = "Generazioni max da verificare";
		$text['mcousin'] = "il xxx cugino yyy di";  //male cousin; xxx = cousin number, yyy = times removed
		$text['fcousin'] = "la xxx cugina yyy di";  //female cousin
		$text['cousin'] = "il xxx cugino/a yyy di";
		$text['mhalfcousin'] = "Il mezzo cugino yyy di";  //male cousin
		$text['fhalfcousin'] = "La mezza cugina yyy di";  //female cousin
		$text['halfcousin'] = "Il mezzo cugino yyy di";
		//added in 8.0.0
		$text['oneremoved'] = "di primo grado";
		$text['gfath'] = "il xxx nonno di";
		$text['gmoth'] = "la xxx nonna di";
		$text['gpar'] = "i xxx nonni di";
		$text['mothof'] = "la madre di";
		$text['fathof'] = "il padre di";
		$text['parof'] = "i genitori di";
		$text['maxrels'] = "Parentele massime da visualizzare";
		$text['dospouses'] = "Mostra parentele riguardanti un coniuge";
		$text['rels'] = "Parentela";
		$text['dospouses2'] = "mostra i coniugi";
		$text['fil'] = "il suocero di";
		$text['mil'] = "la suocera di";
		$text['fmil'] = "il suocero o la suocera di";
		$text['stepson'] = "il figliastro di";
		$text['stepdau'] = "la figliastra di";
		$text['stepchild'] = "il figliastro/la figliastra di";
		$text['stepgson'] = "il xxx figliastro nipote di";
		$text['stepgdau'] = "la xxx figliastra nipote di";
		$text['stepgchild'] = "il/la xxx figliastro/figliastra nipote di";
		//added in 8.1.1
		$text['ggreat'] = "bis";
		//added in 8.1.2
		$text['ggfath'] = "il xxx bisnonno di";
		$text['ggmoth'] = "la xxx bisnonna di";
		$text['ggpar'] = "i xxx bisnonni di";
		$text['ggson'] = "il xxx pronipote di";
		$text['ggdau'] = "la xxx pronipote di";
		$text['ggsondau'] = "i xxx bisnipote di";
		$text['gstepgson'] = "il xxx pronipote figliastro di";
		$text['gstepgdau'] = "la xxx pronipote figliastra di";
		$text['gstepgchild'] = "i xxx pronipote figliastri di";
		$text['guncle'] = "il xxx prozio di";
		$text['gaunt'] = "la xxx prozia di";
		$text['guncleaunt'] = "il/la xxx prozio/prozia di";
		$text['gnephew'] = "il xxx pronipote di";
		$text['gniece'] = "la xxx pronipote di";
		$text['gnephnc'] = "il/la xxx pronipote di";
		//added in 14.0
		$text['pathscalc'] = "Ricerca di connessioni";
		$text['findrel2'] = "Ricerca di Parentela";
		$text['makeme2nd'] = "Usa il mio ID";
		$text['usebookmarks'] = "Usa segnalibri";
		$text['select2inds'] = "Scegli due individui.";
		$text['indinfofor'] = "Informazioni personali di";
		$text['nobookmarks'] = "Nessun segnalibro da usare";
		$text['bkmtitle'] = "Persone trovate nei segnalibri";
		$text['bkminfo'] = "Seleziona una persona:";
		$text['sortpathsby'] = "Ordina i percorsi per numero di";
		$text['sortbyshort'] = "Ordina per";
		$text['bylengthshort'] = "Lunghezza";
		$text['badID1'] = ": ID persona1 errato - torna indietro e correggi";
		$text['badID2'] = ": ID persona2 errato - torna indietro e correggi";
		$text['notintree'] = ": la persona con questo ID non fa parte di questo albero.";
		$text['sameperson'] = "I due individui sono la stessa persona";;
		$text['nopaths'] = "Queste persone non sono collegate.";
		$text['nopaths1'] = "Nessun'altra connessione più corta di xxx";
		$text['nopaths2'] = "in xxx passaggi di ricerca";
		$text['longestpath'] = "(il percorso più lungo cercato finora era lungo xxx passaggi)";
		$text['relevantpaths'] = "Numero di percorsi diversi rilevanti trovati: xxx";
		$text['skipMarr'] = "(in aggiunta, il numero di percorsi trovati ma non visualizzati a causa di troppi matrimoni era: xxx)";
		$text['mjaor'] = "o";
		$text['connectionsto'] = "Connessioni a ";
		$text['findanotherpers'] = "Cerca un'altra persona...";
		$text['sometimes'] = "(a volte il fatto di verificare un altro numero di generazioni dà un risultato diverso)";
		$text['anotherpath'] = "Cerca altre connessioni";
		$text['xpath'] = "Percorso ";
		$text['primary'] = "Persona Iniziale"; // note: used for both Start and End if text['fin'] not set
		$text['secondary'] = "Persona finale";
		$text['parent'] = "Genitore";
		$text['mhfather'] = "suo padre";
		$text['mhmother'] = "sua madre";
		$text['mhhusband'] = "suo marito";
		$text['mhwife'] = "sua moglie";
		$text['mhson'] = "suo figlio";
		$text['mhdaughter'] = "sua figlia";
		$text['fhfather'] = "suo padre";
		$text['fhmother'] = "sua madre";
		$text['fhhusband'] = "suo marito";
		$text['fhwife'] = "sua moglie";
		$text['fhson'] = "suo figlio";
		$text['fhdaughter'] = "sua figlia";
		$text['hfather'] = "padre";
		$text['hmother'] = "madre";
		$text['hhusband'] = "marito";
		$text['hwife'] = "moglie";
		$text['hson'] = "figlio";
		$text['hdaughter'] = "figlia";
		$text['maxruns'] = "Numero massimo di percorsi da controllare";
		$text['maxrshort'] = "Num. massimo";
		$text['maxlength'] = "Percorso di connessione non più lungo di";
		$text['maxlshort'] = "Lunghezza Max";
		$text['xstep'] = "passaggio";
		$text['xsteps'] = "passaggi";
		$text['xmarriages'] = "xxx matrimoni";
		$text['xmarriage'] = "1 matrimonio";
		$text['showspouses'] = "Mostra entrambi i coniugi";
		$text['showTxt'] = "Mostra descrizione testuale percorso";
		$text['showTxtshort'] = "Descr. testuale";
		$text['compactBox'] = "Mostra box persone compatti";
		$text['compactBoxshort'] = "Box compatti";
		$text['paths'] = "Percorsi";
		$text['dospouses2'] = "mostra i coniugi";
		$text['maxmopt'] = "Numero massimo di matrimoni per connessione";
		$text['maxm'] = "Matrimoni Max";
		$text['arerelated'] = "Queste persone sono parenti - la loro parentela è visualizzata nel Percorso 1";
		$text['simplerel'] = "Ricerca parentela semplice";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Foglio del Gruppo Famiglia di";
		$text['ldsords'] = "Ordinanze LDS";
		$text['endowedlds'] = "Conferma (LDS)";
		$text['sealedplds'] = "Sigillo ai Genitori (LDS)";
		$text['sealedslds'] = "Sigillo al Coniuge (LDS)";
		$text['otherspouse'] = "Altro Coniuge";
		$text['husband'] = "Padre";
		$text['wife'] = "Madre";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "N";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "E";
		$text['capplaceabbr'] = "L";
		$text['capmarrabbr'] = "M";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Ridefinire con";
		$text['unknownlit'] = "Sconosciuto";
		$text['popupnote1'] = "Informazioni ulteriori";
		$text['pedcompact'] = "Compatto";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Solo Testo";
		$text['descendfor'] = "Discendenza di";
		$text['maxof'] = "Massimo di";
		$text['gensatonce'] = "generazioni pubblicate contemporaneamente";
		$text['sonof'] = "Figlio di";
		$text['daughterof'] = "Figlia di";
		$text['childof'] = "Bambino di";
		$text['stdformat'] = "Formato Standard";
		$text['ahnentafel'] = "Albero genealogico";
		$text['addnewfam'] = "Aggiungi una nuova famiglia";
		$text['editfam'] = "Pubblica la famiglia";
		$text['side'] = "(ascendenti)";
		$text['familyof'] = "Famiglia di";
		$text['paternal'] = "Paterno";
		$text['maternal'] = "Materno";
		$text['gen1'] = "sé";
		$text['gen2'] = "Genitori";
		$text['gen3'] = "Nonni";
		$text['gen4'] = "Bisnonni";
		$text['gen5'] = "Trisnonni";
		$text['gen6'] = "Quadrisnonni";
		$text['gen7'] = "Quinti Nonni";
		$text['gen8'] = "Sesti Nonni";
		$text['gen9'] = "Settimi Nonni";
		$text['gen10'] = "Ottavi Nonni";
		$text['gen11'] = "Noni Nonni";
		$text['gen12'] = "Decimi Nonni";
		$text['graphdesc'] = "Grafico discendenza fino a questo punto";
		$text['pedbox'] = "Riquadro";
		$text['regformat'] = "Formato registro";
		$text['extrasexpl'] = "= Esiste almeno una foto, una storia o altri media per questo individuo.";
		$text['popupnote3'] = "Nuovo grafico";
		$text['mediaavail'] = "Media disponibili";
		$text['pedigreefor'] = "Albero Genealogico di";
		$text['pedigreech'] = "Albero Genealogico";
		$text['datesloc'] = "Date e Luoghi";
		$text['borchr'] = "Nascita/Alt - Morte/Sepoltura";
		$text['nobd'] = "Nessuna data di nascita o morte";
		$text['bcdb'] = "Tutte le date di Nascita/Alt/Morte/Sepoltura";
		$text['numsys'] = "Sistema di Numerazione";
		$text['gennums'] = "Numeri di Generazione";
		$text['henrynums'] = "Numeri di Henry";
		$text['abovnums'] = "Numeri di d'Aboville";
		$text['devnums'] = "Numeri di de Villiers";
		$text['dispopts'] = "Opzioni di visualizzazione";
		//added in 10.0.0
		$text['no_ancestors'] = "Nessun antenato trovato";
		$text['ancestor_chart'] = "Grafico antenati verticale";
		$text['opennewwindow'] = "Apri in una nuova finestra";
		$text['pedvertical'] = "Verticale";
		//added in 11.0.0
		$text['familywith'] = "Famiglia con";
		$text['fcmlogin'] = "Fai il login per vedere i dettagli";
		$text['isthe'] = "è il";
		$text['otherspouses'] = "altri coniugi";
		$text['parentfamily'] = "La famiglia del genitore ";
		$text['showfamily'] = "Mostra la famiglia";
		$text['shown'] = "visualizzato";
		$text['showparentfamily'] = "Visualizza famiglia genitore";
		$text['showperson'] = "Mostra la persona";
		//added in 11.0.2
		$text['otherfamilies'] = "Altre famiglie";
		//added in 14.0
		$text['dtformat'] = "Tabelle";
		$text['dtchildren'] = "Bambini";
		$text['dtgrandchildren'] = "Nipoti";
		$text['dtggrandchildren'] = "Pronipoti";
		$text['dtgggrandchildren'] = "Pronipoti"; //For 2x great grandchildren, 3x great grandchildren, etc. Usually different in Scandinavian languages
		$text['dtnodescendants'] = "Nessun discendente";
		$text['dtgen'] = "Gen";
		$text['dttotal'] = "Totale";
		$text['dtselect'] = "Seleziona";
		$text['dteachfulltable'] = "Ogni tabella intera avrà";
		$text['dtrows'] = "righe";
		$text['dtdisplayingtable'] = "Visualizzazione tabella";
		$text['dtgototable'] = "Vai alla tabella:";
		$text['fcinstrdn'] = "Mosta famiglia con coniuge";
		$text['fcinstrup'] = "Mostra famiglia con genitori";
		$text['fcinstrplus'] = "Scegli altri coniugi";
		$text['fcinstrfam'] = "Scegli altri genitori";
		//added in 15.0
		$text['nofamily'] = "No family is known for this individual";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Non esiste alcun report.";
		$text['reportname'] = "Nome del Report";
		$text['allreports'] = "Tutti i Report";
		$text['report'] = "Report";
		$text['error'] = "Errore";
		$text['reportsyntax'] = "La sintassi della query lanciata con questo report";
		$text['wasincorrect'] = "era errata, e come risultato non è stato possibile lanciare il report. Contatta l'amministratore a";
		$text['errormessage'] = "Messaggio di Errore";
		$text['equals'] = "uguale";
		$text['endswith'] = "termina con";
		$text['soundexof'] = "soundex di";
		$text['metaphoneof'] = "metafono di";
		$text['plusminus10'] = "+/- 10 anni da";
		$text['lessthan'] = "meno di ";
		$text['greaterthan'] = "più di ";
		$text['lessthanequal'] = "meno o uguale a ";
		$text['greaterthanequal'] = "più o uguale a ";
		$text['equalto'] = "uguale a";
		$text['tryagain'] = "Riprova";
		$text['joinwith'] = "Legame con";
		$text['cap_and'] = "E";
		$text['cap_or'] = "O";
		$text['showspouse'] = "Mostra coniuge (mostrerà duplicati se l'individuo ha più di un coniuge)";
		$text['submitquery'] = "Ricerca";
		$text['birthplace'] = "Luogo di Nascita";
		$text['deathplace'] = "Luogo del Decesso";
		$text['birthdatetr'] = "Anno di Nascita";
		$text['deathdatetr'] = "Anno del Decesso";
		$text['plusminus2'] = "+/- 2 anni da";
		$text['resetall'] = "Resetta tutti i valori";
		$text['showdeath'] = "Visualizza le informazioni di Decesso/Sepoltura";
		$text['altbirthplace'] = "Luogo di Battesimo";
		$text['altbirthdatetr'] = "Anno di Battesimo";
		$text['burialplace'] = "Luogo di Sepoltura";
		$text['burialdatetr'] = "Anno della Sepoltura";
		$text['event'] = "Evento";
		$text['day'] = "Giorno";
		$text['month'] = "Mese";
		$text['keyword'] = "Parola chiave (ad esempio, \"Circa\")";
		$text['explain'] = "Inserisci porzioni di date per vedere gli eventi corrispondenti. Lascia vuoto per vedere tutte le corrispondenze.";
		$text['enterdate'] = "Inserisci o scegli almeno uno degli seguenti: Giorno, Mese, Anno, Parola Chiave";
		$text['fullname'] = "Nome intero";
		$text['birthdate'] = "Data di Nascita";
		$text['altbirthdate'] = "Data di Battesimo";
		$text['marrdate'] = "Data di Matrimonio";
		$text['spouseid'] = "ID del coniuge";
		$text['spousename'] = "Nome del coniuge";
		$text['deathdate'] = "Data del Decesso";
		$text['burialdate'] = "Data della Sepoltura";
		$text['changedate'] = "Data Ultima Modifica";
		$text['gedcom'] = "Albero";
		$text['baptdate'] = "Data di Battesimo (LDS)";
		$text['baptplace'] = "Luogo di Battesimo (LDS)";
		$text['endldate'] = "Data di Conferma (LDS)";
		$text['endlplace'] = "Luogo di Conferma (LDS)";
		$text['ssealdate'] = "Data del Sigillo al Coniuge (LDS)";   //Sealed to spouse
		$text['ssealplace'] = "Luogo del Sigillo al Coniuge (LDS)";
		$text['psealdate'] = "Data del Sigillo ai Genitori (LDS)";   //Sealed to parents
		$text['psealplace'] = "Luogo del sigillo ai Genitori (LDS)";
		$text['marrplace'] = "Luogo di Matrimonio";
		$text['spousesurname'] = "Cognome del coniuge";
		$text['spousemore'] = "se inserisci un valore per il Cognome del coniuge, devi selezionare il sesso.";
		$text['plusminus5'] = "+/- 5 anni da";
		$text['exists'] = "esiste";
		$text['dnexist'] = "non esiste";
		$text['divdate'] = "Data del Divorzio";
		$text['divplace'] = "Luogo del Divorzio";
		$text['otherevents'] = "Altri Eventi ed Attributi";
		$text['numresults'] = "Risultati per pagina";
		$text['mysphoto'] = "Foto misteriosa";
		$text['mysperson'] = "Persone sfuggenti";
		$text['joinor'] = "L'opzione 'Unisci con O' non può essere usata con il Cognome del Coniuge";
		$text['tellus'] = "Dicci quello che sai";
		$text['moreinfo'] = "Ulteriori informazioni:";
		//added in 8.0.0
		$text['marrdatetr'] = "Anno di Matrimonio";
		$text['divdatetr'] = "Anno di Divorzio";
		$text['mothername'] = "Nome della Madre";
		$text['fathername'] = "Nome del Padre";
		$text['filter'] = "Filtro";
		$text['notliving'] = "non vivente";
		$text['nodayevents'] = "Eventi per questo mese che non sono associati con un giorno specifico:";
		//added in 9.0.0
		$text['csv'] = "File CSV (Delimitato da virgola)";
		//added in 10.0.0
		$text['confdate'] = "Data di Conferma (LDS)";
		$text['confplace'] = "Luogo di Conferma (LDS)";
		$text['initdate'] = "Data Iniziazione (LDS)";
		$text['initplace'] = "Luogo Iniziazizone (LDS)";
		//added in 11.0.0
		$text['marrtype'] = "Tipo di Matrimonio";
		$text['searchfor'] = "Cerca";
		$text['searchnote'] = "Nota: Questa pagina utilizza Google per eseguire la ricerca. Il numero di risultati restituiti verrà influenzato direttamente dalla misura in cui Google è stato in grado di indicizzare il sito.";
		//added in 15.0
		$text['livingonly'] = "Living only";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "File di Log per";
		$text['mostrecentactions'] = "Azioni più recenti";
		$text['autorefresh'] = "Auto Refresh (30 secondi)";
		$text['refreshoff'] = "Disattiva Auto Refresh";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cimiteri e Lapidi";
		$text['showallhsr'] = "Mostra tutte le registrazioni delle lapidi";
		$text['in'] = "in";
		$text['showmap'] = "Mostra la mappa";
		$text['headstonefor'] = "Lapide di";
		$text['photoof'] = "Fotografia di";
		$text['photoowner'] = "Proprietario dell'originale";
		$text['nocemetery'] = "Nessun cimitero";
		$text['iptc005'] = "Titolo";
		$text['iptc020'] = "Categorie supplementari";
		$text['iptc040'] = "Istruzioni speciali";
		$text['iptc055'] = "Data di Creazione";
		$text['iptc080'] = "Autore";
		$text['iptc085'] = "Posizione dell'Autore";
		$text['iptc090'] = "Città";
		$text['iptc095'] = "Stato/Provincia";
		$text['iptc101'] = "Nazione";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Titolo";
		$text['iptc110'] = "Fonte";
		$text['iptc115'] = "Fonte della Foto";
		$text['iptc116'] = "Nota di Diritto D'Autore";
		$text['iptc120'] = "Sottotitolo";
		$text['iptc122'] = "Autore del Sottotitolo";
		$text['mapof'] = "Mappa di";
		$text['regphotos'] = "Vista Descrittiva";
		$text['gallery'] = "Vedi la Galleria";
		$text['cemphotos'] = "Foto di Cimiteri";
		$text['photosize'] = "Dimensioni";
        $text['iptc010'] = "Priorità";
		$text['filesize'] = "Dimensione del File";
		$text['seeloc'] = "Vedi Luogo";
		$text['showall'] = "Mostra tutto";
		$text['editmedia'] = "Modifica Media";
		$text['viewitem'] = "Mostra questo oggetto";
		$text['editcem'] = "Modifica Cimitero";
		$text['numitems'] = "# Oggetti";
		$text['allalbums'] = "Tutti gli Albums";
		$text['slidestop'] = "Metti in pausa le Diapositive";
		$text['slideresume'] = "Riprendi la visualizzazione delle Diapositive";
		$text['slidesecs'] = "Secondi per ogni diapositiva:";
		$text['minussecs'] = "riduci di 0.5 secondi";
		$text['plussecs'] = "aumenta di 0.5 secondi";
		$text['nocountry'] = "Nazione sconosciuta";
		$text['nostate'] = "Stato sconosciuto";
		$text['nocounty'] = "Provincia sconosciuta";
		$text['nocity'] = "Città sconosciuta";
		$text['nocemname'] = "Nome del Cimitero sconosciuto";
		$text['editalbum'] = "Modifica l'album";
		$text['mediamaptext'] = "<strong>Nota:</strong> Sposta il mouse sopra l'immagine per vedere i nomi. Clicca per vedere la pagina di ogni nome.";
		//added in 8.0.0
		$text['allburials'] = "Tutte le Sepolture";
		$text['moreinfo'] = "Clicca per ulteriori informazioni su questa immagine";
		//added in 9.0.0
        $text['iptc025'] = "Parole Chiave";
        $text['iptc092'] = "Sub-Luogo";
		$text['iptc015'] = "Categoria";
		$text['iptc065'] = "Programma Originario";
		$text['iptc070'] = "Versione Programma";
		//added in 13.0
		$text['toggletags'] = "Attiva/Disattiva Etichette";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places":
		$text['surnamesstarting'] = "Mostra i cognomi che cominciano con";
		$text['showtop'] = "Mostra l'inizio";
		$text['showallsurnames'] = "Pubblica tutti i Cognomi";
		$text['sortedalpha'] = "ordinati alfabeticamente";
		$text['byoccurrence'] = "ordinati per occorrenze";
		$text['firstchars'] = "Primi caratteri";
		$text['mainsurnamepage'] = "Pagina Cognome principale";
		$text['allsurnames'] = "Tutti i Cognomi";
		$text['showmatchingsurnames'] = "Premi su un Cognome per visualizzare i risultati.";
		$text['backtotop'] = "Ritorna all'inizio";
		$text['beginswith'] = "Inizia con";
		$text['allbeginningwith'] = "Tutti i Cognomi che iniziano con";
		$text['numoccurrences'] = "numero totale località tra parentesi";
		$text['placesstarting'] = "Mostra località maggiori che iniziano con";
		$text['showmatchingplaces'] = "Premi su un luogo per vedere località minori. Clicca sull'icona di ricerca per vedere individui corrispondenti.";
		$text['totalnames'] = "totale individui";
		$text['showallplaces'] = "Mostra tutte le località maggiori";
		$text['totalplaces'] = "totale luoghi";
		$text['mainplacepage'] = "Pagina luoghi principali";
		$text['allplaces'] = "Tutte le località maggiori";
		$text['placescont'] = "Mostra tutti i luoghi che contengono";
		//changed in 8.0.0
		$text['top30'] = "Primi xxx cognomi";
		$text['top30places'] = "Prime xxx località maggiori";
		//added in 12.0.0
		$text['firstnamelist'] = "Lista Nomi";
		$text['firstnamesstarting'] = "Mostra nomi che iniziano con";
		$text['showallfirstnames'] = "Mostra tutti i nomi";
		$text['mainfirstnamepage'] = "Pagina nomi principali";
		$text['allfirstnames'] = "Tutti i Nomi";
		$text['showmatchingfirstnames'] = "Clicca su un nome per mostrare i record corrispondenti.";
		$text['allfirstbegwith'] = "Tutti i nomi che iniziano con";
		$text['top30first'] = "Primi xxx nomi";
		$text['allothers'] = "Tutti gli altri";
		$text['amongall'] = "(tra tutti i nomi)";
		$text['justtop'] = "Solo i primi xxx";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(ultimi xx giorni)";

		$text['photo'] = "Foto";
		$text['history'] = "Storia/Documento";
		$text['husbid'] = "ID Padre";
		$text['husbname'] = "Nome del Padre";
		$text['wifeid'] = "ID Madre";
		//added in 11.0.0
		$text['wifename'] = "Nome della Madre";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Elimina";
		$text['addperson'] = "Aggiungi Individuo";
		$text['nobirth'] = "Il seguente individuo non ha una data di nascita valida e non è stato possibile aggiungerlo";
		$text['event'] = "Evento(i)";
		$text['chartwidth'] = "Larghezza grafico";
		$text['timelineinstr'] = "Aggiungi individui";
		$text['togglelines'] = "Attiva/Disattiva linee";
		//changed in 9.0.0
		$text['noliving'] = "Il seguente individuo è registrato come vivente o privato e non è stato possibile aggiungerlo perché non sei loggato con le autorizzazioni necessarie";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Tutti gli alberi";
		$text['treename'] = "Nome dell'albero";
		$text['owner'] = "Proprietario";
		$text['address'] = "Indirizzo";
		$text['city'] = "Città";
		$text['state'] = "Provincia";
		$text['zip'] = "Codice Postale";
		$text['country'] = "Nazione";
		$text['email'] = "email";
		$text['phone'] = "Telefono";
		$text['username'] = "Nome utente";
		$text['password'] = "Password";
		$text['loginfailed'] = "Login fallito.";

		$text['regnewacct'] = "Registrazione Nuovo Account Utente";
		$text['realname'] = "Il tuo vero nome";
		$text['phone'] = "Telefono";
		$text['email'] = "email";
		$text['address'] = "Indirizzo";
		$text['acctcomments'] = "Note o Commenti";
		$text['submit'] = "Invia";
		$text['leaveblank'] = "(lasciare vuoto se desiderate un nuovo albero)";
		$text['required'] = "Campi obbligatori";
		$text['enterpassword'] = "Inserisci una password.";
		$text['enterusername'] = "Inserisci un nome utente.";
		$text['failure'] = "Ci dispiace ma il nome utente scelto è già in uso. Usa il tasto Indietro del tuo browser per tornare alla pagina precedente e scegliere un nome utente diverso.";
		$text['success'] = "Grazie. Abbiamo ricevuto la tua registrazione. Ti contatteremo quando il tuo account sarà attivato o se abbiamo bisogno di maggiori informazioni.";
		$text['emailsubject'] = "Richiesta di registrazione Nuovo Utente TNG";
		$text['website'] = "Sito web";
		$text['nologin'] = "Non hai ancora un account?";
		$text['loginsent'] = "Dati di accesso inviati";
		$text['loginnotsent'] = "Dati di accesso NON inviati";
		$text['enterrealname'] = "Inserisci il tuo vero nome.";
		$text['rempass'] = "Resta collegato con questo computer";
		$text['morestats'] = "Statistiche addizionali";
		$text['accmail'] = "<strong>NOTA:</strong> Per poter ricevere la posta dall'amministratore del sito in merito al tuo account, assicurati di non bloccare la posta in arrivo da questo dominio.";
		$text['newpassword'] = "Nuova Password";
		$text['resetpass'] = "Resetta la tua Password";
		$text['nousers'] = "Questo form non può essere usato fino a che non esista almeno un record utente. Se sei il proprietario del sito, vai ad Amministrazione/Utenti per creare il tuo Account Amministratore.";
		$text['noregs'] = "Siamo spiacenti, ma non accettiamo nuove registrazioni utente al momento. <a href=\"suggest.php\">Contattaci</a> direttamente se hai osservazioni o domande riguardo qualcosa su questo sito.";
		$text['emailmsg'] = "Hai ricevuto una nuova richiesta per un Account Utente TNG. Collegati all' Amministrazione di TNG ed accorda le autorizzazioni adeguate a questo nuovo Account. Ricorda di informare il richiedente rispondendo questo a messaggio.";
		$text['accactive'] = "L'account utente è stato attivato, ma l'utente non avrà alcun diritto fino a che non gleli assegnerai.";
		$text['accinactive'] = "Vai ad Amministrazione/Utenti/Rivedi per accedere ai Settaggi Utente. L'utente rimarrà inattivo fino a che non modificherai e salverai i dati almeno una volta.";
		$text['pwdagain'] = "Ripeti la password";
		$text['enterpassword2'] = "Digita nuovamente la tua password.";
		$text['pwdsmatch'] = "Le tue password non coincidono. Digita la stessa password nei 2 campi.";
		$text['acksubject'] = "Grazie per esserti registrato"; //for a new user account
		$text['ackmessage'] = "La tua richiesta per un Account Utente è stata ricevuta. Il tuo account rimarrà inattivo fino a che non sarà verificato dal proprietario del sito. Sarai avvisato via email quando il tua account sarà pronto per l'uso.";
		//added in 12.0.0
		$text['switch'] = "Cambia";
		//added in 14.0
		$text['newpassword2'] = "Ripeti la password";
		$text['resetsuccess'] = "Bene ! La Password è stata resettata";
		$text['resetfail'] = "Errore: Password non resettata";
		$text['failreason0'] = " (errore database sconosciuto)";
		$text['failreason2'] = " (non hai i permessi per modificare la tua password)";
		$text['failreason3'] = " (le password non coincidono)";
		break;

	//added in 10.0.0
	case "branches":
		$text['browseallbranches'] = "Scorri tutti i Rami";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Quantità";
		$text['totindividuals'] = "Numero totale di Individui";
		$text['totmales'] = "Totale Uomini";
		$text['totfemales'] = "Totale Donne";
		$text['totunknown'] = "Totale Sesso Non Determinato";
		$text['totliving'] = "Totale Individui Viventi";
		$text['totfamilies'] = "Totale Famiglie";
		$text['totuniquesn'] = "Totale Cognomi unici";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Totale Fonti";
		$text['avglifespan'] = "Durata media di vita";
		$text['earliestbirth'] = "Nascita più vecchia";
		$text['longestlived'] = "Vita più lunga";
		$text['days'] = "Giorni";
		$text['age'] = "Età";
		$text['agedisclaimer'] = "I calcoli legati all'età sono basati sugli Individui con una data di nascita ed una data di decesso conosciute. A causa dell'esistenza di dati incompleti (ad esempio una data di decesso registrata come \"1945 \" o \"AVT 1860 \"), questi calcoli non sono precisi al 100%.";
		$text['treedetail'] = "Maggiori informazioni su quest'albero";
		$text['total'] = "Totale";
		//added in 12.0
		$text['totdeceased'] = "Totale Deceduti";
		//added in 14.0
		$text['totalsourcecitations'] = "Totale Citazioni Fonti";
		break;

	case "notes":
		$text['browseallnotes'] = "Scorri tutte le Note";
		break;

	case "help":
		$text['menuhelp'] = "Tasto Menu";
		break;

	case "install":
		$text['perms'] = "Tutti i permessi sono stati settati.";
		$text['noperms'] = "Non è stato possibile settare i permessi per i seguenti files:";
		$text['manual'] = "Per cortesia, settali manualmente.";
		$text['folder'] = "La cartella";
		$text['created'] = "è stata creata";
		$text['nocreate'] = "non è stata creata. Si prega di crearla manualmente.";
		$text['infosaved'] = "Informazioni memorizzate, collegamento verificato!";
		$text['tablescr'] = "Le tabelle sono state generate!";
		$text['notables'] = "Non è stato possibile generare le seguenti tabelle:";
		$text['nocomm'] = "TNG non riesce a comunicare con il tuo database. Non è stata creata nessuna tabella.";
		$text['newdb'] = "Informazioni memorizzate, connessione verificata, nuovo database creato:";
		$text['noattach'] = "Informazioni memorizzate. Connessione stabilita e database creato, ma TNG non è riuscito a collegarcisi.";
		$text['nodb'] = "Informazioni memorizzate. Connessione stabilita, ma il database non esiste e non è stato possibile crearlo. Verifica che il nome del database sia corrretto, che l'utente del database abbia accesso correttamente o usa il pannello di controllo per crearlo.";
		$text['noconn'] = "Informazioni memorizzate ma connessione fallita. Uno o più dei seguenti elementi non è corretto:";
		$text['exists'] = "Esiste già.";
		$text['noop'] = "Non è stata eseguita nessuna operazione.";
		//added in 8.0.0
		$text['nouser'] = "Utente non creato. Il nome utente potrebbe esistere già.";
		$text['notree'] = "Albero non creato. L'ID dell'Albero potrebbe esistere già.";
		$text['infosaved2'] = "Informazioni memorizzate";
		$text['renamedto'] = "rinominato con";
		$text['norename'] = "non poteva essere rinominato";
		//changed in 13.0.0
		$text['loginfirst'] = "Sono stati rilevati record di utenti esistenti. Per procedere devi prima collegarti o rimuovere tutti i record dalla tabella utenti.";
		break;

	case "imgviewer":
		$text['magmode'] = "Modalità ingrandimento";
		$text['panmode'] = "Modalità panoramica";
		$text['pan'] = "Clicca e trascina per muoverti all'interno dell'immagine";
		$text['fitwidth'] = "Adatta in Larghezza";
		$text['fitheight'] = "Adatta in Altezza";
		$text['newwin'] = "Nuova Finestra";
		$text['opennw'] = "Apri l'immagine in una nuova finestra";
		$text['magnifyreg'] = "Clicca per ingrandire una regione dell'immagine";
		$text['imgctrls'] = "Attiva controlli immagine";
		$text['vwrctrls'] = "Attiva controllli visualizzatore di immagini";
		$text['vwrclose'] = "Chiudere il visualizzatore di immagini";

		//added in 15.0
		$text['showtags'] = "Show tags";
		$text['toggletagsmsg'] = "Click to toggle";
		break;

	case "dna":
		$text['test_date'] = "Verifica data";
		$text['links'] = "Collegamenti rilevanti";
		$text['testid'] = "Verifica ID";
		//added in 12.0.0
		$text['mode_values'] = "Valori Modo";
		$text['compareselected'] = "Confronta selezionati";
		$text['dnatestscompare'] = "Confronta Test Y-DNA";
		$text['keep_name_private'] = "Keep Name Private";
		$text['browsealltests'] = "Scorri tutti i Tests";
		$text['all_dna_tests'] = "Tutti i test DNA";
		$text['fastmutating'] = "Rapido&nbsp;Mutevole";
		$text['alltypes'] = "Tutti i Tipi";
		$text['allgroups'] = "Tutti i Gruppi";
		$text['Ydna_LITbox_info'] = "Il/I Test collegati a questa persona non sono stati necessariamente effettuati da questa persona.<br />La colonna 'Haplogroup' mostra dati in rosso se il risultato è 'Previsto' o verde se il test è 'Confermato'";
		//added in 12.1.0
		$text['dnatestscompare_mtdna'] = "Confronta Test mtDNA selezionati";
		$text['dnatestscompare_atdna'] = "Confronta Test atDNA selezionati";
		$text['chromosome'] = "Chr";
		$text['centiMorgans'] = "cM";
		$text['snps'] = "SNPs";
		$text['y_haplogroup'] = "Y-DNA";
		$text['mt_haplogroup'] = "mtDNA";
		$text['sequence'] = "Ref";
		$text['extra_mutations'] = "Mutazioni Extra";
		$text['mrca'] = "MRC Ancestor";
		$text['ydna_test'] = "Y-DNA Tests";
		$text['mtdna_test'] = "Test mtDNA (Mitocondriale)";
		$text['atdna_test'] = "Test atDNA (autosomico)";
		$text['segment_start'] = "Inizio";
		$text['segment_end'] = "Fine";
		$text['suggested_relationship'] = "Suggeriti";
		$text['actual_relationship'] = "Attuali";
		$text['12markers'] = "Marcatori 1-12";
		$text['25markers'] = "Marcatori 13-25";
		$text['37markers'] = "Marcatori 26-37";
		$text['67markers'] = "Marcatori 38-67";
		$text['111markers'] = "Marcatori 68-111";
		//added in 13.1
		$text['comparemore'] = "Devi selezionare almeno 2 test da confrontare.";
		break;
}

//common
$text['matches'] = "Risultati";
$text['description'] = "Descrizione";
$text['notes'] = "Note";
$text['status'] = "Statuto";
$text['newsearch'] = "Nuova ricerca";
$text['pedigree'] = "Albero";
$text['seephoto'] = "Vedi foto";
$text['andlocation'] = "& luogo";
$text['accessedby'] = "consultato da";
$text['children'] = "Bambini";  //from getperson
$text['tree'] = "Albero";
$text['alltrees'] = "Tutti gli alberi";
$text['nosurname'] = "[nessun cognome]";
$text['thumb'] = "Miniatura";  //as in Thumbnail
$text['people'] = "Persone";
$text['title'] = "Titolo";  //from getperson
$text['suffix'] = "Suffisso";  //from getperson
$text['nickname'] = "Soprannome";  //from getperson
$text['lastmodified'] = "Ultima modifica";  //from getperson
$text['married'] = "Sposato";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Nome"; //from showmap
$text['lastfirst'] = "Nome, Nomignolo";  //from search
$text['bornchr'] = "Nato/battezzato";  //from search
$text['individuals'] = "Persone";  //from whats new
$text['families'] = "Famiglie";
$text['personid'] = "ID persona";
$text['sources'] = "Fonti";  //from getperson (next several)
$text['unknown'] = "Sconosciuto";
$text['father'] = "Padre";
$text['mother'] = "Madre";
$text['christened'] = "Battezzato(a)";
$text['died'] = "Morto(a)";
$text['buried'] = "Sepolto(a)";
$text['spouse'] = "Coniuge";  //from search
$text['parents'] = "Genitori";  //from pedigree
$text['text'] = "Testo";  //from sources
$text['language'] = "Lingua";  //from languages
$text['descendchart'] = "Discendenti";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Persona";
$text['edit'] = "Modifica";
$text['date'] = "Data";
$text['login'] = "Accedi";
$text['logout'] = "Esci";
$text['groupsheet'] = "Foglio di Gruppo";
$text['text_and'] = "e";
$text['generation'] = "Generazione";
$text['filename'] = "Nome del file";
$text['id'] = "ID";
$text['search'] = "Cerca";
$text['user'] = "Utente";
$text['firstname'] = "Nome";
$text['lastname'] = "Cognome";
$text['searchresults'] = "Risultati ricerca";
$text['diedburied'] = "Deceduto/Sepolto";
$text['homepage'] = "Home";
$text['find'] = "Ricerca...";
$text['relationship'] = "Parentela";		//in German, Verwandtschaft
$text['relationship2'] = "Relazione"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Linea del tempo";
$text['yesabbr'] = "Si";               //abbreviation for 'yes'
$text['divorced'] = "Divorziato";
$text['indlinked'] = "Legato a";
$text['branch'] = "Ramo";
$text['moreind'] = "Più individui";
$text['morefam'] = "Più famiglie";
$text['surnamelist'] = "Lista dei cognomi";
$text['generations'] = "Generazioni";
$text['refresh'] = "Aggiorna";
$text['whatsnew'] = "Novità";
$text['reports'] = "Reports";
$text['placelist'] = "Lista di Luoghi";
$text['baptizedlds'] = "Battezzato (LDS)";
$text['endowedlds'] = "Conferma (LDS)";
$text['sealedplds'] = "Sigillo ai Genitori (LDS)";
$text['sealedslds'] = "Sigillo al Coniuge (LDS)";
$text['ancestors'] = "Antenati";
$text['descendants'] = "Discendenti";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data dell'ultima importazione GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Memorizza le modifiche";
$text['familyid'] = "ID famiglia";
$text['headstone'] = "Lapidi";
$text['historiesdocs'] = "Storie";
$text['anonymous'] = "anonimo";
$text['places'] = "Luoghi";
$text['anniversaries'] = "Date ed Anniversari";
$text['administration'] = "Amministrazione";
$text['help'] = "Aiuto";
//$text['documents'] = "Documents";
$text['year'] = "Anno";
$text['all'] = "Tutti";
$text['address'] = "Indirizzo";
$text['suggest'] = "Suggerimento";
$text['editevent'] = "Suggerisci una modifica per questo evento";
$text['morelinks'] = "Altri Collegamenti";
$text['faminfo'] = "Informazioni Famiglia";
$text['persinfo'] = "Informazioni Personali";
$text['srcinfo'] = "Informazioni sulla Fonte";
$text['fact'] = "Fatto";
$text['goto'] = "Scegli una pagina";
$text['tngprint'] = "Stampa";
$text['databasestatistics'] = "Statistiche"; //needed to be shorter to fit on menu
$text['child'] = "Bambino";  //from familygroup
$text['repoinfo'] = "Informazioni Deposito";
$text['tng_reset'] = "Resetta";
$text['noresults'] = "Nessun risultato";
$text['allmedia'] = "Tutti i Media";
$text['repositories'] = "Depositi";
$text['albums'] = "Albums";
$text['cemeteries'] = "Cimiteri";
$text['surnames'] = "Cognomi";
$text['link'] = "Collegamenti";
$text['media'] = "Media";
$text['gender'] = "Genere";
$text['latitude'] = "Latitudine";
$text['longitude'] = "Longitudine";
$text['bookmark'] = "Aggiungi Segnalibro";
$text['mngbookmarks'] = "Vai ai Segnalibri";
$text['bookmarked'] = "Segnalibro aggiunto";
$text['remove'] = "Rimuovi";
$text['find_menu'] = "Trova";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Cimitero";
$text['gmapevent'] = "Mappa Evento";
$text['gevents'] = "Evento";
$text['googleearthlink'] = "Collegamento a Google Earth";
$text['googlemaplink'] = "Collegamento a Google Maps";
$text['gmaplegend'] = "Legenda Pins";
$text['unmarked'] = "Senza marcatori";
$text['located'] = "Individuato";
$text['albclicksee'] = "Clicca per vedere tutti gli elementi in questo album";
$text['notyetlocated'] = "Non ancora individuato";
$text['cremated'] = "Cremato";
$text['missing'] = "Mancante";
$text['pdfgen'] = "Generatore PDF";
$text['blank'] = "Grafico vuoto";
$text['fonts'] = "Fonti";
$text['header'] = "Intestazione";
$text['data'] = "Dati";
$text['pgsetup'] = "Impostazioni pagina";
$text['pgsize'] = "Formato pagina";
$text['orient'] = "Orientamento"; //for a page
$text['portrait'] = "Verticale";
$text['landscape'] = "Orizzontale";
$text['tmargin'] = "Margine superiore";
$text['bmargin'] = "Margine inferiore";
$text['lmargin'] = "Margine sinistro";
$text['rmargin'] = "Margine destro";
$text['createch'] = "Genera Grafico";
$text['prefix'] = "Prefisso";
$text['mostwanted'] = "I più cercati";
$text['latupdates'] = "Aggiornamenti recenti";
$text['featphoto'] = "Foto in evidenza";
$text['news'] = "Notizie";
$text['ourhist'] = "La storia della nostra Famiglia";
$text['ourhistanc'] = "La storia della nostra Famiglia e dei nostri Antenati";
$text['ourpages'] = "Le pagine Genealogiche di Famiglia";
$text['pwrdby'] = "Sito gestito con";
$text['writby'] = "scritto da";
$text['searchtngnet'] = "Cerca nel Network TNG (GENDEX)";
$text['viewphotos'] = "Guarda tutte le foto";
$text['anon'] = "Non sei collegato";
$text['whichbranch'] = "A quale rampo appartenete?";
$text['featarts'] = "Articoli in evidenza";
$text['maintby'] = "Gestito da";
$text['createdon'] = "Creato nel";
$text['reliability'] = "Affidabilità";
$text['labels'] = "Etichette";
$text['inclsrcs'] = "Includi Fonti";
$text['cont'] = "(cont.)"; //abbreviation for continued
$text['mnuheader'] = "Home";
$text['mnusearchfornames'] = "Cerca";
$text['mnulastname'] = "Cognome";
$text['mnufirstname'] = "Nome";
$text['mnusearch'] = "Cerca";
$text['mnureset'] = "Ricomincia";
$text['mnulogon'] = "Login";
$text['mnulogout'] = "Logout";
$text['mnufeatures'] = "Altre funzioni";
$text['mnuregister'] = "Registra un Account Utente";
$text['mnuadvancedsearch'] = "Ricerca Avanzata";
$text['mnulastnames'] = "Cognomi";
$text['mnustatistics'] = "Statistiche";
$text['mnuphotos'] = "Foto";
$text['mnuhistories'] = "Storie";
$text['mnumyancestors'] = "Foto &amp; Storie per Antenati di [Persona]";
$text['mnucemeteries'] = "Cimiteri";
$text['mnutombstones'] = "Lapidi";
$text['mnureports'] = "Rapporti";
$text['mnusources'] = "Fonti";
$text['mnuwhatsnew'] = "Novità";
$text['mnulanguage'] = "Cambia lingua";
$text['mnuadmin'] = "Amministrazione";
$text['welcome'] = "Benvenuto";
//changed in 8.0.0
$text['born'] = "Nato(a)";
//added in 8.0.0
$text['editperson'] = "Modifica Persona";
$text['loadmap'] = "Carica Mappa";
$text['birth'] = "Nascita";
$text['wasborn'] = "nasceva";
$text['startnum'] = "Primo Numero";
$text['searching'] = "Sto cercando";
//moved here in 8.0.0
$text['location'] = "Luogo";
$text['association'] = "Associazione";
$text['collapse'] = "Riduci";
$text['expand'] = "Espandi";
$text['plot'] = "Disegna";
//added in 8.0.2
$text['wasmarried'] = "Sposato(a)";
$text['anddied'] = "Morto(a)";
//added in 9.0.0
$text['share'] = "Condividi";
$text['hide'] = "Nascondi";
$text['disabled'] = "Il tuo Account Utente è stato disattivato. Contatta l'amministratore del sito per ulteriori informazioni.";
$text['contactus_long'] = "Se hai domande o commenti sui contenuti di questo sito, <span class=\"emphasis\"><a href=\"suggest.php\">contattaci</a></span>. Non vediamo l'ora di sentirti.";
$text['features'] = "Caratteristiche";
$text['resources'] = "Risorse";
$text['latestnews'] = "Ultime Notizie";
$text['trees'] = "Alberi";
$text['wasburied'] = "è stato sepolto";
//moved here in 9.0.0
$text['emailagain'] = "Ripeti email";
$text['enteremail2'] = "Inserisci il tuo indirizzo email di nuovo.";
$text['emailsmatch'] = "I tuoi indirizzi email non corrispondono. Inserisci lo stesso indirizzo e-mail nei 2 campi.";
$text['getdirections'] = "Clicca per ottenere indicazioni";
//changed in 9.0.0
$text['directionsto'] = " al ";
$text['slidestart'] = "Presentazione";
$text['livingnote'] = "Almeno un individuo vivente o privato è collegata a questa Nota - Dettagli non divulgabili.";
$text['livingphoto'] = "Almeno un individuo vivente o privato è collegato a questa Foto - Dettagli non divulgabili.";
$text['waschristened'] = "Battezzato(a)";
//added in 10.0.0
$text['branches'] = "Rami";
$text['detail'] = "Dettagli";
$text['moredetail'] = "Ulteriori dettagli";
$text['lessdetail'] = "Meno dettagli";
$text['conflds'] = "Confermato (LDS)";
$text['initlds'] = "Iniziazione (LDS)";
$text['wascremated'] = "è stato cremato";
//moved here in 11.0.0
$text['text_for'] = "per";
//added in 11.0.0
$text['searchsite'] = "Cerca nel sito";
$text['kmlfile'] = "Scarica un file .KML per vedere questo luogo in Google Earth";
$text['download'] = "Clicca per scaricare";
$text['more'] = " più";
$text['heatmap'] = "Mappa Termica";
$text['refreshmap'] = "Aggiorna Mappa";
$text['remnums'] = "Cancella Numeri e Pins";
$text['photoshistories'] = "Foto &amp; Storie";
$text['familychart'] = "Grafico Famiglia";
//moved here in 12.0.0
$text['dna_test'] = "Test DNA";
$text['test_type'] = "Tipo di Test";
$text['test_info'] = "Informazioni Test";
$text['takenby'] = "Effettuato da";
$text['haplogroup'] = "Haplogroup";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Collegamenti rilevanti";
$text['nofirstname'] = "[nessun nome]";
//added in 12.0.1
$text['cookieuse'] = "Nota: questo sito utilizza cookies.";
$text['dataprotect'] = "Protezione dei Dati Personali";
$text['viewpolicy'] = "Vedi la Policy";
$text['understand'] = "Ho compreso";
$text['consent'] = "Fornisco il mio consenso a questo sito di memorizzare i miei dati personali qui forniti. Comprendo che potrò richiedere al proprietario del sito di rimuovere queste informazioni in qualsiasi momento.";
$text['consentreq'] = "Sei pregato di fornire a questo sito il tuo consenso di memorizzare le informazioni personali fornite.";

//added in 12.1.0
$text['testsarelinked'] = "I Test DNA sono associati con";
$text['testislinked'] = "Il Test DNA è associato con";

//added in 12.2
$text['quicklinks'] = "Collegamenti rapidi";
$text['yourname'] = "Il tuo nome";
$text['youremail'] = "La tua email";
$text['liketoadd'] = "Altre informazioni che desideri aggiungere";
$text['webmastermsg'] = "Messaggio del webmaster";
$text['gallery'] = "Vedi la Galleria";
$text['wasborn_male'] = "è nato";  	// same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "è nata"; 	// same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "è stato battezzato";	// same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "è stata battezzata";	// same as $text['waschristened'] if no gender verb
$text['died_male'] = "morto";	// same as $text['anddied'] of no gender verb
$text['died_female'] = "morta";	// same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "è stato sepolto"; 	// same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "è stata sepolta"; 	// same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "è stato cremato";		// same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "è stata cremata";	// same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "sposato";	// same as $text['wasmarried'] if no gender verb
$text['wasmarried_female'] = "sposata";	// same as $text['wasmarried'] if no gender verb
$text['wasdivorced_male'] = "era divorziato";	// might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "era divorziata";	// might be the same as $text['divorce'] but as a verb
$text['inplace'] = " a ";			// used as a preposition to the location
$text['onthisdate'] = " il ";		// when used with full date
$text['inthisyear'] = " nel ";		// when used with year only or month / year dates
$text['and'] = "ed ";				// used in conjunction with wasburied or was cremated

//moved here in 12.2.1
$text['dna_info_head'] = "Info Test DNA";
//added in 13.0
$text['visitor'] = "Visitatore";

$text['popupnote2'] = "Nuovo pedigree";

//moved here in 14.0
$text['zoomin'] = "Zoom IN";
$text['zoomout'] = "Zoom OUT";
$text['scrollnote'] = "Trascina o scorri per vedere di più del grafico.";
$text['general'] = "Generale";

//changed in 14.0
$text['otherevents'] = "Altri Eventi ed Attributi";

//added in 14.0
$text['times'] = "x";
$text['connections'] = "Connessioni";
$text['continue'] = "Continua";
$text['title2'] = "Titolo"; //for media, sources, etc (not people)

//added in 15.0
$text['atsea'] = "Buried at sea";
$text['topsurnames'] = "Top Surnames";
$text['ourphotos'] = "Our Photos";

//moved here in 15.0
$text['greatoffset'] = "0"; //Scandinavian languages should set this to 1 so counting starts a generation later

@include_once(dirname(__FILE__) . "/alltext.php");
if(empty($alltextloaded)) getAllTextPath();
?>