$('#btn_restart_table').on('click', function()
{
    console.log($(this))
    $('#modal_restart_table').modal('show');
});

$('#btn_confirm_restart').on('click', function ()
{
    $.ajax({
        type: 'GET',
        url: $path_restart,
        dataType: 'json',
        success: function (response)
        {
            modal_alert(response.value, response.message);
            $('#modal_restart_table').modal('hide');
            data_list();
        },
        error: function () {
            modal_alert(false, 'Error de conexión.');
            $('#modal_restart_table').modal('hide');
        }
    });
});

$('#btn_cancel_restart').on('click', function ()
{
    
    $('#modal_restart_table').modal('hide');
});

$('#btn_total_cost').on('click', function ()
{
    $.ajax({
        type: 'GET',
        url: $path_total_cost_product,
        dataType: 'json',
        success: function (response)
        {
            data_list();
           $('#cost_total').html('');
           $('#cost_total').append(response.content);
        }
    });
    $('#modal_cost').modal('show');
});


$('#btn-select').on('click', function ()
{
    console.log('ocultar')
    $('.chk-id').toggleClass('ocultar');
});

$('#btn_ck_delete').on('click', function()
{
    if( $('input:checkbox[class=delete_checkbox]:checked ').prop('checked') ) {
        
        console.log($(this));
        $('#modal_ck_delete').modal('show');
    }
    else{

        modal_alert(false, 'No ha seleccionado productos, porfavor seleccione.');
        $('#modal_ck_delete').modal('hide');

    }
    
    
});

$('#btn_ck_confirm_delete').on('click', function ()
{
    var ids_array = [] ;
    $ ( " input:checkbox[class=delete_checkbox]:checked ").each (function (){
        ids_array.push ($(this).val ());
    });

    if(ids_array.length>0){
      console.log(ids_array);
        $.ajax({
            type: 'POST',
            url: $path_ck_drop,
            data: {ids_array: ids_array},
            dataType: 'json',
            success: function (response)
            {
                modal_alert(response.value, response.message);
                $('#modal_ck_delete').modal('hide');
                data_list();
            },
            error: function () {
                modal_alert(false, 'Error de conexión.');
                $('#modal_ck_delete').modal('hide');
            }
        });

    }
    
});

$('#btn_ck_cancel_delete').on('click', function ()
{
    $('#modal_ck_delete').modal('hide');
});

