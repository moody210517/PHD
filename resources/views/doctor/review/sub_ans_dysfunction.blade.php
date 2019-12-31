@extends('admin.main')
@section('content')   


<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">

				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Overall ANS Dysfunction </h2>
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
							<label class="col-form-label report_sub_title"> <h6 class="mb-0"> ANS Dysfunction </h6> </label>
							<div class="row" >
								<div class="form-control text-center no-border pt-3 pb-3 canvas_container" >	
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview1"></canvas>						
									</div>
									<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 18 &nbsp  100% </div>  </div> -->
									<div id="preview-textfield1" class="reset" style="display:none;">1</div>
									<div class="reset"> {{ $ans[0] }}</div>
									<div id="status1" class="status {{$ans[3]}}">{{$ans[2]}}</div>
								</div>
							</div>							
						</div>																		
					</div>


				</div>


				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Overall ANS Dysfunction Results </h2>
				</div>


				<div class="padding">				
																														
						<div class="row px-3 pt-2" >
							
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Heart Rate Baseline </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview2"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 5 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield2" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$heart_rate[4]}}">{{$heart_rate[3]}}</div>
										

										<div class="reading">
											<div class="item_row"> 
												<div class="item_title"> Heart Rate (Baseline) </div>
												<div class="item_value {{$heart_rate[4]}}"> {{ $heart_rate[0] }} </div>
											</div>
											<div class="item_row"> 
												<div class="item_title"> Score  </div>
												<div class="item_value {{$heart_rate[4]}}"> {{ $heart_rate[1] }} </div>
											</div>
										</div>
										
									

									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Standard Deviation RR Interval </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview3"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 3 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield3" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$SDNN[4]}}">{{$SDNN[3]}}</div>
										
										<div class="reading">
										<div class="item_row"> 
											<div class="item_title"> Standard Deviation RR Interval </div>
											<div class="item_value {{$SDNN[4]}}"> {{ $SDNN[0] }} </div>
										</div>
										<div class="item_row"> 
											<div class="item_title"> Score </div>
											<div class="item_value {{$SDNN[4]}}"> {{ $SDNN[1] }} </div>
										</div>
										</div>
																				
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">  Root Mean Square, Successive Diff. </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview4"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 3 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield4" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$RMSSD[4]}}">{{$RMSSD[3]}}</div>

										<div class="reading">
										<div class="item_row"> 
											<div class="item_title"> RMSSD </div>
											<div class="item_value {{$RMSSD[4]}}"> {{ $RMSSD[0] }} </div>
										</div>
										<div class="item_row"> 
											<div class="item_title"> Score </div>
											<div class="item_value {{$RMSSD[4]}}"> {{ $RMSSD[1] }} </div>
										</div>
										</div>
										
									
									</div>
								</div>							
							</div>							
							
						</div>	





						<div class="row px-3 pt-2" >
							
							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> RR Interval Baseline </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview5"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 3 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield5" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$AVG_RR[4]}}">{{$AVG_RR[3]}}</div>

										
										<div class="reading">
										<div class="item_row"> 
											<div class="item_title"> RR Interval Baseline </div>
											<div class="item_value {{$AVG_RR[4]}}"> {{ $AVG_RR[0] }} </div>
										</div>
										<div class="item_row"> 
											<div class="item_title"> Score </div>
											<div class="item_value {{$AVG_RR[4]}}"> {{ $AVG_RR[1] }} </div>
										</div>
										</div>
										
									
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">  pNN50 Baseline </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview6"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 3 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield6" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$More50[4]}}">{{$More50[3]}}</div>
										<div class="reading">
										<div class="item_row"> 
											<div class="item_title"> pNN50 Baseline >= 10 </div>
											<div class="item_value {{$More50[4]}}"> {{ $More50[0] }} </div>
										</div>
										<div class="item_row"> 
											<div class="item_title"> Score </div>
											<div class="item_value {{$More50[4]}}"> {{ $More50[1] }} </div>
										</div>
										</div>
										
										
																				
									</div>
								</div>							
							</div>


							<div class="col-md-4 blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0"> Pulse Oximeter Baseline </h6> </label>
								<div class="row">
									<div class="form-control text-center  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview7"></canvas>						
										</div>
										<!-- <div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 1 &nbsp  100% </div>  </div> -->
										<div id="preview-textfield7" class="reset" style="display:none;"></div>
										
										<div id="status2" class="status {{$SPO2[4]}}">{{$SPO2[3]}}</div>
										<div class="reading">
										<div class="item_row"> 
											<div class="item_title">  SPO2 Baseline >= 94% </div>
											<div class="item_value {{$SPO2[4]}}"> {{ $SPO2[0] }} </div>
										</div>
										<div class="item_row"> 
											<div class="item_title"> Score </div>
											<div class="item_value {{$SPO2[4]}}"> {{ $SPO2[1] }} </div>
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
</form>


