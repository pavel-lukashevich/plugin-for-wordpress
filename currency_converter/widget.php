<?php

class Currency_Converter_Widget extends WP_Widget
{
    // дата записи в БД
    public $base_date;

    // массив c валютами
    public $my_bin_course;

    // кнопки по умолчанию
    public $button_1 = 'USD';
    public $button_2 = 'EUR';
    public $button_3 = 'RUB';

    /**
     * конструктор
     *
     * Currency_Converter_Widget constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'Currency_Converter_Widget',
            'Конвертер байруб',
            array('description' => 'конвертер валют', 'Currency_Converter_Widget_domain')
        );
        // дата
        $base_request = get_byn_course();
        $this->base_date = date('d.m.Y', $base_request->time);

        // массив c валютами
        $new_array = json_decode($base_request->course_array);
        for ($i = 0; $i < count($new_array); $i++) {
            $this->my_bin_course[$new_array[$i]->Cur_Abbreviation] = array(
                'count' => $new_array[$i]->Cur_Scale,
                'rate' => $new_array[$i]->Cur_OfficialRate,
                'name' => $new_array[$i]->Cur_Name,
            );
        }
    }

    /**
     * внешний вид виджета, для посетителей
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        echo "<div class='text-center'><h3>Калькулятор валют</h3>";

        // быстрые кнопки валют
        echo '<div class="btn-group" role="group" aria-label="...">

			  <button type="button" id="currency-converter-button-1" class="btn btn-sm btn-default btn-primary" 
			    data-name="' . $instance['select-btn-1'] . '"
			    data-count="' . $this->my_bin_course[$instance['select-btn-1']]['count'] . '"
			    data-rate="' . $this->my_bin_course[$instance['select-btn-1']]['rate'] .
            '"> BYN-' . $instance['select-btn-1'] . ' </button>
			    
			  <button type="button" id="currency-converter-button-2" class="btn btn-sm btn-default" 
			    data-name="' . $instance['select-btn-2'] . '"
			    data-count="' . $this->my_bin_course[$instance['select-btn-2']]['count'] . '"
			    data-rate="' . $this->my_bin_course[$instance['select-btn-2']]['rate'] .
            '"> BYN-' . $instance['select-btn-2'] . ' </button>
			    
			  <button type="button" id="currency-converter-button-3" class="btn btn-sm btn-default" 
			    data-name="' . $instance['select-btn-3'] . '"
			    data-count="' . $this->my_bin_course[$instance['select-btn-3']]['count'] . '"
			    data-rate="' . $this->my_bin_course[$instance['select-btn-3']]['rate'] .
            '"> BYN-' . $instance['select-btn-3'] . ' </button>
			    
			</div><br><br>';

        // поля-инпуты
        echo '<div class="row">
					 <div class="col-xs-2"></div>
					 <div class="col-xs-8">
                        <div class="input-group input-group-sm">
                        <input id="currency-converter-inpyt-byn" type="number" min="0" class="form-control" value="" 
                         placeholder="' . $this->my_bin_course[$instance['select-btn-1']]['rate'] . '">
                        <span class="input-group-addon"> BYN </span>
                        </div><br>
                        <div class="input-group input-group-sm">
                        <input id="currency-converter-inpyt-currency" type="number" min="0" class="form-control" value="" 
                         placeholder="' . $this->my_bin_course[$instance['select-btn-1']]['count'] . '">
                        <span id="currency-converter-span-currency" class="input-group-addon"> ' . $instance['select-btn-1'] . ' </span>
                        </div>
					 </div>
					 <div class="col-xs-2"></div>				  
				 </div>';

        echo '<small>курс обновлён ' . $this->base_date . '</small>
			</div><br>';
    }

    /**
     * отображение виджета в админке
     *
     * @param array $instance
     * @return string|void
     */
    public function form($instance)
    {
        echo '<h4>выберите валюту:</h4>';

        //выбор кнопки 1
        echo '<div>кнопка 1 :';
        echo '<select name="' . $this->get_field_name('select-btn-1') . '">';
        foreach ($this->my_bin_course as $key => $value)
            echo '<option ' . selected($key, $instance['select-btn-1'], false) .
                ' value="' . $key . '">' . $key . ' - ' . $value['name'] . '</option>';
        echo '</select></div>';

        //выбор кнопки 2
        echo '<div>кнопка 2 :';
        echo '<select name="' . $this->get_field_name('select-btn-2') . '">';
        foreach ($this->my_bin_course as $key => $value)
            echo '<option ' . selected($key, $instance['select-btn-2'], false) .
                ' value="' . $key . '">' . $key . ' - ' . $value['name'] . '</option>';
        echo '</select></div>';

        //выбор кнопки 3
        echo '<div>кнопка 3 :';
        echo '<select name="' . $this->get_field_name('select-btn-3') . '">';
        foreach ($this->my_bin_course as $key => $value)
            echo '<option ' . selected($key, $instance['select-btn-3'], false) .
                ' value="' . $key . '">' . $key . ' - ' . $value['name'] . '</option>';
        echo '</select></div>';
    }

    /**
     * сохранение настроек виджета
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();

        $instance['select-btn-1'] = (!empty($new_instance['select-btn-1'])) ? $new_instance['select-btn-1'] : $this->button_1;
        $instance['select-btn-2'] = (!empty($new_instance['select-btn-2'])) ? $new_instance['select-btn-2'] : $this->button_2;
        $instance['select-btn-3'] = (!empty($new_instance['select-btn-3'])) ? $new_instance['select-btn-3'] : $this->button_3;

        return $instance;
    }
}


