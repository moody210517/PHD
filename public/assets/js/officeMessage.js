/**
Custom module for you to write your own javascript functions
**/
var base_url = window.location.origin + "/phd/";
var initMessage = function(){    
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    
    var expireData = new Date(today);
    expireData.setDate(today.getDate() + 10);
    var edd = String(expireData.getDate()).padStart(2, '0');
    var emm = String(expireData.getMonth() + 1).padStart(2, '0'); //January is 0!
    var eyyyy = expireData.getFullYear();

    var time = mm + '/' + dd + '/' + yyyy;
    var etime = emm + '/' + edd + '/' + eyyyy;
    expire_date = eyyyy + "-" + emm + "-" + edd;
    created_date = yyyy + "-" + mm + "-" + dd;

    document.getElementById("created_date").textContent = time;
    document.getElementById("expire_date").textContent = etime;

    $('#active_days').on('input',function(e){
            $("#expire_date").text(getExpireDate($("#active_days").val()));
    });

    $("#btnAddMessage").click(function(){

        var  title =  $("input[name=title]").val();
        var  body = document.getElementById("body").value;
        //var  created_date =  document.getElementById('created_date').innerHTML;
        var  active_days =  $("#active_days").val();
        //var  expire_date =  document.getElementById('expire_date').innerHTML;
    
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
            type: 'POST',
            data: { title:title, body:body, created_date:created_date, active_days:active_days,  expire_date:expire_date},
            url: "{{ URL::to('api/addMessage')}}",
            success: function(result) {     
                    var res = result.results;
                    if(res == 200){
                                        location.reload();
                    }else{
                        alert("Failed");
                    }
            }

        });            
    });


    $("#btnRefresh").click(function(){            

        var start = $("input[name=start]").val();
        var end = $("input[name=end]").val();

        var company_id = $("#company_id").val();				
        if(start == "" || end == ""){
            alert("Input Date");
            return;
        }

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        
        $.ajax({
        type: 'POST',
        data: {  start:start, end:end, company_id:company_id },
        url: base_url + "api/getMessages",
        success: function(result) {     
                var res = result.results;
                if(res == 200){
                                        
                    $("#total_message").text(result.data.total_message);
                    $("#expire_message").text(result.data.expire_message);
                    $("#active_message").text(result.data.active_message);
                    // $("#start_date").text(result.data.start_date);										
                    // $("#end_date").text(result.data.end_date);																													
                    //$("#table").dataTable().fnDestroy();
                    $("#table").bootstrapTable("destroy");

                    tbody = $("#table tbody"); 
                    showTable(tbody, result.messages);												
                }else{
                    alert("Failed");
                }
        }

        });
    });       


}


function getExpireDate(differ){
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    
    var expireData = new Date(today);
    expireData.setDate(expireData.getDate() + parseInt(differ) );

    var edd = String(expireData.getDate()).padStart(2, '0');
    var emm = String(expireData.getMonth() + 1).padStart(2, '0'); //January is 0!
    var eyyyy = expireData.getFullYear();

    var time = mm + '/' + dd + '/' + yyyy;
    var etime = emm + '/' + edd + '/' + eyyyy;
    expire_date = eyyyy + "-" + emm + "-" + edd;
    return etime;
}


function showTable(tbody, results){
    var s = "";
    for (i = 0; i < results.length; i++) {
        
           s += "<tr>";
              //s += "<td><input type='checkbox' class='checkboxes' value='' id ='td" + i +"'/></td>";
            s += ("<td>" + results[i].id + "</td>");
            s += ("<td>" + results[i].title + "</td>");
            s += ("<td>" + results[i].created_date + "</td>");
            s += ("<td>" + results[i].active_days + "</td>");
            s += ("<td>" + results[i].expire_date + "</td>");

            var today = new Date();
            var expireDate = new Date(results[i].expire_date);
            if( today < expireDate){
                s += ("<td>" + "Active" + "</td>");	
            }else{
                s += ("<td>" + "Expired" + "</td>");	
            }
                                                                                          
           s += "</tr>";
          //  tobody.fnAddData( [results[i].RsvNo, results[i].RsvDate, results[i].Flag, results[i].BankId, results[i].BankName, results[i].UserName,results[i].UserName, results[i].RsvDesc, results[i].OrderId]);

      }
        
      $( tbody ).html(s);
      $('#table').bootstrapTable({            
      });
    //$.fn.dataTable.init = init;
        
}


/***
Usage
***/
//Custom.init();
//Custom.doSomeStuff();