@extends('admin.main')
@section('content')     
   
<div class="page-container" id="page-container">

	<div class="page-title padding pb-0 ">

	</div>
	


    <div class="card">
        <div class="card-header">
        <strong id="step_title"> Upload File </strong>
        </div>
        
        <div class="card-body">
            <form action="{{url('import/import')}}" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">

                        <div class="form-control">
                            {{csrf_field()}}
                            <input type="file" class="" name="imported-file" required="required"/>
                        </div>
                    </div>


                    <div class="form-group">                    
                        <button class="btn btn-primary" type="submit">Import</button>
                    </div>

                    
            </form>
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