$(document).ready(function(){
    $('#filter_form').submit(function(e){ //Применение фильтров
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
});