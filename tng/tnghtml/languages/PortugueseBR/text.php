<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Mostrar todas as fontes";
		$text['shorttitle'] = "T�tulo abreviado";
		$text['callnum'] = "N�mero de registro";
		$text['author'] = "Autor(a)";
		$text['publisher'] = "Publicado por";
		$text['other'] = "Outro";
		$text['sourceid'] = "ID da fonte";
		$text['moresrc'] = "Outras fontes";
		$text['repoid'] = "Identificador do arquivo";
		$text['browseallrepos'] = "Folhear os arquivos";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Novo idioma";
		$text['changelanguage'] = "Outro idioma";
		$text['languagesaved'] = "Idioma armazenado";
		$text['sitemaint'] = "Site em manuten��o";
		$text['standby'] = "O site est� temporariamente fora do ar para manuten��o da base de dados. Por favor tente novamente depois de alguns minutos. Se o site permanecer fora do ar por um per�odo mais longo, por favor <a href=\"suggest.php\">contacte o propriet�rio do site</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM inicia para";
		$text['producegedfrom'] = "Gerar arquivo GEDCOM contendo";
		$text['numgens'] = "N�mero de gera��es";
		$text['includelds'] = "Incluir informa��es SUD";
		$text['buildged'] = "Gerar GEDCOM";
		$text['gedstartfrom'] = "GEDCOM inicia a partir de";
		$text['nomaxgen'] = "Informe o n�mero m�ximo de gera��es. Por favor, aperte o bot�o voltar e corrija o erro.";
		$text['gedcreatedfrom'] = "GEDCOM criado a partir de";
		$text['gedcreatedfor'] = "Gerado para";
		$text['creategedfor'] = "Gerar arquivo GEDCOM para";
		$text['email'] = "E-mail";
		$text['suggestchange'] = "Sugest�o de altera��o para";
		$text['yourname'] = "Seu nome";
		$text['comments'] = "Notas ou coment�rios";
		$text['comments2'] = "Coment�rios";
		$text['submitsugg'] = "Submeter a sugest�o";
		$text['proposed'] = "Altera��o proposta";
		$text['mailsent'] = "Obrigado. A sua mensagem foi enviada.";
		$text['mailnotsent'] = "A sua mensagem n�o p�de ser enviada. Por favor, contacte o Administrador do site directamente atrav�s do e-mail luis@@belard.pt.";
		$text['mailme'] = "Enviar uma c�pia para este endere�o";
		$text['entername'] = "Por favor, indique o seu nome";
		$text['entercomments'] = "Por favor, escreva os seus coment�rios";
		$text['sendmsg'] = "Enviar mensagem";
		//added in 9.0.0
		$text['subject'] = "Assunto";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotos e hist�rias para ";
		$text['indinfofor'] = "Informa��es individuais sobre";
		$text['pp'] = "pg."; //page abbreviation
		$text['age'] = "Idade";
		$text['agency'] = "�rg�o/reparti��o";
		$text['cause'] = "Causa";
		$text['suggested'] = "Altera��o sugerida";
		$text['closewindow'] = "Fechar a janela";
		$text['thanks'] = "Obrigado";
		$text['received'] = "A sua sugest�o foi enviada ao Administrador.";
		$text['indreport'] = "Relat�rio Individual";
		$text['indreportfor'] = "Relat�rio Individual para";
		$text['bkmkvis'] = "<strong>Nota:</strong> Estes marcadores s�o vis�veis somente neste navegador, neste computador.";
        //added in 9.0.0
		$text['reviewmsg'] = "H� altera��es sugeridas para revis�o. Elas s�o relativas a:";
        $text['revsubject'] = "Altera��es sugeridas requerem revis�o";
        break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
	case "connections":
		$text['relcalc'] = "Busca simples de parentescos (parentes consangu�neos e seus c�njuges)";
		$text['findrel'] = "Encontrar parentesco";
		$text['person1'] = "Pessoa 1:";
		$text['person2'] = "Pessoa 2:";
		$text['calculate'] = "Buscar";
		$text['select2inds'] = "Selecione duas pessoas.";
		$text['findpersonid'] = "Encontrar ID de pessoa";
		$text['enternamepart'] = "Forne�a uma parte do prenome ou do sobrenome";
		$text['pleasenamepart'] = "Entre com uma parte de um prenome ou sobrenome.";
		$text['clicktoselect'] = "clique para selecionar";
		$text['nobirthinfo'] = "N�o h� informa��o de nascimento";
		$text['relateto'] = "Parente de ";
		$text['sameperson'] = "Os dois indiv�duos s�o a mesma pessoa.";
		$text['notrelated'] = "As duas pessoas n�o t�m parentesco consangu�neo entre si em xxx gera��es."; //xxx will be replaced with number of generations
		$text['findrelinstr'] = "Instru��es: Forne�a os IDs de duas pessoas (ou utilize as pessoas mostradas). Ap�s clique o bot�o Computar para mostrar o parentesco at� xxx gera��es.";
		$text['sometimes'] = "(�s vezes, verificar um n�mero diferente de gera��es produz um resultado diferente.)";
		$text['findanother'] = "Encontrar outro parentesco";
		$text['brother'] = "irm�o de";
		$text['sister'] = "irm� de";
		$text['sibling'] = "irm�o/irm� de";
		$text['uncle'] = "xxx tio de";
		$text['aunt'] = "xxx tia de";
		$text['uncleaunt'] = "xxx tio/tia de";
		$text['nephew'] = "xxx sobrinho de";
		$text['niece'] = "xxx sobrinha de";
		$text['nephnc'] = "xxx sobrinho/sobrinha de";
		$text['removed'] = "vezes afastado";
		$text['rhusband'] = "marido de  ";
		$text['rwife'] = "esposa de ";
		$text['rspouse'] = "c�njuge de ";
		$text['son'] = "filho de";
		$text['daughter'] = "filha de";
		$text['rchild'] = "filho/filha de";
		$text['sil'] = "genro de";
		$text['dil'] = "nora de";
		$text['sdil'] = "genro/nora de";
		$text['gson'] = "xxx neto de";
		$text['gdau'] = "xxx neta de";
		$text['gsondau'] = "xxx neto/neta de";
		$text['great'] = "bis";
		$text['spouses'] = "s�o c�njuges";
		$text['is'] = "�";
		$text['changeto'] = "Mudar para:";
		$text['notvalid'] = "n�o � um ID v�lido de pessoa nesta base de dados. Por favor, tente novamente.";
		$text['halfbrother'] = "meio-irm�o de";
		$text['halfsister'] = "meia-irm� de";
		$text['halfsibling'] = "meio-irm�o de";
		//changed in 8.0.0
		$text['gencheck'] = "N�mero m�ximo de<br />gera��es a considerar";
		$text['mcousin'] = "primo xxx� yyy de";  //male cousin; xxx = cousin number, yyy = times removed
		$text['fcousin'] = "prima xxx� yyy de";  //female cousin
		$text['cousin'] = "primo/primaxxx� yyy de";
		$text['mhalfcousin'] = "meio-primo xxx� yyy de";  //male cousin
		$text['fhalfcousin'] = "meia-prima xxx� yyy de";  //female cousin
		$text['halfcousin'] = "meio-primo xxx� yyy de";
		//added in 8.0.0
		$text['oneremoved'] = "uma vez afastado";
		$text['gfath'] = "xxx av� de";
		$text['gmoth'] = "xxx av� de";
		$text['gpar'] = "xxx av�/av� de";
		$text['mothof'] = "a m�e de";
		$text['fathof'] = "o pai de";
		$text['parof'] = "genitor de";
		$text['maxrels'] = "N�mero m�ximo de parentescos mostrados";
		$text['dospouses'] = "Mostrar parentescos envolvendo a esposa";
		$text['rels'] = "Parentescos";
		$text['dospouses2'] = "Mostrar c�njuges";
		$text['fil'] = "sogro de";
		$text['mil'] = "sogra de";
		$text['fmil'] = "sogro/sogra de";
		$text['stepson'] = "enteado de";
		$text['stepdau'] = "enteada de";
		$text['stepchild'] = "enteado/enteada de";
		$text['stepgson'] = "xxx enteado de";
		$text['stepgdau'] = "xxx enteada de";
		$text['stepgchild'] = "xxx enteado/enteada de";
		//added in 8.1.1
		$text['ggreat'] = "grande";
		//added in 8.1.2
		$text['ggfath'] = "xxx grande av� de";
		$text['ggmoth'] = "xxx grande av� de";
		$text['ggpar'] = "xxx grande av�/av� de";
		$text['ggson'] = "xxx grande neto de";
		$text['ggdau'] = "xxx grande neta de";
		$text['ggsondau'] = "xxx grande neto/neta de";
		$text['gstepgson'] = "xxx grande enteado de";
		$text['gstepgdau'] = "xxx grande enteada de";
		$text['gstepgchild'] = "xxx grande enteado/enteada de";
		$text['guncle'] = "tio xxx grande de";
		$text['gaunt'] = "tia xxx grande de";
		$text['guncleaunt'] = "tio/tia xxx grande de";
		$text['gnephew'] = "xxx grande sobrinho de";
		$text['gniece'] = "xxx grande sobrinha de";
		$text['gnephnc'] = "xxx grande sobrinho/sobrinha de";
		//added in 14.0
		$text['pathscalc'] = "Buscar parentscos";
		$text['findrel2'] = "inclui parentes n�o-consangu�neos";
		$text['makeme2nd'] = "Usar meu ID";
		$text['usebookmarks'] = "Usar marcadores";
		$text['select2inds'] = "Selecione duas pessoas.";
		$text['indinfofor'] = "Informa��es pessoais para";
		$text['nobookmarks'] = "N�o h� marcador para usar";
		$text['bkmtitle'] = "Pessoas encontradas em marcadores";
		$text['bkminfo'] = "Selecionar a pessoa:";
		$text['sortpathsby'] = "Classificar caminhos por n�mero de";
		$text['sortbyshort'] = "Classificar por";
		$text['bylengthshort'] = "Comprimento";
		$text['badID1'] = ": ID da pessoa1 inv�lido - volte e corrija";
		$text['badID2'] = ": ID da pessoa2 inv�lido - volte e corrija";
		$text['notintree'] = ": a pessoa com este ID n�o est� na �rvore atual.";
		$text['sameperson'] = "Os dois indiv�duos s�o a mesma pessoa.";;
		$text['nopaths'] = "Estas pessoas n�o t�m parentesco.";
		$text['nopaths1'] = "N�o h� outros parentescos de comprimento menor que xxx";
		$text['nopaths2'] = "em xxx passos de busca";
		$text['longestpath'] = "(o caminho mais longo verificado at� agora tem xxx passos)";
		$text['relevantpaths'] = "N�mero de diferentes caminhos relevantes encontrados: xxx";
		$text['skipMarr'] = "(al�m disso, o n�mero de caminhos encontrados mas n�o exibidos devido a n�mero excessivo de casamentos �: xxx)";
		$text['mjaor'] = "ou";
		$text['connectionsto'] = "Parentescos com ";
		$text['findanotherpers'] = "Buscar outra pessoa...";
		$text['sometimes'] = "(�s vezes, verificar um n�mero diferente de gera��es produz um resultado diferente.)";
		$text['anotherpath'] = "Busca avan�ada de parentescos";
		$text['xpath'] = "Caminho ";
		$text['primary'] = "Pessoa inicial"; // note: used for both Start and End if text['fin'] not set
		$text['secondary'] = "Pessoa final";
		$text['parent'] = "Pai/m�e";
		$text['mhfather'] = "seu pai";
		$text['mhmother'] = "sua m�e";
		$text['mhhusband'] = "seu marido";
		$text['mhwife'] = "sua esposa";
		$text['mhson'] = "seu filho";
		$text['mhdaughter'] = "sua filha";
		$text['fhfather'] = "seu pai";
		$text['fhmother'] = "sua m�e";
		$text['fhhusband'] = "seu marido";
		$text['fhwife'] = "sua esposa";
		$text['fhson'] = "seu filho";
		$text['fhdaughter'] = "sua filha";
		$text['hfather'] = "pai";
		$text['hmother'] = "m�e";
		$text['hhusband'] = "marido";
		$text['hwife'] = "esposa";
		$text['hson'] = "filho";
		$text['hdaughter'] = "filha";
		$text['maxruns'] = "N�mero m�ximo de caminhos por verificar";
		$text['maxrshort'] = "N� m�ximo de caminhos";
		$text['maxlength'] = "Caminhos de relacionamento n�o maiores que";
		$text['maxlshort'] = "Comprimento m�ximo";
		$text['xstep'] = "passo";
		$text['xsteps'] = "passos";
		$text['xmarriages'] = "xxx casamentos";
		$text['xmarriage'] = "1 casamento";
		$text['showspouses'] = "Mostrar ambos os c�njuges";
		$text['showTxt'] = "Mostrar descri��o textual do caminho";
		$text['showTxtshort'] = "Descri��o textual";
		$text['compactBox'] = "Compactar os ret�ngulos de indiv�duo";
		$text['compactBoxshort'] = "Ret�ngulos compactados";
		$text['paths'] = "Caminhos";
		$text['dospouses2'] = "Mostrar c�njuges";
		$text['maxmopt'] = "N�mero m�ximo de casamentos por parentesco";
		$text['maxm'] = "Max casamentos";
		$text['arerelated'] = "Estas pessoas t�m parentesco consangu�neo - seu relacionamento � mostrado no caminho 1";
		$text['simplerel'] = "Busca simples de parentescos";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Ficha familiar para ";
		$text['ldsords'] = "Informa��es SUD";
		$text['endowedlds'] = "Investidura (SUD)";
		$text['sealedplds'] = "Selamento aos pais (SUD)";
		$text['sealedslds'] = "Selamento ao c�njuge (SUD)";
		$text['otherspouse'] = "Outros c�njuges";
		$text['husband'] = "Marido";
		$text['wife'] = "Mulher";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "NASC";
		$text['capaltbirthabbr'] = "EM";
		$text['capdeathabbr'] = "FAL";
		$text['capburialabbr'] = "SEPUL";
		$text['capplaceabbr'] = "EM";
		$text['capmarrabbr'] = "CAS";
		$text['capspouseabbr'] = "ESP";
		$text['redraw'] = "Reapresentar com ";
		$text['unknownlit'] = "Desconhecido";
		$text['popupnote1'] = " = Informa��o adicional";
		$text['pedcompact'] = "Compacta";
		$text['pedstandard'] = "Padr�o";
		$text['pedtextonly'] = "Textual";
		$text['descendfor'] = "Descendentes de ";
		$text['maxof'] = "Mostrar no m�ximo";
		$text['gensatonce'] = "gera��es.";
		$text['sonof'] = "Filho de ";
		$text['daughterof'] = "Filha de ";
		$text['childof'] = "Filho(a) de ";
		$text['stdformat'] = "Formato padr�o";
		$text['ahnentafel'] = "�rvore de costado (Ahnentafel)";
		$text['addnewfam'] = "Adicionar nova fam�lia";
		$text['editfam'] = "Alterar fam�lia";
		$text['side'] = "(lado dos)";
		$text['familyof'] = "Fam�lia de ";
		$text['paternal'] = "lado paterno";
		$text['maternal'] = "lado materno";
		$text['gen1'] = "Pr�prio";
		$text['gen2'] = "Pais";
		$text['gen3'] = "Av�s 4";
		$text['gen4'] = "Bisav�s 8";
		$text['gen5'] = "Trisav�s 16";
		$text['gen6'] = "Tetrav�s 32";
		$text['gen7'] = "Pentav�s 64";
		$text['gen8'] = "Hexav�s 128";
		$text['gen9'] = "Heptav�s 256";
		$text['gen10'] = "Octav�s 512";
		$text['gen11'] = "Nonav�s 1024";
		$text['gen12'] = "Decav�s 2048";
		$text['graphdesc'] = "Representa��o gr�fica dos descendentes";
		$text['pedbox'] = "Completa";
		$text['regformat'] = "Formato de Registro";
		$text['extrasexpl'] = "Se houver textos ou fotos para estas pessoas, os �cones correspondentes aparecer�o junto aos seus nomes.";
		$text['popupnote3'] = " = Novo gr�fico";
		$text['mediaavail'] = "M�dia dispon�vel";
		$text['pedigreefor'] = "Diagrama de Pedigree para";
		$text['pedigreech'] = "Diagrama de  Pedigree";
		$text['datesloc'] = "Datas e Lugares";
		$text['borchr'] = "Nasc/Bat � Falec/Sepult (dois)";
		$text['nobd'] = "Sem datas de nascimento ou falecimento";
		$text['bcdb'] = " Nasc/Bat/Falec/Sepult (quatro)";
		$text['numsys'] = "Sistema de numera��o";
		$text['gennums'] = "N�meros de Gera��o";
		$text['henrynums'] = "N�meros Henry";
		$text['abovnums'] = " N�meros d'Aboville";
		$text['devnums'] = " N�meros de Villiers";
		$text['dispopts'] = "Op��es de Exibi��o";
		//added in 10.0.0
		$text['no_ancestors'] = "Sem ancestrais";
		$text['ancestor_chart'] = "Diagrama vertical de ancestrais";
		$text['opennewwindow'] = "Abrir em nova janela";
		$text['pedvertical'] = "Vertical";
		//added in 11.0.0
		$text['familywith'] = "Fam�lia com";
		$text['fcmlogin'] = "Por favor fa�a login para ver mais detalhes";
		$text['isthe'] = "� o";
		$text['otherspouses'] = "outras esposas";
		$text['parentfamily'] = "A fam�lia dos pais � ";
		$text['showfamily'] = "Mostrar a fam�lia";
		$text['shown'] = "mostrado";
		$text['showparentfamily'] = "mostrar fam�lia dos pais";
		$text['showperson'] = "mostrar pessoa";
		//added in 11.0.2
		$text['otherfamilies'] = "Outras fam�lias";
		//added in 14.0
		$text['dtformat'] = "Tabelas";
		$text['dtchildren'] = "Filhos";
		$text['dtgrandchildren'] = "Netos";
		$text['dtggrandchildren'] = "Bisnetos";
		$text['dtgggrandchildren'] = "netos"; //For 2x great grandchildren, 3x great grandchildren, etc. Usually different in Scandinavian languages
		$text['dtnodescendants'] = "Sem descendentes";
		$text['dtgen'] = "Ger";
		$text['dttotal'] = "Total";
		$text['dtselect'] = "Selecionar";
		$text['dteachfulltable'] = "Cada tabela completa ter�";
		$text['dtrows'] = "linhas";
		$text['dtdisplayingtable'] = "Exibindo tabela";
		$text['dtgototable'] = "Ir para tabela:";
		$text['fcinstrdn'] = "Mostrar fam�lia com c�njuge";
		$text['fcinstrup'] = "Mostrar fam�lia com os pais";
		$text['fcinstrplus'] = "Selecione outros c�njuges";
		$text['fcinstrfam'] = "Selecione outros pais";
		//added in 15.0
		$text['nofamily'] = "N�o h� fam�lia conhecida para este indiv�duo";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "N�o h� relat�rios.";
		$text['reportname'] = "Nome do relat�rio";
		$text['allreports'] = "Todos os relat�rios";
		$text['report'] = "Relat�rio";
		$text['error'] = "Erro";
		$text['reportsyntax'] = "A sintaxe da consulta referente a este relat�rio �";
		$text['wasincorrect'] = "inv�lida. O relat�rio n�o pode ser criado. Por favor, comunique ao respons�vel pelo sistema";
		$text['errormessage'] = "Mensagem de erro";
		$text['equals'] = "igual a";
		$text['endswith'] = "termina com";
		$text['soundexof'] = "soundex de";
		$text['metaphoneof'] = "metafon de";
		$text['plusminus10'] = "+/- 10 anos de";
		$text['lessthan'] = "menor que";
		$text['greaterthan'] = "maior que";
		$text['lessthanequal'] = "menor ou igual a";
		$text['greaterthanequal'] = "maior ou igual a";
		$text['equalto'] = "� igual";
		$text['tryagain'] = "Por favor tente novamente";
		$text['joinwith'] = "Conector l�gico";
		$text['cap_and'] = "E";
		$text['cap_or'] = "OU";
		$text['showspouse'] = "Mostrar c�njuge; em caso de v�rios c�njuges, ser�o mostradas duplicatas";
		$text['submitquery'] = "Buscar";
		$text['birthplace'] = "Lugar de nascimento";
		$text['deathplace'] = "Lugar de falecimento";
		$text['birthdatetr'] = "Ano de nascimento";
		$text['deathdatetr'] = "Ano de falecimento";
		$text['plusminus2'] = "+/- 2 anos";
		$text['resetall'] = "Limpar todos os valores";
		$text['showdeath'] = "Mostrar informa��es de falecimento/sepultamento";
		$text['altbirthplace'] = "Lugar do batismo";
		$text['altbirthdatetr'] = "Ano do batismo";
		$text['burialplace'] = "Lugar do sepultamento";
		$text['burialdatetr'] = "Ano de sepultamento";
		$text['event'] = "Evento(s)";
		$text['day'] = "Dia";
		$text['month'] = "M�s";
		$text['keyword'] = "Palavra chave (p.ex.: \"ABT\", \"BEF\", \"AFT\")";
		$text['explain'] = "Escrever data (ou parte dela) para obter eventos correspondentes. Deixar em branco para obter todas.";
		$text['enterdate'] = "Favor fornecer ou selecionar ao menos: dia, m�s, ano ou palavra chave";
		$text['fullname'] = "Nome completo";
		$text['birthdate'] = "Data do nascimento";
		$text['altbirthdate'] = "Data do batismo";
		$text['marrdate'] = "Data do casamento";
		$text['spouseid'] = "ID do c�njuge";
		$text['spousename'] = "Nome do c�njuge";
		$text['deathdate'] = "Data do falecimento";
		$text['burialdate'] = "Data do sepultamento";
		$text['changedate'] = "Data da �ltima altera��o";
		$text['gedcom'] = "�rvore";
		$text['baptdate'] = "Data do batismo (SUD)";
		$text['baptplace'] = "Lugar do batismo (SUD)";
		$text['endldate'] = "Data da Investidura (SUD)";
		$text['endlplace'] = "Lugar da Investidura (SUD)";
		$text['ssealdate'] = "Data do Selamento ao C�njuge (SUD)";   //Sealed to spouse
		$text['ssealplace'] = "Lugar do Selamento ao C�njuge (SUD)";
		$text['psealdate'] = "Data do Selamento aos Pais (SUD)";   //Sealed to parents
		$text['psealplace'] = "Lugar do Selamento aos Pais (SUD)";
		$text['marrplace'] = "Lugar do Casamento";
		$text['spousesurname'] = "Sobrenome do c�njuge";
		$text['spousemore'] = "Se voc� preencher o sobrenome do c�njuge, dever� preencher ao menos um outro campo.";
		$text['plusminus5'] = "+/- 5 anos de agora";
		$text['exists'] = "existe";
		$text['dnexist'] = "n�o existe";
		$text['divdate'] = "Data de div�rcio";
		$text['divplace'] = "Lugar de div�rcio";
		$text['otherevents'] = "Outros atributos/eventos";
		$text['numresults'] = "Resultados por P�gina";
		$text['mysphoto'] = "Fotos Procuradas";
		$text['mysperson'] = "Pessoas Procuradas";
		$text['joinor'] = "A op��o 'Jun��o com OU' n�o pode ser usada com o Sobrenome da Esposa";
		$text['tellus'] = "Nos informe o que voc� sabe";
		$text['moreinfo'] = "Mais Informa��es:";
		//added in 8.0.0
		$text['marrdatetr'] = "Ano do casamento";
		$text['divdatetr'] = "Ano do div�rcio";
		$text['mothername'] = "Nome da m�e";
		$text['fathername'] = "Nome do pai";
		$text['filter'] = "Filtro";
		$text['notliving'] = "Falecido";
		$text['nodayevents'] = "Eventos deste m�s que n�o est�o associados a dias espec�ficos";
		//added in 9.0.0
		$text['csv'] = "Arquivo CSV";
		//added in 10.0.0
		$text['confdate'] = "Data de confirma��o - SUD";
		$text['confplace'] = "Local de confirma��o - SUD";
		$text['initdate'] = "Data de inicia��o - SUD";
		$text['initplace'] = "Local de inicia��o - SUD";
		//added in 11.0.0
		$text['marrtype'] = "Tipo de casamento";
		$text['searchfor'] = "Buscar por";
		$text['searchnote'] = "Observa��o: Esta busca � realizada usando o Google. O n�mero de respostas depende da quantidade de p�ginas do s�tio que foram indexadas pelo Google.";
		//added in 15.0
		$text['livingonly'] = "Somente vivo";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Arquivo de log para";
		$text['mostrecentactions'] = "a��es mais recentes";
		$text['autorefresh'] = "atualiza��o autom�tica (a cada 30 segundos)";
		$text['refreshoff'] = "desligar a atualiza��o autom�tica";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cemit�rios e L�pides";
		$text['showallhsr'] = "Mostrar todas l�pides";
		$text['in'] = "em";
		$text['showmap'] = "Mostrar mapa";
		$text['headstonefor'] = "L�pide de";
		$text['photoof'] = "Fotografia de  ";
		$text['photoowner'] = "Propriet�rio do original";
		$text['nocemetery'] = "Sem cemit�rio";
		$text['iptc005'] = "T�tulo";
		$text['iptc020'] = "Categorias adicionais";
		$text['iptc040'] = "Instru��es especiais";
		$text['iptc055'] = "Data de cria��o";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Fun��o do autor";
		$text['iptc090'] = "Cidade";
		$text['iptc095'] = "Estado";
		$text['iptc101'] = "Pa�s";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Cabe�alho";
		$text['iptc110'] = "Fonte";
		$text['iptc115'] = "Fonte das Fotografias";
		$text['iptc116'] = "Direitos autorais";
		$text['iptc120'] = "Legenda";
		$text['iptc122'] = "Autor da legenda";
		$text['mapof'] = "Mapa de ";
		$text['regphotos'] = "Vis�o com miniaturas e texto";
		$text['gallery'] = "Ver galeria";
		$text['cemphotos'] = "Fotos de cemit�rios";
		$text['photosize'] = "Tamanho";
        $text['iptc010'] = "Prioridade";
		$text['filesize'] = "Tamanho do arquivo";
		$text['seeloc'] = "Ver localiza��o";
		$text['showall'] = "Mostrar tudo";
		$text['editmedia'] = "Editar m�dia";
		$text['viewitem'] = "Ver este item";
		$text['editcem'] = "Editar Cemit�rio";
		$text['numitems'] = "# �tens";
		$text['allalbums'] = "Todos os �lbuns";
		$text['slidestop'] = "Suspender a apresenta��o";
		$text['slideresume'] = "Reiniciar a apresenta��o";
		$text['slidesecs'] = "Segundos por slide:";
		$text['minussecs'] = "menos 0,5 segundos";
		$text['plussecs'] = "mais 0,5 segundos";
		$text['nocountry'] = "Pa�s desconhecido";
		$text['nostate'] = "Estado desconhecido";
		$text['nocounty'] = "Condado desconhecido";
		$text['nocity'] = "Cidade desconhecida";
		$text['nocemname'] = "Nome de cemit�rio desconhecido";
		$text['editalbum'] = "Editar �lbum";
		$text['mediamaptext'] = "<strong>Nota:</strong> Mova o ponteiro do mouse sobre a imagem para mostrar nomes. Clique para ver a p�gina correspondente ao nome.";
		//added in 8.0.0
		$text['allburials'] = "Todos os sepultamentos";
		$text['moreinfo'] = "Mais Informa��es:";
		//added in 9.0.0
        $text['iptc025'] = "Palavras chave";
        $text['iptc092'] = "Sub-local";
		$text['iptc015'] = "Categoria";
		$text['iptc065'] = "Programa de origem";
		$text['iptc070'] = "Vers�o do programa";
		//added in 13.0
		$text['toggletags'] = "Alternar R�tulos";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places":
		$text['surnamesstarting'] = "Mostrar sobrenomes que come�am com a letra";
		$text['showtop'] = "Mostrar os primeiros ";
		$text['showallsurnames'] = "Mostrar todos sobrenomes";
		$text['sortedalpha'] = "em ordem alfab�tica";
		$text['byoccurrence'] = "em ordem de ocorr�ncia";
		$text['firstchars'] = "Primeiras letras";
		$text['mainsurnamepage'] = "P�gina inicial de sobrenomes";
		$text['allsurnames'] = "Todos sobrenomes";
		$text['showmatchingsurnames'] = "Clique no sobrenome para obter mais informa��es";
		$text['backtotop'] = "Para o topo";
		$text['beginswith'] = "Inicia com";
		$text['allbeginningwith'] = "Todas fam�lias que come�am com a letra";
		$text['numoccurrences'] = "n�mero de ocorr�ncias entre par�nteses";
		$text['placesstarting'] = "Mostrar lugares que come�am com";
		$text['showmatchingplaces'] = "Clique em um nome para mostrar lugares menores. Clique na pequena lupa para mostrar pessoas no lugar.";
		$text['totalnames'] = "total de nomes";
		$text['showallplaces'] = "Mostrar os lugares mais abrangentes";
		$text['totalplaces'] = "no. de lugares";
		$text['mainplacepage'] = "P�gina das lugares mais abrangentes";
		$text['allplaces'] = "Todos lugares mais abrangentes";
		$text['placescont'] = "Mostrar todos lugares que cont�m ...";
		//changed in 8.0.0
		$text['top30'] = "xxx sobrenomes mais freq�entes";
		$text['top30places'] = "xxx maiores lugares";
		//added in 12.0.0
		$text['firstnamelist'] = "Lista de Prenomes";
		$text['firstnamesstarting'] = "Mostrar os prenomes come�ando com";
		$text['showallfirstnames'] = "Mostrar todos os prenomes";
		$text['mainfirstnamepage'] = "P�gina principal de prenomes";
		$text['allfirstnames'] = "Todos Prenomes";
		$text['showmatchingfirstnames'] = "Clique em um prenome para mostrar registros correspondentes.";
		$text['allfirstbegwith'] = "Todos os prenomes come�ando com";
		$text['top30first'] = "Primeiros xxx prenomes";
		$text['allothers'] = "Todos demais";
		$text['amongall'] = "(entre todos nomes)";
		$text['justtop'] = "Somente os primeiros xxx";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(�ltimos xx dias)";

		$text['photo'] = "Fotografias";
		$text['history'] = "Hist�rias/Documentos";
		$text['husbid'] = " ID do Pai";
		$text['husbname'] = "Nome do Pai";
		$text['wifeid'] = " ID da M�e";
		//added in 11.0.0
		$text['wifename'] = "Mother's Name";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Excluir";
		$text['addperson'] = "Adicionar pessoa";
		$text['nobirth'] = "A pessoa que segue n�o tem data de nascimento (n�o � poss�vel adicion�-la � linha de tempo)";
		$text['event'] = "Evento(s)";
		$text['chartwidth'] = "Largura do diagrama";
		$text['timelineinstr'] = "Adicione at� quatro pessoas fornecendo seus IDs:";
		$text['togglelines'] = "Trocar linhas";
		//changed in 9.0.0
		$text['noliving'] = "A pessoa que segue est� viva. Por quest�es de privacidade n�o pode ser adicionada � linha de tempo";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Mostre todas �rvores";
		$text['treename'] = "Nome da �rvore";
		$text['owner'] = "Propriet�rio";
		$text['address'] = "Endere�o";
		$text['city'] = "Cidade";
		$text['state'] = "Estado";
		$text['zip'] = "CEP";
		$text['country'] = "Pa�s";
		$text['email'] = "E-mail";
		$text['phone'] = "Telefone";
		$text['username'] = "Usu�rio";
		$text['password'] = "Senha";
		$text['loginfailed'] = "O login falhou.";

		$text['regnewacct'] = "Solicitar registro como usu�rio";
		$text['realname'] = "Nome do usu�rio";
		$text['phone'] = "Telefone";
		$text['email'] = "E-mail";
		$text['address'] = "Endere�o";
		$text['acctcomments'] = "Notas ou coment�rios";
		$text['submit'] = "Submeter";
		$text['leaveblank'] = "(deixar em branco ao solicitar nova �rvore)";
		$text['required'] = "Campos obrigat�rios";
		$text['enterpassword'] = "Por favor forne�a uma senha.";
		$text['enterusername'] = "Por favor forne�a um usu�rio.";
		$text['failure'] = "Usu�rio j� utilizado. Favor voltar � p�gina anterior usando o bot�o voltar de seu browser e fornecer outro usu�rio.";
		$text['success'] = "Obrigado. Sua solicita��o de registro foi recebida corretamente. Entraremos em contato consigo.";
		$text['emailsubject'] = "Solicita��o de registro de novo usu�rio";
		$text['website'] = "P�gina Web (endere�o-WWW)";
		$text['nologin'] = "N�o possui senha?";
		$text['loginsent'] = "Sua informa��o de usu�rio foi enviada";
		$text['loginnotsent'] = "A informa��o de usu�rio n�o foi enviada";
		$text['enterrealname'] = "Favor informar o seu nome.";
		$text['rempass'] = "Permane�a logado neste computador";
		$text['morestats'] = "Mais estat�sticas";
		$text['accmail'] = "<strong>NOTA:</strong> Para garantir que voc� receba e-mail do administrador deste site relativo a sua conta, por favor, assegure-se que seu servidor de e-mail n�o est� bloqueando mensagens desta conta.";
		$text['newpassword'] = "Nova senha";
		$text['resetpass'] = "Criar nova senha";
		$text['nousers'] = "Este formul�rio n�o pode ser usado enquanto n�o existirem usu�rios registrados. Se voc� � o propriet�rios deste site, por favor crie a conta de usu�rios em Administra��o/Usu�rios.";
		$text['noregs'] = "Desculpe, mas n�o estamos aceitando novos usu�rios no momento. Por favor <a href=\"suggest.php\">contate-nos</a> diretamente se tiver coment�rios ou quest�es sobre este site.";
		$text['emailmsg'] = "Voc� recebeu um pedido de registro de usu�rio no TNG. Por favor fa�a as devidas autoriza��es como usu�rio administrador do TNG. Caso concorde com o registro, por favor comunique ao solicitante atrav�s deste e-mail.";
		$text['accactive'] = "A conta foi ativada, mas o usu�rio n�o ter� permiss�es especiais enquanto voc� n�o atribu�-las.";
		$text['accinactive'] = "V� para Administra��o/Usu�rios/Revis�o para acessar as propriedades da conta. A conta permanecer� inativa at� que voc� a edite e salvar ao menos uma vez.";
		$text['pwdagain'] = "Repeti��o da senha";
		$text['enterpassword2'] = "Favor entrar com a senha novamente.";
		$text['pwdsmatch'] = "Senhas diferentes. Favor entrar com a mesma senha em ambos campos.";
		$text['acksubject'] = "Obrigado pelo registro"; //for a new user account
		$text['ackmessage'] = "Sua solicita��o de uma conta de usu�rio foi recebida. Sua conta permanecer� inativa at� que seja revista pelo administrador do s�tio. Voc� ser� notificado por e-mail, t�o logo a solicita��o seja aprovada.";
		//added in 12.0.0
		$text['switch'] = "Chavear";
		//added in 14.0
		$text['newpassword2'] = "Repetir nova senha";
		$text['resetsuccess'] = "Sucesso: a senha foi redefinida";
		$text['resetfail'] = "Falha: Senha n�o redefinida";
		$text['failreason0'] = " (erro desconhecido de banco de dados)";
		$text['failreason2'] = " (voc� n�o tem permiss�o para alterar sua senha)";
		$text['failreason3'] = " (as senhas n�o correspondem)";
		break;

	//added in 10.0.0
	case "branches":
		$text['browseallbranches'] = "Varrer todos ramos";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Quantidade";
		$text['totindividuals'] = "Pessoas em geral";
		$text['totmales'] = "Homens";
		$text['totfemales'] = "Mulheres";
		$text['totunknown'] = "Sexo indeterminado";
		$text['totliving'] = "Vivos";
		$text['totfamilies'] = "Fam�lias";
		$text['totuniquesn'] = "Nomes diferentes";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Fontes";
		$text['avglifespan'] = "Tempo m�dio de vida";
		$text['earliestbirth'] = "Nascimento mais antigo";
		$text['longestlived'] = "Mais longevo";
		$text['days'] = "dias";
		$text['age'] = "Idade";
		$text['agedisclaimer'] = "C�lculos relacionados � idade baseiam-se nas pessoas com data de nascimento e data de falecimento registradas. Pelo preenchimento incompleto deste campos (por exemplo, \"1945\" ou \"antes de 1860\") estes c�lculos podem n�o estar 100% corretos.";
		$text['treedetail'] = "Mais informa��es sobre esta �rvore";
		$text['total'] = "Total de";
		//added in 12.0
		$text['totdeceased'] = "Total de Falecidos";
		//added in 14.0
		$text['totalsourcecitations'] = "Total de cita��es de fontes";
		break;

	case "notes":
		$text['browseallnotes'] = "Percorrer todas notas";
		break;

	case "help":
		$text['menuhelp'] = "Significado dos �cones no menu";
		break;

	case "install":
		$text['perms'] = "Permiss�es foram atribu�das.";
		$text['noperms'] = "Permiss�es para estes arquivos n�o puderam ser atribu�das:";
		$text['manual'] = "Por favor, atribua-as manualmente.";
		$text['folder'] = "Pasta";
		$text['created'] = "foi criada";
		$text['nocreate'] = "n�o pode ser criada. Favor criar manualmente.";
		$text['infosaved'] = "Informa��o salva, conex�o verficada!";
		$text['tablescr'] = "As tabelas foram criadas!";
		$text['notables'] = "As tabelas a seguir n�o puderam ser criadas:";
		$text['nocomm'] = "TNG n�o est� comunicando com o servirdor de base de dados. As tabelas n�o foram criadas.";
		$text['newdb'] = "Informa��o salva, conex�o verficada, novo base de dados criado:";
		$text['noattach'] = "Informa��o salva. Conex�o feita, base de dados criada, mas TNG n�o consegue acess�-la.";
		$text['nodb'] = "Informa��o salva. Conex�o feita, mas a base de dados n�o existe e n�o pode ser criada. Favor verficar o nome da base de dados ou usar seu painel de controle para cri�-la.";
		$text['noconn'] = "Informa��o salva mas conex�o falhou. Uma ou mais dos seguintes est�o incorretos:";
		$text['exists'] = "existe";
		$text['noop'] = "Nenhuma a��o foi executada.";
		//added in 8.0.0
		$text['nouser'] = "O usu�rio n�o foi criado. Nome de usu�rio j� existente.";
		$text['notree'] = "A �rvore n�o foi criada. ID da �rvore j� existente.";
		$text['infosaved2'] = "Informa��o salva";
		$text['renamedto'] = "renomeada para";
		$text['norename'] = "n�o pode ser renomeada";
		//changed in 13.0.0
		$text['loginfirst'] = "Foram detectados registros de usu�rio pr�-existentes. Para prosseguir, fa�a login primeiro ou remova todos registros da tabela de usu�rios.";
		break;

	case "imgviewer":
		$text['magmode'] = "Modo de amplia��o";
		$text['panmode'] = "Modo de varredura";
		$text['pan'] = "Clique e arraste para mover dentro da imagem";
		$text['fitwidth'] = "Ajustar largura";
		$text['fitheight'] = "Ajustar altura";
		$text['newwin'] = "Nova janela";
		$text['opennw'] = "Abrir a imagem em uma nova janela";
		$text['magnifyreg'] = "Clique para magnificar uma parte da imagem";
		$text['imgctrls'] = "Habilitar controles da imagem";
		$text['vwrctrls'] = "Habilitar controles do visualizador de imagem";
		$text['vwrclose'] = "Fechar o visualizador de imagem";

		//added in 15.0
		$text['showtags'] = "Mostrar r�tulos";
		$text['toggletagsmsg'] = "Clique para alternar";
		break;

	case "dna":
		$text['test_date'] = "Data do teste";
		$text['links'] = "Links relevantes";
		$text['testid'] = "ID do teste";
		//added in 12.0.0
		$text['mode_values'] = "Valores de Modo";
		$text['compareselected'] = "Comparar os Selecionados";
		$text['dnatestscompare'] = "Comparar Testes de Y-DNA";
		$text['keep_name_private'] = "Manter o Nome Privado";
		$text['browsealltests'] = "Procurar todos os testes";
		$text['all_dna_tests'] = "Todos os testes de DNA";
		$text['fastmutating'] = "Muta��o R�pida";
		$text['alltypes'] = "Todos os Tipos";
		$text['allgroups'] = "Todos os Grupos";
		$text['Ydna_LITbox_info'] = "Os testes vinculados a esta pessoa n�o foram necessariamente feitos por esta pessoa. <br /> A coluna 'Haplogrupo' exibe dados em vermelho se o resultado for 'Previsto', e em verde se o teste for 'Confirmado'";
		//added in 12.1.0
		$text['dnatestscompare_mtdna'] = "Comparar testes mtDNA";
		$text['dnatestscompare_atdna'] = "Comparar testes atDNA";
		$text['chromosome'] = "Chr";
		$text['centiMorgans'] = "cM";
		$text['snps'] = "SNPs";
		$text['y_haplogroup'] = "Y-DNA";
		$text['mt_haplogroup'] = "mtDNA";
		$text['sequence'] = "Ref";
		$text['extra_mutations'] = "Muta��es extra";
		$text['mrca'] = "Ancestral MRC";
		$text['ydna_test'] = "Testes Y-DNA";
		$text['mtdna_test'] = "Testes mtDNA (mitocondriais)";
		$text['atdna_test'] = "Testes atDNA (autos�micos)";
		$text['segment_start'] = "In�cio";
		$text['segment_end'] = "Fim";
		$text['suggested_relationship'] = "Sugerido";
		$text['actual_relationship'] = "Real";
		$text['12markers'] = "Marcadores 1-12";
		$text['25markers'] = "Marcadores 13-25";
		$text['37markers'] = "Marcadores 26-37";
		$text['67markers'] = "Marcadores 38-67";
		$text['111markers'] = "Marcadores 68-111";
		//added in 13.1
		$text['comparemore'] = "Ao menos dois testes devem ser selecionados para comparar.";
		break;
}

