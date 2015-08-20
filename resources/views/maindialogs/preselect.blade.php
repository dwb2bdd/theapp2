@extends('app')

@section('content')

<script type="text/javascript">
        $(document).ready(function() {
        	$.fn.resetEverything = function(){
        		$("#mainPanelRight").hide();
        		$("#ambient_pressure_fieldset").hide();
        		$("#elevation_unit_fieldset").hide();
        		$("#compressor_capacity_panel").hide();
        		$("#volumetric_flowrate").hide();
        		$("#mass_flowrate").hide();
        		$("#volumetric_fieldset").hide();
        		$("#mass_flowrate_fieldset").hide();
        		$("#known_ambient_pressure").prop('disabled', false);
        		$("#known_elevation").prop('disabled', false);
        		$("#volumetric_flowrate").prop('disabled', false);
        		$("#mass_flowrate").prop('disabled', false);
        		
        		return false;		
            }	
        	
        	$.fn.resetEverything();
        	
        	$("#known_ambient_pressure").click(function() {
        		$("#ambient_pressure_fieldset").show();
        		$("#compressor_capacity_panel").show();
        		$("#known_elevation").prop('disabled', true);
        		$("#volumetric_flowrate").show();
        		$("#mass_flowrate").show();
                $("#ambient_pressure_or_elevation").val('ambient_pressure_pressed');
        	});
        	
        	$("#volumetric_flowrate").click(function() {
        		$("#mainPanelRight").show();
        		$("#volumetric_fieldset").show();
        		$("#mass_flowrate").prop('disabled', true);
                $("#volumetric_or_mass").val('volumetric_pressed');
        	});	
        	
        	$("#known_elevation").click(function() {
        		$("#elevation_unit_fieldset").show();
        		$("#compressor_capacity_panel").show();
        		$("#known_ambient_pressure").prop('disabled', true);
        		$("#volumetric_flowrate").show();
        		$("#mass_flowrate").show();
                $("#ambient_pressure_or_elevation").val('elevation_pressed');
        	});
        	
        	$("#mass_flowrate").click(function() {
        		$("#mainPanelRight").show();
        		$("#mass_flowrate_fieldset").show();
        		$("#volumetric_flowrate").prop('disabled', true);
                $("#volumetric_or_mass").val('mass_pressed');
        	});		
        	
        	$("#reset2").click(function() {
        		$.fn.resetEverything();
        	});
        	
        	$("input[name=product_inlet_temperature_unit]").change(function() {
        		$("input[name=coolant_inlet_temperature_unit][value="+$("input[name=product_inlet_temperature_unit]:checked").val()+"]").prop('checked',true);
        	});
        	
        	$("input[name=inlet_pressure_unit]").change(function() {
        		$("input[name=discharge_pressure_unit][value="+$("input[name=inlet_pressure_unit]:checked").val()+"]").prop('checked',true);
        	});
        	
        }); 
</script>	

<h1>Pre-select units, gas type, and if the product is saturated.</h1>

{!! Form::open(array('url' => 'mainPanelFormSubmitted', 'id' => 'mainPanelForm', 'name' => 'mainPanelForm')) !!}
<!-- <form id ="mainPanelForm" name ="mainPanelForm" action="test">
 -->
