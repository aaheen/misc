<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Переглянути всі джерела";
		$text['shorttitle'] = "Коротка назва";
		$text['callnum'] = "Номер виклику";
		$text['author'] = "Автор";
		$text['publisher'] = "Видавець";
		$text['other'] = "Інше";
		$text['sourceid'] = "Ідентифікатор джерела";
		$text['moresrc'] = "Більше джерел";
		$text['repoid'] = "Ідентифікатор сховища";
		$text['browseallrepos'] = "Переглянути всі сховища";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Нова мова";
		$text['changelanguage'] = "Змінити мову";
		$text['languagesaved'] = "Мова збережена";
		$text['sitemaint'] = "Технічне обслуговування сайту триває";
		$text['standby'] = "Сайт тимчасово недоступний, поки ми оновлюємо нашу базу даних. Спробуйте ще раз через кілька хвилин. Якщо сайт не працює протягом тривалого періоду часу, <a href=\"suggest.php \">зв'язатися з власником сайту</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM починаючи з";
		$text['producegedfrom'] = "Створити файл GEDCOM з";
		$text['numgens'] = "Кількість поколінь";
		$text['includelds'] = "Включити інформацію LDS";
		$text['buildged'] = "Збірка GEDCOM";
		$text['gedstartfrom'] = "GEDCOM починаючи з";
		$text['nomaxgen'] = "Ви повинні вказати максимальну кількість поколінь. Скористайтеся кнопкою \"Назад\", щоб повернутися на попередню сторінку та виправити помилку";
		$text['gedcreatedfrom'] = "GEDCOM створено з";
		$text['gedcreatedfor'] = "створено для";
		$text['creategedfor'] = "Створити GEDCOM";
		$text['email'] = "Ваша електронна пошта";
		$text['suggestchange'] = "Запропонувати зміну";
		$text['yourname'] = "Ваше ім'я";
		$text['comments'] = "Опис<br />пропонованих змін";
		$text['comments2'] = "Коментарі";
		$text['submitsugg'] = "Надіслати пропозицію";
		$text['proposed'] = "Запропонована зміна";
		$text['mailsent'] = "Дякуємо. Ваше повідомлення надіслано.";
		$text['mailnotsent'] = "Нам шкода, але ваше повідомлення не може бути доставлено. Будь ласка, зв'яжіться безпосередньо з xxx за адресою yyy.";
		$text['mailme'] = "Надіслати копію на цю адресу";
		$text['entername'] = "Будь ласка, введіть своє ім'я";
		$text['entercomments'] = "Будь ласка, введіть свої коментарі";
		$text['sendmsg'] = "Надіслати повідомлення";
		//added in 9.0.0
		$text['subject'] = "Тема";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Фотографії та історії для";
		$text['indinfofor'] = "Індивідуальна інформація для";
		$text['pp'] = "pp."; //page abbreviation
		$text['age'] = "Вік";
		$text['agency'] = "Агентство";
		$text['cause'] = "Причина";
		$text['suggested'] = "Запропоновано";
		$text['closewindow'] = "Закрити вікно";
		$text['thanks'] = "Дякую";
		$text['received'] = "Вашу пропозицію було передано адміністратору сайту для розгляду.";
		$text['indreport'] = "Індивідуальний звіт";
		$text['indreportfor'] = "Індивідуальний звіт для";
		$text['bkmkvis'] = "<strong>Примітка:</strong> ці закладки відображаються лише на цьому комп'ютері та в цьому браузері.";
        //added in 9.0.0
		$text['reviewmsg'] = "У вас є запропонована зміна, яка потребує вашого перегляду. Це повідомлення стосується:";
        $text['revsubject'] = "Запропонована зміна потребує вашої перевірки";
        break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
	case "connections":
		$text['relcalc'] = "Калькулятор стосунків";
		$text['findrel'] = "Знайти зв'язок";
		$text['person1'] = "Особа 1:";
		$text['person2'] = "Особа 2:";
		$text['calculate'] = "Обчислити";
		$text['select2inds'] = "Будь ласка, виберіть двох осіб.";
		$text['findpersonid'] = "Знайти ідентифікатор особи";
		$text['enternamepart'] = "введіть частину імені та/або прізвища";
		$text['pleasenamepart'] = "Будь ласка, введіть частину імені або прізвища.";
		$text['clicktoselect'] = "натисніть, щоб вибрати";
		$text['nobirthinfo'] = "Немає інформації про народження";
		$text['relateto'] = "Зв'язок з";
		$text['sameperson'] = "Ці дві особи є однією особою.";
		$text['notrelated'] = "Дві особи не є спорідненими протягом xxx поколінь."; //xxx will be replaced with number of generations
		$text['findrelinstr'] = "Щоб відобразити зв'язок між двома людьми, скористайтеся кнопками \"\" нижче, щоб знайти осіб (або залишити їх відображеними), а потім натисніть \"Обчислити\".";
		$text['sometimes'] = "(Іноді перевірка різної кількості поколінь дає інший результат.)";
		$text['findanother'] = "Знайти інший зв'язок";
		$text['brother'] = "брат";
		$text['sister'] = "сестра";
		$text['sibling'] = "рідний брат";
		$text['uncle'] = "дядя xxx";
		$text['aunt'] = "xxx тітка";
		$text['uncleaunt'] = "дядя/тітка xxx";
		$text['nephew'] = "племінник xxx";
		$text['niece'] = "the xxx niece of";
		$text['nephnc'] = "племінник/племінниця xxx";
		$text['removed'] = "кількість видалень";
		$text['rhusband'] = "чоловік ";
		$text['rwife'] = "дружина ";
		$text['rspouse'] = "дружина ";
		$text['son'] = "син";
		$text['daughter'] = "дочка";
		$text['rchild'] = "нащадок";
		$text['sil'] = "зять";
		$text['dil'] = "невістка";
		$text['sdil'] = "зять або невістка";
		$text['gson'] = "онук xxx";
		$text['gdau'] = "ххх онука";
		$text['gsondau'] = "ххх онука";
		$text['great'] = "чудово";
		$text['spouses'] = "є подружжям";
		$text['is'] = "є";
		$text['changeto'] = "Змінити на (введіть ID):";
		$text['notvalid'] = "є недійсним ідентифікаційним номером особи або його немає в цій базі даних. Спробуйте ще раз.";
		$text['halfbrother'] = "зведений брат";
		$text['halfsister'] = "зведена сестра";
		$text['halfsibling'] = "зведений брат";
		//changed in 8.0.0
		$text['gencheck'] = "Максимальна кількість поколінь для перевірки";
		$text['mcousin'] = "xxx двоюрідний брат yyy";  //male cousin; xxx = cousin number, yyy = times removed
		$text['fcousin'] = "ххх двоюрідний брат yyy";  //female cousin
		$text['cousin'] = "двоюрідний брат xxx yyy";
		$text['mhalfcousin'] = "xxx напівкузен yyy";  //male cousin
		$text['fhalfcousin'] = "xxx напівкузен yyy";  //female cousin
		$text['halfcousin'] = "ххх напівкузен yyy";
		//added in 8.0.0
		$text['oneremoved'] = "один раз видалено";
		$text['gfath'] = "дідусь xxx";
		$text['gmoth'] = "бабуся xxx";
		$text['gpar'] = "бабуся та дідусь xxx";
		$text['mothof'] = "мати";
		$text['fathof'] = "батько";
		$text['parof'] = "батьківський";
		$text['maxrels'] = "Максимальна кількість зв'язків для показу";
		$text['dospouses'] = "Показати стосунки за участю подружжя";
		$text['rels'] = "Зв'язки";
		$text['dospouses2'] = "Показати подружжя";
		$text['fil'] = "тесть";
		$text['mil'] = "свекруха";
		$text['fmil'] = "тесть або свекруха";
		$text['stepson'] = "the stepson of";
		$text['stepdau'] = "падчерка";
		$text['stepchild'] = "пасинок";
		$text['stepgson'] = "xxx зведений онук";
		$text['stepgdau'] = "xxx прийомна онука";
		$text['stepgchild'] = "xxx прийомний онук";
		//added in 8.1.1
		$text['ggreat'] = "чудово";
		//added in 8.1.2
		$text['ggfath'] = "прадід xxx";
		$text['ggmoth'] = "прабабуся xxx";
		$text['ggpar'] = "прабабуся xxx";
		$text['ggson'] = "правнук xxx";
		$text['ggdau'] = "правнучка xxx";
		$text['ggsondau'] = "xxx правнук";
		$text['gstepgson'] = "xxx правнук";
		$text['gstepgdau'] = "xxx правнучка";
		$text['gstepgchild'] = "xxx правнук";
		$text['guncle'] = "lдвоюрідний дядько xxx";
		$text['gaunt'] = "xxx двоюрідна тітка";
		$text['guncleaunt'] = "дядя/тітка xxx";
		$text['gnephew'] = "xxx внучатий племінник";
		$text['gniece'] = "xxx двоюрідна племінниця";
		$text['gnephnc'] = "xxx внучатий племінник/племінниця";
		//added in 14.0
		$text['pathscalc'] = "Пошук з'єднань";
		$text['findrel2'] = "Знайти зв'язки та інші зв'язки";
		$text['makeme2nd'] = "Використовувати мій ідентифікатор";
		$text['usebookmarks'] = "Використовувати закладки";
		$text['select2inds'] = "Будь ласка, виберіть двох осіб.";
		$text['indinfofor'] = "Індивідуальна інформація для";
		$text['nobookmarks'] = "Немає закладок для використання";
		$text['bkmtitle'] = "Особи, знайдені в закладках";
		$text['bkminfo'] = "Виберіть особу:";
		$text['sortpathsby'] = "Сортувати шляхи за кількістю";
		$text['sortbyshort'] = "Сортувати за";
		$text['bylengthshort'] = "Довжина";
		$text['badID1'] = ": поганий ідентифікатор person1 - будь ласка, поверніться та виправте";
		$text['badID2'] = ": поганий ідентифікатор person2 - будь ласка, поверніться та виправте";
		$text['notintree'] = ": особи з цим ідентифікатором немає в поточній базі даних дерева.";
		$text['sameperson'] = "Ці дві особи є однією особою.";;
		$text['nopaths'] = "Ці люди не підключені.";
		$text['nopaths1'] = "Немає більше з'єднань коротше xxx";
		$text['nopaths2'] = "у кроках пошуку xxx";
		$text['longestpath'] = "(найдовший перевірений шлях складав ххх кроків)";
		$text['relevantpaths'] = "Кількість знайдених різних відповідних шляхів: xxx";
		$text['skipMarr'] = "(крім того, кількість шляхів, знайдених, але не відображених через занадто багато шлюбів, була: xxx)";
		$text['mjaor'] = "або";
		$text['connectionsto'] = "Connections to ";
		$text['findanotherpers'] = "Знайти іншу людину...";
		$text['sometimes'] = "(Іноді перевірка різної кількості поколінь дає інший результат.)";
		$text['anotherpath'] = "Пошук інших з'єднань";
		$text['xpath'] = "Шлях ";
		$text['primary'] = "Початкова особа"; // note: used for both Start and End if text['fin'] not set
		$text['secondary'] = "Кінцева особа";
		$text['parent'] = "Батьківський";
		$text['mhfather'] = "його батько";
		$text['mhmother'] = "його мати";
		$text['mhhusband'] = "його чоловік";
		$text['mhwife'] = "його дружина";
		$text['mhson'] = "його син";
		$text['mhdaughter'] = "його дочка";
		$text['fhfather'] = "її батько";
		$text['fhmother'] = "її мати";
		$text['fhhusband'] = "її чоловік";
		$text['fhwife'] = "її дружина";
		$text['fhson'] = "її син";
		$text['fhdaughter'] = "її дочка";
		$text['hfather'] = "батько";
		$text['hmother'] = "мама";
		$text['hhusband'] = "чоловік";
		$text['hwife'] = "дружина";
		$text['hson'] = "син";
		$text['hdaughter'] = "дочка";
		$text['maxruns'] = "Максимальна кількість шляхів для перевірки";
		$text['maxrshort'] = "Максимум шляхів";
		$text['maxlength'] = "Шляхи з'єднання не довші ніж";
		$text['maxlshort'] = "Максимальна довжина";
		$text['xstep'] = "крок";
		$text['xsteps'] = "кроки";
		$text['xmarriages'] = "xxx шлюбів";
		$text['xmarriage'] = "1 шлюб";
		$text['showspouses'] = "Показати обох подружжя";
		$text['showTxt'] = "Показати текстовий опис шляху";
		$text['showTxtshort'] = "Текстовий опис.";
		$text['compactBox'] = "Показати ящики для людей у компактному вигляді";
		$text['compactBoxshort'] = "Компактні блоки";
		$text['paths'] = "Шляхи";
		$text['dospouses2'] = "Показати подружжя";
		$text['maxmopt'] = "Максимальна кількість шлюбів на з'єднання";
		$text['maxm'] = "Максимум шлюбів";
		$text['arerelated'] = "Ці особи є родичами - їхні стосунки показані в Шляху 1";
		$text['simplerel'] = "Простий пошук зв'язків";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Аркуш сімейної групи для";
		$text['ldsords'] = "Постанови СОД";
		$text['endowedlds'] = "Наділений (LDS)";
		$text['sealedplds'] = "Запечатаний P (LDS)";
		$text['sealedslds'] = "Запечатаний S (LDS)";
		$text['otherspouse'] = "Інша дружина";
		$text['husband'] = "Батько";
		$text['wife'] = "Мати";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "B";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "B";
		$text['capplaceabbr'] = "P";
		$text['capmarrabbr'] = "M";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Перемалювати за допомогою";
		$text['unknownlit'] = "Невідомо";
		$text['popupnote1'] = "Додаткова інформація";
		$text['pedcompact'] = "Компактний";
		$text['pedstandard'] = "Стандарт";
		$text['pedtextonly'] = "Текст";
		$text['descendfor'] = "Нащадок для";
		$text['maxof'] = "Максимум";
		$text['gensatonce'] = "генерації, що відображаються одночасно.";
		$text['sonof'] = "син";
		$text['daughterof'] = "дочка";
		$text['childof'] = "нащадок";
		$text['stdformat'] = "Стандартний формат";
		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Додати нову сім'ю";
		$text['editfam'] = "Редагувати сім'ю";
		$text['side'] = "Сторона";
		$text['familyof'] = "Сім'я";
		$text['paternal'] = "Батьківський";
		$text['maternal'] = "Материнська";
		$text['gen1'] = "Я";
		$text['gen2'] = "Батьки";
		$text['gen3'] = "Дідусь і бабуся";
		$text['gen4'] = "Прабабуся";
		$text['gen5'] = "Другі прадіди";
		$text['gen6'] = "3-ті прадіди";
		$text['gen7'] = "4-та прабабуся";
		$text['gen8'] = "5-й прабабуся";
		$text['gen9'] = "6-й прабабуся";
		$text['gen10'] = "7-й прабабуся";
		$text['gen11'] = "8-й прабабуся";
		$text['gen12'] = "9-й прабабуся";
		$text['graphdesc'] = "Діаграма нащадків до цієї точки";
		$text['pedbox'] = "Коробка";
		$text['regformat'] = "Зареєструватися";
		$text['extrasexpl'] = "= Для цієї особи існує принаймні одна фотографія, історія або інший медіа-елемент.";
		$text['popupnote3'] = "Нова діаграма";
		$text['mediaavail'] = "Медіа доступні";
		$text['pedigreefor'] = "Діаграма родоводу для";
		$text['pedigreech'] = "Діаграма родоводу";
		$text['datesloc'] = "Дати та місця";
		$text['borchr'] = "Народження/Alt - Смерть/Поховання";
		$text['nobd'] = "Немає дат народження або смерті";
		$text['bcdb'] = "Усі дані про народження/альтернативу/смерть/поховання";
		$text['numsys'] = "Система числення";
		$text['gennums'] = "Номери поколінь";
		$text['henrynums'] = "Числа Генрі";
		$text['abovnums'] = "Числа д'Абовіля";
		$text['devnums'] = "числа де Вільєрса";
		$text['dispopts'] = "Параметри відображення";
		//added in 10.0.0
		$text['no_ancestors'] = "Не знайдено предків";
		$text['ancestor_chart'] = "Вертикальна діаграма предків";
		$text['opennewwindow'] = "Відкрити в новому вікні";
		$text['pedvertical'] = "Вертикаль";
		//added in 11.0.0
		$text['familywith'] = "Сім'я з";
		$text['fcmlogin'] = "Будь ласка, увійдіть, щоб переглянути деталі";
		$text['isthe'] = "є";
		$text['otherspouses'] = "інші подружжя";
		$text['parentfamily'] = "Батьківська сім'я ";
		$text['showfamily'] = "Показати сім'ю";
		$text['shown'] = "показано";
		$text['showparentfamily'] = "показати батьківську сім'ю";
		$text['showperson'] = "показати особу";
		//added in 11.0.2
		$text['otherfamilies'] = "Інші сім'ї";
		//added in 14.0
		$text['dtformat'] = "Таблиці";
		$text['dtchildren'] = "Діти";
		$text['dtgrandchildren'] = "Онуки";
		$text['dtggrandchildren'] = "Правнуки";
		$text['dtgggrandchildren'] = "Правнуки"; //For 2x great grandchildren, 3x great grandchildren, etc. Usually different in Scandinavian languages
		$text['dtnodescendants'] = "Немає нащадків";
		$text['dtgen'] = "Генерація";
		$text['dttotal'] = "Усього";
		$text['dtselect'] = "Вибрати";
		$text['dteachfulltable'] = "Кожна повна таблиця матиме";
		$text['dtrows'] = "рядки";
		$text['dtdisplayingtable'] = "Відображення таблиці";
		$text['dtgototable'] = "Перейти до таблиці:";
		$text['fcinstrdn'] = "Показати сім'ю з чоловіком";
		$text['fcinstrup'] = "Показати сім'ю з батьками";
		$text['fcinstrplus'] = "Вибрати інших подружжя";
		$text['fcinstrfam'] = "Вибрати інших батьків";
		//added in 15.0
		$text['nofamily'] = "Немає відомостей про родину цієї особи";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Звітів немає.";
		$text['reportname'] = "Назва звіту";
		$text['allreports'] = "Усі звіти";
		$text['report'] = "Звіт";
		$text['error'] = "Помилка";
		$text['reportsyntax'] = "Синтаксис запиту, виконаного з цим звітом";
		$text['wasincorrect'] = "було неправильно, і, як наслідок, звіт не вдалося запустити. Будь ласка, зверніться до системного адміністратора за адресою";
		$text['errormessage'] = "Повідомлення про помилку";
		$text['equals'] = "дорівнює";
		$text['endswith'] = "закінчується на";
		$text['soundexof'] = "soundex of";
		$text['metaphoneof'] = "метафон";
		$text['plusminus10'] = "+/- 10 років з";
		$text['lessthan'] = "менше";
		$text['greaterthan'] = "більше ніж";
		$text['lessthanequal'] = "менше або дорівнює";
		$text['greaterthanequal'] = "більше або дорівнює";
		$text['equalto'] = "дорівнює";
		$text['tryagain'] = "Будь ласка, спробуйте ще раз";
		$text['joinwith'] = "Приєднатися до";
		$text['cap_and'] = "І";
		$text['cap_or'] = "АБО";
		$text['showspouse'] = "Показати подружжя (відображатиме дублікати, якщо особа має більше одного подружжя)";
		$text['submitquery'] = "Надіслати запит";
		$text['birthplace'] = "Місце народження";
		$text['deathplace'] = "Місце смерті";
		$text['birthdatetr'] = "Рік народження";
		$text['deathdatetr'] = "Рік смерті";
		$text['plusminus2'] = "+/- 2 роки з";
		$text['resetall'] = "Скинути всі значення";
		$text['showdeath'] = "Показати інформацію про смерть/поховання";
		$text['altbirthplace'] = "Місце хрещення";
		$text['altbirthdatetr'] = "Рік хрещення";
		$text['burialplace'] = "Місце поховання";
		$text['burialdatetr'] = "Рік поховання";
		$text['event'] = "Подія";
		$text['day'] = "День";
		$text['month'] = "Місяць";
		$text['keyword'] = "Ключове слово (тобто \"Abt\")";
		$text['explain'] = "Введіть компоненти дати, щоб побачити відповідні події. Залиште поле порожнім, щоб побачити збіги для всіх.";
		$text['enterdate'] = "Будь ласка, введіть або виберіть принаймні один із наступного: день, місяць, рік, ключове слово";
		$text['fullname'] = "Повне ім'я";
		$text['birthdate'] = "Дата народження";
		$text['altbirthdate'] = "Дата хрещення";
		$text['marrdate'] = "Дата одруження";
		$text['spouseid'] = "Ідентифікатор подружжя";
		$text['spousename'] = "Ім'я чоловіка";
		$text['deathdate'] = "Дата смерті";
		$text['burialdate'] = "Дата поховання";
		$text['changedate'] = "Дата останньої зміни";
		$text['gedcom'] = "Дерево";
		$text['baptdate'] = "Дата хрещення (LDS)";
		$text['baptplace'] = "Місце хрещення (LDS)";
		$text['endldate'] = "Дата надання (LDS)";
		$text['endlplace'] = "Endowment Place (LDS)";
		$text['ssealdate'] = "Дата печатки S (LDS)";   //Sealed to spouse
		$text['ssealplace'] = "Місце печатки S (LDS)";
		$text['psealdate'] = "Дата печатки P (LDS)";   //Sealed to parents
		$text['psealplace'] = "Закрити місце P (LDS)";
		$text['marrplace'] = "Місце одруження";
		$text['spousesurname'] = "Прізвище подружжя";
		$text['spousemore'] = "Якщо ви вводите значення для прізвища подружжя, ви повинні вибрати стать.";
		$text['plusminus5'] = "+/- 5 років з";
		$text['exists'] = "існує";
		$text['dnexist'] = "не існує";
		$text['divdate'] = "Дата розлучення";
		$text['divplace'] = "Місце розлучення";
		$text['otherevents'] = "Інші події та атрибути";
		$text['numresults'] = "Результати на сторінку";
		$text['mysphoto'] = "Таємничі фотографії";
		$text['mysperson'] = "Невловимі люди";
		$text['joinor'] = "Опція \"Приєднатися за допомогою АБО\" не може використовуватися з Прізвищем подружжя";
		$text['tellus'] = "Розкажіть нам, що ви знаєте";
		$text['moreinfo'] = "Докладніше:";
		//added in 8.0.0
		$text['marrdatetr'] = "Рік одруження";
		$text['divdatetr'] = "Рік розлучення";
		$text['mothername'] = "Ім'я матері";
		$text['fathername'] = "Ім'я батька";
		$text['filter'] = "Фільтр";
		$text['notliving'] = "Не живе";
		$text['nodayevents'] = "Події цього місяця, які не пов'язані з конкретним днем:";
		//added in 9.0.0
		$text['csv'] = "Файл CSV, розділений комами";
		//added in 10.0.0
		$text['confdate'] = "Дата підтвердження (LDS)";
		$text['confplace'] = "Місце підтвердження (LDS)";
		$text['initdate'] = "Дата початку (LDS)";
		$text['initplace'] = "Місце ініціації (LDS)";
		//added in 11.0.0
		$text['marrtype'] = "Тип шлюбу";
		$text['searchfor'] = "Шукати";
		$text['searchnote'] = "Примітка: Ця сторінка використовує Google для здійснення пошуку. Кількість знайдених збігів безпосередньо залежатиме від того, наскільки Google вдалося проіндексувати сайт.";
		//added in 15.0
		$text['livingonly'] = "Лише для проживання";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Файл журналу для";
		$text['mostrecentactions'] = "Останні дії";
		$text['autorefresh'] = "Автоматичне оновлення (30 секунд)";
		$text['refreshoff'] = "Вимкнути автоматичне оновлення";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Кладовища та надгробки";
		$text['showallhsr'] = "Показати всі записи надгробків";
		$text['in'] = "в";
		$text['showmap'] = "Показати карту";
		$text['headstonefor'] = "Надгробок для";
		$text['photoof'] = "Фотографія";
		$text['photoowner'] = "Власник оригіналу";
		$text['nocemetery'] = "Немає кладовища";
		$text['iptc005'] = "Назва";
		$text['iptc020'] = "Категорії підтримки";
		$text['iptc040'] = "Спеціальні інструкції";
		$text['iptc055'] = "Дата створення";
		$text['iptc080'] = "Автор";
		$text['iptc085'] = "Позиція автора";
		$text['iptc090'] = "Місто";
		$text['iptc095'] = "Штат/провінція";
		$text['iptc101'] = "Країна";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Заголовок";
		$text['iptc110'] = "Джерело";
		$text['iptc115'] = "Джерело фото";
		$text['iptc116'] = "Повідомлення про авторські права";
		$text['iptc120'] = "Підпис";
		$text['iptc122'] = "Автор підписів";
		$text['mapof'] = "Карта";
		$text['regphotos'] = "Вигляд опису";
		$text['gallery'] = "Переглянути галерею";
		$text['cemphotos'] = "Фото кладовища";
		$text['photosize'] = "Розміри";
        $text['iptc010'] = "Пріоритет";
		$text['filesize'] = "Розмір файлу";
		$text['seeloc'] = "Подивитися розташування";
		$text['showall'] = "Показати все";
		$text['editmedia'] = "Редагувати медіа";
		$text['viewitem'] = "Переглянути цей елемент";
		$text['editcem'] = "Редагувати кладовище";
		$text['numitems'] = "# елементів";
		$text['allalbums'] = "All Albums";
		$text['slidestop'] = "Призупинити показ слайдів";
		$text['slideresume'] = "Відновити показ слайдів";
		$text['slidesecs'] = "Секунди для кожного слайда:";
		$text['minussecs'] = "мінус 0,5 секунди";
		$text['plussecs'] = "плюс 0,5 секунди";
		$text['nocountry'] = "Невідома країна";
		$text['nostate'] = "Невідомий стан";
		$text['nocounty'] = "Невідомий округ";
		$text['nocity'] = "Невідоме місто";
		$text['nocemname'] = "Невідома назва кладовища";
		$text['editalbum'] = "Редагувати альбом";
		$text['mediamaptext'] = "<strong>Примітка:</strong> Наведіть вказівник миші на зображення, щоб відобразити імена. Натисніть, щоб побачити сторінку для кожного імені.";
		//added in 8.0.0
		$text['allburials'] = "Усі поховання";
		$text['moreinfo'] = "Натисніть, щоб дізнатися більше про це зображення";
		//added in 9.0.0
        $text['iptc025'] = "Ключові слова";
        $text['iptc092'] = "Підрозташування";
		$text['iptc015'] = "Категорія";
		$text['iptc065'] = "Початкова програма";
		$text['iptc070'] = "Версія програми";
		//added in 13.0
		$text['toggletags'] = "Переключити теги";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places":
		$text['surnamesstarting'] = "Показати прізвища, які починаються з";
		$text['showtop'] = "Показати верх";
		$text['showallsurnames'] = "Показати всі прізвища";
		$text['sortedalpha'] = "відсортовано за алфавітом";
		$text['byoccurrence'] = "впорядковано за випадком";
		$text['firstchars'] = "Перші символи";
		$text['mainsurnamepage'] = "Головна сторінка прізвища";
		$text['allsurnames'] = "Усі прізвища";
		$text['showmatchingsurnames'] = "Натисніть на прізвище, щоб показати відповідні записи.";
		$text['backtotop'] = "Повернутися до початку";
		$text['beginswith'] = "Починається з";
		$text['allbeginningwith'] = "Усі прізвища, що починаються з";
		$text['numoccurrences'] = "загальна кількість населених пунктів у дужках";
		$text['placesstarting'] = "Показати найбільші населені пункти, починаючи з";
		$text['showmatchingplaces'] = "Натисніть місце, щоб показати менші населені пункти. Натисніть значок пошуку, щоб показати відповідних осіб.";
		$text['totalnames'] = "загальна кількість осіб";
		$text['showallplaces'] = "Показати всі найбільші населені пункти";
		$text['totalplaces'] = "загальна кількість місць";
		$text['mainplacepage'] = "Сторінка основних місць";
		$text['allplaces'] = "Усі найбільші населені пункти";
		$text['placescont'] = "Показати всі місця, що містять";
		//changed in 8.0.0
		$text['top30'] = "Топ xxx прізвищ";
		$text['top30places'] = "Топ xxx найбільших населених пунктів";
		//added in 12.0.0
		$text['firstnamelist'] = "Список імен";
		$text['firstnamesstarting'] = "Показати імена, які починаються з";
		$text['showallfirstnames'] = "Показати всі імена";
		$text['mainfirstnamepage'] = "Головна сторінка імені";
		$text['allfirstnames'] = "Усі імена";
		$text['showmatchingfirstnames'] = "Натисніть на ім'я, щоб показати відповідні записи.";
		$text['allfirstbegwith'] = "Усі імена, що починаються з";
		$text['top30first'] = "Топ xxx імен";
		$text['allothers'] = "Усі інші";
		$text['amongall'] = "(серед усіх імен)";
		$text['justtop'] = "Just верхній xxx";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(за минулі xx днів)";

		$text['photo'] = "Фото";
		$text['history'] = "Історія/документ";
		$text['husbid'] = "Ідентифікатор батька";
		$text['husbname'] = "Ім'я батька";
		$text['wifeid'] = "Ідентифікатор матері";
		//added in 11.0.0
		$text['wifename'] = "Ім'я матері";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Видалити";
		$text['addperson'] = "Додати особу";
		$text['nobirth'] = "Ця особа не має дійсної дати народження, тому її неможливо додати";
		$text['event'] = "Події";
		$text['chartwidth'] = "Ширина діаграми";
		$text['timelineinstr'] = "Додати людей";
		$text['togglelines'] = "Перемикати рядки";
		//changed in 9.0.0
		$text['noliving'] = "Цю особу позначено як живу чи приватну, і її неможливо додати, оскільки ви не ввійшли в систему з належними правами";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Переглянути всі дерева";
		$text['treename'] = "Назва дерева";
		$text['owner'] = "Власник";
		$text['address'] = "Адреса";
		$text['city'] = "Місто";
		$text['state'] = "Штат/провінція";
		$text['zip'] = "Поштовий індекс";
		$text['country'] = "Країна";
		$text['email'] = "Електронна пошта";
		$text['phone'] = "Телефон";
		$text['username'] = "Ім'я користувача";
		$text['password'] = "Пароль";
		$text['loginfailed'] = "Помилка входу.";

		$text['regnewacct'] = "Зареєструвати новий обліковий запис користувача";
		$text['realname'] = "Ваше справжнє ім'я";
		$text['phone'] = "Телефон";
		$text['email'] = "Електронна пошта";
		$text['address'] = "Адреса";
		$text['acctcomments'] = "Примітки або коментарі";
		$text['submit'] = "Надіслати";
		$text['leaveblank'] = "(залиште порожнім, якщо запитуєте нове дерево)";
		$text['required'] = "Обов'язкові поля";
		$text['enterpassword'] = "Будь ласка, введіть пароль.";
		$text['enterusername'] = "Будь ласка, введіть ім'я користувача.";
		$text['failure'] = "Вибачте, але введене вами ім'я користувача вже використовується. Будь ласка, скористайтеся кнопкою \"Назад\" у вашому браузері, щоб повернутися на попередню сторінку та вибрати інше ім'я користувача.";
		$text['success'] = "Дякуємо. Ми отримали вашу реєстрацію. Ми зв'яжемося з вами, коли ваш обліковий запис стане активним або якщо знадобиться додаткова інформація.";
		$text['emailsubject'] = "Запит на реєстрацію нового користувача TNG";
		$text['website'] = "Веб-сайт";
		$text['nologin'] = "Немає логіна?";
		$text['loginsent'] = "Інформація для входу надіслана";
		$text['loginnotsent'] = "Інформація для входу не надіслана";
		$text['enterrealname'] = "Будь ласка, введіть своє справжнє ім'я.";
		$text['rempass'] = "Залишатися в системі на цьому комп'ютері";
		$text['morestats'] = "Більше статистики";
		$text['accmail'] = "<strong>ПРИМІТКА:</strong> Щоб отримувати листи від адміністратора сайту щодо вашого облікового запису, переконайтеся, що ви не блокуєте листи з цього домену.";
		$text['newpassword'] = "Новий пароль";
		$text['resetpass'] = "Скинути пароль";
		$text['nousers'] = "Ця форма не може бути використана, доки не існує принаймні одного запису користувача. Якщо ви є власником сайту, будь ласка, перейдіть до Адміністратора/Користувачів, щоб створити обліковий запис адміністратора.";
		$text['noregs'] = "Нам шкода, але ми не приймаємо реєстрацію нових користувачів. Будь ласка, <a href=\"suggest.php\">зв'яжіться з нами</a> безпосередньо, якщо у вас є коментарі або питання щодо будь-чого на цьому сайті.";
		$text['emailmsg'] = "Ви отримали новий запит на обліковий запис користувача TNG. Будь ласка, увійдіть у свою область адміністратора TNG і призначте відповідні дозволи цьому новому обліковому запису.";
		$text['accactive'] = "Обліковий запис активовано, але користувач не матиме спеціальних прав, доки ви не призначите їх.";
		$text['accinactive'] = "Перейдіть до Admin/Users/Review, щоб отримати доступ до налаштувань облікового запису. Обліковий запис залишатиметься неактивним, доки ви не відредагуєте та не збережете запис принаймні один раз.";
		$text['pwdagain'] = "Пароль знову";
		$text['enterpassword2'] = "Будь ласка, введіть свій пароль ще раз.";
		$text['pwdsmatch'] = "Ваші паролі не збігаються. Введіть той самий пароль у кожне поле.";
		$text['acksubject'] = "Дякуємо за реєстрацію"; //for a new user account
		$text['ackmessage'] = "Ваш запит на обліковий запис користувача отримано. Ваш обліковий запис буде неактивним, доки його не перегляне адміністратор сайту. Ви отримаєте сповіщення електронною поштою, коли ваш логін буде готовий до використання.";
		//added in 12.0.0
		$text['switch'] = "Переключити";
		//added in 14.0
		$text['newpassword2'] = "Знову новий пароль";
		$text['resetsuccess'] = "Успіх: пароль скинуто";
		$text['resetfail'] = "Помилка: пароль не скинуто";
		$text['failreason0'] = " (невідома помилка бази даних)";
		$text['failreason2'] = " (у вас немає дозволу змінити пароль)";
		$text['failreason3'] = " (паролі не збігаються)";
		break;

	//added in 10.0.0
	case "branches":
		$text['browseallbranches'] = "Переглянути всі гілки";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Кількість";
		$text['totindividuals'] = "Загальна кількість осіб";
		$text['totmales'] = "Усього Мель";
		$text['totfemales'] = "Загальна кількість жінок";
		$text['totunknown'] = "Всього невідома стать";
		$text['totliving'] = "Загальна сума життя";
		$text['totfamilies'] = "Загальна кількість сімей";
		$text['totuniquesn'] = "Загальна кількість унікальних прізвищ";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Загальна кількість джерел";
		$text['avglifespan'] = "Середня тривалість життя";
		$text['earliestbirth'] = "Найбільш раннє народження";
		$text['longestlived'] = "Найдовше живе";
		$text['days'] = "дні";
		$text['age'] = "Вік";
		$text['agedisclaimer'] = "Розрахунки, пов'язані з віком, базуються на особах із записаними датами народження <em>і</em> смерті. Через наявність неповних полів дати (наприклад, дата смерті вказана лише як \" 1945\" або \"BEF 1860\"), ці розрахунки не можуть бути точними на 100%.";
		$text['treedetail'] = "Більше інформації про це дерево";
		$text['total'] = "Усього";
		//added in 12.0
		$text['totdeceased'] = "Загальна кількість померлих";
		//added in 14.0
		$text['totalsourcecitations'] = "Загальна кількість посилань на джерела";
		break;

	case "notes":
		$text['browseallnotes'] = "Переглянути всі нотатки";
		break;

	case "help":
		$text['menuhelp'] = "Клавіша меню";
		break;

	case "install":
		$text['perms'] = "Всі дозволи налаштовано.";
		$text['noperms'] = "Не вдалося встановити дозволи для цих файлів:";
		$text['manual'] = "Встановіть їх вручну.";
		$text['folder'] = "Папка";
		$text['created'] = "було створено";
		$text['nocreate'] = "не вдалося створити. Будь ласка, створіть його вручну.";
		$text['infosaved'] = "Інформацію збережено, з'єднання перевірено!";
		$text['tablescr'] = "Таблиці створено!";
		$text['notables'] = "Не вдалося створити такі таблиці:";
		$text['nocomm'] = "TNG не зв'язується з вашою базою даних. Жодної таблиці не створено.";
		$text['newdb'] = "Інформацію збережено, підключення перевірено, створено нову базу даних:";
		$text['noattach'] = "Інформацію збережено. Підключення та базу даних створено, але TNG не може приєднатися до неї.";
		$text['nodb'] = "Інформація збережена. З'єднання встановлено, але база даних не існує і не може бути створена тут. Будь ласка, переконайтеся, що ім'я бази даних правильне, і що користувач бази даних має відповідний доступ, або скористайтеся панеллю керування створити його.";
		$text['noconn'] = "Інформацію збережено, але з'єднання не вдалося. Одне або більше з наступного неправильно:";
		$text['exists'] = "вже існує.";
		$text['noop'] = "Жодної операції не виконано.";
		//added in 8.0.0
		$text['nouser'] = "Користувач не був створений. Можливо, ім'я користувача вже існує.";
		$text['notree'] = "Дерево не створено. ID дерева може вже існувати.";
		$text['infosaved2'] = "Інформація збережена";
		$text['renamedto'] = "перейменовано на";
		$text['norename'] = "неможливо перейменувати";
		//changed in 13.0.0
		$text['loginfirst'] = "Було виявлено існуючі записи користувача. Щоб продовжити, ви повинні спочатку увійти або видалити всі записи з таблиці користувачів.";
		break;

	case "imgviewer":
		$text['magmode'] = "Режим збільшення";
		$text['panmode'] = "Режим панорамування";
		$text['pan'] = "Клацніть і перетягніть для переміщення всередині зображення";
		$text['fitwidth'] = "Відповідати ширині";
		$text['fitheight'] = "Відповідати висоті";
		$text['newwin'] = "Нове вікно";
		$text['opennw'] = "Відкрити зображення в новому вікні";
		$text['magnifyreg'] = "Натисніть, щоб збільшити область зображення";
		$text['imgctrls'] = "Увімкнути елементи керування зображеннями";
		$text['vwrctrls'] = "Увімкнути елементи керування переглядачем зображень";
		$text['vwrclose'] = "Закрити засіб перегляду зображень";

		//added in 15.0
		$text['showtags'] = "Показати теги";
		$text['toggletagsmsg'] = "Натисніть, щоб перемкнути";
		break;

	case "dna":
		$text['test_date'] = "Дата тесту";
		$text['links'] = "Відповідні посилання";
		$text['testid'] = "Ідентифікатор тесту";
		//added in 12.0.0
		$text['mode_values'] = "Значення режиму";
		$text['compareselected'] = "Порівняти вибране";
		$text['dnatestscompare'] = "Порівняти тести Y-ДНК";
		$text['keep_name_private'] = "Зберігати ім'я приватним";
		$text['browsealltests'] = "Переглянути всі тести";
		$text['all_dna_tests'] = "Усі тести ДНК";
		$text['fastmutating'] = "Швидка&nbsp;мутація";
		$text['alltypes'] = "Усі типи";
		$text['allgroups'] = "Усі групи";
		$text['Ydna_LITbox_info'] = "Тест(и), пов'язані з цією особою, не обов'язково проходила ця особа.<br />Стовпець \"Гаплогрупа\" відображає дані червоним кольором, якщо результат \"Передбачуваний\", або зеленим, якщо тест «Підтверджено»";
		//added in 12.1.0
		$text['dnatestscompare_mtdna'] = "Порівняти вибрані тести мтДНК";
		$text['dnatestscompare_atdna'] = "Порівняти вибрані тести ДНК";
		$text['chromosome'] = "Chr";
		$text['centiMorgans'] = "cM";
		$text['snps'] = "SNP";
		$text['y_haplogroup'] = "Y-ДНК";
		$text['mt_haplogroup'] = "мтДНК";
		$text['sequence'] = "Посилання";
		$text['extra_mutations'] = "Додаткові мутації";
		$text['mrca'] = "Попередник MRC";
		$text['ydna_test'] = "Тести Y-ДНК";
		$text['mtdna_test'] = "тести мтДНК (мітохондрії)";
		$text['atdna_test'] = "тести atDNA (аутосомні)";
		$text['segment_start'] = "Початок";
		$text['segment_end'] = "Кінець";
		$text['suggested_relationship'] = "Запропоновано";
		$text['actual_relationship'] = "Фактичний";
		$text['12markers'] = "Маркери 1-12";
		$text['25markers'] = "Маркери 13-25";
		$text['37markers'] = "Маркери 26-37";
		$text['67markers'] = "Маркери 38-67";
		$text['111markers'] = "Маркери 68-111";
		//added in 13.1
		$text['comparemore'] = "Для порівняння необхідно вибрати принаймні два тести.";
		break;
}

