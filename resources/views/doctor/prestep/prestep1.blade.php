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

					<input type = "hidden" value="exist" name="user_type" />
					<div class="row row-sm">					
							<div class="col-md-4 text-center"></div>
							<div class="col-md-4 text-center">
								<label> Please Select a Patient </label>
								<select id="patient_id" name="patient_id"  data-plugin="select2" data-option="{}"  class="form-control mt-2" required="required">
										@foreach($patients as $c)
											<option value="{{$c->id}}" style="color:black;" <?php if($id == $c->id) {echo 'selected';}  ?> > {{$c->first_name.", ".$c->last_name}} </option>                        
										@endforeach                                         
								</select>                                        
							</div>

							<div class="col-md-12 mt-4 text-center">
								<button type="submit" class="btn col-md-3 mb-1 btn-primary"> Next </button>		
							</div>
						
					</div>
					</form>
				</div>


		</div>
	</div>
</div>

@stop



@section('script')

<script type="text/javascript">   
    $(document).ready(function() {        
	});
		
</script>

@stop
