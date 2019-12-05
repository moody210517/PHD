@extends('admin.main')
@section('content')   
    
<div class="">

	<div class="page-container">
		<div class="bg-white pt-4 pb-5">
					
				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0">Review </h2>
				</div>


				<div class="padding">
					
					<div class="row px-3">
						<div class="col-md-3">
							<label class="col-form-label"> Patient Name </label>
						</div>
						
						<div class="col-md-9">
							<input type="text" name="first_name" class="form-control" value="{{$patient->first_name.' '.$patient->last_name}}" placeholder="First Name" disabled>
						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="col-form-label"> Date of Exam</label>
						</div>
						
						<div class="col-md-9">							
							<input type="date" id="date" name="date" value="{{ substr($allocation->created_at, 0, 10) }}" class="form-control"  disabled>
						</div>                    
					</div>


					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="col-form-label"> Time of Exam</label>
						</div>
						
						<div class="col-md-9">
							<input type="time" id="time" name="time" value="{{ substr($allocation->created_at, 11, 10) }}"  class="form-control"  disabled>
						</div>                    
					</div>

					<div class="row px-3 pt-2">
						<div class="col-md-3">
							<label class="col-form-label"> BMI </label>
							<!-- <i class="ml-2 mr-2 i-con i-con-info" data-toggle="modal" data-target="#bmi_info"><i class="i-con-border"></i></i> -->
						</div>							
						<div class="col-md-9">
							<span class="form-control no-border"> {{$bmi }} - <strong class="{{$color}}"> {{$weight_status}} </strong></span> 
						</div>
					</div>


					<div class="row px-3 pt-5">
						<h2>Results </h2>
					</div>
					
					

					<div class="row px-3 pt-5">
						<div class="col-md-12 report_title">		
							<h5 class="mb-0">Type II Diabetes & Arterial Assessment </h5>
						</div>
					</div>

					<div class="row px-3">
						<!-- <div class="col-md-6 blue-border">
							<label class="col-form-label"> Overall Blood Pressure </label>
							<div class="row_nopadding">
								<div class="col-md-6 form-control text-center no-border">
									<div id="preview-textfield1" class="reset" style="font-size: 41px;">1,250</div>
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview1"></canvas>						
									</div>
								</div>

								<div class="col-md-6 form-control text-center no-border">
									<div id="preview-textfield2" class="reset" style="font-size: 41px;">1,250</div>
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview2"></canvas>						
									</div>
								</div>	
							</div>													
						</div> -->


						<div class="col-md-4 blue-border">
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
						

						<div class="col-md-4 blue-border">
							<label class="col-form-label report_sub_title"> <h6 class="mb-0">Overall Blood Pressure</h6> </label>
							<div class="row">
								<div class="form-control text-center  pt-3 pb-3 canvas_container">
									
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview2"></canvas>						
									</div>
									<div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 30 &nbsp  100% </div>  </div>
									<div id="preview-textfield2" class="reset" style="display:none;"></div>
									<div class="reset">{{ $overall_blood_risk_score }} </div>
									<div id="status2" class="status {{$overall_blood_risk_color}}">{{$overall_blood_risk_name}}</div>
								</div>
							</div>							
						</div>



												
						<div class="col-md-4 blue-border">
							<label class="col-form-label report_sub_title"><h6 class="mb-0"> Skin Microcirculation</h6> </label>
							<div class="row">
								<div class="form-control text-center  no-border  pt-3 pb-3 canvas_container">
									
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview3"></canvas>						
									</div>
									<div class="scale_label"> <div>0% &nbsp &nbsp 0</div>  <div class="scale_label_right"> 4 &nbsp  100% </div>  </div>
									<div id="preview-textfield3" class="reset" style="display:none;">1,250</div>
									<div class="reset"> {{$skin[0]}} </div>
									<div id="status3" class="status {{$skin[3]}}"> {{$skin[2]}}</div>
								</div>
							</div>							
						</div>

						<!-- <div class="col-md-3 blue-border">
							<label class="col-form-label report_sub_title"> <h6 class="mb-0">Arterial Stiffness</h6> </label>
							<div class="row">
								<div class="form-control text-center no-border  pt-3 pb-3 canvas_container">
									
									<div id="preview">
										<canvas width="380" height="170" id="canvas-preview4"></canvas>						
									</div>
									<div id="preview-textfield4" class="reset">1,250</div>
									<div id="status4" class="status text-success">Normal</div>

								</div>
							</div>							
						</div>	 -->
					</div>
					
					<div class="row px-3 pt-5">
						<div class="col-md-12 report_title">		
							<h5 class="mb-0">Autonomic Nerve Assessment </h5>
						</div>
					</div>
					
					<div class="row px-3">																						
							<div class="col-md-3  blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">ANS Dysfunction</h6> </label>
								<div class="row">
									<div class="form-control text-center no-border  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview5"></canvas>						
										</div>
										<div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18   100% </div>  </div>										
										<div id="preview-textfield5" class="reset" style="display:none;">1,250</div>
										<div class="reset">{{ $ans_dysfunction_risk_score }}</div>
										<div id="status5" class="status {{$ans_dysfunction_risk_color}}">{{$ans_dysfunction_risk_name}}</div>


									</div>					
								</div>							
							</div>	


							<div class="col-md-3   blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Adrenergic Sympathetic</h6> </label>
								<div class="row">
									<div class="form-control text-center no-border  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview6"></canvas>	
										</div>
										<div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 35   100% </div>  </div>
										<div id="preview-textfield6" class="reset" style="display:none;">1,250</div>
										<div class="reset">{{$adrenergic[0]}}</div>
										<div id="status6" class="status {{$adrenergic[3]}}">{{$adrenergic[2]}}</div>

									</div>
								</div>														
							</div>	


							<div class="col-md-3   blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Parasympathetic</h6> </label>
								<div class="row">
									<div class="form-control text-center no-border  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview7"></canvas>						
										</div>
										<div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 3   100% </div>  </div>
										<div id="preview-textfield7" class="reset" style="display:none;">1,250</div>
										<div class="reset">{{$para[0]}}</div>
										<div id="status7" class="status {{$para[3]}}">{{$para[2]}}</div>

									</div>
								</div>							
							</div>	


							<div class="col-md-3  blue-border">
								<label class="col-form-label report_sub_title"> <h6 class="mb-0">Cardiac Autonomic Neuropathy</h6> </label>
								<div class="row">
									<div class="form-control text-center no-border  pt-3 pb-3 canvas_container">
										
										<div id="preview">
											<canvas width="380" height="170" id="canvas-preview8"></canvas>	
										</div>
										<div class="scale_label2"> <div>0% &nbsp  0</div>  <div class="scale_label_right"> 18            100% </div>  </div>
										<div id="preview-textfield8" class="reset" style="display:none;">1,250</div>
										<div class="reset">{{$card[0]}}</div>
										<div id="status8" class="status {{$card[3]}}">{{$card[2]}}</div>
									</div>
								</div>							
							</div>


					</div>																			
			</div>
							
		</div>
	</div>
