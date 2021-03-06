@extends('layouts.layout_main')

@section('content')

  <!-- Datatables -->
      <link href="{{url('public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

<script>
    var newCompanyUrl = "{{url("/companies/store")}}";
    var newWorksUrl = "{{url("/companies/storeWorks")}}";
    var editWorksUrl = "{{url('/companies/updateWorks')}}";
    var getCompaniesUrl = "{{url("/company/get")}}";
    var editCompanyUrl = "{{url("/companies/update")}}";
    var deleteCompanyUrl = "{{url("/companies/delete")}}";
    var getPlansByCompanyIDurl = "{{url("/get/plans/by/companyID")}}";

    var dataRow = "";

    $(document).ready(function(){
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
          "order": [[ 1, "asc" ]],
          "processing": true,
          "serverSide": true,
          "stateSave": true,
          "ajax":{
                   "url": "{{url('/company/get')}}",
                   "dataType": "json",
                   "type": "POST",
                   "data":{
                        _token: "{{ csrf_token() }}"
                      }
                 },
          "columns": [
            { data: "daraalal", name: "daraalal"},
            { data: "id", name: "id", visible:false},
            { data: "heseg_id", name: "heseg_id", visible:false},
            { data: "name", name: "name"},
            { data: "companyName", name: "companyName"},
            { data: "ajliinHeseg", name: "ajliinHeseg"},
            { data: "plan", name: "plan"},
            { data: "allExec", name: "allExec"},
            { data: "per", name: "per", render:function(data, type, row, meta){
              if(data == null){return "";}
              else {return data + "%";}
            }},
            { data: "ognoo1", name: "ognoo1" }
            ]
      });
  });
  $(document).ready(function(){
    $('#datatable tbody').on( 'click', 'tr', function () {
        var currow = $(this).closest('tr');
        $('#datatable tbody tr').css("background-color", "white");
        $(this).closest('tr').css("background-color", "yellow");
        dataRow = $('#datatable').DataTable().row(currow).data();
      });
  });
</script>

<div class="col-xs-12">
  <h2 style="text-align:center;"><strong>Бүртгэгдсэн аж ахуйн нэгжүүд</strong></h2>
  <div class="row">
      <table id="datatable" class="table table-striped table-bordered" style="width:100%;">
          <thead>
              <tr>
                <th>д/д</th>
                <th>ID</th>
                <th></th>
                <th>Хэсэг</th>
                <th>Аж ахуй нэгжийн нэр</th>
                <th>Ажлын хэсэг</th>
                <th>Батлагдсан тоо хэмжээ</th>
                <th>Нийт гүйцэтгэл</th>
                <th>Хувь</th>
                <th>Сүүлд гүйцэтгэл<br>оруулсан огноо</th>
              </tr>
          </thead>
      </table>


  </div>
  <div class="text-left">

    @if(Auth::user()->heseg_id == 5)
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newCompany">Нэмэх</button>
      <button type="button" class="btn btn-warning" id="btnEditCompany">Засах</button>
      <button type="button" class="btn btn-danger" id="btnDeleteCompany">Устгах</button>
    @elseif (Auth::user()->heseg_id == 5 || Auth::user()->edit == 'on')
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newCompany">Нэмэх</button>
    @endif

  </div>
  @if ($errors->any())
          {{ implode('', $errors->all('<div>:message</div>')) }}
  @endif
  <script src="{{url('public/js/company/company.js')}}"></script>
  <script src="{{url('public/js/work_type/hideShowWorks.js')}}"></script>
  <script src="{{url('public/js/work_type/editHideShowWorks.js')}}"></script>

  @include('company.companyNew')
  @include('company.companyEdit')
</div>


<!-- Datatables -->
    <script src="{{url('public/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{url('public/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{url('public/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{url('public/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{url('public/vendors/pdfmake/build/vfs_fonts.js')}}"></script>


@endsection