@stop



@section('script')
<script type="text/javascript" src="{{ asset('assets/prettify.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jscolor.js') }}"></script>
<script src="{{ asset('assets/fd-slider/fd-slider.js') }}" ></script>
<script src="{{ asset('dist/gauge.js') }}"></script>

<script type="text/javascript">   
    
	$(document).ready(function() {		
		var ansDysfunctionLabel =  {
				font: "10px sans-serif",
				labels: [0, 5, 9, 14, 18],
				fractionDigits: 0
			};
		var ansDysfunctionZone = [
				{strokeStyle: "#008000", min: 0, max: 5},
				{strokeStyle: "#FFFF00", min: 5, max: 9},
				{strokeStyle: "#FFA500", min: 9, max: 14},
				{strokeStyle: "#FF0000", min: 14, max: 18}
			];

		var baselineLabel =  {
				font: "10px sans-serif",
				labels: [0, 1, 2, 3, 4, 5],
				fractionDigits: 0
			};
		var baselineZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green
				{strokeStyle: "#FFFF00", min: 1, max: 3}, // yellow
				{strokeStyle: "#FFA500", min: 3, max: 4}, // orange
				{strokeStyle: "#FF0000", min: 4, max: 5} //red
			];

		var commonLabel =  {
				font: "10px sans-serif",
				labels: [0, 1,2, 3],
				fractionDigits: 0
			};
		var commonZone = [								
				{strokeStyle: "#008000", min: 0, max: 1}, // green			
				{strokeStyle: "#FFFF00", min: 1, max: 2}, // yellow
				{strokeStyle: "#FF0000", min: 2, max: 3} //red
			];		
		
		var plusLabel =  {
				font: "10px sans-serif",
				labels: [0, 1],
				fractionDigits: 0
			};
		var pluseZone = [								
				{strokeStyle: "#008000", min: 0, max: 0.5}, // green			
				{strokeStyle: "#FF0000", min: 0.5, max: 1} //red
			];

		myInit("canvas-preview1", "preview-textfield1", "{{$ans[0]}}" , ansDysfunctionLabel, ansDysfunctionZone, 18);
		myInit("canvas-preview2", "preview-textfield2", "{{$heart_rate[1]}}" , baselineLabel, baselineZone, 5);
		myInit("canvas-preview3", "preview-textfield3", "{{$SDNN[1]}}" , commonLabel, commonZone, 3);
		myInit("canvas-preview4", "preview-textfield4", "{{$RMSSD[1]}}" , commonLabel, commonZone, 3);
		myInit("canvas-preview5", "preview-textfield5", "{{$AVG_RR[1]}}" , commonLabel, commonZone, 3);
		myInit("canvas-preview6", "preview-textfield6", "{{$More50[1]}}" , commonLabel, commonZone, 3);
		myInit("canvas-preview7", "preview-textfield7", "{{$SPO2[1]}}" , plusLabel, pluseZone, 1);

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
