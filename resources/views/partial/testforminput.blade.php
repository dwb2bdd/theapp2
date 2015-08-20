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
    <td>{{ $sizing->label_pressure_or_elevation }}: </td>
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
    <td>Enter manual selection:</td>
    <td>
      {!! Form::select('speed_fixed_or_not', array('0' => 'Speed To be Determined', 'Fixed' => 'Yes'),null, array('id'=>'speed_fixed_or_not')) !!}
    </td>
    <td>(CXX, BXX, CCxx, CBXX)</td>
  </tr>

  <tr>
    <td>COOLANT INLET TEMPERATURE:</td>
    <td>
        {!! Form::text('coolant_inlet_temperature',  null  ,array('id' => 'coolant_inlet_temperature', 'readonly'=>'readonly', 'class'=>'calculatedOutput')) !!}
    </td>
    <td></td>
  </tr>  

</table>

<hr>
<input type="submit" name="submit" id="submit" value="Show Output"  formtarget="_blank" class="btn btn-primary">
<input type="submit" name="submit2" id="submit2" value="Show Outputin HTML"  formtarget="_blank" class="btn btn-primary">
<input type="button" name="saveSizing" id="saveSizing" value="Save Sizing" class="btn btn-success">