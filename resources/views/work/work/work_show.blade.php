@extends('layouts.layout_main')
@section('content')
  <!-- Datatables -->
      <link href="{{url('public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{url('public/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">


  <script type="text/javascript">
    var getWorkTypeUr = "{{url('/work/get')}}";
    var newWorkTypeUrl = "{{url("/work/store")}}";
    var updateWorkTypeUrl = "{{url("/work/update")}}";
    var deleteWorkTypeUrl = "{{url("/work/delete")}}";

    var csrf = "{{csrf_token()}}"
  </script>
  <script src="{{url('/public/js/work_type/work.js')}}"></script>

  <h2 style="text-align:center;"><strong>Хийх ажлууд</strong></h2>
  <div class="row">
      <table id="datatable_workType" class="table table-striped table-bordered" style="width:100%;">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Ажлын төрөл</th>
                  <th></th>
                  <th>Нэр</th>
                  <th>Хэмжих нэгж</th>
              </tr>
          </thead>
      </table>

  </div>
  <div calss="row">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newWorkTypeModal">Нэмэх</button>
    <button type="button" class="btn btn-warning" id="btnEditWorkType">Засах</button>
    <button type="button" class="btn btn-danger" id="btnDeleteWorkType">Устгах</button>
  </div>
  @include('work.work.work_add')
  @include('work.work.work_edit')
  {{-- @include('guitsetgel.guitsetgelEdit') --}}
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
