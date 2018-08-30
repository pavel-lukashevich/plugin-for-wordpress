<?php

global $byn_course_db_version;
$byn_course_db_version = "1.0.0";

/**
 * создание таблицы в БД
 */
function create_table_byn_course()
{
    global $wpdb;
    global $byn_course_db_version;

    $table_name = $wpdb->get_blog_prefix() . 'byn_course';
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

    $sql = "CREATE TABLE {$table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time bigint(11) DEFAULT '0' NOT NULL,
            course_array varchar(5000) NOT NULL,
            UNIQUE KEY id (id)
        ) {$charset_collate};";

    // Создать таблицу.
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option("byn_course_db_version", $byn_course_db_version);
}

/**
 * обновление таблицы, сохранение записи полученной из апи
 *
 * @return false|int
 */
function update_byn_course()
{
    global $wpdb;

    // получаем json от банка
    // если приходит пустой, то пробуем пока не придёт, но не более 5 раз
    $string_to_base = null;
    for ($i=0; $i<5; $i++) {
        $string_to_base = file_get_contents('http://www.nbrb.by/API/ExRates/Rates?Periodicity=0');
        if ($string_to_base != null) break;
    }

    $table_name = $wpdb->get_blog_prefix() . 'byn_course';

    // пишем в базу
    $rows_affected = $wpdb->insert($table_name, array(
        'time' => time(),
        'course_array' => $string_to_base
    ) );
    return $rows_affected;
}


/**
 * получаем курс из БД
 *
 * @return mixed
 */
function get_byn_course()
{
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'byn_course';
    $course = $wpdb->get_row( "SELECT * FROM {$table_name} ORDER BY ID DESC LIMIT 1;");
    return $course;
}