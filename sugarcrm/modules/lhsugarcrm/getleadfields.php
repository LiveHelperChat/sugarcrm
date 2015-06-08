<?php 

$sugarcrm = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm');
$lead = $sugarcrm->getLeadById($Params['user_parameters']['lead_id']);

$tpl = erLhcoreClassTemplate::getInstance('lhsugarcrm/getleadfields.tpl.php');
$tpl->set('lead',$lead);

echo json_encode(array('result' => $tpl->fetch()));

exit;
?>