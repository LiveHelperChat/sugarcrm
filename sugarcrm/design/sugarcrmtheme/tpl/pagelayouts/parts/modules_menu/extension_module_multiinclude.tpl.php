<?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/sugarcrm_tab_enabled_pre.tpl.php')); ?>
<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhsugarcrm','configure') && $sugarcrm_tab_enabled_pre == true) : ?>
<li><a href="<?php echo erLhcoreClassDesign::baseurl('sugarcrm/index')?>"><?php include(erLhcoreClassDesign::designtpl('lhsugarcrm/sugarcrm_title.tpl.php')); ?></a></li>
<?php endif;?>