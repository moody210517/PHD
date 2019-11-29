@extends('admin.main')
@section('content')     
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0" style="padding-bottom: 35px;">State
            <!-- <a href="{{ url('admin/addUser') }}" class="btn btn-raised btn-wave w-xs blue" style="float: right;color: white;">Add User</a> -->
            </h2>
        </div>

        <div class="padding pt-0 ">
            <div class="table-responsive">
                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable" style="margin-top: -15px;">
                    <thead>
                        <tr>
                            <th><span class="text-muted">ID</span></th>
                            <th><span class="text-muted">State Name</span></th>
                            <th><span class="text-muted">City Name</span></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                            <tr>
                                <td>
                                    <a href="javascript:void(0);" class="item-author "></a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="item-author "></a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="item-author "></a>
                                </td>                              
                            </tr>
                                               
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- modal -->
<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure to execute this action?</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        <button id="delBtn" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Yes</button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>
@stop


@section('script')
<script type="text/javascript">   
    $(document).ready(function() {
        load();
    });


    var deleteId = "";
    function deleteUser(id){
        deleteId = id;
    }

    $("#delBtn").click(function(){    
        var id = deleteId;
        //var request = $.get('{{ URL::to('admin/deleteUser')}}' + "?id=" + id);
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
          type: 'POST',
          data: { id:id},
          url: "{{ URL::to('api/deleteUser')}}",
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



    function load() {
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                type: 'POST',
                data: { id:''},
                url: "{{ URL::to('api/getCities')}}",
                success: function(result) {
                        var res = result.results;
                        if(res == 200){                                  
                            $("#total_tests").text(result.cities.auto_num);
                            $("#success_tests").text(result.cities.state_id);
                            $("#failed_tests").text(result.cities.city_name);
                            $("#datatable").dataTable().fnDestroy();

                            tbody = $("#datatable tbody");

                            showTable(tbody, result.cities);
                                                        
                        }else{
                            alert("Failed");
                        }
                }
            });

    }


    function showTable(tbody, results){
        var s = "";
        for (i = 0; i < results.length; i++) {
            
               s += "<tr>";
                //s += "<td><input type='checkbox' class='checkboxes' value='' id ='td" + i +"'/></td>";                  
                s += ("<td>" + results[i].auto_num + "</td>");
                s += ("<td>" + results[i].state_id + "</td>");
                s += ("<td>" + results[i].city_name + "</td>");																																						                        
               s += "</tr>";
              //  tobody.fnAddData( [results[i].RsvNo, results[i].RsvDate, results[i].Flag, results[i].BankId, results[i].BankName, results[i].UserName,results[i].UserName, results[i].RsvDesc, results[i].OrderId]);

          }
        $( tbody ).html(s);
				$('#datatable').dataTable({            
      	});
				//$.fn.dataTable.init = init;
			
	}
</script>

@stop