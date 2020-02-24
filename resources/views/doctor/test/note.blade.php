@extends('admin.main')
@section('content')   


<div class="">
	<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>
		
		<div class="page-container">
			<div class="bg-white pt-4 pb-5">

				
				
								
				<form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('report/savenote') }}" enctype="multipart/form-data">
				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0">Pre-Test Patient Information </h2>
				</div>
				
				<div class="col-md-12 mt-2 text-right">
          <button type="submit" class="btn col-md-2 mb-1 btn-primary"> Save </button>		
          <button type="button" class="btn col-md-2 mb-1 btn-primary" onclick="cancel();"> Cancel </button>												
          <!-- data-toggle="modal" data-target="#m" -->
				</div>

				@csrf
				<input type="hidden" value="{{$patient->id}}" id="patient_id" name="patient_id" />
        <input type = "hidden" value="exist" name="user_type" />
        <input type = "hidden" value="{{$allocation_id}}" name="allocation_id" id="allocation_id" />

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

            <div class="row px-3 pt-2">
              <div class="col-md-3">
                <label class="col-form-label"> BMI </label>
                <!-- <i class="ml-2 mr-2 i-con i-con-info" data-toggle="modal" data-target="#bmi_info"><i class="i-con-border"></i></i> -->
              </div>							
              <div class="col-md-9">
                <span class="form-control no-border"> {{$bmi }} - <strong class="{{$color}}"> {{$weight_status}} </strong></span> 
              </div>
            </div>
            
												
																		
				</div>



				<div class="padding">				
          <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0"></h2>
          </div>
            

         
          <div class="col-md-12">
          <div class="form-group">
              <label>Healthcare Professional Notes</label>
              <textarea class="form-control" name="notes" rows="6" data-minwords="6" required="" placeholder="Type your message" required> {{ $notes }} </textarea>
            </div>  
          </div>
            
                 

				</div>
				
				


				</form>
						
				
			<div>		
		</div>
	
</div>


<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure you wish to cancel?</h5>
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
  
  function cancel(){
    var allocation_id = $("#allocation_id").val();
	window.history.back();
    //window.location.href ="http://" +  window.location.host + "/phd/report/review/" + allocation_id;    
  }
	
</script>

@stop
