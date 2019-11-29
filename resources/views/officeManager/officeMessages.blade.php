@extends('admin.main')
@section('content')   
    
<div class="">
	<div class="page-title padding pb-0 ">
		<h2 class="text-md mb-0">Office Message Board </h2>
	</div>


	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
	<div class="padding">

	<div class="row row-sm">
		<div class="col-md-12 col-lg-4 col-xl-3">
			<div class="row row-sm">
				<div class="col-lg-12 col-sm-6">
				
				<div class="card">			        	
								<div class="card-body">
			        		<div class="d-flex i-con-h-a">
			        			<span class="text-md">
                      Message statistics
				        		</span>							    
			        			<span class="mx-2 mt-1">
			        				<i class="i-con i-con-trending-up text-success"><i></i></i>			        				
			        			</span>
			        		</div>	


							 	<div class="row no-gutters pb-1" style="margin-top:10px;">
										<div class="col-9">
											<span class="text-muted"> Total Messages </span>	
										</div>
										<div class="col-3">											
											<span id="total_message" class="text-muted">{{ $data['total_message'] }}</span>												
										</div>
								</div>

								<div class="row no-gutters pb-1">
										<div class="col-9">
											<span class="text-muted">Active Messages</span>	
										</div>
										<div class="col-3">											
											<span id="active_message" class="text-muted">{{ $data['active_message'] }}</span>												
										</div>
								</div>

								<div class="row no-gutters pb-1">
										<div class="col-9">
											<span class="text-muted">Expire Message</span>	
										</div>
										<div class="col-3">											
											<span id="expire_message" class="text-muted">{{ $data['expire_message'] }}</span>												
										</div>
								</div>						

			        </div>
										        	
			      </div>
				</div>
			
			</div>					
		</div>





		<div class="col-md-12 col-lg-8 col-xl-9">
			<div class="block px-4 py-3">
	          
					<div class="row">

              <div class="col-lg-3 col-12">
	              <div class="d-flex align-items-center i-con-h-a my-1">	                
	                <div class="mx-3">	                  
	                  <span class="text-md">Filter  Results</span>
	                </div>
	              </div>
              </div>
                	            	            
	            <div class="col-lg-4 col-12">
	              <div class="d-flex align-items-center i-con-h-a my-1">	                								
										<div class='input-group input-daterange' data-plugin="datepicker" data-option="{}">
												<input type='text' class="form-control" name="start">
												<div class="input-group-prepend">
													<span class="input-group-text">to</span>
												</div>
												<input type='text' class="form-control" name="end">
										</div></div>
							</div>
							

							<div class="col-lg-5 col-12">

	              <div class="d-flex align-items-center i-con-h-a my-1">	                
	                <div class="mx-3">	                  																													
										<button class="btn btn-primary" id="btnRefresh" > Refresh </button>											
									</div>
									
									<div class="mx-3">	        
										<button class="btn btn-primary" id="btnNew" data-toggle="modal" data-target="#m" > New  </button>										
									</div>

	              </div>
							</div>
							
	          </div>
	        </div>

	        <div class="row row-sm">
	        	<div class="col-md-12">
			        <div class="card p-4">

							<!-- <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable2" style="margin-top: -15px;"> -->

                <table class="table table-theme v-middle" data-plugin="bootstrapTable"
                    id="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-search-align="left"
                    data-show-columns="true"
                    data-show-export="false"
                    data-detail-view="false"
                    data-mobile-responsive="true"
                    data-pagination="true"
                    data-page-list="[10, 25, 50, 100, ALL]"
                    >
                    
                    <thead>
                        <tr>              
														<th class="table-checkbox">
                              <input type="checkbox" class="group-checkable" />
                            </th>             
                            <th><span class="text-muted">Message # </span></th>
                            <th><span class="text-muted">Title</span></th>
                            <th><span class="text-muted">Created</span></th>
                            <th><span class="text-muted">Days Active</span></th>
														<th><span class="text-muted">Expired</span></th>
														<th><span class="text-muted">Status</span></th>
														<th><span class="text-muted">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>

													  @foreach ($messages as $msg)
                            <tr>
																<td>
                                  <label class="ui-check m-0 ">                               
                                    <input id="{{$msg->id}}" type="checkbox" class="checkboxes" name="id"  value="{{$msg->id}}"/>
                                    <i></i>
                                  </label>                           
                                </td>

                                <td>
                                   {{$msg->id}}
                                </td>
                                <td>
                                    {{$msg->title}}
                                </td>
                                <td>
                                    {{$msg->created_date}}
                                </td>
                                <td>
                                    {{$msg->active_days}}
																</td>
																<td>
                                    {{$msg->expire_date}}
																</td>
																<td>
                                    {{ $msg->expire_date < date("Y-m-d") ? "Expired":"Active" }}
																</td>
																<td>
																	<button type="button" class="btn btn-primary" onclick="openEditModal({{$msg}});">Edit</button>
																</td>
                            </tr>

                        @endforeach
                    </tbody>
								</table>				

								
									
			        	                        
			        </div>
		        </div>	        	
	        </div>

					<div class="col-md-12">
						<button id="deleteMsg" class="btn btn-primary" data-toggle="modal" data-target="#deleteMsgModal" disabled >Delete</button>			
					</div>


	    </div>	  		
	</div>
