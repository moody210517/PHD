@extends('admin.main')
@section('content')   


<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">

				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Overall Cardiac Autonomic Neuropathy Results </h2>
				</div>
								
				<form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/prestep3') }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" value="{{$patient->id}}" id="patient_id" name="patient_id" />
				<input type = "hidden" value="exist" name="user_type" />

				<div class="row padding" style="margin-right: 0px; margin-left: 0px;">
					<div class="col-md-8">					
							<div class="row px-3">
								<div class="col-md-3">
									<label class="col-form-label"> Patient Name </label>
								</div>
								
								<div class="col-md-9">
									<input type="text" name="first_name" class="form-control" value="{{$patient->first_name.' '.$patient->last_name}}" placeholder="First Name" disabled>
								</div>                    
							</div>

							<div class="row  px-3 pt-2">
								<div class="col-md-3">
									<label class="col-form-label"> Date of Exam</label>
								</div>
								
								<div class="col-md-9">
									<input type="date" id="date" name="date" value="{{ substr($allocation->created_at, 0, 10) }}" class="form-control"  disabled>
								</div>                    
							</div>

							<div class="row  px-3 pt-2">
								<div class="col-md-3">
									<label class="col-form-label"> Time of Exam</label>
								</div>
								
								<div class="col-md-9">
									<input type="time" id="time" name="time" value="{{ substr($allocation->created_at, 11, 10) }}" class="form-control"  disabled>
								</div>                    
							</div>

							
							<div class="row  px-3 ">	
								<div class="col-md-3 pt-2">
									<label class="col-form-label"> Patient Height </label>
								</div>						
								<div class="col-md-4 pt-2">
									<input type="text" id="ft" name="ft" value="{{ floor($patient->user_height/12).' ft' }}" class="form-control"  disabled>
								</div>      																			  
								<div class="col-md-4 pt-2">
									<input type="text" id="inche" name="inche" value="{{($patient->user_height - 12 * floor($patient->user_height/12)).' inches'}}" class="form-control"  disabled>
								</div>					
							</div>


							<div class="row px-3">
								<div class="col-md-3 pt-2">
									<label class="col-form-label"> Patient Weight(lbs) </label>
								</div>							
								<div class="col-md-9 pt-2">
									<input type="text" id="weight" name="weight" value="{{$patient->weight}}" class="form-control" disabled>
								</div>								
							</div>
							

							<div class="row  px-3 pt-2">
								<div class="col-md-3">
									<label class="col-form-label"> Patient Age </label>
								</div>							
								<div class="col-md-9">
									<input type="text" id="age" name="age" value="{{$patient->age}}" class="form-control"  disabled>
								</div>                    
							</div>

							<div class="row px-3 pt-2">
								<div class="col-md-3">
									<label class="col-form-label"> Patient Gender </label>
								</div>							
								<div class="col-md-9">
									<input type="text" id="age" name="age" value="{{$patient->sex}}" class="form-control"  disabled>
								</div>                    
							</div>			

							<div class="row  px-3 pt-2">
								<div class="col-md-3">
									<label class="col-form-label"> BMI </label>
									<!-- <i class="ml-2 mr-2 i-con i-con-info" data-toggle="modal" data-target="#bmi_info"><i class="i-con-border"></i></i> -->
								</div>							
								<div class="col-md-9">
									<span class="form-control no-border"> {{$bmi }} - <strong class="{{$color}}"> {{$weight_status}} </strong></span> 
								</div>
							</div>																												
					</div>

					<div class="col-md-4">						
						<div class="col-md-12 blue-border">
							<label class="col-form-label report_sub_title"> <h6 class="mb-0">Cardiac Autonomic Neuropathy</h6> </label>
							<div class="row" >
								<div class="form-control text-center no-border pt-3 pb-3 canvas_container" >	
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview1"></canvas>						
									</div>
									<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 18 &nbsp  100% </div>  </div> -->
									<div id="preview-textfield1" class="reset" style="display:none;">1</div>
									<div class="reset"> {{$card[0]}}</div>
									<div id="status1" class="status {{$card[3]}}"> {{$card[2]}} </div>
								</div>
							</div>							
						</div>																		
					</div>


				</div>


				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Overall Cardiac Autonomic Neuropathy Results </h2>
				</div>


				<div class="padding">				
																														
						

						<div class="row px-3 pt-2" >
							
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> RR Intervals Baseline </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview2"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 3 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield2" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$RR[3]}}">{{$RR[2]}}</div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title" > RR Intervals-Baseline >= 670 </div>
												<div class="item_value {{$RR[3]}}"> {{$RR[4]}} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$RR[3]}}"> {{$RR[0]}} </div>
											</div>
										</div>										
									
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Valsalva Ratio </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview3"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 1 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield3" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$VRC4[3]}} "> {{$VRC4[2]}}  </div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> Valsalva Ratio >= 1.25 </div>
												<div class="item_value {{$VRC4[3]}}"> {{$VRC4[4]}}  </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$VRC4[3]}}">{{$VRC4[0]}}   </div>
											</div>
										</div>																				
																				
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> K30 / 15 </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview4"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 1 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield4" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status  {{$VRC6[3]}} ">  {{$VRC6[2]}} </div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title">  K30/15 >= 1.13 </div>
												<div class="item_value  {{$VRC6[3]}} ">  {{$VRC6[4]}}  </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value  {{$VRC6[3]}} ">  {{$VRC6[0]}}  </div>
											</div>
										</div>										
										
									</div>
								</div>							
							</div>							
							
						</div>	



						
						
						<div class="row px-3 pt-2" >
							
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Systolic Standing Response </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview5"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 5 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield5" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$SPRS[3]}}">  {{$SPRS[2]}} </div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> SPRS <= 10 and >= -30 mmHg </div>
												<div class="item_value {{$SPRS[3]}}"> {{$SPRS[4]}} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$SPRS[3]}}"> {{$SPRS[0]}} </div>
											</div>
										</div>										
									
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Diastolic Standing Response </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview6"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 5 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield6" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$DPRS[3]}} "> {{$DPRS[2]}}  </div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> DPRS <= 5 and >= -30 mmHg </div>
												<div class="item_value {{$DPRS[3]}}">  {{$DPRS[4]}}  </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$DPRS[3]}}"> {{$DPRS[0]}} </div>
											</div>
										</div>										

									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> BP Response to Sustained Hand Grip </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview7"></canvas>						
										</div>
																				
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 3 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield7" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$SPRS7[3]}}"> {{$SPRS7[2]}}</div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> SPRSHG >= 16 mmHg </div>
												<div class="item_value {{$SPRS7[3]}}">  {{$SPRS7[4]}} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$SPRS7[3]}}"> {{$SPRS7[0]}} </div>
											</div>
										</div>
																								
									</div>
								</div>							
							</div>							
							
						</div>	

				</div>
				
				
				<div class="col-md-12 mt-4 text-center">					
					<button type="button" class="btn col-md-2 mb-1 btn-primary" onclick="back()"> Back </button>		
				</div>

				</form>
										
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


