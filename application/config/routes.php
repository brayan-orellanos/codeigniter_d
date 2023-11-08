<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//DATAMAX

$route['default_controller']                                                    =   'users_controller/view';

//ACTIONS
$route['actions']                                                               =   'actions_controller/view';

$route['actions/datalist']                                                      =   'actions_controller/datalist';

$route['actions/add']                                                           =   'actions_controller/add';

$route['actions/view_add']                                                      =   'actions_controller/view_add';

$route['actions/view/detail/(:any)']                                            =   'actions_controller/view_detail/$1';

$route['actions/view/add/(:any)']                                               =   'actions_controller/actions_view_add/$1';

$route['actions/view_add/actions/(:any)']                                       =   'actions_controller/view_add_actions/$1';

$route['actions/editsub/view/add/(:any)']                                       =   'actions_controller/editsub_actions_view_add/$1';

$route['actions/editper/view_add/(:any)']                                       =   'actions_controller/editper_view_add_actions/$1';

$route['actions/view/edit/(:any)']                                              =   'actions_controller/view_edit/$1';

$route['actions/view/trace/(:any)']                                             =   'actions_controller/view_trace/$1';

$route['actions/udrop']                                                         =   'actions_controller/udrop';

$route['actions/edit']                                                          =   'actions_controller/edit';

//USERS
$route['users']                                                                 =   'users_controller/view';

$route['users/list']                                                            =   'users_controller/list';

$route['users/view/add']                                                        =   'users_controller/view_add';

$route['users/add']                                                             =   'users_controller/add';

$route['users/view/detail/(:any)']                                              =   'users_controller/view_detail/$1';

$route['users/display']                                                         =   'users_controller/display';

$route['users/view/edit/(:any)']                                                =   'users_controller/view_edit/$1';

$route['users/edit']                                                            =   'users_controller/edit';

$route['users/udrop']                                                           =   'users_controller/udrop';

$route['users/view/trace/(:any)']                                               =   'users_controller/view_trace/$1';