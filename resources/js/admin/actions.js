$(function ($) {
  let timeoutID = null;
  data_list();
  
  $(".search_list").keyup(function (e) {
    clearTimeout(timeoutID);
    timeoutID = setTimeout(() => data_list(), 1000);
  });
  
  $("#page_size").on("change", function () {
    data_list();
  });

  $(".search_list_icons").keyup(function (e) {
    clearTimeout(timeoutID);
      timeoutID = setTimeout(() => data_icons($(this).val()), 1000);
  });

  if(localStorage.getItem('state') == 'ADD') {
    $('.btn_volver_perm').attr('href', `${localStorage.getItem('ruta')}`);
  } else {
    $('.btn_volver_perm').attr('href', `${localStorage.getItem('ruta2')}`);
  }
    
  data_icons();
    
  $("body").on('click', '.icons_in', function () {
    $("#name_icon").text($(this).attr('data-style'))
    $("#img_icon").attr('class', $(this).attr('data-style') + ' icon_action_add')
    $("#icon_hidden").val($(this).attr('data-style'))
    $("#icon_hidden").addClass('vali')
    inputs_add();
  }) 

  $("#btn_add").on('click', function () {
    $("#modal_add").modal("show");
  })

  $("#btn_confirm_add").on("click", function () {
    $("#form-add").ajaxSubmit({
      dataType: "json",
      success: add,
    });  
  });
    
  $("#btn_edit").on('click', function () {
    $("#modal_edit").modal("show");
  })
    
  $("#btn_confirm_edit").on("click", function () {
    $("#form-edit").ajaxSubmit({
      dataType: "json",
      success: edit,
    });  
  });

  $(".cards_list").on("click", "a.remove-row", function () {
    $("#action_drop").val($(this).attr("data-id"));
    $("#modal_delete").modal("show");
  });
    
  $("#btn_confirm_delete").on("click", function () {
    $.ajax({
      type: "POST",
      url: $path_drop,
      data: {
        id: $("#action_drop").val(),
      },
      dataType: "json",
      success: function (response) {
        data_list();
        modal_alert(response.value, response.message);
        $("#modal_delete").modal("hide");
      },
      error: function () {
        modal_alert(false, "Error de conexión.");
        $("#modal_delete").modal("hide");
      },
    });
  });

  inputs_edit()

  $('#description').keyup( function() {
    inputs_edit()
  })
    
  inputs_add();

  val_input_add('#name')
  val_input_add('#description')

  $(".cont_inputs_actions .inp").each(function(el) {
    if($(this).val() !== "" || $(this).prop('autofocus')) {
      $(this).addClass('act')
    } else {
      $(this).removeClass('act')
    }
  })
    
  $(".cont_inputs_actions .inp").blur(function() {
    if($(this).val() == '') {
      $(this).removeClass('act')
    } else {
      $(this).addClass('act')
    }
  })
});  

function data_list() {
  if ($(".cards_list").length > 0) {
    let size = $("#page_size").val();
    let search = $(".search_list").val();

    $(".cards_pagination").pagination({
      dataSource: $path_view,
      locator: "data",
      formatNavigator:
        '<p class="separate"><span>Página </span><input type= "text" class= "J-paginationjs-go-pagenumber cont" value="<%= currentPage %>" id="cont"> <span>de </span> <span><%= totalPage %> </span></p>',
      showPageNumbers: false,
      showNavigator: true,
      prevText: '<i class="fas fa-angle-left"></i>',
      nextText: '<i class="fas fa-angle-right"></i>',
      totalNumberLocator: function (response) {
        $("#num").html(Math.ceil(response.recordsTotal / size));
        return response.recordsFiltered;
      },
      pageSize: size,
      ajax: {
        type: "GET",
        dataType: "json",
        data: {
          search: search,
        },
        beforeSend: function () {
          $(".cards_list").html(
            '<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>'
          );
        },
      },
      callback: function (response, pagination) {
        if (response.length > 0) {
          $(".cards_list").html(response);
        } else {
          $(".cards_list").html("No hay registros.");
        }
      },
    });
  }
}

