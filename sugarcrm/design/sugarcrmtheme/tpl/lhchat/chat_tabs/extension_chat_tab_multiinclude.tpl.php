<?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/sugarcrm_tab_enabled_pre.tpl.php')); ?>
<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhsugarcrm','use') && $sugarcrm_tab_enabled_pre == true) : ?>
    <?php $sugarCRMSettings = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm')->settings; ?>
    <?php if (isset($sugarCRMSettings['sugarcrm_enabled']) && $sugarCRMSettings['sugarcrm_enabled']  == true) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/sugarcrm_chat_tab_title.tpl.php')); ?>
    <?php endif;?>
<?php endif;?>