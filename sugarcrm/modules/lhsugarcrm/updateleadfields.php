<?php 

$sugarcrm = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm');

$lead = $sugarcrm->doUpdateLeadId($Params['user_parameters']['lead_id']);

$tpl = erLhcoreClassTemplate::getInstance('lhsugarcrm/getleadfields.tpl.php');

$tpl->set('lead',$lead);
$tpl->set('lead_updated',true);

echo json_encode(array('result' => $tpl->fetch()));

exit;
?>