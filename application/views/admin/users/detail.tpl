{extends file="./view.tpl"}
{block name="body_container"}
    <div id="view_detail_user" class="container-view">
            <a id="navigate_to_list_user_since_detail_user" href="{$path_view_users_list}" class="btn-nav">Volver</a>
            <p class="title-view">Detalle de usuario</p>
            <div id="container_section_detail_user" class="container-section-detail-user">
            <div class="section-detail-user">
            <div class="card-detail-user">
                <div class="avatar-detail-user">
                    <img width="80" height="80" class="avatar-selected" src="{$RESOURCES}img/users/{$data_user.data['photo']}" alt="logo-user" />
                    </div>
                    <div class="content-detail-card-user">
                        <p class="text-detail-user fontWeight-600 fontSize-15">
                            {$data_user.data['name']|upper} {$data_user.data['lastname']|upper}
                        </p>
                        <p class="text-detail-user fontSize-15">{$data_user.data['document_type']} {$data_user.data['document_number']}</p>
                        <p class="text-link fontSize-13 fontStyle-Italic mb-0">{$data_user.data['name_occupation']}</p>
                        <p class="text-link fontSize-12 fontStyle-Italic">{$data_user.data['name_area']}</p>
                        <div class="content-info-card-user-detail">
                            <div>
                                <p class="text-detail-user fontSize-15 p-top-5">
                                    <i class="px-2 fa-solid fa-mobile-screen icon-user-info"></i>
                                    (+{$data_user.data['country_indicator']}) {$data_user.data['cell_phone_number']}
                                </p>
                                <p class="text-detail-user fontSize-15 pt-3">
                                    <i class="px-2 fa-solid fa-envelope icon-user-info"></i>
                                    {$data_user.data['email']}
                                </p>
                            </div>
                            <div class="container-section-company-user">
                                <img width="80" height="80" class="logo-company" src="{$RESOURCES}img/enterprises/{$data_user.data['logo_enterprise']}" alt="logo-company" />
                                <p class="text p-top-35">{$data_user.data['name_enterprise']}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-list-roles-user">
                    <p class="text-detail-user fontWeight-600">Roles</p>
                    <div class="section-list-roles-form-users">
                        <div class="item-rol">
                            <div>
                                <label class="text" for="html">{$data_user.data['name_role']}&nbsp;&nbsp; <b><small class="fontStyle-Italic">Rol principal</small></b></label>
                            </div>
                            <div class="container-info-rol">
                                <p class="text-small fontStyle-Italic">{$data_user.data['role_date_insert']}</p>
                                <div class="tooltip-h">
                                    <i data-bs-toggle="modal" data-bs-target="#modal_detail_rol" class="icon-list-rol px-1 fa-solid fa-bullseye display-modal-detail-roles-id"></i>
                                    <div class="tooltip-content">
                                        Ver detalle
                                    </div>
                                </div>
                            </div>
                        </div>
                        {foreach $data_user.data['secundary_roles'] as $role}
                            <div class="item-rol">
                                <div>
                                    <label class="text" for="html">{$role['name']}</label>
                                </div>
                                <div class="container-info-rol">
                                    <p class="text-small fontStyle-Italic">{$role['date_insert']}</p>
                                    <div class="tooltip-h">
                                        <i data-bs-toggle="modal" data-bs-target="#modal_detail_rol" class="icon-list-rol px-1 fa-solid fa-bullseye display-modal-detail-roles-id"></i>
                                        <div class="tooltip-content">
                                            Ver detalle
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}