<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Output</title>
<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

<style>
body{
	background-color: #fff;	
	margin:0;
	padding:0;
	width:100%;
	text-align:left;
	font: 12px/1.2em "Roboto",sans-serif;
	font-family: 'Roboto', sans-serif;
	color:#333;
}

#tableOutput
	td{
		padding:0 10px;
	}
#tableOutput

	td.borderLeft{
		border-left:1px solid #ddd;
	}
#tableOutput

	tr.outputRow{
		border-top:1px solid #ddd;
	}
	
#tableOutput

	tr.outputRow 
		td{
			padding-top:2px;
			padding-bottom:2px;
		}

</style>
</head>
<body>
<h3>All Sizing Require Company Approval</h3>
<h1>FUL-VANE&trade; ROTARY VANE COMPRESSOR SIZING RESULTS</h1>
<table id="tableOutput" cellpadding="2" cellspacing="2" style="background-color:#fff;page-break-after:always;">
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
    <td align="center"><strong>AT</strong></td>
    <td>SCFM</td>
    <td align="right">{{ $C75 }}</td>
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E75 }}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>INLET</strong></td>
    <td>{{ $B76 }}</td>
    <td align="right">{{ $C76 }}</td>
    <td align="right">&nbsp;</td>
    <td align="right" class="borderLeft" >{{ $E76 }}</td>
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
    <td align="center"><strong>(Gauge Pressures)</strong></td>
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
    <td>&nbsp;</td>
    <td class="borderLeft" align="right">{{ $E96 }}</td>
    <td>&nbsp;</td>
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
    <td align="center"><strong>(Gauge Pressures)</strong></td>
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

<img src="{{ $image1 }}" />

<hr style="page-break-after:always;" >
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
<img src="{{ $image2 }}"/>

<hr style="page-break-after:always;" >
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
<img src="{{ $image3 }}"/>

</body>
</html>