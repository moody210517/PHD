@extends('admin.main')
@section('content')     
    <div class="page-container card" id="page-container">
        <div class="page-title padding pb-0">
            <h2 class="text-md mt-2">
                SELECT PAST TEST DATE
            </h2>
            <h2 class="text-md">                
                Please choose from one of the tests below to edit.            
            </h2>

            <h2 class="text-md pt-2 mb-3">
                Patient Name : {{$patient->first_name.", ".$patient->last_name}}
            </h2>
        </div>


        <div class="padding pt-1 ">
            <div class="table-responsive">        
                <div class="pt-0 pb-1 py-2 text-right">
                    <button id="cancelTest" class="btn btn-primary w-xs " data-toggle="modal" data-target="#m" >Cancel</button>
                </div>

                
                <!-- datatable_testlists -->
                <table id="datatable_testlists" class="table table-theme table-row v-middle" data-plugin="dataTable" style="margin-top: -15px;">
                
                <!-- <table class="table table-theme v-middle" data-plugin="bootstrapTable"
                    id="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-search-align="left"
                    data-show-columns="true"
                    data-show-export="false"
                    data-detail-view="false"
                    data-mobile-responsive="true"
                    data-pagination="true"
                    data-page-list="[10, 25, 50, 100, ALL]"
                    >-->
                    <thead>
                        <tr>                            
                            <th class="">                                
                                <!-- <label class="ui-check m-0 ">                               
                                    <input  type="checkbox" class="group-checkable"/>
                                    <i></i>
                                </label>                                    -->
                            </th>

                            <th><span class="text-muted">Date of Exam</span></th>
                            <th><span class="text-muted">Time of Exam</span></th>                                                        
                            <th><span class="text-muted">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allocations as $allocation)
                            <tr>
                                
                                <td>
                                    
                                </td>

                                <td>
                                {{ substr($allocation->created_at, 0, 10) }}
                                </td>
                                <td>
                                {{ substr($allocation->created_at, 10 , 9) }}
                                </td>
                                <td>
                                    <button onClick="review({{$allocation->auto_num}})" class="btn btn-primary w-xs mx-3" data-toggle="modal">View</button>
                                </td>
                            </tr>
                        
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

      

        <div class="padding pt-0">
            <span id="alert_choose" class="text-danger" style=" display: none;">Please select a test date to edit</span>
        </div>
        
        <div class="padding pt-0 text-center">
            
        </div>

    </div>

<!-- modal -->
<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure you wish to cancel  this test?</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        <button id="cancelBtn" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Yes</button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>



<form id="reviewFrom" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('report/review') }}" enctype="multipart/form-data">
	@csrf    	
    <input type="hidden" id="allocation_id" name="allocation_id"  />
    <input type="hidden" value="review" name="page_type"  />
</form>

@stop


@section('script')

<script type="text/javascript">   

    $(document).ready(function() {  
        // $('#datatable_testlists').dataTable({     
        //     "iDisplayLength": 25
        // });
    });

    $("#cancelBtn").click(function(){
        window.location.href = "{{ URL::to('Testreview/TestPatients')}}"
    });
            
    function review(id){
        $("#allocation_id").val(id);        
        document.getElementById("reviewFrom").submit();   
    }
        
    var allocation_id ;
    $(document).on('click', '.group-checkable', function () {        
        var checked = $(this).is(":checked");
        var value = $(this).val();
        $checkBoxs = $(this).closest("table").find("tbody .checkboxes");        
        $checkBoxs.each( function () {
            $( this ).prop( "checked", checked);
        });

        // only enable button when choose a row
        document.getElementById("cancelTest").disabled = true;
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if (checked) {                
                document.getElementById("cancelTest").disabled = false;
                
            } else {                     
            }
        });
    });    
    
    $(document).on('click', '.checkboxes', function () {
        $checkBoxs = $(this).closest("table").find("tbody .checkboxes");   
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if(checked){
                document.getElementById("editTest").disabled = false;
                allocation_id = value;
                $("#alert_choose").hide();
            }      
        });        
    });     
 
    var deleteId = "";
    var $checkBoxs;

    function cancelTest(id){
        deleteId = id;
    }


    $("#delBtn").click(function(){    
        var ids = [];
        //var $checkBoxs = $(this).closest("table").find("tbody .checkboxes");
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if (checked) {                
                ids.push(value);
                //$(this).attr("checked", true);
                //$(this).parents('tr').addClass("active");
            } else {
                //$(this).attr("checked", false);
                //$(this).parents('tr').removeClass("active");
            }
        });


        var id = deleteId;
        //var request = $.get('{{ URL::to('admin/cancelTest')}}' + "?id=" + id);
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
          type: 'POST',
          data: { id:ids},
          url: "{{ URL::to('api/deletePatient')}}",
          success: function(result) {     
                var res = result.results;
                if(res == 200){
                    location.reload();
                }else{
                    alert("Failed");
                }
          }

        });
    });             
</script>

@stop