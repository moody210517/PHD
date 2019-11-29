@extends('admin.main')
@section('content')
<div class="page-container">

    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0">Edit User
            @if($page == 'patient')
            <a href="{{ url('office/patients/edit') }}" class="btn btn-raised btn-wave w-xs blue" style="float: right;color: white;">Back</a>
            @else
            <a href="{{ url('office/users/edit') }}" class="btn btn-raised btn-wave w-xs blue" style="float: right;color: white;">Back</a>
            @endif            
            </h2>
        </div>
        
        <div class="padding">

        <div class="tab-content mb-4">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                @if($page == 'patient')
                    <form method="post" action="{{ url('office/editPatient')}}" enctype="multipart/form-data">
                @else
                    <form method="post" action="{{ url('office/editUser')}}" enctype="multipart/form-data">
                @endif
                
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> First Name </label>
                    </div>                    
                    <div class="col-sm-9">
                        <input type="text" name="first_name" class="  form-control" placeholder="First Name" value="{{$user->first_name}}"   required="required">
                    </div>                    
                </div>
            
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Last Name </label>
                    </div>                    
                    <div class="col-sm-9">
                        <input type="text" id="last_name" name="last_name"  class="form-control" placeholder="Last Name"  value="{{$user->last_name}}"  required="required">
                    </div>                    
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Office Number </label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="text" id="office_num" name="office_num" class="  form-control" placeholder="234-234-3355" value="{{$user->office_num}}"   required="required">
                    </div>                    
                </div>
            
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Mobile Number </label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="text" id="home_num" name="home_num" class="  form-control" placeholder="234-234-3355"  value="{{$user->home_num}}"  required="required">
                    </div>                    
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Email</label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="email" id="email" name="email_address" class="  form-control" placeholder="Email"  value="{{$user->email_address}}"   required="required">
                    </div>                    
                </div>                            
                
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label">Password</label>
                    </div>                    
                    <div class="col-sm-9">
                    <input type="password"  name="user_password"  class="form-control"  placeholder="Password" value="{{$user->user_password}}"  required="required" id="pwd">                                   
                    </div>                    
                </div>                            

             

              
            
                <!-- <div class="form-group">
                    <label>Select Shipping Addresss</label>  <a href="{{ url('admin/ships') }}" style="float: right;color: white;">Go to Shipping </a>
                        <select id="shipping_id" name="shipping_id[]" class="form-control" data-plugin="newselect2" data-option="{}" placeholder="Hour" multiple  required="required"> 
                        <optgroup label="Shipping Address">
                                @foreach($shipping as $hour)
                                <option value="{{$hour->auto_num}}" <?php $tmp = explode(":", $user->shipping_id); if( in_array($hour->auto_num , $tmp) ) { echo "selected";} ?> > {{$hour->shipping_address1." - ".$hour->shipping_city}}</option>  
                                @endforeach
                            </optgroup>                                                
                    </select>
                </div> 
                                
                <div class="form-group">
                    <label>Select Billing Addresss</label>  <a href="{{ url('admin/bills') }}" style="float: right;color: white;">Go to Billing </a>
                        <select id="billing_id" name="billing_id" class="form-control" data-plugin="newselect2" data-option="{}" placeholder="Hour"  required="required"> 
                        <optgroup label="Billing Address">
                                @foreach($billing as $hour)
                                <option value="{{$hour->auto_num}}" <?php if($hour->auto_num == $user->billing_id) { echo "selected";} ?> > {{$hour->billing_address1." - ".$hour->billing_city}}</option>  
                                @endforeach
                            </optgroup>                                                
                    </select>
                </div>  -->
                
                @if(Session::get('user_type') == '0')
                    <div class="form-group">
                        <label class="text-muted">Company</label>
                        <select name="company_id" class="form-control" data-plugin="newselect2" data-option="{}"  required="required">
                            @foreach($company as $com)
                                <option value="{{$com->auto_num}}" style="color:black;"> {{$com->company_name}} </option>                        
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="company_id" class="  form-control" placeholder="First Name" value="{{Session::get('company_id')}}"  required="required">
                @endif
                

                <div class="form-group row">
                    <div class="col-sm-3">
                    <label class="text-muted">User Type</label>
                    </div>
                    <div class="col-sm-9">
                    <select name="user_type_id" class="form-control" required="required">
                        @foreach($usertype as $u)
                            <option value="{{$u->auto_num}}" style="color:black;"> {{$u->user_type_name}} </option>                        
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="col-md-6 form-group" style="padding: 0px;">                        
                   
                    <button class="btn btn-raised btn-wave mb-2 w-xs blue" style="float: right;">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

