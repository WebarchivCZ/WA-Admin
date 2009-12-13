//$(document).ready(function(){
//
//    // Funkce na kontroleru progress/new_contract - prirazuje jiz existujici smlouvu
//    $(".contract-name").click(function () {
//        contract = $.trim($(this).text());
//        contract_array = contract.split('/', 2);
//        contract_no = contract_array[0];
//        year = contract_array[1];
//        $("#contract_no").val(contract_no);
//        $("#year").val(year);
//    });
//
//});

$(document).ready(function () {
    $("#section-rating").click(function () {
        $("#table-ratings").toggle();
    });

    $('a.remove_from_resource_conf').click(function() {
        window.location = $(this).attr('href');
        return false;
    });

    // smazani prirazeni vydavatele ke zdroji
    $('a.remove_from_resource_conf').confirm({
        timeout:5000,
        dialogShow:'fadeIn',
        dialogSpeed:'slow',
        msg: 'Určitě?',
        buttons: {
            ok: 'Ano',
            cancel: 'Ne',
            wrapper:'<button></button>',
            separator:'&nbsp;&nbsp;  '
        }
    });
    
    $('a.delete_publisher_conf').click(function() {
        window.location = $(this).attr('href');
        return false;
    });

    // smazani vydavatele
    $('a.delete_publisher_conf').confirm({
        timeout:5000,
        dialogShow:'fadeIn',
        dialogSpeed:'slow',
        msg: '<br />Opravdu chcete smazat vydavatele a odstranit propojení od všech jeho zdrojů?<br />',
        buttons: {
            ok: 'Ano',
            cancel: 'Ne',
            wrapper:'<button></button>',
            separator:'&nbsp;&nbsp;  '
        }
    });

}
);