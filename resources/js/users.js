const LIST_SEARCH_STATUS_USERS                                                  =   [
                                                                                        {
                                                                                            id: 0,
                                                                                            label: 'Usuarios Activos'
                                                                                        },
                                                                                        {
                                                                                            id: 1,
                                                                                            label: 'Usuarios Inactivos'
                                                                                        }
                                                                                    ]

let cropper_add_form
let cropper_edit_form
let filter_users_display                                                        =   ''
let filter_users_enterprises                                                    =   ''
let filter_search_users                                                         =   ''
let image_avatar_selected                                                       =   ''
let role_selected_form_create                                                   =   0
let role_selected_form_update                                                   =   0

$('#check_selected_all_roles_form_create').change(function() {
    const status_check_all_roles                                                =   $(this).is(':checked')
    if(status_check_all_roles) {
        $('.checkbox-roles-form-create-user-id').prop('checked',true)
        $('#role_selected_form_create').val('1')
        $('#role_selected_form_create-error').html('')
    } else {
        $('.checkbox-roles-form-create-user-id').prop('checked',false)
        $('#role_selected_form_create').val('')
    }
})

$('#check_selected_all_roles_form_edit').change(function() {
    const status_check_all_roles                                                =   $(this).is(':checked')
    if(status_check_all_roles) {
        $('.checkbox-roles-form-update-user-id').prop('checked',true)
        $('#role_selected_form_edit').val('1')
        $('#role_selected_form_edit-error').html('')
    } else {
        $('.checkbox-roles-form-update-user-id').prop('checked',false)
        $('#role_selected_form_edit').val('')
    }
})

$('#search_roles_form_create').keyup(function() {
    const keyword                                                               =   $(this).val()
    display_roles_list(keyword)
})

$('#search_roles_form_update').keyup(function() {
    const keyword                                                               =   $(this).val()
    display_roles_list(keyword)
})

$('#select_filter_list_users').click(function () {
    $('#dropdown_select_filters_list').toggle()
})

$('#registers_users_per_page').on('change', function () {
    display_list_users()
})

$('#input_search_users').keyup(function () {
    if (filter_search_users.length >= 2 || filter_search_users.length === 0) {
        display_list_users()
    }
})

$('#check_activated_all_users').change(function () {
    const status_display_all_users                                              =   $(this).is(':checked')
    update_status_user(0,status_display_all_users)
})

$('#check_filter_all_status_users').click(function() {
    if($(this).is(':checked')) {
        filter_users_display                                                    =   ''
        display_list_users()
        $('.check-users-status-id').prop('checked',false).change()
    }
})

$('#check_filter_all_enterprises_users').click(function() {
    if($(this).is(':checked')) {
        filter_users_enterprises                                                =   ''
        display_list_users()
        $('.check-users-enterprise-id').prop('checked',false).change()
    }
})

$('#badge_upload_img_avatar_create').click(function() {
    $('#modal_upload_img_avatar_create').modal('show')
})

$('#badge_upload_img_avatar_edit').click(function() {
    $('#modal_upload_img_avatar_edit').modal('show')
})

$('#img_upload_create_form').change(function(e) {
    let file                                                                    =   e.target.files[0]
    let reader                                                                  =   new FileReader()
    reader.onload                                                               =   function(e) {
                                                                                        const file_type = file.type
                                                                                        if(file_type === 'image/jpeg' || file_type === 'image/png') {
                                                                                            $('#img_avatar_prev_form_create').attr('src',e.target.result)
                                                                                            $('#btn_change_avatar_form_create').removeClass('display-none')
                                                                                            $('#text_error_message_image_form_create').empty()
                                                                                            if($('#img_avatar_prev_form_create').hasClass('cropper-hidden')) {
                                                                                                cropper_add_form.destroy()
                                                                                            }
                                                                                            cropper_add_form = new Cropper(document.getElementById('img_avatar_prev_form_create'), {
                                                                                                aspectRatio: NaN,
                                                                                            });
                                                                                        } else {
                                                                                            $('#img_avatar_prev_form_create').attr('src',`${$path_resources}img/upload.png`)
                                                                                            $('#btn_change_avatar_form_create').addClass('display-none')
                                                                                            $('#text_error_message_image_form_create').text('Sólo se aceptan archivos en formato .jpg o .png')
                                                                                        }
                                                                                    }
    reader.readAsDataURL(file)
})