<div id="mainPanelLeft">
    <h2>Ambient Pressure:</h2>
    <button class="btn btn-default" type="button" name="known_ambient_pressure" id="known_ambient_pressure">Known Ambient Pressure</button>
    <button class="btn btn-default" type="button" name="known_elevation" id="known_elevation">Known Elevation</button>
    <hr>

    <input type="hidden" name="ambient_pressure_or_elevation" id="ambient_pressure_or_elevation" value="" >
    
    <fieldset id="ambient_pressure_fieldset">
      <legend>Select Ambient Pressure Units:</legend>&nbsp;
        <input name="ambient_pressure_unit" type="radio" value="psia" checked="checked">psia&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="HGa">HGa&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="H2Oa">H2Oa&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="mmHGa">mmHGa&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="kgcm2a">kg/cm2a
        <br>&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="mmH2Oa">mmH2Oa&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="BARa">BARa&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="mBARa">mBARa&nbsp;
        <input type="radio" name="ambient_pressure_unit" value="kPAa">kPAa
    </fieldset>

    <fieldset id="elevation_unit_fieldset">
      <legend>Select Elevation Units:</legend>&nbsp;
        <input name="elevation_unit" type="radio" value="ft" checked="checked">ft&nbsp;
        <input type="radio" name="elevation_unit" value="m">m
    </fieldset>
    
    <table width="100%" border="0" id="compressor_capacity_panel">
      <tbody>
        <tr>
          <td><h2>Compressor Capacity (Flowrate):</h2></td>
          <td><input type="checkbox" name="saturatee" value="saturatee">Saturated Product</td>
        </tr>
      </tbody>
    </table>

    <button class="btn btn-default" type="button" name="volumetric_flowrate" id="volumetric_flowrate">Volumetric Flowrate</button>
    <button class="btn btn-default" type="button" name="mass_flowrate" id="mass_flowrate">Mass Flowrate</button>
    
    <fieldset id="volumetric_fieldset">
      <legend>Select Volumetric Flowrate Units:</legend>&nbsp;
        <input name="volumetric_flowrate_unit" type="radio" value="scfm" checked="checked">scfm&nbsp;
        <input type="radio" name="volumetric_flowrate_unit" value="scfd">scfd&nbsp;
        <input type="radio" name="volumetric_flowrate_unit" value="mscfd">mscfd
        <br>&nbsp;
        <input type="radio" name="volumetric_flowrate_unit" value="mmscfd">mmscfd&nbsp;
        <input type="radio" name="volumetric_flowrate_unit" value="Sm3min">Sm3/min&nbsp;
        <input type="radio" name="volumetric_flowrate_unit" value="icfm">icfm
    </fieldset>
          
    <fieldset id="mass_flowrate_fieldset">
      <legend>Select Mass Flowrate Units:</legend>&nbsp;
        <input name="mass_flowrate_unit" type="radio" value="lbhr" checked="checked">lb/hr&nbsp;
        <input type="radio" name="mass_flowrate_unit" value="lbmin">lb/min
        <br>&nbsp;
        <input type="radio" name="mass_flowrate_unit" value="kghr">kg/hr&nbsp;
        <input type="radio" name="mass_flowrate_unit" value="kgmin">kg/min
    </fieldset>
    <input type="hidden" name="volumetric_or_mass" id="volumetric_or_mass" value="" >
	<hr>          
	<button class="btn btn-default" type="button" name="reset2" id="reset2">Reset</button>          
</div>


<div id="mainPanelRight">
    <table width="100%" border="0">
        <tbody>
          <tr>
            <td valign="top"><h2>Product Data:</h2></td>
            <td width="50%" valign="top"><h2>Product Inlet Temperature:</h2></td>
          </tr>
          <tr>
            <td valign="top"><fieldset>
              <legend>Select Product Type:</legend>
              <input name="product_type" type="radio" value="Air" checked="checked">
              Air
              <input type="radio" name="product_type" value="Other Gas">
              Other Gas
            </fieldset></td>
            <td valign="top"><fieldset>
              <legend>Select Inlet Temp. Units:</legend>
              <input name="product_inlet_temperature_unit" type="radio" value="F" checked="checked">&deg;F
              <input type="radio" name="product_inlet_temperature_unit" value="C">&deg;C
            </fieldset></td>
          </tr>
        </tbody>
    </table>
    
    <h2>Coolant Inlet Temperature:</h2>
    <fieldset>
      <legend>Select Inlet Temp.Units:</legend>
      <input name="coolant_inlet_temperature_unit" type="radio" value="F" checked="checked">F&deg;
      <input type="radio" name="coolant_inlet_temperature_unit" value="C">&deg;C
    </fieldset>
    
    <h2>Inlet Pressure:</h2>
    <fieldset>
    <legend>Select Inlet Pressure Units:</legend>&nbsp;
        <input name="inlet_pressure_unit" type="radio" value="psig" checked="checked">psig&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="HGg">&quot;HGg&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="H2Og">&quot;H2Og&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="mmHGh">mmHGh&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="kgcm2g">kg/cm2g <br>&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="psia">psia&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="mmH2Og">mmH2Og&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="BARg">BARg&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="mBARg">mBARg&nbsp;
        <input type="radio" name="inlet_pressure_unit" value="kPAg">kPAg
    </fieldset>
          
    <h2>Discharge Pressure:</h2>
    <fieldset>
        <legend>Select Discharge Pressure Units:</legend>&nbsp;
        <input name="discharge_pressure_unit" type="radio" value="psig" checked="checked">psig&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="HGg">&quot;HGg&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="H2Og">&quot;H2Og&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="mmHGh">mmHGh&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="kgcm2g">kg/cm2g <br>&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="psia">psia&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="mmH2Og">mmH2Og&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="BARg">BARg&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="mBARg">mBARg&nbsp;
        <input type="radio" name="discharge_pressure_unit" value="kPAg">kPAg
    </fieldset>
    
    <button class="btn btn-default" type="button" name="cancel" id="cancel">Cancel</button>
    <button class="btn btn-default" type="submit" name="ok" id="ok">Ok</button>          
</div>

<hr>

{!! Form::close() !!}

@stop