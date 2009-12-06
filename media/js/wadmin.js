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

    $('a.confirm').click(function() {
        window.location = $(this).attr('href');
        return false;
    });

    // The most simple use.
    $('a.confirm').confirm({
        timeout:5000,
        dialogShow:'fadeIn',
        dialogSpeed:'slow',
        msg: '<br />Určitě?<br />',
        buttons: {
            ok: 'Ano',
            cancel: 'Ne',
            wrapper:'<button></button>',
            separator:'&nbsp;&nbsp;  '
        }
    });

}
);