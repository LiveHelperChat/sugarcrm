<?php

$Module = array( "name" => "SugarCRM",
				 'variable_params' => true );

$ViewList = array();

$ViewList['index'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('configure')
);

$ViewList['createorupdatelead'] = array(
    'params' => array('chat_id'),
    'uparams' => array(),
    'functions' => array('use')
);

$ViewList['getleadfields'] = array(
    'params' => array('lead_id'),
    'uparams' => array(),
    'functions' => array('use')
);

$ViewList['updateleadfields'] = array(
    'params' => array('lead_id'),
    'uparams' => array(),
    'functions' => array('use')
);

$ViewList['configuration'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('configure')
);

$FunctionList['use'] = array('explain' => 'Allow operator to use SugarCRM module');
$FunctionList['configure'] = array('explain' => 'Allow operator to configure SugarCRM module');