$('#img_upload_edit_form').change(function(e) {
    let file                                                                    =   e.target.files[0]
    let reader                                                                  =   new FileReader()
    reader.onload                                                               =   function(e) {
                                                                                        const file_type = file.type
                                                                                        if(file_type === 'image/jpeg' || file_type === 'image/png') {
                                                                                            $('#img_avatar_prev_form_edit').attr('src',e.target.result)
                                                                                            $('#btn_change_avatar_form_edit').removeClass('display-none')
                                                                                            $('#text_error_message_image_form_edit').empty()
                                                                                            if($('#img_avatar_prev_form_edit').hasClass('cropper-hidden')) {
                                                                                                cropper_edit_form.destroy()
                                                                                            }
                                                                                            cropper_edit_form = new Cropper(document.getElementById('img_avatar_prev_form_edit'), {
                                                                                                aspectRatio: NaN,
                                                                                            });
                                                                                        } else {
                                                                                            $('#img_avatar_prev_form_edit').attr('src',`${$path_resources}img/upload.png`)
                                                                                            $('#btn_change_avatar_form_edit').addClass('display-none')
                                                                                            $('#text_error_message_image_form_edit').text('Sólo se aceptan archivos en formato .jpg o .png')
                                                                                        }
                                                                                    }
    reader.readAsDataURL(file)
})

$('#btn_change_avatar_form_create').click(function() {
    $('#icon_avatar_prev_form_create').addClass('display-none')
    $('#avatar_selected_prev_form_create').removeClass('display-none')
    $('#modal_upload_img_avatar_create').modal('hide')
    const canvas = cropper_add_form.getCroppedCanvas()
    const img_base64 = canvas.toDataURL()
    image_avatar_selected = img_base64
    $('#avatar_selected_prev_form_create').attr('src',img_base64)
    $('#image_user_status_form_create').val(1)
    $('.container-section-validate-avatar span').html('')
})

$('#btn_change_avatar_form_edit').click(function() {
    $('#icon_avatar_prev_form_edit').addClass('display-none')
    $('#avatar_selected_prev_form_edit').removeClass('display-none')
    $('#modal_upload_img_avatar_edit').modal('hide')
    const canvas = cropper_edit_form.getCroppedCanvas()
    const img_base64 = canvas.toDataURL()
    image_avatar_selected = img_base64
    $('#avatar_selected_prev_form_edit').attr('src',img_base64)
    $('#image_user_status_form_edit').val(1)
    $('.container-section-validate-avatar span').html('')
})

$('#add_user').click(function() {
    const input_image = document.getElementById('img_upload_create_form')
    const file_name = input_image.value
    const file_extension = file_name.split('.').pop()
    
    const data                                                                  =   new FormData(document.getElementById('form_create_user'))

    const byteCharacters = atob(image_avatar_selected.split(',')[1])
    const byteNumbers = new Array(byteCharacters.length)
    for (var i = 0; i < byteCharacters.length; i++) {
        byteNumbers[i]                                                          =   byteCharacters.charCodeAt(i)
    }
    const byteArray                                                             =   new Uint8Array(byteNumbers)
    const blob                                                                  =   new Blob([byteArray], { type: `image/${file_extension}` })

    const file_image                                                            =   new File([blob], `image.${file_extension}`,{ type: `image/${file_extension}`})
    data.append('avatar_file_resize', file_image)
    const roles_secundary                                                       =   []
    for (const [name, value] of data.entries()) {
        if (name == "roles_secundary") {
            roles_secundary.push(value)
        }
    }
    data.set('roles_secundary',roles_secundary)
    add_user(data)
})

$('#edit_user').click(function() {
    const input_image = document.getElementById('img_upload_edit_form')
    const file_name = input_image.value
    const file_extension = file_name.split('.').pop()

    const data                                                                  =   new FormData(document.getElementById('form_edit_user'))
    
    if(image_avatar_selected)
    {
        const byteCharacters = atob(image_avatar_selected.split(',')[1])
        const byteNumbers = new Array(byteCharacters.length)
        for (var i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i]                                                          =   byteCharacters.charCodeAt(i)
        }
        const byteArray                                                             =   new Uint8Array(byteNumbers)
        const blob                                                                  =   new Blob([byteArray], { type: `image/${file_extension}` });
    
        const file_image                                                            =   new File([blob], `image.${file_extension}`,{ type: `image/${file_extension}`})
        data.append('avatar_file_resize', file_image)
    }

    data.append('avatar_img',image_avatar_selected)
    data.append('id',$('#input_id_user').val())
    const roles_secundary = []
    for (const [name, value] of data.entries()) {
        if (name == "roles_secundary") {
            roles_secundary.push(value);
        }
    }
    data.set('roles_secundary',roles_secundary)
    edit_user(data)
})

