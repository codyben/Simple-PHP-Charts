<?php
namespace codyben;

/**
 * Class SimplePHPChart
 * @package codyben
 * @version 1.0
 */

class SimplePHPChart {

	/**
	 * @var float
	 */
	private $shiftX;

	/**
	 * @var float
	 */
	private $shiftY;

	/**
	 * @var array
	 */
	private $xValues;

	/**
	 * @var array
	 */
	private $yValues;

	/**
	 * @var int
	 */
	private $sizeX;

	/**
	 * @var int
	 */
	private $sizeY;

	private $colorAxisY;

	private $colorAxisX;

	private $colorTickY;

	private $colorTickX;

	private $colorBackground;

	private $colorPoints;

	private $im;

	/**
	 * @var bool
	 */
	private $isRangeX;

	/**
	 * @var int
	 */
	private $rangeXLow = 0;

	/**
	 * @var int
	 */
	private $rangeYLow = 0;

	/**
	 * @var int
	 */
	private $rangeXHigh = 0;

	/**
	 * @var int
	 */
	private $rangeYHigh = 0;

	/**
	 * @var bool
	 */
	private $isRangeY;

	/**
	 * @var bool
	 */
	public $gridLines;

	/**
	 * @var float
	 */
	private $domain;

	/**
	 * @var float
	 */
	private $range;

	/**
	 * @var float
	 */
	private $scaleX;

	/**
	 * @var float
	 */
	private $scaleY;

	/**
	 * @var int
	 */
	private $originX;

	/**
	 * @var int
	 */
	private $originY;

	/**
	 * @var bool
	 */
	private $ticks;

	/**
	 * Initialize the chart with its dimensions in pixels.
	 * @param int $x 
	 * @param int $y 
	 * @param bool|bool $ticks 
	 */
	function __construct(int $x, int $y, bool $ticks = true)
	{
		$this->ticks = $ticks;

		$this->sizeX = $x;
		$this->sizeY = $y;
		$this->imageName = "chart.png";
		$this->im = imagecreatetruecolor($x, $y);

		//Assign default colors
		$this->colorTickY = imagecolorallocate($this->im, 255, 255, 255); //white
		$this->colorTickX = imagecolorallocate($this->im, 255, 255, 255); //white
		$this->colorAxisY = imagecolorallocate($this->im, 255,215,0); //gold
		$this->colorAxisX = imagecolorallocate($this->im, 255, 215, 0); //gold
		$this->colorBackground = imagecolorallocate($this->im, 0, 0, 0); //black
		$this->colorPoints = imagecolorallocate($this->im, 0,128,0); //green
		imagefill($this->im, 0, 0, $this->colorBackground);
	}

	/**
	 * Destroys the image when object falls out of scope.
	 * @return type
	 */
	function __destruct()
	{
		imagedestroy($this->im);
	}

	/**
	 * Draws the x & y axis. Draws from 0px to end.
	 * @return void
	 */
	private function drawAxis() : void
	{
		imageline($this->im, 0 , $this->shiftY , $this->sizeX , $this->shiftY, $this->colorAxisX);
		imageline($this->im, $this->shiftX , 0 , $this->shiftX, $this->sizeY , $this->colorAxisX);
	}

	/**
	 * Scales all x values in terms of chart size.
	 * @return void
	 */
	private function scaleX() : void
	{
		$this->domain = abs($this->rangeXLow) + abs($this->rangeXHigh);

		$this->scaleX = ((float)$this->sizeX / $this->domain);
		$this->originX = $this->sizeX >> 1;
		
	}

	/**
	 * Scales all y values in terms of chart size.
	 * @return void
	 */
	private function scaleY() : void 
	{
		$this->range = abs($this->rangeYLow) + abs($this->rangeYHigh);

		$this->scaleY = ((float)$this->sizeY / $this->range);
		$this->originY = $this->sizeY >> 1;
	}

	/**
	 * Set the extent of the domain.
	 * @param int $low 
	 * @param int $high 
	 * @return void
	 */
	public function setDomain(int $low, int $high) : void
	{
		$this->isRangeX = true;
		$this->rangeXHigh = $high;
		$this->rangeXLow = $low;

	}

	/**
	 * Set the extent of the range.
	 * @param int $low 
	 * @param int $high 
	 * @return void
	 */
	public function setRange(int $low, int $high) : void
	{
		$this->isRangeY = true;
		$this->rangeYHigh = $high;
		$this->rangeYLow = $low;

	}

	/**
	 * Set the color of the x axis.
	 * @param int $r 
	 * @param int $g 
	 * @param int $b 
	 * @return void
	 */
	public function setColorAxisX(int $r, int $g, int $b) : void
	{
		$this->colorAxisX =imagecolorallocate($this->m, $r, $g, $b);
	}

