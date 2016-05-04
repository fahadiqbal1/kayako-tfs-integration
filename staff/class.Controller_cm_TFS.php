<?php
class Controller_cm_TFS extends Controller_staff{
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
	 * Load the custom tab - Called by the staff_tickets_viewtickettab hook
	 * @param  SWIFT_Ticket $_SWIFT_TicketObject The ticket object of the current ticket
	 * @return boolean                           Ture if tab is loaded
	 */
	public function loadTab( SWIFT_Ticket $_SWIFT_TicketObject )
	{
		$_SWIFT = SWIFT::GetInstance(); 
		$this->loadLanguage();
		
		if (!$this->GetIsClassLoaded())
		{
			return false;
		}

		$_linked = $this->checkIfLinked($_SWIFT_TicketObject);

		if ($_linked === false) {
			$this->View->_RenderUnLinkedTab($_SWIFT_TicketObject);
		} else {
			$this->View->_RenderLinkedTab($_SWIFT_TicketObject, $_linked);
		}

	}

	/**
	 * Link a Kayako ticket to TFS
	 * @param int $_ticketID The ticket number
	 * @param int $tfs_id POST The TFS number
	 */
	public function TFSLinkSubmit($_ticketID)
	{
		$_SWIFT = SWIFT::GetInstance(); 

		$tfs_id = $_POST['tfs_id'];
		$insert = sprintf("INSERT INTO %s_cm_tfs(ticketid, tfsNumber) VALUES('%s','%s')", TABLE_PREFIX, $_ticketID, $tfs_id);
		
		$this->Database->Query($insert);
		
		$_listType = 'inbox'; $_departmentID = -1; $_ticketStatusID = -1; $_ticketTypeID = -1; $_ticketLimitOffset = 0;
		$this->Language->Load('cm_TFS');
		$this->Load->Controller('Ticket',APP_TICKETS)->Load->Method('View', $_ticketID);
		return true;
	}

	/**
	 * Unlink the Kayako ticket from TFS
	 * @param int $_ticketID The ticket number
	 */
	public function TFSUnLinkSubmit($_ticketID)
	{
		$_SWIFT = SWIFT::GetInstance();

		$query = sprintf("DELETE FROM %s_cm_tfs WHERE ticketid = %d", TABLE_PREFIX, $_ticketID);
		$this->Database->Query($query);
		
		$this->Language->Load('cm_TFS');
		$this->Load->Controller('Ticket',APP_TICKETS)->Load->Method('View', $_ticketID);
		return true;
	}

	/**
	 * Load the locale details for app
	 * @return boolean 
	 */
	public function loadLanguage()
	{
		$_SWIFT = SWIFT::GetInstance(); 
		$_AppObject = $_SWIFT->Router->GetApp();
		$_AppName = $_AppObject->GetName();
		if ($_AppName == 'cm_tfs') {
			$this->Language->Load('cm_TFS');
		}		
		return true;
	}


	/**
	 * Check if the current ticket is linked to TFS
	 * @param  SWIFT_Ticket $_SWIFT_TicketObject The ticket object of the current ticket
	 * @return mixed                             False if unlinked, DB details if linked
	 */
	private function checkIfLinked( SWIFT_Ticket $_SWIFT_TicketObject )
	{
		$_SWIFT = SWIFT::GetInstance(); 
		$_ticketID = $_SWIFT_TicketObject->GetTicketID();

		$query = sprintf("SELECT * FROM sw_cm_tfs WHERE ticketid = %d ORDER BY createdDtTm DESC;", $_ticketID);
		$result = $_SWIFT->Database->QueryFetch($query);

		if (is_array($result) && !empty($result['ticketid'])) {
			return $result;
		} else {
			return false;
		}
	}

}
?>