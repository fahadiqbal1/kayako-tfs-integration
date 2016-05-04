<?php
 
class SWIFT_SetupDatabase_cm_TFS extends SWIFT_SetupDatabase
{
	public function __construct()
	{
		parent::__construct("cm_TFS");
		return true;
	}

	public function __destruct()
	{
		parent::__destruct();
		return true;
	}

	public function Install($_pageIndex)
	{
		parent::Install($_pageIndex);
		$this->ImportSettings();
		return true;
	}

	public function Uninstall()
	{
		parent::Uninstall();
		return true;
	}

	public function Upgrade()
	{
		$this->ImportSettings();
		return parent::Upgrade();
	}

	public function LoadTables()
	{
		$this->AddTable(
			'cmTFSRef',
			new SWIFT_SetupDatabaseTable(
				TABLE_PREFIX ."_cm_TFS",
				"rowid I PRIMARY AUTOINCREMENT NOTNULL, ticketid I NOTNULL, tfsNumber I NOTNULL, createdDtTm T DEFTIMESTAMP NOTNULL"
			)
		);
		return true;
	}

	public function ImportSettings()
	{
		$this->Load->Library('Settings:SettingsManager');
		$this->SettingsManager->Import('./'SWIFT_APPSDIRECTORY.'/cm_TFS/config/settings.xml');
	}
}
 
?>