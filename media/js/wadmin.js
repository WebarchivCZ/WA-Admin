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
	
	  $("select#category_select").change(function(){
		  pathArray = window.location.pathname.split( '/' );
		  var url = window.location.protocol + "//" + window.location.host + "/" + pathArray[1];

	    $.getJSON(url+"/suggest/get_subcategories/"+$(this).val(), '' , function(j){
	      var options = '';
	      for (var i = 0; i < j.length; i++) {
	        options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>\n';
	      }
	      $("select#subcategory_select").html(options);
	    })
	  });


    $("table.listing tr").hover(
         function() {$(this).find("td").css('background-color', '#CCC')},
         function() {$(this).find("td").css('background-color', '')}
      );

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
        msg: '<br /><b>POZOR!</b> Touto akcí vymažete vydavatele od všech zdrojů! Chcete opravdu pokračovat? <br />',
        buttons: {
            ok: 'Ano',
            cancel: 'Ne',
            wrapper:'<button></button>',
            separator:'&nbsp;&nbsp;  '
        }
    });

    $('a.delete_contract_conf').click(function() {
        window.location = $(this).attr('href');
        return false;
    });

    // smazani vydavatele
    $('a.delete_contract_conf').confirm({
        timeout:5000,
        dialogShow:'fadeIn',
        dialogSpeed:'slow',
        msg: '<br /><b>POZOR!</b> Touto akcí vymažete smlouvu od všech zdrojů! Chcete opravdu pokračovat? <br />',
        buttons: {
            ok: 'Ano',
            cancel: 'Ne',
            wrapper:'<button></button>',
            separator:'&nbsp;&nbsp;  '
        }
    });
}
);