//common
$text['matches'] = "Збіги";
$text['description'] = "Опис";
$text['notes'] = "Примітки";
$text['status'] = "Статус";
$text['newsearch'] = "Новий пошук";
$text['pedigree'] = "Родовід";
$text['seephoto'] = "Переглянути фото";
$text['andlocation'] = "&amp; розташування";
$text['accessedby'] = "доступно";
$text['children'] = "Діти";  //from getperson
$text['tree'] = "Дерево";
$text['alltrees'] = "Усі дерева";
$text['nosurname'] = "[без прізвища]";
$text['thumb'] = "Великий палець";  //as in Thumbnail
$text['people'] = "Люди";
$text['title'] = "Назва";  //from getperson
$text['suffix'] = "Суфікс";  //from getperson
$text['nickname'] = "Псевдонім";  //from getperson
$text['lastmodified'] = "Остання зміна";  //from getperson
$text['married'] = "Одружений";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Ім'я"; //from showmap
$text['lastfirst'] = "Прізвище, ім'я (імена)";  //from search
$text['bornchr'] = "Народився/хрестився";  //from search
$text['individuals'] = "Особи";  //from whats new
$text['families'] = "Сім'ї";
$text['personid'] = "Ідентифікатор особи";
$text['sources'] = "Джерела";  //from getperson (next several)
$text['unknown'] = "Невідомо";
$text['father'] = "Батько";
$text['mother'] = "Мати";
$text['christened'] = "Охрещений";
$text['died'] = "Помер";
$text['buried'] = "Похований";
$text['spouse'] = "Дружина";  //from search
$text['parents'] = "Батьки";  //from pedigree
$text['text'] = "Текст";  //from sources
$text['language'] = "Мова";  //from languages
$text['descendchart'] = "Нащадок";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Особа";
$text['edit'] = "Редагувати";
$text['date'] = "Дата";
$text['login'] = "Вхід";
$text['logout'] = "Вийти";
$text['groupsheet'] = "Аркуш групи";
$text['text_and'] = "і";
$text['generation'] = "Генерація";
$text['filename'] = "Ім'я файлу";
$text['id'] = "ID";
$text['search'] = "Пошук";
$text['user'] = "Користувач";
$text['firstname'] = "Ім'я";
$text['lastname'] = "Прізвище";
$text['searchresults'] = "Результати пошуку";
$text['diedburied'] = "Помер/Похований";
$text['homepage'] = "Домашня сторінка";
$text['find'] = "Знайти...";
$text['relationship'] = "Відносини";		//in German, Verwandtschaft
$text['relationship2'] = "Зв'язок"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Шкала часу";
$text['yesabbr'] = "Y";               //abbreviation for 'yes'
$text['divorced'] = "Розлучений";
$text['indlinked'] = "Пов'язано з";
$text['branch'] = "Гілка";
$text['moreind'] = "Більше осіб";
$text['morefam'] = "Більше сімей";
$text['surnamelist'] = "Список прізвищ";
$text['generations'] = "Покоління";
$text['refresh'] = "Оновити";
$text['whatsnew'] = "Що нового";
$text['reports'] = "Звіти";
$text['placelist'] = "Список місць";
$text['baptizedlds'] = "Охрещений (LDS)";
$text['endowedlds'] = "Наділений (LDS)";
$text['sealedplds'] = "Запечатаний P (LDS)";
$text['sealedslds'] = "Запечатаний S (LDS)";
$text['ancestors'] = "Предки";
$text['descendants'] = "Нащадки";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Дата останнього імпорту GEDCOM";
$text['type'] = "Тип";
$text['savechanges'] = "Зберегти зміни";
$text['familyid'] = "Ідентифікатор сім'ї";
$text['headstone'] = "Нагробні камені";
$text['historiesdocs'] = "Історії";
$text['anonymous'] = "анонімний";
$text['places'] = "Місця";
$text['anniversaries'] = "Дати та річниці";
$text['administration'] = "Адміністрування";
$text['help'] = "Допомога";
//$text['documents'] = "Documents";
$text['year'] = "Рік";
$text['all'] = "Усі";
$text['address'] = "Адреса";
$text['suggest'] = "Запропонувати";
$text['editevent'] = "Запропонувати зміну для цієї події";
$text['morelinks'] = "Більше посилань";
$text['faminfo'] = "Інформація про сім'ю";
$text['persinfo'] = "Особиста інформація";
$text['srcinfo'] = "Інформація про джерело";
$text['fact'] = "Факт";
$text['goto'] = "Виберіть сторінку";
$text['tngprint'] = "Друк";
$text['databasestatistics'] = "Статистика"; //needed to be shorter to fit on menu
$text['child'] = "Дитина";  //from familygroup
$text['repoinfo'] = "Інформація про сховище";
$text['tng_reset'] = "Скинути";
$text['noresults'] = "Результатів не знайдено";
$text['allmedia'] = "Усі медіа";
$text['repositories'] = "Сховища";
$text['albums'] = "Альбоми";
$text['cemeteries'] = "Кладовища";
$text['surnames'] = "Прізвища";
$text['link'] = "Посилання";
$text['media'] = "Медіа";
$text['gender'] = "Стать";
$text['latitude'] = "Широта";
$text['longitude'] = "Довгота";
$text['bookmark'] = "Закладка";
$text['mngbookmarks'] = "Перейти до закладок";
$text['bookmarked'] = "Закладку додано";
$text['remove'] = "Видалити";
$text['find_menu'] = "Знайти";
$text['info'] = "Інформація"; //this needs to be a very short abbreviation
$text['cemetery'] = "Кладовище";
$text['gmapevent'] = "Карта подій";
$text['gevents'] = "Подія";
$text['googleearthlink'] = "Посилання на Google Earth";
$text['googlemaplink'] = "Посилання на Карти Google";
$text['gmaplegend'] = "Закріпити легенду";
$text['unmarked'] = "Не позначено";
$text['located'] = "Розташований";
$text['albclicksee'] = "Натисніть, щоб переглянути всі елементи цього альбому";
$text['notyetlocated'] = "Ще не знайдено";
$text['cremated'] = "Кремований";
$text['missing'] = "Відсутній";
$text['pdfgen'] = "Генератор PDF";
$text['blank'] = "Порожня діаграма";
$text['fonts'] = "Шрифти";
$text['header'] = "Заголовок";
$text['data'] = "Дані";
$text['pgsetup'] = "Налаштування сторінки";
$text['pgsize'] = "Розмір сторінки";
$text['orient'] = "Орієнтація"; //for a page
$text['portrait'] = "Портрет";
$text['landscape'] = "Пейзаж";
$text['tmargin'] = "Верхнє поле";
$text['bmargin'] = "Нижнє поле";
$text['lmargin'] = "Ліве поле";
$text['rmargin'] = "Праве поле";
$text['createch'] = "Створити діаграму";
$text['prefix'] = "Префікс";
$text['mostwanted'] = "Найбільш розшукуваний";
$text['latupdates'] = "Останні оновлення";
$text['featphoto'] = "Вибране фото";
$text['news'] = "Новини";
$text['ourhist'] = "Історія нашої родини";
$text['ourhistanc'] = "Наша сімейна історія та походження";
$text['ourpages'] = "Сторінки генеалогії нашої родини";
$text['pwrdby'] = "Цей сайт працює на";
$text['writby'] = "автор";
$text['searchtngnet'] = "Пошук у мережі TNG (GENDEX)";
$text['viewphotos'] = "Переглянути всі фотографії";
$text['anon'] = "На даний момент ви анонімні";
$text['whichbranch'] = "З якої ви філії?";
$text['featarts'] = "Особливі статті";
$text['maintby'] = "Підтримує";
$text['createdon'] = "Створено";
$text['reliability'] = "Надійність";
$text['labels'] = "Мітки";
$text['inclsrcs'] = "Включити джерела";
$text['cont'] = "(продовження)"; //abbreviation for continued
$text['mnuheader'] = "Домашня сторінка";
$text['mnusearchfornames'] = "Пошук";
$text['mnulastname'] = "Прізвище";
$text['mnufirstname'] = "Ім'я";
$text['mnusearch'] = "Пошук";
$text['mnureset'] = "Почати спочатку";
$text['mnulogon'] = "Увійти";
$text['mnulogout'] = "Вийти";
$text['mnufeatures'] = "Інші можливості";
$text['mnuregister'] = "Зареєструвати обліковий запис користувача";
$text['mnuadvancedsearch'] = "Розширений пошук";
$text['mnulastnames'] = "Прізвища";
$text['mnustatistics'] = "Статистика";
$text['mnuphotos'] = "Фотографії";
$text['mnuhistories'] = "Історії";
$text['mnumyancestors'] = "Фотографії та історії предків [особи]";
$text['mnucemeteries'] = "Кладовища";
$text['mnutombstones'] = "Надгробки";
$text['mnureports'] = "Звіти";
$text['mnusources'] = "Джерела";
$text['mnuwhatsnew'] = "Що нового";
$text['mnulanguage'] = "Змінити мову";
$text['mnuadmin'] = "Адміністрування";
$text['welcome'] = "Ласкаво просимо";
//changed in 8.0.0
$text['born'] = "Народився";
//added in 8.0.0
$text['editperson'] = "Редагувати особу";
$text['loadmap'] = "Завантажити карту";
$text['birth'] = "Народження";
$text['wasborn'] = "народився";
$text['startnum'] = "Перше число";
$text['searching'] = "Пошук";
//moved here in 8.0.0
$text['location'] = "Розташування";
$text['association'] = "Асоціація";
$text['collapse'] = "Згорнути";
$text['expand'] = "Розгорнути";
$text['plot'] = "Сюжет";
//added in 8.0.2
$text['wasmarried'] = "Одружений";
$text['anddied'] = "Помер";
//added in 9.0.0
$text['share'] = "Поділитися";
$text['hide'] = "Приховати";
$text['disabled'] = "Ваш обліковий запис користувача вимкнено. Будь ласка, зверніться до адміністратора сайту для отримання додаткової інформації.";
$text['contactus_long'] = "Якщо у вас є будь-які запитання або коментарі щодо інформації на цьому сайті, будь ласка, <span class=\"emphasis\"><a href=\"suggest.php\">зв'яжіться з нами</ a></span>. Ми з нетерпінням чекаємо на вашу думку.";
$text['features'] = "Функції";
$text['resources'] = "Ресурси";
$text['latestnews'] = "Останні новини";
$text['trees'] = "Дерева";
$text['wasburied'] = "був похований";
//moved here in 9.0.0
$text['emailagain'] = "Надіслати електронною поштою знову";
$text['enteremail2'] = "Будь ласка, введіть адресу електронної пошти ще раз.";
$text['emailsmatch'] = "Ваші електронні адреси не збігаються. Будь ласка, введіть ту саму адресу електронної пошти в кожному полі.";
$text['getdirections'] = "Натисніть, щоб отримати маршрут";
//changed in 9.0.0
$text['directionsto'] = " до ";
$text['slidestart'] = "Слайд-шоу";
$text['livingnote'] = "Принаймні одна жива або приватна особа пов'язана з цією заміткою - подробиці не розкриваються.";
$text['livingphoto'] = "Принаймні одна жива або приватна особа пов'язана з цим елементом - подробиці не розкриваються.";
$text['waschristened'] = "був хрещений";
//added in 10.0.0
$text['branches'] = "Гілки";
$text['detail'] = "Деталі";
$text['moredetail'] = "Більше деталей";
$text['lessdetail'] = "Менше деталей";
$text['conflds'] = "Підтверджено (LDS)";
$text['initlds'] = "Ініціація (LDS)";
$text['wascremated'] = "був кремований";
//moved here in 11.0.0
$text['text_for'] = "для";
//added in 11.0.0
$text['searchsite'] = "Шукати на цьому сайті";
$text['kmlfile'] = "Завантажте файл .kml, щоб показати це розташування в Google Планета Земля";
$text['download'] = "Натиснітьk для завантаження";
$text['more'] = "Більше";
$text['heatmap'] = "Теплова карта";
$text['refreshmap'] = "Оновити карту";
$text['remnums'] = "Очистити номери та піни";
$text['photoshistories'] = "Фотографії та історії";
$text['familychart'] = "Family Chart";
//moved here in 12.0.0
$text['dna_test'] = "Тест ДНК";
$text['test_type'] = "Тип тесту";
$text['test_info'] = "Інформація про тест";
$text['takenby'] = "Знято";
$text['haplogroup'] = "Гаплогрупа";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "Релевантні посилання";
$text['nofirstname'] = "[без імені]";
//added in 12.0.1
$text['cookieuse'] = "Примітка: цей сайт використовує файли cookie.";
$text['dataprotect'] = "Політика захисту даних";
$text['viewpolicy'] = "Політика перегляду";
$text['understand'] = "Я розумію";
$text['consent'] = "Я даю свою згоду на те, щоб цей сайт зберігав зібрану тут особисту інформацію. Я розумію, що можу попросити власника сайту видалити цю інформацію в будь-який час.";
$text['consentreq'] = "Будь ласка, дайте свою згоду на зберігання особистої інформації на цьому сайті.";

