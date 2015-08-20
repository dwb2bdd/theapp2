<table border="0" cellpadding="2" cellspacing="2" id="tableInputSection">
  <tr>
    <th>&nbsp;</th>
    <th><input type="button" name="goToMainDialog" id="goToMainDialog" value="Show Main Dialog Box" class="btn btn-danger"><!--<input type="reset" name="reset" id="reset" value="Reset">--></th>
    <th><!--<input type="submit" name="submit" id="submit" value="Show Output in HTML">--></th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Calcultions performed by:</td>
    <td>
      {!! Form::text('calculations_performed_by', null ,array('id' => 'calculations_performed_by')) !!}
    </td>
    <td></td>
  </tr>
  <tr>
    <td>Customer: </td>
    <td>
      {!! Form::text('customer', null ,array('id' => 'customer')) !!}
    </td>
    <td></td>
  </tr>
  <tr>
    <td>Reference: </td>
    <td>
      {!! Form::text('reference', null ,array('id' => 'reference')) !!}
    </td>
    <td></td>
  </tr>

  <tr>
    <td colspan="3"><h2>AMBIENT PRESSURE:</h2></td>
  </tr>

  <tr>
    <td>{{ $label_pressure_or_elevation }}:
        {!! Form::hidden('label_pressure_or_elevation', $label_pressure_or_elevation ,array('id' => 'label_pressure_or_elevation')) !!}
        {!! Form::hidden('ambient_pressure_or_elevation', $ambient_pressure_or_elevation ,array('id' => 'ambient_pressure_or_elevation')) !!}
        {!! Form::hidden('volumetric_or_mass', $volumetric_or_mass ,array('id' => 'volumetric_or_mass')) !!}
        {!! Form::hidden('volumetric_flowrate_unit', $volumetric_flowrate_unit ,array('id' => 'volumetric_flowrate_unit')) !!}
        {!! Form::hidden('mass_flowrate_unit', $mass_flowrate_unit ,array('id' => 'mass_flowrate_unit')) !!}
        {!! Form::hidden('product_inlet_temperature_unit', $product_inlet_temperature_unit ,array('id' => 'product_inlet_temperature_unit')) !!}
        {!! Form::hidden('coolant_inlet_temperature_unit', $coolant_inlet_temperature_unit ,array('id' => 'coolant_inlet_temperature_unit')) !!}

        {!! Form::hidden('inlet_pressure_unit', $inlet_pressure_unit ,array('id' => 'inlet_pressure_unit')) !!}
        {!! Form::hidden('discharge_pressure_unit', $discharge_pressure_unit ,array('id' => 'discharge_pressure_unit')) !!}

        {!! Form::hidden('B17', $B17 ,array('id' => 'B17')) !!}
        {!! Form::hidden('B30_raw', $B30_raw ,array('id' => 'B30_raw')) !!}

        {!! Form::hidden('B86', $B86 ,array('id' => 'B86')) !!}
        {!! Form::hidden('C86', $C86 ,array('id' => 'C86')) !!}
        {!! Form::hidden('E86', $E86 ,array('id' => 'E86')) !!}
        {!! Form::hidden('A118', $A118 ,array('id' => 'A118')) !!}
        {!! Form::hidden('L3', $L3_3_12 ,array('id' => 'L3')) !!}
        {!! Form::hidden('M3', $M3 ,array('id' => 'M3')) !!}
    </td>
    <td>
      {!! Form::text('elevation',  $B11  ,array('id' => 'elevation')) !!}
    <td>{{ $label_pressure_or_elevation_unit }}
      {!! Form::hidden('label_pressure_or_elevation_unit', $label_pressure_or_elevation_unit ,array('id' => 'label_pressure_or_elevation_unit')) !!}
    </td>
  </tr>
  <tr>
    <td>AMBIENT PRESSURE:</td>
    <td>
      {!! Form::text('ambient_pressure',  $B13  ,array('id' => 'ambient_pressure', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
      {!! Form::hidden('ambient_pressure_unit', $ambient_pressure_unit ,array('id' => 'ambient_pressure_unit')) !!}
    </td>
    <td>PSIA</td>
  </tr>
  <tr>
    <td colspan="3"><h2>PRODUCT DATA:</h2></td>
  </tr>

  <tr>
    <td>{{ $label_product_type }}:
      {!! Form::hidden('label_product_type', $label_product_type ,array('id' => 'label_product_type')) !!}
    </td>
    <td>
      {!! Form::text('name_of_gas',  $B16  ,array('id' => 'name_of_gas')) !!}
    </td>
    <td></td>
  </tr>
  <tr>
    <td>Molecular Weight:</td>
    <td>
      {!! Form::text('molecular_weight',  $B17  ,array('id' => 'molecular_weight')) !!}
    </td>
    <td></td>
  </tr>
  <tr>
    <td>Specific Gravity:</td>
    <td>
      {!! Form::text('specific_gravity',  $B18  ,array('id' => 'specific_gravity')) !!}
    </td>
    <td></td>
  </tr>
  <tr>
    <td>Cp/Cv:</td>
    <td>
      {!! Form::text('cp_cv',  $B19  ,array('id' => 'cp_cv')) !!}
    </td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3"><h2>PRODUCT INLET TEMPERATURE:</h2></td>
  </tr>
  <tr>
    <td>Gas Inlet Temperature:</td>
    <td>
      {!! Form::text('gas_inlet_temperature',  $B21  ,array('id' => 'gas_inlet_temperature')) !!}
    </td>
    <td>{{ $label_gas_inlet_temperature }}
      {!! Form::hidden('label_gas_inlet_temperature', $label_gas_inlet_temperature ,array('id' => 'label_gas_inlet_temperature')) !!}
    </td>
  </tr>

  <tr>
    <td>INLET TEMPERATURE:</td>
    <td>
      @if (! empty($editMode) )
      {!! Form::text('inlet_temperature',  null  ,array('id' => 'inlet_temperature', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
      @else
      {!! Form::text('inlet_temperature',  $B23  ,array('id' => 'inlet_temperature', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
      @endif      
      {!! Form::hidden('B23', $B23 ,array('id' => 'B23')) !!}
    </td>
    <td>{{ $label_gas_inlet_temperature }}</td>
  </tr>

  <tr>
    <td><h2>INLET PRESSURE:</h2></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Gas Inlet Pressure (Pi):</td>
    <td>
      {!! Form::text('gas_inlet_pressure',  $B27  ,array('id' => 'gas_inlet_pressure')) !!}
    </td>
    <td>{{ $label_inlet_pressure_unit }}
      {!! Form::hidden('label_inlet_pressure_unit', $label_inlet_pressure_unit ,array('id' => 'label_inlet_pressure_unit')) !!}
    </td>
  </tr>
  <tr>
    <td>INLET PRESSURE (Pi):</td>
    <td>
      @if (! empty($editMode) )
      {!! Form::text('inlet_pressure',  null  ,array('id' => 'inlet_pressure', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
      @else
      {!! Form::text('inlet_pressure',  $B30  ,array('id' => 'inlet_pressure', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
      @endif      
      {!! Form::hidden('B30', $B30 ,array('id' => 'B30')) !!}
    <td>PSIA</td>
  </tr>
  <tr>
    <td colspan="3"><h2>DISCHARGE PRESSURE:</h2></td>
  </tr>
  <tr>
    <td>Gas Discharge Pressure    (Pd):</td>
    <td>
      {!! Form::text('gas_discharge_pressure',  $B32  ,array('id' => 'gas_discharge_pressure')) !!}
    </td>
    <td>{{ $label_discharge_pressure_unit }}
            {!! Form::hidden('label_discharge_pressure_unit', $label_discharge_pressure_unit ,array('id' => 'label_discharge_pressure_unit')) !!}
  </tr>
  <tr>
    <td>DISCHARGE PRESSURE (Pd):</td>
    <td>
      {!! Form::text('discharge_pressure',  $B35  ,array('id' => 'discharge_pressure', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
      </td>
    <td>PSIA</td>
  </tr>
  <tr>
    <td>COMPRESSION RATIO (Pd/Pi):</td>
    <td>
      {!! Form::text('compression_ratio',  $B36  ,array('id' => 'compression_ratio', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
    </td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3"><h2>COMPRESSOR CAPACITY    (flowrate):</h2></td>
  </tr>
  <tr>
    <td>Flowrate:</td>
    <td>
      {!! Form::text('flowrate',  $B39  ,array('id' => 'flowrate')) !!}
    </td>
    <td>{{ $label_volumetric_or_mass }}
        {!! Form::hidden('label_volumetric_or_mass', $label_volumetric_or_mass ,array('id' => 'label_volumetric_or_mass')) !!}
    </td>
  </tr>

@if ($B41 > 0 )
  <tr>
    <td>Partial pressure of vapor:</td>
    <td>
      {!! Form::text('partial_pressure',  $B41  ,array('id' => 'partial_pressure', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
    </td>
    <td>psi</td>
  </tr>  
@endif
  <tr>
    <td>COMPRESSOR FLOW CAPACITY:</td>
    <td>
      {!! Form::text('compressor_flow_capacity',  $B42  ,array('id' => 'compressor_flow_capacity', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
    </td>
    <td>ICFM</td>
  </tr>
  <tr>
    <td colspan="3"><h2>COOLANT INLET TEMPERATURE:</h2></td>
  </tr>
  <tr>
    <td>Coolant Temperature:</td>
    <td>
      {!! Form::text('coolant_temperature',  $B44  ,array('id' => 'coolant_temperature')) !!}
    </td>
    <td>{{ $label_coolant_temperature }}
        {!! Form::hidden('label_coolant_temperature', $label_coolant_temperature ,array('id' => 'label_coolant_temperature')) !!}
    </td>
  </tr>

  <tr>
    <td>COOLANT INLET TEMPERATURE:</td>
    <td>
        {!! Form::text('coolant_inlet_temperature',  $B46  ,array('id' => 'coolant_inlet_temperature', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
    </td>
    <td>{{ $label_coolant_temperature }}</td>
  </tr>
  <tr>
    <td colspan="3"><h2>BOOSTER SELECT:</h2></td>
  </tr>
  <tr>
    <td>Do you wish to select a Booster?</td>
    <td>
      @if (! empty($editMode) )
      {!! Form::select('booster_select', array('0' => 'No', '1' => 'Yes'),null, array('id'=>'booster_select')) !!}
      @else
      {!! Form::select('booster_select', array('0' => 'No', '1' => 'Yes'),'0', array('id'=>'booster_select')) !!}
      @endif
    </td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3"><h2>MANUAL SIZE SELECTION:</h2></td>
  </tr>
  <tr>
    <td>Enter manual selection:</td>
    <td>@if (! empty($editMode) )
      {!! Form::select('manual_selection', $available_sizes, null, array('id'=>'manual_selection')) !!}
      @else
      {!! Form::select('manual_selection', $available_sizes, 'C400', array('id'=>'manual_selection')) !!}
      @endif
    </td>
    <td>(CXX, BXX, CCxx, CBXX)</td>
  </tr>
  <tr>
    <td>Is speed Fixed?</td>
    <td>
      {!! Form::select('speed_fixed_or_not', array('0' => 'Speed To be Determined', 'Fixed' => 'Yes')) !!}
    </td>
    <td>(Fixed, Speed to be Determined)</td>
  </tr>
  <tr>
    <td>Fixed Speed:</td>
    <td>
      {!! Form::text('fixed_speed',  null  ,array('id' => 'fixed_speed')) !!}
    </td>
    <td>RPM</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<hr>
<input type="submit" name="submit" id="submit" value="Show Output"  formtarget="_blank" class="btn btn-primary">
<input type="submit" name="submit2" id="submit2" value="Show Outputin HTML"  formtarget="_blank" class="btn btn-primary">
<input type="button" name="saveSizing" id="saveSizing" value="Save Sizing" class="btn btn-success">