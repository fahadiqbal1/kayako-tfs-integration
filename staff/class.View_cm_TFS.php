<?php
class View_cm_TFS extends SWIFT_View{
    public function __construct()
    {
        parent::__construct();
        $this->Load->Library('Settings:Settings');
        return true;
    }
 
    public function __destruct()
    {
        parent::__destruct();
        return true;
    }
	
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

	public function _RenderLinkedTab( SWIFT_Ticket $_SWIFT_TicketObject, array $linkDetails )
	{
		$_SWIFT = SWIFT::GetInstance(); 

		if (!$this->GetIsClassLoaded()){
			return false;
		}

		$TFS_URL = "http://ddtfsapp01:8080/tfs/TFSCollection/CacheMatrixPlatform_Baseline";

		$_renderHTML = "<tr><td>";
		$_renderHTML .= "";
		$_renderHTML .= "</td></tr>";

		$_TFSTabObject = $this->UserInterface->AddTab($this->Language->Get('cm_TFS_tabName'), 'icon_ticketreply.png', 'cm_TFS_tab', false, false, 4 );
		$_TFSTabObject->SetColumnWidth('15%');
		$_TFSTabObject->LoadToolbar();
		$_TFSTabObject->Toolbar->AddButton($this->Language->Get('cm_TFS_openlinkBtn'), 'icon_link.png', $TFS_URL . '/_workItems#id='.$linkDetails['tfsNumber'].'&_a=edit', SWIFT_UserInterfaceToolbar::LINK_NEWWINDOW );
		$_TFSTabObject->Toolbar->AddButton('');
		$_TFSTabObject->Toolbar->AddButton($this->Language->Get('cm_TFS_updatelinkBtn'), 'icon_edit.png', '/cm_TFS/cm_TFS/TFSLinkSubmit/' . $_SWIFT_TicketObject->GetTicketID() . '/', SWIFT_UserInterfaceToolbar::LINK_FORM);
		$_TFSTabObject->Toolbar->AddButton($this->Language->Get('cm_TFS_removelinkBtn'), 'icon_diffdelete.gif', '/cm_TFS/cm_TFS/TFSUnLinkSubmit/' . $_SWIFT_TicketObject->GetTicketID() . '/', SWIFT_UserInterfaceToolbar::LINK_FORM);
		$_TFSTabObject->Number( 'tfs_id' , $this->Language->Get('cm_TFS_linkInputDesc'), '', $linkDetails['tfsNumber'] );
		$_TFSTabObject->RowHTML($_renderHTML);

	}
}
?>