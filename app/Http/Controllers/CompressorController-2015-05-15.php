<?php namespace App\Http\Controllers;

class CompressorController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Compressor Controller
	|--------------------------------------------------------------------------
	|
	*/
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index(){
		return view('maindialogs/preselect');
	}

///*********AJAX CALLS************///

	public function coolantTemperatureChanged(){
		$inputs = \Request::input();
		$data = array();
		$data['K3'] = 1;
		if ($inputs['coolant_inlet_temperature_unit'] == 'C'){
			$data['K3'] = 0;
		}

		$tdata =  $this->getB46($inputs, $data);
		echo $tdata['B46'].';';
	}

	public function flowrateChanged(){
		$inputs = \Request::input();
		$data = array();
		$data['H2'] = $this->getH2($inputs);
		$data['H3'] = $this->getH3($inputs);

      	$data['B27'] = $inputs ['gas_inlet_pressure'];
      	$data['B32'] = $inputs ['gas_discharge_pressure'];

		//B13=IF(H3=1,B11,(B11*3.2808))
		$data['I7'] = $inputs['elevation']*3.2808;
		if ($data['H3']==1)
			$data['I7'] = $inputs['elevation'];

		if ($data['H2'] == 1){
			$data['B13'] = (14.68683)+(($data['I7'])*(-0.0005299248))+((pow($data['I7'],2))*(0.0000000072))+((pow($data['I7'],3))*(3.621858E-14))+((pow($data['I7'],4))*(-3.859745E-18));
		}else{
			$table = $this->getTableArrayJ10L18($inputs);
			$data['B13'] = $table[$data['H3']];
		}
		$data['B13'] = round($data['B13'], 2);

		$tdata = $this->getVolumetricOrMass($inputs, $data);
		$data['B41'] = $tdata['B41'];			

		//J3     
		$data['J3'] = 1;
		if ($inputs['product_inlet_temperature_unit'] == "C"){
			$data['J3'] = 0;
		}

		$tdata = $this->getB23($inputs, $data);
		$data['B23'] = $tdata['B23'];

		$data3  = $this->getB30($data, $inputs);
		$data['B30'] = $data3['B30'];
		$data['B30_raw'] = $data3['B30_raw'];

		$data['B39'] = $inputs['flowrate'];

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$tdata = $this->getO38($inputs, $data);
			$data['O38'] = $tdata['O38'];
			$data['B42'] = number_format($data['O38'],3, '.','');
			$data['B42_raw'] = $data['O38'];

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);
			$data['O39'] = $tdata['O39'];
			$data['B42'] = number_format($data['O39'],3, '.','');
			$data['B42_raw'] = $data['O39'];
		}			

		$data2 = $this->getB35($data, $inputs);
		$data['B35'] = $data2['B35'];
		$data['B35_raw'] = $data2['B35_raw'];
		$data['M3'] = $data2['M3'];

		$data['B36'] = number_format(($data['B35_raw']/$data['B30_raw']), 3, '.','');

		echo $data['B42'].';';
	}	
	public function gasDischargePressureChanged(){
		$inputs = \Request::input();
		$data = array();
		$data['H2'] = $this->getH2($inputs);
		$data['H3'] = $this->getH3($inputs);

      	$data['B27'] = $inputs ['gas_inlet_pressure'];
      	$data['B32'] = $inputs ['gas_discharge_pressure'];

		//B13=IF(H3=1,B11,(B11*3.2808))
		$data['I7'] = $inputs['elevation']*3.2808;
		if ($data['H3']==1)
			$data['I7'] = $inputs['elevation'];

		if ($data['H2'] == 1){
			$data['B13'] = (14.68683)+(($data['I7'])*(-0.0005299248))+((pow($data['I7'],2))*(0.0000000072))+((pow($data['I7'],3))*(3.621858E-14))+((pow($data['I7'],4))*(-3.859745E-18));
		}else{
			$table = $this->getTableArrayJ10L18($inputs);
			$data['B13'] = $table[$data['H3']];
		}
		$data['B13'] = round($data['B13'], 2);

		$tdata = $this->getVolumetricOrMass($inputs, $data);
		$data['B41'] = $tdata['B41'];			

		//J3     
		$data['J3'] = 1;
		if ($inputs['product_inlet_temperature_unit'] == "C"){
			$data['J3'] = 0;
		}

		$tdata = $this->getB23($inputs, $data);
		$data['B23'] = $tdata['B23'];

		$data3  = $this->getB30($data, $inputs);
		$data['B30'] = $data3['B30'];
		$data['B30_raw'] = $data3['B30_raw'];

		$data['B39'] = $inputs['flowrate'];

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$tdata = $this->getO38($inputs, $data);
			$data['O38'] = $tdata['O38'];
			$data['B42'] = number_format($data['O38'],3, '.','');
			$data['B42_raw'] = $data['O38'];

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);
			$data['O39'] = $tdata['O39'];
			$data['B42'] = number_format($data['O39'],3, '.','');
			$data['B42_raw'] = $data['O39'];
		}			

		$data2 = $this->getB35($data, $inputs);
		$data['B35'] = $data2['B35'];
		$data['B35_raw'] = $data2['B35_raw'];
		$data['M3'] = $data2['M3'];

		$data['B36'] = number_format(($data['B35_raw']/$data['B30_raw']), 3, '.','');

		echo $data['B35'].';'.$data['B36'];
	}

	public function gasInletPressureChanged(){
		$inputs = \Request::input();
		$data = array();
		$data['H2'] = $this->getH2($inputs);
		$data['H3'] = $this->getH3($inputs);

      	$data['B27'] = $inputs ['gas_inlet_pressure'];
      	$data['B32'] = $inputs ['gas_discharge_pressure'];

		//B13=IF(H3=1,B11,(B11*3.2808))
		$data['I7'] = $inputs['elevation']*3.2808;
		if ($data['H3']==1)
			$data['I7'] = $inputs['elevation'];

		if ($data['H2'] == 1){
			$data['B13'] = (14.68683)+(($data['I7'])*(-0.0005299248))+((pow($data['I7'],2))*(0.0000000072))+((pow($data['I7'],3))*(3.621858E-14))+((pow($data['I7'],4))*(-3.859745E-18));
		}else{
			$table = $this->getTableArrayJ10L18($inputs);
			$data['B13'] = $table[$data['H3']];
		}
		$data['B13'] = round($data['B13'], 2);

		$tdata = $this->getVolumetricOrMass($inputs, $data);
		$data['B41'] = $tdata['B41'];			

		//J3     
		$data['J3'] = 1;
		if ($inputs['product_inlet_temperature_unit'] == "C"){
			$data['J3'] = 0;
		}

		$tdata = $this->getB23($inputs, $data);
		$data['B23'] = $tdata['B23'];

		$data3  = $this->getB30($data, $inputs);
		$data['B30'] = $data3['B30'];
		$data['B30_raw'] = $data3['B30_raw'];

		$data['B39'] = $inputs['flowrate'];

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$tdata = $this->getO38($inputs, $data);
			$data['O38'] = $tdata['O38'];
			$data['B42'] = number_format($data['O38'],3, '.','');
			$data['B42_raw'] = $data['O38'];

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);
			$data['O39'] = $tdata['O39'];
			$data['B42'] = number_format($data['O39'],3, '.','');
			$data['B42_raw'] = $data['O39'];
		}			

		$data2 = $this->getB35($data, $inputs);
		$data['B35'] = $data2['B35'];
		$data['B35_raw'] = $data2['B35_raw'];
		$data['M3'] = $data2['M3'];

		$data['B36'] = number_format(($data['B35_raw']/$data['B30_raw']), 3, '.','');

		echo $data['B30'].';'.$data['B36'].';'.$data['B42'].';';
	}

	public function gasInletTemperatureChanged(){
		$inputs = \Request::input();
		$data = array();
		$data['H2'] = $this->getH2($inputs);
		$data['H3'] = $this->getH3($inputs);

      	$data['B27'] = $inputs ['gas_inlet_pressure'];
      	$data['B32'] = $inputs ['gas_discharge_pressure'];

		//B13=IF(H3=1,B11,(B11*3.2808))
		$data['I7'] = $inputs['elevation']*3.2808;
		if ($data['H3']==1)
			$data['I7'] = $inputs['elevation'];

		if ($data['H2'] == 1){
			$data['B13'] = (14.68683)+(($data['I7'])*(-0.0005299248))+((pow($data['I7'],2))*(0.0000000072))+((pow($data['I7'],3))*(3.621858E-14))+((pow($data['I7'],4))*(-3.859745E-18));
		}else{
			$table = $this->getTableArrayJ10L18($inputs);
			$data['B13'] = $table[$data['H3']];
		}
		$data['B13'] = round($data['B13'], 2);

		$tdata = $this->getVolumetricOrMass($inputs, $data);
		$data['B41'] = $tdata['B41'];			

		//J3     
		$data['J3'] = 1;
		if ($inputs['product_inlet_temperature_unit'] == "C"){
			$data['J3'] = 0;
		}

		$tdata = $this->getB23($inputs, $data);
		$data['B23'] = $tdata['B23'];

		$data3  = $this->getB30($data, $inputs);
		$data['B30'] = $data3['B30'];
		$data['B30_raw'] = $data3['B30_raw'];

		$data['B39'] = $inputs['flowrate'];

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$tdata = $this->getO38($inputs, $data);
			$data['O38'] = $tdata['O38'];
			$data['B42'] = number_format($data['O38'],3, '.','');
			$data['B42_raw'] = $data['O38'];

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);
			$data['O39'] = $tdata['O39'];
			$data['B42'] = number_format($data['O39'],3, '.','');
			$data['B42_raw'] = $data['O39'];
		}			

		echo $data['B23'].';'.$data['B42'].';';
	}

	public function elevationChanged(){
		$inputs = \Request::input();
		$data = array();
		$data['H2'] = $this->getH2($inputs);
		$data['H3'] = $this->getH3($inputs);

      	$data['B27'] = $inputs ['gas_inlet_pressure'];
      	$data['B32'] = $inputs ['gas_discharge_pressure'];

		//B13=IF(H3=1,B11,(B11*3.2808))
		$data['I7'] = $inputs['elevation']*3.2808;
		if ($data['H3']==1)
			$data['I7'] = $inputs['elevation'];

		if ($data['H2'] == 1){
			$data['B13'] = (14.68683)+(($data['I7'])*(-0.0005299248))+((pow($data['I7'],2))*(0.0000000072))+((pow($data['I7'],3))*(3.621858E-14))+((pow($data['I7'],4))*(-3.859745E-18));
		}else{
			$table = $this->getTableArrayJ10L18($inputs);
			$data['B13'] = $table[$data['H3']];
		}
		$data['B13'] = round($data['B13'], 2);

		$data3  = $this->getB30($data, $inputs);
		$data['B30'] = $data3['B30'];
		$data['B30_raw'] = $data3['B30_raw'];


		$data2  	= $this->getB35($data, $inputs);
		$data['B35'] = $data2['B35'];
		$data['B35_raw'] = $data2['B35_raw'];
		$data['M3'] = $data2['M3'];

		$data['B36'] = number_format(($data['B35_raw']/$data['B30_raw']), 3, '.','');

		$data['B39'] = $inputs['flowrate'];
		$data['B23'] = $inputs['gas_inlet_temperature'];

		$tdata = $this->getVolumetricOrMass($inputs, $data);
		$data['B41'] = $tdata['B41'];		

		$data['B17'] = $inputs['molecular_weight'];

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$tdata = $this->getO38($inputs, $data);
			$data['O38'] = $tdata['O38'];
			$data['B42'] = number_format($data['O38'],3, '.','');
			$data['B42_raw'] = $data['O38'];

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);
			$data['O39'] = $tdata['O39'];
			$data['B42'] = number_format($data['O39'],3, '.','');
			$data['B42_raw'] = $data['O39'];
		}		

