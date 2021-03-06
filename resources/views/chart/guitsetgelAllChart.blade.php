@extends('layouts.layout_main')
@section('content')

  <div class="clearfix"></div>
  <div class="row">
    <script>
      $(document).ready(function(){
          $("#cmbCompany").change(function(){
            $("#cmbWorkType").css("display","block");
          });
      });
    </script>
    <script>
      $(document).ready(function(){
          $("#cmbHeseg").change(function(){
              $("#cmbWorkType").css("display","none");
              window.location.href = "{{url('/chart/all')}}";
          });
      });
    </script>
    <div class="col-md-4">
      <label>Аж ахуйн нэгж</label>
      <select class="form-control" id="cmbHeseg">
        @php
          echo '<option value="0">Сонгоно уу</option>';
            switch (Auth::user()->heseg_id) {
              case 1:
                echo '<option value="1" >Зүүнбаян чиглэл I хэсэг</option>';
                if(Auth::user()->heseg_id == 1)
                  echo '<option value="1" selected>Зүүнбаян чиглэл I хэсэг</option>';
                break;
              case 2:
                echo '<option value="2">Мандах чиглэл II хэсэг</option>';
                if(Auth::user()->heseg_id == 2)
                  echo '<option value="2" selected>Мандах чиглэл II хэсэг</option>';
                break;
              case 3:
                echo '<option value="3">Цогтцэций чиглэл III чиглэл</option>';
                if(Auth::user()->heseg_id == 3)
                  echo '<option value="3" selected>Цогтцэций чиглэл III чиглэл</option>';
                break;

              default:
                if(Auth::user()->heseg_id == 1)
                  echo '<option value="1" selected>Зүүнбаян чиглэл I хэсэг</option>';
                else
                  echo '<option value="1">Зүүнбаян чиглэл I хэсэг</option>';

                if(Auth::user()->heseg_id == 2)
                  echo '<option value="2" selected>Мандах чиглэл II хэсэг</option>';
                else
                  echo '<option value="2">Мандах чиглэл II хэсэг</option>';

                if(Auth::user()->heseg_id == 3)
                  echo '<option value="3" selected>Цогтцэций чиглэл III чиглэл</option>';
                else
                  echo '<option value="3">Цогтцэций чиглэл III чиглэл</option>';

                if($hesegID > 3)
                  echo '<option value="4" selected>Бүх аж ахуйн нэгжээр</option>';
                else {
                  echo '<option value="4">Бүх аж ахуйн нэгжээр</option>';
                }
                break;
            }
        @endphp
      </select>
    </div>
    <div class="col-md-4">
      <label>Аж ахуйн нэгж</label>
      <select class="form-control" id="cmbCompany">
        <option value="0">Сонгоно уу</option>
        @foreach ($companies as $company)
            <option value="{{$company->id}}">{{$company->companyName}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4" style="display: none;">
      <label>Хийгдэж буй ажлын төрлөөр харах</label>
      <select class="form-control" id="cmbWorkType">
        <option value="0">Сонгоно уу</option>
        @php
          $workTypes = App\Http\Controllers\WorktypeController::getCompactWorkType();
        @endphp

        @foreach ($workTypes as $workType)
            <option value="{{$workType->id}}">{{$workType->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="clearfix"></div>

<script>
window.onload = function () {

    //Better to construct options first and then pass it as a parameter
    var options = {
    	animationEnabled: true,
    	theme: "light1", //"light1", "dark1", "dark2"
    	title:{
    		text: "Аж ахуйн нэгжүүдийн гүйцэтгэл"
    	},
    	axisY:{
    		interval: 10,
    		suffix: "%"
    	},
    	toolTip:{
    		shared: true
    	},
    	data:[{
    		type: "stackedColumn100",
    		toolTipContent: "{label}<br><b>{name}:</b> {y} (#percent%)",
    		showInLegend: true,
    		name: "Гүйцэтгэл",
    		dataPoints: [
          @foreach ($companies as $company)
            @php
              $dundaj = App\Http\Controllers\GuitsetgelController::getGuitsetgelHuvi($company->id);
            @endphp
            { y: {{ $dundaj}}, label: "{{$company->companyName}}" },
          @endforeach
    		]
    	},
    	{
    		type: "stackedColumn100",
    		toolTipContent: "<b>{name}:</b> {y} (#percent%)",
    		showInLegend: true,
    		name: "Үлдсэн ажил",
    		dataPoints: [
          @foreach ($companies as $company)
            @php
              $dundaj = App\Http\Controllers\GuitsetgelController::getGuitsetgelHuvi($company->id);
            @endphp
            { y: {{100 - $dundaj}}, label: "{{$company->companyName}}" },
          @endforeach
    		]
    	}]
    };

    $("#chartContainer").CanvasJSChart(options);
}
</script>

  <div id="chartContainer" style="height: 570px; max-width: 4050px; margin: 0px auto;"></div>

{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
@endsection
