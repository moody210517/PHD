@extends('admin.main')
@section('content')   


<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">

				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0">Type II Risk Assessment </h2>
				</div>
								
				<form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/editVisitForm') }}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" value="{{$patient->id}}" id="patient_id" name="patient_id" />
				<input type="hidden" value="{{$allocation_id}}" id="allocation_id" name="allocation_id" />
				<input type = "hidden" value="exist" name="user_type" />

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
								<input type="date" id="date" name="date" class="form-control"  disabled>
							</div>                    
						</div>

						<div class="row px-3 pt-2">
							<div class="col-md-3">
								<label class="col-form-label"> Time of Exam</label>
							</div>
							
							<div class="col-md-9">
								<input type="time" id="time" name="time" class="form-control"  disabled>
							</div>                    
						</div>

						
						<div class="row px-3 ">	
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
							<div class="col-md-6 pt-2">
								<input type="text" id="weight" name="weight" value="{{$patient->weight}}" class="form-control" >
							</div>            

							<div class="col-md-3 pt-2">								
								<button type="button" id="btnUpdateWeight" class="btn mb-1 btn-primary col-md-12" > Update Weight </button>		
							</div>
						</div>



						<div class="row px-3 pt-2">
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
						
						
						
				</div>

				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0"> Required Informations for Type II Risk </h2>
				</div>


				<div class="padding">				
												
						<div class="row px-3">
							<div class="col-md-5">
								<label class="col-form-label"> Waist circumference </label>
							</div>							
							<div class="col-md-7">
								<input type="number" name="waist" class="form-control" value="{{ $user_diabet->first()? $user_diabet->first()->waist:'' }}" placeholder="Waist">
							</div>  
						</div>

						<div class="row px-3 pt-2">
							<div class="col-md-5">
								<label class="col-form-label"> Use of blood pressure medication </label>
							</div>							
							<div class="col-md-7">
								<select id="bpmeds" name="bpmeds"  data-plugin="select2" data-option="{}"  class="form-control mt-2" required="required">
									<option disabled selected value> -- select an option -- </option>
									<option value="1" <?php  if($user_diabet->first() && $user_diabet->first()->bpmeds == 1) { echo "selected"; } ?> > Yes </option>
									<option value="0"  <?php  if($user_diabet->first() && $user_diabet->first()->bpmeds == 0) { echo "selected"; } ?> > No </option>										
								</select>																
							</div>                    
						</div>


						<div class="row px-3 pt-2">
							<div class="col-md-5">
								<label class="col-form-label"> History of high blood glucose </label>
							</div>							
							<div class="col-md-7">
								<select id="glucose" name="glucose"  data-plugin="select2" data-option="{}"  class="form-control mt-2" required="required">
									<option disabled selected value> -- select an option -- </option>
									<option value="1" <?php  if($user_diabet->first() && $user_diabet->first()->glucose == 1) { echo "selected"; } ?> > Yes </option>
									<option value="0"  <?php  if($user_diabet->first() && $user_diabet->first()->glucose == 0) { echo "selected"; } ?> > No </option>										
								</select>																
							</div>                    
						</div>
															

						<div class="row px-3 pt-2">
							<div class="col-md-5">
								<label class="col-form-label"> Daily consumption of vegetables, fruits, or berries </label>
							</div>							
							<div class="col-md-7">
								<select id="vegetable" name="vegetable"  data-plugin="select2" data-option="{}"  class="form-control mt-2" required="required">
									<option disabled selected value> -- select an option -- </option>
									<option value="1" <?php  if($user_diabet->first() && $user_diabet->first()->vegetable == 1) { echo "selected"; } ?> > Yes </option>
									<option value="0"  <?php  if($user_diabet->first() && $user_diabet->first()->vegetable == 0) { echo "selected"; } ?> > No </option>										
								</select>																
							</div>                    
						</div>	
												
						<div class="row px-3 pt-2">
							<div class="col-md-5">
								<label class="col-form-label"> Family history of diabetes </label>
							</div>							
							<div class="col-md-7">
								<select id="family" name="family"  data-plugin="select2" data-option="{}"  class="form-control mt-2" required="required">
									<option disabled selected value> -- select an option -- </option>
									<option value="0"  <?php  if($user_diabet->first() && $user_diabet->first()->family == 0) { echo "selected"; } ?> > No </option>
									<option value="2" <?php  if($user_diabet->first() && $user_diabet->first()->family == 2) { echo "selected"; } ?> > Yes - 1st Degree Relative  </option>
									<option value="1" <?php  if($user_diabet->first() && $user_diabet->first()->family == 1) { echo "selected"; } ?> > Yes - 2nd Degree Relative </option>

									

								</select>																
							</div>                    
						</div>	

				</div>
				
				
				<div class="col-md-12 mt-4 text-center">
					<button type="button" class="btn col-md-2 mb-1 btn-primary" data-toggle="modal" data-target="#m"> Cancel </button>		
					<button type="button" class="btn col-md-2 mb-1 btn-primary" onclick="back()"> Back </button>		
					<button type="submit" class="btn col-md-2 mb-1 btn-primary"> Next </button>		
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





<form id="step1Form" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/testlists') }}" enctype="multipart/form-data">
	@csrf
	<input type="hidden" id="" value="{{$patient->id}}"  name="patient_id"/>
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


	$("#btnUpdateWeight").click(function(){
				
		var patient_id = $("#patient_id").val();
		var weight = $("#weight").val();

		
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
            type: 'POST',
            data: { patient_id:patient_id, weight:weight},
            url: "{{ URL::to('api/updateWeight')}}",
            success: function(result) {     
                    var res = result.results;
                    if(res == 200){
                        //alert("Ok");                
                    }else{
                        alert("Failed");
                    }
            }

		});    
		
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
		//window.location.href = "{{ URL::to('doctor/prestep1') }}";
		document.getElementById("step1Form").submit();
	}
	
</script>

@stop
