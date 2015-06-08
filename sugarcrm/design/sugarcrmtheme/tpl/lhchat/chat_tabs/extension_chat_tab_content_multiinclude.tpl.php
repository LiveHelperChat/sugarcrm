<?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/sugarcrm_tab_enabled_pre.tpl.php')); ?>

<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhsugarcrm','use') && $sugarcrm_tab_enabled_pre == true) : ?>

    <?php $sugarCRMSettings = erLhcoreClassModule::getExtensionInstance('erLhcoreClassExtensionSugarcrm')->settings; ?>
    <?php if (isset($sugarCRMSettings['sugarcrm_enabled']) && $sugarCRMSettings['sugarcrm_enabled']  == true) : ?>
    <div role="tabpanel" class="tab-pane" id="main-extension-sugarcrm-chat-<?php echo $chat->id?>">
    
        <?php if (!isset($chat->chat_variables_array['sugarcrm_lead_id']) || $chat->chat_variables_array['sugarcrm_lead_id'] == '') : ?>
    	<div class="form-group">
    		<a data-loading-text="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Processing')?>..." class="btn btn-default" onclick="sugarcrm.createOrUpdate($(this),<?php echo $chat->id?>)" href="javascript:void(0)"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Create Or Update a related lead')?></a>
    	</div>
        <?php endif;?>
        
    	<div id="sugar-crm-lead-info-<?php echo $chat->id?>">
            <?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/createorupdatelead.tpl.php')); ?>
        </div>
    
    </div>
    <?php endif;?>

<?php endif;?>