var sugarcrm = {
	createOrUpdate : function(btn,chat_id) {
		var $btn = btn.button('loading');
		    
		$.postJSON(WWW_DIR_JAVASCRIPT + 'sugarcrm/createorupdatelead/' + chat_id, function(data){
			$('#sugar-crm-lead-info-'+chat_id).html(data.result);
		    $btn.button('reset');
		});
	}	
};