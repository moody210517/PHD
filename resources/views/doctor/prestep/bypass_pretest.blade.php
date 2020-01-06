@extends('admin.main')
@section('content')   


<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">
																
				
				<form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/prestep3') }}" enctype="multipart/form-data">					
					@csrf
					<input type="hidden" value="{{$patient->id}}" id="patient_id" name="patient_id" />
					<input type = "hidden" value="exist" name="user_type" />				

					<div class="page-title padding pb-0 ">
						<h2 class="text-md mb-0"> Do you wish to bypass the pre-test questions </h2>
					</div>

					<div class="padding">																	
						<div class="col-md-12 mt-4 text-center">
							<button type="button" class="btn col-md-2 mb-1 btn-primary" onclick="back()"> Back </button>		
							<button type="button" class="btn col-md-2 mb-1 btn-primary" onclick="goToStep()"> Yes </button>		
							<button type="button" class="btn col-md-2 mb-1 btn-primary" onclick="goToPreTest()"> No </button>									
						</div>
					</div>												
				</form>
				
			<div>		
		</div>
	
</div>



<form id="pretest" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/gopretest') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$patient->id}}"  name="patient_id"/>
</form>


<form id="steps" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/steps') }}" enctype="multipart/form-data">

	@csrf
	<input type="hidden" id="pid" value="{{$patient->id}}"  name="pid"/>
	<input type="hidden" id="visit_form_id"  value="{{$visit_form_id}}"   name="visit_form_id"/>
	<input type="hidden" id="diabet_risk_id" value="{{$diabet_risk_id}}"   name="diabet_risk_id"/>
</form>

<form id="step1Form" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/prestep1') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$patient->id}}"  name="id"/>
</form>


@stop



@section('script')

<script type="text/javascript">   
    $(document).ready(function() {        
		var today = new Date();
		var date = today.getFullYear()+'-'+(getTwoString(today.getMonth()+1))+'-'+ getTwoString(today.getDate());
		var time = getTwoString(today.getHours()) + ":" + getTwoString(today.getMinutes()) + ":" + getTwoString(today.getSeconds());
		$("#date").val(date);
		$("#time").val(time);
	});
		
	function goToPreTest(){
		//window.location.href = "{{ URL::to('doctor/prestep1') }}";
		
		document.getElementById("pretest").submit();
	}

	function goToStep(){
		//window.location.href = "{{ URL::to('doctor/prestep1') }}";		
		document.getElementById("steps").submit();
	}

	function back(){
		//window.location.href = "{{ URL::to('doctor/prestep1') }}";
		document.getElementById("step1Form").submit();
	}
	
	
</script>

@stop