</div>
</div>


<div id="m" class="modal" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">New Office Message</h5>
			</div>
			
			<form method="post" action="{{ url('office/officeInformation')}}" enctype="multipart/form-data">
			@csrf

			<div class="modal-body text-left p-lg">					
					<div class="form-group">
							<label class="text-muted">Message Title</label>
							<input type="text" id="title" name="title" class="form-control" placeholder="Message Title" required="required">
					</div>
					<div class="form-group ">
							<label class="text-muted">Message Body</label>
							<textarea type="text" id="body" name="body" class="form-control"  placeholder="Message Body" required="required"> </textarea>
					</div>
					
					<div class="row">
							<label class="col-sm-6"> Created by: </label>
							<div class="col-sm-6">
								<span > Office Admin Name </span>		
							</div>
					</div>
					<div class="row">
							<label class="col-sm-6"> Date Created: </label>
							<div class="col-sm-6">
								<span id="created_date"> </span>
							</div>	
					</div>

					<div class="row">
							<label class="col-sm-6"> How many days active? </label>
							<div class="col-sm-6">
							<input type="number" id="active_days" name="active_days"  value="10" class="form-control" placeholder="Active Days"  required="required">
							</div>
					</div>

					<div class="row">
							<label class="col-sm-6"> Expired Date: </label>
							<div class="col-sm-6">
								<span id="expire_date" >  04/23/2019 </span>
							</div>
					</div>

			</div>
			</form>

			<div class="modal-footer">
				<button type="button" id="btnAddMessage" class="btn btn-primary" data-dismiss="modal">Submit</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
			</div>
		</div><!-- /.modal-content -->
	</div>
</div>



