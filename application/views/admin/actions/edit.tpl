{extends file="./view.tpl"}

{block name="body_container"}
    <div class="br-pagebody mg-t-3 pd-r-30 pd-t-30 pd-l-30 pd-b-0 bg-light-max">
        <div class="wd-100p mg-t-10">
            <div class="row mg-x-0">
                <div class="col-lg-12 p-0 mg-t-30">
                    <a type="button" href="{$path_actions}" class="btn-m btn_volver">Volver</a>
                    <h6 class="titles">Editar acción</h6>
                </div>
                <form class="wd-100p" id="form-edit" method="post" action="{$path_edit}">
                    <div class="mg-lg-l-80 mg-md-l-30 mg-t-10">
                        <div class="wd-100p w-100 cont_info m-0">
                            <div class="cont_action_inputs cont_inputs_actions m-0 gap-4 ctn_action_icons">
                                <input type="hidden" name="id" value="{if $data_action.data}{$data_action.data['id']}{/if}">
                                <div class="ctn_action_input">
                                    <p class="p-info mg-b-5">Nombre acción</p>
                                    <p class="mg-0">{if $data_action.data}{$data_action.data['name']}{/if}</p>
                                </div>
                                <div class="err">
                                    <div class="ctn_input">
                                        <label for="description" class="label_inp">Descripción</label>
                                        <input type="text" class="module_name form-control inp" id="description" name="description" autocomplete="off"  autofocus="true" value="{if $data_action.data}{$data_action.data['name_es']}{/if}">
                                    </div>
                                </div>
                            </div>
                            <p class="p-info mg-t-35 mg-b-10">Icono</p>
                            <div class="ctn_action_icons mg-0">
                                <div class="error_icon">
                                    <div class="ctn_action_icon">
                                        <i class="{if $data_action.data}{$data_action.data['icon']}{/if} icon_action_add" id="img_icon"></i>
                                        <p id="name_icon"">{if $data_action.data}{$data_action.data['icon']}{/if}</p>
                                    </div>
                                    <input type="hidden" id="icon_hidden" name="icon" autocomplete="off" value="{if $data_action.data}{$data_action.data['icon']}{/if}">
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
                        <button type="button" class="btn_add btn" id="btn_edit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {if $act_edit}
        <div id="modal_edit" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bd-0 tx-14 dtm-modal">
                    <div class="modal-body">
                        <div class="mg-10">
                            <div class="d-flex justify-content-center align-items-center mg-b-20 mg-t-45">
                                <i class="fas fa-pencil-alt dtm-icon"></i>
                            </div>
                            <p class="text-modal">¿Estas seguro/a?</p>
                            <p class="dtm-confirm">¿Estas seguro/a que deseas guardar los cambios realizados sobre esta acción?</p>
                            <div class="col-lg-12 mg-t-20 d-flex justify-content-center align-items-center">
                                <button type="button" id="btn_confirm_edit" class="btn btn-confirm">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
{/block}