<?php

/**
 * Direct integration with SugarCRM
 * */
class erLhcoreClassExtensionSugarcrm
{

    public function __construct()
    {}

    public function run()
    {
        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();
        
        $dispatcher->listen('chat.chat_offline_request', array(
            $this,
            'offlineRequest'
        ));
    }

    public function __get($var)
    {
        switch ($var) {
            
            case 'settings':
                $this->settings = erLhcoreClassModelChatConfig::fetch('sugarcrm_data')->data;
                return $this->settings;
                break;
            
            default:
                ;
                break;
        }
    }

    public function offlineRequest($params)
    {
        if (isset($this->settings['sugarcrm_offline_lead']) && $this->settings['sugarcrm_offline_lead'] == true && isset($this->settings['sugarcrm_enabled']) && $this->settings['sugarcrm_enabled'] == true) {
            $chat = $params['chat'];
            $inputData = $params['input_data'];

            $soapclient = new SoapClient($this->settings['wsdl_address']);
            
            $result_array = $soapclient->login(array(
                'user_name' => $this->settings['wsdl_username'],
                'password' => $this->settings['wsdl_password'],
                'version' => '0.1'
            ), 'soaplhcsugarcrm');
            $session_id = $result_array->id;
            $user_guid = $soapclient->get_user_id($session_id);
            
            $leadData = array(
                array(
                    'name' => 'last_name',
                    'value' => $chat->nick
                ),
                array(
                    'name' => 'department',
                    'value' => (string) $chat->department
                ),
                array(
                    'name' => 'status',
                    'value' => 'New'
                ),
                array(
                    'name' => 'phone_work',
                    'value' => (string) $chat->phone
                ),
                array(
                    'name' => 'email1',
                    'value' => (string) $chat->email
                ),
                array(
                    'name' => 'lead_source',
                    'value' => 'Web Site'
                ),
                array(
                    'name' => 'website',
                    'value' => (string) $chat->referrer
                ),
                array(
                    'name' => 'lead_source_description',
                    'value' => PHP_EOL.$inputData->question."\n\n".erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Offline form request')
                ),
                array(
                    'name' => 'assigned_user_id',
                    'value' => $user_guid
                )
            );
            
            $chatAdditionalData = $chat->additional_data_array;
            
            // Add custom fields if required
            if (isset($this->settings['lead_extra_fields']) && is_array($this->settings['lead_extra_fields']) && ! empty($this->settings['lead_extra_fields']) && is_array($chatAdditionalData) && ! empty($chatAdditionalData)) {
            
                $fieldsMappingSugar = array();
                foreach ($this->settings['lead_extra_fields'] as $data) {
                    if (isset($data['lhcfield']) && ! empty($data['lhcfield'])) {
                        $fieldsMappingSugar[$data['lhcfield']] = $data['sugarcrm'];
                    }
                }

                foreach ($chatAdditionalData as $addItem) {
                    $fieldIdentifier = isset($addItem->identifier) ? $addItem->identifier : str_replace(' ', '_', $addItem->key);
                    if (key_exists($fieldIdentifier, $fieldsMappingSugar)) {
                        $leadData[] = array(
                            'name' => $fieldsMappingSugar[$fieldIdentifier],
                            'value' => $addItem->value
                        );
                    }
                }
            }
            
            $result = $soapclient->set_entry($session_id, 'Leads', $leadData);            
        }
    }
    
    /**
     * Creates a demo lead from SugarCRM extension configuration window
     *
     * @return unknown
     */
    public function createDemoLead()
    {
        
        $soapclient = new SoapClient($this->settings['wsdl_address']);
        
        $result_array = $soapclient->login(array(
            'user_name' => $this->settings['wsdl_username'],
            'password' => $this->settings['wsdl_password'],
            'version' => '0.1'
        ), 'soaplhcsugarcrm');
        $session_id = $result_array->id;
        $user_guid = $soapclient->get_user_id($session_id);
        
        // $LeadFields = $soapclient->get_module_fields($session_id, 'Leads'); print_r($LeadFields);
        
        $result = $soapclient->set_entry($session_id, 'Leads', array(
            array(
                'name' => 'last_name',
                'value' => 'Live Helper Chat'
            ),
            array(
                'name' => 'department',
                'value' => 'Demo departament'
            ),
            array(
                'name' => 'status',
                'value' => 'New'
            ),
            array(
                'name' => 'phone_work',
                'value' => 'Demo Phone'
            ),
            array(
                'name' => 'primary_address_city',
                'value' => 'Demo City'
            ),
            array(
                'name' => 'account_name',
                'value' => 'Demo account name'
            ),
            array(
                'name' => 'email1',
                'value' => 'demo@example.com'
            ),
            array(
                'name' => 'lead_source',
                'value' => 'Web Site'
            ),
            array(
                'name' => 'lead_source_description',
                'value' => 'Your lead was successfully created'
            ),
            array(
                'name' => 'assigned_user_id',
                'value' => $user_guid
            )
        ));
        
        return $result;
    }

