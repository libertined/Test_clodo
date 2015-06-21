$(document).ready(function(){
    //Применение фильтров
    $('#filter_form').submit(function(e){
        e.preventDefault();
        var m_method=$(this).attr('method');
        var m_action=$(this).attr('action');
        var m_data=$(this).serialize();
        $.ajax({
            type: m_method,
            url: m_action,
            data: m_data,
            success: function(result){ $('.content').html(result); }
        });
    });

    //Календарик
    $( ".datepicker" ).datepicker({defaultDate:0, dateFormat:'dd.mm.yy'});

    //Модальное окно
    $(document).on("click", ".js-btn-email", function (event){
        event.preventDefault();
        $curRow = $(this).closest(".users-table__row");
        $curEmail = $curRow.children(".users-table__email").text();
        $curName = $curRow.children(".users-table__fio").text();
        $('#js-modal .js-email').val($curEmail);
        $('#js-modal .js-fio').text($curName);
        //Передаем значения
        $('#overlay').fadeIn(400,
            function(){
                $('#js-modal')
                    .css('display', 'block')
                    .animate({opacity: 1, top: '50%'}, 200);
            });
    });

    /* Закрытие модального окна, тут делаем то же самое но в обратном порядке */
    $('#js-modal .modal__close, #overlay').click( function(){ // ловим клик по крестику или подложке
        $('#js-modal')
            .animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
            function(){ // после анимации
                $(this).css('display', 'none'); // делаем ему display: none;
                $('#overlay').fadeOut(400); // скрываем подложку
                $('#js-modal .js-email').val('');
                $('#js-modal .js-fio').text('Имя');
                $('#js-modal .js-comment').val('');
                $('#js-modal .js-msg').hide();
            }
        );
    });

    $('#js-modal form').submit(function(e){
        e.preventDefault();
        var m_method=$(this).attr('method');
        var m_action=$(this).attr('action');
        var m_data=$(this).serialize();
        $.ajax({
            type: m_method,
            url: m_action,
            data: m_data,
            dataType: "json",
            success: function(result){
                if(result.error != ''){
                    $('#js-modal .js-msg').text(result.error);
                    $('#js-modal .js-msg').removeClass("modal__msg--sucsess");
                    $('#js-modal .js-msg').addClass("modal__msg--error");
                    $('#js-modal .js-msg').show();
                }
                else{
                    $('#js-modal .js-msg').text(result.text);
                    $('#js-modal .js-msg').removeClass("modal__msg--error");
                    $('#js-modal .js-msg').addClass("modal__msg--sucsess");
                    $('#js-modal .js-msg').show();
                }
            }
        });
    });
})