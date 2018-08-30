jQuery(function($){
    $(document).ready(function () {

        //меняем значение курсов валют и название второго инпута
        function change_value(ths, e) {

            $('#currency-converter-button-1').removeClass('btn-primary');
            $('#currency-converter-button-2').removeClass('btn-primary');
            $('#currency-converter-button-3').removeClass('btn-primary');

            var parent = $(ths);
            parent.addClass(' btn-primary');
            e.preventDefault();

            var name = $(ths).attr('data-name');
            var count = $(ths).attr('data-count');
            var rate = $(ths).attr('data-rate');

            var byn = $('#currency-converter-inpyt-byn');
            var currency = $('#currency-converter-inpyt-currency');

            byn.attr('placeholder', rate);
            currency.attr('placeholder', count);
            byn.val('');
            currency.val('');
            $('#currency-converter-span-currency').html(name);
        }

        // обработка кнопки 1
        $('#currency-converter-button-1').click(function(e) {

            change_value(this, e);
        });

        // обработка кнопки 2
        $('#currency-converter-button-2').click(function(e) {

            change_value(this, e);
        });

        // обработка кнопки 3
        $('#currency-converter-button-3').click(function(e) {

            change_value(this, e);
        });

        // изменение значения в первом инпуте
        $('#currency-converter-inpyt-byn').on('input', function() {
            var rate = $('#currency-converter-inpyt-currency');
            var val = $(this).val();
            var currency = Number(val) * rate.attr('placeholder') / $(this).attr('placeholder');

            $(this).val(val);
            rate.val(currency);
        });

        // изменение значения во втором инпуте
        $('#currency-converter-inpyt-currency').on('input', function() {
            var rate = $(this);
            var val = $(this).val();
            var byn = $('#currency-converter-inpyt-byn');
            var byn_rub = Number(val) / rate.attr('placeholder') * byn.attr('placeholder');

            $(this).val( val);
            byn.val( byn_rub);
        });
    });
});


