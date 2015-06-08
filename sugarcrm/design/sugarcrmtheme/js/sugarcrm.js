var sugarcrm = {
		createOrUpdate : function(btn,chat_id) {
			var $btn = btn.button('loading');
			
			$.postJSON(WWW_DIR_JAVASCRIPT + 'sugarcrm/createorupdatelead/' + chat_id, function(data){
				$('#sugar-crm-lead-info-'+chat_id).html(data.result);
				$btn.button('reset');
				
				if (data.error == false) {
					sugarcrm.loadLead(data.lead_id);
				}
			});
		},	
		loadLead : function(lead_id) {
			if (lead_id != '') {
				if ($('#'+lead_id).html() == '') {
					$.getJSON(WWW_DIR_JAVASCRIPT + 'sugarcrm/getleadfields/' + lead_id, function(data){
						$('#'+lead_id).html(data.result);
					});
				}
			}
		},	
		updateLeadFields : function(lead_id,form) {
			if (lead_id != '') {				
				var $btn = $('.btn-sugarcrm').button('loading');				
				$.postJSON(WWW_DIR_JAVASCRIPT + 'sugarcrm/updateleadfields/' + lead_id, form.serialize(), function(data){
					$('#'+lead_id).html(data.result);
					$btn.button('reset');
				});
			}
			return false;
		}
};