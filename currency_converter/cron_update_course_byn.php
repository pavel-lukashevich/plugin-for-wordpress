<?php

// при активации добавляем задачу
register_activation_hook(__FILE__, 'activation_cron_currency_converter');

//
function activation_cron_currency_converter()
{
    // удалим все такие же задачи cron
    wp_clear_scheduled_hook('currency_converter_daily_event');

    // добавим новую cron задачу
    wp_schedule_event( time(), 'daily', 'currency_converter_daily_event');
}

// Проверка существования расписания во время работы плагина на всякий случай
if( ! wp_next_scheduled( 'currency_converter_daily_event' ) ) {
    wp_schedule_event( time(), 'daily', 'currency_converter_daily_event');
}

// обновляем БД
add_action('currency_converter_daily_event', 'update_byn_course');


// При дезактивации плагина удаляем задачу:
register_deactivation_hook(__FILE__, 'deactivation_cron_currency_converter');

function deactivation_cron_currency_converter()
{
    wp_clear_scheduled_hook('currency_converter_daily_event');
}