function data_icons(search) {
  if ($(".list_icons").length > 0) {
    let search = $(".search_list_icons").val();
    let map = new Map();
    let data;
  
    $.ajax({
      type: "GET",
      url: resources + "/lib/font-awesome/js/icons.json",
      dataType: "json",
      beforeSend: function () {
        $(".list_icons").html(
          '<div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div>'
        );
      },
      success: function (response) {
        if(response) {
          $(".list_icons").html('');
        }
  
        for(let item in response) {
          map.set(item, response[item]);
        }
  
        data = Array.from(map, ([name, value]) => ({ name, value }))
  
        if(search && search !== '') {
          data = data.filter(el => el.value.label.toLowerCase().includes(search.toLowerCase()))
        } else {
          data = data = Array.from(map, ([name, value]) => ({ name, value }))
        }
  
        $(".icons_pagination").pagination({
          dataSource: data,
          formatNavigator:
          '<p class="separate"><span>Página </span><input type= "number" class= "J-paginationjs-go-pagenumber cont" value="<%= currentPage %>" id="cont"> <span>de </span> <span><%= totalPage %> </span></p>',
          showPageNumbers: false,
          showNavigator: true,
          prevText: '<i class="fas fa-angle-left"></i>',
          nextText: '<i class="fas fa-angle-right"></i>',
          pageSize: 30,
          callback: function (response, pagination) {
            if (response.length > 0) {
              $(".list_icons").html('');
              response.forEach((el) => {
                if (el.value.free.length > 1) {
                  el.value.free.forEach((e, i) => {
                    $(".list_icons").append(`              
                      <div class="icons_in" data-style="fas fa-${e} fa-${el.name}" data-name="${el.value.label}">
                        <div class="icon_list">
                          <i class="fas fa-${e} fa-${el.name}"></i>
                        </div>
                        <p class="name_icon">${el.value.label.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); })}</p>
                      </div>`);
                  });
                } else {
                  $(".list_icons").append(`              
                    <div class="icons_in" data-style="fas fa-${el.value.styles[0]} fa-${el.name}" data-name="${el.value.label}">
                      <div class="icon_list">
                        <i class="fas fa-${el.value.styles[0]} fa-${el.name}"></i>
                      </div>
                      <p class="name_icon">${el.value.label.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); })}</p>
                    </div>`);
                }
              });
            } else {
              $(".cards_list").html("No hay registros.");
            }
          },
        });
      },
      error: function () {
        console.log(error);
      },
    });
  }
}

$(".mayus_name").keyup(function (e) {
  $(this).val($(this).val().toUpperCase());
});
  
function add(response) {
  $("#modal_add").modal("hide");
  var id = $('#id_module').val();
  var sub = $('#id_submodule').val();
  var sub_act = $('#id_act_submodule').val();
  var sub_edit_act = $('#edit_id_act_sub').val();

  if((id!='')&&(sub=='')){
    modal_alert_and_event(response.value, response.message, function () {
      if (response.value) {
        window.location.href = `${$path_view_add_submodule}/${id}`;
      }
    });
  }
  else if((sub!='')&&(id=='')){
    modal_alert_and_event(response.value, response.message, function () {
      if (response.value) {
        history.back();
      }
    });
  }
  else if(localStorage.getItem('state') == 'ADD'){
    modal_alert_and_event(response.value, response.message, function () {
      if (response.value) {
        window.location.href = localStorage.getItem('ruta');
      }
    });
  }
  else if(localStorage.getItem('state') == 'EDIT'){
    modal_alert_and_event(response.value, response.message, function () {
      if (response.value) {
        window.location.href = localStorage.getItem('ruta2');
      }
    });
  }
  else
  {

    modal_alert_and_event(response.value, response.message, function () {
      if (response.value) {
        window.location.href = $path_actions;
      }
    });
  }
  
}

function edit(response) {
  $("#modal_edit").modal("hide");
  modal_alert_and_event(response.value, response.message, function () {
    if (response.value) {
      window.location.href = `${$path_actions}`;
    }
  });
}

function inputs_edit() {
  if($('#description').val() != '') {
    $("#btn_edit").prop('disabled', false)
    $("#btn_edit").removeClass('dis')
  } else {
    $("#btn_edit").prop('disabled', true)
    $("#btn_edit").addClass('dis')
  }
}

function inputs_add() {
  if($('#name').val() != '' && $('#description').val() != '' && $('#icon_hidden').hasClass('vali')) {
    $("#btn_add").prop('disabled', false)
    $("#btn_add").removeClass('dis')
  } else {
    $("#btn_add").prop('disabled', true)
    $("#btn_add").addClass('dis')
  }
}

function val_input_add(input) {
  $(input).keyup( function() {
    inputs_add()
  })
}