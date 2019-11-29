@extends('admin.main')
@section('content')   


<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">

				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0">Type II Risk Assessment </h2>
				</div>
								
				<form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/prestep3') }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" value="{{$patient->id}}" id="patient_id" name="patient_id" />
				<input type = "hidden" value="exist" name="user_type" />

				<div class="row padding">
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
									<span class="form-control no-border"> {{$bmi[0] }} - <strong class="{{$color}}"> {{$weight_status}} </strong></span> 
								</div>
							</div>																												
					</div>

					<div class="col-md-4">						
						<div class="col-md-12 blue-border">
							<label class="col-form-label report_sub_title"> <h6 class="mb-0">Type II Risk</h6> </label>
							<div class="row" >
								<div class="form-control text-center no-border pt-3 pb-3 canvas_container" >	
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview1"></canvas>						
									</div>
									<div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 26 &nbsp  100% </div>  </div>
									<div id="preview-textfield1" class="reset" style="display:none;">1</div>
									<div class="reset"> {{ $diabet_risk_score }}</div>
									<div id="status1" class="status {{$diabet_risk_color}}">{{$diabet_risk_name}}</div>
								</div>
							</div>
							
						</div>
						
												
					</div>

				</div>


				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Type II Risk - Score Based on Finish Diabets Risk Score </h2>
				</div>


				<div class="padding">				
																														
						<div class="row px-3 pt-2">
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > Age: </label>
									<label class="second_title" > {{$age[0]}}  </label>
									<label class="third_title" > +{{$age[1]}}  </label>
								</div>								
							</div>							
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > History of high blood glucose: </label>
									<label class="second_title" > {{ $glucose[0] == 0? "No" : "YES"}} </label>
									<label class="third_title" >  +{{$glucose[1]}}  </label>
								</div>								
							</div>
						</div>	

						<div class="row px-3 pt-2">
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > BMI: </label>
									<label class="second_title" > {{$bmi[0]}}  </label>
									<label class="third_title" > +{{$bmi[1]}}  </label>
								</div>								
							</div>							
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > Daily consumption of vegetables, fruits, or berries: </label>
									<label class="second_title" > {{ $vegetable[0] == 0? "No" : "YES"}}  </label>
									<label class="third_title" > +{{$vegetable[1]}} </label>
								</div>								
							</div>
						</div>	



						<div class="row px-3 pt-2">
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > Waist(in): </label>
									<label class="second_title" > {{$waist[0]}}  </label>
									<label class="third_title" > +{{$waist[1]}}  </label>
								</div>								
							</div>							
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > Family history of diabets: </label>
									<label class="second_title" >   {{ $family[0] == 0? "No" : "YES"}}  </label>
									<label class="third_title" > +{{$family[1]}} </label>
								</div>								
							</div>
						</div>	


						<div class="row px-3 pt-2">
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > Use of blood pressure medication: </label>
									<label class="second_title" > {{ $bpmeds[0] == 0? "No" : "YES"}}  </label>
									<label class="third_title" > +{{$bpmeds[1]}}  </label>
								</div>								
							</div>							
							<div class="col-md-6">
								<div class="form-control grey-control">
									<label class="first_title" > Physical Activity (hours/week) </label>
									<label class="second_title" > {{ $activity[0] <=3 ? "<4" : ">5" }}  </label>
									<label class="third_title" > +{{$activity[1]}}  </label>
								</div>								
							</div>
						</div>	

						<div class="row px-3 pt-2">
							<div class="col-md-12">
								<div class="form-control grey-control">
									<label class="first_title" > Total Number of Points: </label>									
									<label class="second_title" > {{$diabet_risk_score}}  </label>
								</div>								
							</div>	
						</div>

						<div class="row px-3 pt-2">
							<div class="col-md-12">
								<div class="form-control grey-control">
									<label class="first_title" > Risk Score: </label>									
									<label class="second_title" > {{$diabet_risk_name}}  </label>
								</div>								
							</div>	
						</div>


						<div class="row px-3 pt-2">
							<div class="col-md-12">
								<div class="form-control grey-control">
									<label class="first_title" > 10-year risk of developing Type 2 Diabetes: </label>									
									<label class="second_title" > {{$year_risk}}  </label>
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
		var diabetLabel =  {
				font: "10px sans-serif",
				labels: [0, 12, 31, 46, 77, 100],
				fractionDigits: 0
			};
		var diabetZone = [								
				{strokeStyle: "#008000", min: 0, max: 31}, // green
				{strokeStyle: "#FFFF00", min: 31, max: 46}, // yellow
				{strokeStyle: "#FFA500", min: 46, max: 77}, // orange
				{strokeStyle: "#FF0000", min: 77, max: 100} //red
			];

		myInit("canvas-preview1", "preview-textfield1", "{{$diabet_risk_percent}}" , diabetLabel, diabetZone);
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

	function myInit(id, text, value, staticLables, staticZones){
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
		gauge.maxValue = 100; // set max gauge value
		gauge.setMinValue(0);  // set min value
		gauge.set(value); // set actual value
	}


	
</script>

@stop
