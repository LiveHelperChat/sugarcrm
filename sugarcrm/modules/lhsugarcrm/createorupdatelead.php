<?php 


$chat = erLhcoreClassChat::getSession()->load( 'erLhcoreClassModelChat', $Params['user_parameters']['chat_id']);

if ( erLhcoreClassChat::hasAccessToRead($chat) )
{
    erLhcoreClassChatEventDispatcher::getInstance()->dispatch('sugarcrm.createorupdatelead', array());
    
    try {
        $sugarcrm = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm');
        $leadId = $sugarcrm->createLeadByChat($chat);
        
        $tpl = erLhcoreClassTemplate::getInstance('lhsugarcrm/createorupdatelead.tpl.php');
        $tpl->set('lead',$leadId);
        $tpl->set('chat',$chat);
        
        echo json_encode(array('error' => false, 'lead_id' => $leadId->id, 'result' => $tpl->fetch()));
    } catch (Exception $e) {
        $tpl = erLhcoreClassTemplate::getInstance('lhkernel/validation_error.tpl.php');
        $tpl->set('errors',array($e->getMessage()));
        echo json_encode(array('error' => true, 'result' => $tpl->fetch()));
    }
}

exit;
?>