$('#udrop_modal_user').click(function() {
    const id_user                                                               =   Number($('#id_user_udrop').val())
    udrop_user(id_user)
    $('#modal_delete').modal('hide')
})

$('#select_type_document_user_form_create').change(function() {
    $('#select_type_document_user_form_create-error').html('')
})

$('#select_type_document_user_form_edit').change(function() {
    $('#select_type_document_user_form_edit-error').html('')
})

$('#select_enterprise_user_form_create').change(function() {
    $('#select_enterprise_user_form_create-error').html('')
})

$('#select_enterprise_user_form_edit').change(function() {
    $('#select_enterprise_user_form_edit-error').html('')
})

$('#select_area_form_create').change(function() {
    $('#select_area_form_create-error').html('')
})

$('#select_area_form_edit').change(function() {
    $('#select_area_form_edit-error').html('')
})

$('#select_user_insert_form_create').change(function() {
    $('#select_user_insert_form_create-error').html('')
})

$('#select_user_update_form_edit').change(function() {
    $('#select_user_update_form_edit-error').html('')
})

$('#select_occupation_user_form_create').change(function() {
    $('#select_occupation_user_form_create-error').html('')
})

$('#select_occupation_user_form_edit').change(function() {
    $('#select_occupation_user_form_edit-error').html('')
})

$('#select_role_form_create').change(function() {
    $('#select_role_form_create-error').html('')
})

$('#select_role_form_edit').change(function() {
    $('#select_role_form_edit-error').html('')
})

$('#form_create_user').submit(function(e) {
    e.preventDefault()
})

$('#form_edit_user').submit(function(e) {
    e.preventDefault()
})

$('#form_create_user').validate({
    ignore: [],
    submitHandler: function() {
        $('#modal_create').modal('show')
    },
    invalidHandler: function(e,validator) {
        const errors                                                            =   validator.errorList
        errors.forEach(error => {
            const element_name                                                  =   error.element.name
            if(element_name === 'document_type' || element_name === 'enterprise' || element_name === 'area' || element_name === 'occupation' || element_name === 'user_insert' || element_name === 'role') {
                $(`#container_input_form_${element_name}`).addClass('error-select')
            }
        })
    },
    rules: {
        name: {
            required: true
        },
        lastname: {
            required: true
        },
        document_type: {
            required: true
        },
        document_number: {
            required: true,
        },
        country_indicator: {
            required: true
        },
        cell_phone_number: {
            required: true,
            minlength: 10,
            maxlength: 10
        },
        email: {
            required: true
        },
        occupation: {
            required: true
        },
        enterprise: {
            required: true
        },
        area: {
            required: true
        },
        user_insert: {
            required: true
        },
        date_insert: {
            required: true
        },
        image_user: {
            required: true
        },
        role_create: {
            required: true
        },
        role: {
            required: true
        }
    },
    messages: {
        image_user: "Añade una foto de perfil",
        role_create: "Selecciona al menos un rol secundario para el usuario"
    },
    errorElement: 'span',
    errorPlacement: function(error,element) {
        error.insertAfter(element)
    }
})

$('#form_edit_user').validate({
    ignore: [],
    submitHandler: function() {
        $('#modal_edit').modal('show')
    },
    invalidHandler: function(e,validator) {
        const errors                                                            =   validator.errorList
        errors.forEach(error => {
            const element_name                                                  =   error.element.name
            if(element_name === 'document_type' || element_name === 'enterprise' || element_name === 'area' || element_name === 'occupation' || element_name === 'user_update' || element_name === 'role') {
                $(`#container_input_form_${element_name}_edit`).addClass('error-select')
            }
        })
    },
    rules: {
        name: {
            required: true
        },
        lastname: {
            required: true
        },
        document_type: {
            required: true
        },
        document_number: {
            required: true
        },
        country_indicator: {
            required: true
        },
        cell_phone_number: {
            required: true,
            minlength: 10,
            maxlength: 10
        },
        email: {
            required: true
        },
        occupation: {
            required: true
        },
        enterprise: {
            required: true
        },
        area: {
            required: true
        },
        user_update: {
            required: true
        },
        date_update: {
            required: true
        },
        role_edit: {
            required: true
        },
        role: {
            required: true
        }
    },
    messages: {
        role_edit: "Selecciona al menos un rol secundario para el usuario"
    },
    errorElement: 'span',
    errorPlacement: function(error,element) {
        error.insertAfter(element)
    }
})

