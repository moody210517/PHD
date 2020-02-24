@extends('admin.main')
@section('content')
<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">

				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0">TEST FOR NEW PATIENT <br> Patient Visit Purpose </h2>
				</div>
				
				<form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/prestep4') }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" id="patient_id" value="{{$patient->id}}"  name="patient_id"/>
				<input type="hidden" id="tester_id" value="{{$tester_id}}"  name="tester_id"/>
				<input type="hidden" id="visit_form_id" value="{{$visit_form->id}}"  name="visit_form_id"/>
				<div class="padding">
					
						<div class="row px-3">
							<div class="col-md-3">
								<label class="col-form-label"> Patient Name </label>
							</div>
							
							<div class="col-md-9">
								<input type="text" name="first_name" class="form-control" value="{{$patient->first_name.' '.$patient->last_name}}" placeholder="First Name" disabled>
							</div> 
							                   
						</div>

						

						
						<div class="row px-3 pt-2" id="div_activity_level">
							<div class="col-md-3">
								<label class="col-form-label"> Daily  Activity Level </label>
							</div>				

							<div class="col-md-9">

								<div class="radio mt-2">
									<label class="ui-check ui-check-md" >
									<input type="radio" name="a" <?php if($visit_form->daily_activity == '1') { echo 'checked';} ?>  class="activity_level" >
									<i class="dark-white"></i>
									Very little to no activity
									</label>								
								</div>

								<div class="radio">
									<label class="ui-check ui-check-md">
									<input type="radio" name="a" <?php if($visit_form->daily_activity == '2') { echo 'checked';} ?>  class="activity_level">
									<i class="dark-white"></i>
									Very light activity/Office activity
									</label>				
								</div>

								<div class="radio">
									<label class="ui-check ui-check-md">
									<input type="radio" name="a" <?php if($visit_form->daily_activity == '3') { echo 'checked';} ?>  class="activity_level">
									<i class="dark-white"></i>
									Moderate activity: 20 minutes per day/2 hours per week 
									</label>								
								</div>

								<div class="radio">
									<label class="ui-check ui-check-md">
									<input type="radio" name="a" <?php if($visit_form->daily_activity == '4') { echo 'checked';} ?>  class="activity_level">
									<i class="dark-white"></i>
									Exercise: 2-4 hours per week
									</label>								
								</div>

								<div class="radio">
									<label class="ui-check ui-check-md">
									<input type="radio" name="a" <?php if($visit_form->daily_activity == '5') { echo 'checked';} ?>  class="activity_level">
									<i class="dark-white"></i>
									High exercise level: greater than 4 hours per week
									</label>								
								</div>

								<span id="alert_level" class="text-danger" style=" display: none;">Please select a daily activity level</span>

							</div>                    
						</div>



						<div class="row px-3 pt-2" id="div_visit_purpose" style="display:none">
							<div class="col-md-3">
								<label class="col-form-label"> Reason for Visit </label>
							</div>				

							<div class="col-md-9">								
								<div class="radio mt-2">
									<label class="ui-check ui-check-md">
									<input id="rd_checkup" type="radio" name="rd_visit_step" class="visit_step">
									<i class="dark-white"></i>
									Check Up
									</label>								
								</div>

								<div class="checkbox">
									<label class="ui-check ui-check-md">
									<input id="chk_symptoms" type="checkbox"  class="visit_purpose" <?php if($visit_form->symptoms != null ) { echo 'checked';} ?> >
									<i class="dark-white"></i>
									Symptoms review
									</label>
								</div>
								<div class="checkbox">
									<label class="ui-check ui-check-md">
									<input id="chk_disease" type="checkbox"  class="visit_purpose" <?php if($visit_form->disease != null ) { echo 'checked';} ?> >
									<i class="dark-white"></i>
									Disease review
									</label>
								</div>
								<div class="checkbox">
									<label class="ui-check ui-check-md">
									<input id="chk_treatment" type="checkbox" class="visit_purpose" <?php if($visit_form->treatment != null ) { echo 'checked';} ?> >
									<i class="dark-white"></i>
									Follow-up for treatment
									</label>
								</div>
								<span id="alert_visit" class="text-danger" style=" display: none;">Please select a purpose for the visit</span>								
								
							</div>                    
						</div>			
						
						
						<div class="row px-3 pt-2" id="div_visit_symptoms" style="display:none">
							<div class="col-md-3">
								<label class="col-form-label"> Symptoms </label>
							</div>				

							<div class="col-md-9 mt-2" >	
								<select class="form-control visit_symptoms" id="ddd" multiple data-plugin="select2" data-option="{}" data-allow-clear="true" style="width:100% !important;">
									@foreach($symptoms as $item)
										<option value="{{$item->id}}" <?php $items = explode(":", $visit_form->symptoms); if( in_array($item->id, $items) ) { echo "selected"; }  ?>   >{{$item->title}}</option>								
									@endforeach			
								</select>											
								<span id="alert_symptoms" class="text-danger" style=" display: none;"> Please select at least one option. </span>

							</div>                    
						</div>	

						<div class="row px-3 pt-2" id="div_visit_disease" style="display:none">
						
							<div class="col-md-3">
								<label class="col-form-label"> Disease </label>
							</div>

							<div class="col-md-9 row  mt-2">	
								<select class="form-control visit_disease" multiple data-plugin="select2" data-option="{}" data-allow-clear="true" style="width:100% !important;">
									@foreach($disease as $item)
										<option value="{{$item->id}}" <?php $items = explode(":", $visit_form->disease); if( in_array($item->id, $items) ) { echo "selected"; }  ?>  >{{$item->title}}</option>								
									@endforeach			
								</select>																								
							</div>
							<div class="col-md-3"></div>
							<div class="col-md-9">
								<span id="alert_disease" class="text-danger" style=" display: none;"> Please select at least one option. </span>
							</div>
							
						</div>	

						<div class="row px-3 pt-2" id="div_visit_treatment" style="display:none">
							<div class="col-md-3">
								<label class="col-form-label"> Treatment </label>
							</div>				

							<div class="col-md-9  mt-2">	

								<select class="form-control visit_treatment"  multiple data-plugin="select2" data-option="{}" data-allow-clear="true" style="width:100% !important;">
									@foreach($treatment as $item)
										<option value="{{$item->id}}"  <?php $items = explode(":", $visit_form->treatment); if( in_array($item->id, $items) ) { echo "selected"; }  ?>  >{{$item->title}}</option>
									@endforeach			
								</select>

							</div>
							<div class="col-md-3"></div>
							<div class="col-md-9">
							<span id="alert_treatment" class="text-danger" style=" display: none;"> Please select at least one option. </span>
							</div>
							
						</div>	

				</div>
								
				<div class="col-md-12 mt-4 text-center">
					<button type="button" class="btn col-md-2 mb-1 btn-primary" data-toggle="modal" data-target="#m"> Cancel </button>							
					<button type="button" class="btn col-md-2 mb-1 btn-primary" id="btnBack" name="btnBack"> Back </button>		
					<button type="button" id="next" class="btn col-md-2 mb-1 btn-primary" name="next"> Next </button>		
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


