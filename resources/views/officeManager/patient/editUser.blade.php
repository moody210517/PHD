@extends('admin.main')
@section('content')
<div class="page-container">

    <div class="page-container-1" id="page-container">

        
        <input value="{{$logintype}}" id="logintype" type="hidden" />


        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0">Edit Patient
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
                <form method="post" action="{{ url('office/editPatient')}}" enctype="multipart/form-data">                
                @csrf
                    
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <input type="hidden" name="page_type" value="<?php if(isset($page_type)){echo $page_type;}else{echo "edit";}  ?>">
                    
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> First Name </label>
                    </div>                    
                    <div class="col-sm-9">
                        <input type="text" name="first_name" class="  form-control"  value="{{$user->first_name}}"  placeholder="First Name"  required="required">
                    </div>                    
                </div>


                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="col-form-label"> Last Name </label>
                    </div>

                    <div class="col-sm-9">
                    <input type="text" name="last_name" class="  form-control" value="{{$user->last_name}}" placeholder="Last Name"   required="required">
                    </div>
                </div>
                

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">EMR/EHR ID</label>
                    <div class="col-sm-9">
                    <input type="text" name="emrid" class="  form-control"  value="{{$user->emr_ehr_id}}"  placeholder="EMR/EHR ID" >
                    </div>
                </div>


                <!-- <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Office Number </label>
                    <div class="col-sm-9">
                    <input type="text" id="office_num" name="office_num" class="  form-control" value="{{$user->office_num}}" placeholder="231-345-3426">
                    </div>
                </div> -->


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Mobile Number </label>
                    <div class="col-sm-9">
                    <input type="tel" id="mobile_num" name="mobile_num" class="  form-control" value="{{$user->mobile_num}}" placeholder="231-345-3426"   required="required">
                    </div>                    
                </div>

          

                @if($logintype == "1")
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Home Number </label>
                    <div class="col-sm-9">
                        <input type="tel" id="home_num" name="home_num" class="  form-control"  value="{{$user->home_num}}" placeholder="231-345-3426"   required="required">
                    </div>                    
                </div>
                @else
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Home Number </label>
                    <div class="col-sm-9">
                        <input type="tel" id="home_num" name="home_num" class="  form-control"  value="{{$user->home_num}}" placeholder="231-345-3426">
                    </div>                    
                </div>
                @endif


                <!-- <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Fax Number </label>
                    <div class="col-sm-9">
                    <input type="text" id="fax_num" name="fax_num" class="  form-control"  value="{{$user->fax_num}}"  placeholder="Fax Number" >
                    </div>
                </div> -->

                         

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Birthday</label>
                    <div class="col-sm-9">
                    <input type="date" name="date_of_birth" class="  form-control" value="{{$user->date_of_birth}}" placeholder="Birthday"   required="required">
                    </div>                    
                </div>

     
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sex</label>
                    <div class="col-sm-9">
                    <select id="sex" name="sex" class="form-control" placeholder="Hour" required="required">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Male" class="text-black"  <?php if($user->sex == "Male") { echo "selected";}?> > Male </option>  
                        <option value="Female"  class="text-black"  <?php if($user->sex == "Female") { echo "selected";}?> > Female </option>  
                        <!-- <option value="Undisclosed"  class="text-black" <?php if($user->sex == "Undisclosed") { echo "selected";}?>  > Undisclosed </option> -->
                    </select>
                    </div>                             
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Ethnicity </label>                                        
                    <div class="col-sm-3 form-group"> 
                        <select id="ethnicity" name="ethnicity" class="form-control" required="required">    
                            <option disabled selected value> -- select ethnicity -- </option>                            
                            <option value="Asian" style="color:black;" <?php if($user->ethnicity == "Asian") { echo "selected";}?> > Asian </option>                        
                            <option value="Black" style="color:black;" <?php if($user->ethnicity == "Black") { echo "selected";}?> > Black </option>
                            <option value="Caucasian" style="color:black;" <?php if($user->ethnicity == "Caucasian") { echo "selected";}?> > Caucasian </option>
                            <option value="Hispanic" style="color:black;" <?php if($user->ethnicity == "Hispanic") { echo "selected";}?> > Hispanic </option>
                            <option value="Other" style="color:black;" <?php if($user->ethnicity == "Other") { echo "selected";}?> > Other </option>
                        </select>
                    </div>
                </div>
            
        
              
                @if($logintype == "1")

                    <div class="form-group row">
                           <label class="col-sm-3 col-form-label">Height - inches(optional)</label>
                           <div class="col-sm-4">
                                <!-- <input type="number" id="feet" name="feet" class="form-control"  value="{{ floor($user->user_height/12) }}" placeholder="Height - FEET"> -->
                                <select id="feet" name="feet" class="form-control" required="required" placeholder="Height - FEET">    
                                    <option disabled selected value> -- select feet -- </option>                            
                                    <option value="3" <?php if($user->user_height - 12 * floor($user->user_height/12) == 3) { echo "selected"; } ?> style="color:black;"> 3 </option>                        
                                    <option value="4" <?php if($user->user_height - 12 * floor($user->user_height/12) == 4) { echo "selected"; } ?> style="color:black;"> 4 </option>
                                    <option value="5" <?php if($user->user_height - 12 * floor($user->user_height/12) == 5) { echo "selected"; } ?> style="color:black;"> 5 </option>
                                    <option value="6" <?php if($user->user_height - 12 * floor($user->user_height/12) == 6) { echo "selected"; } ?> style="color:black;"> 6 </option>
                                    <option value="7" <?php if($user->user_height - 12 * floor($user->user_height/12) == 7) { echo "selected"; } ?> style="color:black;"> 7 </option>
                                    <option value="8" <?php if($user->user_height - 12 * floor($user->user_height/12) == 8) { echo "selected"; } ?> style="color:black;"> 8 </option>
                                </select>
                           </div>
                           <div class="col-sm-4">
                                <!-- <input type="number" id="inche" name="inche" class="form-control" value="" placeholder="Height - inches"/> -->
                                <select id="inche" name="inche" class="form-control" required="required" placeholder="Height - inches">    
                                    <option disabled selected value> -- select inches -- </option>                            
                                    <option value="0" <?php if($user->user_height - 12 * floor($user->user_height/12) == 0) { echo "selected"; } ?> style="color:black;"> 0 </option>                        
                                    <option value="1" <?php if($user->user_height - 12 * floor($user->user_height/12) == 1) { echo "selected"; } ?> style="color:black;"> 1 </option>
                                    <option value="2" <?php if($user->user_height - 12 * floor($user->user_height/12) == 2) { echo "selected"; } ?> style="color:black;"> 2 </option>
                                    <option value="3" <?php if($user->user_height - 12 * floor($user->user_height/12) == 3) { echo "selected"; } ?> style="color:black;"> 3 </option>
                                    <option value="4" <?php if($user->user_height - 12 * floor($user->user_height/12) == 4) { echo "selected"; } ?> style="color:black;"> 4 </option>
                                    <option value="5" <?php if($user->user_height - 12 * floor($user->user_height/12) == 5) { echo "selected"; } ?> style="color:black;"> 5 </option>
                                    <option value="6" <?php if($user->user_height - 12 * floor($user->user_height/12) == 6) { echo "selected"; } ?> style="color:black;"> 6 </option>
                                    <option value="7" <?php if($user->user_height - 12 * floor($user->user_height/12) == 7) { echo "selected"; } ?> style="color:black;"> 7 </option>
                                    <option value="8" <?php if($user->user_height - 12 * floor($user->user_height/12) == 8) { echo "selected"; } ?> style="color:black;"> 8 </option>
                                    <option value="9" <?php if($user->user_height - 12 * floor($user->user_height/12) == 9) { echo "selected"; } ?> style="color:black;"> 9 </option>
                                    <option value="10" <?php if($user->user_height - 12 * floor($user->user_height/12) == 10) { echo "selected"; } ?> style="color:black;"> 10 </option>
                                    <option value="11" <?php if($user->user_height - 12 * floor($user->user_height/12) == 11) { echo "selected"; } ?> style="color:black;"> 11 </option>
                                </select>
                                
                           </div>
                        </div>
                    </div>                     
                    <div class="form-group row">
                           <label class="col-sm-3 col-form-label">Weight - pounds(optional)</label>
                           <div class="col-sm-9">
                           <input type="number" id="weight" name="weight" class="  form-control" value="{{$user->weight}}"  placeholder="Weight - pounds">
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">            
                        <input type="email" name="email_address" class="  form-control" value="{{$user->email_address}}" placeholder="Email"    required="required">
                    </div>
                </div>
                @else                
                    <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Height - inches(optional)</label>
                            <div class="col-sm-4">
                                <!-- <input type="number" id="feet" name="feet" class="form-control"  value="" placeholder="Height - FEET" required="required"> -->
                                <select id="feet" name="feet" class="form-control" required="required" placeholder="Height - FEET">    
                                    <option disabled selected value> -- select feet -- </option>                            
                                    <option value="3" <?php if(floor($user->user_height/12) == 3) { echo "selected"; } ?> style="color:black;"> 3 </option>                        
                                    <option value="4" <?php if(floor($user->user_height/12) == 4) { echo "selected"; } ?> style="color:black;"> 4 </option>
                                    <option value="5" <?php if( floor($user->user_height/12) == 5) { echo "selected"; } ?> style="color:black;"> 5 </option>
                                    <option value="6" <?php if( floor($user->user_height/12) == 6) { echo "selected"; } ?> style="color:black;"> 6 </option>
                                    <option value="7" <?php if( floor($user->user_height/12) == 7) { echo "selected"; } ?> style="color:black;"> 7 </option>
                                    <option value="8" <?php if( floor($user->user_height/12) == 8) { echo "selected"; } ?> style="color:black;"> 8 </option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <!-- <input type="number" id="inche" name="inche" class="form-control" value="" placeholder="Height - inches"  required="required"/> -->
                                <select id="inche" name="inche" class="form-control" required="required" placeholder="Height - inches">    
                                    <option disabled selected value> -- select inches -- </option>                            
                                    <option value="0" <?php if($user->user_height - 12 * floor($user->user_height/12) == 0) { echo "selected"; } ?> style="color:black;"> 0 </option>                        
                                    <option value="1" <?php if($user->user_height - 12 * floor($user->user_height/12) == 1) { echo "selected"; } ?> style="color:black;"> 1 </option>
                                    <option value="2" <?php if($user->user_height - 12 * floor($user->user_height/12) == 2) { echo "selected"; } ?> style="color:black;"> 2 </option>
                                    <option value="3" <?php if($user->user_height - 12 * floor($user->user_height/12) == 3) { echo "selected"; } ?> style="color:black;"> 3 </option>
                                    <option value="4" <?php if($user->user_height - 12 * floor($user->user_height/12) == 4) { echo "selected"; } ?> style="color:black;"> 4 </option>
                                    <option value="5" <?php if($user->user_height - 12 * floor($user->user_height/12) == 5) { echo "selected"; } ?> style="color:black;"> 5 </option>
                                    <option value="6" <?php if($user->user_height - 12 * floor($user->user_height/12) == 6) { echo "selected"; } ?> style="color:black;"> 6 </option>
                                    <option value="7" <?php if($user->user_height - 12 * floor($user->user_height/12) == 7) { echo "selected"; } ?> style="color:black;"> 7 </option>
                                    <option value="8" <?php if($user->user_height - 12 * floor($user->user_height/12) == 8) { echo "selected"; } ?> style="color:black;"> 8 </option>
                                    <option value="9" <?php if($user->user_height - 12 * floor($user->user_height/12) == 9) { echo "selected"; } ?> style="color:black;"> 9 </option>
                                    <option value="10" <?php if($user->user_height - 12 * floor($user->user_height/12) == 10) { echo "selected"; } ?> style="color:black;"> 10 </option>
                                    <option value="11" <?php if($user->user_height - 12 * floor($user->user_height/12) == 11) { echo "selected"; } ?> style="color:black;"> 11 </option>
                                </select>

                            </div>                        
                    </div> 
                    
                    <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Weight - pounds(optional)</label>
                            <div class="col-sm-9">
                                <input type="number" id="weight"  name="weight" class="  form-control" value="{{$user->weight}}"  placeholder="Weight - pounds"  required="required">
                            </div>
                    </div>
                    <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">            
                            <input type="email" name="email_address" class="  form-control" value="{{$user->email_address}}" placeholder="Email">
                             </div>
                    </div>

                @endif



                <input type="hidden" name="billing_id" class="  form-control" value="{{$user->billing_id}}">
                <input type="hidden" name="shipping_id" class="  form-control" value="{{$user->shipping_id}}">



                <div class="hidden">
                    <select id="country" name="billing_country_id"  data-plugin="newselect2" data-option="{}"  class="form-control" required="required">
                        @foreach($country as $c)
                            <option value="{{$c->auto_num}}" style="color:black;" <?php if($billing->billing_country_id == $c->auto_num) { echo "selected";}?>> {{$c->country_name}} </option>                        
                        @endforeach
                    </select>
                </div>


                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Billing Address </label>
                    <div class="col-sm-9">
                    <input type="text" id="billing_address1" name="billing_address1" class="form-control" value="{{$billing->billing_address1}}" placeholder="Billing Address" <?php echo $logintype == "1" ? "required='required'":"" ?> >
                    </div>
                </div>                                                        
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">  </label>
                    <div class="col-sm-9">
                    <input type="text" id="billing_address2" name="billing_address2"  value="{{$billing->billing_address2}}" class="form-control" placeholder="Billing Address"  <?php echo $logintype == "1" ? "required='required'":"" ?> >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Billing State/City/Zip </label>                                        
                    <div class="col-sm-3 form-group"> 
                        <select id="state" name="billing_state_id" class="form-control" data-plugin="newselect2" data-option="{}"   <?php echo $logintype == "1" ? "required='required'":"" ?> >    
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;" <?php if($billing->billing_state_id == $c->auto_num) { echo "selected";}?> > {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <select id="city" name="billing_city" class="form-control"  data-plugin="newselect2" data-option="{}"   <?php echo $logintype == "1" ? "required='required'":"" ?> >    
                            @foreach($city as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"  <?php if($billing->billing_city == $c->auto_num) { echo "selected";}?> > {{$c->city_name}} </option>                        
                            @endforeach
                        </select>                                                                
                    </div>          
                    
                    <div class="col-sm-3 form-group">
                        <input type="text" name="billing_zip" value="{{$billing->billing_zip}}"  class="form-control" placeholder="Zip"  <?php echo $logintype == "1" ? "required='required'":"" ?> >
                    </div>                        
                </div>
               



                <div class="form-group row center">          
                    <div class="form-check">
                        <input type="checkbox" onclick="popup();" value="" id="popCheckbox">
                        <label class="col-form-label" for="popCheckbox">
                        Shipping same as billing Address
                        </label>
                    </div>           
                </div>



                <div class="hidden">
                    <select id="country2" name="shipping_country_id"  data-plugin="newselect2" data-option="{}"  class="form-control" required="required">
                        @foreach($country as $c)
                            <option value="{{$c->auto_num}}" style="color:black;" <?php if($shipping->shipping_country_id == $c->auto_num) { echo "selected";}?> > {{$c->country_name}} </option>                        
                        @endforeach
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Shipping Address </label>
                    <div class="col-sm-9">
                    <input type="text" id="shipping_address1" name="shipping_address1" value="{{$shipping->shipping_address1}}" class="form-control" placeholder="Shipping Address"  <?php echo $logintype == "1" ? "required='required'":"" ?> >
                    </div>
                </div>                                                        
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">  </label>
                    <div class="col-sm-9">
                    <input type="text" id="shipping_address2" name="shipping_address2" value="{{$shipping->shipping_address2}}" class="form-control" placeholder="Shipping Address"  <?php echo $logintype == "1" ? "required='required'":"" ?> >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Shipping State/City/Zip </label>                    
                    <div class="col-sm-3 form-group"> 
                        <select id="state2" name="shipping_state_id" class="form-control" data-plugin="newselect2" data-option="{}"   <?php echo $logintype == "1" ? "required='required'":"" ?> >    
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;" <?php if($shipping->shipping_state_id == $c->auto_num) { echo "selected";}?> > {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 form-group">
                        <select id="city2" name="shipping_city" class="form-control"  data-plugin="newselect2" data-option="{}"   <?php echo $logintype == "1" ? "required='required'":"" ?> >    
                            @foreach($city2 as $c)
                                <option value="{{$c->auto_num}}" style="color:black;" <?php if($shipping->shipping_city == $c->auto_num) { echo "selected";}?> > {{$c->city_name}} </option>                        
                            @endforeach
                        </select>
                    </div>                    
                    <div class="col-sm-3 form-group">
                        <input type="text" name="shipping_zip" value="{{$shipping->shipping_zip}}"  class="form-control" placeholder="Zip"  <?php echo $logintype == "1" ? "required='required'":"" ?> >
                    </div>

                </div>


                <div class="col-md-6 form-group" style="padding: 0px;">                                           
                    <button class="btn btn-raised btn-wave mb-2 w-xs blue" style="float: right;">Save</button>
                </div>
                        

                <input type="hidden" name="company_id" class="  form-control" placeholder="First Name" value="{{Session::get('company_id')}}"  required="required">
                <div class="form-group hidden">
                    <label class="text-muted">User Type</label>
                    <select name="user_type_id" class="form-control" required="required">
                        @foreach($usertype as $u)
                            <option value="{{$u->auto_num}}" style="color:black;"> {{$u->user_type_name}} </option>                        
                        @endforeach
                    </select>
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
        var id = $("#country").val();        

        // var phoneMask = IMask(
        // document.getElementById('office_num'), {
        //     mask: '000-000-0000'
        // });

        var phoneMask = IMask(
        document.getElementById('home_num'), {
            mask: '000-000-0000'
        });

        var phoneMask = IMask(
        document.getElementById('mobile_num'), {
            mask: '000-000-0000'
        });
        // var phoneMask = IMask(
        // document.getElementById('fax_num'), {
        //     mask: '000-000-0000'
        // });
    });


    $('#state').on('change', function() {   
        var id = this.value;        
        var unitid = $("#city");
        initState(id , unitid, 0);               
    });

    $('#state2').on('change', function() {   
        var id = this.value;        
        var unitid = $("#city2");
        initState(id , unitid, 0);               
    });

    $("#mobile_num").change(function(){		
        var mobile_num = $("#mobile_num").val();        
        if(phonenumber(mobile_num)){            
        }else{
            alert("Please input correct mobile number!");
        }
	});

    $("#home_num").change(function(){		        
        var home_num = $("#home_num").val();
        if(phonenumber(home_num)){            
        }else{
            var  logintype = $("#logintype").val();
            if(logintype == '1'){
                alert("Please input correct home number!");
            }       
        }
    });
            
    $("#weight").change(function(){
       check();
    });
            
    $("#weight").addEventListener('focus', (event) => {
        check();
    });

    function check(){
        var home_num = $("#home_num").val();
        var mobile_num = $("#mobile_num").val();

        var  logintype = $("#logintype").val();
        if(logintype == '1'){
            if(phonenumber(mobile_num) && phonenumber(home_num) ){ 
            }else{
                alert("Please input correct phone number!");
            }                        
        }else{
            if(phonenumber(mobile_num) ){ 
            }else{
                alert("Please input correct phone number!");
            }   
        }       
    }


	function phonenumber(inputtxt){

	    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
	    if((inputtxt.match(phoneno))) {
            return true;
		}
		else
		{
			return false;
		}
    }
    

    function initState(id, unitid, type){        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
          type: 'POST',
          data: { id:id},
          url: "{{ URL::to('api/getCity')}}",
          success: function(result) {     
                var res = result.results;
                if(res == 200){

                    units = result.city;    
                    $(unitid).empty();
                    var toAppend = '';
                    $.each(units,function(i,o){                
                        toAppend += '<option value=' + o.auto_num +' style="color:black;" >'+ o.city_name +'</option>';                               
                    });
                    $(unitid).append(toAppend);

                    if(type == 1){
                        var e = document.getElementById("city");
                        var val = e.options[e.selectedIndex].value;
                        $('#city2').val(val);
                        $('#city2').select2().trigger('change');
                    }
                                               
                }else{
                    alert("Failed");
                }
          }
             
        });
    }

  

    function popup(){

        var chk = document.getElementById("popCheckbox").checked;

        if(chk){            
            var e = document.getElementById("state");
            var val = e.options[e.selectedIndex].value;
            var text = e.options[e.selectedIndex].text;
            
            $('#state2').val(val);
            $('#state2').select2().trigger('change');
        
            var unitid = $("#city2");
            initState(val , unitid, 1);

        }
    }
</script>

@stop

