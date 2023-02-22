$(document).ready(function() {

    $('.btn_parse').click(function() {
        $(this).hide();
        let td = $(this).closest('td');
        td.html('<img src="/images/loading.gif" style="width:16px;height:16px;"> Parsing... ');

    });

});

