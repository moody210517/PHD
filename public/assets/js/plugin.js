(function ($, MODULE_CONFIG, MODULE_OPTION_CONFIG) {
  	"use strict";
  
	$.fn.plugin = function(){

        return this.each(function(){
        	var self = $(this);
        	var opts = self.attr('data-option') || self.attr('data-plugin-option');
        	var plugin = self.attr('data-plugin');

			// check if the plugin loaded and has option in the attribute
			if(self[plugin] && opts){
				// init plugin with the potion on it's attribute
				self[plugin].apply(self, getOpts(opts, plugin));
			}else{
				// load the plugin												
				lazyload.load(MODULE_CONFIG[plugin]).then( function(){
					// init plugin with the potion on it's attribute
					if(plugin === 'newselect2')
						plugin = 'select2';
					if(plugin === 'dataTable2')
						plugin = 'dataTable';
					if(plugin === 'bootstrapWizard2')
						plugin = 'bootstrapWizard';
						

					//console.log(self[plugin]);
					opts && self[plugin].apply(self, getOpts(opts, plugin));
					// call the plugin init()
					self[plugin] && self[plugin].init && self[plugin].init();
					// call other init()
					window[plugin] && window[plugin].init && window[plugin].init();
					var sensor_id = $("#sensor_id").val();
					var allocation_id = $("#allocation_id").val();
					if(plugin === 'chartjs' && sensor_id != null ){
						customChat(sensor_id, allocation_id);
					}
					var currentUrl = document.URL;
					if(currentUrl.includes('steps')){						
						if(plugin === 'chartjs' || plugin === 'chartjs2'){
							initStep();
							initChart();							
						}
					}			
					
					if(currentUrl.includes('office/officeMessages')){
						initMessage();
					}

					if(currentUrl.includes('admin/test')){
						testChart();
					}

					
				});
			}
			self.removeAttr('data-plugin').removeAttr('data-option');
        });
				
        function getOpts(opts, plugin){
        	var options = opts && eval('[' + opts + ']');
			if (options && $.isPlainObject(options[0])) {
				options[0] = $.extend({}, MODULE_OPTION_CONFIG[plugin], options[0]);
			}
			return options;
		}		

	}

})(jQuery, MODULE_CONFIG, MODULE_OPTION_CONFIG);
