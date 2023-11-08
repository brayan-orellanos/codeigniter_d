{extends file='../../head.tpl'}
{block name='styles'}
    <link href="{$RESOURCES}css/users.css" rel="stylesheet">
{/block}
{block name='body'}
    {block name="body_container"}
        <div id="view_list_users" class="container-view">
            <p class="title-view-principal">Usuarios</p>
            <div class="header-filter-results">
                <div class="content-select-results">
                    <p class="text-content-select-results">Ver</p>
                    <select id="registers_users_per_page" class="select-results-per-page">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option selected value="5">5</option>
                    </select>
                    <p class="text-content-select-results">elementos</p>
                </div>
                <div class="content-filter-results">
                    <div>
                        <div id="select_filter_list_users" class="select-filter-list-users">
                            <p class="text">Seleccionar</p>
                            <i class="px-1 fa-solid fa-caret-down fa-2xs mt-2"></i>
                        </div>
                        <div id="dropdown_select_filters_list" class="dropwdown-select-filter-list-users">
                            <div id="checks_search_status_users">
                                <div>
                                    <input id="check_filter_all_status_users" class="check-filter-all-users" type="checkbox" checked="checked"/>
                                    <label class="text ps-1" for="html">Todos</label>
                                </div>
                            </div>
                            <hr />
                            <div id="checks_search_company_users">
                                <div>
                                    <input id="check_filter_all_enterprises_users" class="check-filter-all-users" type="checkbox" checked="checked"/>
                                    <label class="text" for="html">Todos</label>
                                    {foreach $enterprises as $enterprise}
                                        <div>
                                            <input value="{$enterprise['id']}" class="checkbox-filter-users check-users-enterprise-id" type="checkbox" />
                                            <label class="text ps-1">{$enterprise['name']}</label>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                    </div>
                    <input id="input_search_users" class="input-search" type="text" placeholder="Buscar..." />
                    <a id="navigate_to_add_user" href="{$path_view_add_users}" class="btn-nav-pg">
                        <i class="fa-solid fa-plus white-text mt-0"></i>
                    </a>
                </div>
            </div>
            <div class="container-activated-users">
                <div>
                    <label id="label_check_activated_all_users" class="text fontStyle-Italic mr-2" for="check_activated_all_users">Activar Todos</label>
                    <input id="check_activated_all_users" class="check-activated-all-users" type="checkbox" />
                </div>
            </div>
            <div id="list_of_users" class="content-results"></div>
            <div class="mb-160" id="container_pagination"></div>
        </div>
        <div class="modal fade" id="modal_delete" tabindex="-1" aria-labelledby="modal_delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-card">
                    <div class="modal-body">
                        <div class="container-modal">
                            <input id="id_user_udrop" type="hidden" value="0">
                            <img src="{$RESOURCES}/img/icon_trash.png" width="60px" />
                            <p class="text-center title-modal">¿Estás seguro/a?</p>
                            <p class="text-center content-text-modal">¿Estás seguro/a que deseas eliminar este usuario?</p>
                            <button id="udrop_modal_user" type="button" class="btn-nav">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/block}
    <div class="modal fade" id="modal_detail_rol" tabindex="-1" aria-labelledby="modal_detail_rol" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-card-detail-rol">
                <div class="modal-body">
                    <div class="container-modal">
                        <div class="header-modal-detail-rol">
                            <img src="{$RESOURCES}/img/icon_robot.png" width="45px" height="35px" />
                            <p class="text-center title-modal pt-1">Detalle Rol</p>
                        </div>
                        <p class="text-center content-text-modal">Este Rol tiene asignados los siguientes permisos:</p>
                        <div class="content-modal-detail-rol">
                            <div class="card-detail-module-rol">
                                <p class="text fontWeight-600">Módulo</p>
                                <p class="text fontWeight-600 my-2 ps-3">
                                    <i class="icon-sidebar-secondary fa-solid fa-house"></i>
                                    <span class="ps-2">Inicio</span>
                                </p>
                                <div class="header-table-submodules-detail-rol mt-1">
                                    <p class="text fontWeight-600 w-70per">Submódulo</p>
                                    <p class="text fontWeight-600 w-30per">Acciones</p>
                                </div>
                                <div class="content-table-submodules-detail-rol">
                                    <p class="text fontWeight-600 w-70per">Nombre submódulo</p>
                                    <div class="w-30per">
                                        <p class="text">Acción 1</p>
                                        <p class="text">Acción 12</p>
                                        <p class="text">Acción 8</p>
                                    </div>
                                </div>
                                <div class="content-table-submodules-detail-rol">
                                    <p class="text fontWeight-600 w-70per">Nombre submódulo</p>
                                    <div class="w-30per">
                                        <p class="text">Acción 1</p>
                                        <p class="text">Acción 12</p>
                                        <p class="text">Acción 8</p>
                                    </div>
                                </div>
                                <div class="content-table-submodules-detail-rol">
                                    <p class="text fontWeight-600 w-70per">Nombre submódulo</p>
                                    <div class="w-30per">
                                        <p class="text">Acción 1</p>
                                        <p class="text">Acción 12</p>
                                        <p class="text">Acción 8</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-detail-module-rol">
                                <p class="text fontWeight-600">Módulo</p>
                                <p class="text fontWeight-600 my-2 ps-3">
                                    <i class="icon-sidebar-secondary fa-solid fa-house"></i>
                                    <span class="ps-2">Inicio</span>
                                </p>
                                <div class="header-table-submodules-detail-rol mt-1">
                                    <p class="text fontWeight-600 w-70per">Submódulo</p>
                                    <p class="text fontWeight-600 w-30per">Acciones</p>
                                </div>
                                <div class="content-table-submodules-detail-rol">
                                    <p class="text fontWeight-600 w-70per">Nombre submódulo</p>
                                    <div class="w-30per">
                                        <p class="text">Acción 1</p>
                                        <p class="text">Acción 12</p>
                                        <p class="text">Acción 8</p>
                                    </div>
                                </div>
                                <div class="content-table-submodules-detail-rol">
                                    <p class="text fontWeight-600 w-70per">Nombre submódulo</p>
                                    <div class="w-30per">
                                        <p class="text">Acción 1</p>
                                        <p class="text">Acción 12</p>
                                        <p class="text">Acción 8</p>
                                    </div>
                                </div>
                                <div class="content-table-submodules-detail-rol">
                                    <p class="text fontWeight-600 w-70per">Nombre submódulo</p>
                                    <div class="w-30per">
                                        <p class="text">Acción 1</p>
                                        <p class="text">Acción 12</p>
                                        <p class="text">Acción 8</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}
{block name='scripts'}
    <script type="text/javascript" src="{$RESOURCES}lib/mdb/js/mdb.min.js"></script>
    <script type="text/javascript" src="{$RESOURCES}lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="{$RESOURCES}lib/apexcharts/apexcharts.min.js"></script>
    <script type="text/javascript">
        const $path_view_users_list                                             =   '{$path_view_users_list}'
        const $path_view_add_users                                              =   '{$path_view_add_users}'
        const $path_view_edit_user                                              =   '{$path_view_edit_user}'
        const $path_users_list                                                  =   '{$path_users_list}'
        const $path_users_detail                                                =   '{$path_view_detail_user}'
        const $path_users_display                                               =   '{$path_users_display}'
        const $path_users_add                                                   =   '{$path_users_add}'
        const $path_users_edit                                                  =   '{$path_users_edit}'
        const $path_users_udrop                                                 =   '{$path_users_udrop}'
        const $path_resources                                                   =   '{$path_resources}'
    </script>
    <script src="{$RESOURCES}js/users.js"></script>
{/block}