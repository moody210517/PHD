@extends('admin.main')
@section('content')

<div class="page-container">

    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0">Add User
            <!-- <a href="{{ url('admin/users') }}" class="btn btn-primary" style="float: right;color: white;">Back</a> -->
            </h2>
            <!-- <h6>(Please check/add billing address and shipping address before add user infos )</h6> -->
        </div>        
    <div class="padding">


    <input type="hidden" id="exist" name="first_name" class="  form-control" value="{{$exist}}">


    <div class="tab-content mb-4">
        <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">

            @if($page == 'patient')
            <form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('office/addPatient') }}" enctype="multipart/form-data">
            @else
            <form data-plugin="parsley" data-option="{}" method="post" action="{{ url('office/addUser') }}" enctype="multipart/form-data">
            @endif

                @csrf
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> First Name </label>
                    </div>                    
                    <div class="col-sm-9">
                        <input type="text" name="first_name" class="  form-control" placeholder="First Name"  required="required">
                    </div>                    
                </div>
            
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Last Name </label>
                    </div>                    
                    <div class="col-sm-9">
                        <input type="text" id="last_name" name="last_name"  class="form-control" placeholder="Last Name"  required="required">
                    </div>                    
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Office Number </label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="text" id="office_num" name="office_num" class="  form-control" placeholder="234-234-3355"   required="required">
                    </div>                    
                </div>
            
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Mobile Number </label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="text" id="home_num" name="home_num" class="  form-control" placeholder="234-234-3355"   required="required">
                    </div>                    
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Email</label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="email" id="email" name="email_address" class="  form-control" placeholder="Email"    required="required">
                    </div>                    
                </div>                            
                
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Password</label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="password"  name="user_password"  class="form-control"  placeholder="Password" required="required" id="pwd">                                   
                    </div>                    
                </div>                            

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Confirm Password</label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="password" name="confirmPassword" class="form-control"  placeholder="Confirm Password"  data-parsley-equalto="#pwd" required="required">
                    </div>                    
                </div>   
             
                <!-- <div class="form-group">
                    <label>Select Shipping Addresss</label>  <a href="{{ url('admin/ships') }}" style="float: right;color: white;">Go to Shipping </a>
                        <select id="shipping_id" name="shipping_id[]" class="form-control" data-plugin="select2" data-option="{}" placeholder="Hour" multiple required="required"> 
                        <optgroup label="Shipping Address">                                
                                @foreach($shipping as $hour)
                                <option value="{{$hour->auto_num}}" > {{$hour->shipping_address1." - ".$hour->shipping_city}}</option>  
                                @endforeach
                            </optgroup>                                                
                    </select>
                </div>

                <div class="form-group">
                    <label>Select Billing Addresss</label>  <a href="{{ url('admin/bills') }}" style="float: right;color: white;">Go to Billing </a>
                        <select id="billing_id" name="billing_id" class="form-control" data-plugin="select2" data-option="{}" placeholder="Hour"  required="required"> 
                        <optgroup label="Billing Address">
                                <option disabled selected value> -- select an option -- </option>
                                @foreach($billing as $hour)
                                <option value="{{$hour->auto_num}}" > {{$hour->billing_address1." - ".$hour->billing_city}}</option>  
                                @endforeach
                            </optgroup>                                                
                    </select>
                </div> -->
                
                @if(Session::get('user_type') == '0')
                    <div class="form-group">
                        <label class="text-muted">Company</label>
                        <select name="company_id" class="form-control" data-plugin="select2" data-option="{}"  required="required">
                            @foreach($company as $com)
                                <option value="{{$com->auto_num}}" style="color:black;"> {{$com->company_name}} </option>                        
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" id="company_id" name="company_id" class="  form-control" placeholder="First Name" value="{{Session::get('company_id')}}"  required="required">
                @endif



                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label">User Type</label>
                    </div>                    
                    <div class="col-sm-9">
                    <select id="user_type_id" name="user_type_id" class="form-control" required="required">                        
                    <option disabled selected value> -- select an option -- </option>
                        @foreach($usertype as $u)
                            <option value="{{$u->auto_num}}" style="color:black;"> {{$u->user_type_name}} </option>
                        @endforeach
                    </select>
                    </div>                    
                </div>   

                <div class=" form-group" style="padding: 0px;">
                    <button  class="btn btn-primary" style="float: right;">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Same Email Already Exit. Please try with other email adddress.</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" id="btnOk" class="btn btn-primary" data-dismiss="modal">Ok</button>
        <!-- <button id="delBtn" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Ok</button> -->
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>


@stop

@section('script')
<script src="https://unpkg.com/imask"></script>
<script type="text/javascript">  
    $(document).ready(function() {       
        
        var phoneMask = IMask(
        document.getElementById('office_num'), {
            mask: '000-000-0000'
        });

        var phoneMask = IMask(
        document.getElementById('home_num'), {
            mask: '000-000-0000'
        });


        
        var exist = document.getElementById("exist").value;
        //$("#m").show();
        if(exist == '1'){
            $("#m").show();
        }
    });
    

    $("#btnOk").click(function(){   
        $("#m").hide();
    });

    function saveUser(){
        
        var first_name = document.getElementById("first_name").value;
        var last_name = document.getElementById("last_name").value;
        var office_num = document.getElementById("office_num").value;
        var home_num = document.getElementById("home_num").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        var user_type_id = $("#user_type_id").value;

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
          type: 'POST',
          data: { first_name:first_name, last_name:last_name, office_num:office_num, home_num:home_num, email:email, password:password, user_type_id:user_type_id},
          url: "{{ URL::to('api/addUser')}}",
          success: function(result) {     
                var res = result.results;
                if(res == 200){
                    location.reload();
                }else{
                    alert("Failed");
                }
          }

        });
    }
</script> 
@stop




