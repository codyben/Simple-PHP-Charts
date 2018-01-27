# Simple PHP Charts

Ever just needed to generate a chart on the fly? 
Didn't feel like using GCharts or another charting library?
Feeling _really_ minimalistic?

# _Simple PHP Charts is for you!_

  - <100 lines (comments and whitespace included!)
  - Graph as many data points as your heart desires
  - Make a graph so obnoxious with different colors, nobody will notice how minimalistic it is!

# Settings
- Settings are already included in **chart.php** to generate a chart right out of the box. 
- Set Data Points (Each X must have one Y !):
- - ```$dataPointsX = array(x1,x2,x3,x4); ```
- - ```$dataPointsY = array(y1,y2,y3,y4); ```
- Set Range:
- - ```$dataRange = array('startX'=> xLow,'startY'=> yHigh, 'endX'=> xHigh, 'endY'=> yLow);```
- Set gridlines (not implemented yet :( :
- - ```$gridLines = FALSE;```
- Set Chart Size:
- - ```$chartSize =array('x'=>xSize,'y'=>ySize); ```
- Tick Marks:
- - ```$tickMarks = TRUE;```
- Create Image: 
- - ```$im = imagecreatetruecolor(xSize, ySize);```
- Set Color Options (the fun stuff!):
- - ```$colorOptions = array(```
	```'colorTickY' => imagecolorallocate($im, 255, 255, 255), //white```
	```'colorTickX' => imagecolorallocate($im, 255, 255, 255), //white```
	```'colorAxisY' => imagecolorallocate($im, 255,215,0), //gold```
	```'colorAxisX' => imagecolorallocate($im, 255, 255, 255), //gold```
```	'colorGraphBackground' => imagecolorallocate($im, 255, 255, 0), //black```
	```'colorDataPoints' => imagecolorallocate($im, 0,128,0) //green```
```);```
- Create Chart (finally _whew!_): 
- - ```createChart($im, $colorOptions, $dataPointsX,$dataPointsY, $dataRange, $gridLines, $chartSize, $tickMarks);```
# Example
- View **example_chart.png** in the repo.



