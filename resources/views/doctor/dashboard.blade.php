@extends('admin.main')
@section('content')   
    
<div class="">
	<div class="page-title padding pb-0 ">
		<h2 class="text-md mb-0">Test Information</h2>
	</div>

	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>

	<div class="padding">
	<div class="row row-sm">
		<div class="col-md-12 col-lg-4 col-xl-3">
			<div class="row row-sm">
				<div class="col-lg-12 col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="mb-4">

								<span class="text-md">Overal  Test Results</span>
																	
									<div class="row no-gutters pb-1" style="margin-top:10px;">
											<div class="col-9">
												<span class="text-muted">Total Tests</span>	
											</div>
											<div class="col-3">												
														<span id="total_tests" class="text-success" data-plugin="countTo" data-option="{
												from: 5,
													to: {{ $data['total_tests'] }},
													refreshInterval: 10,
													formatter: function (value, options) {
														return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
													}
													}"></span>
												
											</div>
									</div>

																
									<div class="row no-gutters pb-1">
											<div class="col-9">
												<span class="text-muted">Successful Tests</span>	
											</div>
											<div class="col-3">
												
														<span id="success_tests" class="text-success" data-plugin="countTo" data-option="{
												from: 10,
													to: {{ $data['success_tests'] }},
													refreshInterval: 10,
													formatter: function (value, options) {
														return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
													}
													}"></span>
												
											</div>
									</div>

									<div class="row no-gutters pb-1">
											<div class="col-9">
												<span class="text-muted">Failed Tests</span>	
											</div>
											<div class="col-3">												
														<span id="failed_tests" class="text-success" data-plugin="countTo" data-option="{
												from: 10,
													to: {{ $data['failed_tests'] }},
													refreshInterval: 10,
													formatter: function (value, options) {
														return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
													}
													}"></span>												
											</div>
									</div>

									

									<div class="row no-gutters pb-1">
											<div class="col-6">
												<span class="text-muted">Start Date</span>	
											</div>
											<div class="col-6">												
												<span id="start_date" class="text-muted">{{ $data['start_date'] }}</span>													
											</div>
									</div>

									<div class="row no-gutters pb-1">
											<div class="col-6">
												<span class="text-muted">End  Date</span>	
											</div>
											<div class="col-6">												
												<span id="end_date" class="text-muted">{{ $data['end_date'] }}</span>													
											</div>
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
											<select id="user_id" name="user_id" class="form-control" data-plugin="select2" data-option="{}" placeholder="User"  required="required"> 
													<optgroup label="Patients">
															<option value="-1" > All Users </option>  
															@foreach($patients as $p)
															<option value="{{$p->id}}" > {{$p->first_name." - ".$p->last_name}}</option>  
															@endforeach
													</optgroup>                                                
											</select>												
									</div>
									
									<div class="mx-3">	        
										<button class="btn btn-primary" id="btnRefresh" > Refresh </button>
									</div>

	              </div>
							</div>
							
	          </div>
	        </div>

	        <div class="row row-sm">
	        	<div class="col-md-12">
			        <div class="card p-4">

							<table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable" style="margin-top: -15px;">

                <!-- <table class="table table-theme v-middle" data-plugin="bootstrapTable"
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
                     -->
                    <thead>
                        <tr>
                           
                            <th><span class="text-muted">Date</span></th>
                            <th><span class="text-muted">Patient</span></th>
                            <th><span class="text-muted">Tester</span></th>
                            <th><span class="text-muted">PHD ID</span></th>
														<th><span class="text-muted">Blood Pressure</span></th>
														<th><span class="text-muted">SPO2</span></th>
                            <th><span class="text-muted">GSR</span></th>
                            <th><span class="text-muted">Phase1 Completed</span></th>
                            <th><span class="text-muted">Phase2 Completed</span></th>
														<th><span class="text-muted">Phase3 Completed</span></th>
														<th><span class="text-muted">Phase4 Completed</span></th>
                            <th><span class="text-muted">Test Completed</span></th>
                            <th><span class="text-muted">Test Aborted</span></th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allocation as $user)
                            <tr>
                                
                                <td>
                                   {{substr($user->created_at, 0, 10)}}
                                </td>
                                <td>
                                    {{$user->user_num}}
                                </td>
                                <td>
                                    {{$user->administer_num}}
                                </td>
                                <td>
                                    {{$user->serial_num}}
																</td>
																
                                <td>
                                   @if (strpos($user->tracking, '2') !== false)  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
																</td>
																<td>
																@if (strpos($user->tracking, '1') !== false)  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
                                </td>
                                <td>
																@if (strpos($user->tracking, '3') !== false)  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
                                </td>
															 
															
																
																<td>
																@if (  $user->step >= 2 )  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
                                </td>
                                <td>
                                @if (  $user->step >= 3)  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
                                </td>
                                <td>
																@if (  $user->step >= 4)  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
                                </td>
																<td>
																@if (  $user->step >= 5)  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
																</td>
																

                                <td>
																@if (  $user->is_allocated == 0)  <i class='mr-2 i-con i-con-ok text-success'></i> @else <i class="mr-2 i-con i-con-close text-danger"></i> @endif  
                                </td>
                                <td>
																@if (  $user->is_allocated == 2)  <i class='mr-2 i-con i-con-close text-danger'></i>@endif  
                                </td>
                            </tr>
                        
                        @endforeach
                                            
                    </tbody>
								</table>
								
			        	                        
			        </div>
		        </div>	        	
	        </div>
	    </div>
	  	
	
	</div>
