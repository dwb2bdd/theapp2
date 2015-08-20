<!-- This dialog is called after a submission from the preselect screen -->
@extends('app')
@section('content')

<?php  //echo $datavalues; ?>

<!-- test1 = {{ $test1 }}<br>
test2 = {{ $test2 }}<br>
test3 = {{ $test3 }}<br>
test4 = {{ $test4 }}<br>
B19 = {{ $B19 }}<br>
B30 = {{ $B30 }}<br>
B36 = {{ $B36 }}<br>
H19 = {{ $H19 }}<br>
I19 = {{ $I19 }}<br>
I60 = {{ $I60 }}<br>
I61 = {{ $I61 }}<br>
I62 = {{ $I62 }}<br>
I63 = {{ $I63 }}<br>
I64 = {{ $I64 }}<br> -->
<?php  
/*echo '<table width="100%" border="1" cellpadding="2" cellspacing="2">';
  echo '<tbody>';
			echo '<tr>';
				echo '<td>K</td>';
				echo '<td>L</td>';
				echo '<td>M</td>';
				echo '<td>N</td>';
				echo '<td>O</td>';
				echo '<td>P</td>';
				echo '<td>Q</td>';
				echo '<td>R</td>';
				echo '<td>S</td>';
			echo '</tr>';

		foreach ($graphInput2['K'] as $key => $value){
//		echo $value $graphInput[''].= $key.' = '.$value.'<br>';
			echo '<tr>';
				echo '<td>'.$value.'</td>';
				echo '<td>'.$graphInput2['L'][$key].'</td>';
				echo '<td>'.$graphInput2['M'][$key].'</td>';
				echo '<td>'.$graphInput2['N'][$key].'</td>';
				echo '<td>'.$graphInput2['O'][$key].'</td>';
				echo '<td>'.$graphInput2['P'][$key].'</td>';
				echo '<td>'.$graphInput2['Q'][$key].'</td>';
				echo '<td>'.$graphInput2['R'][$key].'</td>';
				echo '<td>'.$graphInput2['S'][$key].'</td>';
			echo '</tr>';
	}
 echo '</tbody>';			
 echo '</table>';	*/

//echo $graphInput['J'][0][0];
/*echo '<table width="100%" border="1" cellpadding="2" cellspacing="2">';
  echo '<tbody>';
			echo '<tr>';
				echo '<td>J</td>';
				echo '<td>K</td>';
				echo '<td>L</td>';
				echo '<td>M</td>';
				echo '<td>N</td>';
				echo '<td>O</td>';
				echo '<td>P</td>';
				echo '<td>Q</td>';
				echo '<td>R</td>';
				echo '<td>S</td>';
			echo '</tr>';

		foreach ($graphInput['J'] as $key => $value){
//		echo $value $graphInput[''].= $key.' = '.$value.'<br>';
			echo '<tr>';
				echo '<td>'.$value.'</td>';
				echo '<td>'.$graphInput['K'][$key].'</td>';
				echo '<td>'.$graphInput['L'][$key].'</td>';
				echo '<td>'.$graphInput['M'][$key].'</td>';
				echo '<td>'.$graphInput['N'][$key].'</td>';
				echo '<td>'.$graphInput['O'][$key].'</td>';
				echo '<td>'.$graphInput['P'][$key].'</td>';
				echo '<td>'.$graphInput['Q'][$key].'</td>';
				echo '<td>'.$graphInput['R'][$key].'</td>';
				echo '<td>'.$graphInput['S'][$key].'</td>';
			echo '</tr>';
	}
 echo '</tbody>';			
 echo '</table>';			
 echo $image1;	
 echo public_path();	*/
?>
<h3>All Sizing Require Company Approval</h3>
<h1>FUL-VANE&trade; ROTARY VANE COMPRESSOR SIZING RESULTS</h1>
<table border="0" align="center" cellpadding="2" cellspacing="2" id="tableOutput3">
  <tr>
    <td width="252"><strong>Calcultions performed by:</strong></td>
    <td width="24">&nbsp;</td>
    <td width="175">{{ $calculations_performed_by }}</td>
  </tr>
  <tr>
    <td><strong>Customer: </strong></td>
    <td>&nbsp;</td>
    <td>{{ $customer }}</td>
  </tr>
  <tr>
    <td><strong>Reference: </strong></td>
    <td>&nbsp;</td>
    <td>{{ $reference }}</td>
  </tr>
