<?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/sugarcrm_tab_enabled_pre.tpl.php')); ?>
<?php if ($sugarcrm_tab_enabled_pre == true) : ?>
<?php $hasExtensionModule = $currentUser->hasAccessTo('lhsugarcrm','configure') || (isset($hasExtensionModule) ? $hasExtensionModule : false);?>
<?php endif;?>