<div id="editModal" class="modal" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Office Message</h5>
			</div>


			<input type="hidden" id="msgId" class="form-control">
			<div class="modal-body text-left p-lg">					
					<div class="form-group">
							<label class="text-muted">Message Title</label>
							<input type="text" id="etitle" name="etitle" class="form-control" placeholder="Message Title" required="required">
					</div>
					<div class="form-group ">
							<label class="text-muted">Message Body</label>
							<textarea type="text" id="ebody" name="ebody" class="form-control"  placeholder="Message Body" required="required"> </textarea>
					</div>
					
					<div class="row">
							<label class="col-sm-6"> Created by: </label>
							<div class="col-sm-6">
								<span > Office Admin Name </span>		
							</div>
					</div>
					<div class="row">
							<label class="col-sm-6"> Date Created: </label>
							<div class="col-sm-6">
								<span id="ecreated_date"> </span>
							</div>	
					</div>

					<div class="row">
							<label class="col-sm-6"> How many days active? </label>
							<div class="col-sm-6">
							<input type="number" id="eactive_days" name="eactive_days"  value="10" class="form-control" placeholder="Active Days"  required="required">
							</div>
					</div>

					<div class="row">
							<label class="col-sm-6"> Expired Date: </label>
							<div class="col-sm-6">
								<span id="eexpire_date" >  04/23/2019 </span>
							</div>
					</div>
			</div>
	

			<div class="modal-footer">
				<button type="button" id="btnDeleteMessage" class="btn btn-primary" data-dismiss="modal">Delete</button>
				<button type="button" id="btnEditMessage"  class="btn btn-primary" data-dismiss="modal">Update</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
			</div>
		</div><!-- /.modal-content -->
	</div>
</div>


<!--delete message modal -->
<div id="deleteMsgModal" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure you wish to delete this message?</h5>
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

<div id="deleteMsgModalSingle" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure you wish to delete this message?</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        <button id="delBtnSingle" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Yes</button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>

@stop


@section('script')