    /**
     * Creates a lead from chat object
     *
     * @param unknown $chat            
     * @throws Exception
     * @return unknown
     */
    public function createLeadByChat(& $chat)
    {
        if ($this->settings['sugarcrm_enabled'] == true) {
            $soapclient = new SoapClient($this->settings['wsdl_address']);
            
            $result_array = $soapclient->login(array(
                'user_name' => $this->settings['wsdl_username'],
                'password' => $this->settings['wsdl_password'],
                'version' => '0.1'
            ), 'soaplhcsugarcrm');
            $session_id = $result_array->id;
            $user_guid = $soapclient->get_user_id($session_id);
            
            $leadData = array(
                array(
                    'name' => 'last_name',
                    'value' => $chat->nick
                ),
                array(
                    'name' => 'department',
                    'value' => (string) $chat->department
                ),
                array(
                    'name' => 'status',
                    'value' => 'New'
                ),
                array(
                    'name' => 'phone_work',
                    'value' => (string) $chat->phone
                ),
                array(
                    'name' => 'email1',
                    'value' => (string) $chat->email
                ),
                array(
                    'name' => 'lead_source',
                    'value' => 'Web Site'
                ),
                array(
                    'name' => 'website',
                    'value' => (string) $chat->referrer
                ),
                array(
                    'name' => 'lead_source_description',
                    'value' => (string) $chat->remarks."\n\n=====\n".erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Chat ID').' - '.$chat->id
                ),
                array(
                    'name' => 'assigned_user_id',
                    'value' => $user_guid
                )
            );
            
            $storeLead = true;
            
            if (isset($chat->chat_variables_array['sugarcrm_lead_id']) && $chat->chat_variables_array['sugarcrm_lead_id'] != '') {
                $leadData[] = array(
                    'name' => 'id',
                    'value' => $chat->chat_variables_array['sugarcrm_lead_id']
                );
                $storeLead = false;
            }
            
            $chatAdditionalData = $chat->additional_data_array;
            
            // Add custom fields if required
            if (isset($this->settings['lead_extra_fields']) && is_array($this->settings['lead_extra_fields']) && ! empty($this->settings['lead_extra_fields']) && is_array($chatAdditionalData) && ! empty($chatAdditionalData)) {
                
                $fieldsMappingSugar = array();
                foreach ($this->settings['lead_extra_fields'] as $data) {
                    if (isset($data['lhcfield']) && ! empty($data['lhcfield'])) {
                        $fieldsMappingSugar[$data['lhcfield']] = $data['sugarcrm'];
                    }
                }
                
                foreach ($chatAdditionalData as $addItem) {
                    $fieldIdentifier = isset($addItem->identifier) ? $addItem->identifier : str_replace(' ', '_', $addItem->key);
                    if (key_exists($fieldIdentifier, $fieldsMappingSugar)) {
                        $leadData[] = array(
                            'name' => $fieldsMappingSugar[$fieldIdentifier],
                            'value' => $addItem->value
                        );
                    }
                }
            }
            
            $result = $soapclient->set_entry($session_id, 'Leads', $leadData);
            
            if ($result->id != - 1 && $storeLead == true) {
                $chat->chat_variables_array['sugarcrm_lead_id'] = $result->id;
                $chat->chat_variables = json_encode($chat->chat_variables_array);
                $chat->saveThis();
            }
            
            return $result;
        } else {
            throw new Exception('SugarCRM extension is not enabled');
        }
    }

    /**
     * Validates lead settings
     *
     * @param unknown $settings            
     * @return multitype:NULL
     */
    public static function validateSettings(& $settings)
    {
        $definition = array(
            'WSDLAddress' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'),
            'WSDLUsername' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'),
            'WSDLPassword' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'),
            'SugarCRMEnabled' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'boolean'),
            'SugarCRMCreateFromOffline' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'boolean'),
            'SugarCRMLHCIdentifier' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw', null, FILTER_REQUIRE_ARRAY),
            'SugarCRMLeadField' => new ezcInputFormDefinitionElement(ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw', null, FILTER_REQUIRE_ARRAY)
        );
        
        $form = new ezcInputForm(INPUT_POST, $definition);
        
        $Errors = array();
        
        if (! $form->hasValidData('WSDLAddress') || $form->WSDLAddress == '') {
            $Errors[] = erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Please enter SugarCRM WSDL address');
        } else {
            $settings['wsdl_address'] = $form->WSDLAddress;
        }
      
        if ($form->hasValidData('SugarCRMEnabled') && $form->SugarCRMEnabled == true) {
            $settings['sugarcrm_enabled'] = true;
        } else {
            $settings['sugarcrm_enabled'] = false;
        }
        
        if ($form->hasValidData('SugarCRMCreateFromOffline') && $form->SugarCRMCreateFromOffline == true) {
            $settings['sugarcrm_offline_lead'] = true;
        } else {
            $settings['sugarcrm_offline_lead'] = false;
        }
        
        if (! $form->hasValidData('WSDLUsername') || $form->WSDLUsername == '') {
            $Errors[] = erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Please enter SugarCRM username');
        } else {
            $settings['wsdl_username'] = $form->WSDLUsername;
        }
        
        if (! $form->hasValidData('WSDLPassword') || $form->WSDLPassword == '') {
            if ($settings['wsdl_password'] == '') {
                $Errors[] = erTranslationClassLhTranslation::getInstance()->getTranslation('sugarcrm/module', 'Please enter SugarCRM password');
            }
        } else {
            if ($form->WSDLPassword != '') {
                $settings['wsdl_password'] = md5($form->WSDLPassword);
            }
        }
        
        if ($form->hasValidData('SugarCRMLHCIdentifier') && ! empty($form->SugarCRMLHCIdentifier)) {
            $fieldsData = array();
            
            foreach ($form->SugarCRMLHCIdentifier as $key => $lhcFieldIdentifier) {
                $fieldsData[] = array(
                    'lhcfield' => $lhcFieldIdentifier,
                    'sugarcrm' => $form->SugarCRMLeadField[$key]
                );
            }
            
            $settings['lead_extra_fields'] = $fieldsData;
        } else {
            $settings['lead_extra_fields'] = array();
        }
        
        return $Errors;
    }
}