<?php
/**
 * @package Currency_Converter
 * @version 1.0
 */
/*
Plugin Name: Калькулятор валют
Description: Курс валют на сегодня.
Author: Павел Лукашевич
Version: 1.0
Author URI: https://github.com/pavel-lukashevich
*/

//подключаем файлы с классами и функциямия
include_once 'table_byn_course.php';
include_once 'widget.php';

// добавляем таблицу при активации
register_activation_hook(__FILE__, 'create_table_byn_course');

// делаем запись в БД
register_activation_hook(__FILE__, 'update_byn_course');

// добавляем обновление таблицы в крон
include_once 'cron_update_course_byn.php';

// читаем последнюю запись из БД
$my_byn_cours = get_byn_course();

//регистрируем виджет
function currency_converter_register_widget()
{
    register_widget('Currency_Converter_Widget');
}

add_action('widgets_init', 'currency_converter_register_widget');

// подключаем стили
function currency_converter_enqueue_style()
{
    $purl = plugins_url('/bootstrap.min.css', __FILE__);
    wp_register_style('bootstrap', $purl);
    wp_enqueue_style('bootstrap');
}

add_action('wp_enqueue_scripts', 'currency_converter_enqueue_style');

// подключаем стили
function currency_converter_button_script()
{
    $purl = plugins_url('', __FILE__);

    wp_deregister_script('jquery');
    wp_register_script('jquery', $purl . '/jquery-3.3.1.min.js', false, false, true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('currency_converter_button', $purl . '/currency_converter_button_script.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'currency_converter_button_script');

?>