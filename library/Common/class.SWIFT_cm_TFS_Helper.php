<?php
/**
* 
*/
class SWIFT_cm_TFS_Helper extends SWIFT_Library
{

	protected $_UI;
	
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

	public function getInterface()
	{
		return $this->UserInterface;
	}

    public function loadTab( SWIFT_Ticket $_SWIFT_TicketObject , $linked = false )
    {
    	if (!$linked) {
    		$_TFSTabObject = $this->UserInterface->AddTab("TFS POC", 'icon_ticketreply.png', 'cm_TFS_POC', false, false, 4 );
    		$_TFSTabObject->LoadToolbar();
			$_TFSTabObject->Toolbar->AddButton("Link to TFS", 'icon_check.gif', '/Tickets/Ticket/ReplySubmit/' . $_SWIFT_TicketObject->GetTicketID() . '/', SWIFT_UserInterfaceToolbar::LINK_FORM);
			$_TFSTabObject->Title( $this->Language->Get('cm_TFS_name'), 'doublearrows.gif' );
			$_TFSTabObject->Description( $this->Language->Get('cm_TFS_description') );
			$_TFSTabObject->Number( 'tfs_id' , $this->Language->Get('cm_TFS_input') );
    	} else {
    		$_TFSTabObject = $this->UserInterface->AddTab("TFS POC", 'icon_ticketreply.png', 'cm_TFS_POC', false, false, 4, SWIFT::Get('basename') . '/cm_TFS/cm_TFS/renderTFSTab/' . $_SWIFT_TicketObject->GetTicketID() );
    	}
    	
    	
    }
}