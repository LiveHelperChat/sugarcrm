<?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/configuration_title.tpl.php'));?>

<form action="" method="post" autocomplete="off">

<?php if (isset($errors)) : ?>
		<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Settings updated'); ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif; ?>

<?php if (isset($lead_id)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Lead was succesfully created')?>

    <?php if ($lead_id->id != -1) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
    <?php else : $errors = array(erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Failed to create a lead!'))?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
    <?php endif;?>
    
    <pre><?php print_r($lead_id);?></pre>
<?php endif;?>

<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#logininformation" aria-controls="logininformation" role="tab" data-toggle="tab"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Login information');?></a></li>
			<li role="presentation"><a href="#additionalsettings" aria-controls="additionalsettings" role="tab" data-toggle="tab"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Additional settings');?></a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="logininformation">

				<div class="form-group">
					<label><input type="checkbox" name="SugarCRMEnabled" value="on" <?php (isset($data['sugarcrm_enabled']) && $data['sugarcrm_enabled'] == true) ? print 'checked="checked"' : print '';?>>&nbsp;<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Extension enabled')?></label>
				</div>
				
				<div class="form-group">
					<label><input type="checkbox" name="SugarCRMCreateFromOffline" value="on" <?php (isset($data['sugarcrm_offline_lead']) && $data['sugarcrm_offline_lead'] == true) ? print 'checked="checked"' : print '';?>>&nbsp;<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Create leads automatically from offline requests')?></label>
				</div>
				
				<div class="form-group">
					<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','WSDL address')?></label> <input type="text" class="form-control" name="WSDLAddress" value="<?php isset($data['wsdl_address']) ? print htmlspecialchars($data['wsdl_address']) : print '';?>" placeholder="http://example.com/sugarcrm/soap.php" />
				</div>
				
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Username')?></label> <input type="text" class="form-control" name="WSDLUsername" value="<?php isset($data['wsdl_username']) ? print htmlspecialchars($data['wsdl_username']) : print '';?>" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','SugarCRM Username')?>" />
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
						    <input style="display:none">
							<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Password (will not be shown once saved)')?></label> <input type="password" class="form-control" name="WSDLPassword" value="" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','SugarCRM Password')?>" />
						</div>
					</div>
				</div>
			</div>
			
			<div role="tabpanel" class="tab-pane" id="additionalsettings">
				<h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Additional fields identifiers mapping to Lead field names')?></h4>
				<div class="row">
                <?php for ($i = 0; $i < 20; $i++) : ?>
                <div class="col-xs-6">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6">
								    <label><?php echo $i + 1?>. <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Custom field identifier')?></label>
									<input class="form-control" type="text" name="SugarCRMLHCIdentifier[<?php echo $i?>]" value="<?php isset($data['lead_extra_fields'][$i]['lhcfield']) ? print htmlspecialchars($data['lead_extra_fields'][$i]['lhcfield']) : ''?>" placeholder="" />
								</div>
								<div class="col-xs-6">
								    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','SugarCRM lead field name')?></label>
									<input class="form-control" type="text" name="SugarCRMLeadField[<?php echo $i?>]" value="<?php isset($data['lead_extra_fields'][$i]['sugarcrm']) ? print htmlspecialchars($data['lead_extra_fields'][$i]['sugarcrm']) : ''?>" placeholder="" />
								</div>
							</div>
						</div>
					</div>
                <?php endfor;?>
                </div>
			</div>

		</div>
	</div>

	<div class="btn-group" role="group" aria-label="...">
		<input type="submit" class="btn btn-default" name="StoreSettings" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save'); ?>" /> <input type="submit" class="btn btn-default" name="StoreAndTest" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module','Save and create a test Lead'); ?>" />
	</div>

</form>