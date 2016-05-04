<?php
/**
* 
*/
class SWIFT_cm_TFS_Helper extends SWIFT_Library
{

	/**
	 * The baseline path of the TFS Collection
	 * @var string
	 */
	protected $tfs_url = "http://ddtfsapp01:8080/tfs/TFSCollection/CacheMatrixPlatform_Baseline";
	
	public function __construct()
	{
		parent::__construct();
		return true;
	}

	public function __destruct()
	{
		parent::__destruct();
		return true;
	}

	/**
	 * Return the TFS installation URL
	 * @return string $tfs_url
	 */
	public function getURL()
	{
		return $this->tfs_url;
	}
}