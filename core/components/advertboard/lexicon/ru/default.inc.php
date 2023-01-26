<?php
include_once 'setting.inc.php';

$_lang['advertboard'] = 'Доска Объявлений';
$_lang['advertboard_menu_desc'] = 'Панель управления Доской Объявлений';
$_lang['advertboard_intro_msg'] = 'Вы можете выделять сразу несколько Объявлений при помощи Shift или Ctrl.';

$_lang['advertboard_items'] = 'Объявления';
$_lang['advertboard_item_id'] = 'Id';
$_lang['advertboard_item_title'] = 'Заголовок';
$_lang['advertboard_item_content'] = 'Содержание';
$_lang['advertboard_item_hash'] = 'Hash объявления';
$_lang['advertboard_item_author'] = 'ID автора';
$_lang['advertboard_item_parent'] = 'ID категории';
$_lang['advertboard_item_active'] = 'Активно';
$_lang['advertboard_item_top'] = 'Топ';
$_lang['advertboard_item_price'] = 'Цена';
$_lang['advertboard_item_image'] = 'Изображение';

$_lang['advertboard_item_create'] = 'Создать Объявление';
$_lang['advertboard_item_update'] = 'Изменить Объявление';
$_lang['advertboard_item_enable'] = 'Включить Объявление';
$_lang['advertboard_items_enable'] = 'Включить Объявления';
$_lang['advertboard_item_disable'] = 'Отключить Объявление';
$_lang['advertboard_items_disable'] = 'Отключить Объявления';
$_lang['advertboard_item_remove'] = 'Удалить Объявление';
$_lang['advertboard_items_remove'] = 'Удалить Объявления';
$_lang['advertboard_item_remove_confirm'] = 'Вы уверены, что хотите удалить этот Объявление?';
$_lang['advertboard_items_remove_confirm'] = 'Вы уверены, что хотите удалить эти Объявления?';
$_lang['advertboard_item_active'] = 'Включено';

$_lang['advertboard_item_err_title'] = 'Вы должны указать загаловок Объявления.';
$_lang['advertboard_item_err_price'] = 'Вы должны указать цену Объявления.';
$_lang['advertboard_item_err_user_id'] = 'Вы должны указать ID автора Объявления.';
$_lang['advertboard_item_err_pid'] = 'Вы должны указать ID категории Объявления.';
$_lang['advertboard_item_err_ae'] = 'Объявление с таким именем уже существует.';
$_lang['advertboard_item_err_nf'] = 'Объявление не найдено.';
$_lang['advertboard_item_err_ns'] = 'Объявление не указано.';
$_lang['advertboard_item_err_remove'] = 'Ошибка при удалении Объявления.';
$_lang['advertboard_item_err_save'] = 'Ошибка при сохранении Объявления.';

$_lang['advertboard_grid_search'] = 'Поиск';
$_lang['advertboard_grid_actions'] = 'Действия';

$_lang['advertboard_import'] = 'Импорт объявлений';
$_lang['advertboard_import_intro_msg'] = '<p>Каждая строка должна содержать информацию об одном объявлении.</p>
<p>Разделитель - точка с запятой.</p>
<p>Формат данных:</p>
<p>"Дата";"E-mail пользователя";"ID категории";"Имя автора";"Заголовок";"Содержание";"Цена";"Путь до изображения"</p>
<p>Пример: <i>"28/11/2022";"email@email.com";8;"John Smith";"Advert title";"Advert content";100;"assets/import/img1.jpg";</i></p>';
$_lang['advertboard_import_file'] = 'Укажите файл csv';
$_lang['advertboard_import_start'] = 'Импортировать';
$_lang['adverts_import_err_csv'] = 'Укажите верный файл';