<script type="text/javascript">   
		var  created_date ;
		var  expire_date ;

    $(document).ready(function() {      
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

			$('#eactive_days').on('input',function(e){
					$("#eexpire_date").text(getExpireDate($("#eactive_days").val()));
			});

    });

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

    $(document).on('click', '.group-checkable', function () {        
        var checked = $(this).is(":checked");
        var value = $(this).val();
        $checkBoxs = $(this).closest("table").find("tbody .checkboxes");        
        $checkBoxs.each( function () {
            $( this ).prop( "checked", checked);
				});
				
				// only enable button when choose a row
        document.getElementById("deleteMsg").disabled = true;
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if (checked) {                
                document.getElementById("deleteMsg").disabled = false;
            } else {                
            }
				});
				
    });    

    $(document).on('click', '.checkboxes', function () {
				$checkBoxs = $(this).closest("table").find("tbody .checkboxes");        
				// only enable button when choose a row
        document.getElementById("deleteMsg").disabled = true;
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if (checked) {                
                document.getElementById("deleteMsg").disabled = false;
            } else {                
            }
				});
				
    });     

    var deleteId = "";
    var $checkBoxs;

    function deleteUser(id){
        deleteId = id;
		}

		function openEditModal(msg){
			$("#editModal").modal();			
			document.getElementById("msgId").value = msg['id'];
			document.getElementById("etitle").value = msg['title'];
			document.getElementById("etitle").value = msg['title'];
			document.getElementById("ebody").value = msg['body'];
			document.getElementById("eactive_days").value = msg['active_days'];
			document.getElementById("ecreated_date").innerHTML = msg['created_date'];
			document.getElementById("eexpire_date").innerHTML = msg['expire_date'];

			var today = new Date();
			var expireDate = new Date(msg['expire_date']);
			if( today < expireDate){ // active
				document.getElementById("btnEditMessage").style.display= "block";				
			}else{ // if expired , hide the edit button
				document.getElementById("btnEditMessage").style.display= "none";
			}
		}
				
		$("#btnAddMessage").click(function(){
				var  title =  $("input[name=title]").val();
				var  body = document.getElementById("body").value;
				//var  created_date =  document.getElementById('created_date').innerHTML;
				var  active_days =  $("#active_days").val();
				//var  expire_date =  document.getElementById('expire_date').innerHTML;
				var company_id = $("#company_id").val();			
				$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
          type: 'POST',
          data: { title:title, body:body, created_date:created_date, active_days:active_days,  expire_date:expire_date, company_id:company_id},
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


		$("#btnEditMessage").click(function(){

				var  title =  $("input[name=etitle]").val();
				var  body = document.getElementById("ebody").value;
				//var  created_date =  document.getElementById('created_date').innerHTML;
				var  active_days =  $("#eactive_days").val();
				//var  expire_date =  document.getElementById('expire_date').innerHTML;
				var company_id = $("#company_id").val();			
				var id = document.getElementById("msgId").value;

				$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
          type: 'POST',
          data: { id:id, title:title, body:body, created_date:created_date, active_days:active_days,  expire_date:expire_date, company_id:company_id},
          url: "{{ URL::to('api/editMessage')}}",
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

		$("#btnDeleteMessage").click(function(){			 				

				// hide deleteMsgModal and show deleteMsgModalSingle
				$('#deleteMsgModal').modal('hide');
				$('#deleteMsgModalSingle').modal('show');										
		});

		$("#delBtnSingle").click(function(){				
				var  id = document.getElementById("msgId").value;				
				$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
          type: 'POST',
          data: { id:id},
          url: "{{ URL::to('api/deleteMessage')}}",
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

		$("#delBtn").click(function(){    
        var ids = [];
        //var $checkBoxs = $(this).closest("table").find("tbody .checkboxes");
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if (checked) {                
                ids.push(value);                
            } else {                
            }
        });


        var id = deleteId;
        //var request = $.get('{{ URL::to('admin/deleteUser')}}' + "?id=" + id);
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
          type: 'POST',
          data: { id:ids},
          url: "{{ URL::to('api/deleteMessageByChk')}}",
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
		


    // $("#btnRefresh").click(function(){ 
		// 		var start = $("input[name=start]").val();
		// 		var end = $("input[name=end]").val();
		// 		var company_id = $("#company_id").val();

		// 		if(start == "" || end == ""){
		// 			alert("Input Date");
		// 			return;
		// 		}

    //     $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    //     });

    //     $.ajax({
    //       type: 'POST',
    //       data: {  start:start, end:end, company_id:company_id },
    //       url: "{{ URL::to('api/getMessages')}}",
    //       success: function(result) {     
    //             var res = result.results;
    //             if(res == 200){										
		// 								$("#total_message").text(result.data.total_message);
		// 								$("#expire_message").text(result.data.expire_message);
		// 								$("#active_message").text(result.data.active_message);
		// 								// $("#start_date").text(result.data.start_date);										
		// 								// $("#end_date").text(result.data.end_date);																													
		// 								//$("#table").dataTable().fnDestroy();
    //                 tbody = $("#table tbody"); 
		// 								showTable(tbody, result.messages);												
    //             }else{
    //                 alert("Failed");
    //             }
    //       }
    //     });
		// });       
		
		
		// function showTable(tbody, results){
    //     var s = "";
    //     for (i = 0; i < results.length; i++) {
            
    //            s += "<tr>";
    //               //s += "<td><input type='checkbox' class='checkboxes' value='' id ='td" + i +"'/></td>";
    //               s += ("<td>" + results[i].id + "</td>");
    //               s += ("<td>" + results[i].title + "</td>");
    //               s += ("<td>" + results[i].created_date + "</td>");
		// 							s += ("<td>" + results[i].active_days + "</td>");
		// 							s += ("<td>" + results[i].expire_date + "</td>");

		// 							var today = new Date();
		// 							var expireDate = new Date(results[i].expire_date);
		// 							if( today < expireDate){
		// 								s += ("<td>" + "Active" + "</td>");	
		// 							}else{
		// 								s += ("<td>" + "Expired" + "</td>");	
		// 							}
																                              
    //            s += "</tr>";
    //           //  tobody.fnAddData( [results[i].RsvNo, results[i].RsvDate, results[i].Flag, results[i].BankId, results[i].BankName, results[i].UserName,results[i].UserName, results[i].RsvDesc, results[i].OrderId]);

    //       }
    //     $( tbody ).html(s);
		// 		//$('#table').dataTable({            
    //   	//});
		// 		//$.fn.dataTable.init = init;			
		// }
						
</script>
@stop