</div>

</div>

@stop



@section('script')

<script type="text/javascript">   
    $(document).ready(function() {        
    });

    // var table = $('#table').DataTable();
    // $('#table tbody').on( 'click', 'tr', function () {
    //     var d = table.row( this ).data();        
    //     d.counter++;    
    //     table
    //         .row( this )
    //         .data( d )
    //         .draw();
    // } );
    // $(".group-checkable").change(function() {
    //     var checked = $(this).is(":checked");
    //     $('.checkboxes').attr("checked",checked);
    // });

    $(document).on('click', '.group-checkable', function () {
        
        var checked = $(this).is(":checked");
        var value = $(this).val();
        $checkBoxs = $(this).closest("table").find("tbody .checkboxes");        
        $checkBoxs.each( function () {
            $( this ).prop( "checked", checked);
        });
    });    

    $(document).on('click', '.checkboxes', function () {
        $checkBoxs = $(this).closest("table").find("tbody .checkboxes");        
    });     
 
    var deleteId = "";
    var $checkBoxs;

    function deleteUser(id){
        deleteId = id;
		}
		

    $("#btnRefresh").click(function(){            

				var start = $("input[name=start]").val();
				var end = $("input[name=end]").val();
				
				var user_id = $( "#user_id" ).val();
				var user_id2 = $( "#user_id option:selected" ).val();
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
          data: { id:user_id, start:start, end:end, company_id:company_id },
          url: "{{ URL::to('api/getTestInfo')}}",
          success: function(result) {     
                var res = result.results;
                if(res == 200){
										
										$("#total_tests").text(result.data.total_tests);
										$("#success_tests").text(result.data.success_tests);
										$("#failed_tests").text(result.data.failed_tests);
										$("#start_date").text(result.data.start_date);										
										$("#end_date").text(result.data.end_date);
										
										$("#oxygen").text(result.data.oxygen);
										$("#blood_pressure").text(result.data.blood_pressure);
										$("#gsr").text(result.data.gsr);

										$("#phase1").text(result.data.phase1);
										$("#phase2").text(result.data.phase2);
										$("#phase3").text(result.data.phase3);
										$("#phase4").text(result.data.phase4);
										$("#test_aborts").text(result.data.phase4);
										
										$("#datatable").dataTable().fnDestroy();
                    tbody = $("#datatable tbody"); 
										showTable(tbody, result.allocation);
												
                }else{
                    alert("Failed");
                }
          }

        });
		});       
		
		
		function showTable(tbody, results){
        var s = "";
        for (i = 0; i < results.length; i++) {
            
               s += "<tr>";
                  //s += "<td><input type='checkbox' class='checkboxes' value='' id ='td" + i +"'/></td>";
                  s += ("<td>" + results[i].created_at.substring(0,10) + "</td>");
                  s += ("<td>" + results[i].user_num + "</td>");
                  s += ("<td>" + results[i].administer_num + "</td>");
									s += ("<td>" + results[i].serial_num + "</td>");

									if(results[i].tracking.includes('2') == false){
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>' + "</td>";
									}else{
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>"+ "</td>";
									}
									if(results[i].tracking.includes('1') == false){
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>' + "</td>";
									}else{
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>"+ "</td>";
									}
									if(results[i].tracking.includes('3') == false){
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>' + "</td>";
									}else{
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>"+ "</td>";
									}
									
									
									if(parseInt(results[i].step) >= 2){
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>" + "</td>";
									}else{
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>'+ "</td>";
									}
									if(parseInt(results[i].step) >= 3){
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>" + "</td>";
									}else{
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>'+ "</td>";
									}
									if(parseInt(results[i].step) >= 4){
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>" + "</td>";
									}else{
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>'+ "</td>";
									}
									if(parseInt(results[i].step) >= 5){
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>" + "</td>";
									}else{
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>'+ "</td>";
									}

			
									if(parseInt(results[i].is_allocated) == 0){
										s += "<td>" + "<i class='mr-2 i-con i-con-ok text-success'></i>" + "</td>";
									}else{
										s += "<td>" + '<i class="mr-2 i-con i-con-close text-danger"></i>'+ "</td>";
									}
									if(parseInt(results[i].is_allocated) == 2){
										s += "<td>" + "<i class='mr-2 i-con i-con-close text-danger'></i>" + "</td>";
									}else{
										s += "<td>" + '<i class="mr-2 i-con i-con-ok text-success"></i>'+ "</td>";
									}                                 
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
