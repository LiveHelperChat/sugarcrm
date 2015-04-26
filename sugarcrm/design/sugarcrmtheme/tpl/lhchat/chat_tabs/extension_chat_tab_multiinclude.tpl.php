<?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/sugarcrm_tab_enabled_pre.tpl.php')); ?>
<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhsugarcrm','use') && $sugarcrm_tab_enabled_pre == true) : ?>
    <?php $sugarCRMSettings = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm')->settings; ?>
    <?php if (isset($sugarCRMSettings['sugarcrm_enabled']) && $sugarCRMSettings['sugarcrm_enabled']  == true) : ?>
    <li role="presentation"><a href="#main-extension-sugarcrm-chat-<?php echo $chat->id?>" aria-controls="main-extension-sugarcrm-chat-<?php echo $chat->id?>" role="tab" data-toggle="tab" title="SugarCRM">SugarCRM</a></li>
    <?php endif;?>
<?php endif;?>