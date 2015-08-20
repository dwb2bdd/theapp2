<?php namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use App\Sizing;

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
		$this->ajaxMajorCall($inputs, $data);
		echo $data['B42'].';';
	}	
	public function gasDischargePressureChanged(){
		$inputs = \Request::input();
		$data = array();
		$this->ajaxMajorCall($inputs, $data);
		echo $data['B35'].';'.$data['B36'];
	}

	public function gasInletPressureChanged(){
		$inputs = \Request::input();
		$data = array();
		$this->ajaxMajorCall($inputs, $data);
		echo $data['B30'].';'.$data['B36'].';'.$data['B42'].';';
	}

	public function gasInletTemperatureChanged(){
		$inputs = \Request::input();
		$data = array();
		$this->ajaxMajorCall($inputs, $data);
		echo $data['B23'].';'.$data['B42'].';';
	}

	function ajaxMajorCall($inputs, &$data){
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
		
		$data['B13_raw'] = $data['B13'];
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

		$unitsTwoDefaults = $this->getUnitTwoValues($data['B13_raw'], $data['B27'], $data['B32']);

		$data3  = $this->getB30($data, $inputs, $unitsTwoDefaults );

		$data['B30'] = $data3['B30'];

		$data['B30_raw'] = $data3['B30_raw'];

		$data2  = $this->getB35($data, $inputs, $unitsTwoDefaults );
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
			$data['B42'] = number_format($data['O38'],2, '.','');
			$data['B42_raw'] = $data['O38'];

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);
			$data['O39'] = $tdata['O39'];
			$data['B42'] = number_format($data['O39'],2, '.','');
			$data['B42_raw'] = $data['O39'];
		}		
	}

	public function elevationChanged(){
		$inputs = \Request::input();
		$data = array();

		$this->ajaxMajorCall($inputs, $data);
		echo $data['B13'].';'.$data['B30'].';'.$data['B35'].';'.$data['B36'].';'.$data['B42'];
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

	public function getUnitOneValues2($B13){
		$unitsOneDefaults['psia']=$B13;
		$unitsOneDefaults['HG']=$B13/0.4912;
		$unitsOneDefaults['H20']=$B13*27.678;
		$unitsOneDefaults['mmHG']=$B13*25.4/0.4912;
		$unitsOneDefaults['kg_cm2']=$B13/14.226;
		$unitsOneDefaults['mmH20']=$B13*25.4/0.03613;
		$unitsOneDefaults['Bara']=$B13/14.504;
		$unitsOneDefaults['mBara']=$B13/0.014504;
		$unitsOneDefaults['kPa']=$B13/0.14504;
		return $unitsOneDefaults;
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

	//DISCHARGE
	public function getUnitTwoValues3($B13,$B35){
		$unitsTwoDefaults['discharge_psig']=$B35-$B13;
		$unitsTwoDefaults['discharge_HG']=($B35-$B13)/0.4912;
		$unitsTwoDefaults['discharge_H20']=($B35-$B13)*27.678;
		$unitsTwoDefaults['discharge_mmHG']=($B35-$B13)*51.71;
		$unitsTwoDefaults['discharge_kg_cm2']=($B35-$B13)/14.226;
		$unitsTwoDefaults['discharge_psia']=$B35;
		$unitsTwoDefaults['discharge_mmH20']=($B35-$B13)*25.4/0.03613;
		$unitsTwoDefaults['discharge_Barg']=($B35-$B13)/14.504;
		$unitsTwoDefaults['discharge_mBarg']=($B35-$B13)/0.014504;
		$unitsTwoDefaults['discharge_kPa']=($B35-$B13)/0.14504;

/*
				\Log::info('getUnitTwoValues3');
				\Log::info('===============================================');
				\Log::info('discharge_psig = '.$unitsTwoDefaults['discharge_psig']);
				\Log::info('discharge_HG = '.$unitsTwoDefaults['discharge_HG']);
				\Log::info('discharge_H20 = '.$unitsTwoDefaults['discharge_H20']);
				\Log::info('discharge_mmHG = '.$unitsTwoDefaults['discharge_mmHG']);
				\Log::info('discharge_kg_cm2 = '.$unitsTwoDefaults['discharge_kg_cm2']);
				\Log::info('discharge_psia = '.$unitsTwoDefaults['discharge_psia']);
				\Log::info('discharge_mmH20 = '.$unitsTwoDefaults['discharge_mmH20']);
				\Log::info('discharge_Barg = '.$unitsTwoDefaults['discharge_Barg']);
				\Log::info('discharge_mBarg = '.$unitsTwoDefaults['discharge_mBarg']);
				\Log::info('discharge_kPa = '.$unitsTwoDefaults['discharge_kPa']);
				\Log::info('===============================================');*/
		
		return $unitsTwoDefaults;
	}	

	function getC100($unitsTwoDefaults, $inputs){
		$result = 0;
		switch (strtoupper($inputs['discharge_pressure_unit'])){
	       case 'PSIG':
	        	$result = $unitsTwoDefaults['discharge_psig'];
	        break;
	        case 'HGG':
	        	$result = $unitsTwoDefaults['discharge_HG'];
	        break;
	        case 'H2OG':
	        	$result = $unitsTwoDefaults['discharge_H20'];
	        break;
	        case 'MMHGH':
	        	$result = $unitsTwoDefaults['discharge_mmHG'];
	        break;
	       	case 'KGCM2G':
	        	$result = $unitsTwoDefaults['discharge_kg_cm2'];
	        break;
	        case 'PSIA':
	        	$result = $unitsTwoDefaults['discharge_psia'];
	        break;
	        case 'MMH2OG':
	        	$result = $unitsTwoDefaults['discharge_mmH20'];
	        break;
	        case 'BARG':
	        	$result = $unitsTwoDefaults['discharge_Barg'];
	        break;
	        case 'MBARG':
	        	$result = $unitsTwoDefaults['discharge_mBarg'];
	        break;
	        case 'KPAG':
	        	$result = $unitsTwoDefaults['discharge_kPa'];
	        break;
		}
		return $result;
	}	

	function getC91($unitsTwoDefaults, $inputs){
		$result = 0;
		switch (strtoupper($inputs['inlet_pressure_unit'])){
	       case 'PSIG':
	        	$result = $unitsTwoDefaults['psig'];
	        break;
	        case 'HGG':
	        	$result = $unitsTwoDefaults['HG'];
	        break;
	        case 'H2OG':
	        	$result = $unitsTwoDefaults['H20'];
	        break;
	        case 'MMHGH':
	        	$result = $unitsTwoDefaults['mmHG'];
	        break;
	       	case 'KGCM2G':
	        	$result = $unitsTwoDefaults['kg_cm2'];
	        break;
	        case 'PSIA':
	        	$result = $unitsTwoDefaults['psia'];
	        break;
	        case 'MMH2OG':
	        	$result = $unitsTwoDefaults['mmH20'];
	        break;
	        case 'BARG':
	        	$result = $unitsTwoDefaults['Barg'];
	        break;
	        case 'MBARG':
	        	$result = $unitsTwoDefaults['mBarg'];
	        break;
	        case 'KPAG':
	        	$result = $unitsTwoDefaults['kPa'];
	        break;
		}
		return $result;
	}	


	///INTAKE
	public function getUnitTwoValues2($B13,$B30){
		\Log::info('twovalues b30 = '. $B30);
		\Log::info('twovalues b13 = '. $B13);

		$L22 = $B30;
		$unitsTwoDefaults['psig']=$L22-$B13;
		$unitsTwoDefaults['HG']=($L22-$B13)*2.036;
		$unitsTwoDefaults['H20']=($L22-$B13)*27.678;
		$unitsTwoDefaults['mmHG']=($L22-$B13)*51.71;
		$unitsTwoDefaults['kg_cm2']=($L22-$B13)/14.226;
		$unitsTwoDefaults['psia']=$B30;
		$unitsTwoDefaults['mmH20']=($L22-$B13)*25.4/0.03613;
		$unitsTwoDefaults['Barg']=($L22-$B13)/14.504;
		$unitsTwoDefaults['mBarg']=($L22-$B13)/0.014504;
		$unitsTwoDefaults['kPa']=($L22-$B13)/0.14504;
		return $unitsTwoDefaults;
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

				\Log::info('$B27 = '.$B27);
				\Log::info('$B13 = '.$B13);
/*				\Log::info('L25 thru L34');
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

	public function getB35($data, $inputs, $unitsTwoDefaults ){
      	//###B35=VLOOKUP(M3,$J$25:$O$34,5)
      	$data2['M3'] = 1;
		//$unitsTwoDefaults = $this->getUnitTwoValues($data['B13'], $data['B27'], $data['B32']);
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
   				$data2['label_discharge_pressure_unit'] ='KG/CM2';
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

	public function getB30($data, $inputs, $unitsTwoDefaults ){
      	//###B30 = =VLOOKUP(L3,$J$25:$L$34,3)
		//$unitsTwoDefaults = $this->getUnitTwoValues($data['B13'], $data['B27'], $data['B32']);
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
				$data2['label_inlet_pressure_unit'] ='KG/CM2';
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
			$data['A118'] = 'AIR VOLUMETRIC EFFICIENCY';
		} else {
			$data['label_product_type'] = 'Enter Name of Gas';
			$data['B16'] = '';
			$data['A118'] = 'GAS VOLUMETRIC EFFICIENCY';
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
		$data2['B86'] = '';
		$data2['M11'] = 0;
		$data2['C86'] = $data2['M11'];
		$data2['E86'] = $data2['M11'];

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

   				$data2['B86'] = 'IN HG';
   				$data2['M11'] = $data2['13_2']/0.4912;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11'];
	        break;

	        case 'H2OA':
	        	$data2['11_3'] = 'inches water';
	        	$data2['h3_3_8'] = 3;

   				$data2['13_2'] = $unitsOneDefaults['H20'];
   				$data2['B86'] = 'IN WATER';
   				$data2['M11'] = $data2['13_2']*27.678;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11'];   				
	        break;
	        case 'MMHGA':
	        	$data2['11_3'] = 'mm hg';
	        	$data2['h3_3_8'] = 4;

   				$data2['13_2'] = $unitsOneDefaults['mmHG'];
   				$data2['B86'] = 'MM HG';
   				$data2['M11'] = $data2['13_2']*25.4/0.4912;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11'];   				
	        break;
	        case 'KGCM2A':
	        	$data2['11_3'] = 'kg/cm2';
	        	$data2['h3_3_8'] = 5;

   				$data2['13_2'] = $unitsOneDefaults['kg_cm2'];
   				$data2['B86'] = 'KG/CM2';
   				$data2['M11'] = $data2['13_2']/14.226;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11'];     				
	        break;
	        case 'MMH2OA':
	        	$data2['11_3'] = 'mm water';
	        	$data2['h3_3_8'] = 6;

   				$data2['13_2'] = $unitsOneDefaults['mmH20'];
   				$data2['B86'] = 'MM WATER';
   				$data2['M11'] = $data2['13_2']*25.4/0.03613;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11'];    				
	        break;
	        case 'BARA':
	        	$data2['11_3'] = 'bara';
	        	$data2['h3_3_8'] = 7;

   				$data2['13_2'] = $unitsOneDefaults['Bara'];
   				$data2['B86'] = 'BARa';
   				$data2['M11'] = $data2['13_2']/14.504;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11']; 
			break;
	        case 'MBARA':
	        	$data2['11_3'] = 'mbara';
	        	$data2['h3_3_8'] = 8;

   				$data2['13_2'] = $unitsOneDefaults['mBara'];
   				$data2['B86'] = 'MBARa';
   				$data2['M11'] = $data2['13_2']/0.014504;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11']; 
   			break;
	        case 'KPAA':
	        	$data2['11_3'] = 'kPa';
	        	$data2['h3_3_8'] = 9;

   				$data2['13_2'] = $unitsOneDefaults['kPa'];
   				$data2['B86'] = 'KPA';
   				$data2['M11'] = $data2['13_2']/0.14504;
   				$data2['C86'] = $data2['M11'];
   				$data2['E86'] = $data2['M11']; 
	        break;
		}
		return $data2;
	}

	function getBtoE76($inputs, $data){
		$data2['dummy'] = 0;
		$data2['B76'] = '';
		$data2['C76'] = 0;
		$data2['E76'] = 0;

		//K41=C74*($B$30/14.7)*(520/($B$23+460))
		$data2['K41'] = $data['C74']*($data['B30']/14.7)*(520/($data['B23']+460));

		//M41=E74*($B$30/14.7)*(520/($B$23+460))

		//K42 K43 K44 K45 K46 M42 M43 M44 M45 M46
		$data2['M41'] = $data['E74']*($data['B30']/14.7)*(520/($data['B23']+460));

        switch(strtoupper($inputs['volumetric_flowrate_unit'])){
	        case 'SCFD':
				$data2['B76'] = 'SCFD';
		        $data2['C76'] = $data2['K41']*60*24;
		        $data2['E76'] = $data2['M41']*60*24;
	        break;
	        case 'MSCFD':
				$data2['B76'] = 'MSCFD';
		        $data2['C76'] = $data2['K41']*60*24/1000;
		        $data2['E76'] = $data2['M41']*60*24/1000;
	        break;
	        case 'MMSCFD':
				$data2['B76'] = 'MMSCFD';
		        $data2['C76'] = $data2['K41']*60*24/1000000;
		        $data2['E76'] = $data2['M41']*60*24/1000000;
	        break;
	        case 'SM3MIN':
				$data2['B76'] = 'M3/MIN';
		        $data2['C76'] = $data2['K41']/35.31;
		        $data2['E76'] = $data2['M41']/35.31;
	        break;
       }

       return $data2;
	}	

	function getBtoE76O39($inputs, $data)	{
		$data2['dummy'] = 0;
		$data2['B76'] = '';
		$data2['C76'] = 0;
		$data2['E76'] = 0;

		//K47 =C74*60*144*B30*B17/(1545*(B23+460))  K48 K49 K50  M47 M48 M49 M50
		$data2['K47']=$data['C74']*60*144*$data['B30']*$data['B17']/(1545*($data['B23']+460));

		//M47 =E74*60*144*B30*B17/(1545*(B23+460))
		$data2['M47']=$data['E74']*60*144*$data['B30']*$data['B17']/(1545*($data['B23']+460));

		switch (strtoupper($inputs['mass_flowrate_unit'])){
	        case 'LBHR':
				$data2['B76'] = 'LB/HR';
		        $data2['C76'] = $data2['K47'];
		        $data2['E76'] = $data2['M47'];
	        break;
	        case 'LBMIN':
				$data2['B76'] = 'LB/MIN';
		        $data2['C76'] = $data2['K47']/60;
		        $data2['E76'] = $data2['M47']/60;
	        break;
	        case 'KGHR':
				$data2['B76'] = 'KG/HR';
		        $data2['C76'] = $data2['K47']/2.205;
		        $data2['E76'] = $data2['M47']/2.205;
	        break;
	        case 'KGMIN':
				$data2['B76'] = 'KG/MIN';
		        $data2['C76'] = ($data2['K47']/2.205)/60;
		        $data2['E76'] = ($data2['M47']/2.205)/60;
	        break;
		}
		return $data2;
	}	

	function getO38($inputs, $data){
		$data2['dummy'] = 0;
		/*		foreach ($inputs as $key => $value)
					$this->dwLog($key, $value);	*/
        switch(strtoupper($inputs['volumetric_flowrate_unit'])){
	        case 'SCFM':
	        	$data2['N38'] = ($data['B39']*(14.7/$data['B30_raw'])*(460+$data['B23'])/520);
	        	$data2['label_volumetric_or_mass'] = 'SCFM';
	        	\Log::info('o38 scfm');
	        break;
	        case 'SCFD':
	        	$data2['N38'] = ($data['B39']/(24*60))*(14.7/$data['B30_raw'])*(460+$data['B23'])/520;
	        	$data2['label_volumetric_or_mass'] = 'SCFD';
	        	\Log::info('o38 scfd');
	        break;
	        case 'MSCFD':
	        	$data2['N38'] = ($data['B39']*1000/(24*60))*(14.7/$data['B30_raw'])*(460+$data['B23'])/520;
	        	$data2['label_volumetric_or_mass'] = 'MSCFD';
	        	\Log::info('o38 mscfd');
	        break;
	        case 'MMSCFD':
	        	$data2['N38'] = ($data['B39']*1000000/(24*60))*(14.7/$data['B30_raw'])*(460+$data['B23'])/520;
	        	$data2['label_volumetric_or_mass'] = 'MMSCFD';
	        	\Log::info('o38 mmscfd');
	        break;
	        case 'SM3MIN':
	        	$data2['N38'] = ($data['B39']*35.31*(14.7/$data['B30_raw'])*(460+$data['B23'])/520);
	        	$data2['label_volumetric_or_mass'] = 'M3/MIN';
	        	\Log::info('o38 s3m');
	        break;
	        case 'ICFM':
	        	$data2['N38'] = $data['B39'];
	        	\Log::info('o38 icfm');
				

	        	$data2['label_volumetric_or_mass'] = 'ICFM';
	        break;
       }
       //=N38*($B$30)/($B$30-$B$41)
       \Log::info('B39 = '.$data['B39']);
       \Log::info('B23 = '.$data['B23']);

       \Log::info('N38 = '.$data2['N38']);
       \Log::info('B30 = '.$data['B30_raw']);
       \Log::info('B41 = '.$data['B41']);
       $data2['O38'] = $data2['N38']*($data['B30_raw'])/($data['B30_raw']-$data['B41']);

       return $data2;
	}

	function getO39($inputs, $data)	{
		$data2['dummy'] = 0;

		/*		foreach ($inputs as $key => $value)
					$this->dwLog($key, $value);	*/	


		switch (strtoupper($inputs['mass_flowrate_unit'])){
	        case 'LBHR':
	        	$data2['N39'] = ($data['B39']*1545*($data['B23']+460))/(144*$data['B30_raw']*$data['B17']);
	        	$data2['label_volumetric_or_mass'] = 'LB/HR';
	        break;
	        case 'LBMIN':
	        	$data2['N39'] = ($data['B39']*1545*($data['B23']+460))/(144*$data['B30_raw']*$data['B17']*60);
	        	$data2['label_volumetric_or_mass'] = 'LB/MIN';
	        break;
	        case 'KGHR':
	        	$data2['N39'] = (($data['B39']*2.205)*1545*($data['B23']+460))/(144*$data['B30_raw']*$data['B17']);
	        	$data2['label_volumetric_or_mass'] = 'KG/HR';
	        break;
	        case 'KGMIN':
	        	$data2['N39'] = ((($data['B39']*2.205)/60)*1545*($data['B23']+460))/(144*$data['B30_raw']*$data['B17']);
				$data2['label_volumetric_or_mass'] = 'KG/MIN';
	        break;

		}
		//=N39*($B$30)/($B$30-$B$41)
		$data2['O39'] =$data2['N39']*($data['B30_raw'])/($data['B30_raw']-$data['B41']);

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
		$inputs = \Request::input();

		//B1 thru B54
		$defaults ['elevation'] = number_format(25.00, 2, '.', '');
		if ($inputs['ambient_pressure_or_elevation']=="elevation_pressed")
			$defaults ['elevation'] = number_format(1000.00, 2, '.', '');

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


		$data['inputs'] = '';

		foreach ($inputs as $key => $value)
			$data['inputs'] .= $key.' = '.$value.'<br>';

		$tdata = $this->getB16($inputs);
		$data['label_product_type'] = $tdata['label_product_type'];
		$data['B16'] = $tdata['B16'];
		$data['A118'] = $tdata['A118'];

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
			$data['B13'] = $data['13_2'];

			$data['B86'] = $tdata['B86'];
			$data['M11'] = $tdata['M11'];
			$data['C86'] = $tdata['C86'];
			$data['E86'] = $tdata['E86'];
			
			$data['label_pressure_or_elevation_unit'] = $data['11_3'];

		} else if ($inputs['ambient_pressure_or_elevation']=="elevation_pressed"){

			$data ['H3'] = 1;
			$data['B86'] = 'ALT.(FT)';
			$data['B11'] = $defaults ['elevation'];
			$data['C86'] = $data['B11'];
			$data['E86'] = $data['B11'];			

			$data['label_pressure_or_elevation_unit'] = 'feet';

			if ($inputs['elevation_unit']=='m'){
				$data ['H3'] = 0;
				$data['B86'] = 'ALT.(M)';
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

      	$tdata = $this->getB30($data, $inputs, $unitsTwoDefaults);
      	$data['L3_3_12']  = $tdata['L3_3_12'];
      	$data['B30']  = $tdata['B30'];
      	$data['B30_raw']  = $tdata['B30_raw'];

		$data['label_inlet_pressure_unit'] = $tdata['label_inlet_pressure_unit'] ;

		$tdata = $this->getB35($data, $inputs, $unitsTwoDefaults );
		$data['B35'] = $tdata['B35'];
		$data['B35_raw'] = $tdata['B35_raw'];

		$this->dwLog('B35raw', $data['B35_raw']);
		$this->dwLog('B30raw', $data['B30_raw']);
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

			$data['B42'] = number_format($data['O38'],2, '.','');
			$data['B42_raw'] = $data['O38'];
			\Log::info('O38 = '.$data['O38']);

		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getO39($inputs, $data);

			$data['label_volumetric_or_mass'] = $tdata['label_volumetric_or_mass'];
			$data['O39'] = $tdata['O39'];
			$data['N39'] = $tdata['N39'];
			\Log::info('O39 = '.$data['O39']);
			$data['B42'] = number_format($data['O39'],2, '.','');
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

		$data['available_sizes1'] = \DB::table('Compressordatabases')->select('size')->distinct()->get(); 

		foreach ($data['available_sizes1'] as $value)
			$data['available_sizes']["$value->size"] = $value->size;

		$data['ambient_pressure_or_elevation'] = $inputs['ambient_pressure_or_elevation'];
		$data['volumetric_or_mass'] = $inputs['volumetric_or_mass'];
		$data['ambient_pressure_unit'] = $inputs['ambient_pressure_unit'];
		$data['volumetric_flowrate_unit'] = $inputs['volumetric_flowrate_unit'];
		$data['mass_flowrate_unit'] = $inputs['mass_flowrate_unit'];
		$data['product_inlet_temperature_unit'] = $inputs['product_inlet_temperature_unit'];
		$data['coolant_inlet_temperature_unit'] = $inputs['coolant_inlet_temperature_unit'];

		$data['inlet_pressure_unit'] = $inputs['inlet_pressure_unit'];
		//$data['label_inlet_pressure_unit'] = $inputs['label_inlet_pressure_unit'];
		$data['discharge_pressure_unit'] = $inputs['discharge_pressure_unit'];
		//$data['label_discharge_pressure_unit'] = $inputs['label_discharge_pressure_unit'];

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

	function getC75($inputs, $data, $data2){
		/*			
			\Log::info('B30_raw = '.$data2['B30_raw']);
			return $data*($inputs['inlet_pressure']/14.7)*(520/($inputs['inlet_temperature']+460));
			=C74*($B$30/14.7)*(520/($B$23+460))

				*/		

		\Log::info('C74 = '. $data);
		\Log::info('B30 raw = '. $data2['B30_raw']);
		\Log::info('inlet_temperature = '. $inputs['inlet_temperature']);
		return $data*($data2['B30_raw']/14.7)*(520/($inputs['inlet_temperature']+460));
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

	function getManualSelection(&$data, $inputs)	{
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

		$data['E75'] = $this->getC75($inputs,$data['E74'], $data);		

		$data['E80'] =  $this->getC80($data['E79']);
		$data['E82'] =  $data['C82'];
		$data['E85'] =  $data['C85'];
		$data['E86'] =  $data['C86'];

		$data['E90'] =  $data['C90'];
		$data['E91'] =  $data['C91'];
		$data['E96'] =  $data['C96'];	

		$data['F96'] = '';
		if ($data['E96'] > 350 ) $data['F96'] = 'Too Hot';

		$data['E99'] =  $data['C99'];
		$data['E100'] =  $data['C100'];
		$data['E105'] =  $data['C105'];
		$data['E107'] =  $data['C107'];

		$manual_selection_row = \DB::table('Compressordatabases')->where('size',  $data['I58'])->first();

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

		return $data;
	}

	function getComputerSelection(&$data, $inputs, $rowSelected){

		if (isset($rowSelected)){
			$data['C65']=$rowSelected->size;

		} else{
			$data['C65'] = 'No Choice';
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
		}

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
		$data['C75'] = $this->getC75($inputs,$data['C74'], $data);
		$data['K41'] = $data['C75'];

		//C79=IF($B$53=0,VLOOKUP($C$65,$AB$10:$AY$89,14),VLOOKUP($C$65,$AB$10:$AY$89,22))
		//already done above with c74 and d72

		//=C79*0.7457
		$data['C80'] = $this->getC80($data['C79']);

		$data['C82'] = $inputs['inlet_temperature'];
		//C85 = M10 = B13 
		$data['M10'] = $inputs['ambient_pressure'];
		$data['C85'] = $data['M10'];
		$data['C86'] = $inputs['elevation'];
		$data['C90'] = $inputs['inlet_pressure'];

		$unitsTwoDefaultsOther = $this->getUnitTwoValues2($data['B13'], $inputs['inlet_pressure']);
		$data['C91'] = $this->getC91($unitsTwoDefaultsOther, $inputs);

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

		//$unitsTwoDefaultsOther = $this->getUnitTwoValues2($data['B13'], $data['B30']);
		$unitsTwoDefaultsOther = $this->getUnitTwoValues3($data['B13'], $data['B35']);
		$data['C100'] = $this->getC100($unitsTwoDefaultsOther, $inputs);

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
		if (isset($rowSelected))
			$data['table_array_BD'] = $this->getC121($data['C100'], $rowSelected);
		else
			$data['table_array_BD'] = 0;

		$data['C121'] = $data['table_array_BD'];

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

		$data['E75'] = $this->getC75($inputs,$data['E74'],$data);

		if ($inputs['volumetric_or_mass']=="volumetric_pressed"){
			$tdata = $this->getBtoE76($inputs, $data);
		} else if ($inputs['volumetric_or_mass']=="mass_pressed"){
			$tdata = $this->getBtoE76O39($inputs, $data);
		}		

		$data['B76'] = $tdata['B76'];
		$data['C76'] = $tdata['C76'];
		$data['E76'] = $tdata['E76'];

		$data['K89'] = $data['I63']*(pow(($data['E72'] / $data['I61']),2));

		$data['J89'] = ($inputs['inlet_pressure']+8)/$inputs['inlet_pressure'];
		$data['L89'] = ((144*$inputs['cp_cv'])/(33000*($inputs['cp_cv']-1)))*((
			( pow($data['J89'],$data['I19']) )
			-1)*($inputs['inlet_pressure']*$data['I64']*($data['E72']/$data['I60'])));

		$data['M89'] = $data['K89']+$data['L89'];
		
		if (isset($rowSelected)){
			$data['C123'] = ($data['M89']*5250)/$data['C72'];
			//C125 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,40),VLOOKUP($C$65,$AB$10:$BX$89,49))
			$data['C125'] = $this->getC125($rowSelected, $data['P3']);
			//C126 =IF($P$3=1,VLOOKUP($C$65,$AB$10:$BO$89,39),VLOOKUP($C$65,$AB$10:$BX$89,48))
			$data['C126'] = $this->getC126($rowSelected, $data['P3']);
			$data['C129'] = $rowSelected->inlet_air;
			$data['C130'] = $rowSelected->outlet_air;
			$data['C131'] = $rowSelected->inlet_water;
			$data['C132'] = $rowSelected->outlet_water;
			$data['C133'] = $rowSelected->weight;			
		} else {
			$data['C123'] = 0;
			$data['C125'] = 0;
			$data['C126'] = 0;
			$data['C129'] = 'N/A';
			$data['C130'] = 'N/A';
			$data['C131'] = 'N/A';
			$data['C132'] = 'N/A';
			$data['C133'] = 'N/A';
		}

		//C127 =($C$126/14000)*60*24
		$data['C127'] = ($data['C126']/14000)*60*24;

		$this->getC135_C137($data);

		return $data;
	}

	public function getB100($inputs){
		$data2['dummy']= 0;
      	switch(strtoupper($inputs['discharge_pressure_unit'])){
	        case 'PSIG':
	        	$data2['B100']='PSIG';
	        break;
	        case 'HGG':
	        	$data2['B100']='IN. HG';
	        break;
	        case 'H2OG':
	        	$data2['B100']='IN. WATER';
	        break;
	        case 'MMHGH':
	        	$data2['B100']='MM HG';
	        break;
	        case 'KGCM2G':
	        	$data2['B100']='KG/CM2';
	        break;
	        case 'PSIA':
	        	$data2['B100']='PSIA';
	        break;
	        case 'MMH2OG':
	        	$data2['B100']='MM WATER';
	        break;
	        case 'BARG':
	        	$data2['B100']='BARg';
	        break;
	        case 'MBARG':
	        	$data2['B100']='MBARg';
	        break;
	        case 'KPAG':
	        	$data2['B100']='KPAg';
	        break;
      	}	
      	return $data2;
     }

	public function getB91($inputs){
		$data2['dummy']= 0;
      	switch (strtoupper($inputs['inlet_pressure_unit'])){
	        case 'PSIG':
	        	$data2['B91']='PSIG';
	        break;
	        case 'HGG':
	        	$data2['B91']='IN. HG';
	        break;
	        case 'H2OG':
	        	$data2['B91']='IN. WATER';
	        break;
	        case 'MMHGH':
	        	$data2['B91']='MM HG';
	        break;
	        case 'KGCM2G':
	        	$data2['B91']='KG/CM2';
	        break;
	        case 'PSIA':
	        	$data2['B91']='PSIA';
	        break;
	        case 'MMH2OG':
	        	$data2['B91']='MM WATER';
	        break;
	        case 'BARG':
	        	$data2['B91']='BARg';
	        break;
	        case 'MBARG':
	        	$data2['B91']='MBARg';
	        break;
	        case 'KPAG':
	        	$data2['B91']='KPAg';
	        break;
      	}
      	return $data2;
	}

	function getB108($data, $inputs){
		$data2['B108'] = '';
		$data2['C108'] = 0;
		$data2['E108'] = 0;
		if($data['M3']==$data['L3']){

			switch($data['M3']){
				case 2:
					$data2['B108'] = 'IN. HG';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
				case 3:
					$data2['B108'] = 'IN WATER';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
				case 4:
					$data2['B108'] = 'MM HG';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
				case 5:
					$data2['B108'] = 'KG/CM2';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
				case 7:
					$data2['B108'] = 'MM WATER';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
				case 8:
					$data2['B108'] = 'BARg';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
				case 9:
					$data2['B108'] = 'MBARg';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
				case 10:
					$data2['B108'] = 'KPAg';
					$data2['C108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
					$data2['E108'] = $inputs['gas_discharge_pressure']-$inputs['gas_inlet_pressure'];
				break;
			}

		}
	}	

	function getK58($inputs, $data){
		$graphInput['K'] = array();
		$graphInput['L'] = array();
		$graphInput['M'] = array();
		$graphInput['N'] = array();
		$graphInput['O'] = array();
		$graphInput['P'] = array();
		$graphInput['Q'] = array();
		$graphInput['R'] = array();
		$graphInput['S'] = array();

		$graphInput['K'][0]=$data['I59'];

		for ($i = 1; $i < 30; $i++){
			$graphInput['K'][$i] = $graphInput['K'][$i-1]+25;
		}

		foreach ($graphInput['K'] as $key => $value)
			$graphInput['L'][$key] = (97.55-(2.375*$data['B36']))/100;

		foreach ($graphInput['L'] as $key => $value)
			$graphInput['M'][$key] = (100-(((100-($value*100))*((pow($data['H18'],0.5)))+(pow($data['B36'],$data['H19']))-1)))/100;


		foreach ($graphInput['L'] as $key => $value)
			if ($inputs['name_of_gas'] == 'Air')
				$graphInput['N'][$key] = $graphInput['L'][$key];
			else
				$graphInput['N'][$key] = $graphInput['M'][$key];

		foreach ($graphInput['K'] as $key => $value)
			$graphInput['O'][$key] = $data['I63']*(pow(($value/$data['I60']),2));

		foreach ($graphInput['K'] as $key => $value)
			//=((144*$B$19)/(33000*($B$19-1)))*((($B$36^$I$19)-1)*($B$30*$I$64*(K59/$I$60)))
			//$graphInput['P'][$key] = ((144*$inputs['cp_cv'])/(33000*($inputs['cp_cv']-1)))*(((pow($data['B36'],$data['I19']))-1)*($data['B30']*$data['I64']*($value/$data['I60'])));
			$graphInput['P'][$key] = ((144*$inputs['cp_cv'])/(33000*($inputs['cp_cv']-1)))*((pow(($data['B35']/$inputs['inlet_pressure']),
				
				$data['I19']


				)-1)*($inputs['inlet_pressure']*$data['I64']*($value/$data['I60'])));

		foreach ($graphInput['O'] as $key => $value)
			$graphInput['Q'][$key] = $value + $graphInput['P'][$key];

		foreach ($graphInput['K'] as $key => $value)
			$graphInput['R'][$key] = ($value*$data['I62']*$graphInput['N'][$key])/($data['I61']);

		foreach ($graphInput['R'] as $key => $value)
			$graphInput['S'][$key] = $value*($inputs['inlet_pressure']/14.7)*(520/($data['B23']+460));

		return $graphInput;
	}	


	function getJ97($inputs, $data){
		$graphInput['J'] = array(1,2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50);
		$graphInput['K'] = array();
		$graphInput['O'] = array();
		$graphInput['P'] = array();
		$graphInput['Q'] = array();
		$graphInput['R'] = array();
		$graphInput['S'] = array();

		foreach ($graphInput['J'] as $key => $value)
			$graphInput['K'][$key] = ($value+$inputs['ambient_pressure'])/$inputs['inlet_pressure'];

		foreach ($graphInput['K'] as $key => $value)
			$graphInput['O'][$key] = $data['I63']*( pow(($data['E72']/$data['I61']),2) );

		foreach ($graphInput['K'] as $key => $value)
			$graphInput['P'][$key] =((144*$inputs['cp_cv'])/(33000*($inputs['cp_cv']-1)))*(((pow($value,$data['I19']))-1)*($inputs['inlet_pressure']*$data['I64']*($data['E72']/$data['I61'])));

		foreach ($graphInput['O'] as $key => $value)
			$graphInput['Q'][$key] = $graphInput['O'][$key] +$graphInput['P'][$key]  ;

		foreach ($graphInput['K'] as $key => $value)
			$graphInput['L'][$key] = ($data['I69']-($data['I70']*$value))/100;

		foreach ($graphInput['L'] as $key => $value)
			$graphInput['M'][$key] = (100-(((100-($value*100))*((
				
				pow((1/$inputs['specific_gravity']),0.5)

				))+((
				
				pow($graphInput['K'][$key],(1/$inputs['cp_cv']))

				)-1))))/100;

		foreach ($graphInput['L'] as $key => $value)
			if ($inputs['name_of_gas'] == 'Air')
				$graphInput['N'][$key] = $graphInput['L'][$key];
			else
				$graphInput['N'][$key] = $graphInput['M'][$key];

		foreach ($graphInput['N'] as $key => $value)
			$graphInput['R'][$key] =($data['E72']*$data['I62']*$value)/($data['I61']);
	

		foreach ($graphInput['R'] as $key => $value)
			$graphInput['S'][$key] = $value*($inputs['inlet_pressure']/14.7)*(520/($inputs['inlet_temperature']+460));

		return $graphInput;
	}

	public function inputFormSubmitted(){
		$data['inputs'] ='';
		$inputs = \Request::input();

		$Cp = \App\Compressordatabase::all(); 
		//echo $Cp->count();

		$data['H18'] = 1/ $inputs['specific_gravity'];
		$data['H19'] = 1/ $inputs['cp_cv'];
		$data['B13'] = $inputs['ambient_pressure'];
		$data['B19'] = $inputs['cp_cv'];
		$data['B36'] = $inputs['compression_ratio'];
		$data['B35'] = $inputs['discharge_pressure'];
		$data['B32'] = $inputs['gas_discharge_pressure'];
		$data['B30'] = $inputs['inlet_pressure'];
		$data['B30_raw'] = $inputs['B30_raw'];
		$data['C32'] = $inputs['label_discharge_pressure_unit'];

		$data['calculations_performed_by'] = $inputs['calculations_performed_by'];
		$data['customer'] = $inputs['customer'];
		$data['reference'] = $inputs['reference'];
		
		//=($B$19-1)/$B$19
		$data['I19'] = ($inputs['cp_cv']-1)/$inputs['cp_cv'];
		$data['B67'] = $inputs['name_of_gas'];
		$data['B68'] = $inputs['molecular_weight'];
		$data['B69'] = $inputs['specific_gravity'];
		$data['B70'] = $inputs['cp_cv'];
		$data['A118'] = $inputs['A118'];
		$data['B17'] = $inputs['B17'];
		$data['L3'] = $inputs['L3'];
		$data['M3'] = $inputs['M3'];

		$data['B100'] = $inputs['label_discharge_pressure_unit'];


		$data['product_inlet_temperature_unit'] = $inputs['product_inlet_temperature_unit'];

		if (isset($inputs['B86'])) $data['B86'] = $inputs['B86'];
		if (isset($inputs['B30'])) $data['B30'] = $inputs['B30'];
		if (isset($inputs['B23'])) $data['B23'] = $inputs['B23'];
		if (isset($inputs['M11'])) $data['M11'] = $inputs['M11'];
		if (isset($inputs['C86'])) $data['C86'] = $inputs['C86'];
		if (isset($inputs['E86'])) $data['E86'] = $inputs['E86'];		

		$data['P3']=0;
		if ($inputs['name_of_gas']=='Air'){
			$data['P3']=1;
		}

		$dataFound = false;
		$foundRow = null;
		for ($i=1; $i<=$Cp->count(); $i++){
			$this->getTableArrayValues($Cp[$i-1], $data, $inputs);
			//AA Value, last determiner
			if ($data['table_array_AL'] > $Cp[$i-1]->min_rpm && $data['table_array_AL'] < $Cp[$i-1]->max_rpm){
				
				$data['table_array_AA'] = $Cp[$i-1]->aa_value;

				if ($inputs['booster_select']==1 && $data['table_array_AA'] == '2'){
					$dataFound = true;
					$foundRow = $Cp[$i-1];
					break;
				}else if ($inputs['booster_select']==0 && $data['table_array_AA'] == '1'){
					$dataFound = true;
					$foundRow = $Cp[$i-1];
					break;
				}

			}
		}

		
		if ($dataFound) 
			$this->getComputerSelection($data, $inputs, $foundRow);
		else 
			$this->getComputerSelection($data, $inputs, null);

		$this->getManualSelection($data, $inputs);

		$data['B21'] = $inputs['gas_inlet_temperature'];

		$data['B83'] = '';
		$data['C83'] = 0;
		$data['E83'] = 0;

		$data['B97'] = '';
		$data['C97'] = 0;
		$data['E97'] = 0;

		if ($inputs['product_inlet_temperature_unit'] == "C"){
			$data['B83'] = '&deg;C';
			$data['C83'] = $data['B21'];
			$data['E83'] = $data['B21'];

			$data['B97'] = '&deg;C';
			$data['C97'] = ($data['C96']-32)*5/9;
			$data['E97'] = ($data['E96']-32)*5/9;
		}			

		$data['B113'] = '';
		$data['C113'] = 0;
		$data['E113'] = 0;
		if ($inputs['coolant_inlet_temperature_unit'] == "C"){
			$data['B113'] = '&deg;C';
			$data['C113'] = ($data['C112']-32)*5/9;
			$data['E113'] = ($data['E112']-32)*5/9;
		}

		$data['B91'] = $inputs['label_inlet_pressure_unit'];


		$tdata = $this->getB108($data, $inputs);
		$data['B108'] = $tdata['B108'];
		$data['C108'] = $tdata['C108'];
		$data['E108'] = $tdata['E108'];

		//***TODO e76 and the fucking vbscript programming review******
		if(isset($data['C86'])) $data['C86'] = number_format($data['C86'],2, '.', '');
		if(isset($data['E86'])) $data['E86'] = number_format($data['E86'],2, '.', '');

		if(isset($data['C72'])) $data['C72'] = number_format($data['C72'],2, '.', '');
		if(isset($data['E72'])) $data['E72'] = number_format($data['E72'],2, '.', '');

		if(isset($data['C74'])) $data['C74'] = number_format($data['C74'],2, '.', '');
		if(isset($data['E74'])) $data['E74'] = number_format($data['E74'],2, '.', '');

		if(isset($data['C75'])) $data['C75'] = number_format($data['C75'],2, '.', '');
		if(isset($data['E75'])) $data['E75'] = number_format($data['E75'],2, '.', '');

		if(isset($data['C76'])) $data['C76'] = number_format($data['C76'],2, '.', '');
		if(isset($data['E76'])) $data['E76'] = number_format($data['E76'],2, '.', '');
		
		if(isset($data['C79'])) $data['C79'] = number_format($data['C79'],2, '.', '');
		if(isset($data['C80'])) $data['C80'] = number_format($data['C80'],2, '.', '');
		if(isset($data['E79'])) $data['E79'] = number_format($data['E79'],2, '.', '');
		if(isset($data['E80'])) $data['E80'] = number_format($data['E80'],2, '.', '');


		if(isset($data['C91'])) $data['C91'] = number_format($data['C91'],2, '.', '');
		if(isset($data['E91'])) $data['E91'] = number_format($data['E91'],2, '.', '');

		if(isset($data['C96'])) $data['C96'] = number_format($data['C96'],2, '.', '');
		if(isset($data['E96'])) $data['E96'] = number_format($data['E96'],2, '.', '');

		if(isset($data['C97'])) $data['C97'] = number_format($data['C97'],2, '.', '');
		if(isset($data['E97'])) $data['E97'] = number_format($data['E97'],2, '.', '');

		if(isset($data['C105'])) $data['C105'] = number_format($data['C105'],2, '.', '');
		if(isset($data['E105'])) $data['E105'] = number_format($data['E105'],2, '.', '');

		if(isset($data['C100'])) $data['C100'] = number_format($data['C100'],2, '.', '');
		if(isset($data['E100'])) $data['E100'] = number_format($data['E100'],2, '.', '');

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


		$data['test1'] = $inputs['inlet_pressure'];//144*$inputs['cp_cv'];
		$data['test2'] = pow(($data['B35']/$data['B30']),$data['I19']);
		$data['test3'] = 33000*($inputs['cp_cv']-1);
		$data['test4'] = $data['B30']*$data['I64']*(300/$data['I60']);



		$data['graphInput1'] = $this->getJ97($inputs, $data);
		$data['graphInput2'] = $this->getK58($inputs, $data);

		$graphInput11 = $data['graphInput1']['J'];
		$graphInput12 = $data['graphInput1']['Q'];
		$graphInput13 = $data['graphInput1']['S'];
		$graphInput14 = $data['graphInput1']['N'];

		$graphInput21 = $data['graphInput2']['K'];
		$graphInput22 = $data['graphInput2']['Q'];
		$graphInput23 = $data['graphInput2']['S'];

		//get file name from random
        $datetime = new \DateTime(); 
        $fileName1 = 'graph1'.$datetime->format('YmdHis').'.png';
        $fileName2 = 'graph2'.$datetime->format('YmdHis').'.png';
        $fileName3 = 'graph3'.$datetime->format('YmdHis').'.png';

        //combine the file name with assets/images folder


        ///// WINDOWS file system
		/*        $theImage1 = public_path().'\assets\images\\'.$fileName1;
		        $theImage2 = public_path().'\assets\images\\'.$fileName2;
		        $theImage3 = public_path().'\assets\images\\'.$fileName3;

		*/      

        ///// UNIX file system
		$theImage1 = public_path().'/assets/images/'.$fileName1;
        $theImage2 = public_path().'/assets/images/'.$fileName2;
        $theImage3 = public_path().'/assets/images/'.$fileName3;

        //draw the graph based on the scatter graph data and output it to the file name
		$this->drawTheGraph($graphInput11,$graphInput12,$graphInput13,$theImage1,"Discharge Pressure [PSIG]","Brake Horse Power","Capacity [SCFM]");
		$this->drawTheGraph2($graphInput21,$graphInput22,$graphInput23,$theImage2,"Speed [RPM]","Brake Horse Power","Capacity [SCFM]");
		$this->drawTheGraph3($graphInput11,$graphInput14,$theImage3,"Discharge Pressure [PSIG]","Efficiency");

		//anothe file name to feed the URL::assett();
		$fileNameA1 = 'assets/images/'.$fileName1;
		$fileNameA2 = 'assets/images/'.$fileName2;
		$fileNameA3 = 'assets/images/'.$fileName3;

		//set image path/s for pdf output, need the public path for the images to show on pdf, img tag is added to the output file template;
		$data['image1'] =$theImage1;
		$data['image2'] =$theImage2;
		$data['image3'] =$theImage3;

		//if html output mode
		if (isset($inputs['submit2'])){
			$data['datavalues'] ='';
			//set image path/s for html output, strip all public path and use asset;
			$data['image1'] ='<img src="'.\URL::asset($fileNameA1).'"/>';
			$data['image2'] ='<img src="'.\URL::asset($fileNameA2).'"/>';
			$data['image3'] ='<img src="'.\URL::asset($fileNameA3).'"/>';

			return view('output/results', $data);			
		}

		//if pdf output mode;
		$tHtml = view('output/resultspdf', $data);
		$pdf = \PDF::loadHTML($tHtml);
		return $pdf->stream();
	}

	public function drawTheGraph($data1,$data2,$data3,$theImage,$data1Label, $data2Label, $data3Label){
			require_once app_path()."/libraries/pChart/class/pData.class.php";
			require_once app_path()."/libraries/pChart/class/pDraw.class.php";
			require_once app_path()."/libraries/pChart/class/pImage.class.php";
			require_once app_path()."/libraries/pChart/class/pScatter.class.php";

			$myData = new \pData();  

			/* Create the X axis and the binded series */
			$myData->addPoints($data1,$data1Label); 
			$myData->addPoints($data2,$data2Label); 
			$myData->addPoints($data3,$data3Label); 

			//set the x-axis
			$myData->setAxisName(0,$data1Label);
			$myData->setAxisXY(0,AXIS_X);
			$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);

			/* Create the Y axis and the binded series */
			$myData->setSerieOnAxis($data3Label,1);
			$myData->setAxisName(1,$data3Label);
			$myData->setAxisXY(1,AXIS_Y);
			$myData->setAxisPosition(1,AXIS_POSITION_LEFT);

			$myData->setSerieOnAxis($data2Label,2);
			$myData->setAxisName(2,$data2Label);
			$myData->setAxisXY(2,AXIS_Y);
			$myData->setAxisPosition(2,AXIS_POSITION_RIGHT);


			/* Create the 1st scatter chart binding */
			$myData->setScatterSerie($data1Label,$data3Label,0);
			$myData->setScatterSerieDescription(0,$data3Label);

			/* Create the 2nd scatter chart binding */
			$myData->setScatterSerie($data1Label,$data2Label,1);
			$myData->setScatterSerieDescription(1,$data2Label);

			/* Create the pChart object */
			$myPicture = new \pImage(650,650,$myData);

			/* Set the default font */
			$myPicture->setFontProperties(array("FontName"=> app_path()."/libraries/pChart/fonts/pf_arma_five.ttf","FontSize"=>6));

			/* Set the graph area */
			$myPicture->setGraphArea(50,50,600,600);

			/* Create the Scatter chart object */
			$myScatter = new \pScatter($myPicture,$myData);

			/* Draw the scale */
			$myScatter->drawScatterScale();

			/* Draw a scatter plot chart */
			$myScatter->drawScatterLineChart();

			/* Draw the legend */
			$myScatter->drawScatterLegend(280,380,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER));
			/* Render the picture (choose the best way) */
			$myPicture->render($theImage);

			return true;
	}	

	public function drawTheGraph2($data1,$data2,$data3,$theImage,$data1Label, $data2Label, $data3Label){
			require_once app_path()."/libraries/pChart/class/pData.class.php";
			require_once app_path()."/libraries/pChart/class/pDraw.class.php";
			require_once app_path()."/libraries/pChart/class/pImage.class.php";
			require_once app_path()."/libraries/pChart/class/pScatter.class.php";

			$myData = new \pData();  

			/* Create the X axis and the binded series */
			$myData->addPoints($data1,$data1Label); 
			$myData->addPoints($data2,$data2Label); 
			$myData->addPoints($data3,$data3Label); 

			//set the x-axis
			$myData->setAxisName(0,$data1Label);
			$myData->setAxisXY(0,AXIS_X);
			$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);

			/* Create the Y axis and the binded series */
			$myData->setSerieOnAxis($data3Label,1);
			$myData->setAxisName(1,$data3Label);
			$myData->setAxisXY(1,AXIS_Y);
			$myData->setAxisPosition(1,AXIS_POSITION_LEFT);

			$myData->setSerieOnAxis($data2Label,2);
			$myData->setAxisName(2,$data2Label);
			$myData->setAxisXY(2,AXIS_Y);
			$myData->setAxisPosition(2,AXIS_POSITION_RIGHT);


			/* Create the 1st scatter chart binding */
			$myData->setScatterSerie($data1Label,$data3Label,0);
			$myData->setScatterSerieDescription(0,$data3Label);

			/* Create the 2nd scatter chart binding */
			$myData->setScatterSerie($data1Label,$data2Label,1);
			$myData->setScatterSerieDescription(1,$data2Label);

			/* Create the pChart object */
			$myPicture = new \pImage(650,650,$myData);

			/* Set the default font */
			$myPicture->setFontProperties(array("FontName"=> app_path()."/libraries/pChart/fonts/pf_arma_five.ttf","FontSize"=>6));

			/* Set the graph area */
			$myPicture->setGraphArea(50,50,600,600);

			/* Create the Scatter chart object */
			$myScatter = new \pScatter($myPicture,$myData);

			/* Draw the scale */
			$myScatter->drawScatterScale();

			/* Draw a scatter plot chart */
			$myScatter->drawScatterLineChart();

			/* Draw the legend */
			$myScatter->drawScatterLegend(280,380,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER));
			/* Render the picture (choose the best way) */
			$myPicture->render($theImage);

			return true;
	}	

	public function drawTheGraph3($data1,$data2,$theImage,$data1Label, $data2Label){
			require_once app_path()."/libraries/pChart/class/pData.class.php";
			require_once app_path()."/libraries/pChart/class/pDraw.class.php";
			require_once app_path()."/libraries/pChart/class/pImage.class.php";
			require_once app_path()."/libraries/pChart/class/pScatter.class.php";

			$myData = new \pData();  

			/* Create the X axis and the binded series */
			$myData->addPoints($data1,$data1Label); 
			$myData->addPoints($data2,$data2Label); 

			//set the x-axis
			$myData->setAxisName(0,$data1Label);
			$myData->setAxisXY(0,AXIS_X);
			$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);

			/* Create the Y axis and the binded series */
			$myData->setSerieOnAxis($data2Label,1);
			$myData->setAxisName(1,$data2Label);
			$myData->setAxisXY(1,AXIS_Y);
			$myData->setAxisPosition(1,AXIS_POSITION_LEFT);

			/* Create the 1st scatter chart binding */
			$myData->setScatterSerie($data1Label,$data2Label,0);
			$myData->setScatterSerieDescription(0,$data2Label);

			/* Create the pChart object */
			$myPicture = new \pImage(650,650,$myData);

			/* Set the default font */
			$myPicture->setFontProperties(array("FontName"=> app_path()."/libraries/pChart/fonts/pf_arma_five.ttf","FontSize"=>6));

			/* Set the graph area */
			$myPicture->setGraphArea(50,50,600,600);

			/* Create the Scatter chart object */
			$myScatter = new \pScatter($myPicture,$myData);

			/* Draw the scale */
			$myScatter->drawScatterScale();

			/* Draw a scatter plot chart */
			$myScatter->drawScatterLineChart();

			/* Draw the legend */
			$myScatter->drawScatterLegend(280,380,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER));
			/* Render the picture (choose the best way) */
			$myPicture->render($theImage);

			return true;
	}		

	//Debug purposes
	public function dwLog($key, $value){
		\Log::info($key .' = '.$value);						
	}


	function fillSizing($newSizing, $inputs)	{
		$newSizing->calculations_performed_by = $inputs['calculations_performed_by'];
		$newSizing->customer  = $inputs['customer'];
		$newSizing->reference = $inputs['reference'];
		
		$newSizing->label_pressure_or_elevation = $inputs['label_pressure_or_elevation'];
		$newSizing->label_product_type = $inputs['label_product_type'];
		$newSizing->label_gas_inlet_temperature = $inputs['label_gas_inlet_temperature'];
		$newSizing->label_volumetric_or_mass = $inputs['label_volumetric_or_mass'];
		$newSizing->label_coolant_temperature = $inputs['label_coolant_temperature'];

		$newSizing->ambient_pressure_or_elevation = $inputs['ambient_pressure_or_elevation'];
		$newSizing->volumetric_or_mass  = $inputs['volumetric_or_mass'];
		$newSizing->volumetric_flowrate_unit  = $inputs['volumetric_flowrate_unit'];
		$newSizing->mass_flowrate_unit  = $inputs['mass_flowrate_unit'];
		$newSizing->product_inlet_temperature_unit  = $inputs['product_inlet_temperature_unit'];
		$newSizing->coolant_inlet_temperature_unit  = $inputs['coolant_inlet_temperature_unit'];
		$newSizing->inlet_pressure_unit = $inputs['inlet_pressure_unit'];
		$newSizing->discharge_pressure_unit = $inputs['discharge_pressure_unit'];
		$newSizing->b86 = $inputs['B86'];
		$newSizing->b17 = $inputs['molecular_weight'];
		$newSizing->b30_raw = $inputs['B30_raw'];
		$newSizing->c86 = $inputs['C86'];
		$newSizing->e86 = $inputs['E86'];
		$newSizing->a118  = $inputs['A118'];
		$newSizing->l3  = $inputs['L3'];
		$newSizing->m3  = $inputs['M3'];
		$newSizing->elevation = $inputs['elevation'];
		$newSizing->ambient_pressure  = $inputs['ambient_pressure'];
		$newSizing->ambient_pressure_unit = $inputs['ambient_pressure_unit'];
		$newSizing->name_of_gas = $inputs['name_of_gas'];
		$newSizing->molecular_weight  = $inputs['molecular_weight'];
		$newSizing->specific_gravity  = $inputs['specific_gravity'];
		$newSizing->cp_cv = $inputs['cp_cv'];
		$newSizing->gas_inlet_temperature  = $inputs['gas_inlet_temperature'];
		$newSizing->inlet_temperature = $inputs['inlet_temperature'];
		$newSizing->b23 = $inputs['B23'];
		$newSizing->gas_inlet_pressure  = $inputs['gas_inlet_pressure'];
		$newSizing->label_inlet_pressure_unit = $inputs['label_inlet_pressure_unit'];
		$newSizing->inlet_pressure  = $inputs['inlet_pressure'];
		$newSizing->b30 = $inputs['B30'];
		$newSizing->gas_discharge_pressure  = $inputs['gas_discharge_pressure'];
		$newSizing->label_discharge_pressure_unit = $inputs['label_discharge_pressure_unit'];
		$newSizing->discharge_pressure  = $inputs['discharge_pressure'];
		$newSizing->compression_ratio = $inputs['compression_ratio'];
		$newSizing->flowrate  = $inputs['flowrate'];

		if (isset($inputs['partial_pressure']))
			$newSizing->partial_pressure  = $inputs['partial_pressure'];
		$newSizing->compressor_flow_capacity  = $inputs['compressor_flow_capacity'];
		$newSizing->coolant_temperature = $inputs['coolant_temperature'];
		$newSizing->coolant_inlet_temperature = $inputs['coolant_inlet_temperature'];
		$newSizing->booster_select  = $inputs['booster_select'];
		$newSizing->manual_selection  = $inputs['manual_selection'];
		$newSizing->speed_fixed_or_not  = $inputs['speed_fixed_or_not'];
		$newSizing->fixed_speed = $inputs['fixed_speed'];		
	}


	public function saveSizing(){
		$inputs = \Request::input();
		$newSizing = new Sizing;
		$this->fillSizing($newSizing, $inputs);
		$newSizing->save();
		echo 'data saved';
	}

	public function updateSizing(){
		$inputs = \Request::input();
		$newSizing = Sizing::findOrFail($inputs['tid']);
		$this->fillSizing($newSizing, $inputs);
		$newSizing->save();
		echo 'data saved';
	}	

	public function load(){	
		$sizings = Sizing::paginate(5);
		return view('maindialogs/load', ['sizings' => $sizings]);
	}

	public function loadThisOne($id){	
		$sizing = Sizing::findOrFail($id);

		$available_sizes1 = \DB::table('Compressordatabases')->select('size')->distinct()->get(); 

		foreach ($available_sizes1 as $value)
			$available_sizes["$value->size"] = $value->size;

		return view('maindialogs/edit', 
			array(
			'sizing' => $sizing,
			'editMode' => 'edit',
			'label_pressure_or_elevation' => $sizing->label_pressure_or_elevation,
			'ambient_pressure_or_elevation' => $sizing->ambient_pressure_or_elevation,
			'volumetric_or_mass' => $sizing->volumetric_or_mass,
			'volumetric_flowrate_unit' => $sizing->volumetric_flowrate_unit,
			'mass_flowrate_unit' => $sizing->mass_flowrate_unit,
			'product_inlet_temperature_unit' => $sizing->product_inlet_temperature_unit,
			'coolant_inlet_temperature_unit' => $sizing->coolant_inlet_temperature_unit,
			'inlet_pressure_unit' => $sizing->inlet_pressure_unit,
			'discharge_pressure_unit' => $sizing->discharge_pressure_unit,
			'B17' => $sizing->b17,
			'B30_raw' => $sizing->b30_raw,
			'B86' => $sizing->b86,
			'C86' => $sizing->c86,
			'E86' => $sizing->e86,
			'A118' => $sizing->a118,
			'L3_3_12' => $sizing->l3,
			'M3' => $sizing->m3,
			'B11' => $sizing->b11,
			'label_pressure_or_elevation_unit' => $sizing->label_pressure_or_elevation_unit,
			'B13' => $sizing->ambient_pressure,
			'ambient_pressure_unit' => $sizing->ambient_pressure_unit,
			'label_product_type' => $sizing->label_product_type,
			'B16' => $sizing->name_of_gas,
			'B18' => $sizing->specific_gravity,
			'B19' => $sizing->cp_cv,
			'B21' => $sizing->gas_inlet_temperature,
			'label_gas_inlet_temperature' => $sizing->label_gas_inlet_temperature,
			'B23' => $sizing->b23,
			'B27' => $sizing->gas_inlet_pressure,
			'label_inlet_pressure_unit' => $sizing->label_inlet_pressure_unit,
			'B30' => $sizing->b30,
			'B32' => $sizing->gas_discharge_pressure,
			'label_discharge_pressure_unit' => $sizing->label_discharge_pressure_unit,
			'B35' => $sizing->discharge_pressure,
			'B36' => $sizing->compression_ratio,
			'B39' => $sizing->flowrate,
			'label_volumetric_or_mass' => $sizing->label_volumetric_or_mass,
			'B41' => $sizing->partial_pressure,
			'B42' => $sizing->compressor_flow_capacity,
			'B44' => $sizing->coolant_temperature,
			'label_coolant_temperature' => $sizing->label_coolant_temperature,
			'B46' => $sizing->coolant_inlet_temperature,
			'available_sizes' => $available_sizes,
			)
		);
	}
}

/*		echo '<hr>';
		foreach ($dataManual as $key => $value)
			echo $key.' = '.$value.'<br>';
		echo '<hr>';
		foreach ($data as $key => $value)
			echo $key.' = '.$value.'<br>';*/
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
		echo 'K89='.$data['K89'].'<br>';

		echo '<hr>';
		foreach ($inputs as $key => $value)
			$data['inputs'] .= $key.' = '.$value.'<br>';

		echo $data['inputs'];
*/
/*
$inputs['ambient_pressure_or_elevation'] = ambient_pressure_pressed<br>
$inputs['ambient_pressure_unit'] = HGa<br>
$inputs['elevation_unit'] = ft<br>
$inputs['volumetric_flowrate_unit'] = scfm<br>
$inputs['mass_flowrate_unit'] = lbhr<br>
$inputs['volumetric_or_mass'] = volumetric_pressed<br>
$inputs['product_type'] = Air<br>
$inputs['product_inlet_temperature_unit'] = F<br>
$inputs['coolant_inlet_temperature_unit'] = F<br>
$inputs['inlet_pressure_unit'] = psig<br>
$inputs['discharge_pressure_unit'] = psig<br>
ok = <br>

	\Log::info('psia raw = '. $unitsOneDefaults['psia']);

*/