<form id="backReport" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('report/review') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
	<input type="hidden" id="" value="{{$page_type}}"  name="page_type"/>
</form>


@stop



@section('script')
<script type="text/javascript" src="{{ asset('assets/prettify.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jscolor.js') }}"></script>
<script src="{{ asset('assets/fd-slider/fd-slider.js') }}" ></script>
<script src="{{ asset('dist/gauge.js') }}"></script>

<script type="text/javascript">   
    
	$(document).ready(function() {		

		var cardicLabel =  {
				font: "10px sans-serif",
				labels: [0, 4, 9, 13, 18],
				fractionDigits: 0
			};
		var cardicZone = [
				{strokeStyle: "#008000", min: 0, max: 4},
				{strokeStyle: "#FFFF00", min: 4, max: 9},
				{strokeStyle: "#FFA500", min: 9, max: 13},
				{strokeStyle: "#FF0000", min: 13, max: 18}
			];


		var commonLabel =  {
				font: "10px sans-serif",
				labels: [0, 70 , 100],
				fractionDigits: 0
			};
		var commonZone = [								
				{strokeStyle: "#008000", min: 0, max: 70}, // green			
				{strokeStyle: "#FF0000", min: 70, max: 100} //red
			];

		

		var RRLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 2, 3],
				fractionDigits: 0
			};
		var RRZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green
				{strokeStyle: "#FFFF00", min: 1, max: 2}, // yellow
				{strokeStyle: "#FF0000", min: 2, max: 3} //red
			];


		var VRC4Label =  {
				font: "10px sans-serif",
				labels: [0, 1],
				fractionDigits: 0
			};
		var VRC4Zone = [								
				{strokeStyle: "#008000", min: 0, max: 0.5}, // green	
				{strokeStyle: "#FFFF00", min: 0.5, max: 1} //red
			];

		var SPLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 3, 4, 5],
				fractionDigits: 0
			};
		var SPZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green	
				{strokeStyle: "#FFFF00", min: 1, max: 3},
				{strokeStyle: "#FFA500", min: 3, max: 4},
				{strokeStyle: "#FF0000", min: 4, max: 5} //red
			];

		myInit("canvas-preview1", "preview-textfield1", "{{$card[0]}}" , cardicLabel, cardicZone, 18);
		myInit("canvas-preview2", "preview-textfield2", "{{$RR[0]}}" , RRLabel, RRZone, 3);
		myInit("canvas-preview3", "preview-textfield3", "{{$VRC4[0]}}" , VRC4Label, VRC4Zone, 1);
		myInit("canvas-preview4", "preview-textfield4", "{{$VRC6[0]}}" , VRC4Label, VRC4Zone, 1);
		myInit("canvas-preview5", "preview-textfield5", "{{$SPRS[0]}}" , SPLabel, SPZone, 5);
		myInit("canvas-preview6", "preview-textfield6", "{{$DPRS[0]}}" , SPLabel, SPZone, 5);
		myInit("canvas-preview7", "preview-textfield7", "{{$SPRS7[0]}}" , RRLabel, RRZone, 3);
		

	});

	$("#closeTest").click(function(){
		window.location.href = "{{ URL::to('doctor/testland') }}";
	});

	function getTwoString(n){
		if(parseInt(n) > 9){
			return n;
		}else{
			return "0" + n;
		}
	}
	function back(){
		
		document.getElementById("backReport").submit();
	}

	function myInit(id, text, value, staticLables, staticZones, maxValue){
		var opts = {
			angle: 0,
			lineWidth: 0.3,
			radiusScale:1,
			pointer: {
				length: 0.6,
				strokeWidth: 0.04,
				color: '#000000'
			},

			staticLabels: staticLables,			
			staticZones: staticZones,
			limitMax: false,
			limitMin: false,
			highDpiSupport: true

		};

		var target = document.getElementById(id); // your canvas element	
		var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
		gauge.setTextField(document.getElementById(text));
		gauge.maxValue = maxValue; // set max gauge value
		gauge.setMinValue(0);  // set min value
		gauge.set(value); // set actual value
	}


	
</script>

@stop
