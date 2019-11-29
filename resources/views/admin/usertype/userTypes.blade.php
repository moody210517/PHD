@extends('admin.main')
@section('content')     
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0" style="padding-bottom: 25px;">User
            
            <a href="{{ url('admin/addUserType') }}" class="btn btn-primary" style="float: right;color: white;">Add User Type</a>
            </h2>
        </div>

        <div class="padding pt-0 ">
            <div class="table-responsive">
                <!-- <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable" style="margin-top: -15px;"> -->
                <table class="table table-theme v-middle" data-plugin="bootstrapTable"
                    id="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-search-align="left"
                    data-show-columns="true"
                    data-show-export="false"
                    data-detail-view="false"
                    data-mobile-responsive="true"
                    data-pagination="true"
                    data-page-list="[10, 25, 50, 100, ALL]">


                    <thead>
                        <tr>
                            <th><span class="text-muted">User Type Name</span></th>
                            <th><span class="text-muted"> Role </span></th>                            
                            <th><span class="text-muted">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usertypes as $user)
                            <tr>
                                <td>
                                {{$user->user_type_name}}
                                </td>
                                <td>
                                {{$user->role}}
                                </td>
                                
                                <td>
                                    <div style="float:right;">
                                        <a href="{{ url('admin/editUserType', $user->auto_num)}}" class="btn btn-primary">Edit</a>                                    
                                        <button onclick="deleteUser({{$user->auto_num}})" class="btn btn-primary" data-toggle="modal" data-target="#m">Delete</button>
                                    </div>                               
                                </td>
                            </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- modal -->
<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure to execute this action?</h5>
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


    var deleteId = "";
    function deleteUser(id){
        deleteId = id;
    }

    $("#delBtn").click(function(){    
        var id = deleteId;    
        var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    
        $.ajax({
          type: 'POST',
          data: {id:id},
          url: "{{ URL::to('api/deleteUserType')}}",
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