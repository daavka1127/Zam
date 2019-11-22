function refresh(){

    var csrf = $('meta[name=csrf-token]').attr("content");
    $('#datatable').dataTable().fnDestroy();
      $('#datatable').DataTable( {
          "language": {
              "lengthMenu": "_MENU_ мөрөөр харах",
              "zeroRecords": "Хайлт илэрцгүй байна",
              "info": "Нийт _PAGES_ -аас _PAGE_-р хуудас харж байна ",
              "infoEmpty": "Хайлт илэрцгүй",
              "infoFiltered": "(_MAX_ мөрөөс хайлт хийлээ)",
              "sSearch": "Хайх: ",
              "paginate": {
                "previous": "Өмнөх",
                "next": "Дараахи"
              }
          },
          "processing": true,
          "serverSide": true,
          "ajax":{
                   "url": getCompaniesUrl,
                   "dataType": "json",
                   "type": "POST",
                   "data":{
                        _token: csrf
                      }
                 },
          "columns": [
            { data: "id", name: "id" },
            { data: "companyID", name: "companyID", visible:false},
            { data: "companyName", name: "companyName"},
            { data: "gHursHuulalt", name: "gHursHuulalt"},
            { data: "gDalan", name: "gDalan" },
            { data: "gUhmal", name: "gUhmal" },
            { data: "gSuuriinUy", name: "gSuuriinUy" },
            { data: "gShuuduu", name: "gShuuduu" },
            { data: "gUhmaliinHamgaalalt", name: "gUhmaliinHamgaalalt" },
            { data: "gUuliinShuuduu", name: "gUuliinShuuduu" },
            { data: "ognoo", name: "ognoo" }
            ]
      }).ajax.reload();
}

$(document).ready(function(){
    $("#btnPostNewGuitsetgel").click(function(e){
        e.preventDefault();
        var isInsert = true;
        if($("#cmbNewCompanyID").val()=="-1"||$("#cmbNewCompanyID").val()==null){
            alertify.error("Аж ахуйн нэгжийг сонгоно уу.");
            isInsert = false;
        }
        if($("#txtOgnoo").val()==""||$("#txtOgnoo").val()==null){
            alertify.error("Oгноо оруулаагүй байна!");
            isInsert = false;
        }

        if(isInsert == false) { return; }

        $.ajax({
          type: 'POST',
          url: newCompanyUrl,
          data: $("#frmNewGuitsetgel").serialize(),
          success:function(response){
              alertify.alert(response);
              emptyNewModal();
              refresh();
          },
          error: function(jqXhr, json, errorThrown){// this are default for ajax errors
            var errors = jqXhr.responseJSON;
            var errorsHtml = '';
            $.each(errors['errors'], function (index, value) {
                errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
            });
            alert(errorsHtml);
          }
        });
    });
});


function emptyNewModal(){
  $("#txtCompanyName").val("");
  $("#txtOgnoo").val("");
  $("#txtHursHuulalt").val("");
  $("#txtDalan").val("");
  $("#txtUhmal").val("");
  $("#txtSuuriinUy").val("");
  $("#txtShuuduu").val("");
  $("#txtUhmaliinHamgaalalt").val("");
  $("#txtUuliinShuuduu").val("");
}


$(document).ready(function(){
    $("#btnEditGuitsetgel").click(function(){
        $("#txtEditID").val(dataRow["id"]);
        $("#cmbEditGCompany").val(dataRow["companyID"]);
        $("#txtEditOgnoo").val(dataRow["ognoo"]);
        $("#txtEditGHursHuulalt").val(dataRow["gHursHuulalt"]);
        $("#txtEditGDalan").val(dataRow["gDalan"]);
        $("#txtEditGUhmal").val(dataRow["gUhmal"]);
        $("#txtEditGSuuriinUy").val(dataRow["gSuuriinUy"]);
        $("#txtEditGShuuduu").val(dataRow["gShuuduu"]);
        $("#txtEditGUhmaliinHamgaalalt").val(dataRow["gUhmaliinHamgaalalt"]);
        $("#txtEditGUuliinShuuduu").val(dataRow["gUuliinShuuduu"]);
        if(dataRow == ""){alertify.alert("Та засах мөрөө сонгоно уу!!!")}
        else{$('#modalEditGuitsetgel').modal('show');}

    });
});


$(document).ready(function(){
    $("#btnEditPostGuitsetgel").click(function(e){
        e.preventDefault();
        var isInsert = true;
        if($("#cmbEditGCompany").val()==""||$("#cmbEditGCompany").val()==null){
            alertify.error("Аж ахуйн нэгжийн нэр оруулаагүй байна!!!");
            isInsert = false;
        }
        if($("#txtEditOgnoo").val()==""||$("#txtEditOgnoo").val()==null){
            alertify.error("Ажил эхэлсэн огноо оруулаагүй байна!!!");
            isInsert = false;
        }
        if(isInsert == false){return;}
        $.ajax({
          type: 'POST',
          url: editCompanyUrl,
          data: $("#frmEditGuitsetgel").serialize(),
          success:function(response){
              alertify.alert(response);
              $('#modalEditGuitsetgel').modal('hide');
              refresh();
          },
          error: function(jqXhr, json, errorThrown){// this are default for ajax errors
            var errors = jqXhr.responseJSON;
            var errorsHtml = '';
            $.each(errors['errors'], function (index, value) {
                errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
            });
            alert(errorsHtml);
          }
        });
    });
});

$(document).ready(function(){
    $("#btnDeleteGuitsetgel").click(function(){
        if(dataRow == ""){
            alertify.error('Та Устгах мөрөө дарж сонгоно уу!!!');
            return;
        }

        alertify.confirm( "Та устгахдаа итгэлтэй байна уу?", function (e) {
          if (e) {
            var csrf = $('meta[name=csrf-token]').attr("content");
            $.ajax({
                type: 'POST',
                url: deleteCompanyUrl,
                data: {_token: csrf, id : dataRow['id']},
                success:function(response){
                    alertify.alert(response);
                    refresh();
                    dataRow="";
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alertify.error("Status: " + textStatus); alertify.error("Error: " + errorThrown);
                }
            })
          } else {
              alertify.error('Устгах үйлдэл цуцлагдлаа.');
          }
        });
    });
});