<?php

$tpl = erLhcoreClassTemplate::getInstance( 'lhsugarcrm/index.tpl.php');
$Result['content'] = $tpl->fetch();
$Result['path'] = array(array('url' => erLhcoreClassDesign::baseurl('sugarcrm/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','SugarCRM')))

?>