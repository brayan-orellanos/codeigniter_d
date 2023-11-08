{extends file='../../head.tpl'}
{block name='body'}
    {block name="body_container"}
        <div class="pos-relative">
            <div class="br-pagebody mg-t-30 pd-30 bg-light-max">
                <div class="mn-ht-120 panel">
                    <h6 class="titles pd-t-10">Modulos</h6>
                    <div class="wd-100p d-flex justify-content-between align-items-center flex-wrap my-4">
                        <div class="ft-left">
                            <span>Ver</span>
                            <select class="pageSize" id="page_size">
                                <option value="5" selected>5</option>
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span>elementos</span>
                        </div>
                        <div class="ft-right d-flex flex-row-reverse flex-nowrap align-items-center mt-4 mt-sm-0">
                            {if $act_add}
                                    <a type="button" id="" href="{$path_view_add}" class="btn btnn btn-light-blue ft-right ml-3"
                                        data-toggle="tooltip" data-placement="top" title="Agregar">
                                        <i class="fas fa-plus"></i>
                                    </a>
                            {/if}

                            <div class="form-group search m-0 d-md-inline-block">
                                <input class="form-control search_list" type="text" placeholder="Buscar...">
                            </div>
                        </div>
                    </div>
                    {if $mobile}<br /><br /><br />{/if}
                    {if $act_view}
                        <div class="wd-100p mg-t-10">
                            <div class="row mg-x-0 cards_list mg-b-5"></div>
                            <div class="d-flex justify-content-end">
                               <div class="cards_pagination"></div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    {/block}
    
    {if $act_drop}
        <div id="modal_delete" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bd-0 tx-14 dtm-modal">
                    <div class="modal-body pd-25">
                        <div class="mg-10">
                            <div class="d-flex justify-content-center align-items-center mg-b-20 mg-t-45">
                                <i class="fas fa-trash-alt dtm-icon"></i>
                            </div>
                            <p class="text-modal">¿Estas seguro/a?</p>
                            <p class="dtm-confirm">¿Estas seguro/a que deseas eliminar este módulo?</p>
                            <input type="hidden" class="d-none" id="module_drop">
                            <div class="col-lg-12 mg-t-20 d-flex justify-content-center align-items-center">
                                <button type="button" id="btn_confirm_delete" class="btn btn-confirm">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
{/block}
{block name='scripts'}
    <script type="text/javascript" src="{$RESOURCES}lib/mdb/js/mdb.min.js"></script>
    <script type="text/javascript" src="{$RESOURCES}lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="{$RESOURCES}lib/apexcharts/apexcharts.min.js"></script>
    <script type="text/javascript">
        var $path_view                                                          =   '{$path_view}';
        var $path_modules                                                       =   '{$path_modules}';
        var $path_get_submodules                                                =   '{$path_get_submodules}';
        var $path_drop                                                          =   '{$path_drop}';
        var $path_view_assign_submodule                                         =   '{$path_view_assign_submodule}';
        var $path_view_assign_submodule_edit                                    =   '{$path_view_assign_submodule_edit}';
        var $path_get_actions                                                   =   '{$path_get_actions}';
        var $path_drop_submodule                                                =   '{$path_drop_submodule}';
        var $path_order_sort                                                    =   '{$path_order_sort}';
        var $path_order_modules                                                 =   '{$path_order_modules}';
        var $path_view_add_actions                                              =   '{$path_view_add_actions}';
        var $path_editsub_view_add_actions                                      =   '{$path_editsub_view_add_actions}';

        var height = ($(window).height() - 380);
        var resources                                                           =   '{$RESOURCES}';
    </script>
    <script src="{$RESOURCES}js/admin/modules.js"></script>
{/block}