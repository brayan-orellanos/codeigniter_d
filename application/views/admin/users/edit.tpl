{extends file="./view.tpl"}
{block name="body_container"}
    <div id="view_edit_users" class="container-view display-none">
            <a id="navigate_to_list_user_since_edit_user" href="{$path_view_users_list}" class="btn-nav">Volver</a>
            <p class="title-view">Editar usuario</p>
            <form id="form_edit_user">
                <div class="mx-60 container-sections-icons-users">
                    <div class="section-user-selected">
                        <div class="mt-460n">
                            <div id="icon_avatar_prev_form_edit" class="icon-selected center display-none">
                                <i class="fa-solid fa-user fa-2xl"></i>
                            </div>
                            <img width="80" height="80" id="avatar_selected_prev_form_edit" src="{$RESOURCES}img/users/{$data['user']['photo']}" class="avatar-selected" alt="logo-user" src="" />
                            <input type="file" id="img_upload_edit_form" class="display-none">
                        </div>
                        <div id="badge_upload_img_avatar_edit" class="badge-icon-user center">
                            <i class="fa-solid fa-pencil fa-xs"></i>
                        </div>
                    </div>
                    <div class="section-form-users">
                        <div class="container-form-create">
                            <input id="input_id_user" type="hidden" value="{$data['user']['id']}" />
                            <div class="container-input-form">
                                <input required id="input_name_user_form_update" value="{$data['user']['name']}" name="name" class="input-text-form-2" type="text" />
                                <span class="label-input-text-form">Nombres</span>
                            </div>
                            <div class="container-input-form">
                                <input required id="input_lastname_user_form_update" value="{$data['user']['lastname']}" name="lastname" class="input-text-form-2" type="text" />
                                <span class="label-input-text-form">Apellidos</span>
                            </div>
                            <div class="group-inputs-form">
                                <div id="container_input_form_document_type_edit" class="w-40per container-select-validate-forms">
                                    <select id="select_type_document_user_form_edit" name="document_type" id="select_type_document_user_form_update" class="js-example-basic-single">
                                        <option value="">Tipo de documento</option>
                                        <option value="C.C." {if $data['user']['document_type'] == 'C.C.'}selected{/if}>CC. Cédula de ciudadanía</option>
                                        <option value="C.E." {if $data['user']['document_type'] == 'C.E.'}selected{/if}>CE. Cédula de extranjería</option>
                                    </select>
                                </div>
                                <div class="w-60per">
                                    <div class="container-input-form">
                                        <input required name="document_number" id="input_document_number_user_form_update" value="{$data['user']['document_number']}" class="input-text-form-2" type="number" />
                                        <span class="label-input-text-form">Número de documento</span>
                                    </div>
                                </div>
                            </div>
                            <div class="group-inputs-form">
                                <div class="w-40per">
                                    <select name="country_indicator" id="select_country_indicator_user_form_update" value="{$data['user']['country_indicator']}" class="js-example-basic-single">
                                        {foreach $data['countries'] as $country}
                                            <option title="{$country['abreviature']}" {if $data['user']['country_indicator'] == $country['indicative']}selected{/if} value="{$country['indicative']}">{$country['abreviature']} (+{$country['indicative']})</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="w-60per">
                                    <div class="container-input-form">
                                        <input required name="cell_phone_number" id="input_phone_user_form_update" value="{$data['user']['cell_phone_number']}" class="input-text-form-2" type="number" />
                                        <span class="label-input-text-form">Número de celular</span>
                                    </div>
                                </div>
                            </div>
                            <div class="container-input-form">
                                <input required id="input_email_user_form_update" name="email" value="{$data['user']['email']}" class="input-text-form-2" type="email" />
                                <span class="label-input-text-form">Correo</span>
                            </div>
                            <div id="container_input_form_occupation_edit" class="container-select-validate-forms">
                                <select id="select_occupation_user_form_edit" value="{$data['user']['occupation']}" name="occupation" class="js-example-basic-single">
                                    <option value="">Cargo</option>
                                    {foreach $data['occupations'] as $occupation}
                                        <option value="{$occupation['id']}" {if $data['user']['occupation'] == $occupation['id']}selected{/if}>{$occupation['name']}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="group-inputs-form my-2">
                                <div id="container_input_form_enterprise_edit" class="w-40per container-select-validate-forms">
                                    <select id="select_enterprise_user_form_edit" name="enterprise" class="js-example-basic-single">
                                        <option value="">Empresa</option>
                                        {foreach $data['enterprises'] as $enterprise}
                                            <option value="{$enterprise['id']}" {if $data['user']['enterprise'] == $enterprise['id']}selected{/if}>{$enterprise['name']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div id="container_input_form_area_edit" class="w-60per container-select-validate-forms">
                                    <select id="select_area_form_edit" value="{$data['user']['area']}" name="area" class="js-example-basic-single">
                                        <option value="">Área</option>
                                        {foreach $data['areas'] as $area}
                                            <option value="{$area['id']}" {if $data['user']['area'] == $area['id']}selected{/if}>{$area['name']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="group-inputs-form">
                                <div id="container_input_form_user_update_edit" class="w-40per container-select-validate-forms">
                                    <select id="select_user_update_form_edit" name="user_update" value="{$data['user']['user_update']}" class="js-example-basic-single">
                                        <option value="">Usuario</option>
                                        {foreach $data['users'] as $user}
                                            <option value="{$user['id']}" {if $data['user']['user_update'] == $user['id']}selected{/if}>{$user['name']} {$user['lastname']}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div id="container_input_form_role_edit" class="w-60per container-select-validate-forms">
                                    <select id="select_role_form_edit" value="{$data['user']['role']}" name="role" class="js-example-basic-single">
                                        <option value="">Rol principal</option>
                                        {foreach $data['roles'] as $role}
                                            <option value="{$role['id']}" {if $data['user']['role'] == $role['id']}selected{/if}>{$role['name']}</option>
                                        {/foreach}
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-list-roles">
                        <div class="header-section-list-roles">
                            <p class="text fontWeight-600">Asignar roles secundarios</p>
                            <button type="button" data-bs-toggle="modal" class="btn-nav">
                                <i class="px-2 fa-solid fa-plus"></i> Nuevo Rol
                            </button>
                        </div>
                        <hr />
                        <div class="section-filter-list-roles">
                            <div>
                                <input id="check_selected_all_roles_form_edit" class="check-selected-all-roles" type="checkbox" />
                                <label class="text fontWeight-600 pt-2 pl-2">Todos</label>
                            </div>
                            <input id="search_roles_form_update" class="input-search" type="text" placeholder="Buscar..." />
                        </div>
                        <div id="section_list_roles_user_edit" class="section-list-roles-form-users">
                            {foreach $data['roles'] as $role}
                                <div class="item-rol">
                                    <div>
                                        <input class="checkbox-roles-forms checkbox-roles-form-update-user-id" {if in_array($role['id'],$data['user']['secundary_roles_ids'])}checked{/if} value="{$role['id']}" type="checkbox" name="roles_secundary" />
                                        <label class="text" for="html">{$role['name']}</label>
                                    </div>
                                    <div class="tooltip-h">
                                        <i data-bs-toggle="modal" data-bs-target="#modal_detail_rol"
                                        class="icon-list-rol px-1 fa-solid fa-bullseye display-modal-detail-roles-id"></i>
                                        <div class="tooltip-content">
                                            Ver detalle
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                        <input id="role_selected_form_edit" value="1" type="hidden" name="role_edit"/>
                    </div>
                </div>
                <div class="mx-60 container-btn-process-user">
                    <button type="submit" class="btn-nav">Guardar</button>
                </div>
            </form>
        </div>
        <div class="modal fade" id="modal_upload_img_avatar_edit" tabindex="-1" aria-labelledby="modal_detail_rol" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-card-upload-files">
                    <div class="modal-body">
                        <div class="container-img-avatar">
                            <div class="section-img-avatar">
                                <div class="bg-img-avatar">
                                    <img id="img_avatar_prev_form_edit" width="300" height="300" class="img-selected" src="{$RESOURCES}img/users/{$data['user']['photo']}" alt="logo-avatar" />
                                </div>
                            </div>
                            <small id="text_error_message_image_form_edit" class="center text-error"></small>
                            <div class="section-upload-avatar">
                                <div class="bg-upload-avatar">
                                    <button type="button" class="btn-nav-outlined-upload">
                                        <label for="img_upload_edit_form">Examinar</label>
                                    </button>
                                    <button id="btn_change_avatar_form_edit" type="button" class="btn-nav-upload display-none">Aceptar</button>
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="modal_edit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-card">
                    <div class="modal-body">
                        <div class="container-modal">
                            <img src="{$RESOURCES}img/icon_pencil.png" width="80px" />
                            <p class="text-center title-modal">¿Terminaste tu edición?</p>
                            <p class="text-center content-text-modal">¿Estás seguro/a que deseas guardar los cambios realizados sobre este usuario?</p>
                            <button id="edit_user" type="button" class="btn-nav" data-bs-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{/block}