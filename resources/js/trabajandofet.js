'use strict';
$(document).ready(function()
{
    $('.show-sub + .br-menu-sub').slideDown();

    $('#btnLeftMenu').on('click', function()
    {
        var menuText = $('.menu-item-label,.menu-item-arrow');

        if($('body').hasClass('collapsed-menu')) 
        {
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
            $('.br-sideleft').one('transitionend', function(e) 
            {
                menuText.removeClass('op-lg-0-force');
                menuText.removeClass('d-lg-none');
            });

            $('#logo_menu').addClass('d-none');
            $('#bars_menu').removeClass('d-none');
        }
        else 
        {
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
            menuText.addClass('op-lg-0-force');
            $('.br-sideleft').one('transitionend', function(e) 
            {
                menuText.addClass('d-lg-none');
            });

            $('#bars_menu').addClass('d-none');
            $('#logo_menu').removeClass('d-none');
        }

        return false;
    });

    $(document).on('mouseover', function(e)
    {
        e.stopPropagation();

        if($('body').hasClass('collapsed-menu') && $('#btnLeftMenu').is(':visible')) 
        {
            var targ = $(e.target).closest('.br-sideleft').length;

            if(targ) 
            {
                $('body').addClass('expand-menu');
                $('.show-sub + .br-menu-sub').slideDown();
                var menuText = $('.menu-item-label,.menu-item-arrow');
                menuText.removeClass('d-lg-none');
                menuText.removeClass('op-lg-0-force');
            } 
            else 
            {
                $('body').removeClass('expand-menu');
                $('.show-sub + .br-menu-sub').slideUp();
                var menuText = $('.menu-item-label,.menu-item-arrow');
                menuText.addClass('op-lg-0-force');
                menuText.addClass('d-lg-none');
            }
        }
    });

    $('.br-menu-link').on('click', function()
    {
        var nextElem = $(this).next();
        var thisLink = $(this);

        if(nextElem.hasClass('br-menu-sub')) 
        {

            if(nextElem.is(':visible')) 
            {
                thisLink.removeClass('show-sub');
                nextElem.slideUp();
            } 
            else 
            {
                $('.br-menu-link').each(function()
                {
                    $(this).removeClass('show-sub');
                });
                $('.br-menu-sub').each(function()
                {
                    $(this).slideUp();
                });
                thisLink.addClass('show-sub');
                nextElem.slideDown();
            }

            return false;
        }
    });

    $('#btnLeftMenuMobile').on('click', function()
    {
        $('body').addClass('show-left');
        $('#logo_menu_mobile').addClass('d-none');
        $('#bars_menu_mobile').removeClass('d-none');
        return false;
    });

    $('#btnRightMenu').on('click', function()
    {
        $('body').addClass('show-right');
        return false;
    });

    $(document).on('click', function(e)
    {
        e.stopPropagation();

        if($('body').hasClass('show-left')) 
        {
            var targ = $(e.target).closest('.br-sideleft').length;

            if(!targ) 
            {
                $('body').removeClass('show-left');
            }

            $('#bars_menu_mobile').addClass('d-none');
            $('#logo_menu_mobile').removeClass('d-none');
        }

        if($('body').hasClass('show-right')) 
        {
            var targ = $(e.target).closest('.br-sideright').length;

            if(!targ) 
            {
                $('body').removeClass('show-right');
            }
        }
    });

    $(function()
    {
        'use strict';
        $(window).resize(function()
        {
            minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() 
        {
            if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1440px)').matches) 
            {
                $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
                $('body').addClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideUp();
            } 
            else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) 
            {
                $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
                $('body').removeClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideDown();
            }
        }
    });

    $('.overflow-y-auto').mCustomScrollbar({
        theme:"minimal-blue",
        axis:"y"
    });

    $('.carousel-x').mCustomScrollbar({
        theme:"minimal",
        axis:"x",
        advanced:{
            autoExpandHorizontalScroll:true
        }
    });

    $('.initialform-y').mCustomScrollbar({
        theme:"minimal-dark",
        axis:"y"
    });

    var interval = setInterval(function() 
    {
        var momentNow = moment();
        momentNow.locale('es');

        $('#brDate').html(momentNow.format('MMMM DD, YYYY') + ' '
            + momentNow.format('dddd')
            .substring(0,3).toUpperCase());

        $('#brTime').html(momentNow.format('hh:mm:ss A'));

    }, 100);

    $.datepicker.regional['es'] = 
    {
        closeText: 'Cerrar',
        prevText: '<< Anterior',
        nextText: 'Siguiente >>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['es']);

    if($().datepicker) 
    {
        $('.form-control-datepicker').datepicker().on("change", function (e) 
        {
            console.log("Date changed: ", e.target.value);
        });
    }

    $('.datepicker').datepicker();

    $('.switch-button').switchButton();

    $('[data-toggle="tooltip"]').tooltip({
        trigger : 'hover'
    });

    $('[data-toggle="tooltip"]').click(function()
    {
        $('[data-toggle="tooltip"]').tooltip('hide');           
    });

    $("#panel-fullscreen").click(function (e) 
    {
        e.preventDefault();
        
        var $this = $(this);
    
        if ($this.children('svg').hasClass('fa-expand-arrows-alt'))
        {
            $this.children('svg').removeClass('fa-expand-arrows-alt');
            $this.children('svg').addClass('fa-compress-arrows-alt');
            $("#panel-fullscreen").attr('data-original-title', 'Contraer');

            $('div.dataTables_scrollBody').height(($(window).height() - 160));
        }
        else if ($this.children('svg').hasClass('fa-compress-arrows-alt'))
        {
            $this.children('svg').removeClass('fa-compress-arrows-alt');
            $this.children('svg').addClass('fa-expand-arrows-alt');
            $("#panel-fullscreen").attr('data-original-title', 'Expandir');

            $('div.dataTables_scrollBody').height(($(window).height() - 350));
        }

        $(this).closest('.panel').toggleClass('panel-fullscreen');

    });

    // $.ajax({
    //     type: 'POST',
    //     url: $path_notifications,
    //     dataType: 'json',
    //     success: function (response) 
    //     {
    //         if (response.data)
    //         {
    //             $('.notifications').removeClass('d-none-force');
    //             $('#notifications_list').append(response.html);
    //         }
    //         else
    //         {
    //             $('.notifications').addClass('d-none-force');
    //         }

    //     }
    // });

    // $('#search_company').select2({
    //     theme: 'bootstrap4',
    //     width: '100%',
    //     language: 'es',
    //     placeholder: 'Seleccionar',
    //     allowClear: true,
    //     ajax: {
    //         url: $path_search_companies,
    //         dataType: 'json',
    //         delay: 250,
    //         data: function(params)
    //         {

    //             return {
    //                 q: params.term,
    //                 page: params.page || 1
    //             };
    //         },
    //         processResults: function(data, params)
    //         {
    //             var page = params.page || 1;
    //             return {
    //                 results: $.map(data.items, function (item)
    //                 {
    //                     return {
    //                         id: item.id,
    //                         text: item.text
    //                     }
    //                 }),
    //                 pagination: {
    //                     more: (page * 10) <= data.total_count
    //                 }
    //             };
    //         }
    //     },
    //     escapeMarkup: function (markup) { return markup; },
    // }).on('change', function (e)
    // {
    //     $('#search_company_text').val($("#search_company option[value='" + $(this).val() + "']").text().trim());
    //     $('#search_project').val(null).trigger('change');
    //     $('#search_project_text').val('');
    // });

    // $('#search_project').select2({
    //     theme: 'bootstrap4',
    //     width: '100%',
    //     language: 'es',
    //     placeholder: 'Seleccionar',
    //     allowClear: true,
    //     ajax: {
    //         url: $path_search_projects,
    //         dataType: 'json',
    //         delay: 250,
    //         data: function(params)
    //         {
    //             var id = $('#search_company option:selected').val();

    //             return {
    //                 q: params.term,
    //                 page: params.page || 1,
    //                 id: id
    //             };
    //         },
    //         processResults: function(data, params)
    //         {
    //             var page = params.page || 1;
    //             return {
    //                 results: $.map(data.items, function (item)
    //                 {
    //                     return {
    //                         id: item.id,
    //                         text: item.text
    //                     }
    //                 }),
    //                 pagination: {
    //                     more: (page * 10) <= data.total_count
    //                 }
    //             };
    //         }
    //     },
    //     escapeMarkup: function (markup) { return markup; },
    // }).on('change', function (e)
    // {
    //     $('#search_project_text').val($("#search_project option[value='" + $(this).val() + "']").text().trim());
    // });

    $('#form_search_project').ajaxForm(
    {
        dataType:  'json',
        success:   function(response)
        {
            location.reload();
        }
    });

    // session_company_project_gral();

    $('#btn_gral_search').click(function()
    {
        $('#form_search_project .form-control').removeClass('error');
        $('#modal_gral_search').modal('show');          
    });

    $('#btn_gral_cancel, #btn_modal_gral_cancel').click(function()
    {
        $.ajax({
            type: 'POST',
            url: $path_cleargeneralsearch,
            dataType: 'json',
            success: function (response) 
            {
                location.reload();
            }
        });
    });
});

function trace($path_trace, idname, id)
{
    $('#text_global_trace').addClass('d-none');
    $('.br-pagebody').attr('style', 'cursor: wait;');
    $('#modal_trace').iziModal({
        title: 'Histórico del registro',
        icon: 'fas fa-history',
        headerColor: '#224978',
        zindex: 9999,
        onClosing: function()
        {
            $('#create_trace span').html('');
            $('#edit_trace span').html('');
            $('#edit_trace').addClass('d-none');
        }
    });

    var data     =  {};
    data[idname] =  id;

    $.ajax({
        type: 'POST',
        url: $path_trace,
        data: data,
        dataType: 'json',
        success: function (response) 
        {
            $('.br-pagebody').attr('style', 'cursor: auto;');

            if (response.data)
            {
                var row_thead   =   '<thead>'
                                +   '<tr>'
                                +   '<th class="wd-30p-force p-2">Acción</th>'
                                +   '<th class="wd-35p-force p-2">Fecha</th>'
                                +   '<th class="wd-35p-force p-2">Usuario</th>'
                                +   '</tr>'
                                +   '</thead>';

                var row_tbody  =   '<tbody>'
                                +   '<tr>'
                                +   '<td><b>Creación</b></td>'
                                +   '<td class="text-center">' + response.data.date_insert + '</td>'
                                +   '<td class="text-center">' + (response.data.user_insert ? response.data.user_insert: 'N/A') + '</td>'
                                +   '</tr>'
                                +   '</tbody>';

                if (response.data.user_update != null && response.data.user_update != '') 
                {
                    row_tbody  +=   '<tbody>'
                                +   '<tr>'
                                +   '<td><b>Última edición</b></td>'
                                +   '<td class="text-center">' + response.data.date_update + '</td>'
                                +   '<td class="text-center">' + response.data.user_update + '</td>'
                                +   '</tr>'
                                +   '</tbody>';
                }

                $('#row_trace').html(row_thead + row_tbody);

                var data_global = response.data_global;

                if ((data_global != false) && (data_global.length > 1))
                {
                    var row_thead   =   '<thead>'
                                    +   '<tr>'
                                    +   '<th class="wd-10p-force p-2">No</th>'
                                    +   '<th class="wd-40p-force p-2">Fecha</th>'
                                    +   '<th class="wd-40p-force p-2">Usuario</th>'
                                    +   '</tr>'
                                    +   '</thead>';

                    var row_tbody   =  '<tbody>';

                    for (var i = 1; i < data_global.length; i++)
                    {
                        row_tbody   +=  '<tbody>'
                                    +   '<tr>'
                                    +   '<td class="text-center">' + i + '</td>'
                                    +   '<td class="text-center">' + data_global[i]['date_update'] + '</td>'
                                    +   '<td class="text-center">' + data_global[i]['user_update'] + '</td>'
                                    +   '</tr>';
                    }

                    row_tbody   +=  '</tbody>';

                    $('#global_trace').html(row_thead + row_tbody);

                    $('#text_global_trace').removeClass('d-none');
                }

                $('#modal_trace').iziModal('open'); 
            }           
            else
            {
                modal_alert(response.data, response.message);
            } 

        },
        error: function () 
        {
            modal_alert(false, 'Error de conexión.');
        }
    });

    $('#btn_close_trace').on('click', function() 
    {
        $('#modal_trace').iziModal('close');
        $('#row_trace').html('');
        $('#global_trace').html('');
    });

    $('#btn_cancel_trace').on('click', function() 
    {
        $('#row_trace').html('');
        $('#global_trace').html('');
        $('#modal_trace').modal('hide');
    });
}

function new_trace($path_trace, idname, id)
{
    $('#text_global_trace').addClass('d-none');
    $('.br-pagebody').attr('style', 'cursor: wait;');

    var data     =  {};
    data[idname] =  id;

    $.ajax({
        type: 'POST',
        url: $path_trace,
        data: data,
        dataType: 'json',
        success: function (response) 
        {
            $('.br-pagebody').attr('style', 'cursor: auto;');

            if (response.data)
            {
                var row_thead   =   '<thead>'
                                +   '<tr>'
                                +   '<th class="wd-30p-force p-2">Acción</th>'
                                +   '<th class="wd-35p-force p-2">Fecha</th>'
                                +   '<th class="wd-35p-force p-2">Usuario</th>'
                                +   '</tr>'
                                +   '</thead>';

                var row_tbody  =   '<tbody>'
                                +   '<tr>'
                                +   '<td><b>Creación</b></td>'
                                +   '<td class="text-center">' + response.data.date_insert + '</td>'
                                +   '<td class="text-center">' + (response.data.user_insert ? response.data.user_insert: '') + '</td>'
                                +   '</tr>'
                                +   '</tbody>';

                if (response.data.user_update != null && response.data.user_update != '') 
                {
                    row_tbody  +=   '<tbody>'
                                +   '<tr>'
                                +   '<td><b>Última edición</b></td>'
                                +   '<td class="text-center">' + response.data.date_update + '</td>'
                                +   '<td class="text-center">' + response.data.user_update + '</td>'
                                +   '</tr>'
                                +   '</tbody>';
                }

                $('#row_trace').html(row_thead + row_tbody);

                var data_global = response.data_global;

                if ((data_global != false) && (data_global.length > 1))
                {
                    var row_thead   =   '<thead>'
                                    +   '<tr>'
                                    +   '<th class="wd-10p-force p-2">No</th>'
                                    +   '<th class="wd-40p-force p-2">Fecha</th>'
                                    +   '<th class="wd-40p-force p-2">Usuario</th>'
                                    +   '</tr>'
                                    +   '</thead>';

                    var row_tbody   =  '<tbody>';

                    for (var i = 1; i < data_global.length; i++)
                    {
                        row_tbody   +=  '<tbody>'
                                    +   '<tr>'
                                    +   '<td class="text-center">' + i + '</td>'
                                    +   '<td class="text-center">' + data_global[i]['date_update'] + '</td>'
                                    +   '<td class="text-center">' + data_global[i]['user_update'] + '</td>'
                                    +   '</tr>';
                    }

                    row_tbody   +=  '</tbody>';

                    $('#global_trace').html(row_thead + row_tbody);
                    $('#global_trace').removeClass('d-none');
                    $('#text_global_trace').removeClass('d-none');
                }

                $('.div-views').addClass('d-none');
                $('#view_trace').removeClass('d-none');
            }           
            else
            {
                modal_alert(response.data, response.message);
            } 

        },
        error: function () 
        {
            modal_alert(false, 'Error de conexión.');
        }
    });

    $('#btn_close_trace').on('click', function() 
    {
        $('.div-views').addClass('d-none');
        $('#view_table').removeClass('d-none');
        $('#row_trace').html('');
        $('#global_trace').html('');
    });
}

function size_validate(id, size)
{
    var file = $('#' + id)[0].files[0];
    
    if (file != undefined) 
    {
        if (file.size > size) 
        {
            var user = (file.size)/1000000;
            var permit = (size)/1000000;

            modal_alert(false, 'El archivo excede el tamaño máximo permitido de ' + permit + ' MB, actualmente tiene un tamaño de ' + user.toFixed(2) + ' MB.');
            return false;
        }
        else
        {
            return true;
        }
    }
    else
    {
        return true;
    }
}

function modal_alert(data, message)
{  
    iziToast.show(
    {
        backgroundColor: (data ? '#D5E6D3' : '#F6D6D6'),
        color: (data ? '#40AC2F' : '#DE3030'),
        icon: (data ? 'far fa-smile' : 'far fa-frown'),
        iconColor: (data ? '#8CBB85' : '#FE7676'),
        maxWidth: 420,
        message: '<br/>' + message,
        messageColor: (data ? '#8CBB85' : '#FE7676'),
        position: 'topRight',
        timeout: 5000,
        title: (data ? '¡Bien hecho!' : '¡Atención!'),
        titleColor: (data ? '#40AC2F' : '#DE3030')
    });

    var defaultTable = $('#default_table').DataTable();
    defaultTable.ajax.reload();

    if (data)
    {
        $('#view_table').removeClass('d-none');        
    }
}

function modal_alert_warning(message)
{  
    iziToast.show(
    {
        backgroundColor: '#FCF9C6',
        color: '#B2AD5E',
        icon: 'far fa-meh',
        iconColor: '#D4CD57',
        maxWidth: 420,
        message: '<br/>' + message,
        messageColor: '#D4CD57',
        position: 'topRight',
        timeout: 5000,
        title: '¡Cuidado!',
        titleColor: '#B2AD5E'
    });

    var defaultTable = $('#default_table').DataTable();
    defaultTable.ajax.reload();

    if (data)
    {
        $('#view_table').removeClass('d-none');        
    }
}

function modal_alert_and_continue(data, message)
{  
    iziToast.show(
    {
        backgroundColor: (data ? '#D5E6D3' : '#F6D6D6'),
        color: (data ? '#40AC2F' : '#DE3030'),
        icon: (data ? 'far fa-smile' : 'far fa-frown'),
        iconColor: (data ? '#8CBB85' : '#FE7676'),
        maxWidth: 420,
        message: '<br/>' + message,
        messageColor: (data ? '#8CBB85' : '#FE7676'),
        position: 'topRight',
        timeout: 5000,
        title: (data ? '¡Bien hecho!' : '¡Atención!'),
        titleColor: (data ? '#40AC2F' : '#DE3030')
    });
}

function modal_alert_and_event(data, message, event)
{  
    iziToast.show(
    {
        backgroundColor: (data ? '#D5E6D3' : '#F6D6D6'),
        color: (data ? '#40AC2F' : '#DE3030'),
        icon: (data ? 'far fa-smile' : 'far fa-frown'),
        iconColor: (data ? '#8CBB85' : '#FE7676'),
        maxWidth: 420,
        message: '<br/><br/>' + message,
        messageColor: (data ? '#8CBB85' : '#FE7676'),
        position: 'topRight',
        timeout: 3000,
        title: (data ? '¡Bien hecho!' : '¡Atención!'),
        titleColor: (data ? '#40AC2F' : '#DE3030'),
        onClosed: function() {
            event();
        }
    });
}

function modal_alert_and_url(data, message, url)
{  
    iziToast.show(
    {
        backgroundColor: (data ? '#D5E6D3' : '#F6D6D6'),
        color: (data ? '#40AC2F' : '#DE3030'),
        icon: (data ? 'far fa-smile' : 'far fa-frown'),
        iconColor: (data ? '#8CBB85' : '#FE7676'),
        maxWidth: 420,
        message: '<br/><br/>' + message,
        messageColor: (data ? '#8CBB85' : '#FE7676'),
        position: 'topRight',
        timeout: 3000,
        title: (data ? '¡Bien hecho!' : '¡Atención!'),
        titleColor: (data ? '#40AC2F' : '#DE3030')
    });

    setTimeout(function()
    {
        $('#loading').addClass('d-none');
        location.href = url;
    }, 6000);
}

function cut_text(param, count)
{
    var count_param = param.length;

    if (count_param > count)
    {
        return param.substring(0,count) + '...';
    }
    else
    {
        return param;
    }
}

function replace_all(text, search, txtreplace)
{
    while (text.toString().indexOf(search) != -1)
        text = text.toString().replace(search, txtreplace);

    return text;
}

function convert_money(amount) 
{
    amount += '';
    amount = parseFloat(amount.replace(/[^0-9\.]/g, ''));
    var decimals = 0;

    decimals = decimals || 0; 

    if (isNaN(amount) || amount === 0) 
    {
        return parseFloat(0).toFixed(decimals);
    }

    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
    {
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
    }

    return amount_parts.join('.');
}

function convert_pointer(amount) 
{
    amount += '';
    amount = parseFloat(amount.replace(/[^0-9\.]/g, ''));
    var decimals = 0;

    decimals = decimals || 0; 

    if (isNaN(amount) || amount === 0) 
    {
        return parseFloat(0).toFixed(decimals);
    }

    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
    {
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');
    }

    return amount_parts.join('.');
}

function copy_to_clipboard(element)
{
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).html()).select();
    document.execCommand("copy");
    $temp.remove();
}

// function session_company_project_gral()
// {
//     if (session_company_gral != '')
//     {
//         var option_gral = new Option(session_company_text_gral, session_company_gral, true, true);
//         $('#search_company').append(option_gral).trigger('change');
//         $('#search_company_text').val(session_company_text_gral);
//         var option = new Option(session_company_text_gral, session_company_gral, true, true);
//         $('#id_company').val(session_company_gral);
//         $('#id_company').append(option).trigger('change');
//         $('#text_company').val(session_company_text_gral);
//     }
    
//     if (session_project_gral != '')
//     {
//         var option_gral = new Option(session_project_text_gral, session_project_gral, true, true);
//         $('#search_project').append(option_gral).trigger('change');
//         $('#search_project_text').val(session_project_text_gral);
//         var option = new Option(session_project_text_gral, session_project_gral, true, true);
//         $('#id_project').val(session_project_gral);
//         $('#id_project').append(option).trigger('change');
//         $('#text_project').val(session_project_text_gral);
//     }
// }