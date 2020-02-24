@extends('admin.main')
@section('content')   

<div class="">

	<input type="hidden" value="{{Session::get('user_id')}}" id="user_id"/>
    <input type="hidden" value="{{Session::get('company_id')}}" id="company_id"/>
    <input type="hidden" value="{{$allocation->first()?$allocation->first()->step:'0'}}" id="step_id"/>
	<input type="hidden" value="{{$devices->first()?$devices->first()->auto_num:'0'}}" id="device_id"/>
		
	<input value="{{$patient->id}}" id="patient_id" name="patient_id" type="hidden" />
	<input value="{{$visit_form_id}}" id="visit_form_id" name="visit_form_id" type="hidden" />
	<input value="{{$diabet_risk_id}}" id="diabet_risk_id" name="diabet_risk_id" type="hidden" />
	<input type="hidden" value="-1"  id="allocation_id"/>
				
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">				
				<!-- <form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/prestep3') }}" enctype="multipart/form-data">					 -->

					@csrf							

					<div class="page-title padding pb-0 ">
						<h2 class="text-md mb-0"> <span> Patient Name : {{ $patient->first_name.", ".$patient->last_name }}  </span> </h2>
					</div>


					<div class="page-title padding pb-0 ">
						<h2 class="text-md mb-0"> <span id="step_title"> Waiting for PHD Device Data...</span> </h2>
					</div>

					<div class="padding">													
						<div class="col-md-12 mt-4 text-center" style="left:calc(50% - 55px);">		
								<div class="loader" id="img_loading" style="display:none;" ></div>			
						</div>

						<!-- step 1 -->
						<div class="row row-sm" id="div_step1" style="display:none">
							<div class="col-xl-4 col-lg-4 col-md-4" id="div_pluse">
                                <div class="card">			        	                                           
									<div class="form-control">	
										<h2 class="text-md mb-0"> Pluse Oximeter </h2>										
										<div class="col-md-12  px-3 pt-2">
											<label class="test_header"> O2 </label>
											<input type="text" name="o2" id="o2" disabled> %
											
										</div>

										<div class="col-md-12  px-3 pt-2">
											<label  class="test_header"> HRV </label>
											<input type="text" name="hrv" id="hrv" disabled> ms
										</div>										
									</div>                      
                                </div>                            
                            </div>
							<div class="col-xl-4 col-lg-4 col-md-4" id="div_gsr" >
                                <div class="card" >  
										@if($patient->placemaker == "1")
										<div class="form-control" id="div_gsr_container" style = "background-color:#d3d3d3;"> 
										@else
										<div class="form-control" id="div_gsr_container" > 
										@endif
                                        
											<h2 class="text-md mb-0"> Galvanic Skin Response </h2>										
											<div class="col-md-12  px-3 pt-2">
												<label class="test_header"> <span>&#181;</span>s </label>
												<input type="text" name="us" id="us" disabled> 
												<!-- <span>&#181;</span>s -->
											</div>											
                                        </div>                              
                                </div>                            
                            </div>

							<div class="col-xl-4 col-lg-4 col-md-4" id="div_blood">
                                <div class="card">			        	                                           
                                        <div class="form-control"> 
											<h2 class="text-md mb-0"> Blood Pressure </h2>										
											<div class="col-md-12  px-3 pt-2">
												<label class="test_header"> SYS </label>
												<input type="text" name="sys" id="sys" disabled> mmHg
											</div>
											<div class="col-md-12  px-3 pt-2">
												<label class="test_header"> DIA </label>
												<input type="text" name="dia" id="dia" disabled> mmHg
											</div>
											<div class="col-md-12  px-3 pt-2" id="div_pul">
												<label class="test_header"> PUL </label>
												<input type="text" name="pul" id="pul" disabled> /min
											</div>

                                        </div>                              
                                </div>                            
                            </div>
						</div>



						<!-- step 2 -->
						<div class="row row-sm" id="div_step2" style="display:none">
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                                                      
                                        </div>                              
                                </div>                            
                            </div>

							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
						</div>


						<!-- step 3 -->
						<div class="row row-sm" id="div_step3" style="display:none">
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control">										
										<h2 class="text-md mb-0"> Galvanic Skin Response </h2>										
											<div class="col-md-12  px-3 pt-2">
												<label class="test_header"> <span>&#181;</span>s </label>
												<input type="text" name="us" id="step3_us" disabled> <span>&#181;</span>s
											</div>											
                                        </div>                              
                                </div>                            
                            </div>
							
						</div>

						<!-- step 4 -->
						<div class="row row-sm" id="div_step4" style="display:none">
						<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
									<div class="form-control">	
										<h2 class="text-md mb-0"> Pluse Oximeter </h2>										
										<div class="col-md-12  px-3 pt-2">
											<label class="test_header"> O2 </label>
											<input type="text" name="o2" id="o2" disabled> %
											
										</div>

										<div class="col-md-12  px-3 pt-2">
											<label  class="test_header"> HRV </label>
											<input type="text" name="hrv" id="hrv" disabled> ms
										</div>										
									</div>                      
                                </div>                            
                            </div>
							
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control"> 
											<h2 class="text-md mb-0"> Blood Pressure </h2>										
											<div class="col-md-12  px-3 pt-2">
												<label class="test_header"> SYS </label>
												<input type="text" name="sys" id="sys" disabled> mmHg
											</div>
											<div class="col-md-12  px-3 pt-2">
												<label class="test_header"> DIA </label>
												<input type="text" name="dia" id="dia" disabled> mmHg
											</div>
											<div class="col-md-12  px-3 pt-2">
												<label class="test_header"> PUL </label>
												<input type="text" name="pul" id="pul" disabled> /min
											</div>
										
                                        </div>                              
                                </div>                            
                            </div>
						</div>

						<!-- step 5  -->
						<div class="row row-sm" id="div_step5" style="display:none">
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                                                      
                                        </div>                              
                                </div>                            
                            </div>

							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
						</div>

						<!-- step 6 -->
						<div class="row row-sm" id="div_step6" style="display:none">
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                                                      
                                        </div>                              
                                </div>                            
                            </div>

							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
						</div>

						<!-- step 7 -->
						<div class="row row-sm" id="div_step7" style="display:none">
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                                                      
                                        </div>                              
                                </div>                            
                            </div>

							<div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 200px">                                           
                                        </div>                              
                                </div>                            
                            </div>
						</div>


						<div class="col-md-12 mt-4 text-center">								
							<button type="button" class="btn col-md-2 mb-1 btn-primary" data-toggle="modal" data-target="#m"> Cancel </button>		
						</div>
					</div>									
				<!-- </form> -->
								
			<div>		
		</div>	
</div>


<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure you wish to close the test?</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        <button id="closeTest" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Yes</button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>


<div id="alert_modal" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"> The security token has expired. Please reboot the PHD tablet to get a new security token and restart the test process. </h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">        
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel">Ok</button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>



<form id="cancelStep" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/cancelStep') }}" enctype="multipart/form-data">
	@csrf	
	<input type = "hidden"  name="aid" id="aid" />
</form>


@stop



@section('script')

<script type="text/javascript">   
		
	function back(){
		//window.location.href = "{{ URL::to('doctor/prestep1') }}";
		document.getElementById("step1Form").submit();
	}
			
	$(document).ready(function() {                          		
		updateStepNew(1);
	});
	
	function cancel(){
		window.location.href = "testland";		
	}	
		
	$("#closeTest").click(function(){
		document.getElementById("cancelStep").submit();
		//window.location.href = "{{ URL::to('doctor/testland') }}";
	});
	// $("#cancel").click(function(){	
	// 	window.location.href = "{{ URL::to('doctor/testland') }}";
	// });


</script>

@stop
