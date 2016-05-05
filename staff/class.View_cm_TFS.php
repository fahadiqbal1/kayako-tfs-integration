<?php
class View_cm_TFS extends SWIFT_View{
	
	protected $helper;

	public function __construct()
	{
		parent::__construct();
		// Load the settings
			$this->Load->Library('Settings:Settings');
		// Load the Helper class and tie it to $helper
			$this->Load->Library('Common:cm_TFS_Helper', [], true, 'cm_TFS');
			$this->helper = new SWIFT_cm_TFS_Helper();
		return true;
	}
 
	public function __destruct()
	{
		parent::__destruct();
		return true;
	}
	
	/**
	 * Render the Unlinked Tab - User will be asked to input a TFS number
	 * @param  SWIFT_Ticket $_SWIFT_TicketObject The ticket object of the current ticket
	 * @return boolean                           Ture if tab is loaded
	 */
	public function _RenderUnLinkedTab( SWIFT_Ticket $_SWIFT_TicketObject )
	{
		$_SWIFT = SWIFT::GetInstance(); 

		if (!$this->GetIsClassLoaded()){
			return false;
		}

		$_TFSTabObject = $this->UserInterface->AddTab($this->Language->Get('cm_TFS_tabName'), 'icon_ticketreply.png', 'cm_TFS_tab', false, false, 4 );

		$_TFSTabObject->SetColumnWidth('15%');
		$_TFSTabObject->LoadToolbar();
		$_TFSTabObject->Toolbar->AddButton($this->Language->Get('cm_TFS_linkBtn'), 'icon_check.gif', '/cm_TFS/cm_TFS/TFSLinkSubmit/' . $_SWIFT_TicketObject->GetTicketID() . '/', SWIFT_UserInterfaceToolbar::LINK_FORM);
		$_TFSTabObject->Title( $this->Language->Get('cm_TFS_name'), 'doublearrows.gif' );
		$_TFSTabObject->Description( $this->Language->Get('cm_TFS_description') );
		$_TFSTabObject->Number( 'tfs_id' , $this->Language->Get('cm_TFS_linkInputDesc') );

		return true;
		
	}

	/**
	 * Render the Linked Tab - User will be shown TFS ticket details
	 * @param  SWIFT_Ticket $_SWIFT_TicketObject The ticket object of the current ticket
	 * @param  array        $linkDetails         The DB record of the link
	 * @return boolean                           Ture if tab is loaded
	 */
	public function _RenderLinkedTab( SWIFT_Ticket $_SWIFT_TicketObject, array $linkDetails )
	{
		$_SWIFT = SWIFT::GetInstance(); 

		if (!$this->GetIsClassLoaded()){
			return false;
		}

		$TFS_URL = $this->helper->getURL();

		$_renderHTML = "<tr><td>";
		$_renderHTML .= "";
		$_renderHTML .= "</td></tr><script> $('.disabled').attr('disabled','disabled'); </script>";

		$_TFSTabObject = $this->UserInterface->AddTab($this->Language->Get('cm_TFS_tabName'), 'icon_ticketreply.png', 'cm_TFS_tab', false, false, 4 );
		$_TFSTabObject->SetColumnWidth('15%');
		$_TFSTabObject->LoadToolbar();
		$_TFSTabObject->Toolbar->AddButton($this->Language->Get('cm_TFS_openlinkBtn'), 'icon_link.png', $TFS_URL . '/_workItems#id='.$linkDetails['tfsNumber'].'&_a=edit', SWIFT_UserInterfaceToolbar::LINK_NEWWINDOW );
		$_TFSTabObject->Toolbar->AddButton('');
		$_TFSTabObject->Toolbar->AddButton($this->Language->Get('cm_TFS_updatelinkBtn'), 'icon_edit.png', '/cm_TFS/cm_TFS/TFSLinkSubmit/' . $_SWIFT_TicketObject->GetTicketID() . '/', SWIFT_UserInterfaceToolbar::LINK_FORM);
		$_TFSTabObject->Toolbar->AddButton($this->Language->Get('cm_TFS_removelinkBtn'), 'icon_diffdelete.gif', '/cm_TFS/cm_TFS/TFSUnLinkSubmit/' . $_SWIFT_TicketObject->GetTicketID() . '/', SWIFT_UserInterfaceToolbar::LINK_FORM);
		$_TFSTabObject->Number( 'tfs_id' , $this->Language->Get('cm_TFS_linkInputDesc'), '', $linkDetails['tfsNumber'] );
		$_TFSTabObject->Title('{Workitem Title}');
		$_TFSTabObject->Text('tfs_type','Type','','{Workitem Type}','text','30',0,'','disabled');
		$_TFSTabObject->Text('tfs_area_path','Area Path','','{Workitem Area Path}','text','30',0,'','disabled');
		$_TFSTabObject->Text('tfs_iteration','Iteration Path','','{Workitem Iteration Path}','text','30',0,'','disabled');

		$_TFSTabObject->RowHTML($_renderHTML);

	}
}
?>