$(document).on('click', '.display-dropdown-id', function () {
    const id_user                                                               =   $(this).attr('data-index')
    $(`#dropdown_${id_user}`).toggle()
})

$(document).on('click', '.udrop-user-id', function() {
    const id_user                                                               =   $(this).attr('data-index')
    $('#id_user_udrop').val(id_user)
    $('#modal_delete').modal('show')
})

$(document).on('change', '.switch-status-user-id', function () {
    const id_user                                                               =   $(this).attr('data-index')
    const display_user                                                          =   $(this).is(':checked')
    update_status_user(id_user,display_user)
})

$(document).on('change', '.check-users-status-id', function() {
    const user_status_id                                                        =   $(this).val()
    if ($(this).is(':checked')) {
        $('#check_filter_all_status_users').prop('checked',false).change()
        if(filter_users_display.length > 0) filter_users_display                +=  `,${user_status_id}`
        else filter_users_display                                               =   user_status_id
    } else {
        if($('.check-users-status-id').filter(":checked").length === 0) {
            $('#check_filter_all_status_users').prop('checked',true).change()
        }
        if(filter_users_display.length > 1) {
            if(filter_users_display[0] == user_status_id) {
                filter_users_display                                            =   filter_users_display.split(`${user_status_id},`).join('')
            }
            else {
                filter_users_display                                            =   filter_users_display.split(`,${user_status_id}`).join('')
            } 
        } 
        else {
            filter_users_display                                                =   ''
        } 
    }
    display_list_users()
})

$(document).on('change', '.check-users-enterprise-id', function() {
    const user_enterprise_id                                                    =   $(this).val()
    if ($(this).is(':checked')) {
        $('#check_filter_all_enterprises_users').prop('checked',false).change()
        if(filter_users_enterprises.length > 0) filter_users_enterprises        +=  `,${user_enterprise_id}`
        else filter_users_enterprises = user_enterprise_id
    } else {
        if($('.check-users-enterprise-id').filter(":checked").length === 0) $('#check_filter_all_enterprises_users').prop('checked',true).change()
        if(filter_users_enterprises.includes(',')) {
            if(filter_users_enterprises[0] == user_enterprise_id) {
                filter_users_enterprises                                        =   filter_users_enterprises.split(`${user_enterprise_id},`).join('')
            }
            else {
                filter_users_enterprises                                        =   filter_users_enterprises.split(`,${user_enterprise_id}`).join('')
            } 
        } 
        else {
            filter_users_enterprises                                            =   ''
        } 
    }
    display_list_users()
})

$(document).on('change', '.checkbox-roles-form-create-user-id', function() {
    $('#check_selected_all_roles_form_create').prop('checked',false)
    if($('.checkbox-roles-form-create-user-id').filter(":checked").length === 0) {
        $('#role_selected_form_create').val('')
    } else {
        $('#role_selected_form_create').val('1')
        $('#role_selected_form_create-error').html('')
    }
})

$(document).on('change', '.checkbox-roles-form-update-user-id', function() {
    $('#check_selected_all_roles_form_edit').prop('checked',false)
    if($('.checkbox-roles-form-update-user-id').filter(":checked").length === 0) {
        $('#role_selected_form_edit').val('')
    } else {
        $('#role_selected_form_edit').val('1')
        $('#role_selected_form_edit-error').html('')
    }
})

$(document).on('change', '.radio-buttons-form-update-user-id', function() {
    role_selected_form_update                                                   =   $(this).val()
})

$(document).on('change', '.container-select-validate-forms', function() {
    $(this).removeClass('error-select')
})

$(document).on('click', '.display-modal-detail-roles-id', function() {
    $('#modal_detail_rol').modal('show')
})