</div>






<div id="bmi_info" class="modal" data-backdrop="true" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title">BMI Information</h5>
		</div>
		<div class="modal-body text-center p-lg">
				
		<div class="padding" style="text-align:left;">
			<h2 class="text-md mb-1">What is BMI?</h2>			
			<p>BMI is a person’s weight in kilograms divided by the square of height in meters. BMI does not measure body fat directly, but research has shown that BMI is moderately correlated with more direct measures of body fat obtained from skinfold thickness measurements, bioelectrical impedance, densitometry (underwater weighing), dual energy x-ray absorptiometry (DXA) and other methods 1,2,3. Furthermore, BMI appears to be as strongly correlated with various metabolic and disease outcome as are these more direct measures of body fatness 4,5,6,7,8,9. In general, BMI is an inexpensive and easy-to-perform method of screening for weight category, for example underweight, normal or healthy weight, overweight, and obesity.</p>
			
			<h2 class="text-md mb-1 mt-2">How is BMI used?</h2>			
			<p>A high BMI can be an indicator of high body fatness. BMI can be used as a screening tool but is not diagnostic of the body fatness or health of an individual.
			To determine if a high BMI is a health risk, a healthcare provider would need to perform further assessments. These assessments might include skinfold thickness measurements, evaluations of diet, physical activity, family history, and other appropriate health screenings10.</p>

			<h2 class="text-md mb-1 mt-2">What are the BMI trends for adults in the United States?</h2>			
			<p>The prevalence of adult BMI greater than or equal to 30 kg/m2 (obese status) has greatly increased since the 1970s. Recently, however, this trend has leveled off, except for older women. Obesity has continued to increase in adult women who are age 60 years and older.
			To learn more about the trends of adult obesity, visit Adult Obesity Facts.</p>

			<h2 class="text-md mb-1 mt-2">Why is BMI used to measure overweight and obesity?</h2>
			<p>BMI can be used for population assessment of overweight and obesity. Because calculation requires only height and weight, it is inexpensive and easy to use for clinicians and for the general public. BMI can be used as a screening tool for body fatness but is not diagnostic.
			To see the formula based on either kilograms and meters or pounds and inches, visit How is BMI calculated?</p>

		
			<h2 class="text-md mb-1 mt-2">What are some of the other ways to assess excess body fatness besides BMI?</h2>
			<p>Other methods to measure body fatness include skinfold thickness measurements (with calipers), underwater weighing, bioelectrical impedance, dual-energy x-ray absorptiometry (DXA), and isotope dilution 1,2,3. However, these methods are not always readily available, and they are either expensive or need to be conducted by highly trained personnel. Furthermore, many of these methods can be difficult to standardize across observers or machines, complicating comparisons across studies and time periods.</p>
		</div>
		
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal">No</button>
		<button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
		</div>
	</div><!-- /.modal-content -->
	</div>
