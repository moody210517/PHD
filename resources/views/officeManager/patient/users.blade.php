@extends('admin.main')
@section('content')     
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0" style="padding-bottom: 35px;">
            @if($type == 'edit')            
                Edit Patient
            @elseif($type == 'delete') 
                Delete Patient
            @elseif($type == 'add') 
                
            @else
            <a href="{{ url('admin/addUser') }}" class="btn btn-primary" style="float: right;">Add Patient</a>         
            <a href="{{ url('import/index')}}" class="btn btn-primary" style="float:right;margin-right: 20px;"> Import </a>
            <a href="{{ url('import/export')}}" class="btn btn-primary" style="float:right;margin-right: 20px;"> Export </a>
            @endif
            
            </h2>
        </div>

        <div class="padding pt-0 ">
            <div class="table-responsive">
                
                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable2" style="margin-top: -15px;">

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

                            @if($type == 'delete')  
                                <th class="table-checkbox">
                                    <input type="checkbox" class="group-checkable" />
                                </th>
                            @endif
                            @if($type == 'edit')
                                <th class="table-checkbox hidden">
                                    <input type="checkbox" class="group-checkable" />
                                </th>
                            @endif

                            <th><span class="text-muted">Name</span></th>
                            <th><span class="text-muted">Email</span></th>
                            <th><span class="text-muted">User Type</span></th>
                            <th><span class="text-muted">Comapny</span></th>
                            <th><span class="text-muted">Created</span></th>
                            @if($type == 'edit')
                            <th><span class="text-muted">Action</span></th>
                            @endif
                            <!-- <th><span class="text-muted">Action</span></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                @if($type == 'delete')  
                                    <td>
                                        <label class="ui-check m-0 ">                               
                                        <input id="{{$user->id}}" type="checkbox" class="checkboxes" name="id"  value="{{$user->id}}"/>
                                        <i></i>
                                        </label>                                 
                                    </td>
                                    
                                @endif
                                @if($type == 'edit')
                                    <td>
                                        <input id="{{$user->id}}" type="checkbox" class="checkboxes hidden" name="id"  value="{{$user->id}}"/>                                        
                                    </td>
                                @endif
                                
                                <td>
                                {{$user->first_name}}
                                </td>
                                <td>
                                {{$user->email_address}}
                                </td>
                                <td>
                                {{$user->user_type_id}}
                                </td>
                                <td>
                                {{$user->company_id}}
                                </td>
                                <td>
                                {{$user->created_at}}
                                </td>
                                @if($type == 'edit')
                                    @if($page == 'user')
                                        <td>
                                            <a href="{{ url('office/editUser', $user->id)}}" class="btn btn-primary" >Edit</a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{ url('office/editPatient', $user->id)}}" class="btn btn-primary" >Edit</a>
                                        </td>
                                    @endif
                                
                                @endif
                                <!-- <td>
                                    <a href="{{ url('admin/editUser', $user->id)}}" class="btn btn-primary" >Edit</a>                                    
                                    <button onclick="deleteUser({{$user->id}})" class="btn btn-primary" data-toggle="modal" data-target="#m">Delete</button>
                                </td> -->
                            </tr>
                        
                        @endforeach
                                            
                    </tbody>
                </table>
            </div>
        </div>

        <div class="padding pt-0 ">
            @if($type == 'delete' && count($users) > 0 )
                <button id="deleteUser" class="btn btn-primary" data-toggle="modal" data-target="#m" disabled >Delete</button>
            @endif            
        </div>

    </div>

<!-- modal -->
<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure you wish to delete the selected patient(s)?</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        <button id="delBtn" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Yes</button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>
@stop


@section('script')

<script type="text/javascript">   
    $(document).ready(function() {        
    });

    // var table = $('#table').DataTable();
    // $('#table tbody').on( 'click', 'tr', function () {
    //     var d = table.row( this ).data();        
    //     d.counter++;    
    //     table
    //         .row( this )
    //         .data( d )
    //         .draw();
    // } );

    // $(".group-checkable").change(function() {
    //     var checked = $(this).is(":checked");
    //     $('.checkboxes').attr("checked",checked);
    // });


    $(document).on('click', '.group-checkable', function () {        
        var checked = $(this).is(":checked");
        var value = $(this).val();
        $checkBoxs = $(this).closest("table").find("tbody .checkboxes");        
        $checkBoxs.each( function () {
            $( this ).prop( "checked", checked);
        });
        
        // only enable button when choose a row
        document.getElementById("deleteUser").disabled = true;
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if (checked) {                
                document.getElementById("deleteUser").disabled = false;
            } else {                
            }
        });

    });    

    $(document).on('click', '.checkboxes', function () {
        $checkBoxs = $(this).closest("table").find("tbody .checkboxes");     

        // only enable button when choose a row
        document.getElementById("deleteUser").disabled = true;
        $checkBoxs.each( function () {
            var checked = $(this).is(":checked");
            var value = $(this).val();
            if (checked) {
                document.getElementById("deleteUser").disabled = false;
            } else {
            }
        });        
    });     
 
    var deleteId = "";
    var $checkBoxs;

    function deleteUser(id){
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
        //var request = $.get('{{ URL::to('admin/deleteUser')}}' + "?id=" + id);
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