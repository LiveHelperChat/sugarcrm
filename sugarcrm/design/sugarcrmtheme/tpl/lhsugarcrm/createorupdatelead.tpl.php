<?php if (isset($lead) && $lead->id == -1) : ?>
<div class="alert alert-warniong" role="alert">
    <pre><?php print_r($lead);?></pre>
</div>
<?php elseif (isset($lead) && $lead->id != -1) : ?>
<div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Lead processed')?>
</div>
<?php endif;?>

<?php if (isset($chat->chat_variables_array['sugarcrm_lead_id'])) : ?>
<div class="alert alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Lead ID')?> - <?php echo $chat->chat_variables_array['sugarcrm_lead_id']?> 
</div>
<div id="<?php echo $chat->chat_variables_array['sugarcrm_lead_id']?>"></div>
<?php else : ?>
<div class="alert alert-info" role="alert">
<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Lead does not exists yet')?>
</div>
<?php endif;?>