</div>



<form id="diabetForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/diabetreport') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
</form>

<form id="bloodPressureForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/BloodPressureReport') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
</form>

<form id="skinForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/skin') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
</form>

<form id="ansForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/ans') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
</form>

<form id="adrenergicForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/adrenergic') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
</form>

<form id="paraForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/para') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$allocation->auto_num}}"  name="allocation_id"/>
</form>

<form id="cardiacForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('subreport/cardiac') }}" enctype="multipart/form-data">
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



		var bloodPressureLabel =  {
				font: "10px sans-serif",
				labels: [0, 23, 50, 77, 100],
				fractionDigits: 0
			};
		var bloodPressureZone = [
				{strokeStyle: "#008000", min: 0, max: 23},
				{strokeStyle: "#FFFF00", min: 23, max: 50},
				{strokeStyle: "#FFA500", min: 50, max: 77},
				{strokeStyle: "#FF0000", min: 77, max: 100}
			];


		var ansDysfunctionLabel =  {
				font: "10px sans-serif",
				labels: [0, 28, 50, 78, 100],
				fractionDigits: 0
			};
		var ansDysfunctionZone = [
				{strokeStyle: "#008000", min: 0, max: 28},
				{strokeStyle: "#FFFF00", min: 28, max: 50},
				{strokeStyle: "#FFA500", min: 50, max: 78},
				{strokeStyle: "#FF0000", min: 78, max: 100}
			];


		var skinLabel =  {
				font: "10px sans-serif",
				labels: [0, 25, 50, 100],
				fractionDigits: 0
			};
		var skinZones = [				
				{strokeStyle: "#008000", min: 0, max: 25},
				{strokeStyle: "#FFFF00", min: 25, max: 50},
				{strokeStyle: "#FF0000", min: 50, max: 100}
			];

		var adrenergicLabel =  {
				font: "10px sans-serif",
				labels: [0, 24, 50, 76, 100],
				fractionDigits: 0
			};
		var ardrenergicZones = [
				{strokeStyle: "#008000", min: 0, max: 24},
				{strokeStyle: "#FFFF00", min: 24, max: 50},
				{strokeStyle: "#FFA500", min: 50, max: 76},
				{strokeStyle: "#FF0000", min: 76, max: 100}
			];

		var paraLabel =  {
				font: "10px sans-serif",
				labels: [0, 33.3, 66.6, 100],
				fractionDigits: 0
			};
		var paraZones = [
				{strokeStyle: "#008000", min: 0, max: 33.3},
				{strokeStyle: "#FFFF00", min: 33.3, max: 66.6},		
				{strokeStyle: "#FF0000", min: 66.6, max: 100}
			];


		var cardLabel =  {
				font: "10px sans-serif",
				labels: [0, 22, 50, 72, 100],
				fractionDigits: 0
			};
		var cardZones = [
				{strokeStyle: "#008000", min: 0, max: 22},
				{strokeStyle: "#FFFF00", min: 22, max: 50},
				{strokeStyle: "#FFA500", min: 50, max: 72},
				{strokeStyle: "#FF0000", min: 72, max: 100}
			];

		//initZones("canvas-preview1")
		myInit("canvas-preview1", "preview-textfield1", "{{$diabet_risk_percent}}" , diabetLabel, diabetZone);
		myInit("canvas-preview2", "preview-textfield2", "{{$overall_blood_risk_percent}}" , bloodPressureLabel, bloodPressureZone);
		myInit("canvas-preview3", "preview-textfield3", "{{$skin[1]}}" , skinLabel, skinZones);
		//myInit("canvas-preview4", "preview-textfield4");
		myInit("canvas-preview5", "preview-textfield5", "{{ $ans_dysfunction_risk_percent}}" , ansDysfunctionLabel, ansDysfunctionZone);
		myInit("canvas-preview6", "preview-textfield6", "{{ $adrenergic[1] }}" , adrenergicLabel, ardrenergicZones);
		myInit("canvas-preview7", "preview-textfield7", "{{$para[1]}}" , paraLabel, paraZones);
		myInit("canvas-preview8", "preview-textfield8","{{$card[1]}}" , cardLabel, cardZones);

		$("#canvas-preview1").click(function(){
			document.getElementById("diabetForm").submit();
		});
		$("#canvas-preview2").click(function(){
			document.getElementById("bloodPressureForm").submit();
		});
		$("#canvas-preview3").click(function(){
			//skin
			document.getElementById("skinForm").submit();
		});
		$("#canvas-preview4").click(function(){
		
		});
		$("#canvas-preview5").click(function(){
			document.getElementById("ansForm").submit();
		});
		$("#canvas-preview6").click(function(){
			document.getElementById("adrenergicForm").submit();
		});
		$("#canvas-preview7").click(function(){
			document.getElementById("paraForm").submit();
		});
		$("#canvas-preview8").click(function(){
			document.getElementById("cardiacForm").submit();
		});	
		$("#bmi_info").click(function(){			
		});

	});
	function newPatient(){
		window.location.href = "{{ URL::to('office/addPatient') }}";
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



	function initZones(id){
		//document.getElementById("class-code-name").innerHTML = "Gauge";
		demoGauge = new Gauge(document.getElementById(id));
		var opts = {
		angle: -0.25,
		lineWidth: 0.2,
		radiusScale:0.9,
		pointer: {
			length: 0.6,
			strokeWidth: 0.15,
			color: '#000000'
		},
		staticLabels: {
			font: "10px sans-serif",
			labels: [200, 500, 2100, 2800],
			fractionDigits: 0
		},
		staticZones: [
			{strokeStyle: "#F03E3E", min: 0, max: 200},
			{strokeStyle: "#FFDD00", min: 200, max: 500},
			{strokeStyle: "#30B32D", min: 500, max: 2100},
			{strokeStyle: "#FFDD00", min: 2100, max: 2800},
			{strokeStyle: "#F03E3E", min: 2800, max: 3000}
		],
		limitMax: false,
		limitMin: false,
		highDpiSupport: true
		};
		demoGauge.setOptions(opts);
		demoGauge.setTextField(document.getElementById("preview-textfield"));
		demoGauge.minValue = 0;
		demoGauge.maxValue = 3000;
		demoGauge.set(1250);
  	};
    

	
</script>

@stop
