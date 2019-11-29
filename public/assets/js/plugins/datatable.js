(function ($) {
	"use strict";

  var init = function(){


    try {
     
      if ( $.fn.DataTable.isDataTable('#datatable') ) {
        $('#datatable').DataTable().destroy();
      }    
      //$('#datatable tbody').empty();
    }
    catch(err) {      
    } 
    finally {
      $('#datatable').dataTable({            
      });
      $.fn.dataTable.init = init;
    }
    
  }

  $(document).ready( function() {
    
  });
  // for ajax to init again
  $.fn.dataTable.init = init;

})(jQuery);