<input type="hidden" value="{{$user_type}}" name="user_type" id="user_type" />

<form id="myform" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('report/review') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="pid" value="{{$allocation_id}}"  name="allocation_id"/>
	<input type="hidden" id="pid" value="edit"  name="page_type"/>

</form>


<form id="editPatientForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('office/editPatient', ['patient_id' => $patient->id ] ) }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="back"  name="page_type"/>
</form>


<form id="diabetForm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/editDiabetForm') }}" enctype="multipart/form-data">	
	@csrf
	<input type="hidden" id="" value="edit"  name="user_type"/>
	<input type="hidden" id="" value="{{$patient->id}}"  name="patient_id"/>
	<input type="hidden" id="" value="{{$allocation_id}}"  name="allocation_id"/>	
</form>


@stop


@section('script')

<script type="text/javascript">   

	var currentPage = 1;	
	var activity_level = 0;	
	var visitArray = [];
    $(document).ready(function() {        
		var today = new Date();
		var date = today.getFullYear()+'-'+(getTwoString(today.getMonth()+1))+'-'+ getTwoString(today.getDate());
		var time = getTwoString(today.getHours()) + ":" + getTwoString(today.getMinutes()) + ":" + getTwoString(today.getSeconds());
		$("#date").val(date);
		$("#time").val(time);
		initPageType();		
	});

	$("#closeTest").click(function(){
		window.location.href = "{{ URL::to('doctor/testland') }}";
	});
	
	// for symptoms , disease, treatment checkbox
	$(".visit_purpose").change(function() {
        var checked = $(this).is(":checked");		
		$('.visit_step').prop('checked', false);	
		initPageType();	
		$('#alert_visit').hide();
	});
	
	// for Check Up radio box
	$(".visit_step").change(function(){
		var checked = $(this).is(":checked");
		$(".visit_purpose").prop('checked', false);		
		initPageType();
		$('#alert_visit').hide();
	});

	$(".activity_level").change(function(){
		$('#alert_level').hide();
	});

	
	
	$("#btnBack").click(function(){
		if(currentPage == 1){			
			var user_type = $("#user_type").val();
			var patient_id = $("#patient_id").val();
			if(user_type == "new"){
				document.getElementById("editPatientForm").submit();
			}else{
				document.getElementById("diabetForm").submit();				
			}			
		}else{

			$("#div_visit_disease").hide();
			$("#div_visit_treatment").hide();
			$("#div_visit_symptoms").hide();	
			
			if( $("#div_visit_purpose").is(':visible') ){

				$("#div_activity_level").show();
				$("#div_visit_purpose").hide();				
				currentPage = 1;
			}else{

				$("#div_activity_level").hide();
				$("#div_visit_purpose").show();	
				initPageType();
			}			
		}
	});

	var page_index = 0; // initial status of the purpose type page (0: symptoms, 1: disease, 2:treatment )	
	$("#next").click(function(){
		if(currentPage == 1){
			//div_activity_level
			var index = 0;
			$(".activity_level").each(function(){
				var checked = $(this).is(":checked");				
				if(checked){
					activity_level = index + 1; 
				}
				index++;
			});
			if(activity_level != 0){
				$("#div_activity_level").hide();
				$("#div_visit_purpose").show();	
				var symptoms = $("#chk_symptoms").is(":checked");
				var disease = $("#chk_disease").is(":checked");
				var treatment = $("#chk_treatment").is(":checked");
				if( !symptoms && !disease && !treatment ){
					$('#rd_checkup').prop( "checked", true);
				}
				currentPage = 2;			
			}else{
				$('#alert_level').show()
			}
		}else{
				var checkup = $("#rd_checkup").is(":checked");
				var symptoms = $("#chk_symptoms").is(":checked");
				var disease = $("#chk_disease").is(":checked");
				var treatment = $("#chk_treatment").is(":checked");
				
				
				if( !checkup && !symptoms && !disease && !treatment){
					$('#alert_visit').show();
					return;
				}

				if(checkup || !symptoms && !disease && !treatment ){										 
					goToNextTest();			
				}else{					
					// hide the "Reason for Visit" section
					if(page_index <= getSelectedCount() + 1){
						var visitId = getVisitInfoByPageNumber(page_index);
						if(visitId == 0){
							$("#div_visit_purpose").hide();
							$("#div_visit_disease").hide();
							$("#div_visit_treatment").hide();
							$("#div_visit_symptoms").show();
						
						}else if(visitId == 1){
							if(preCheck()){
								return;
							}									
							$("#div_visit_purpose").hide();
							$("#div_visit_disease").show();
							$("#div_visit_treatment").hide();
							$("#div_visit_symptoms").hide();
						}else if(visitId == 2){ 
							if(preCheck()){
								return;
							}
							$("#div_visit_purpose").hide();
							$("#div_visit_disease").hide();
							$("#div_visit_treatment").show();
							$("#div_visit_symptoms").hide();
						}else{
							if(preCheck()){
								return;
							}	
							goToNextTest();
						}
						page_index++;
					}else{
						if(preCheck()){
							return;
						}	
						goToNextTest();
					}
					
				}
		}
		
	});

	function preCheck(){
		if(page_index != 0){
			var pre = getVisitInfoByPageNumber(page_index -1);
			if(pre == 0){
				if( $('.visit_symptoms').val() == null || $('.visit_symptoms').val() == ''){
					$("#alert_symptoms").show();
					return true;
				}
			}else if(pre == 1){
				if( $('.visit_disease').val() == null || $('.visit_disease').val() == ''){
					$("#alert_disease").show();
					return true;
				}
			}else if(pre == 2){
				if( $('.visit_treatment').val() == null || $('.visit_treatment').val() == ''){
					$("#alert_treatment").show();
					return true;
				}
			}
		}
		return false;
	}

	function goToNextTest(){
					var symptoms_value;
					var disease_value;
					var treatment_value ;
					
					var symptoms = $("#chk_symptoms").is(":checked");
					var disease = $("#chk_disease").is(":checked");
					var treatment = $("#chk_treatment").is(":checked");

					var index = 0;
					if(symptoms){
						var symptoms = $(".visit_symptoms").val();
						for (var i=0, iLen=symptoms.length; i<iLen; i++) {
							if(i == 0){
								symptoms_value = symptoms[i];	
							}else{
								symptoms_value = symptoms_value + ":" + symptoms[i];
							}	
						}						
					}
					
					 
					var index2 = 0;
					if(disease){
						var diseases = $(".visit_disease").val();
						for (var i=0, iLen=diseases.length; i<iLen; i++) {
							if(i == 0){
								disease_value = diseases[i];	
							}else{
								disease_value = disease_value + ":" + diseases[i];
							}	
						}	
					}
					

					var index3 = 0;
					if(treatment){
						var treatments = $(".visit_treatment").val();
						for (var i=0, iLen=treatments.length; i<iLen; i++) {
							if(i == 0){
								treatment_value = treatments[i];	
							}else{
								treatment_value = treatment_value + ":" + treatments[i];
							}	
						}
					}

					var patient_id = $("#patient_id").val();
					var tester_id = $("#tester_id").val();
					var visit_form_id= $("#visit_form_id").val();
					$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
					});

					$.ajax({
						type: 'POST',
						data: {tester_id:tester_id, patient_id:patient_id , symptoms:symptoms_value, disease:disease_value, treatment:treatment_value , visit_form_id:visit_form_id, daily_activity:activity_level},
						url: "{{ URL::to('api/editVisitForm')}}",
						success: function(result) {
								var res = result.results;
								if(res == 200){																
									document.getElementById("myform").submit();

								}else{
									alert("Failed");
								}
						}
					});
	}

	function isSelected(id){
		var flag = false;
		$(id).each(function(){
			var checked = $(this).is(":checked");				
			if(checked){				
				flag = true;
			}
		});
		return flag;
	}


	
		
	function initPageType(){
		visitArray = [];
		$(".visit_purpose").each(function(){			
			visitArray.push($(this).is(":checked"));					
		});				
		page_index = 0;		
	}

	function getSelectedCount(){
		var index = 0;
		for(var i = 0 ; i < visitArray.length ; i++){
			if(visitArray[i]){
				index++;
			}
		}
		return index;
	}
	function getVisitInfoByPageNumber(id){
		var index = 0;
		for(var i = 0 ; i < visitArray.length ; i++){			
			if(visitArray[i]){
				if(index == id){
					return i;
				}
				index++;
			}			
		}
	}


	function getTwoString(n){
		if(parseInt(n) > 9){
			return n;
		}else{
			return "0" + n;
		}
	}

	
	
</script>

@stop
