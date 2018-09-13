<h3>Установка плагина:<h3><br>
-скачайте архив<br>
-скопируйте папку currency_converter на ваш сервер [корень сайта]\wp-content\plugins<br>
-активируйте плагин во вкладке Плагины в Административной части сайта<br>
-переходим во [Внешний вид]/виджеты выбираем "Конвертер байруб" добавить виджет<br>
-в настройках выбираем кнопки валют для сравнения с BYN<br><br>

p.s. Плагин создаёт таблицу в базе данных [префикс_]byn_course, если вы удаляете плагин и не планируете к нему возвращаться, рекомендуется удалить эту таблицу вручную.<br>
<br>

задание: Разработать плагин для CMS Wordpress, который будет отображать актуальный курс валют на сайте в виде виджета.
Требования: 
1)	Виджет должен состоять из “табов” переключения типа валют и двух полей ввода. При вводе в одно из полей, значение второго поля должно изменятся автоматически. Изначальное значение - 1 BYN. В нижней части виджета должна отображаться дата последнего обновления курса валют.
2)	Хранение актуальных курсов и даты последнего обновления в БД.
3)	Получение актуальных курсов с помощью API НБРБ http://www.nbrb.by/APIHelp/ExRates
4)	Создать событие ежедневного обновления курсов с помощью wp_schedule_event
5)	Использовать Bootstrap для табов, разметки и полей. Bootstrap подключать с помощью wp_enqueue_script и wp_enqueue_style в плагин 



