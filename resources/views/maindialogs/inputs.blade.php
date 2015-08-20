<!-- This dialog is called after a submission from the preselect screen -->

@extends('app')

@section('content')
<script type="text/javascript">
$(document).ready(function() {

	$("#goToMainDialog").click(function() {
		window.location.href = "/compressor";
	}); 
	
	$("#saveSizing").click(function() {
		var form_data = $("#mainPanelForm").serialize();
		$.ajax({
		  url: "saveSizing",
		  type: 'post',
		  data: form_data,
		  success: function(msg) {
	 		  var data = msg.split(';');
  			alert(msg);
		  },
		  error:function (xhr, ajaxOptions, thrownError){
  			alert(xhr.status);
  			alert(thrownError);
		  }  
		});
		return false;
	}); 	

  $("#coolant_temperature").change(function() {
    var form_data = $("#mainPanelForm").serialize();
    $.ajax({
      url: "coolantTemperatureChanged",
      type: 'post',
      data: form_data,
      success: function(msg) {
        var data = msg.split(';');
        $('#coolant_inlet_temperature').val(data[0]);
      },
      error:function (xhr, ajaxOptions, thrownError){
        alert(xhr.status);
        alert(thrownError);
      }  
    });
    return false;
  });

  $("#flowrate").change(function() {
    var form_data = $("#mainPanelForm").serialize();
    $.ajax({
      url: "flowrateChanged",
      type: 'post',
      data: form_data,
      success: function(msg) {
        var data = msg.split(';');
        $('#compressor_flow_capacity').val(data[0]);
      },
      error:function (xhr, ajaxOptions, thrownError){
        alert(xhr.status);
        alert(thrownError);
      }  
    });
    return false;
  });

  $("#gas_discharge_pressure").change(function() {
    var form_data = $("#mainPanelForm").serialize();
    $.ajax({
      url: "gasDischargePressureChanged",
      type: 'post',
      data: form_data,
      success: function(msg) {
        var data = msg.split(';');
        $('#discharge_pressure').val(data[0]);
        $('#compression_ratio').val(data[1]);
      },
      error:function (xhr, ajaxOptions, thrownError){
        alert(xhr.status);
        alert(thrownError);
      }  
    });
    return false;
  });

  $("#gas_inlet_pressure").change(function() {
    var form_data = $("#mainPanelForm").serialize();
    $.ajax({
      url: "gasInletPressureChanged",
      type: 'post',
      data: form_data,
      success: function(msg) {
        var data = msg.split(';');
        $('#inlet_pressure').val(data[0]);
		$('#B30_raw').val(data[0]);
        $('#compression_ratio').val(data[1]);
        $('#compressor_flow_capacity').val(data[2]);
      },
      error:function (xhr, ajaxOptions, thrownError){
        alert(xhr.status);
        alert(thrownError);
      }  
    });
    return false;
  });      

  $("#gas_inlet_temperature").change(function() {
    var form_data = $("#mainPanelForm").serialize();
    $.ajax({
      url: "gasInletTemperatureChanged",
      type: 'post',
      data: form_data,
      success: function(msg) {
        var data = msg.split(';');
        $('#inlet_temperature').val(data[0]);
        $('#compressor_flow_capacity').val(data[1]);
      },
      error:function (xhr, ajaxOptions, thrownError){
        alert(xhr.status);
        alert(thrownError);
      }  
    });
    return false;
  });   

	$("#elevation").change(function() {
		var form_data = $("#mainPanelForm").serialize();
		$.ajax({
			url: "elevationChanged",
			type: 'post',
			data: form_data,
			success: function(msg) {
        var data = msg.split(';');
        $('#ambient_pressure').val(data[0]);
        $('#inlet_pressure').val(data[1]);
        $('#B30_raw').val(data[1]);
        $('#discharge_pressure').val(data[2]);
        $('#compression_ratio').val(data[3]);
        $('#compressor_flow_capacity').val(data[4]);
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
			}
		});
		return false;
	});

}); 
</script>   


{!! Form::open(array('url' => 'inputFormSubmitted', 'id' => 'mainPanelForm', 'name' => 'mainPanelForm', 'target' => '_blank')) !!}

{{-- $inputs --}}
<h1>DATA INPUT SECTION:</h1>
  @include('partial/forminput')
{!! Form::close() !!}

@stop