function display_list_search_status_users() {
    LIST_SEARCH_STATUS_USERS.forEach(status => {
        const template_status_user                                              =   `<div>
                                                                                        <input value="${status.id}" class="checkbox-filter-users check-users-status-id" type="checkbox" />
                                                                                        <label class="text ps-1" for="html">${status.label}</label>
                                                                                    </div>`
        $('#checks_search_status_users').append(template_status_user)
    })
}

function display_list_users() {
    if ($("#list_of_users").length > 0) {
        let size = $('#registers_users_per_page').val()
        let search = $("#input_search_users").val()
        $("#container_pagination").pagination({
            dataSource: $path_users_list,
            locator: "data",
            formatNavigator:
            '<p class="separate"><span>Página </span><input type= "text" class= "J-paginationjs-go-pagenumber cont" value="<%= currentPage %>" id="cont"> <span>de </span> <span><%= totalPage %> </span></p>',
            showPageNumbers: false,
            showNavigator: true,
            prevText: '<i style="color: white;" class="fas fa-angle-left"></i>',
            nextText: '<i style="color: white;" class="fas fa-angle-right"></i>',
            totalNumberLocator: function (response) {
                $("#num").html(Math.ceil(response.recordsTotal / size));
                return response.recordsFiltered;
            },
            pageSize: size,
            ajax: {
            type: "POST",
            dataType: "json",
            data: {
                search: `${filter_users_display}/${filter_users_enterprises}/${search}`,
            },
            beforeSend: function () {
                $("#list_of_users").html(
                '<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>'
                );
            }
            },
            callback: function (response, pagination) {
            if (response.length > 0) {
                $("#list_of_users").html(response);
            } else {
                $("#list_of_users").html("No hay registros.");
            }
            },
        });
    }
}

function display_roles_list(keyword='') {
    if(keyword.length >= 3) {
        $('.item-rol label').each(function() {
            const name_role = $(this).text()
            if(!name_role.toLocaleLowerCase().includes(keyword.toLocaleLowerCase())) {
                $(this).parent().parent().css('display','none')
            } else {
                $(this).parent().parent().css('display','flex')
            }
        })
    } else if(keyword.length === 0) {
        $('.item-rol label').each(function() {
            $(this).parent().parent().css('display','flex')
        })
    }
}

function update_status_user(id,display) {
    $.ajax({
        type: 'POST',
        url: $path_users_display,
        data: {
            id,
            display: display ? 0 : 1
        },
        success: function (response) {
            const status_response                                               =   JSON.parse(response)
            const user_status                                                   =   status_response.status
            if(user_status) {
                modal_alert(true,status_response.message)
                if(id > 0) {
                    if (display) {
                        $(`#label_status_user_${id}`).text('Trabajador Activo')
                        $(`#label_status_user_${id}`).addClass('label-switch-on')
                        $(`#label_status_user_${id}`).removeClass('label-switch-off')
                    } else {
                        $(`#label_status_user_${id}`).text('Trabajador Inactivo')
                        $(`#label_status_user_${id}`).addClass('label-switch-off')
                        $(`#label_status_user_${id}`).removeClass('label-switch-on')
                    }
                } else {
                    if (display) {
                        $('#label_check_activated_all_users').text('Desactivar Todos')
                    } else {
                        $('#label_check_activated_all_users').text('Activar Todos')
                    }
                    display_list_users()
                }
            } else {
                modal_alert(false,status_response.message)
            }
        },
        error: function (error) {
            $('#modal_info').modal('show')
        }
    })
}

function add_user(user) {
    $.ajax({
        type: 'POST',
        url: $path_users_add,
        data: user,
        processData: false,
        contentType: false,
        success: function (response) {
            const data_response = JSON.parse(response)
            if(data_response.data) {
                $('#modal_create').modal('hide')
                modal_alert(true,data_response.message)
                setTimeout(function() {
                    window.location.href = $path_view_users_list
                },1500)
            } else {
                modal_alert(false,data_response.message)
            }
        },
        error: function (error) {
            $('#modal_info').modal('show')
        }
    })
}

