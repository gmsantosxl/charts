<?php
namespace Pcm\Charts\Traits;

/**
 * Description of StakedTrait
 *
 * @author gamacsan
 */
trait StackedMultiSeriesTrait
{

	protected $datasets = array();

	protected $datasetParams = array();

	private $isMainDatasetInitialized = false;

	public function setDataSet($dataSet)
	{
		$this->datasets = $dataSet;
	}

	public function setDataSetParams($dataSetParams)
	{
		$this->datasetParams = $dataSetParams;
	}

	public function builtMsStackedDataseries($dataArray, $datasets, $datasetParams)
	{
		foreach ($datasets as $key => $datasetName)
		{
			// Make sure this dataset has params to inject
			$datasetConfig = isset($datasetParams[$key]) ? $datasetParams[$key] : array();
			
			if (isset($datasetConfig['renderAs']) && $datasetConfig['renderAs'] == 'line')
			{
				unset($datasetConfig['renderAs']);
				$this->chartLib->addDatasetMSLine($datasetName, $datasetConfig);
			}
			else
			{
				$this->initializeMainDataset();
				$this->chartLib->addSubDatasetMS($datasetName, $datasetConfig);
			}
			
			foreach ($dataArray[$key] as $value)
			{
				$this->chartLib->addChartData($value);
			}
		}
	}

	private function initializeMainDataset()
	{
		if (! $this->isMainDatasetInitialized)
		{
			$this->chartLib->createMSStDataset();
			$this->isMainDatasetInitialized = true;
		}
	}
}