$(function($)
{
    let timeoutID = null;
    data_list();

    $('.search_list').keyup(function(e) {
        clearTimeout(timeoutID);
        timeoutID = setTimeout(() => data_list(), 1000)
    });

    


    $( ".photo-file" ).change(function(e)
    {
        if ($( ".photo-file" ).val() != '')
        {
            let reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);

            reader.onload = function()
            {
                $('.product-photo').attr('src', reader.result)
            };
        }
        else
        {
            $('.product-photo').attr('src', resources + 'img/producto.png')
        }
    });

    var validate = $('#form_add').validate(
    {
        rules:
        {
            name_product:
            {
                required: true,
                maxlength: 100
            },
            code_product:
            {
                required: true,
                maxlength: 100
            },
            brand_product:
            {
                required: true,
                maxlength: 100
            },
            cost_product:
            {
                required: true,
                number: true,
                maxlength: 100
            },
            location_product:
            {
                required: true,
                maxlength: 100
            },
            detail_product:
            {
                required: true,
                maxlength: 300
            }
        },
        messages:
        {
            name_product:
            {
                required: 'Por favor ingresa el nombre del producto.',
                maxlength: 'Máximo se permiten 100 caracteres.'
            },
            code_product:
            {
                required: 'Por favor ingresa el codigo del producto',
                maxlength: 'Máximo se permiten 100 caracteres.'
            },
            brand_product:
            {
                required: 'Por favor ingresa la marca del producto.',
                maxlength: 'Máximo se permiten 100 caracteres.'
            },
            cost_product:
            {
                required: 'Por favor ingresa el costo del producto.',
                number: 'Por favor ingresa solo numeros.',
                maxlength: 'Máximo se permiten 100 caracteres.'
            },
            location_product:
            {
                required: 'Por favor ingresa la ubicacion del producto.',
                maxlength: 'Máximo se permiten 100 caracteres.'
            },
            detail_product:
            {
                required: 'Por favor ingresa el detalle del producto',
                maxlength: 'Máximo se permiten 300 caracteres.'
            }
        }
    });

    $('#form_add').ajaxForm({
        dataType:  'json',
        success:   add,
    });

    var validate = $('#form_edit').validate(
        {
            rules:
            {
                name_product:
                {
                    required: true,
                    maxlength: 100
                },
                code_product:
                {
                    required: true,
                    maxlength: 100
                },
                brand_product:
                {
                    required: true,
                    maxlength: 100
                },
                cost_product:
                {
                    required: true,
                    number: true,
                    maxlength: 100
                },
                location_product:
                {
                    required: true,
                    maxlength: 100
                },
                detail_product:
                {
                    required: true,
                    maxlength: 300
                }
            },
            messages:
            {
                name_product:
                {
                    required: 'Por favor ingresa el nombre del producto.',
                    maxlength: 'Máximo se permiten 100 caracteres.'
                },
                code_product:
                {
                    required: 'Por favor ingresa el codigo del producto',
                    maxlength: 'Máximo se permiten 100 caracteres.'
                },
                brand_product:
                {
                    required: 'Por favor ingresa la marca del producto.',
                    maxlength: 'Máximo se permiten 100 caracteres.'
                },
                cost_product:
                {
                    required: 'Por favor ingresa el costo del producto.',
                    number:   'Por favor ingresa solo numeros.',
                    maxlength: 'Máximo se permiten 100 caracteres.'
                },
                location_product:
                {
                    required: 'Por favor ingresa la ubicacion del producto.',
                    maxlength: 'Máximo se permiten 100 caracteres.'
                },
                detail_product:
                {
                    required: 'Por favor ingresa el detalle del producto',
                    maxlength: 'Máximo se permiten 300 caracteres.'
                }
            }
        });
    
        $('#form_edit').ajaxForm({
            dataType:  'json',
            success:   edit,
        });
    var validate_pass = $('#form_pass').validate();

    $('.cards_list').on('click', 'a.pass-row', function()
    {
        validate_pass.resetForm();
        $('#form_pass')[0].reset();
        $('#id_user_pass').val($(this).attr('data-id'));
        $('.form-control').removeClass('error');
        $('#modal_edit_pass').modal('show');
    });

    $('#form_pass').ajaxForm({
        dataType:  'json',
        success:   edit_pass
    });

    $('#btn_cancel_pass').on('click', function()
    {
        validate_pass.resetForm();
        $('#form_pass')[0].reset();
        $('#id_user_pass').val('');
        $('.form-control').removeClass('error');
        $('#modal_edit_pass').modal('hide');
    });

    data_project();

    $('.projects_list').on('click', '.check-change',function ()
    {
        var user = $('#user_project').val();
        var project = $(this).val();

        if ($(this).prop('checked'))
        {
            var state = 1;
        }
        else
        {
            var state = 0;
        }

        $.ajax({
            type: 'POST',
            url: $path_assign_project,
            data:
            {
                id_user: user,
                id_project: project,
                state: state,
                search: $('.search_project').val()
            },
            dataType: 'json',
            success: function (response)
            {
                if (response.state)
                {
                    $('#btn_all_projects').attr('data-flag', '1');
                    $('#btn_all_projects').attr('data-original-title', 'Desmarcar Todos');
                }
                else
                {
                    $('#btn_all_projects').attr('data-flag', '0');
                    $('#btn_all_projects').attr('data-original-title', 'Marcar Todos');
                }

                if (!response.value)
                {
                    data_project();
                }

                iziToast.show(
                {
                    backgroundColor: (response.value ? '#D5E6D3' : '#F6D6D6'),
                    color: (response.value ? '#40AC2F' : '#DE3030'),
                    icon: (response.value ? 'far fa-smile' : 'far fa-frown'),
                    iconColor: (response.value ? '#8CBB85' : '#FE7676'),
                    maxWidth: 420,
                    message: '<br/>' + response.message,
                    messageColor: (response.value ? '#8CBB85' : '#FE7676'),
                    position: 'topRight',
                    timeout: 5000,
                    title: (response.value ? '¡Bien hecho!' : '¡Atención!'),
                    titleColor: (response.value ? '#40AC2F' : '#DE3030')
                });
            },
            error: function ()
            {
                modal_alert(false, 'Error de conexión.');
            }
        });
    });


    let timeoutID_projects = null;

    $('.search_project').keyup(function(e) {
        clearTimeout(timeoutID_projects);
        timeoutID_projects = setTimeout(() => data_project(), 1000)
    });


    $('#btn_all_projects').on('click', function ()
    {
        var flag = $('#btn_all_projects').attr('data-flag');

        $.ajax({
            type: 'POST',
            url: $path_assign_projects,
            data:
            {
                search: $('.search_project').val(),
                state: flag,
                id_user: $('#user_project').val()
            },
            dataType: 'json',
            success: function (response)
            {
                if (response.value)
                {
                    if (flag == "0")
                    {
                        $('.check-change').prop('checked', true);
                        $('#btn_all_projects').attr('data-flag', '1');
                        $('#btn_all_projects').attr('data-original-title', 'Desmarcar Todos');
                    }
                    else
                    {
                        $('.check-change').prop('checked', false);
                        $('#btn_all_projects').attr('data-flag', '0');
                        $('#btn_all_projects').attr('data-original-title', 'Marcar Todos');
                    }
                }

                iziToast.show(
                {
                    backgroundColor: (response.value ? '#D5E6D3' : '#F6D6D6'),
                    color: (response.value ? '#40AC2F' : '#DE3030'),
                    icon: (response.value ? 'far fa-smile' : 'far fa-frown'),
                    iconColor: (response.value ? '#8CBB85' : '#FE7676'),
                    maxWidth: 420,
                    message: '<br/>' + response.message,
                    messageColor: (response.value ? '#8CBB85' : '#FE7676'),
                    position: 'topRight',
                    timeout: 5000,
                    title: (response.value ? '¡Bien hecho!' : '¡Atención!'),
                    titleColor: (response.value ? '#40AC2F' : '#DE3030')
                });
            },
            error: function () {
                modal_alert(false, 'Error de conexión.');
            }
        });
    });

    data_roles();

    $('.roles_list').on('click', '.check-change',function ()
    {
        var user = $('#user_role').val();
        var role = $(this).val();

        if ($(this).prop('checked'))
        {
            var state = 1;
        }
        else
        {
            var state = 0;
        }

        $.ajax({
            type: 'POST',
            url: $path_assign_role,
            data:
            {
                id_user: user,
                id_role: role,
                state: state,
                search: $('.search_role').val()
            },
            dataType: 'json',
            success: function (response)
            {
                if (response.state)
                {
                    $('#btn_all_roles').attr('data-flag', '1');
                    $('#btn_all_roles').attr('data-original-title', 'Desmarcar Todos');
                }
                else
                {
                    $('#btn_all_roles').attr('data-flag', '0');
                    $('#btn_all_roles').attr('data-original-title', 'Marcar Todos');
                }

                if (!response.value)
                {
                    data_roles();
                }

                iziToast.show(
                {
                    backgroundColor: (response.value ? '#D5E6D3' : '#F6D6D6'),
                    color: (response.value ? '#40AC2F' : '#DE3030'),
                    icon: (response.value ? 'far fa-smile' : 'far fa-frown'),
                    iconColor: (response.value ? '#8CBB85' : '#FE7676'),
                    maxWidth: 420,
                    message: '<br/>' + response.message,
                    messageColor: (response.value ? '#8CBB85' : '#FE7676'),
                    position: 'topRight',
                    timeout: 5000,
                    title: (response.value ? '¡Bien hecho!' : '¡Atención!'),
                    titleColor: (response.value ? '#40AC2F' : '#DE3030')
                });
            },
            error: function ()
            {
                modal_alert(false, 'Error de conexión.');
            }
        });
    });


    let timeoutID_roles = null;

    $('.search_role').keyup(function(e) {
        clearTimeout(timeoutID_roles);
        timeoutID_roles = setTimeout(() => data_roles(), 1000)
    });

    $('#btn_all_roles').on('click', function ()
    {
        var flag = $('#btn_all_roles').attr('data-flag');

        $.ajax({
            type: 'POST',
            url: $path_assign_roles,
            data:
            {
                search: $('.search_role').val(),
                state: flag,
                id_user: $('#user_role').val()
            },
            dataType: 'json',
            success: function (response)
            {
                if (response.value)
                {
                    if (flag == "0")
                    {
                        $('.check-change').prop('checked', true);
                        $('#btn_all_roles').attr('data-flag', '1');
                        $('#btn_all_roles').attr('data-original-title', 'Desmarcar Todos');
                    }
                    else
                    {
                        $('.check-change').prop('checked', false);
                        $('#btn_all_roles').attr('data-flag', '0');
                        $('#btn_all_roles').attr('data-original-title', 'Marcar Todos');
                    }
                }

                iziToast.show(
                {
                    backgroundColor: (response.value ? '#D5E6D3' : '#F6D6D6'),
                    color: (response.value ? '#40AC2F' : '#DE3030'),
                    icon: (response.value ? 'far fa-smile' : 'far fa-frown'),
                    iconColor: (response.value ? '#8CBB85' : '#FE7676'),
                    maxWidth: 420,
                    message: '<br/>' + response.message,
                    messageColor: (response.value ? '#8CBB85' : '#FE7676'),
                    position: 'topRight',
                    timeout: 5000,
                    title: (response.value ? '¡Bien hecho!' : '¡Atención!'),
                    titleColor: (response.value ? '#40AC2F' : '#DE3030')
                });
            },
            error: function () {
                modal_alert(false, 'Error de conexión.');
            }
        });
    });

    load_tree();

    load_report();

    $('.cards_list').on('click', 'a.remove-row', function()
    {
        $('#product_drop').val($(this).attr('data-id'));
        $('#modal_delete').modal('show');
    });

    $('#btn_confirm_delete').on('click', function ()
    {
        $.ajax({
            type: 'Get',
            url: $path_drop,
            data: {
                id_product: $('#product_drop').val()
            },
            dataType: 'json',
            success: function (response)
            {
                data_list();
                modal_alert(response.value, response.message);
                $('#modal_delete').modal('hide');
            },
            error: function () {
                modal_alert(false, 'Error de conexión.');
                $('#modal_delete').modal('hide');
            }
        });
    });

    $('#btn_cancel_delete').on('click', function ()
    {
        $('#product_drop').val('');
        $('#modal_delete').modal('hide');
    });

    $('.more-permissions-user').on('click', function()
    {
        $(this).parent('.card-box').toggleClass('d-permissions-user');

        if ($(this).children('i').hasClass('fa-angle-double-down'))
        {
            $(this).children('i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
        }
        else
        {
            $(this).children('i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
        }
    });

    $( "#type_report" ).change(function()
    {
        if ($(this).val() == 'general')
        {
            $('#id_report').attr('disabled', true);
            $('#id_report').val('');
        }
        else
        {
            $('#id_report').attr('disabled', false);
        }
    });

    $('#date_filter').datepicker({
        language: 'es-ES',
        format: 'dd-mm-yyyy',
        startView: 3,
        endDate: new Date(),
        autoHide: true
    });

    $('#id_report').select2({
        theme: 'bootstrap4',
        width: '100%',
        language: 'es',
        placeholder: 'Buscar...',
        allowClear: true,
        ajax: {
            url: $path_users_report,
            dataType: 'json',
            delay: 250,
            data: function(params)
            {
                return {
                    q: params.term,
                    page: params.page || 1
                };
            },
            processResults: function(data, params)
            {
                var page = params.page || 1;
                return {
                    results: $.map(data.items, function (item)
                    {
                        return {
                            id: item.id,
                            text: item.text
                        }
                    }),
                    pagination: {
                        more: (page * 10) <= data.total_count
                    }
                };
            }
        },
        escapeMarkup: function (markup) { return markup; },
    }).on('change', function (e) 
    {
        load_report();
    });

    $('#date_filter').change(function()
    {
        if ($('.datepicker-container').hasClass("datepicker-hide"))
        {
            load_report();
        }

        $('#date_report').val($(this).val());
    });

    $('#gral_month').on('click', function ()
    {
        $('#gral_month').addClass('btn-light-blue');
        $('#gral_week').removeClass('btn-light-blue');
        $('#chart5').parent('div').addClass('d-none');
        $('#chart6').parent('div').removeClass('d-none');
        $("#chart6").html('');
        chart6 = new ApexCharts(document.querySelector("#chart6"), options6);
        chart6.render();
    });

    $('#gral_week').on('click', function ()
    {
        $('#gral_week').addClass('btn-light-blue');
        $('#gral_month').removeClass('btn-light-blue');
        $('#chart6').parent('div').addClass('d-none');
        $('#chart5').parent('div').removeClass('d-none');
        $("#chart5").html('');
        chart5 = new ApexCharts(document.querySelector("#chart5"), options5);
        chart5.render();
    });

    $('#exp_report_pdf').on('click', function ()
    {
        window.setTimeout(function() {
            $('#html_most_used').val($('#most_submodule').html());
            $('#html_less_used').val($('#less_submodule').html());

            chart1.dataURI().then((uri) => {
                $('#img_chart1').val(uri.imgURI);
            });
            chart2.dataURI().then((uri) => {
                $('#img_chart2').val(uri.imgURI);
            });
            chart3.dataURI().then((uri) => {
                $('#img_chart3').val(uri.imgURI);
            });
            chart4.dataURI().then((uri) => {
                $('#img_chart4').val(uri.imgURI);
            });
            chart5.dataURI().then((uri) => {
                $('#img_chart5').val(uri.imgURI);
            });
            chart6.dataURI().then((uri) => {
                $('#img_chart6').val(uri.imgURI);
            });
        }, 1300);
        window.setTimeout(function() {
            $('#form_export_report').submit();
        }, 1500);
    });

    $('#form_validate_emails').ajaxForm({
        dataType:  'json',
        success:   function(response)
        {
            modal_alert(response.data, response.message);

            if (response.data)
            {
                data_list();
                $('#id_validate_email').val('');
                $('#modal_validate_emails').modal('hide');
            }
        }
    });

    $('#btn_cancel_request').on('click', function()
    {
        $('#id_validate_email').val('');
        $('#modal_validate_emails').modal('hide');
    });

    $('#btn_validate_emails').on('click', function()
    {
        $('#id_validate_email').val('');
        $('#modal_validate_emails').modal('show');
    });

    $('.cards_list').on('click', 'a.mail-row', function()
    {
        $('#id_validate_email').val($(this).attr('data-id'));
        $('#modal_validate_emails').modal('show');
    });
});

function add(response)
{console.log('hkhkjk');
    modal_alert_and_event(response.value, response.message, function(){
        if (response.value) {
            window.location.href = $path_products;
        }
    });
}

function import_xlsx(response)
{console.log('hkhkjk');
    modal_alert_and_event(response.value, response.message, function(){
        if (response.value) {
            window.location.href = $path_products;
            data_list();
        }
    });
}

$('#form_import').ajaxForm({
    dataType:  'json',
    success:   import_xlsx,
});

function edit(response)
{
    modal_alert_and_event(response.value, response.message, function(){
        if (response.value) {
            window.location.href = $path_products;
        }
    });
}

function edit_pass(response)
{
    modal_alert(response.value, response.message);

    if (response.value)
    {
        $('#modal_edit_pass').modal('hide');
    }
}

function edit_display(user, display)
{
    $.ajax({
        type: 'POST',
        url: $path_display,
        data:
        {
            id_user: user,
            display: display
        },
        dataType: 'json',
        success: function (response)
        {
            data_list();
            modal_alert(response.value, response.message);
        },
        error: function ()
        {
            modal_alert(false, 'Error de conexión.');
        }
    });
}

function data_list()
{
    if ($('.cards_list').length > 0)
    {
        var search = $('.search_list').val();

        var order = $('#order option:selected').val();

        $('.cards_pagination').pagination({
            dataSource: $path_view,
            locator: 'data',
            totalNumberLocator: function(response)
            {
                $('.label-total-pag').html(response.data.length + ' registros de un total de ' + response.recordsTotal);

                if (response.recordsFiltered == 0)
                {
                    $('#btn_export_xlsx').removeAttr('href');
                }
                else
                {
                    if (search != "")
                    {
                        $('#btn_export_xlsx').attr('href', $path_export_xlsx + '/?search=' + search);
                    }
                    else
                    {
                        $('#btn_export_xlsx').attr('href', $path_export_xlsx);
                    }
                }

                return response.recordsFiltered;
            },
            pageSize: 10,
            ajax:
            {
                type: 'GET',
                dataType: 'json',
                data:
                {
                    search : search,
                    order  : order
                },
                beforeSend: function()
                {
                    $('.cards_list').html('<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>');
                }
            },
            callback: function(response, pagination)
            {
                if (response.length > 0)
                {
                    $('.cards_list').html(response);
                }
                else
                {
                    $('.cards_list').html('No hay registros.');
                }
            }
        });
    }
}

function data_project()
{
    if ($('.projects_list').length > 0)
    {
        $('.projects_pagination').pagination({
            dataSource: $path_projects,
            locator: 'data',
            totalNumberLocator: function(response)
            {
                $('.label-total-pag').html(response.data.length + ' registros de un total de ' + response.recordsTotal);

                if (response.projects >= response.recordsFiltered)
                {
                    $('#btn_all_projects').attr('data-flag', '1');
                    $('#btn_all_projects').attr('data-original-title', 'Desmarcar Todos');
                }
                else
                {
                    $('#btn_all_projects').attr('data-flag', '0');
                    $('#btn_all_projects').attr('data-original-title', 'Marcar Todos');
                }

                return response.recordsFiltered;
            },
            pageSize: 10,
            ajax:
            {
                type: 'GET',
                dataType: 'json',
                data:
                {
                    search : $('.search_project').val(),
                    user: $('#user_project').val()
                },
                beforeSend: function() {
                    $('.projects_list').html('<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>');
                }
            },
            callback: function(response, pagination)
            {
                if (response.length > 0)
                {
                    $('.projects_list').html(response);
                }
                else
                {
                    $('.projects_list').html('No hay registros.');
                }
            }
        });
    }
}

function data_roles()
{
    if ($('.roles_list').length > 0)
    {
        $('.roles_pagination').pagination({
            dataSource: $path_roles_cards,
            locator: 'data',
            totalNumberLocator: function(response)
            {
                $('.label-total-pag').html(response.data.length + ' registros de un total de ' + response.recordsTotal);

                if (response.roles >= response.recordsFiltered)
                {
                    $('#btn_all_roles').attr('data-flag', '1');
                    $('#btn_all_roles').attr('data-original-title', 'Desmarcar Todos');
                }
                else
                {
                    $('#btn_all_roles').attr('data-flag', '0');
                    $('#btn_all_roles').attr('data-original-title', 'Marcar Todos');
                }

                return response.recordsFiltered;
            },
            pageSize: 10,
            ajax:
            {
                type: 'GET',
                dataType: 'json',
                data:
                {
                    search : $('.search_role').val(),
                    user: $('#user_role').val()
                },
                beforeSend: function() {
                    $('.roles_list').html('<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>');
                }
            },
            callback: function(response, pagination)
            {
                if (response.length > 0)
                {
                    $('.roles_list').html(response);
                }
                else
                {
                    $('.roles_list').html('No hay registros.');
                }
            }
        });
    }
}
function load_tree()
{
    if ($('.treeview-animated').length > 0)
    {
        $('.treeview-animated').mdbTreeview();
    }
}

function load_report()
{
    if ($('.view-report').length > 0)
    {
        $.ajax({
            type: 'POST',
            url: $path_report,
            data:
            {
                date_filter: $('#date_filter').val(),
                id: $('#id_report').val()
            },
            dataType: 'json',
            success: function (response)
            {
                if (chart2)
                {
                    chart2.destroy();
                }

                $('#exp_report_pdf').attr('disabled',  false);

                if ($('#id_report').val() != null)
                {
                    $('#div_label_usr_by').removeClass('d-none');
                    $('#label_usr_other').removeClass('d-none');
                    $('#label_usr_by').html(' Creados por ' + $('#id_report option:selected').text());
                    $('#user_export').val($('#id_report option:selected').text());
                }
                else
                {
                    $('#div_label_usr_by').addClass('d-none');
                    $('#label_usr_other').addClass('d-none');
                    $('#label_usr_by').html('');
                    $('#user_export').val('');
                }

                if (response.value.day)
                {
                    var total_day = response.value.day['total'];
                    $('.date_chart1').html(response.value.day['date_insert']);
                    $('.num_chart1').html(total_day);
                    $('#daily_login').val(total_day);
                }
                else
                {
                    var today = new Date();
                    var date = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
                    $('.date_chart1').html(date);
                    $('.num_chart1').html('0');
                    $('#daily_login').val(0);
                    var total_day = 0;
                }

                if (response.value.user_data)
                {
                    $('#data_user_report').html(response.value.user_data);
                    $('#div_chart1').addClass('min-chart-one').removeClass('mg-b-10-force');
                    $('#div_chart2').addClass('min-chart-one');
                }
                else
                {
                    $('#data_user_report').html('');
                    $('#div_chart1').removeClass('min-chart-one').addClass('mg-b-10-force');
                    $('#div_chart2').removeClass('min-chart-one');
                }

                options1 =
                {
                    chart:
                    {
                        height: 60,
                        type: 'bar',
                        toolbar: 
                        {
                            show: false
                        }
                    },
                    grid:
                    {
                        show: false,
                        padding:
                        {
                            left: 0,
                            right: 0,
                            top: -20,
                            bottom: -15
                        }
                    },
                    plotOptions:
                    {
                        bar:
                        {
                            horizontal: false,
                            columnWidth: '60%',
                            endingShape: 'rounded',
                            distributed: true
                        },
                    },
                    legend:
                    {
                        show: false
                    },
                    dataLabels:
                    {
                        enabled: false
                    },
                    colors: ['#FBE5CC', '#F7941D', '#FBE5CC'],
                    series: [{
                        name: 'Ingresos',
                        data: [0, response.value.day['total'], 0]
                    }],
                    xaxis:
                    {
                        show: false,
                        floating: true
                    },
                    yaxis:
                    {
                        show: false,
                        floating: true,
                    },
                    tooltip:
                    {
                        x: {
                            show: false,
                        },
                    }
                }

                $("#chart1").html('');
                chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
                chart1.render();

                options2 =
                {
                    series: [((response.value.total_users) ? response.value.total_users : 0), ((response.value.total_users_own) ? response.value.total_users_own : 0)],
                    chart: {
                        width: 185,
                        type: 'donut'
                    },
                    labels : ['Usuarios', ((response.value.total_users_own) ? $('#id_report option:selected').text() : '')],
                    plotOptions:
                    {
                        pie:
                        {
                            donut:
                            {
                                size: '77%',
                                labels: {
                                    show: true,
                                    total:
                                    {
                                        showAlways: true,
                                        show: true,
                                        label: 'Usuarios'
                                    }
                                }
                            }
                        },
                        distributed: true
                    },
                    colors: ['#005BAA', '#F7941D'],
                    dataLabels:
                    {
                        dropShadow:
                        {
                            blur: 3,
                            opacity: 0.8
                        },
                        enabled: false
                    },
                    legend:
                    {
                        show: false
                    },
                    responsive: [{
                        breakpoint: 480,
                        options:
                        {
                            chart:
                            {
                                width: 200
                            },
                            legend:
                            {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                $("#chart2").html('');
                chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
                chart2.render();


                $('#max_day').html(response.value.week['max_day']);
                $('#max_day_val').html(response.value.week['max_val']);
                $('#min_day').html(response.value.week['min_day']);
                $('#min_day_val').html(response.value.week['min_val']);
                $('#max_day_exp').val(response.value.week['max_day']);
                $('#max_day_val_exp').val(response.value.week['max_val']);
                $('#min_day_exp').val(response.value.week['min_day']);
                $('#min_day_val_exp').val(response.value.week['min_val']);

                options3 =
                {
                    chart:
                    {
                        height: 100,
                        type: 'bar',
                        stacked: true,
                        stackType: '100%',
                        toolbar:
                        {
                            show: false
                        }
                    },
                    grid:
                    {
                        show: false,
                        padding:
                        {
                            left: 0,
                            right: 0,
                            top: -20,
                            bottom: -15
                        }
                    },
                    plotOptions:
                    {
                        bar:
                        {
                            horizontal: false,
                            columnWidth: '20%',
                            borderRadius: 4,
                            endingShape: 'rounded'
                        },
                    },
                    legend:
                    {
                        show: false
                    },
                    dataLabels:
                    {
                        enabled: false
                    },
                    colors: ['#47A9FF', '#C2E3FF'],
                    series:
                    [{
                        name: 'Ingresos',
                        data: response.value.week['values']
                    },
                    {
                        name: '',
                        data: response.value.week['values_max']
                    }],
                    xaxis:
                    {
                        categories: response.value.week['labels'],
                        axisBorder:
                        {
                            show: false
                        },
                        axisTicks:
                        {
                            show: false
                        },
                        labels:
                        {
                            offsetY: -5
                        }
                    },
                    yaxis:
                    {
                        show: false,
                        floating: true,
                    },
                    tooltip:
                    {
                        x:
                        {
                            show: false,
                        },
                    }
                }

                $("#chart3").html('');
                chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
                chart3.render();


                $('#total_year').html(response.value.year['total_year']['total']);
                $('#total_login').val(response.value.year['total_year']['total']);
                $('#total_reb').html(response.value.year['total_year']['total_reb']);
                $('#reb_login').val(response.value.year['total_year']['total_reb']);

                options4 =
                {
                    series:
                    [{
                        name: 'Ingresos',
                        data: response.value.year['values']
                    },
                    {
                        name: 'Rebote',
                        data: response.value.year['values_reb']
                    }],
                    chart:
                    {
                        type: 'bar',
                        height: 220
                    },
                    plotOptions:
                    {
                        bar:
                        {
                            horizontal: false,
                            columnWidth: '40%',
                            endingShape: 'rounded',
                            borderRadius: 4
                        },
                    },
                    colors: ['#47A9FF', '#C2E3FF'],
                    dataLabels:
                    {
                        enabled: false
                    },
                    legend:
                    {
                        show: false
                    },
                    stroke:
                    {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis:
                    {
                        categories: response.value.year['labels'],
                    },
                    fill:
                    {
                        opacity: 1
                    },
                    tooltip:
                    {
                        y:
                        {
                            formatter: function (val)
                            {
                                return val
                            }
                        }
                    }
                };

                $("#chart4").html('');
                chart4 = new ApexCharts(document.querySelector("#chart4"), options4);
                chart4.render();


                $('#gral_week').addClass('btn-light-blue');
                $('#gral_month').removeClass('btn-light-blue');
                $('#chart6').parent('div').addClass('d-none');
                $('#chart5').parent('div').removeClass('d-none');
        
                options5 =
                {
                    chart:
                    {
                        height: 315,
                        type: 'area',
                        stacked: false,
                        toolbar:
                        {
                            show: false,
                        },
                        sparkline:
                        {
                            enabled: true
                        },
                    },
                    colors: ['#47A9FF', '#C2E3FF'],
                    dataLabels:
                    {
                        enabled: false
                    },
                    stroke:
                    {
                        curve: 'smooth',
                        width: 2.5,
                        dashArray: [0, 8]
                    },
                    fill:
                    {
                        type: 'gradient',
                        gradient:
                        {
                            inverseColors: false,
                            shade: 'light',
                            type: "vertical",
                            gradientToColors: ['#47A9FF', '#C2E3FF'],
                            opacityFrom: 0.7,
                            opacityTo: 0.55,
                            stops: [0, 5, 100]
                        }
                    },
                    series:
                    [
                        {
                            name: 'Usabilidad',
                            data: response.value.week_activity['values'],
                            type: 'line',
                        }
                    ],
                    xaxis:
                    {
                        offsetY: -50,
                        categories: response.value.week_activity['labels'],
                        axisBorder: {
                        show: false,
                        },
                        axisTicks: {
                        show: false,
                        },
                        labels:
                        {
                            show: true,
                            style:
                            {
                                colors: '#47A9FF'
                            }
                        }
                    },
                    tooltip:
                    {
                        x:
                        {
                            show: false 
                        }
                    },
                }

                $("#chart5").html('');
                chart5 = new ApexCharts(document.querySelector("#chart5"), options5);
                chart5.render();

                options6 =
                {
                    chart:
                    {
                        width: '100%',
                        height: 315,
                        type: 'area',
                        stacked: false,
                        toolbar:
                        {
                            show: false,
                        },
                        sparkline:
                        {
                            enabled: true
                        },
                    },
                    colors: ['#47A9FF', '#C2E3FF'],
                    dataLabels:
                    {
                        enabled: false
                    },
                    stroke:
                    {
                        curve: 'smooth',
                        width: 2.5,
                        dashArray: [0, 8]
                    },
                    fill:
                    {
                        type: 'gradient',
                        gradient:
                        {
                            inverseColors: false,
                            shade: 'light',
                            type: "vertical",
                            gradientToColors: ['#47A9FF', '#C2E3FF'],
                            opacityFrom: 0.7,
                            opacityTo: 0.55,
                            stops: [0, 5, 100]
                        }
                    },
                    series:
                    [
                        {
                            name: 'Usabilidad',
                            data: response.value.month_activity['values'],
                            type: 'line',
                        }
                    ],
                    xaxis:
                    {
                        offsetY: -50,
                        categories: response.value.month_activity['labels'],
                        axisBorder: {
                        show: false,
                        },
                        axisTicks: {
                        show: false,
                        },
                        labels:
                        {
                            show: true,
                            style:
                            {
                                colors: '#47A9FF'
                            }
                        }
                    },
                    tooltip:
                    {
                        x:
                        {
                            show: false 
                        }
                    },
                }

                $("#chart6").html('');
                chart6 = new ApexCharts(document.querySelector("#chart6"), options6);
                chart6.render();

                $('#most_submodule').html(response.value.total_activity['content_m']);
                $('#less_submodule').html(response.value.total_activity['content_l']);
                $('#daily_activity').html(response.value.daily_activity);
                $('#html_daily').val(response.value.daily_activity_exp);
            },
            error: function ()
            {
                modal_alert(false, 'Error de conexión.');
            }
        });
    }
}

$('#order').on('change', function() {
    data_list();

})

$('body').on('click', '.img_product', function ()
{
    console.log($(this));
    $('#title_mo').text($(this).attr('alt'));
    $('#img').attr('src', $(this).attr('src'));
    $('#modal_img').modal('show');
})

$('body').on('click', '#btn_serach', function ()
{
    // console.log('dffdfdf')
    $.ajax({
        type: 'POST',
        url: $path_search,
        data: {name: $('#name_product').val()},
        dataType: 'json',
        success: function (response)
        {
            console.log(response)

            $('#code_product').val(response.data['code_product']);
            $('#brand_product').val(response.data['brand_product']);
            $('#detail_product').val(response.data['detail_product']);
            $(".product-photo").attr('src', response.img);
        },
        error: function() 
        {
            alert('no se encontraron datos')
        }
    });
});