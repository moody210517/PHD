@extends('admin.main')
@section('content')   


    <!-- Parameters
    device_id
    device_name
    sessin_id (key from login api)    
    sensore values -->

    <!-- tbl_s_blood_pressure, tbl_s_gsr, and tbl_s_pulse_oximeter -->
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0" style="padding-bottom: 25px;">Device            
            <a href="{{ url('admin/addDevice') }}" class="btn btn-primary" style="float: right;color: white;">Add Device</a>
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
                    data-page-list="[10, 25, 50, 100, ALL]"                    
                    >

                    <thead>
                        <tr>
                            <th><span class="text-muted">ID</span></th>
                            <th><span class="text-muted">Serial Number</span></th>
                            <th><span class="text-muted">Company Name</span></th>
                            <th><span class="text-muted">Action</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $user)
                            <tr>
                                <td>
                                    <a href="javascript:void(0);" class="item-author ">{{$user->auto_num}}</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="item-author ">{{$user->serial_num}}</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="item-author ">{{$user->company_id}}</a>
                                </td>
                                
                                <td>
                                    <div style="float:right;">
                                        <a href="{{ url('admin/editDevice', $user->auto_num)}}" class="btn btn-primary">Edit</a>                                    
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
        deleteData(deleteId, "{{ URL::to('api/deleteDevice')}}")
    });             
</script>

@stop