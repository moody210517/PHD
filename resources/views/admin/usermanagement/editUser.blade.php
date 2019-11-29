@extends('admin.main')
@section('content')
<div class="page-container">

    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0">Edit User
            <a href="{{ url('admin/allUsers') }}" class="btn btn-raised btn-wave w-xs blue" style="float: right;color: white;">Back</a>
            
            </h2>
        </div>
        
        <div class="padding">

        <div class="tab-content mb-4">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form  data-plugin="parsley" data-option="{}"  method="post" action="{{ url('admin/editUser')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">                                                            
                <div class="form-group">
                    <input type="text" name="first_name" class=" form-control" placeholder="First Name" value="{{$user->first_name}}"  required="required">
                </div>

                <div class="form-group">
                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{$user->last_name}}"  required="required">
                </div>
                <div class="form-group">
                    <input type="text" id="office_num" name="office_num" class="form-control" placeholder="Office Num"  value="{{$user->office_num}}"  required="required">
                </div>
                <div class="form-group">
                    <input type="text" id="home_num" name="home_num" class="form-control" placeholder="Home Num" value="{{$user->home_num}}"  required="required">
                </div>
                

                <div class="form-group">
                    <input type="email" name="email_address" class="form-control" placeholder="Email" value="{{$user->email_address}}"  required="required">
                </div>

                <!-- <div class="form-group">
                    <input type="password" name="user_password" class="form-control" placeholder="Password" value="{{$user->user_password}}"  required="required">
                </div> -->
            
                <!-- <div class="form-group">
                    <label>Select Shipping Addresss</label>  <a href="{{ url('admin/ships') }}" style="float: right;color: white;">Go to Shipping </a>
                        <select id="shipping_id" name="shipping_id[]" class="form-control" data-plugin="newselect2" data-option="{}" placeholder="Hour" multiple  required="required"> 
                        <optgroup label="Shipping Address">
                                @foreach($shipping as $hour)
                                <option value="{{$hour->auto_num}}" > {{$hour->shipping_address1." - ".$hour->shipping_city}}</option>  
                                @endforeach
                            </optgroup>                                                
                    </select>
                </div>

                
                <div class="form-group">
                    <label>Select Billing Addresss</label>  <a href="{{ url('admin/bills') }}" style="float: right;color: white;">Go to Billing </a>
                        <select id="billing_id" name="billing_id" class="form-control" data-plugin="newselect2" data-option="{}" placeholder="Hour"  required="required"> 
                        <optgroup label="Billing Address">
                                @foreach($billing as $hour)
                                <option value="{{$hour->auto_num}}" <?php if($hour->auto_num == $user->bill_id) { echo "selected";} ?> > {{$hour->billing_address1." - ".$hour->billing_city}}</option>  
                                @endforeach
                            </optgroup>                                                
                    </select>
                </div>  -->
                
                @if(Session::get('user_type') == '0')
                    
                    <input type="hidden" name="company_id" class="  form-control" placeholder="First Name" value="{{$user->company_id}}"  required="required">
                    <!-- <div class="form-group">
                        <label class="text-muted">Company</label>
                        <select name="company_id" class="form-control" data-plugin="newselect2" data-option="{}"  required="required">
                            @foreach($company as $com)
                                <option value="{{$com->auto_num}}" style="color:black;"> {{$com->company_name}} </option>                        
                            @endforeach
                        </select>
                    </div> -->
                @else
                    <input type="hidden" name="company_id" class="  form-control" placeholder="First Name" value="{{Session::get('company_id')}}"  required="required">
                @endif
                

                <div class="form-group">
                    <label class="text-muted">User Type</label>
                    <select name="user_type_id" class="form-control" required="required">
                        @foreach($usertype as $u)
                            <option value="{{$u->auto_num}}" style="color:black;"> {{$u->user_type_name}} </option>                        
                        @endforeach
                    </select>
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


@section('script')
<script src="https://unpkg.com/imask"></script>
<script type="text/javascript">   
    $(document).ready( function() {    
        var phoneMask = IMask(
        document.getElementById('office_num'), {
            mask: '000-000-0000'
        });

        var phoneMask = IMask(
        document.getElementById('home_num'), {
            mask: '000-000-0000'
        });
        
    });
</script>

@stop