//added in 12.1.0
$text['testsarelinked'] = "тести ДНК пов'язані з";
$text['testislinked'] = "тест ДНК пов'язаний з";

//added in 12.2
$text['quicklinks'] = "Швидкі посилання";
$text['yourname'] = "Ваше ім'я";
$text['youremail'] = "Ваша електронна адреса";
$text['liketoadd'] = "Будь-яка інформація, яку ви хотіли б додати";
$text['webmastermsg'] = "Повідомлення веб-майстра";
$text['gallery'] = "Переглянути галерею";
$text['wasborn_male'] = "народився";  	// same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "народився"; 	// same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "був хрещений";	// same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "був охрещений";	// same as $text['waschristened'] if no gender verb
$text['died_male'] = "помер";	// same as $text['anddied'] of no gender verb
$text['died_female'] = "померла";	// same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "був похований"; 	// same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "був похований"; 	// same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "був кремований";		// same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "була кремована";	// same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "одружений";	// same as $text['wasmarried'] if no gender verb
$text['wasmarried_female'] = "одружений";	// same as $text['wasmarried'] if no gender verb
$text['wasdivorced_male'] = "був розлучений";	// might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "була розлучена";	// might be the same as $text['divorce'] but as a verb
$text['inplace'] = " в ";			// used as a preposition to the location
$text['onthisdate'] = " на ";		// when used with full date
$text['inthisyear'] = " у ";		// when used with year only or month / year dates
$text['and'] = "і ";				// used in conjunction with wasburied or was cremated

//moved here in 12.2.1
$text['dna_info_head'] = "Інформація про тест ДНК";
//added in 13.0
$text['visitor'] = "Відвідувач";

$text['popupnote2'] = "Новий родовід";

//moved here in 14.0
$text['zoomin'] = "Збільшити";
$text['zoomout'] = "Зменшити";
$text['scrollnote'] = "Перетягніть або прокрутіть, щоб побачити більше діаграми.";
$text['general'] = "Загальні";

//changed in 14.0
$text['otherevents'] = "Інші події та атрибути";

//added in 14.0
$text['times'] = "x";
$text['connections'] = "Підключення";
$text['continue'] = "Продовжити";
$text['title2'] = "Назва"; //for media, sources, etc (not people)

//added in 15.0
$text['atsea'] = "Похований у морі";
$text['topsurnames'] = "Top Surnames";
$text['ourphotos'] = "Our Photos";

//moved here in 15.0
$text['greatoffset'] = "0"; //Scandinavian languages should set this to 1 so counting starts a generation later

@include_once(dirname(__FILE__) . "/alltext.php");
if(empty($alltextloaded)) getAllTextPath();
?>