	/**
	 * Set the color of the y axis.
	 * @param int $r 
	 * @param int $g 
	 * @param int $b 
	 * @return void
	 */
	public function setColorAxisY(int $r, int $g, int $b) : void
	{
		$this->colorAxisY = imagecolorallocate($this->im, $r, $g, $b);
	}

	/**
	 * Set the color of the y axis tick marks
	 * @param int $r 
	 * @param int $g 
	 * @param int $b 
	 * @return void
	 */
	public function setColorTickY(int $r, int $g, int $b) : void
	{
		$this->colorTickY = imagecolorallocate($this->im, $r, $g, $b);
	}

	/**
	 * Set the color of the x axis tick marks
	 * @param int $r 
	 * @param int $g 
	 * @param int $b 
	 * @return void
	 */
	public function setColorTickX(int $r, int $g, int $b) : void
	{
		$this->colorTickX = imagecolorallocate($this->im, $r, $g, $b);
	}

	/**
	 * Set the chart background color.
	 * @param int $r 
	 * @param int $g 
	 * @param int $b 
	 * @return void
	 */
	public function setColorBackground(int $r, int $g, int $b) : void
	{
		$this->colorBackground = imagecolorallocate($this->im, $r, $g, $b);
		imagefill($this->im, 0, 0, $this->colorBackground);
	}

	/**
	 * Set the color of plotted data points.
	 * @param int $r 
	 * @param int $g 
	 * @param int $b 
	 * @return void
	 */
	public function setColorPoints(int $r, int $g, int $b) : void
	{
		$colorPoints = imagecolorallocate($im, $r, $g, $b);
	}

	/**
	 * Create an (x,y) pair to be plotted.
	 * @param int $x 
	 * @param int $y 
	 * @return void
	 */
	public function setPoint(int $x, int $y ) : void
	{
		if($x > $this->rangeXHigh)
			$this->rangeXHigh = $x;
		elseif ($x < $this->rangeXLow) 
			$this->rangeXLow = $x;

		if($y > $this->rangeYHigh)
			$this->rangeYHigh = $y;
		elseif ($y < $this->rangeYLow) 
			$this->rangeYLow = $y;

		$this->xValues[] = $x;
		$this->yValues[] = $y;

	}

	/**
	 * Get number of (x,y) pairs input. Returns -1 on failure.
	 * @return int
	 */
	public function getSize() : int 
	{
		$s = count($this->xValues);

		if($s !== count($this->yValues)) //these *should* be the same, but it doesn't hurt to check
			return -1;
		else
			return $s;
	}

	/**
	 * Calculate the scaling needed to chart proportionally.
	 * @return type
	 */
	private function calcShifts() : void
	{
		$this->shiftY = $this->scaleY*abs($this->rangeYHigh);

		$this->shiftX = $this->scaleX*abs($this->rangeXLow);
	}

	/**
	 * Draw tick marks using provided / default colors.
	 * @return void
	 */
	private function makeTickMarks() : void 
	{
		$tickX = 0;

		$tickY = 0;

		if($this->ticks) {

			$tickSizeX = $this->scaleY/6;
			$tickSizeY = $this->scaleX/6;

			while($tickX <= $this->sizeX) {
				imageline($this->im, $tickX, 0-$tickSizeX+$this->shiftY, $tickX, 0+$tickSizeX+$this->shiftY, $this->colorTickX);
				$tickX += $this->scaleX;
			}

			while($tickY <= $this->sizeY) {
				imageline($this->im, 0-$tickSizeY+$this->shiftX, $tickY, 0+$tickSizeY+$this->shiftX, $tickY, $this->colorTickY);
				$tickY += $this->scaleY;
			}
		}
	}

	/**
	 * Plot all (x,y) pairs.
	 * @return void
	 */
	private function plotData() : void
	{
		$n = $this->getSize();
		if($n === -1) {
			exit();
		}

		for ($i=0; $i < $n; $i++) { 
			imagefilledellipse($this->im, $this->xValues[$i]*$this->scaleX+$this->shiftX, $this->yValues[$i]*$this->scaleY*(-1)+$this->shiftY, 10, 10, $this->colorPoints);
		}

	}

	/**
	 * Create the chart image resoucrce.
	 * @return resource
	 */
	public function makeChart()
	{
		$this->scaleX();

		$this->scaleY();

		$this->calcShifts();

		$this->drawAxis();

		$this->makeTickMarks();

		$this->plotData();

		return $this->im;

	}

}