</table>
<p>&nbsp;</p>
<table id="tableOutput" cellpadding="2" cellspacing="2" style="background-color:#fff;">
  <tr >
    <td colspan="4" align="center" style="width:60%"><h2>COMPUTER SELECTION</h2></td>
    <td style="width:38%" colspan="2" align="center"><h2>MANUAL SELECTION</h2></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td><strong>COMPRESSOR CYLINDER SIZE</strong></td>
    <td>&nbsp;</td>
    <td>{{ $C65 }}</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >{{ $E65 }}</a></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>GAS NAME</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $B67 }}</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>GAS MOLECULAR WEIGHT</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">{{ $B68 }}</a></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>GAS SPECIFIC GRAVITY</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">{{ $B69 }}</a></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>GAS Cp/Cv (Ratio of specific    heats)</strong></td>
    <td align="right">&nbsp;</td>
    <td align="right">{{ $B70 }}</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>OPERATING SPEED</strong></td>
    <td>RPM</td>
    <td align="right">{{ $C72 }}</td>
    <td>{{ $D72 }}</td>
    <td class="borderLeft"  align="right">{{ $E72 }}</td>
    <td>{{ $F72 }}</td>
  </tr>
  <tr class="outputRow">
    <td align="center"></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>CAPACITY</strong></td>
    <td>ICFM</td>
    <td align="right">{{ $C74 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft"  align="right">{{ $E74 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>SCFM</td>
    <td align="right">{{ $C75 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E75 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>@if ($B76 != ''  ) {{ $B76 }}@endif</td>
    <td align="right">@if ($B76 != ''  ){{ $C76 }}@endif</td>
    <td align="right">&nbsp;</td>
    <td align="right" class="borderLeft" >@if ($B76 != ''  ){{ $E76 }}@endif</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>POWER</strong></td>
    <td>BHP</td>
    <td align="right">{{ $C79 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E79 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>CONSUMPTION</strong></td>
    <td>KW</td>
    <td align="right">{{ $C80 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E80 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>PRODUCT INLET</strong></td>
    <td>DEG F</td>
    <td align="right">{{ $C82 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E82 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>TEMPERATURE</strong></td>
    <td>@if ($B83 != ''  ) {{ $B83 }}@endif&nbsp;</td>
    <td align="right">@if ($B83 != ''  ) {{ $C83 }}@endif</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >@if ($B83 != ''  ) {{ $E83 }}@endif</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>AMBIENT</strong></td>
    <td>PSIA</td>
    <td align="right">{{ $C85 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E85}}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>PRESSURE</strong></td>
	<td>@if ($B86 != ''  ) {{ $B86 }}@endif</td>
	<td align="right">@if ($C86 > 0  ) {{ $C86 }}@endif</td>
	<td>&nbsp;</td>
    <td class="borderLeft" align="right">@if ($E86 > 0 ) {{ $E86 }}@endif</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>PRODUCT INLET</strong></td>
    <td>PSIA</td>
    <td align="right">{{ $C90 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E90 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>PRESSURE</strong></td>
    <td>{{ $B91 }}</td>
    <td align="right">{{ $C91 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E91 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td class="borderLeft" ></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>PRODUCT DISCHARGE</strong></td>
    <td>°F</td>
    <td align="right">{{ $C96 }}</td>
    <td>{{ $D96 }}</td>
    <td class="borderLeft" align="right">{{ $E96 }}</td>
    <td>{{ $F96 }}</td>
  </tr>
  <tr>
    <td align="center"><strong>TEMPERATURE</strong></td>
    <td>@if ($B83 != ''  ) {{ $B97 }}@endif</td>
    <td align="right">@if ($B83 != ''  ) {{ $C97 }}@endif</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >@if ($B83 != ''  ) {{ $E97 }}@endif&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>PRODUCT DISCHARGE</strong></td>
    <td>PSIA</td>
    <td align="right">{{ $C99 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E99 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>PRESSURE</strong></td>
    <td>{{ $B100 }}</td>
    <td align="right">{{ $C100 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E100 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td class="borderLeft" ></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>COMPRESSION RATIO</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C105 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E105 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>PRESSURE</strong></td>
    <td>PSI</td>
    <td align="right">{{ $C107 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E107 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>DIFFERENTIAL</strong></td>
    <td>@if ($B108 != ''  ) {{ $B108 }}@endif</td>
    <td align="right">@if ($B108 != ''  ) {{ $C108 }}@endif</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >@if ($B108 != ''  ) {{ $E108 }}@endif</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>COOLANT INLET</strong></td>
    <td>DEG F</td>
    <td align="right">{{ $C112 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E112 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>TEMPERATURE</strong></td>
    <td align="right">@if ($B113 != ''  ) {{ $B113 }}@endif</td>
    <td align="right">@if ($B113 != ''  ) {{ $C113 }}@endif</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">@if ($B113 != ''  ) {{ $E113 }}@endif</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>WATER FLOWRATE</strong></td>
    <td>GPM</td>
    <td align="right">{{ $C115 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E115 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>GLYCOL FLOWRATE</strong></td>
    <td>GPM</td>
    <td align="right">{{ $C116 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E116 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>{{ $A118 }}</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C118 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E118 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>BLADE STRESS, PSI</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C121 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E121 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>STARTING    TORQUE (@ 8#</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="borderLeft" >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>DISCHARGE) LBS-FT.</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C123 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E123 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>NUMBER OF LUBE FEED POINTS</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C125 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E125 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>LUBE FEED RATE (DROPS/MIN)</strong></td>
    <td></td>
    <td align="right">{{ $C126 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E126 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>LUBE FEED RATE (PINTS/DAY)</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C127 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E127 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr class="outputRow">
    <td align="center"><strong>GAS INLET CONNECTION</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C129 }}</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >{{ $E129 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>GAS DISCHARGE CONNECTION</strong></td>
    <td></td>
    <td align="right">{{ $C130 }}</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >{{ $E130 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>COOLANT INLET CONNECTION</strong></td>
    <td></td>
    <td align="right">{{ $C131 }}</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >{{ $E131 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>COOLANT OUTLET CONNECTION</strong></td>
    <td></td>
    <td align="right">{{ $C132 }}</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >{{ $E132 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>BARE SHAFT CYLINDER WEIGHT</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C133 }}</td>
    <td>LBS.</td>
    <td class="borderLeft" align="right">{{ $E133 }}</td>
    <td>LBS.</td>
  </tr>
  <tr class="outputRow">
    <td align="center"></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
<!--  <tr class="outputRow">
    <td align="center"><strong>AFTERCOOLER SIZE</strong></td>
    <td>&nbsp;</td>
    <td align="right">{{ $C135 }}</td>
    <td>&nbsp;</td>
    <td align="right" class="borderLeft" >{{ $E135 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>MAXIMUM CAPACITY</strong></td>
    <td>CFM</td>
    <td align="right">{{ $C136 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E136 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>WEIGHT</strong></td>
    <td>LBS.</td>
    <td align="right">{{ $C137 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E137 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="outputRow">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>-->
</table>

<hr>
<h2>Performance</h2>
<table border="0" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">FLSmidth Inc. - Pneumatic Transport <br>
      2040 Avenue C <br>
      Bethlehem PA 18017-2188, USA <br>
      Tel. +1 610-264-6011 <br>
      E-mail: fls-pt-info@flsmidth.com <br>
      web site: www.flsmidth.com </td>
      <td valign="top" width="10">&nbsp; </td>
      <td valign="top">
      <table border="1" cellpadding="2" cellspacing="0" id="tableOutput2">
        <tr>
          <td colspan="4"><h3>Compressor Performance</h3></td>
        </tr>
        <tr>
          <td width="42">Size:</td>
          <td width="104">{{ $I58 }}</td>
          <td width="113">Gas:</td>
          <td width="68">{{ $B67 }}</td>
          </tr>
        <tr>
          <td>Speed:</td>
          <td>{{ $E72 }} RPM</td>
          <td>Std. Pressure:</td>
          <td>14.7 psia</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>Std. Temperature:</td>
          <td>60 °F</td>
          </tr>
      </table>
      </td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<?php echo $image1; ?>

<hr>
<h2>Capacity</h2>
<table border="0" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">FLSmidth Inc. - Pneumatic Transport <br>
      2040 Avenue C <br>
      Bethlehem PA 18017-2188, USA <br>
      Tel. +1 610-264-6011 <br>
      E-mail: fls-pt-info@flsmidth.com <br>
      web site: www.flsmidth.com </td>
      <td valign="top" width="10">&nbsp; </td>
      <td valign="top">
      <table border="1" cellpadding="2" cellspacing="0" id="tableOutput2">
        <tr>
          <td colspan="4"><h3>Compressor Capacity</h3></td>
        </tr>
        <tr>
          <td width="42">Size:</td>
          <td width="104">{{ $I58 }}</td>
          <td width="113">Gas:</td>
          <td width="68">{{ $B67 }}</td>
          </tr>
        <tr>
          <td>Pressure:</td>
          <td>{{ $B32 }} {{ $C32 }}</td>
          <td>Std. Pressure:</td>
          <td>14.7 psia</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>Std. Temperature:</td>
          <td>60 °F</td>
          </tr>
      </table>
      </td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<?php echo $image2; ?>

<hr>
<h2>Efficiency</h2>
<table border="0" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">FLSmidth Inc. - Pneumatic Transport <br>
      2040 Avenue C <br>
      Bethlehem PA 18017-2188, USA <br>
      Tel. +1 610-264-6011 <br>
      E-mail: fls-pt-info@flsmidth.com <br>
      web site: www.flsmidth.com </td>
      <td valign="top" width="10">&nbsp; </td>
      <td valign="top">
      <table border="1" cellpadding="2" cellspacing="0" id="tableOutput2">
        <tr>
          <td colspan="4"><h3>Compressor Efficiency</h3></td>
        </tr>
        <tr>
          <td width="42">Size:</td>
          <td width="104">{{ $I58 }}</td>
          <td width="113">Gas:</td>
          <td width="68">{{ $B67 }}</td>
          </tr>
        <tr>
          <td>Speed:</td>
          <td>{{ $E72 }} RPM</td>
          <td>Std. Pressure:</td>
          <td>14.7 psia</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>Std. Temperature:</td>
          <td>60 °F</td>
          </tr>
      </table>
      </td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<?php echo $image3; ?>


@stop