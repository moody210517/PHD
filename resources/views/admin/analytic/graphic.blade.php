@extends('admin.main')
@section('content')   
    <div class="page-container1" id="page-container">

        <input type="hidden" value="{{Session::get('user_id')}}" id="user_id"/>
        <input type="hidden" value="{{Session::get('company_id')}}" id="company_id"/>

        <div class="page-title padding pb-0 inline">           
            <h2 class="text-md mb-0">Graphic Analytic </h2>                     
        </div>

        <div class="padding">
            <div class="row row-sm">
         
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="block px-4 py-3">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="d-flex align-items-center i-con-h-a my-1">
                                    <div>
                                        <span class="avatar w-40 b-a b-2x">
                                        <i class="i-con i-con-user b-2x text-primary"><i></i></i>                                        
                                        </span>                                                  
                                        <label class="text-muted">Patient</label>                             
                                    </div>                                                                        
                                    <div class="col-md-8">                                                               
                                        <select id="patient_id" name="patient_id"  class="form-control" required="required">
                                            @if($allocation->first())
                                                @foreach($patients as $c)
                                                    <option value="{{$c->auto_num}}" style="color:black;" <?php  if($c->auto_num == $allocation->first()->user_num) { echo "selected";} ?> > {{$c->first_name."  ".$c->last_name}} </option>                        
                                                @endforeach
                                            @else                                            
                                                @foreach($patients as $c)
                                                    <option value="{{$c->auto_num}}" style="color:black;" > {{$c->first_name."  ".$c->last_name}} </option>                        
                                                @endforeach
                                            @endif                                            
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                                                        
                            <div class="col-lg-3 col-6">
                                <div class="d-flex align-items-center i-con-h-a my-1">
                                    <div>
                                        <span class="avatar w-40 b-a b-2x">
                                        <i class="i-con i-con-history b-2x text-success"><i></i></i>
                                        </span>
                                        <label class="text-muted">Device</label>   
                                    </div>
                                    <div class="col-md-8">                                                               
                                        <select id="device_id" name="device_id"  class="form-control" required="required">
                                            @if($allocation->first())
                                            
                                                @foreach($devices as $c)
                                                    <option value="{{$c->auto_num}}" style="color:black;"  <?php  if($c->auto_num == $allocation->first()->serial_num) { echo "selected";} ?>  > {{$c->serial_num}} </option>
                                                @endforeach
                                            @else
                                                @foreach($devices as $c)
                                                    <option value="{{$c->auto_num}}" style="color:black;" > {{$c->serial_num}} </option>                        
                                                @endforeach
                                            @endif
                                           
                                        </select>                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6" >                                
                                    
                                    <div class="col-md-8" style="display:none">
                                        <div class="modal-body">
                                        <div class="wrapper-div ">                                                    
                                        <input type="hidden" id="allocation_name" name="allocation_name" class="form-control" placeholder="Test Name" value="{{$allocation->first()?$allocation->first()->allocation_name:''}}" required="required">
                                        </div>
                                        </div>    
                                    </div>

                                    <div class="col-md-4" style="margin-top:5px;">
                                        <div class="modal-body">
                                            <div class="wrapper-div">
                                            <button class="btn btn-primary" onClick="complete()" id="complete" > Stop </button>
                                            <button class="btn btn-primary" onClick="allocate()" id="allocate" > Start </button>
                                            </div>
                                        </div>
                                    </div>                                                                        

                                    @if($allocation->first())                                                                                        

                                        <input type="hidden" value="{{$allocation->first()->auto_num}}"  id="allocation_id"/>
                                    @else
                                        <input type="hidden" value="-1"  id="allocation_id"/>
                                    
                                    @endif                                        
                                                                                                        
                                    <!-- <div class="mx-3">
                                        <a href="#" class="d-block ajax"><strong>5,050</strong></a>
                                        <small class="text-muted">Users</small>
                                    </div> -->
                               
                            </div>

                             <div class="col-lg-3 col-6">
                                <div class="modal-body">
                                    <div class="wrapper-div">                                                               
                                        <select id="sensor_id" name="sensor_id"    class="form-control" required="required">
                                            <option value="0" style="color:black;" >Oxymeter (SPO2) </option>                        
                                            <option value="1" style="color:black;" >Blood Pressure </option>                        
                                            <option value="2" style="color:black;" >GSR </option>                        
                                        </select>                                        
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-lg-3 col-6">
                                <div class="d-flex align-items-center i-con-h-a my-1">
                                    <div>
                                        <span class="avatar w-40 b-a b-2x">
                                        <i class="i-con i-con-mail b-2x text-danger"><i></i></i>
                                        </span>
                                    </div>
                                    <div class="mx-3">
                                        <a href="#" class="d-block ajax"><strong>302</strong></a>
                                        <small class="text-muted">Mails</small>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    
                    <div class="row row-sm">                        
                        <div class="col-md-12">
                            <div class="card p-4">

                                <div class="pb-4" style="display:none;">
                                    <div class="d-flex mb-3">
                                        <span class="text-md">Real Time Graphic</span>
                                        <span class="flex"></span>
                                        <!-- <label class="ui-switch mt-1">
                                        <input type="checkbox" checked>
                                        <i></i>
                                        </label> -->
                                    </div>
                                    <div class="d-flex">
                                        <!-- <div class="i-con-h-a">
                                            <small class="text-muted">Administrator</small>
                                            <div class="mt-1">
                                                <span class="text-primary text-md">{{Session::get('first_name')}}</span>
                                                
                                                <i class="i-con i-con-trending-up text-success"><i></i></i>
                                                <small class="mx-1 text-muted">+5%</small>
                                            </div>
                                        </div> -->
                                        
                                        <!-- <div class="i-con-h-a mx-3">
                                            <small class="text-muted">Patient</small>
                                            <div class="mt-1">
                                                <span class="text-muted text-md">$25,000</span>
                                                <i class="i-con i-con-trending-down text-danger"><i></i></i>
                                                <small class="mx-1 text-muted">-10%</small>
                                            </div>
                                        </div>

                                        <div class="i-con-h-a mx-3">
                                            <small class="text-muted">Device Name</small>
                                            <div class="mt-1">
                                                <span class="text-muted text-md"></span>
                                                <i class="i-con i-con-trending-down text-danger"><i></i></i>
                                                <small class="mx-1 text-muted">-10%</small>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div style="height: 300px">
                                    <canvas data-plugin="chartjs" id="chartline"></canvas>
                                </div>
                            </div>
                        </div>                        
                    </div>


                    <div class="row row-sm">                        
                        <div class="col-md-12">
                            <div class="card p-4">
                                <div class="pb-4">
                                    <div class="d-flex mb-3">
                                        <span class="text-md" id="sensor_value"> Sensor Value</span>
                                        <span class="flex"></span>
                                        <!-- <label class="ui-switch mt-1">
                                        <input type="checkbox" checked>
                                        <i></i>
                                        </label> -->
                                    </div>

                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable" style="margin-top: -15px;">
                                            <thead>
                                                <tr>
                                                    <th><span class="text-muted">ID</span></th>
                                                    <th><span class="text-muted">O2 Percentage</span></th>
                                                    <th><span class="text-muted">BPM Vaulues</span></th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr class="odd" data-id="1" role="row">
                
                                                        <td class="sorting_1">
                                                            <small class="text-muted">1</small>
                                                        </td>
                                                 
                                                        <td class="flex">
                                                        <span class="item-amount text-sm ">
                                                            21%
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <span class="item-amount text-sm ">
                                                            210
                                                            </span>
                                                        </td>
                                                        
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>                                                                
            </div>
        </div>
    </div>
@stop


@section('script')
<script type="text/javascript">

    var sensor_id = "0";
    var allocation_id = "";

    $(document).ready(function() {           
        
        // for allocation table
        allocation_id = $("#allocation_id").val();
        if(allocation_id == -1){
            $("#complete").hide();
            $("#allocate").show();
        }else{
            $("#complete").show();
            $("#allocate").hide();
        }

        // for selected sensore
        var sensor_id_text = $("#sensor_id option:selected").text();
        sensor_id = $("#sensor_id").val();
        $("#sensor_value").text("Sensor Values - " + sensor_id );
        $("#sensor_id").on('change', function(){
            sensor_id_text = $("#sensor_id option:selected").text();
            $("#sensor_value").text("Sensor Values - " + sensor_id_text );
            //sensor_id = this.val();
        });

        //customChat(sensor_id , allocation_id);
    
    });
    
    
</script>
@stop