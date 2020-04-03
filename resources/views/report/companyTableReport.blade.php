@extends('layouts.layout_main')

@section('content')
  <script>
  // requires jquery library
  jQuery(document).ready(function() {
     jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
   });

  </script>
  <style>
  .table-scroll {
    position:relative;
    max-width:100%;
    margin:auto;
    overflow:hidden;
    border:1px solid #000;
    }
    .table-wrap {
    width:100%;
    overflow:auto;
    }
    .table-scroll table {
    width:100%;
    margin:auto;
    border-collapse:separate;
    border-spacing:0;
    }
    .table-scroll th, .table-scroll td {
    padding:5px 10px;
    border:1px solid #000;
    background:#fff;
    white-space:nowrap;
    vertical-align:top;
    }
    .table-scroll thead, .table-scroll tfoot {
    background:#f9f9f9;
    }
    .clone {
    position:absolute;
    top:0;
    left:0;
    pointer-events:none;
    }
    .clone th, .clone td {
    visibility:hidden
    }
    .clone td, .clone th {
    border-color:transparent
    }
    .clone tbody th {
    visibility:visible;
    color:red;
    }
    .clone .fixed-side {
    border:1px solid #000;
    background:#eee;
    visibility:visible;
    }
    .clone thead, .clone tfoot{background:transparent;}
  </style>
@endsection