function edit_user(user) {
    $.ajax({
        type: 'POST',
        url: $path_users_edit,
        data: user,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response)
            const data_response = JSON.parse(response)
            if(data_response.data) {
                $('#modal_edit').modal('hide')
                modal_alert(true,data_response.message)

                setTimeout(function() {
                    window.location.href = $path_view_users_list
                },1500)
            } else {
                modal_alert(false,data_response.message)
            }
        },
        error: function (error) {
            $('#modal_info').modal('show')
        }
    })
}

function udrop_user(id_user) {
    $.ajax({
        type: 'POST',
        url: $path_users_udrop,
        data: {
            id_user
        },
        success: function (response) {
            const data_response = JSON.parse(response)
            if(data_response.status) {
                $('#modal_delete').modal('hide')
                modal_alert(true,data_response.message)
                display_list_users()
            } else {
                modal_alert(false,data_response.message)
            }
        },
        error: function (error) {
            $('#modal_info').modal('show')
        }
    })
}

$(document).ready(function () {

    $('.js-example-basic-single').select2()

    if(window.location.href === $path_view_add_users) {
        $('#view_add_users').fadeIn(500)
        $("#select_country_indicator_user_form_create").select2({
            dropdownAutoWidth : true,
            templateResult: function (item) {
                if (!item.id) { return item.text; }
                var $state = $(
                    `<span><img sytle="display: inline-block;" width="30" height="20" src="${$path_resources}img/flags/${item.title}.svg" />&nbsp;${item.text}</span>`
                );
                return $state;
            },
            templateSelection: function (item) {
                if (!item.id) { return item.text; }
                var $state = $(
                    `<span><img sytle="display: inline-block;" width="30" height="20" src="${$path_resources}img/flags/${item.title}.svg" />&nbsp;${item.text}</span>`
                );
                return $state;
            }
        
        })

        $("#select_type_document_user_form_create").select2({
            placeholder: "Tipo de documento"
        })
    
        $("#select_enterprise_user_form_create").select2({
            placeholder: "Empresa"
        })
    
        $("#select_area_user_form_create").select2({
            placeholder: "Área"
        })
    
        $("#select_occupation_user_form_create").select2({
            placeholder: "Cargo"
        })
    
        $("#select_user_insert_form_create").select2({
            placeholder: "Usuario"
        })
    
        $("#select_role_form_create").select2({
            placeholder: "Rol principal"
        })
    }

    if(window.location.href.includes($path_view_edit_user)) {
        $('#view_edit_users').fadeIn(500)
        $("#select_country_indicator_user_form_update").select2({
            templateResult: function (item) {
                if (!item.id) { return item.text; }
                var $state = $(
                    `<span><img sytle="display: inline-block;" width="30" height="20" src="${$path_resources}img/flags/${item.title}.svg" />&nbsp;${item.text}</span>`
                );
                return $state;
            },
            templateSelection: function (item) {
                if (!item.id) { return item.text; }
                var $state = $(
                    `<span><img sytle="display: inline-block;" width="30" height="20" src="${$path_resources}img/flags/${item.title}.svg" />&nbsp;${item.text}</span>`
                );
                return $state;
            }
        
        })
    
        $("#select_type_document_user_form_update").select2({
            placeholder: "Tipo de documento"
        })
    
        $("#select_enterprise_user_form_update").select2({
            placeholder: "Empresa"
        })
    
        $("#select_area_user_form_update").select2({
            placeholder: "Área"
        })
    
        $("#select_occupation_user_form_update").select2({
            placeholder: "Cargo"
        })
    
        $("#select_user_update_form_update").select2({
            placeholder: "Usuario"
        })
    
        $("#select_role_form_update").select2({
            placeholder: "Rol principal"
        })
    }

    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Por favor, rellena este campo.",
        email: "Por favor, escribe una dirección de correo válida",
        url: "Por favor, escribe una URL válida.",
        date: "Por favor, escribe una fecha válida.",
        dateISO: "Por favor, escribe una fecha (ISO) válida.",
        number: "Por favor, escribe un número entero válido.",
        digits: "Por favor, escribe sólo dígitos.",
        creditcard: "Por favor, escribe un número de tarjeta válido.",
        equalTo: "Por favor, escribe el mismo valor de nuevo.",
        accept: "Por favor, escribe un valor con una extensión aceptada.",
        maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
        minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
        rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
        range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
        max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
        min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    })

    if(window.location.href === $path_view_users_list || window.location.href === 'http://localhost/datamax/') {
        display_list_users()
    }

    display_list_search_status_users()
    
})