//common
$text['matches'] = "Resultados";
$text['description'] = "Descri��o";
$text['notes'] = "Notas";
$text['status'] = "Status";
$text['newsearch'] = "Nova consulta";
$text['pedigree'] = "�rvore geneal�gica";
$text['seephoto'] = "Veja foto";
$text['andlocation'] = "& lugar";
$text['accessedby'] = "acessado por";
$text['children'] = "Filhos(as)";  //from getperson
$text['tree'] = "�rvore";
$text['alltrees'] = "Todas as �rvores";
$text['nosurname'] = "[sem sobrenome]";
$text['thumb'] = "Miniatura";  //as in Thumbnail
$text['people'] = "Pessoas";
$text['title'] = "T�tulo";  //from getperson
$text['suffix'] = "Sufixo";  //from getperson
$text['nickname'] = "Apelido";  //from getperson
$text['lastmodified'] = "�ltima altera��o";  //from getperson
$text['married'] = "Casamento";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Nome"; //from showmap
$text['lastfirst'] = "Sobrenome, prenome";  //from search
$text['bornchr'] = "Nascimento/Batismo";  //from search
$text['individuals'] = "Pessoas";  //from whats new
$text['families'] = "Fam�lias";
$text['personid'] = "ID da pessoa";
$text['sources'] = "Fontes";  //from getperson (next several)
$text['unknown'] = "desconhecido";
$text['father'] = "Pai";
$text['mother'] = "M�e";
$text['christened'] = "Batismo";
$text['died'] = "Falecimento";
$text['buried'] = "Sepultamento";
$text['spouse'] = "C�njuge";  //from search
$text['parents'] = "Pais";  //from pedigree
$text['text'] = "Texto";  //from sources
$text['language'] = "L�ngua";  //from languages
$text['descendchart'] = "Descendentes";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Pessoa";
$text['edit'] = "Editar";
$text['date'] = "Data";
$text['login'] = "Entrar";
$text['logout'] = "Sair";
$text['groupsheet'] = "Ficha familiar";
$text['text_and'] = "e";
$text['generation'] = "Gera��o";
$text['filename'] = "Nome de arquivo";
$text['id'] = "ID";
$text['search'] = "Buscar";
$text['user'] = "Usu�rio";
$text['firstname'] = "Prenome";
$text['lastname'] = "Sobrenome";
$text['searchresults'] = "Resultado da busca";
$text['diedburied'] = "Falecido";
$text['homepage'] = "In�cio";
$text['find'] = "Buscar...";
$text['relationship'] = "Parentesco";		//in German, Verwandtschaft
$text['relationship2'] = "Parentesco"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Linha de tempo";
$text['yesabbr'] = "S";               //abbreviation for 'yes'
$text['divorced'] = "Div�rcio";
$text['indlinked'] = "Ligado a";
$text['branch'] = "Ramo";
$text['moreind'] = "Mais pessoas";
$text['morefam'] = "Mais fam�lias";
$text['surnamelist'] = "Lista de sobrenomes";
$text['generations'] = "Gera��es";
$text['refresh'] = "Atualizar";
$text['whatsnew'] = "Recentes";
$text['reports'] = "Relat�rio";
$text['placelist'] = "Lista de lugares";
$text['baptizedlds'] = "Batismo (SUD)";
$text['endowedlds'] = "Investidura (SUD)";
$text['sealedplds'] = "Selamento aos pais (SUD)";
$text['sealedslds'] = "Selamento ao c�njuge (SUD)";
$text['ancestors'] = "Ancestrais";
$text['descendants'] = "Descendentes";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data da �ltima importa��o de GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Salvar";
$text['familyid'] = "ID da fam�lia";
$text['headstone'] = "L�pides";
$text['historiesdocs'] = "Hist�rias e Documentos";
$text['anonymous'] = "an�nimo";
$text['places'] = "Lugares";
$text['anniversaries'] = "Datas e anivers�rios";
$text['administration'] = "Administra��o";
$text['help'] = "Ajuda";
//$text['documents'] = "Documents";
$text['year'] = "Ano";
$text['all'] = "Todos";
$text['address'] = "Endere�o";
$text['suggest'] = "Sugest�o de altera��o";
$text['editevent'] = "Sugest�o de altera��o deste evento";
$text['morelinks'] = "Mais v�nculos";
$text['faminfo'] = "Dados da fam�lia";
$text['persinfo'] = "Dados da pessoa";
$text['srcinfo'] = "Dados da fonte";
$text['fact'] = "Fato";
$text['goto'] = "Selecione uma p�gina";
$text['tngprint'] = "Imprimir";
$text['databasestatistics'] = "Estat�sticas"; //needed to be shorter to fit on menu
$text['child'] = "Filho(a)";  //from familygroup
$text['repoinfo'] = "Informa��o do local de arquivamento";
$text['tng_reset'] = "Limpar";
$text['noresults'] = "Resultado vazio";
$text['allmedia'] = "Todas as m�dia";
$text['repositories'] = "Reposit�rios";
$text['albums'] = "�lbuns";
$text['cemeteries'] = "Cemit�rios";
$text['surnames'] = "Sobrenomes";
$text['link'] = "Link";
$text['media'] = "M�dia";
$text['gender'] = "Sexo";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmark'] = "Adicionar marcador";
$text['mngbookmarks'] = "Ir para Marcadores";
$text['bookmarked'] = "Marcador Adicionado";
$text['remove'] = "Remover";
$text['find_menu'] = "Buscar";
$text['info'] = "Info"; //this needs to be a very short abbreviation
$text['cemetery'] = "Cemit�rios";
$text['gmapevent'] = "Mapa de eventos";
$text['gevents'] = "Evento";
$text['googleearthlink'] = "Link para Google Earth";
$text['googlemaplink'] = "Link para Google Maps";
$text['gmaplegend'] = "Legenda";
$text['unmarked'] = "N�o marcado";
$text['located'] = "Localizado";
$text['albclicksee'] = "Clicar para ver todos os itens do �lbum";
$text['notyetlocated'] = "Ainda n�o localizado";
$text['cremated'] = "Crema��o";
$text['missing'] = "Em falta";
$text['pdfgen'] = "Gerador de PDF";
$text['blank'] = "Diagrama Vazio";
$text['fonts'] = "Fontes";
$text['header'] = "Cabe�alho";
$text['data'] = "Dados";
$text['pgsetup'] = "Configura��o";
$text['pgsize'] = "Tamanho da Folha";
$text['orient'] = "Orienta��o"; //for a page
$text['portrait'] = "Retrato";
$text['landscape'] = "Paisagem";
$text['tmargin'] = " Margem Superior";
$text['bmargin'] = " Margem Inferior";
$text['lmargin'] = " Margem Esquerda";
$text['rmargin'] = " Margem Direita";
$text['createch'] = "Criar Diagrama";
$text['prefix'] = "Prefixo";
$text['mostwanted'] = "Mais Procurado";
$text['latupdates'] = "�ltimas altera��es";
$text['featphoto'] = "Foto do dia";
$text['news'] = "Novidades";
$text['ourhist'] = "A Nossa Hist�ria de Fam�lia";
$text['ourhistanc'] = "A Nossa Hist�ria de Fam�lia e Antepassados";
$text['ourpages'] = "As Nossas P�ginas de Genealogia da Fam�lia";
$text['pwrdby'] = "Este site � produzido com ";
$text['writby'] = "escrito por";
$text['searchtngnet'] = "Buscar em TNG Network (GENDEX)";
$text['viewphotos'] = "Ver todas as fotos";
$text['anon'] = "Voc� est� an�nimo";
$text['whichbranch'] = "De que ramo �?";
$text['featarts'] = "Artigos Detalhados";
$text['maintby'] = "Criado e gerenciado por";
$text['createdon'] = "Criado em";
$text['reliability'] = "Confiabilidade";
$text['labels'] = "R�tulos";
$text['inclsrcs'] = "Incluir Fontes";
$text['cont'] = "(cont.)"; //abbreviation for continued
$text['mnuheader'] = "P�gina Inicial";
$text['mnusearchfornames'] = "Buscar Pessoa";
$text['mnulastname'] = "Sobrenome";
$text['mnufirstname'] = "Prenome";
$text['mnusearch'] = "Buscar";
$text['mnureset'] = "Repetir";
$text['mnulogon'] = "Entrar";
$text['mnulogout'] = "Sair";
$text['mnufeatures'] = "Outras Atividades";
$text['mnuregister'] = "Registrar-se como Usu�rio";
$text['mnuadvancedsearch'] = "Busca avan�ada";
$text['mnulastnames'] = "Sobrenomes";
$text['mnustatistics'] = "Estat�stica";
$text['mnuphotos'] = "Fotos";
$text['mnuhistories'] = "Hist�rias";
$text['mnumyancestors'] = "Fotos &amp; Hist�rias dos ancestrais de [Person]";
$text['mnucemeteries'] = "Cemit�rios";
$text['mnutombstones'] = "L�pides";
$text['mnureports'] = "Relat�rios";
$text['mnusources'] = "Fontes";
$text['mnuwhatsnew'] = "Novidades";
$text['mnulanguage'] = "Mudar Idioma";
$text['mnuadmin'] = "P�gina da Administra��o";
$text['welcome'] = "Bem-vindo";
//changed in 8.0.0
$text['born'] = "Nascimento";
//added in 8.0.0
$text['editperson'] = "Editar pessoas";
$text['loadmap'] = "Carregar o mapa";
$text['birth'] = "Nascimento";
$text['wasborn'] = "nasceu em";
$text['startnum'] = "Primeiro n�mero";
$text['searching'] = "Buscando";
//moved here in 8.0.0
$text['location'] = "Localiza��o";
$text['association'] = "Relacionamento";
$text['collapse'] = "Diminuir representa��o";
$text['expand'] = "Aumentar representa��o";
$text['plot'] = "Sepultura";
//added in 8.0.2
$text['wasmarried'] = "casou com";
$text['anddied'] = "faleceu em";
//added in 9.0.0
$text['share'] = "Compartilhar";
$text['hide'] = "Ocultar";
$text['disabled'] = "Sua conta de usu�rio foi desabilitada. Favor contatar o administrador do site para informa��es.";
$text['contactus_long'] = "Se voc� tem quest�es ou coment�rios sobre as informa��es contidas neste site, por favor <span class=\"emphasis\"><a href=\"suggest.php\">contate-nos</a></span>. Esperamos sua mensagem.";
$text['features'] = "Artigos";
$text['resources'] = "Recursos";
$text['latestnews'] = "Novidades";
$text['trees'] = "�rvores";
$text['wasburied'] = "sepultado em";
//moved here in 9.0.0
$text['emailagain'] = "Repita o e-mail";
$text['enteremail2'] = "Favor entrar com seu e-mail novamente.";
$text['emailsmatch'] = "E-mails diferentes. Favor entrar com o mesmo e-mail em ambos campos.";
$text['getdirections'] = "Clique para obter caminho";
//changed in 9.0.0
$text['directionsto'] = " para ";
$text['slidestart'] = "Apresenta��o";
$text['livingnote'] = "Pessoa viva ou dados privativos - detalhes ocultos por raz�es de privacidade";
$text['livingphoto'] = "Ao menos uma pessoa viva est� ligada a esta foto - detalhes ocultos por raz�es de privacidade. ";
$text['waschristened'] = "batizado em";
//added in 10.0.0
$text['branches'] = "Ramos";
$text['detail'] = "Detalhe";
$text['moredetail'] = "Exibir detalhes";
$text['lessdetail'] = "Ocultar detalhes";
$text['conflds'] = "Confirma��o (SUD)";
$text['initlds'] = "Inicializa��o (SUD)";
$text['wascremated'] = "foi cremado";
//moved here in 11.0.0
$text['text_for'] = "para";
//added in 11.0.0
$text['searchsite'] = "Buscar neste s�tio";
$text['kmlfile'] = "Baixe um arquivo .kml para mostrar a localiza��o no Google Earth";
$text['download'] = "Clique para baixar";
$text['more'] = "Mais";
$text['heatmap'] = "Distribui��o no mapa";
$text['refreshmap'] = "Recarregar o mapa";
$text['remnums'] = "Limpar n�meros e �cones";
$text['photoshistories'] = "Fotografias &amp; Hist�rias";
$text['familychart'] = "Diagrama familiar";
//moved here in 12.0.0
$text['dna_test'] = "Teste de DNA";
$text['test_type'] = "Tipo de Teste";
$text['test_info'] = "Informa��o do Teste";
$text['takenby'] = "Indiv�duo Examinado";
$text['haplogroup'] = "Haplogrupo";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Liga��es relevantes";
$text['nofirstname'] = "[sem primeiro nome]";
//added in 12.0.1
$text['cookieuse'] = "Nota: este s�tio usa cookies.";
$text['dataprotect'] = "Pol�tica de Prote��o de Dados";
$text['viewpolicy'] = "Ver pol�tica";
$text['understand'] = "Eu entendo";
$text['consent'] = "Eu concedo autoriza��o para que este s�tio armazene os dados pessoais aqui fornecidos. Eu estou ciente de que posso solicitar a remo��o destes dados ao propriet�rio do s�tio, a qualquer tempo.";
$text['consentreq'] = "Por favor, d� seu consentimento para que este site armazene dados pessoais.";

