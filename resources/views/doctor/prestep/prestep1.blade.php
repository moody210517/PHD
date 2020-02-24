@extends('admin.main')
@section('content')   

<div class="">

	<div class="page-container">
		<div class="bg-white pt-4 pb-5">
						
				<div class="page-title padding pb-0 ">
					<h2 class="text-md mb-0">Test Menu</h2>
				</div>

				<input type="hidden" value="{{ Session::get('company_id') }}"  id="company_id"/>

				<div class="padding">
					<form  method="post" action="{{ url('doctor/prestep2') }}" enctype="multipart/form-data">			
					@csrf

					
					<div class="row row-sm">					
							<div class="col-md-4 text-center"></div>
							<div class="col-md-4 text-center">
								<label> Please Select a Patient </label>
								<select id="pid" name="pid"  data-plugin="select2" data-option="{}"  class="form-control mt-2" required="required">
										@foreach($patients as $c)
											<option value="{{$c->id}}" style="color:black;" <?php if($id == $c->id) {echo 'selected';}  ?> > {{$c->first_name.", ".$c->last_name}} </option>

										@endforeach                                         
								</select>                                        
							</div>

							<div class="col-md-12 mt-4 text-center">
								<button type="button" class="btn col-md-3 mb-1 btn-primary" onClick="choosePatient();"> Next </button>		
								
							</div>
						
					</div>
					</form>
				</div>

		</div>
	</div>
</div>


<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Do no hook up GSR sensors to patient as their pace maker will affect the results. </h5>
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



<form id="nextStep" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('doctor/prestep2') }}" enctype="multipart/form-data">
	@csrf

	<input type = "hidden" value="exist" name="user_type" />
	<input type = "hidden"  name="patient_id" id="patient_id" />

</form>


@stop



@section('script')

<script type="text/javascript">

    $(document).ready(function() {       

	});

	
	$("#closeTest").click(function(){		
		document.getElementById("nextStep").submit();
	});


	function choosePatient(){		
		var pid = $("#pid").val();
		$("#patient_id").val(pid);
		var patients = <?php echo json_encode($patients); ?>;
		for(var i = 0; i < patients.length; i++) {
			if(patients[i].id == pid){
				if( patients[i].placemaker == 1){
					$("#m").modal();
				}else{
					document.getElementById("nextStep").submit();
				}				
			}
		}
				

	}
		
</script>

@stop