/*		\Log::info('B35 raw = '. $data['B35_raw']);
		\Log::info('B30 raw = '. $data['B30_raw']);
*/		echo $data['B13'].';'.$data['B30'].';'.$data['B35'].';'.$data['B36'].';'.$data['B42'];
	}

///*********END AJAX CALLS************///

	function getH2($inputs){
		if ($inputs['ambient_pressure_or_elevation']=="ambient_pressure_pressed")
			return 0;
		else
			return 1;
	}

	function getH3($inputs){
       	$result = 0;
		//h3 
		switch ($inputs['ambient_pressure_unit']){
	        case 'psia':
	        	$result = 1;
	        break;
	        case 'HGa':
	        	$result = 2;
	        break;
	        case 'H2Oa':
	        	$result = 3;
	        break;
	        case 'mmHGa':
	        	$result = 4;
	        break;
	        case 'kgcm2a':
	        	$result = 5;
	        break;
	        case 'mmH2Oa':
	        	$result = 6;
	        break;
	        case 'BARa':
	        	$result = 7;
	        break;
	        case 'mBARa':
	        	$result = 8;
	        break;
	        case 'kPAa':
	        	$result = 9;
	        break;
		}
		return $result;
	}

	function getTableArrayJ10L18($inputs){
		$table = array();

		$table[1] = $inputs['elevation'];
		$table[2] = $inputs['elevation']*0.4912;
		$table[3] = $inputs['elevation']*0.03613;
		$table[4] = $inputs['elevation']*0.4912/25.4;
		$table[5] = $inputs['elevation']*14.226;
		$table[6] = $inputs['elevation']*0.03613/25.4;
		$table[7] = $inputs['elevation']*14.504;
		$table[8] = $inputs['elevation']*0.014504;
		$table[9] = $inputs['elevation']*0.14504;

		return $table;
	}

	public function getUnitOneValues($B11){
		//L10 thru L18
		$unitsOneDefaults['psia']=$B11;
		$unitsOneDefaults['HG']=$unitsOneDefaults['psia']*0.4912;
		$unitsOneDefaults['H20']=$unitsOneDefaults['psia']*0.03613;
		$unitsOneDefaults['mmHG']=$unitsOneDefaults['psia']*0.4912/25.4;
		$unitsOneDefaults['kg_cm2']=$unitsOneDefaults['psia']*14.226;
		$unitsOneDefaults['mmH20']=$unitsOneDefaults['psia']*0.03613/25.4;
		$unitsOneDefaults['Bara']=$unitsOneDefaults['psia']*14.504;
		$unitsOneDefaults['mBara']=$unitsOneDefaults['psia']*0.014504;
		$unitsOneDefaults['kPa']=$unitsOneDefaults['psia']*0.14504;

/*		\Log::info('L10 thru L18');
		\Log::info('===============================================');
		\Log::info('psia raw = '. $unitsOneDefaults['psia']);
		\Log::info('HG raw = '. $unitsOneDefaults['HG']);
		\Log::info('H20 raw = '. $unitsOneDefaults['H20']);
		\Log::info('mmHG raw = '. $unitsOneDefaults['mmHG']);
		\Log::info('kg_cm2 raw = '. $unitsOneDefaults['kg_cm2']);
		\Log::info('mmH20 raw = '. $unitsOneDefaults['mmH20']);
		\Log::info('Bara raw = '. $unitsOneDefaults['Bara']);
		\Log::info('mBara raw = '. $unitsOneDefaults['mBara']);
		\Log::info('kPa raw = '. $unitsOneDefaults['kPa']);
		\Log::info('===============================================');*/

		return $unitsOneDefaults;
	}

	public function getUnitTwoValues($B13, $B27, $B32){
		//L25 thru L34
		$unitsTwoDefaults['psig']=$B27+$B13;
		$unitsTwoDefaults['HG']=($B27*0.4912)+$B13;
		$unitsTwoDefaults['H20']=($B27*0.03613)+$B13;
		$unitsTwoDefaults['mmHG']=$B27/51.71+$B13;
		$unitsTwoDefaults['kg_cm2']=($B27*14.226)+$B13;
		$unitsTwoDefaults['psia']=$B27;
		$unitsTwoDefaults['mmH20']=$B27*0.03613/25.4+$B13;
		$unitsTwoDefaults['Barg']=($B27*14.504)+$B13;
		$unitsTwoDefaults['mBarg']=($B27*0.014504)+$B13;
		$unitsTwoDefaults['kPa']=($B27*0.14504)+$B13;

/*		\Log::info('$B27 = '.$B27);
		\Log::info('$B13 = '.$B13);
		\Log::info('L25 thru L34');
		\Log::info('===============================================');
		\Log::info('psig raw = '.$unitsTwoDefaults['psig']);
		\Log::info('HG raw = '.$unitsTwoDefaults['HG']);
		\Log::info('H20 raw = '.$unitsTwoDefaults['H20']);
		\Log::info('mmHG raw = '.$unitsTwoDefaults['mmHG']);
		\Log::info('kg_cm2 raw = '.$unitsTwoDefaults['kg_cm2']);
		\Log::info('psia raw = '.$unitsTwoDefaults['psia']);
		\Log::info('mmH20 raw = '.$unitsTwoDefaults['mmH20']);
		\Log::info('Barg raw = '.$unitsTwoDefaults['Barg']);
		\Log::info('mBarg raw = '.$unitsTwoDefaults['mBarg']);
		\Log::info('kPa raw = '.$unitsTwoDefaults['kPa']);
		\Log::info('===============================================');*/

		$unitsTwoDefaults['discharge_psig']=$B32+$B13;
		$unitsTwoDefaults['discharge_HG']=($B32*0.4912)+$B13;
		$unitsTwoDefaults['discharge_H20']=$B32*0.03613+$B13;
		$unitsTwoDefaults['discharge_mmHG']=$B32/51.71+$B13;
		$unitsTwoDefaults['discharge_kg_cm2']=$B32*14.226+$B13;
		$unitsTwoDefaults['discharge_psia']=$B32;
		$unitsTwoDefaults['discharge_mmH20']=$B32*0.03613/25.4+$B13;
		$unitsTwoDefaults['discharge_Barg']=($B32*14.504)+$B13;
		$unitsTwoDefaults['discharge_mBarg']=($B32*0.014504)+$B13;
		$unitsTwoDefaults['discharge_kPa']=($B32*0.14504)+$B13;
		
		return $unitsTwoDefaults;
	}

	public function getB35($data, $inputs){
      	//###B35=VLOOKUP(M3,$J$25:$O$34,5)
      	$data2['M3'] = 1;
		$unitsTwoDefaults = $this->getUnitTwoValues($data['B13'], $data['B27'], $data['B32']);
      	switch(strtoupper($inputs['discharge_pressure_unit'])){
	        case 'PSIG':
	        	$data2['M3']=1;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_psig'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_psig'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='PSIG';
	        break;
	        case 'HGG':
	        	$data2['M3']=2;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_HG'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_HG'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='IN. HG';
	        break;
	        case 'H2OG':
	        	$data2['M3']=3;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_H20'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_H20'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='IN. WATER';
	        break;
	        case 'MMHGH':
	        	$data2['M3']=4;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_mmHG'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_mmHG'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='MM GH';
	        break;
	        case 'KGCM2G':
	        	$data2['M3']=5;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_kg_cm2'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_kg_cm2'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='KG/CM<sup>2</sup>';
	        break;
	        case 'PSIA':
	        	$data2['M3']=6;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_psia'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_psia'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='PSIA';
	        break;
	        case 'MMH2OG':
	        	$data2['M3']=7;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_mmH20'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_mmH20'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='MM WATER';
	        break;
	        case 'BARG':
	        	$data2['M3']=8;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_Barg'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_Barg'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='BARg';
	        break;
	        case 'MBARG':
	        	$data2['M3']=9;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_mBarg'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_mBarg'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='MBARg';
	        break;
	        case 'KPAG':
	        	$data2['M3']=10;
	        	$data2['B35_raw']=$unitsTwoDefaults['discharge_kPa'];
	        	$data2['B35']=number_format($unitsTwoDefaults['discharge_kPa'], 2, '.','');
   				$data2['label_discharge_pressure_unit'] ='KPAg';
	        break;
      	}	
      	return $data2;
     }

	public function getB30($data, $inputs){
      	//###B30 = =VLOOKUP(L3,$J$25:$L$34,3)
		$unitsTwoDefaults = $this->getUnitTwoValues($data['B13'], $data['B27'], $data['B32']);
		$data2['L3_3_12'] = 0;
      	switch (strtoupper($inputs['inlet_pressure_unit'])){
	        case 'PSIG':
	        	$data2['L3_3_12'] = 1;
   				$data2['B30'] = round($unitsTwoDefaults['psig'], 2);
   				$data2['B30_raw'] = $unitsTwoDefaults['psig'];
   				$data2['label_inlet_pressure_unit'] ='PSIG';
	        break;
	        case 'HGG':
	        	$data2['L3_3_12'] = 2;
				$data2['B30'] = round($unitsTwoDefaults['HG'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['HG'];
				$data2['label_inlet_pressure_unit'] ='IN. HG';
	        break;
	        case 'H2OG':
	        	$data2['L3_3_12'] = 3;
				$data2['B30'] = round($unitsTwoDefaults['H20'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['H20'];
				$data2['label_inlet_pressure_unit'] ='IN. WATER';
	        break;
	        case 'MMHGH':
	        	$data2['L3_3_12'] = 4;
				$data2['B30'] = round($unitsTwoDefaults['mmHG'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['mmHG'];
				$data2['label_inlet_pressure_unit'] ='MM HG';
	        break;
	        case 'KGCM2G':
	        	$data2['L3_3_12'] = 5;
				$data2['B30'] = round($unitsTwoDefaults['kg_cm2'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['kg_cm2'];
				$data2['label_inlet_pressure_unit'] ='KG/CM<sup>2</sup>';
	        break;
	        case 'PSIA':
	        	$data2['L3_3_12'] = 6;
				$data2['B30'] = round($unitsTwoDefaults['psia'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['psia'];
				$data2['label_inlet_pressure_unit'] ='PSIA';
	        break;
	        case 'MMH2OG':
	        	$data2['L3_3_12'] = 7;
				$data2['B30'] = round($unitsTwoDefaults['mmH20'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['mmH20'];
				$data2['label_inlet_pressure_unit'] ='MM WATER';
	        break;
	        case 'BARG':
	        	$data2['L3_3_12'] = 8;
				$data2['B30'] = 	round($unitsTwoDefaults['Barg'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['Barg'];
				$data2['label_inlet_pressure_unit'] ='BARg';
	        break;
	        case 'MBARG':
	        	$data2['L3_3_12'] = 9;
				$data2['B30'] = round($unitsTwoDefaults['mBarg'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['mBarg'];
				$data2['label_inlet_pressure_unit'] ='MBARg';
	        break;
	        case 'KPAG':
	        	$data2['L3_3_12'] = 10;
				$data2['B30'] = round($unitsTwoDefaults['kPa'], 2);
				$data2['B30_raw'] = $unitsTwoDefaults['kPa'];
				$data2['label_inlet_pressure_unit'] ='KPAg';
	        break;
      	}
      	return $data2;
	}

	function getVolumetricOrMass($inputs, $data){
		$data['B41'] = 0;
		if (isset($inputs['saturatee'])){
			$data['B41'] = $data['I23'];
		}

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$data['L2'] = 1;
			$data['I2'] = 1;
		} else {
			$data['L2'] = 0;
			$data['I2'] = 0;
		}		

		return $data;
	}


	//get B16 and label_product_type;
	function getB16($inputs){
		$data['dummy']='';
		if ($inputs['product_type']=='Air'){
			$data['label_product_type'] = 'Name of Gas';
			$data['B16'] = 'Air';
		} else {
			$data['label_product_type'] = 'Enter Name of Gas';
			$data['B16'] = '';
		}		

		return $data;
	}

	function getLabelPressureOrElevation($inputs, $defaults){
		if ($inputs['ambient_pressure_or_elevation']=="ambient_pressure_pressed"){
			$data['label_pressure_or_elevation'] = 'Pressure';	
			$data['B11'] = $defaults ['ambient'];
			$data['h2_2_8'] = 0;
			$data['10_1'] = '';
			$data['11_1'] = 'Pressure';
			$data['12_1'] = '';
			$data['10_2'] = '';
			$data['10_3'] = '';
			$data['12_2'] = '';
			$data['12_3'] = '';
			$data['h3_3_8'] = 0;			
		}else {
			$data['label_pressure_or_elevation'] = 'Elevation';
			$data['B11']=$defaults ['elevation'];
			$data['h2_2_8'] = 1;
			$data['10_1'] = '';
			$data['11_1'] = 'Elevation';
			$data['12_1'] = '';
			$data['10_2'] = '';
			$data['10_3'] = '';
			$data['12_2'] = '';
			$data['12_3'] = '';
			$data['7_9'] = '';				
		}

		return $data;
	}	

	function getLabelPressureOrElevationUnit($inputs, $unitsOneDefaults){	
		switch (strtoupper($inputs['ambient_pressure_unit'])){
	        case 'PSIA':
	        	$data2['11_3'] = 'psia';
	        	$data2['h3_3_8'] = 1;
   				$data2['13_2'] = $unitsOneDefaults['psia'];
	        break;

	        case 'HGA':
	        	$data2['11_3'] = 'inches hg';
	        	$data2['h3_3_8'] = 2;
   				$data2['13_2'] = $unitsOneDefaults['HG'];
	        break;

	        case 'H2OA':
	        	$data2['11_3'] = 'inches water';
	        	$data2['h3_3_8'] = 3;

   				$data2['13_2'] = $unitsOneDefaults['H20'];
	        break;
	        case 'MMHGA':
	        	$data2['11_3'] = 'mm hg';
	        	$data2['h3_3_8'] = 4;

   				$data2['13_2'] = $unitsOneDefaults['mmHG'];
	        break;
	        case 'KGCM2A':
	        	$data2['11_3'] = 'kg/cm2';
	        	$data2['h3_3_8'] = 5;

   				$data2['13_2'] = $unitsOneDefaults['kg_cm2'];
	        break;
	        case 'MMH2OA':
	        	$data2['11_3'] = 'mm water';
	        	$data2['h3_3_8'] = 6;

   				$data2['13_2'] = $unitsOneDefaults['mmH20'];
	        break;
	        case 'BARA':
	        	$data2['11_3'] = 'bara';
	        	$data2['h3_3_8'] = 7;

   				$data2['13_2'] = $unitsOneDefaults['Bara'];
	        break;
	        case 'MBARA':
	        	$data2['11_3'] = 'mbara';
	        	$data2['h3_3_8'] = 8;

   				$data2['13_2'] = $unitsOneDefaults['mBara'];
	        break;
	        case 'KPAA':
	        	$data2['11_3'] = 'kPa';
	        	$data2['h3_3_8'] = 9;

   				$data2['13_2'] = $unitsOneDefaults['kPa'];
	        break;
		}
		return $data2;
	}

	function getO38($inputs, $data){
		$data2['dummy'] = 0;
		foreach ($inputs as $key => $value)
			$this->dwLog($key, $value);	
        switch(strtoupper($inputs['volumetric_flowrate_unit'])){
	        case 'SCFM':
	        	$data2['N38'] = ($data['B39']*(14.7/$data['B30'])*(460+$data['B23'])/520);
	        	$data2['label_volumetric_or_mass'] = 'SCFM';
	        break;
	        case 'SCFD':
	        	$data2['N38'] = ($data['B39']/(24*60))*(14.7/$data['B30'])*(460+$data['B23'])/520;
	        	$data2['label_volumetric_or_mass'] = 'SCFD';
	        break;
	        case 'MSCFD':
	        	$data2['N38'] = ($data['B39']*1000/(24*60))*(14.7/$data['B30'])*(460+$data['B23'])/520;
	        	$data2['label_volumetric_or_mass'] = 'MSCFD';
	        break;
	        case 'MMSCFD':
	        	$data2['N38'] = ($data['B39']*1000000/(24*60))*(14.7/$data['B30'])*(460+$data['B23'])/520;
	        	$data2['label_volumetric_or_mass'] = 'MMSCFD';
	        break;
	        case 'SM3MIN':
	        	$data2['N38'] = ($data['B39']*35.31*(14.7/$data['B30'])*(460+$data['B23'])/520);
	        	$data2['label_volumetric_or_mass'] = 'M3/MIN';
	        break;
	        case 'ICFM':
	        	$data2['N38'] = $data['B39'];
	        	$data2['label_volumetric_or_mass'] = 'ICFM';
	        break;
       }
       //=N38*($B$30)/($B$30-$B$41)
       $data2['O38'] = $data2['N38']*($data['B30'])/($data['B30']-$data['B41']);	

       return $data2;
	}

	function getO39($inputs, $data)	{
		$data2['dummy'] = 0;

		foreach ($inputs as $key => $value)
			$this->dwLog($key, $value);		


		switch (strtoupper($inputs['mass_flowrate_unit'])){
	        case 'LBHR':
	        	$data2['N39'] = ($data['B39']*1545*($data['B23']+460))/(144*$data['B30']*$data['B17']);
	        	$data2['label_volumetric_or_mass'] = 'LB/HR';
	        break;
	        case 'LBMIN':
	        	$data2['N39'] = ($data['B39']*1545*($data['B23']+460))/(144*$data['B30']*$data['B17']*60);
	        	$data2['label_volumetric_or_mass'] = 'LB/MIN';
	        break;
	        case 'KGHR':
	        	$data2['N39'] = (($data['B39']*2.205)*1545*($data['B23']+460))/(144*$data['B30']*$data['B17']);
	        	$data2['label_volumetric_or_mass'] = 'KG/HR';
	        break;
	        case 'KGMIN':
	        	$data2['N39'] = ((($data['B39']*2.205)/60)*1545*($data['B23']+460))/(144*$data['B30']*$data['B17']);
				$data2['label_volumetric_or_mass'] = 'KG/MIN';
	        break;

		}
		//=N39*($B$30)/($B$30-$B$41)
		$data2['O39'] =$data2['N39']*($data['B30'])/($data['B30']-$data['B41']);

		return $data2;
	}

	function getB23($inputs, $data){
      	if ($data['J3'] == 1){
      		$data2['B23'] = $inputs['gas_inlet_temperature'];
      		$data2['label_gas_inlet_temperature'] = '&deg;F';
      	}else{
      		//h23 = =$B$21*9/5+32
      		$data2['B23'] =$inputs['gas_inlet_temperature']*9/5+32;
      		$data2['label_gas_inlet_temperature'] = '&deg;C';
      	}
      	return $data2;
	}

	function getB46($inputs, $data){
		$data2['B44'] = $inputs['coolant_temperature'];
		$data2['H44'] = $data2['B44'];
		$data2['H45'] = $data2['B44']*9/5+32;

		//###B46
		$data2['B46']= number_format($data2['H44'], 1, '.', '');
		if ($data['K3']==0)
			$data2['B46']= number_format($data2['H45'], 1, '.', '');
		return $data2;
	}

	public function mainPanelFormSubmitted(){
		$data = array();
		//B1 thru B54
		$defaults ['elevation'] = number_format(25.00, 2, '.', '');
		$defaults ['ambient'] = number_format(25.00, 2, '.', '');
		$defaults ['ambient_pressure'] =number_format(25.00, 2, '.', '');//calculated
		$defaults ['molecular_weight'] =number_format(28.980, 3, '.', '');
		$defaults ['specific_gravity'] =number_format(1.000, 3, '.', '');
		$defaults ['cp_cv'] =number_format(1.400, 3, '.', '');
		$defaults ['gas_inlet_temperature'] =number_format(90.00, 2, '.', '');
		$defaults ['inlet_temperature'] = number_format(90.00, 2, '.', '');//calculated
		$defaults ['gas_inlet_pressure'] = number_format(0.00, 2, '.', '');
		$defaults ['inlet_pressure'] =number_format(0.00, 2, '.', ''); //calculated
		$defaults ['gas_discharge_pressure'] =number_format(28.00, 2, '.', '');
		$defaults ['discharge_pressure'] =number_format(25.00, 2, '.', '');//calculated
		$defaults ['compression_ration'] =number_format(25.000, 3, '.', '');//calculated
		$defaults ['flowrate'] =number_format(2000.00, 2, '.', '');
		$defaults ['coolant_temperature'] =number_format(100, 2, '.', '');
		$defaults ['manual_selection'] ='c400';
		$defaults ['fixed_speed'] =number_format(0.00, 2, '.', '');

		//*************TODO for other unit defaults?

		$inputs = \Request::input();
		$data['inputs'] = '';
		foreach ($inputs as $key => $value)
			$data['inputs'] .= $key.' = '.$value.'<br>';

		$tdata = $this->getB16($inputs);
		$data['label_product_type'] = $tdata['label_product_type'];
		$data['B16'] = $tdata['B16'];

		$data['B18'] = $defaults ['specific_gravity'];
		$data['B19'] = $defaults ['cp_cv'];
		$data['B32'] = $defaults ['gas_discharge_pressure'];

		$tdata = $this->getLabelPressureOrElevation($inputs,$defaults);

		$data['label_pressure_or_elevation'] = $tdata['label_pressure_or_elevation'];
		$data['B11'] = $tdata['B11'];


		if ($inputs['ambient_pressure_or_elevation']=="ambient_pressure_pressed"){

			$unitsOneDefaults = $this->getUnitOneValues($data['B11']);

			//=IF(H2=1,$I$10,VLOOKUP(H3,$J$10:$L$18,3))
			//simplified, check the ambient_pressure_unit (psia, mbara, kpa etc) and set b13 to $unitsOneDefaults[ambient_pressure_unit]
			$tdata = $this->getLabelPressureOrElevationUnit($inputs, $unitsOneDefaults);

        	$data['11_3'] = $tdata['11_3'];
        	$data['h3_3_8'] = $tdata['h3_3_8'];
			$data['13_2'] = $tdata['13_2'];

			$data['label_pressure_or_elevation_unit'] = $data['11_3'];

		} else if ($inputs['ambient_pressure_or_elevation']=="elevation_pressed"){

			$data ['H3'] = 1;
			$data['label_pressure_or_elevation_unit'] = 'feet';

			if ($inputs['elevation_unit']=='m'){
				$data ['H3'] = 0;
				$data['label_pressure_or_elevation_unit'] = 'meters';
			}
			//=IF(H3=1,B11,(B11*3.2808)) 
			$data['I7'] = '';
			if ($data ['H3'] == 1){
				$data['7_9'] = $defaults ['elevation'];
				$data['I7'] = $defaults ['elevation'];

			}else{
				$data['7_9'] = $defaults ['elevation']*3.2808;
				$data['I7'] = $defaults ['elevation']*3.2808;
			}
 			//Worksheets("SIZING").Cells(13, 2).Value = "=IF(H2=1,$I$10,VLOOKUP(H3,$J$10:$L$18,3))" <=-==== will always one, so formula below applies (J10)
			$data['13_2'] = (14.68683)+(($data['I7'])*(-0.0005299248))+((pow($data['I7'],2))*(0.0000000072))+((pow($data['I7'],3))*(3.621858E-14))+((pow($data['I7'],4))*(-3.859745E-18));
			$data['B13'] = $data['13_2'];
		}///////// END OF ELEVATION OR AMBIENT PRESSURE BUTTON PRESSED

		//J3     
		$data['J3'] = 1;
		if ($inputs['product_inlet_temperature_unit'] == "C"){
			$data['J3'] = 0;
		}

		$data['B21'] = $defaults['gas_inlet_temperature'];

      	$tdata = $this->getB23($defaults, $data);
      	$data['B23'] = $tdata['B23'];
      	$data['label_gas_inlet_temperature'] = $tdata['label_gas_inlet_temperature'];

      	$data['B13'] = $data['13_2'];
      	$data['B27'] = $defaults ['gas_inlet_pressure'];
      	$data['B32'] = $defaults ['gas_discharge_pressure'];
		$unitsTwoDefaults = $this->getUnitTwoValues($data['B13'], $data['B27'], $data['B32']);
      	$data['B13'] = number_format($data['13_2'], 2, '.','');;

      	$tdata = $this->getB30($data, $inputs);
      	$data['L3_3_12']  = $tdata['L3_3_12'];
      	$data['B30']  = $tdata['B30'];
      	$data['B30_raw']  = $tdata['B30_raw'];

		$data['label_inlet_pressure_unit'] = $tdata['label_inlet_pressure_unit'] ;

		$tdata  	= $this->getB35($data, $inputs);
		$data['B35'] = $tdata['B35'];
		$data['B35_raw'] = $tdata['B35_raw'];
		$data['label_discharge_pressure_unit'] = $tdata['label_discharge_pressure_unit'];

		$data['B36'] = number_format(($data['B35_raw']/$data['B30_raw']), 3, '.','');

      	$data['M3'] = $tdata['M3'];

		$data['I23'] = number_format((0.0813948)+(($data['B23'])*(-0.003149847))+((pow($data['B23'],2))*(0.0001318915))+((pow($data['B23'],3))*(-0.000001078829))+((pow($data['B23'],4))*(0.000000009424192)), 3, '.','');

		$data['B17'] = $defaults ['molecular_weight'];
		$data['B39'] = $defaults ['flowrate'];


		$tdata = $this->getVolumetricOrMass($inputs, $data);

		$data['L2'] = $tdata['L2'];
		$data['B41'] = $tdata['B41'];
		$data['I2'] = $tdata['I2'];

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$tdata = $this->getO38($inputs, $data);

	       	$data['N38'] =$tdata['N38'];
        	$data['label_volumetric_or_mass'] = $tdata['label_volumetric_or_mass'];
	       	$data['O38'] = $tdata['O38'];

			$data['B42'] = number_format($data['O38'],3, '.','');
			$data['B42_raw'] = $data['O38'];

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);

			$data['label_volumetric_or_mass'] = $tdata['label_volumetric_or_mass'];
			$data['O39'] = $tdata['O39'];
			$data['N39'] = $tdata['N39'];
			$data['B42'] = number_format($data['O39'],3, '.','');
			$data['B42_raw'] = $data['O39'];
		}

		$data['K3'] = 1;
		$data['label_coolant_temperature'] = '&deg;F';
		if ($inputs['coolant_inlet_temperature_unit'] == 'C'){
			$data['K3'] = 0;
			$data['label_coolant_temperature'] = '&deg;C';
		}

		$tdata = $this->getB46($defaults, $data);
		$data['B44'] = $tdata['B44'];
		$data['H44'] = $tdata['H44'];
		$data['H45'] = $tdata['H45'];
		$data['B46'] = $tdata['B46'];

		$data['available_sizes'] = \DB::table('Compressordatabases')->select('size')->distinct()->get(); 

		$data['ambient_pressure_or_elevation'] = $inputs['ambient_pressure_or_elevation'];
		$data['volumetric_or_mass'] = $inputs['volumetric_or_mass'];
		$data['ambient_pressure_unit'] = $inputs['ambient_pressure_unit'];
		$data['volumetric_flowrate_unit'] = $inputs['volumetric_flowrate_unit'];
		$data['product_inlet_temperature_unit'] = $inputs['product_inlet_temperature_unit'];
		$data['coolant_inlet_temperature_unit'] = $inputs['coolant_inlet_temperature_unit'];

		//$data2['O38'] = ($data2['N38']*$data['B30'])/$data['B30']-$data['B41'];	
/*		\Log::info('$O38 = '.$data['O38']);
		\Log::info('$N38 = '.$data['N38']);
		\Log::info('$B30 = '.$data['B30']);
		\Log::info('$B41 = '.$data['B41']);*/
		return view('maindialogs/inputs', $data);
	}

/*GET C135 =
	IF(	C$103>40.001,
		"N/A",
	IF(
		C$103>30.001,
			VLOOKUP(C$74,$P$202:$X$213,7),
		IF(
			C$103>20.001,
				VLOOKUP(C$74,$Q$202:$X$213,6),
			VLOOKUP(C$74,$R$202:$X$213,5)
		)
	)
	2100	1830	1148	2701	2335	1885	SAF-194
	1,243.85
		//C136 =IF(C$103>40.001,"N/A",IF(C$103>30.001,VLOOKUP(C$74,$P$202:$X$213,4),IF(C$103>20.001,VLOOKUP(C$74,$Q$202:$X$213,4),VLOOKUP(C$74,$R$202:$X$213,4))))
		//C137 =IF(C$103>40.001,"N/A",IF(C$103>30.001,VLOOKUP(C$74,$P$202:$X$213,9),IF(C$103>20.001,VLOOKUP(C$74,$Q$202:$X$213,8),VLOOKUP(C$74,$R$202:$X$213,7))))
)*/
	function getC135_C137i(&$C135,&$C136,&$C137, $C74){
		$Cp = \App\Compressoraftercooler::all();
		$result = '';
		for ($i=1; $i<=$Cp->count(); $i++){
			if ($i == $Cp->count()){
				$C135 = $Cp[$i-1]->approach_temp;
				$C136 = $Cp[$i-1]->ss_20psi;
				$C137 = $Cp[$i-1]->weight;
			} else if ($i == 1 && $Cp[$i]->sss_20psi >= $C74){
				$C135 = $Cp[$i-1]->approach_temp;
				$C136 = $Cp[$i-1]->ss_20psi;
				$C137 = $Cp[$i-1]->weight;
				break;
			} if ($Cp[$i-1]->sss_20psi >= $C74){
				$C135 = $Cp[$i-2]->approach_temp;
				$C136 = $Cp[$i-2]->ss_20psi;
				$C137 = $Cp[$i-2]->weight;
				break;
			}
		}
		return $C135;
	}

	function getC135_C137(&$data){
		$Cp = \App\Compressoraftercooler::all();
		$result = '';
		for ($i=1; $i<=$Cp->count(); $i++){
			if ($i == $Cp->count()){
				$data['C135'] = $Cp[$i-1]->approach_temp;
				$data['C136'] = $Cp[$i-1]->ss_20psi;
				$data['C137'] = $Cp[$i-1]->weight;
			} else if ($i == 1 && $Cp[$i]->sss_20psi >= $data['C74']){
				$data['C135'] = $Cp[$i-1]->approach_temp;
				$data['C136'] = $Cp[$i-1]->ss_20psi;
				$data['C137'] = $Cp[$i-1]->weight;
				break;
			} if ($Cp[$i-1]->sss_20psi >= $data['C74']){
				$data['C135'] = $Cp[$i-2]->approach_temp;
				$data['C136'] = $Cp[$i-2]->ss_20psi;
				$data['C137'] = $Cp[$i-2]->weight;
				break;
			}
		}

		return $data;
	}

	function getC126($Cp, $P3){
		//C124 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,39),VLOOKUP($C$65,$AB$10:$BX$89,48))
		$BJ10 = 0;
		if($Cp->intake_flange > 0)
			$BJ10 = 1;		

		//BN10 =2*BH10+BJ10*BI10+BK10*BL10
		$BN10 = 2*$Cp->each_head+$BJ10*$Cp->intake_flange+$Cp->cylinder_wall_number*$Cp->cylinder_wall_drops;

		//BW10 =(2*BP10)+BQ10+BR10+(BS10*BT10)+(BU10*BV10)
		$BW10 =(2*$Cp->lube_feed_each_head)+$Cp->lube_feed_intake_flange+$Cp->drops_shaft_seal+($Cp->drops_cylinder_number*$Cp->drops_wall_drops)+($Cp->bearing_number*$Cp->seal_drops);

		if ($P3 == 1) return $BN10;
		else return $BW10;
	}	

	function getC125($Cp, $P3){
		//C125 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,40),VLOOKUP($C$65,$AB$10:$BX$89,49))

		// BJ10=IF(BI10>0,1,0)
				//BI10 = table intake_flange
		$BJ10 = 0;
		if($Cp->intake_flange > 0)
			$BJ10 = 1;

		// BK10 = table cylinder number
		//BO =2+BJ10+BK10
		$BO = 2+$BJ10+$Cp->cylinder_wall_number;

		if ($P3 == 1) return $BO;
		//BX = table feeds		
		else return $Cp->number_feeds;
	}

	function getC121($C100, $Cp){
		return ($C100)* ( pow(($Cp->standout/$Cp->blade_thickness),2) );
	}

	function getC116($C115){
		return $C115 /0.85;
	}
	function getC115($C79){
		return $C79 * 0.08467;
	}

	function getC80($C79){
		return $C79 * 0.7457;
	}

	function getC75($inputs, $data){
		return $data*($inputs['inlet_pressure']/14.7)*(520/($inputs['inlet_temperature']+460));
	}

	function getTableArrayValues($comporessorRowData, &$tableArray, $inputs){
		$tableArray['table_array_AI'] = round (( $comporessorRowData->air_ve_part_1 - ( $comporessorRowData->air_ve_part_2 * $tableArray['B36']) ) /100, 2);
		$tableArray['table_array_AI_not_rounded'] =( $comporessorRowData->air_ve_part_1 - ( $comporessorRowData->air_ve_part_2 * $tableArray['B36']) ) /100;

		$tableArray['table_array_AK'] = $tableArray['table_array_AI'];

		//=(100-(((100-(AI36*100))*((($H$18)^0.5))+(($B$36)^($H$19))-1)))/100
		$tableArray['table_array_AJ'] = round((100-(( (100-($tableArray['table_array_AI']*100)) * pow($tableArray['H18'],0.5) + pow($tableArray['B36'],$tableArray['H19']) -1) ))/100, 2);
		
		if ($tableArray['P3']==0) {
			$tableArray['table_array_AK'] = $tableArray['table_array_AJ'];
		}

		/*if fixed_speed has no value, table_array AL-AO*/
		$tableArray['table_array_AL'] = (1*$inputs['compressor_flow_capacity']*$comporessorRowData->nom_rpm)/($comporessorRowData->displ_capacity * $tableArray['table_array_AI_not_rounded'] );

		//=$AE10*((AL10/$AF10)^2)
		$tableArray['table_array_AM']	= $comporessorRowData->emp_hp_factor * ( pow( ( $tableArray['table_array_AL'] / $comporessorRowData->nom_rpm ), 2 ) );

		//=((144*$B$19)/(33000*($B$19-1)))*((($B$36^$I$19)-1)*($B$30*$AD10*(AL10/$AF10)))
		$tableArray['table_array_AN']	= ((144*$inputs['cp_cv'])/(33000*($inputs['cp_cv']-1)))*(((
			pow($tableArray['B36'],$tableArray['I19'])
			)-1)*($inputs['inlet_pressure']*$comporessorRowData->HP_displ*($tableArray['table_array_AL']/$comporessorRowData->nom_rpm)));

		$tableArray['table_array_AO']	= $tableArray['table_array_AM'] +$tableArray['table_array_AN'];
		//=$AE10*((AQ10/$AF10)^2)

		/*if fixed_speed has value table_array AQ-AX*/
		$tableArray['table_array_AQ'] = 0;
		if ($inputs['speed_fixed_or_not'] == 1){
			$tableArray['table_array_AQ']=$inputs['fixed_speed'];
		}

		//this is just copying values 
		$tableArray['table_array_AR'] = $tableArray['table_array_AI'];
		$tableArray['table_array_AR_not_rounded'] = $tableArray['table_array_AI_not_rounded'];
		$tableArray['table_array_AS'] = $tableArray['table_array_AJ'];
		$tableArray['table_array_AT'] = $tableArray['table_array_AK'];

		//=$AE10*((AQ10/$AF10)^2)
		$tableArray['table_array_AU']	= $comporessorRowData->emp_hp_factor * ( pow( ( $tableArray['table_array_AQ']/ $comporessorRowData->nom_rpm ), 2 ) );
		$tableArray['table_array_AV']	= ((144*$inputs['cp_cv'])/(33000*($inputs['cp_cv']-1)))*(((
			pow($tableArray['B36'],$tableArray['I19'])
			)-1)*($inputs['inlet_pressure']*$comporessorRowData->HP_displ*($tableArray['table_array_AQ']/$comporessorRowData->nom_rpm)));
		$tableArray['table_array_AW']	= $tableArray['table_array_AU'] +$tableArray['table_array_AV'];
		//=(AQ10*AC10*AT10)/(AF10)
		$tableArray['table_array_AX']	= ($tableArray['table_array_AQ'] *$comporessorRowData->displ_capacity*$tableArray['table_array_AT'])/($comporessorRowData->nom_rpm);

		//=IF(AL10>$AG10,$AI$118,IF(AL10<$AH10,$AI$119,$AM$119))
		$tableArray['table_array_AY'] = '';
		if ($tableArray['table_array_AL'] > $comporessorRowData->max_rpm)
			$tableArray['table_array_AY'] = 'Too Fast';
		else if ($tableArray['table_array_AL'] < $comporessorRowData->min_rpm)
			$tableArray['table_array_AY'] = 'Too Slow';

		$tableArray['table_array_AZ'] = '';
		if ($tableArray['table_array_AQ'] > $comporessorRowData->max_rpm)
			$tableArray['table_array_AZ'] = 'Too Fast';
		else if ($tableArray['table_array_AQ'] < $comporessorRowData->min_rpm)
			$tableArray['table_array_AZ'] = 'Too Slow';
	}


	function getOutputData($size, $inputs, $prevData){
		//retrieve the info of compressor, selected by manual selection
		$data = $prevData;
		$selection_row = \DB::table('Compressordatabases')->where('size',  $size)->first();
		$data['I59'] = $selection_row->min_rpm;
		$data['I60'] = $selection_row->max_rpm;
		$data['I61'] = $selection_row->nom_rpm;
		$data['I62'] = $selection_row->displ_capacity;
		$data['I63'] = $selection_row->emp_hp_factor;
		$data['I64'] = $selection_row->HP_displ;

		$data['I69'] = $selection_row->volumetric_a;
		$data['I70'] = $selection_row->volumetric_b;


		$this->getTableArrayValues($selection_row, $data, $inputs);		

		return $data;
	}

	function getComputerSelection(){
		$data['C65'] = 'No Choice';
		$data['C72']=0;
		$data['C74']=0;
		$data['table_array_AL'] = 0;
		$data['table_array_AM'] = 0;
		$data['table_array_AN'] = 0;
		$data['table_array_AO'] = 0;
		$data['table_array_AP'] = 0;
		$data['table_array_AQ'] = 0;
		$data['table_array_AR'] = 0;
		$data['table_array_AS'] = 0;
		$data['table_array_AT'] = 0;
		$data['table_array_AV'] = 0;
		$data['table_array_AW'] = 0;
		$data['table_array_AX'] = 0;
		$data['table_array_AY'] = 0;
		$data['table_array_AZ'] = 0;
		$data['table_array_AI_not_rounded'] = 0;

		if($inputs['speed_fixed_or_not']==0){
			$data['C74'] = $inputs['compressor_flow_capacity'];
			$data['D72'] = $data['table_array_AY'];
			$data['C79'] = $data['table_array_AO'];
			$data['C118'] = $data['table_array_AI_not_rounded'];
		}else{
			$data['C74'] = $data['table_array_AX'];
			$data['D72'] = $data['table_array_AZ'];
			$data['C79'] = $data['table_array_AW'];	
			$data['C118'] = $data['table_array_AR_not_rounded'];
		}


		//C75 =$K$41 = =C74*($B$30/14.7)*(520/($B$23+460))
		$data['C75'] = $this->getC75($inputs,$data['C74']);
		$data['K41'] = $data['C75'];

		//C79=IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,14),VLOOKUP($C$65,$AB$10:$AY$89,22))
		//already done above with c74 and d72

		//=C79*0.7457
		$data['C80'] = $this->getC80($data['C79']);

		$data['C82'] = $inputs['inlet_temperature'];
		//C85 = M10 = B13 
		$data['M10'] = $inputs['ambient_pressure'];
		$data['C85'] = $data['M10'];
		$data['C90'] = $inputs['inlet_pressure'];

		//C91 = M25 = =$L$22-$B$13   //// L22 = =B30
		$data['C91'] = $inputs['inlet_pressure']-$inputs['ambient_pressure'];

		//C96 = I36 = =I34+I35 
		//I35 =(B46-60)/2
		//I34 =I33-460
		//I33 =($B$23+460)*$B$36^$I$19
		$data['I33'] = ($inputs['inlet_temperature']+460)* (pow($inputs['compression_ratio'], $data['I19']));
		$data['I34'] = $data['I33']-460;
		$data['I35'] = ($inputs['coolant_inlet_temperature']-60)/2;
		$data['I36'] = $data['I34'] + $data['I35'];
		$data['C96'] = $data['I36'];
		//D96=IF(C$96>350,$AI$120,$AH$120)
		$data['D96'] = '';
		if ($data['C96'] > 350 ) $data['D96'] = 'Too Hot';

		$data['C99'] = $inputs['discharge_pressure'];

		//C100 = O25 = B35-B13
		$data['C100'] = $inputs['discharge_pressure']-$inputs['ambient_pressure'];

		$data['C105'] = $inputs['compression_ratio'];

		$data['C107'] = $inputs['discharge_pressure']-$inputs['inlet_pressure'];

		//=IF(AND(B49=0,C107>45),$AM$121,IF(C107>110,$AM$121,$AM$119))

		if ($inputs['booster_select']==0 && $data['C107']>45)
			$data['D107'] = 'HIGH';
		else if ($data['C107']>110)
			$data['D107'] = 'HIGH';
		else							
			$data['D107'] = '';

		$data['C112'] = $inputs['coolant_inlet_temperature'];

		//C115=$C$79*0.08467
		$data['C115'] = $this->getC115($data['C79']);

		//C116=$C$115/0.85
		$data['C116'] = $this->getC116($data['C115']);

		//C118 =IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,8),VLOOKUP($C$65,$AB$10:$AY$89,17))
		//already done above with c74 and d72

		//C121 =VLOOKUP($C$65,$AB$10:$BO$89,29)
		//table_array_BD=($B$35-$B$30)*((BB10/BC10)^2)

/*			$data['table_array_BD'] = $this->getC121($data['C100'], $Cp[$i-1]);
		$data['C121'] = $this->getC121($data['C100'], $Cp[$i-1]);
*/
		$data['table_array_BD'] = 0;
		$data['C121'] = $data['table_array_BD'];

		//D121 =IF(C$121>=2500,$AM$120,$AM$119)
		$data['D121'] = '';
		if ($data['C121']>2500)
			$data['D121'] = 'TOO HIGH';				
	}






	public function inputFormSubmitted(){
		$data['inputs'] ='';
		$inputs = \Request::input();

		$Cp = \App\Compressordatabase::all(); 
		//echo $Cp->count();

		$data['H18'] = 1/ $inputs['specific_gravity'];
		$data['H19'] = 1/ $inputs['cp_cv'];
		$data['B36'] = $inputs['compression_ratio'];

		//=($B$19-1)/$B$19
		$data['I19'] = ($inputs['cp_cv']-1)/$inputs['cp_cv'];
		$data['B67'] = $inputs['name_of_gas'];
		$data['B68'] = $inputs['molecular_weight'];
		$data['B69'] = $inputs['specific_gravity'];
		$data['B70'] = $inputs['cp_cv'];

		$data['P3']=0;
		if ($inputs['name_of_gas']=='Air'){
			$data['P3']=1;
		}

		$dataFound = false;

		for ($i=1; $i<=$Cp->count(); $i++){
			
			$this->getTableArrayValues($Cp[$i-1], $data, $inputs);

			//AA Value, last determiner
			if ($data['table_array_AL'] > $Cp[$i-1]->min_rpm && $data['table_array_AL'] < $Cp[$i-1]->max_rpm){
				$dataFound = true;
				$data['table_array_AA'] = $Cp[$i-1]->aa_value;
				if ($inputs['booster_select']==1){
					if ($data['table_array_AA'] == '2') {
						$data['C65']=$Cp[$i-1]->size;
						$data['C72']=$data['table_array_AL'];
						break;
					}
				}else{
					if ($data['table_array_AA'] == '1'){

						$data['C65']=$Cp[$i-1]->size;
						$data['C72']=$data['table_array_AL'];

						//D72=IF($B$53=0,VLOOKUP($C$65,$AB$10:$BA$89,24),VLOOKUP($C$65,$AB$10:$BA$89,25))
						//C74=IF($B$53=0,$B$42,VLOOKUP($C$65,$AB$10:$AY$89,23))
						//C118=IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,8),VLOOKUP($C$65,$AB$10:$AY$89,17))

						$data['C74']=0;
						if($inputs['speed_fixed_or_not']==0){
							$data['C74'] = $inputs['compressor_flow_capacity'];
							$data['D72'] = $data['table_array_AY'];
							$data['C79'] = $data['table_array_AO'];
							$data['C118'] = $data['table_array_AI_not_rounded'];
						}else{
							$data['C74'] = $data['table_array_AX'];
							$data['D72'] = $data['table_array_AZ'];
							$data['C79'] = $data['table_array_AW'];	
							$data['C118'] = $data['table_array_AR_not_rounded'];
						}

						//C75 =$K$41 = =C74*($B$30/14.7)*(520/($B$23+460))
						$data['C75'] = $this->getC75($inputs,$data['C74']);
						$data['K41'] = $data['C75'];

						//C79=IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,14),VLOOKUP($C$65,$AB$10:$AY$89,22))
						//already done above with c74 and d72

						//=C79*0.7457
						$data['C80'] = $this->getC80($data['C79']);

						$data['C82'] = $inputs['inlet_temperature'];
						//C85 = M10 = B13 
						$data['M10'] = $inputs['ambient_pressure'];
						$data['C85'] = $data['M10'];
						$data['C90'] = $inputs['inlet_pressure'];

						//C91 = M25 = =$L$22-$B$13   //// L22 = =B30
						$data['C91'] = $inputs['inlet_pressure']-$inputs['ambient_pressure'];

						//C96 = I36 = =I34+I35 
						//I35 =(B46-60)/2
						//I34 =I33-460
						//I33 =($B$23+460)*$B$36^$I$19
						$data['I33'] = ($inputs['inlet_temperature']+460)* (pow($inputs['compression_ratio'], $data['I19']));
						$data['I34'] = $data['I33']-460;
						$data['I35'] = ($inputs['coolant_inlet_temperature']-60)/2;
						$data['I36'] = $data['I34'] + $data['I35'];
						$data['C96'] = $data['I36'];
						//D96=IF(C$96>350,$AI$120,$AH$120)
						$data['D96'] = '';
						if ($data['C96'] > 350 ) $data['D96'] = 'Too Hot';

						$data['C99'] = $inputs['discharge_pressure'];

						//C100 = O25 = B35-B13
						$data['C100'] = $inputs['discharge_pressure']-$inputs['ambient_pressure'];

						$data['C105'] = $inputs['compression_ratio'];

						$data['C107'] = $inputs['discharge_pressure']-$inputs['inlet_pressure'];

						//=IF(AND(B49=0,C107>45),$AM$121,IF(C107>110,$AM$121,$AM$119))

						if ($inputs['booster_select']==0 && $data['C107']>45)
							$data['D107'] = 'HIGH';
						else if ($data['C107']>110)
							$data['D107'] = 'HIGH';
						else							
							$data['D107'] = '';

						$data['C112'] = $inputs['coolant_inlet_temperature'];

						//C115=$C$79*0.08467
						$data['C115'] = $this->getC115($data['C79']);

						//C116=$C$115/0.85
						$data['C116'] = $this->getC116($data['C115']);

						//C118 =IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,8),VLOOKUP($C$65,$AB$10:$AY$89,17))
						//already done above with c74 and d72

						//C121 =VLOOKUP($C$65,$AB$10:$BO$89,29)
						//table_array_BD=($B$35-$B$30)*((BB10/BC10)^2)
						$data['table_array_BD'] = $this->getC121($data['C100'], $Cp[$i-1]);
						$data['C121'] = $this->getC121($data['C100'], $Cp[$i-1]);

						//D121 =IF(C$121>=2500,$AM$120,$AM$119)
						$data['D121'] = '';
						if ($data['C121']>2500)
							$data['D121'] = 'TOO HIGH';

						//C123 = H67 =(M89*5250)/C72
						//M89 =K89+L89
							//K89 =$I$63*((E72/$I$61)^2)

								//I63 =VLOOKUP($I$58,$AB$10:$BX$89,4)<== lookup for $inputs['manual_selection'], return emp_HP_factor in database
								//I58 =E65
								//E65 =$B$52
								//B52 = manual_selection input

								//E72 =IF($B$53=0,VLOOKUP($E$65,$AB$10:$AY$89,11),VLOOKUP($E$65,$AB$10:$AY$89,16))

								//I61 =VLOOKUP($I$58,$AB$10:$BX$89,5)<== lookup for $inputs['manual_selection'], return nom_rpm in database

							//L89 =((144*$B$19)/(33000*($B$19-1)))*((($J$89^$I$19)-1)*($B$30*$I$64*(E72/$I$60)))
								//B19 B30 are known inputs
								//E72 I19 already calculated in previous formulas
								//J89 =(B30+8)/B30
								//I64 =VLOOKUP($I$58,$AB$10:$BX$89,3)<== I58 is known, vlookup to return HP_displ
								//I60 =VLOOKUP($I$58,$AB$10:$BX$89,6)<== vlookup to return HP_displ max_rpm

						$data['B52'] = $inputs['manual_selection'];
						$data['E65'] = $data['B52'];
						$data['I58'] = $data['E65'];
						
						//retrieve the info of compressor, selected by manual selection
						$manual_selection_row = \DB::table('Compressordatabases')->where('size',  $data['I58'])->first();
						$data['I59'] = $manual_selection_row->min_rpm;
						$data['I60'] = $manual_selection_row->max_rpm;
						$data['I61'] = $manual_selection_row->nom_rpm;
						$data['I62'] = $manual_selection_row->displ_capacity;
						$data['I63'] = $manual_selection_row->emp_hp_factor;
						$data['I64'] = $manual_selection_row->HP_displ;

						$data['I69'] = $manual_selection_row->volumetric_a;
						$data['I70'] = $manual_selection_row->volumetric_b;


						$data_manual = $data;
						$this->getTableArrayValues($manual_selection_row, $data_manual, $inputs);

						//E72 =IF($B$53=0,VLOOKUP($E$65,$AB$10:$AY$89,11),VLOOKUP($E$65,$AB$10:$AY$89,16))
						$data['E72'] = $data_manual['table_array_AQ'];
						if($inputs['speed_fixed_or_not']==0){
							$data['E74'] = $inputs['compressor_flow_capacity'];
							$data['F72'] = $data_manual['table_array_AY'];
							$data['E72'] = $data_manual['table_array_AL'];
							$data['E79'] = $data_manual['table_array_AO'];
							$data['E118'] = $data_manual['table_array_AI_not_rounded'];
						}else{
							$data['E74'] = $data_manual['table_array_AX'];
							$data['F72'] = $data_manual['table_array_AZ'];
							$data['E79'] = $data_manual['table_array_AW'];	
							$data['E118'] = $data_manual['table_array_AR_not_rounded'];					
						}

						$data['E75'] = $this->getC75($inputs,$data['E74']);

						$data['K89'] = $data['I63']*(pow(($data['E72'] / $data['I61']),2));


						$data['J89'] = ($inputs['inlet_pressure']+8)/$inputs['inlet_pressure'];
						$data['L89'] = ((144*$inputs['cp_cv'])/(33000*($inputs['cp_cv']-1)))*((
							( pow($data['J89'],$data['I19']) )
							-1)*($inputs['inlet_pressure']*$data['I64']*($data['E72']/$data['I60'])));

						$data['M89'] = $data['K89']+$data['L89'];
						$data['C123'] = ($data['M89']*5250)/$data['C72'];

						//C125 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,40),VLOOKUP($C$65,$AB$10:$BX$89,49))
						$data['C125'] = $this->getC125($Cp[$i-1], $data['P3']);

						//C126 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,39),VLOOKUP($C$65,$AB$10:$BX$89,48))
						$data['C126'] = $this->getC126($Cp[$i-1], $data['P3']);

						//C127 =($C$126/14000)*60*24
						$data['C127'] = ($data['C126']/14000)*60*24;

						$data['C129'] = $Cp[$i-1]->inlet_air;
						$data['C130'] = $Cp[$i-1]->outlet_air;
						$data['C131'] = $Cp[$i-1]->inlet_water;
						$data['C132'] = $Cp[$i-1]->outlet_water;
						$data['C133'] = $Cp[$i-1]->weight;
						$this->getC135_C137($data);

						//********* MANUAL SELECTION info**********/
						$data['E80'] =  $this->getC80($data['E79']);
						$data['E82'] =  $data['C82'];
						$data['E85'] =  $data['C85'];
						$data['E90'] =  $data['C90'];
						$data['E91'] =  $data['C91'];
						$data['E96'] =  $data['C96'];

						//F96=IF(E$96>350,$AI$120,$AH$120)
						$data['F96'] = '';
						if ($data['E96'] > 350 ) $data['F96'] = 'Too Hot';

						$data['E99'] =  $data['C99'];
						$data['E100'] =  $data['C100'];
						$data['E105'] =  $data['C105'];
						$data['E107'] =  $data['C107'];

						//=IF(AND(H74<1,E107>45),$AM$121,IF(E107>110,$AM$121,$AM$119))
						//H74 =VLOOKUP(E65,AB10:CG81,58)

						if ($manual_selection_row->column_58 < 1 && $data['E107']>45)
							$data['F107'] = 'HIGH';
						else if ($data['E107']>110)
							$data['F107'] = 'HIGH';
						else							
							$data['F107'] = '';

						$data['E112'] =  $data['C112'];

						$data['E115'] =  $this->getC115($data['E79']);
						$data['E116'] =  $this->getC116($data['E115']);

						$data['E121'] = $this->getC121($data['C100'],  $manual_selection_row);

						//I67 =(M89*5250)/E72
						$data['I67'] = ($data['M89']*5250)/$data['E72'];
						$data['E123'] = $data['I67'];

						$data['E125'] = $this->getC125($manual_selection_row, $data['P3']);

						//C126 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,39),VLOOKUP($C$65,$AB$10:$BX$89,48))
						$data['E126'] = $this->getC126($manual_selection_row, $data['P3']);

						//C127 =($C$126/14000)*60*24
						$data['E127'] = ($data['E126']/14000)*60*24;			

						$data['E129'] = $manual_selection_row->inlet_air;
						$data['E130'] = $manual_selection_row->outlet_air;
						$data['E131'] = $manual_selection_row->inlet_water;
						$data['E132'] = $manual_selection_row->outlet_water;
						$data['E133'] = $manual_selection_row->weight;
						
						$data['E135'] = '';
						$data['E136'] = '';
						$data['E137'] = '';


						$this->getC135_C137i($data['E135'],$data['E136'],$data['E137'], $data['E74']);


						//if > < condition found exit loop
						break;
					} 
				}
			}

		}

		
		if ($dataFound) $this->dwLog('datafound', 'Found');
		else {
			$this->dwLog('datafound', 'Not Found');
			$data['C65'] = 'No Choice';

			$data['C72']=0;
			$data['C74']=0;
			$data['table_array_AL'] = 0;
			$data['table_array_AM'] = 0;
			$data['table_array_AN'] = 0;
			$data['table_array_AO'] = 0;
			$data['table_array_AP'] = 0;
			$data['table_array_AQ'] = 0;
			$data['table_array_AR'] = 0;
			$data['table_array_AS'] = 0;
			$data['table_array_AT'] = 0;
			$data['table_array_AV'] = 0;
			$data['table_array_AW'] = 0;
			$data['table_array_AX'] = 0;
			$data['table_array_AY'] = 0;
			$data['table_array_AZ'] = 0;
			$data['table_array_AI_not_rounded'] = 0;

			if($inputs['speed_fixed_or_not']==0){
				$data['C74'] = $inputs['compressor_flow_capacity'];
				$data['D72'] = $data['table_array_AY'];
				$data['C79'] = $data['table_array_AO'];
				$data['C118'] = $data['table_array_AI_not_rounded'];
			}else{
				$data['C74'] = $data['table_array_AX'];
				$data['D72'] = $data['table_array_AZ'];
				$data['C79'] = $data['table_array_AW'];	
				$data['C118'] = $data['table_array_AR_not_rounded'];
			}


			//C75 =$K$41 = =C74*($B$30/14.7)*(520/($B$23+460))
			$data['C75'] = $this->getC75($inputs,$data['C74']);
			$data['K41'] = $data['C75'];

			//C79=IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,14),VLOOKUP($C$65,$AB$10:$AY$89,22))
			//already done above with c74 and d72

			//=C79*0.7457
			$data['C80'] = $this->getC80($data['C79']);

			$data['C82'] = $inputs['inlet_temperature'];
			//C85 = M10 = B13 
			$data['M10'] = $inputs['ambient_pressure'];
			$data['C85'] = $data['M10'];
			$data['C90'] = $inputs['inlet_pressure'];

			//C91 = M25 = =$L$22-$B$13   //// L22 = =B30
			$data['C91'] = $inputs['inlet_pressure']-$inputs['ambient_pressure'];

			//C96 = I36 = =I34+I35 
			//I35 =(B46-60)/2
			//I34 =I33-460
			//I33 =($B$23+460)*$B$36^$I$19
			$data['I33'] = ($inputs['inlet_temperature']+460)* (pow($inputs['compression_ratio'], $data['I19']));
			$data['I34'] = $data['I33']-460;
			$data['I35'] = ($inputs['coolant_inlet_temperature']-60)/2;
			$data['I36'] = $data['I34'] + $data['I35'];
			$data['C96'] = $data['I36'];
			//D96=IF(C$96>350,$AI$120,$AH$120)
			$data['D96'] = '';
			if ($data['C96'] > 350 ) $data['D96'] = 'Too Hot';

			$data['C99'] = $inputs['discharge_pressure'];

			//C100 = O25 = B35-B13
			$data['C100'] = $inputs['discharge_pressure']-$inputs['ambient_pressure'];

			$data['C105'] = $inputs['compression_ratio'];

			$data['C107'] = $inputs['discharge_pressure']-$inputs['inlet_pressure'];

			//=IF(AND(B49=0,C107>45),$AM$121,IF(C107>110,$AM$121,$AM$119))

			if ($inputs['booster_select']==0 && $data['C107']>45)
				$data['D107'] = 'HIGH';
			else if ($data['C107']>110)
				$data['D107'] = 'HIGH';
			else							
				$data['D107'] = '';

			$data['C112'] = $inputs['coolant_inlet_temperature'];

			//C115=$C$79*0.08467
			$data['C115'] = $this->getC115($data['C79']);

			//C116=$C$115/0.85
			$data['C116'] = $this->getC116($data['C115']);

			//C118 =IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,8),VLOOKUP($C$65,$AB$10:$AY$89,17))
			//already done above with c74 and d72

			//C121 =VLOOKUP($C$65,$AB$10:$BO$89,29)
			//table_array_BD=($B$35-$B$30)*((BB10/BC10)^2)

/*			$data['table_array_BD'] = $this->getC121($data['C100'], $Cp[$i-1]);
			$data['C121'] = $this->getC121($data['C100'], $Cp[$i-1]);
*/
			$data['table_array_BD'] = 0;
			$data['C121'] = $data['table_array_BD'];

			//D121 =IF(C$121>=2500,$AM$120,$AM$119)
			$data['D121'] = '';
			if ($data['C121']>2500)
				$data['D121'] = 'TOO HIGH';			

		}


		//Get all info for manual selection output
		$data['B52'] = $inputs['manual_selection'];
		$data['E65'] = $data['B52'];

		$dataManual = $this->getOutputData($inputs['manual_selection'], $inputs, $data);

		$data['E72'] = $dataManual['table_array_AQ'];
		if($inputs['speed_fixed_or_not']==0){
			$data['E74'] = $inputs['compressor_flow_capacity'];
			$data['F72'] = $dataManual['table_array_AY'];
			$data['E72'] = $dataManual['table_array_AL'];
			$data['E79'] = $dataManual['table_array_AO'];
			$data['E118'] = $dataManual['table_array_AI_not_rounded'];
		}else{
			$data['E74'] = $dataManual['table_array_AX'];
			$data['F72'] = $dataManual['table_array_AZ'];
			$data['E79'] = $dataManual['table_array_AW'];	
			$data['E118'] = $dataManual['table_array_AR_not_rounded'];					
		}

		$data['E75'] = $this->getC75($inputs,$data['E74']);		

		$data['E80'] =  $this->getC80($data['E79']);
/*		$data['E82'] =  $data['C82'];
		$data['E85'] =  $data['C85'];
		$data['E90'] =  $data['C90'];
		$data['E91'] =  $data['C91'];
		$data['E96'] =  $data['C96'];	

		$data['F96'] = '';
		if ($data['E96'] > 350 ) $data['F96'] = 'Too Hot';

		$data['E99'] =  $data['C99'];
		$data['E100'] =  $data['C100'];
		$data['E105'] =  $data['C105'];
		$data['E107'] =  $data['C107'];

		if ($manual_selection_row->column_58 < 1 && $data['E107']>45)
			$data['F107'] = 'HIGH';
		else if ($data['E107']>110)
			$data['F107'] = 'HIGH';
		else							
			$data['F107'] = '';

		$data['E112'] =  $data['C112'];

		$data['E115'] =  $this->getC115($data['E79']);
		$data['E116'] =  $this->getC116($data['E115']);

		$data['E121'] = $this->getC121($data['C100'],  $manual_selection_row);

		//I67 =(M89*5250)/E72
		$data['I67'] = ($data['M89']*5250)/$data['E72'];
		$data['E123'] = $data['I67'];

		$data['E125'] = $this->getC125($manual_selection_row, $data['P3']);

		//C126 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,39),VLOOKUP($C$65,$AB$10:$BX$89,48))
		$data['E126'] = $this->getC126($manual_selection_row, $data['P3']);

		//C127 =($C$126/14000)*60*24
		$data['E127'] = ($data['E126']/14000)*60*24;			

		$data['E129'] = $manual_selection_row->inlet_air;
		$data['E130'] = $manual_selection_row->outlet_air;
		$data['E131'] = $manual_selection_row->inlet_water;
		$data['E132'] = $manual_selection_row->outlet_water;
		$data['E133'] = $manual_selection_row->weight;
		
		$data['E135'] = '';
		$data['E136'] = '';
		$data['E137'] = '';


		$this->getC135_C137i($data['E135'],$data['E136'],$data['E137'], $data['E74']);		

		*/	


		//***TODO e76 and the fucking vbscript programming review******

		//End of Get all info for manual selection output




		echo '<hr>';
		foreach ($dataManual as $key => $value)
			echo $key.' = '.$value.'<br>';
		echo '<hr>';
		foreach ($data as $key => $value)
			echo $key.' = '.$value.'<br>';

		if(isset($data['C72'])) $data['C72'] = number_format($data['C72'],2, '.', '');
		if(isset($data['E72'])) $data['E72'] = number_format($data['E72'],2, '.', '');

		if(isset($data['C74'])) $data['C74'] = number_format($data['C74'],2, '.', '');
		if(isset($data['E74'])) $data['E74'] = number_format($data['E74'],2, '.', '');

		if(isset($data['C75'])) $data['C75'] = number_format($data['C75'],2, '.', '');
		if(isset($data['E75'])) $data['E75'] = number_format($data['E75'],2, '.', '');
		
		if(isset($data['C79'])) $data['C79'] = number_format($data['C79'],2, '.', '');
		if(isset($data['C80'])) $data['C80'] = number_format($data['C80'],2, '.', '');
		if(isset($data['E79'])) $data['E79'] = number_format($data['E79'],2, '.', '');
		if(isset($data['E80'])) $data['E80'] = number_format($data['E80'],2, '.', '');

		if(isset($data['C96'])) $data['C96'] = number_format($data['C96'],2, '.', '');
		if(isset($data['E96'])) $data['E96'] = number_format($data['E96'],2, '.', '');

		if(isset($data['C105'])) $data['C105'] = number_format($data['C105'],2, '.', '');
		if(isset($data['E105'])) $data['E105'] = number_format($data['E105'],2, '.', '');

		if(isset($data['C115'])) $data['C115'] = number_format($data['C115'],2, '.', '');
		if(isset($data['C116'])) $data['C116'] = number_format($data['C116'],2, '.', '');
		if(isset($data['E115'])) $data['E115'] = number_format($data['E115'],2, '.', '');
		if(isset($data['E116'])) $data['E116'] = number_format($data['E116'],2, '.', '');

		if(isset($data['C118'])) $data['C118'] = number_format(100*$data['C118'], 2,'.','').'%';
		if(isset($data['E118'])) $data['E118'] = number_format(100*$data['E118'], 2,'.','').'%';

		if(isset($data['C121'])) $data['C121'] = number_format($data['C121'],2, '.', '');
		if(isset($data['C123'])) $data['C123'] = number_format($data['C123'],2, '.', '');
		if(isset($data['E121'])) $data['E121'] = number_format($data['E121'],2, '.', '');
		if(isset($data['E123'])) $data['E123'] = number_format($data['E123'],2, '.', '');

		if(isset($data['C127'])) $data['C127'] = number_format($data['C127'],2, '.', '');
		if(isset($data['E127'])) $data['E127'] = number_format($data['E127'],2, '.', '');

//		print $formatter->format(.45);		

		//=IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,11),VLOOKUP($C$65,$AB$10:$AY$89,16))		
/*
		echo 'C65='.$data['C65'].'<br>';
		echo 'C72='.round($data['C72'],2).'<br>';
		echo 'D72='.$data['D72'].'<br>';
		echo 'C74='.round($data['C74'],2).'<br>';
		echo 'C75='.round($data['C75'],2).'<br>';
		echo 'C79='.$data['C79'].'<br>';
		echo 'C80='.$data['C80'].'<br>';
		echo 'C82='.$data['C82'].'<br>';
		echo 'C85='.$data['C85'].'<br>';
		echo 'C90='.$data['C90'].'<br>';
		echo 'C91='.$data['C91'].'<br>';
		echo 'C96='.$data['C96'].'<br>';
		echo 'C100='.$data['C100'].'<br>';
		echo 'C105='.$data['C105'].'<br>';
		echo 'C107='.$data['C107'].'<br>';
		echo 'D107='.$data['D107'].'<br>';
		echo 'C112='.$data['C112'].'<br>';
		echo 'C115='.$data['C115'].'<br>';
		echo 'C116='.$data['C116'].'<br>';
		echo 'C118='.$data['C118'].'<br>';//format as %
		echo 'C121='.$data['C121'].'<br>';
		echo 'C123='.$data['C123'].'<br>';
		echo 'C125='.$data['C125'].'<br>';
		echo 'C126='.$data['C126'].'<br>';
		echo 'C127='.$data['C127'].'<br>';
		echo 'C129='.$data['C129'].'<br>';
		echo 'C130='.$data['C130'].'<br>';
		echo 'C131='.$data['C131'].'<br>';
		echo 'C132='.$data['C132'].'<br>';
		echo 'C133='.$data['C133'].'<br>';
		echo 'C135='.$data['C135'].'<br>';
		echo 'C136='.$data['C136'].'<br>';
		echo 'C137='.$data['C137'].'<br>';

		echo '<hr>';

		echo 'E72='.$data['E72'].'<br>';
		echo 'F72='.$data['F72'].'<br>';
		echo 'E74='.$data['E74'].'<br>';
		echo 'E75='.$data['E75'].'<br>';
		echo 'E79='.$data['E79'].'<br>';
		echo 'E80='.$data['E80'].'<br>';
		echo 'E115='.$data['E115'].'<br>';
		echo 'E116='.$data['E116'].'<br>';
		echo 'E118='.$data['E118'].'<br>';
		echo 'E121='.$data['E121'].'<br>';
		echo 'E123='.$data['E123'].'<br>';
		echo 'E125='.$data['E125'].'<br>';
		echo 'E126='.$data['E126'].'<br>';
		echo 'E127='.$data['E127'].'<br>';
		echo 'E129='.$data['E129'].'<br>';
		echo 'E130='.$data['E130'].'<br>';
		echo 'E131='.$data['E131'].'<br>';
		echo 'E132='.$data['E132'].'<br>';
		echo 'E133='.$data['E133'].'<br>';
		echo 'E135='.$data['E135'].'<br>';
		echo 'E136='.$data['E136'].'<br>';
		echo 'E137='.$data['E137'].'<br>';


		echo 'I58='.$data['I58'].'<br>';
		echo 'I59='.$data['I59'].'<br>';
		echo 'I60='.$data['I60'].'<br>';
		echo 'I61='.$data['I61'].'<br>';
		echo 'I62='.$data['I62'].'<br>';
		echo 'I63='.$data['I63'].'<br>';
		echo 'I64='.$data['I64'].'<br>';
		echo 'I69='.$data['I69'].'<br>';
		echo 'I70='.$data['I70'].'<br>';
		echo 'E72='.$data['E72'].'<br>';
		echo 'K89='.$data['K89'].'<br>';*/

		echo '<hr>';
		foreach ($inputs as $key => $value)
			$data['inputs'] .= $key.' = '.$value.'<br>';

		echo $data['inputs'];


//		return view('output/results', $data);
	}


	public function dwLog($key, $value){

		\Log::info($key .' = '.$value);						
	}


}