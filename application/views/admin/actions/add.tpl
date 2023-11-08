{extends file="./view.tpl"}

{block name="body_container"}
    <div class="br-pagebody mg-t-3 pd-r-30 pd-t-30 pd-l-30 pd-b-0 bg-light-max">
        <div class="wd-100p mg-t-10">
            <div class="row mg-x-0">
                <div class="col-lg-12 p-0 mg-t-30">
                    {if isset($id_module)}
                        <a type="button" href="{$path_view_add_submodule}/{$id_module}" class="btn-m btn_volver">Volver</a>
                    {elseif isset($id_submodule)}
                        <a type="button" href="{$path_view_edit_submodule}/{$id_submodule}" class="btn-m btn_volver">Volver</a>
                    {elseif isset($id_act_submodule)}
                        <a type="button" href="#" class="btn-m  btn_volver btn_volver_perm">Volver</a>
                    {else}
                        <a type="button" href="{$path_actions}" class="btn-m btn_volver">Volver</a>
                    {/if}
                    <h6 class="titles">Crear nueva acción</h6>
                    {if isset($id_module)}
                        <input class="form-control" type="hidden" id="id_module" name="id_module" value="{$id_module}">
                    {else}
                        <input class="form-control" type="hidden" id="id_module" name="id_module">
                    {/if}
                    
                </div>
                <form class="wd-100p" id="form-add" method="post" action="{$path_add}">
                    <div class="mg-lg-l-80 mg-md-l-30 mg-t-30">
                        <div class="wd-100p w-100 cont_info m-0">
                            <div class="cont_inputs_actions m-0 gap-4">
                                {if isset($id_submodule)}
                                    <input class="form-control" type="hidden" id="id_submodule" name="id_submodule" value="{$id_submodule}">
                                {else}
                                    <input class="form-control" type="hidden" id="id_submodule" name="id_submodule">
                                {/if}
                                {if isset($id_act_submodule)}
                                    <input class="form-control" type="hidden" id="id_act_submodule" name="id_act_submodule" value="{$id_act_submodule}">
                                {else}
                                    <input class="form-control" type="hidden" id="id_act_submodule" name="id_act_submodule">
                                {/if}

                                <div class="err">
                                    <div class="ctn_input">
                                        <label for="name" class="label_inp">Nombre acción</label>
                                        <input type="text" class="module_name mayus_name form-control inp" id="name" name="name" autocomplete="off"  autofocus="true">
                                    </div>
                                </div>
                                <div class="err">
                                    <div class="ctn_input">
                                        <label for="description" class="label_inp">Descripción</label>
                                        <input type="text" class="module_name form-control inp" id="description" name="description" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <p class="p-info mg-t-35 mg-b-10">Icono</p>
                            <div class="ctn_action_icons mg-0">
                                <div class="error_icon">
                                    <div class="ctn_action_icon">
                                        <i class="fas fa-pencil-alt icon_action_add" id="img_icon"></i>
                                        <p id="name_icon"">Nombre icono</p>
                                    </div>
                                    <input type="hidden" id="icon_hidden" name="icon" autocomplete="off">
                                </div>
                                <div class="card-box wd-100p m-0">
                                    <div>
                                        <div class="wd-100p d-flex justify-content-between align-items-center flex-wrap mg-b-40">
                                            <div class="ft-left">
                                                <p class="p-info">Selecciona un icono para tu acción</p>
                                            </div>
                                            <div class="ft-right">
                                                <div class="form-group mg-0 search d-md-inline-block">
                                                    <input class="form-control search_list_icons pd-15" type="text" placeholder="Buscar...">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="icons d-flex justify-content-center {if !$mobile}overflow-y-auto{/if}">
                                            <div class="list_icons"></div>
                                        </div> 
                                        <div class="icons_pagination mg-r-40 mg-t-10"></div>                          
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 p-0 d-flex justify-content-end align-items-center mg-t-15">
                        <button type="button" class="btn_add btn" id="btn_add">Crear acción</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {* {if $act_add} *}
        <div id="modal_add" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bd-0 tx-14 dtm-modal">
                    <div class="modal-body">
                        <div class="mg-10">
                            <div class="d-flex justify-content-center align-items-center mg-b-20 mg-t-45">
                                <i class="fas fa-plus dtm-icon"></i>
                            </div>
                            <p class="text-modal">¿Estas seguro/a?</p>
                            <p class="dtm-confirm">¿Estas seguro que deseas crear esta nueva acción?</p>
                            <div class="col-lg-12 mg-t-20 d-flex justify-content-center align-items-center">
                                <button type="button" id="btn_confirm_add" class="btn btn-confirm">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {* {/if} *}
{/block}