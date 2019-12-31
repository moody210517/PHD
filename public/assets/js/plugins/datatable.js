(function ($) {
	"use strict";

  var init = function(){


    try {
     
      if ( $.fn.DataTable.isDataTable('#datatable') ) {
        $('#datatable').DataTable().destroy();
      }    

      if ( $.fn.DataTable.isDataTable('#datatable_testlists') ) {
        $('#datatable').DataTable().destroy();
      }    


      //$('#datatable tbody').empty();
    }
    catch(err) {      
    } 
    finally {
      $('#datatable').dataTable({            
      });
      $('#datatable_testlists').dataTable({         
        "iDisplayLength": 25   
      });

      $("#datatable_testlists_length").hide();
      
      $.fn.dataTable.init = init;
    }
    
  }

  $(document).ready( function() {
    
  });
  // for ajax to init again
  $.fn.dataTable.init = init;

})(jQuery);
