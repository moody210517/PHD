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
					<div class="row row-sm">
								
						<div class="col-md-12 pt-3 text-center">
							<button class="btn col-md-4 mb-1 btn-primary" onclick="newPatient()" >Test for New Patient</button>		
						</div>

						<div class="col-md-12 pt-3 text-center">
							<button class="btn  col-md-4 mb-1 btn-primary" onclick="existPatient()">Test for Existing Patient</button>		
						</div>
						<div class="col-md-12 pt-3 text-center">
							<button class="btn col-md-4 mb-1 btn-primary" onclick="pastTest()">Edit Past Tests</button>		
						</div>
						
					</div>
				</div>

		</div>
	</div>
</div>

@stop



@section('script')

<script type="text/javascript">   
    $(document).ready(function() {        
	});
	function newPatient(){
		window.location.href = "{{ URL::to('office/addPatient') }}";
	}

	function existPatient(){
		window.location.href = "{{ URL::to('doctor/prestep1') }}";
	}

	function pastTest(){
		window.location.href = "{{ URL::to('doctor/pastTest') }}";
	}
	
</script>

@stop
