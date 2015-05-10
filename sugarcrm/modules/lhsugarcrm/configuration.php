<?php
$tpl = erLhcoreClassTemplate::getInstance('lhsugarcrm/configuration.tpl.php');

$dataObject = erLhcoreClassModelChatConfig::fetch('sugarcrm_data');
$data = (array)$dataObject->data;

if (ezcInputForm::hasPostData()) {
    $Errors = erLhcoreClassExtensionSugarcrm::validateSettings($data);
    
    if (count($Errors) == 0) {
        $dataObject->hidden = 1;
        $dataObject->identifier = 'sugarcrm_data';
        $dataObject->type = 0;
        $dataObject->explain = 'SugarCRM extension configuration data';
        $dataObject->value = serialize($data);
        $dataObject->saveThis(); 

        if (isset($_POST['StoreAndTest'])){
            $extension = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm');
            try {
                $leadId = $extension->createDemoLead();
                $tpl->set('lead_id',$leadId);
            } catch (Exception $e) {
                $tpl->set('errors',array($e->getMessage()));
            }
        }
        
        $tpl->set('updated',true);      
    } else {
        $tpl->set('errors',$Errors);  
    }
}

$tpl->set('data',$data);
$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('sugarcrm/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'SugarCRM')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('sugarcrm/configuration'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Configuration')
    )
);

erLhcoreClassChatEventDispatcher::getInstance()->dispatch('sugarcrm.configuration_path',array('result' => & $Result));
    
?>