//added in 12.1.0
$text['testsarelinked'] = "Testes de DNA est�o associados com";
$text['testislinked'] = "Teste de DNA est� associado com";

//added in 12.2
$text['quicklinks'] = "Links r�pidos";
$text['yourname'] = "Seu nome";
$text['youremail'] = "Seu endere�o de e-mail";
$text['liketoadd'] = "Qualquer informa��o que voc� gostaria de adicionar";
$text['webmastermsg'] = "Mensagem do webmaster";
$text['gallery'] = "Ver galeria";
$text['wasborn_male'] = "nasceu";  	// same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "nasceu"; 	// same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "foi batizado";	// same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "foi batizado";	// same as $text['waschristened'] if no gender verb
$text['died_male'] = "morreu";	// same as $text['anddied'] of no gender verb
$text['died_female'] = "morreu";	// same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "foi enterrado"; 	// same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "foi enterrado"; 	// same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "foi cremado";		// same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "foi cremado";	// same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "casado";	// same as $text['wasmarried'] if no gender verb
$text['wasmarried_female'] = "casado";	// same as $text['wasmarried'] if no gender verb
$text['wasdivorced_male'] = "divorciou-se";	// might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "divorciou-se";	// might be the same as $text['divorce'] but as a verb
$text['inplace'] = " em ";			// used as a preposition to the location
$text['onthisdate'] = " em ";		// when used with full date
$text['inthisyear'] = " em ";		// when used with year only or month / year dates
$text['and'] = "e ";				// used in conjunction with wasburied or was cremated

//moved here in 12.2.1
$text['dna_info_head'] = "Informa��o do Teste de DNA";
//added in 13.0
$text['visitor'] = "Visitante";

$text['popupnote2'] = " = Nova �rvore";

//moved here in 14.0
$text['zoomin'] = "Mais Zoom";
$text['zoomout'] = "Menos Zoom";
$text['scrollnote'] = "Observa��o: talvez seja necess�rio deslizar para a esquerda/direita ou para baixo para visualizar todo o diagrama.";
$text['general'] = "Geral";

//changed in 14.0
$text['otherevents'] = "Outros atributos/eventos";

//added in 14.0
$text['times'] = "-";
$text['connections'] = "Parentescos";
$text['continue'] = "Continuar";
$text['title2'] = "T�tulo"; //for media, sources, etc (not people)

//added in 15.0
$text['atsea'] = "Sepultado no mar";
$text['topsurnames'] = "Top Surnames";
$text['ourphotos'] = "Our Photos";

//moved here in 15.0
$text['greatoffset'] = "-1"; //Scandinavian languages should set this to 1 so counting starts a generation later

@include_once(dirname(__FILE__) . "/alltext.php");
if(empty($alltextloaded)) getAllTextPath();
?>