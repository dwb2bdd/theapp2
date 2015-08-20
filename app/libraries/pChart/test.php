<?php   
 /* CAT:Scatter chart */

 /* pChart library inclusions */
 include("class/pData.class.php");
 include("class/pDraw.class.php");
 include("class/pImage.class.php");
 include("class/pScatter.class.php");

 /* Create the pData object */
 $myData = new pData();  

 /* Create the X axis and the binded series */
 $myData->addPoints(array(1,2,4,6,19,20,21),"Probe 1"); 
 $myData->addPoints(array(100,200,400,600,1900,2000,2100),"Probe 2"); 
 $myData->setAxisName(0,"Index");
 $myData->setAxisXY(0,AXIS_X);
 $myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);

 /* Create the Y axis and the binded series */
 $myData->addPoints(array(10,20,40,60,190,200,210),"Probe 3"); 
 
 $myData->setSerieOnAxis("Probe 3",1);
 $myData->setAxisName(1,"Degree");
 $myData->setAxisXY(1,AXIS_Y);
 $myData->setAxisPosition(1,AXIS_POSITION_LEFT);

 $myData->setSerieOnAxis("Probe 2",2);
 $myData->setAxisName(2,"Degree");
 $myData->setAxisXY(2,AXIS_Y);
 $myData->setAxisPosition(2,AXIS_POSITION_RIGHT);


 /* Create the 1st scatter chart binding */
 $myData->setScatterSerie("Probe 2","Probe 1",0);
 $myData->setScatterSerieDescription(0,"This year");
 $myData->setScatterSerieTicks(0,4);
 $myData->setScatterSerieColor(0,array("R"=>0,"G"=>0,"B"=>0));

 /* Create the 2nd scatter chart binding */
 $myData->setScatterSerie("Probe 2","Probe 3",1);
 $myData->setScatterSerieDescription(1,"Last Year");

 /* Create the pChart object */
 $myPicture = new pImage(400,400,$myData);

 /* Set the default font */
 $myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>6));
 
 /* Set the graph area */
 $myPicture->setGraphArea(50,50,350,350);

 /* Create the Scatter chart object */
 $myScatter = new pScatter($myPicture,$myData);

 /* Draw the scale */
 $myScatter->drawScatterScale();

 /* Draw a scatter plot chart */
 $myScatter->drawScatterLineChart();

 /* Draw the legend */
 $myScatter->drawScatterLegend(280,380,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER));

 /* Render the picture (choose the best way) */
 $myPicture->autoOutput("pictures/example.drawScatterLineChart.png");
?>