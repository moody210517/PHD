@extends('admin.main')
@section('content')   


<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">

				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Overall Blood Pressure </h2>
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
							<label class="col-form-label report_sub_title"> <h6 class="mb-0">Overall Blood Pressure</h6> </label>
							<div class="row" >
								<div class="form-control text-center no-border pt-3 pb-3 canvas_container" >	
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview1"></canvas>						
									</div>
									<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 30 &nbsp  100% </div>  </div> -->
									<div id="preview-textfield1" class="reset" style="display:none;">1</div>
									<div class="reset"> {{ $overall_blood_risk_score }}</div>
									<div id="status1" class="status {{$overall_blood_risk_color}}">{{$overall_blood_risk_name}}</div>
								</div>
							</div>							
						</div>																		
					</div>


				</div>


				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Overall Blood Pressure Results </h2>
				</div>


				<div class="padding">				
																														
						<div class="row px-3 pt-2" >
							
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Blood Pressure Baseline </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview2"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 5 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield2" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$baseline[4]}}">{{$baseline[3]}}</div>
										<div class="reading"> 
											<div class="item_row"> 
												<div class="item_title"> Systolic Pressure <= 140 mmHg </div>
												<div class="item_value {{$baseline[6]}}"> {{ $baseline[1] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Diastolic Pressure <= 90 mmHg </div>
												<div class="item_value {{$baseline[7]}}"> {{ $baseline[2] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$baseline[4]}}">  {{ $baseline[0] }} </div>
											</div>
										</div>
										

									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Blood Pressure Standing </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview3"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 5 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield3" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$standing[4]}}">{{$standing[3]}}</div>
										
										<div class="reading"> 
											<div class="item_row"> 
												<div class="item_title"> Systolic Pressure <= 119 mmHg </div>
												<div class="item_value {{$standing[6]}}"> {{ $standing[1] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Diastolic Pressure <= 75 mmHg </div>
												<div class="item_value {{$standing[7]}}"> {{ $standing[2] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$standing[4]}}">  {{ $standing[0] }} </div>
											</div>
										</div>
										

									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">BP Standing Response</h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview4"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 8 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield4" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$standingRes[4]}}">{{$standingRes[3]}}</div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> SPRS < 10 mmHg </div>
												<div class="item_value {{$standingRes[6]}}"> {{ $standingRes[0] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> DPRS < 5 mmHg </div>
												<div class="item_value {{$standingRes[7]}}"> {{ $standingRes[1] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title mt-1"> Score SPRS<span class="{{$standingRes[4]}}" >{{$standingRes[8]}} </span>+DPRS<span class="{{$standingRes[4]}}"> {{$standingRes[9]}} </span> </div>
												<div class="item_value {{$standingRes[4]}}">  {{ $standingRes[2] }} </div>
											</div>
										</div>
										
									</div>
								</div>							
							</div>							
							
						</div>	





						<div class="row px-3 pt-2" >
							
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Blood Pressure Valsalva </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview5"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 5 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield5" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$valsalva[4]}}">{{ $valsalva[3] }}</div>

										<div class="reading"> 
											<div class="item_row"> 
												<div class="item_title"> Systolic Pressure <= 140 mmHg </div>
												<div class="item_value {{$valsalva[6]}}"> {{ $valsalva[1] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Diastolic Pressure <= 90 mmHg </div>
												<div class="item_value {{$valsalva[7]}}"> {{ $valsalva[2] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$valsalva[4]}}">  {{ $valsalva[0] }} </div>
											</div>
											
										</div>
										
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> BP Valsalva Response </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview6"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 4 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield6" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$valsalvaRes[3]}}">{{$valsalvaRes[2]}}</div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> SPRV >= -40 mmHg </div>
												<div class="item_value {{$valsalvaRes[3]}}"> {{ $valsalvaRes[1] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score </div>
												<div class="item_value {{$valsalvaRes[3]}}"> {{ $valsalvaRes[0] }} </div>
											</div>
										</div>
										
										
																				
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Parasympathetic</h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview7"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 3 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield7" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$para[8]}}">{{$para[7]}}</div>

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> Valsalva Ratio >= 1.25 </div>
												<div class="item_value {{$para[4]}}"> {{ $para[0] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> K30 / 15 >= 1.13 </div>
												<div class="item_value {{$para[5]}}"> {{ $para[1] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> E / I Ratio >= 1.20 </div>
												<div class="item_value {{$para[6]}}">  {{ $para[2] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Parasympathetic Score </div>
												<div class="item_value {{$para[8]}}">  {{ $para[3] }} </div>
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
		var diabetLabel =  {
				font: "10px sans-serif",
				labels: [0, 7, 15, 23, 30],
				fractionDigits: 0
			};
		var diabetZone = [								
				{strokeStyle: "#008000", min: 0, max: 7}, // green
				{strokeStyle: "#FFFF00", min: 7, max: 15}, // yellow
				{strokeStyle: "#FFA500", min: 15, max: 23}, // orange
				{strokeStyle: "#FF0000", min: 23, max: 30} //red
			];


		var baselineLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 3, 4, 5],
				fractionDigits: 0
			};
		var baselineZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green
				{strokeStyle: "#FFFF00", min: 1, max: 3}, // yellow
				{strokeStyle: "#FFA500", min: 3, max: 4}, // orange
				{strokeStyle: "#FF0000", min: 4, max: 5} //red
			];
		var standingLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 3, 4, 5],
				fractionDigits: 0
			};
		var standingZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green
				{strokeStyle: "#FFFF00", min: 1, max: 3}, // yellow
				{strokeStyle: "#FFA500", min: 3, max: 4}, // orange
				{strokeStyle: "#FF0000", min: 4, max: 5} //red
			];

		var standResLabel =  {
				font: "10px sans-serif",
				labels: [0,2,  4, 6, 8],
				fractionDigits: 0
			};
						
		var standResZone = [								
				{strokeStyle: "#008000", min: 0, max: 2}, // green
				{strokeStyle: "#FFFF00", min: 2, max: 4}, // yellow
				{strokeStyle: "#FFA500", min: 4, max: 6}, // orange
				{strokeStyle: "#FF0000", min: 6, max: 8} //red
			];

		var valResLabel =  {
				font: "10px sans-serif",
				labels: [0 ,1,2, 3, 4],
				fractionDigits: 0
			};
		var valResZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green
				{strokeStyle: "#FFFF00", min: 1, max: 2}, // yellow
				{strokeStyle: "#FFA500", min: 2, max: 3}, // orange
				{strokeStyle: "#FF0000", min: 3, max: 4} //red
			];
			
		var paraLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 2,  3],
				fractionDigits: 0
			};
		var paraZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green
				{strokeStyle: "#FFFF00", min: 1, max: 2}, // yellow				
				{strokeStyle: "#FF0000", min: 2, max: 3} //red
			];

		myInit("canvas-preview1", "preview-textfield1", "{{$overall_blood_risk_score}}" , diabetLabel, diabetZone, 30);
		myInit("canvas-preview2", "preview-textfield2", "{{$baseline[0]}}" , baselineLabel, baselineZone, 5);
		myInit("canvas-preview3", "preview-textfield3", "{{$standing[0]}}" , standingLabel, standingZone, 5);
		myInit("canvas-preview4", "preview-textfield4", "{{$standingRes[2]}}" , standResLabel, standResZone, 8);
		myInit("canvas-preview5", "preview-textfield5", "{{$valsalva[0]}}" , standingLabel, standingZone, 5);
		myInit("canvas-preview6", "preview-textfield6", "{{$valsalvaRes[0]}}" , valResLabel, valResZone, 4);
		myInit("canvas-preview7", "preview-textfield7", "{{$para[3]}}" , paraLabel, paraZone, 3);

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
