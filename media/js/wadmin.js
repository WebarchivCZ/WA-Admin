$(document).ready(function () {

    // dashboard - display all
    var pageID = $('body').attr('id');

    $(".dashboard #show-all").click(function () {
        $(".dashboard table tr.hidden").toggle();
        $(".dashboard .show-all").hide();
    })

    $("form div.problem").click(function () {
        $(this).css('background-color', 'lightgreen');
        var id = $(this).attr('id');
        $("form div.problem#" + id + " div.solution").toggle();
    });

    $("select#category_select").change(function () {
        pathArray = window.location.pathname.split('/');
        var url = window.location.protocol + "//" + window.location.host + "/" + pathArray[1];

        $.getJSON(url + "/suggest/get_subcategories/" + $(this).val(), function (j) {
            var options = '<option value=""></option>\n';
            for (var i = 0; i < j.length; i++) {
                options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>\n';
            }
            $("select#subcategory_select").html(options);
        })
    });

    $("input[name=proxy_fine]").change(function () {
        $("#proxy_comments").toggle();
    });

    $("form[name=qa_form] .problem input").change(function () {
        var comments = this.name + '_comments';
        var url = this.name + '_url';
        $("p#" + comments).toggle();
        $("p#" + url).toggle();
    });

    $("table.listing tr").hover(
        function () {
            $(this).find("td").css('background-color', '#CCC')
        },
        function () {
            $(this).find("td").css('background-color', '')
        }
    );

    $("#section-rating").click(function () {
        $("#table-ratings").toggle();
    });

    // smazani prirazeni vydavatele ke zdroji
    $('a.confirm').click(
        function (event) {
            window.location = $(this).attr('href');
            return false;
        }).confirm({timeout:5000,
            dialogShow:'fadeIn',
            dialogSpeed:'slow',
            msg:'Určitě?',
            buttons:{
                ok:'Ano',
                cancel:'Ne',
                wrapper:'<button></button>',
                separator:'&nbsp;&nbsp;  '
            }
        });

    // smazani smlouvy
    $('a.delete_contract_conf').click(
        function () {
            window.location = $(this).attr('href');
        }).confirm({
            timeout:5000,
            dialogShow:'fadeIn',
            dialogSpeed:'slow',
            msg:'<br /><b>POZOR!</b> Touto akcí vymažete smlouvu od všech zdrojů! Chcete opravdu pokračovat? <br />',
            buttons:{
                ok:'Ano',
                cancel:'Ne',
                wrapper:'<button></button>',
                separator:'&nbsp;&nbsp;  '
            }
        });

    // zobrazeni jednotliveho zaznamu zdroje
    if (new RegExp("resources/view").test(pageID)) {

        var final_rating = $('select#final_rating').val();
        if (final_rating == 2) {
            $('#p_crawl_freq').show();
        } else if (final_rating == 3) {
            $('#p_reevaluate_date').show();
        }

        //pri zmene hodnoceni na mozna je treba zajistit zobrazeni "prehodnotit k" nebo pri ano "frekvence sklizeni"
        $('select#final_rating').change(function () {
            $('.hidden_toggle_elements').hide();
            if (this.value == 3) {
                $('#p_reevaluate_date').show();
            } else if (this.value == 2) {
                $('#p_crawl_freq').show();
            }
        });
    }

    //pri zaskrtnuti blanko_smlouva, zobrazit url pro blanko
    if (!$('input#blanco_contract').attr('checked')) {
        $('input#domain').attr('disabled', true);
    }
    $('input#blanco_contract').click(function () {
        var domain = $('input#domain');
        if ($(this).is(':checked')) {
            domain.attr('disabled', false);
        }
        else {
            domain.attr('disabled', true);
        }
    })

    // nastylovani tab zalozek
    $(function () {
        $("#tabs").tabs();
    });

    // nastylovani tlacitek
    $("button, input:submit, .button_file").button();
    $(".icon").button("destroy");
    $("input#reevaluate_date").datepicker({ dateFormat:'dd.mm.yy' });
    $("input#date").datepicker({ dateFormat:'dd.mm.yy' });
    $("input.date_today").datepicker({ dateFormat:'dd.mm.yy', gotoCurrent:true });

    $.datepicker.setDefaults($.datepicker.regional['cs']);

    $('.send_new_window').click(function () {
        $(this).parent().attr('target', '_blank');
    });


    $("#assign_addendum_button")
        .click(function () {
            $("#assign_addendum_dialog").dialog("open");
        });

    $('#assign_addendum_dialog').dialog(
        {
            autoOpen:false,
            height:150,
            width:350,
            modal:true,
            buttons:{
                "Přiřadit dodatek":function () {
                    $("#addendum_form").submit();
                }
            },
            Cancel:function () {
                $(this).dialog("close");
            }
        }
    )

    $('#date_signed').datepicker();

    // thumbnails in lightbox
    $('a.thumbnail').lightBox();

    $('.accordion').accordion({autoHeight:false});
});

/* Czech initialisation for the jQuery UI date picker plugin. */
/* Written by Tomas Muller (tomas@tomas-muller.net). */
jQuery(function ($) {
    $.datepicker.regional['cs'] = {
        closeText:'Zavřít',
        prevText:'&#x3c;Dříve',
        nextText:'Později&#x3e;',
        currentText:'Nyní',
        monthNames:['leden', 'únor', 'březen', 'duben', 'květen', 'červen',
            'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec'],
        monthNamesShort:['led', 'úno', 'bře', 'dub', 'kvě', 'čer',
            'čvc', 'srp', 'zář', 'říj', 'lis', 'pro'],
        dayNames:['neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'],
        dayNamesShort:['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
        dayNamesMin:['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
        weekHeader:'Týd',
        dateFormat:'dd.mm.yy',
        firstDay:1,
        isRTL:false,
        showMonthAfterYear:false,
        yearSuffix:''};
    $.datepicker.setDefaults($.datepicker.regional['cs']);
});
