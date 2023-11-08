<!DOCTYPE html>
<html lang="es">
    <head>
        {block name=head}{/block}
    </head>
    <body class="collapsed-menu bg-light-gray-two">
        <div class="br-logo" >
            <a  href="#">
                <img src="{$RESOURCES}img//datamax.png" class="wd-150">
            </a>
        </div>
        <div class="br-sideleft overflow-y-auto" id="btnLeftMenu">
            <div class="br-sideleft-menu">
                <br/>
                <div class="sidebar-secondary">
                    <a>
                        <i class="icon-sidebar-secondary fa-solid fa-house"></i>
                    </a>
                    <a>
                        <i class="icon-sidebar-secondary fa-solid fa-handshake-angle"></i>
                    </a>
                    <a>
                        <i class="icon-sidebar-secondary fa-solid fa-file-lines"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="br-header">
            <img id="logo_menu" class="mg-l-20" src="{$RESOURCES}img/datamax.png">
    
            {* <div class="br-header-left">
                <div class="navicon-left hidden-md-down">
                    <a id="btnLeftMenu" href="">
                        <span id="bars_menu" class="d-none">
                            <i class="fas fa-bars dark-blue"></i>
                        </span>
                        <img id="logo_menu" src="{$RESOURCES}img/Grupo 43.png">
                    </a>
                </div>
                <div class="navicon-left hidden-lg-up">
                    <a id="btnLeftMenuMobile" href="">
                        <span id="bars_menu_mobile" class="d-none">
                            <i class="fas fa-bars dark-blue"></i>
                        </span>
                        <img id="logo_menu_mobile" src="{$RESOURCES}img/Grupo 43.png">
                    </a>
                </div> *}
                {* {if $affiliate eq false}
                    <div class="div-gral-search">
                        {if $session_company_gral != ''}
                            <img src="{$path_logocompanysearch}/{$session_company_gral}" class="logo_company_search">
                        {/if}
                        {if $session_project_text_gral != ''}
                            <p class="slash-search">/</p>
                            <p class="tx-project-gral">{$session_project_text_gral}</p>
                        {/if}
                        <button class="btn btn-gral-search" id="btn_gral_search"><i class="fas fa-filter"></i></button>
                        {if $session_company_gral != '' || $session_project_text_gral != ''}
                            <button class="btn btn-gral-cancel" id="btn_gral_cancel"><i class="fas fa-eraser"></i></button>
                        {/if}
                    </div>
                {/if} *}
            {* </div>
            <div class="br-header-right">
            </div> *}
            <div class="br-header-right">
                <nav class="nav">
                    <div class="dropdown">
                        <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                            <span class="logged-name hidden-md-down">{$name_user}</span>
                            <i class="fas fa-user tx-20 dark-blue"></i>
                            <span class="square-10 bg-success"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-header wd-200">
                            <ul class="list-unstyled user-profile-nav">
                                <li><a href="#"><i class="fas fa-user-edit"></i> Editar Usuario</a></li>
                                <li><a href="#"><i class="fas fa-power-off"></i> Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="navicon-right">
                    <a id="btnRightMenu" href="" class="pos-relative">
                        <i class="fas fa-cogs tx-20 dark-blue"></i>
                        <span class="square-6 bg-primary rounded-circle"></span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="br-sideright" id="btnRightMenu">
            <div class="tab-content">
                {* <h5 class="tx-white pd-20 pd-t-50">Control de acceso</h5> *}
                <div class="menu-right-sid">
                    <p class="header-sidebar-primary">
                        <i class="px-1 fa fa-cogs"></i>
                        Control de acceso
                    </p>
                    <div class="sidebar-primary">
                        <a class="item-selected">
                            <i class="px-3 icon-sidebar-primary fa-solid fa-users"></i>
                            Usuarios
                        </a>
                        <a class="item-sidebar-nav">
                            <i class="item-sidebar-nav px-3 icon-sidebar-primary fa-solid fa-robot"></i>
                            Roles
                        </a>
                        <a class="item-sidebar-nav">
                            <i class="item-sidebar-nav px-3 icon-sidebar-primary fa-solid fa-star"></i>
                            Acciones
                        </a>
                        <a class="item-sidebar-nav">
                            <i class="item-sidebar-nav px-3 icon-sidebar-primary fa-solid fa-cubes"></i>
                            <span>Módulos/</span>
                            <p class="text-submodule">Submódulos</p>
                        </a>
                    </div>
                    <hr />
                </div>
            </div>
        </div>

        {* {if $affiliate eq false}
        <div class="br-sideright">
            <ul class="nav nav-tabs sidebar-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" role="tab" href="#affiliates"><i class="far fa-user tx-white-20"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab" href="#attachments"><i class="far fa-folder tx-white-20"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab" href="#calendar"><i class="far fa-calendar tx-white-20"></i></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab" href="#settings"><i class="fas fa-user-cog tx-white-20"></i></a>
                </li>
            </ul>
        </div>
        <div id="modal_gral_search" class="modal fade">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header bg-light-blue pd-y-10 pd-x-25">
                        <h6 class="mg-b-0"><i class="fas fa-filter icon-modal dark-blue"></i><span > Filtrar búsqueda</span></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="modal-close bg-dark-blue" aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body pd-25">
                        <form id="form_search_project" method="post" action="{$select_company_project}">
                            <div class="row mg-y-10">
                                <div class="col-12">
                                    <div class="form-group pos-relative">
                                        <label class="form-control-label light-gray-four">Asociación</label>
                                        <select class="form-control" id="search_company" name="search_company">
                                        </select>
                                        <input type="hidden" class="d-none" id="search_company_text" name="search_company_text">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group pos-relative">
                                        <label class="form-control-label light-gray-four">Proyecto</label>
                                        <select class="form-control" id="search_project" name="search_project">
                                        </select>
                                        <input type="hidden" class="d-none" id="search_project_text" name="search_project_text">
                                    </div>
                                </div>
                                <div class="col-12 mg-t-20">
                                    <button type="submit" class="btn btn-light-blue tx-16 pd-y-10 pd-x-25 tx-mont tx-medium float-left">Buscar</button>
                                    <button type="button" id="btn_modal_gral_cancel" class="btn btn-secondary tx-16  pd-y-10 pd-x-25 tx-mont tx-medium float-right" data-dismiss="modal">Limpiar búsqueda</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {/if} *}
        <div class="br-mainpanel">
            {block name=body}{/block}
            <footer class="br-footer dtm">
                <div class="footer-left">
                    {* <div class="mg-b-2 foot">{$COPYRIGHT}</div> *}
                    <div class="mg-b-2 foot "><p class="mg-0">Este es un producto creado por <img src="{$RESOURCES}/img/conectera.png" alt="conectera" class="mg-l-4"></p></div>
                </div>
                
            </footer>
        </div>
        <script src="{$RESOURCES}lib/jquery/jquery.js"></script>
        <script src="{$RESOURCES}lib/jquery-ui/jquery-ui.min.js"></script>
        <script src="{$RESOURCES}lib/jquery-form/jquery.form.min.js"></script>
        <script src="{$RESOURCES}lib/popperjs/popper.js"></script>
        <script src="{$RESOURCES}lib/bootstrap/js/bootstrap.js"></script>
        <script src="{$RESOURCES}lib/datatables/js/datatables.min.js"></script>
        <script src="{$RESOURCES}lib/x-editable/js/bootstrap-editable.js"></script>
        <script src="{$RESOURCES}lib/datatables/js/dataTables.scroller.min.js"></script>
        <script src="{$RESOURCES}lib/font-awesome/js/all.js" data-auto-replace-svg="false"></script>
        <script src="{$RESOURCES}lib/moment/moment.js"></script>
        <script src="{$RESOURCES}lib/moment/moment-locales.js"></script>
        <script src="{$RESOURCES}lib/switchbutton/js/switchButton.js"></script>
        <script src="{$RESOURCES}lib/malihu-scrollbar/js/jquery.mCustomScrollbar.js"></script>
        <script src="{$RESOURCES}lib/izimodal/js/iziModal.js"></script>
        <script src="{$RESOURCES}lib/izitoast/js/iziToast.js"></script>
        <script src="{$RESOURCES}lib/select2/js/select2.full.js"></script>
        <script src="{$RESOURCES}lib/select2/js/i18n/es.js"></script>   
        <script src="{$RESOURCES}lib/jquery-validation/jquery.validate.js"></script>
        <script src="{$RESOURCES}lib/jquery-validation/additional-methods.js"></script>
        <script src="{$RESOURCES}lib/jquery-validation/localization/messages_es.js"></script>
        <script src="{$RESOURCES}lib/smart-wizard/js/jquery.smartWizard.js"></script>
        <script src="{$RESOURCES}lib/datepicker/datepicker.js"></script>
        <script src="{$RESOURCES}lib/datepicker/datepicker.es-ES.js"></script>
        <script src="{$RESOURCES}lib/timepicker/dist/wickedpicker.min.js"></script>
        <script src="{$RESOURCES}lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="{$RESOURCES}lib/paginationjs/pagination.min.js"></script>
        <script src="{$RESOURCES}lib/spectrum/spectrum.js"></script>
        <script src="{$RESOURCES}lib/bootstrap-star-rating/js/star-rating.min.js"></script>
        <script src="{$RESOURCES}lib/bootstrap-star-rating/themes/krajee-fas/theme.js"></script>
        <script src="{$RESOURCES}lib/bootstrap-star-rating/js/locales/es.js"></script>
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.1.5/js/dx.all.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.0/dist/croppr.min.js"></script>
        <script src="{$RESOURCES}lib/nestable/js/jquery.nestable.js"></script>
        <script src="{$RESOURCES}lib/cropper/cropper.min.js"></script>

        <script>
            window.paceOptions = {
                ajax: {
                    trackMethods: ['GET', 'POST', 'PUT', 'DELETE', 'REMOVE']
                }
            };
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
        
        <script src="{$RESOURCES}lib/pacejs/pace.min.js"></script>

        <script type="text/javascript">
            {* var $path_notifications                                          =   '{$path_notifications}'; *}
            var $path_search_companies                                          =   '{$path_search_companies}';
            var $path_search_projects                                           =   '{$path_search_projects}';
            var $path_cleargeneralsearch                                         =   '{$path_cleargeneralsearch}';
            var session_company_gral                                            =   '{$session_company_gral}';
            var session_company_text_gral                                       =   '{$session_company_text_gral}';
            var session_project_gral                                            =   '{$session_project_gral}';
            var session_project_text_gral                                       =   '{$session_project_text_gral}';

            Pace.options = {
                ajax: {
                    trackMethods: ['GET', 'POST', 'PUT', 'DELETE', 'REMOVE']
                }
            }
        </script>

        <script src="{$RESOURCES}js/datamax.js"></script>
        {block name=scripts}{/block}
    </body>
</html>