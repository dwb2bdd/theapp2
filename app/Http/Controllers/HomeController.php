<?php namespace App\Http\Controllers;
use Auth;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user();

		if ($user->activated == '1')
			return view ('home');
		else{
			Auth::logout();
			return view('auth/login')->with('regsuccess', 
				'Access Request sent succesfully. We will review and get back to you as soon as possible');
		}
	}

	public function dwpdf()	{
		$data1 = \App\Bhpvsspeed::lists('speed'); 
		$data2 = \App\Bhpvsspeed::lists('brake_hp'); 
		$data3 = \App\Bhpvsspeed::lists('scfm'); 		

		//get file name from random
        $datetime = new \DateTime(); 
        $fileName = 'imagefile-'.$datetime->format('Y-m-d--H-i-s').'.png';

        //combine the file name with assets/images folder
        $theImage = public_path().'\assets\images\\'.$fileName;

        //draw the graph based on the scatter graph data and output it to the file name
		$this->drawTheGraph($data1,$data2,$data3,$theImage);

		//anothe file name to feed the URL::assett();
		$fileName2 = 'assets/images/'.$fileName;

		//create pdf;
//            $pdf = App::make('dompdf');

		//echo '<h1>Test</h1>'.'<img src="'.URL::asset($fileName2).'"/>';	
		$tHtml ='<h1>Test</h1>'.'<img src="'.$theImage.'"/>';		

		$pdf = \PDF::loadHTML($tHtml);
		return $pdf->stream();		
	}	

	public function drawTheGraph($data1,$data2,$data3,$theImage){
			require_once app_path()."/libraries/pChart/class/pData.class.php";
			require_once app_path()."/libraries/pChart/class/pDraw.class.php";
			require_once app_path()."/libraries/pChart/class/pImage.class.php";
			require_once app_path()."/libraries/pChart/class/pScatter.class.php";
			$myData = new \pData();  

			/* Create the X axis and the binded series */
			$myData->addPoints($data1,"Speed"); 
			$myData->addPoints($data2,"Brake HP"); 
			$myData->addPoints($data3,"SCFM"); 

			//set the x-axis
			$myData->setAxisName(0,"Speed");
			$myData->setAxisXY(0,AXIS_X);
			$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);

			/* Create the Y axis and the binded series */
			$myData->setSerieOnAxis("SCFM",1);
			$myData->setAxisName(1,"SCFM");
			$myData->setAxisXY(1,AXIS_Y);
			$myData->setAxisPosition(1,AXIS_POSITION_LEFT);

			$myData->setSerieOnAxis("Brake HP",2);
			$myData->setAxisName(2,"Brake HP");
			$myData->setAxisXY(2,AXIS_Y);
			$myData->setAxisPosition(2,AXIS_POSITION_RIGHT);


			/* Create the 1st scatter chart binding */
			$myData->setScatterSerie("Speed","SCFM",0);
			$myData->setScatterSerieDescription(0,"This year");

			/* Create the 2nd scatter chart binding */
			$myData->setScatterSerie("Speed","Brake HP",1);
			$myData->setScatterSerieDescription(1,"Last Year");

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

}