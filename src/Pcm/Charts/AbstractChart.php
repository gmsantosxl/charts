<?php namespace Pcm\Charts;

use Illuminate\Support\Facades\Config;
use Pcm\Charts\Libraries\ChartLibraryInterface;

/**
 * Description of AbstractChart
 *
 * @author gamacsan
 */
abstract class AbstractChart implements ChartInterface{

	protected $chartLib;
	protected $chartParams = array();
	protected $xAxisLabels = array();
	protected $dataArray = array();

	public function __construct(ChartLibraryInterface $chartLib)
	{
		$this->chartLib = $chartLib;
		$this->chartParams = Config::get('charts::config');
	}

	abstract protected function prepareToRender();

	public function setDataArray($dataArray)
	{
		$this->dataArray = $dataArray;
	}
	
	public function insertTitle($title)
	{
		$this->chartParams['caption'] = $title;
	}

	public function insertSubtitle($subtitle)
	{
		$this->chartParams['subcaption'] = $subtitle;
	}

	public function setXAxisName($label)
	{
		$this->chartParams['xAxisName'] = $label;
	}

	public function setYAxisName($label)
	{
		$this->chartParams['yAxisName'] = $label;
	}

	public function setSecondYAxisName($label)
	{
		$this->chartParams['yAxisName'] = $label;
	}

	public function setChartParams(Array $params)
	{
		$this->chartParams = array_merge($this->chartParams, $params);
	}

	public function addXAxisPoints(Array $xAxisLabels)
	{
		$this->xAxisLabels = $xAxisLabels;
	}

	public function addChartData($value)
	{
		$this->chartLib->addChartData($value);
	}
	
	public function renderAsXML()
	{
		$this->prepareToRender();

		return $this->chartLib->outputXML();
	}

	public function renderAsJSON()
	{
		$this->prepareToRender();

		return $this->chartLib->outputJSON();
	}
	

}
