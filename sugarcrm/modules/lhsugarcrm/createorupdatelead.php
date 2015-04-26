<?php 


$chat = erLhcoreClassChat::getSession()->load( 'erLhcoreClassModelChat', $Params['user_parameters']['chat_id']);

if ( erLhcoreClassChat::hasAccessToRead($chat) )
{
    try {
        $sugarcrm = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm');
        $leadId = $sugarcrm->createLeadByChat($chat);
        
        $tpl = erLhcoreClassTemplate::getInstance('lhsugarcrm/createorupdatelead.tpl.php');
        $tpl->set('lead',$leadId);
        $tpl->set('chat',$chat);
        
        echo json_encode(array('result' => $tpl->fetch()));
    } catch (Exception $e) {
        $tpl = erLhcoreClassTemplate::getInstance('lhkernel/validation_error.tpl.php');
        $tpl->set('errors',array($e->getMessage()));
        echo json_encode(array('result' => $tpl->fetch()));
    }
}

exit;
?>