@extends('admin.main')
@section('content')

<div class="page-container">

    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            @if($logintype == "1")
            <h2 class="text-md mb-0">Add Patient
            <!-- <a href="{{ url('admin/users') }}" class="btn btn-primary" style="float: right;color: white;">Back</a> -->
            </h2>
            @else
            <h2 class="text-md mb-0">Test for New Patient
            <!-- <a href="{{ url('admin/users') }}" class="btn btn-primary" style="float: right;color: white;">Back</a> -->
            </h2>
            @endif
            
            <h6>(Please check/add billing address and shipping address before add user infos )</h6>
        </div>        
    <div class="padding">

    <div class="tab-content mb-4">
        <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">

            @if($page == 'patient')
            <form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('office/addPatient') }}" enctype="multipart/form-data">
            @else
            <form data-plugin="parsley" data-option="{}"  method="post" action="{{ url('office/addUser') }}" enctype="multipart/form-data">
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
                    <input type="text" name="last_name" class="  form-control" placeholder="Last Name"   required="required">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">EMR/EHR ID</label>
                    <div class="col-sm-9">
                    <input type="text" name="emrid" class="  form-control" placeholder="EMR/EHR ID" >
                    </div>
                </div>

                
                <!-- <div class="form-group row" type="hidden">
                    <label class="col-sm-3 col-form-label"> Office Number </label>
                    <div class="col-sm-9">
                    <input type="text" id="office_num" name="office_num" class="  form-control" placeholder="231-345-3426">
                    </div>
                </div> -->

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Mobile Number </label>
                    <div class="col-sm-9">
                    <input type="tel" id="mobile_num" name="mobile_num" class="  form-control" placeholder="231-345-3426"   required="required">
                    </div>                    
                </div>

                @if($logintype == "1")
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Home Number </label>
                    <div class="col-sm-9">
                        <input type="tel" id="home_num" name="home_num" class="  form-control" placeholder="231-345-3426" required = "required">
                    </div>                    
                </div>
                @else
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Home Number </label>
                    <div class="col-sm-9">
                        <input type="tel" id="home_num" name="home_num" class="  form-control" placeholder="231-345-3426">
                    </div>                    
                </div>
                @endif

                              

                <!-- <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Fax Number </label>
                    <div class="col-sm-9">
                    <input type="text" id="fax_num" name="fax_num" class="  form-control" placeholder="Fax Number">
                    </div>
                </div> -->                
                <!-- <div class="form-group">
                    <input type="text" name="home_email" class="  form-control" placeholder="Home Email"   required="required">
                </div> -->
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Birthday</label>
                    <div class="col-sm-9">
                    <input type="date" name="date_of_birth" class="  form-control" placeholder="Birthday"   required="required">
                    </div>                    
                </div>
               
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sex</label>
                    <div class="col-sm-9">
                    <select id="sex" name="sex" class="form-control" placeholder="Hour" required="required">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Male" class="text-black"> Male </option>  
                        <option value="Female"  class="text-black" > Female </option>  
                        <!-- <option value="Undisclosed"  class="text-black" > Undisclosed </option> -->
                    </select>
                    </div>                             
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Ethnicity </label>                                        
                    <div class="col-sm-3 form-group"> 
                        <select id="ethnicity" name="ethnicity" class="form-control" required="required">    
                            <option disabled selected value> -- select ethnicity -- </option>                            
                            <option value="Asian" style="color:black;"> Asian </option>                        
                            <option value="Black" style="color:black;"> Black </option>
                            <option value="Caucasian" style="color:black;"> Caucasian </option>
                            <option value="Hispanic" style="color:black;"> Hispanic </option>
                            <option value="Other" style="color:black;"> Other </option>
                        </select>
                    </div>
                </div>


                <!-- <div class="form-group">
                    <input type="number"  name="age" class="  form-control" placeholder="Age"   required="required">
                </div> -->

                @if($logintype == '1')
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Height - inches(optional)</label>
                    <div class="col-sm-4">
                        <!-- <input type="number" id="feet" name="feet" class="form-control" maxlength="2" size="2" > -->
                        <select id="feet" name="feet" class="form-control" required="required" placeholder="Height - FEET">    
                            <option disabled selected value> -- select feet -- </option>                            
                            <option value="3" style="color:black;"> 3 </option>                        
                            <option value="4" style="color:black;"> 4 </option>
                            <option value="5" style="color:black;"> 5 </option>
                            <option value="6" style="color:black;"> 6 </option>
                            <option value="7" style="color:black;"> 7 </option>
                            <option value="8" style="color:black;"> 8 </option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <!-- <input type="number" id="inche" name="inche" class="  form-control" placeholder="Height - inches"> -->
                        <select id="inche" name="inche" class="form-control" required="required" placeholder="Height - inches">    
                            <option disabled selected value> -- select inches -- </option>                            
                            <option value="0" style="color:black;"> 0 </option>                        
                            <option value="1" style="color:black;"> 1 </option>
                            <option value="2" style="color:black;"> 2 </option>
                            <option value="3" style="color:black;"> 3 </option>
                            <option value="4" style="color:black;"> 4 </option>
                            <option value="5" style="color:black;"> 5 </option>
                            <option value="6" style="color:black;"> 6 </option>
                            <option value="7" style="color:black;"> 7 </option>
                            <option value="8" style="color:black;"> 8 </option>
                            <option value="9" style="color:black;"> 9 </option>
                            <option value="10" style="color:black;"> 10 </option>
                            <option value="11" style="color:black;"> 11 </option>
                        </select>
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Weight - pounds(optional)</label>
                    <div class="col-sm-9">
                    <input type="number" id="weight"  name="weight" class="  form-control" onfocus="check()" placeholder="Weight - pounds">
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">            
                    <input type="email" name="email_address" class="  form-control" placeholder="Email"    required="required">
                    </div>
                </div>
                @else
                <div class="form-group row">
                    <label class="col-sm-3 mt-1 col-form-label">Height - inches(optional)</label>
                    <div class="col-sm-4 mt-1">
                        <!-- user_height -->
                        <!-- <input type="number" id="feet" name="feet" class="  form-control"  maxlength="2"  size="2" placeholder="Height - FEET" required="required"> -->
                        <select id="feet" name="feet" class="form-control" required="required" placeholder="Height - FEET">    
                            <option disabled selected value> -- select feet -- </option>                            
                            <option value="3" style="color:black;"> 3 </option>                        
                            <option value="4" style="color:black;"> 4 </option>
                            <option value="5" style="color:black;"> 5 </option>
                            <option value="6" style="color:black;"> 6 </option>
                            <option value="7" style="color:black;"> 7 </option>
                            <option value="8" style="color:black;"> 8 </option>
                        </select>
                    </div>
                    <div class="col-sm-4 mt-1">
                        <!-- user_height -->
                        <!-- <input type="number" id="inche" name="inche" class="  form-control" placeholder="Height - inches" required="required"> -->
                        <select id="inche" name="inche" class="form-control" required="required" placeholder="Height - inches">    
                            <option disabled selected value> -- select inches -- </option>                            
                            <option value="0" style="color:black;"> 0 </option>                        
                            <option value="1" style="color:black;"> 1 </option>
                            <option value="2" style="color:black;"> 2 </option>
                            <option value="3" style="color:black;"> 3 </option>
                            <option value="4" style="color:black;"> 4 </option>
                            <option value="5" style="color:black;"> 5 </option>
                            <option value="6" style="color:black;"> 6 </option>
                            <option value="7" style="color:black;"> 7 </option>
                            <option value="8" style="color:black;"> 8 </option>
                            <option value="9" style="color:black;"> 9 </option>
                            <option value="10" style="color:black;"> 10 </option>
                            <option value="11" style="color:black;"> 11 </option>
                        </select>
                        
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Weight - pounds(optional)</label>
                    <div class="col-sm-9">
                    <input type="number" id="weight"  name="weight" class="  form-control" placeholder="Weight - pounds" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">            
                    <input type="email" name="email_address" class="  form-control" placeholder="Email">
                    </div>
                </div>
                @endif
                
                                                           


                <!-- <div class="form-group">
                    <input type="password" name="user_password" class="  form-control" placeholder="Password" id="pwd"  required="required">
                </div>

                <div class="form-group">
                    <input type="password" name="confirmPassword" class="  form-control" data-parsley-equalto="#pwd" placeholder="Confirm Password"   required="required">
                </div> -->

                <!-- <div class="form-group">
                    <input type="text" name="shipping_id" class="  form-control" placeholder="Shipping Address"    required="required">
                </div>

                <div class="form-group">
                    <input type="text" name="billing_id" class="  form-control" placeholder="Billing Addresss"    required="required">
                </div> -->


                <div class="hidden">
                    <select id="country" name="billing_country_id"  data-plugin="select2" data-option="{}"  class="form-control" required="required">
                        @foreach($country as $c)
                            <option value="{{$c->auto_num}}" style="color:black;"> {{$c->country_name}} </option>                        
                        @endforeach
                    </select>
                </div>


                @if($logintype == '1')
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Billing Address </label>
                    <div class="col-sm-9">
                    <input type="text" id="billing_address1" name="billing_address1" class="form-control" placeholder="Billing Address" required="required">
                    </div>
                </div>                                                        
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">  </label>
                    <div class="col-sm-9">
                    <input type="text" id="billing_address2" name="billing_address2" class="form-control" placeholder="Billing Address" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Billing State/City/Zip </label>                                        
                    <div class="col-sm-3 form-group"> 
                        <select id="state" name="billing_state_id" class="form-control" data-plugin="select2" data-option="{}"  required="required">    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-3 form-group">
                        <select id="city" name="billing_city" class="form-control"  data-plugin="select2" data-option="{}"  required="required">    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($city as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->city_name}} </option>                        
                            @endforeach
                        </select>                                                                
                    </div>          
                    
                    <div class="col-sm-3 form-group">
                        <input type="text" id="billing_zip" name="billing_zip"  class="form-control" placeholder="Zip" required="required">
                    </div>                        
                </div>

                @else

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Billing Address </label>
                    <div class="col-sm-9">
                    <input type="text" id="billing_address1" name="billing_address1" class="form-control" placeholder="Billing Address">
                    </div>
                </div>                                                        
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">  </label>
                    <div class="col-sm-9">
                    <input type="text" id="billing_address2" name="billing_address2" class="form-control" placeholder="Billing Address">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Billing State/City/Zip </label>                                        
                    <div class="col-sm-3 form-group"> 
                        <select id="state" name="billing_state_id" class="form-control" data-plugin="select2" data-option="{}"  >    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>


                    <div class="col-sm-3 form-group">
                        <select id="city" name="billing_city" class="form-control"  data-plugin="select2" data-option="{}" >    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($city as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->city_name}} </option>                        
                            @endforeach
                        </select>                                                                
                    </div>          
                    
                    <div class="col-sm-3 form-group">
                        <input type="text" id="billing_zip" name="billing_zip"  class="form-control" placeholder="Zip" >
                    </div>                        
                </div>

                @endif



                <div class="form-group row center">          
                    <div class="form-check">
                        <input type="checkbox" onclick="popup();" value="" id="popCheckbox">
                        <label class="col-form-label" for="popCheckbox">
                        Shipping same as billing Address
                        </label>
                    </div>           
                </div>
 
                <!-- hide country -->
                <div class="hidden">
                    <select id="country2" name="shipping_country_id"  data-plugin="select2" data-option="{}"  class="form-control" required="required">
                        @foreach($country as $c)
                            <option value="{{$c->auto_num}}" style="color:black;"> {{$c->country_name}} </option>                        
                        @endforeach
                    </select>
                </div>



                @if($logintype == '1')
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Shipping Address </label>
                    <div class="col-sm-9">
                    <input type="text" id="shipping_address1" name="shipping_address1" class="form-control" placeholder="Shipping Address" required="required">
                    </div>
                </div>                                                        
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">  </label>
                    <div class="col-sm-9">
                    <input type="text" id="shipping_address2" name="shipping_address2" class="form-control" placeholder="Shipping Address" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Shipping State/City/Zip </label>                    
                   
                    <div class="col-sm-3 form-group"> 
                        <select id="state2" name="shipping_state_id" class="form-control" data-plugin="select2" data-option="{}"  required="required">    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <select id="city2" name="shipping_city" class="form-control"  data-plugin="select2" data-option="{}"  required="required">    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($city as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->city_name}} </option>                        
                            @endforeach
                        </select>                                                                
                    </div>          
                    
                    <div class="col-sm-3 form-group">
                        <input type="text" id="shipping_zip" name="shipping_zip"  class="form-control" placeholder="Zip" required="required">
                    </div>                        
                </div>
                @else
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Shipping Address </label>
                    <div class="col-sm-9">
                    <input type="text" id="shipping_address1" name="shipping_address1" class="form-control" placeholder="Shipping Address">
                    </div>
                </div>                                                        
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">  </label>
                    <div class="col-sm-9">
                    <input type="text" id="shipping_address2" name="shipping_address2" class="form-control" placeholder="Shipping Address">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"> Shipping State/City/Zip </label>                    
                   
                    <div class="col-sm-3 form-group"> 
                        <select id="state2" name="shipping_state_id" class="form-control" data-plugin="select2" data-option="{}" >    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 form-group">
                        <select id="city2" name="shipping_city" class="form-control"  data-plugin="select2" data-option="{}" >    
                            <option disabled selected value> -- select an option -- </option>
                            @foreach($city as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->city_name}} </option>                        
                            @endforeach
                        </select>                                                                
                    </div>          
                    
                    <div class="col-sm-3 form-group">
                        <input type="text" id="shipping_zip" name="shipping_zip"  class="form-control" placeholder="Zip" >
                    </div>
                                                         
                </div>
                @endif
                
                
                <div class="form-group">  
                    <button class="btn btn-primary" style="float: right;">Save</button>
                </div>

                <input type="hidden" name="company_id" class="  form-control" placeholder="First Name" value="{{Session::get('company_id')}}"  required="required">   

                <div class="form-group hidden" >
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
@stop


@section('script')
<script src="https://unpkg.com/imask"></script>
<script type="text/javascript">   
     
     var type = 0;
    $(document).ready( function($) {                
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
        //mask: '+{7}(000)000-00-00'    

    });

   
    $('#state').on('change', function() {   
        var id = this.value;        
        var unitid = $("#city");
        initState(id , unitid, 0);
    });
    
    $('#state2').on('change', function() {
        var id = this.value;        
        var unitid = $("#city2");
        initState(id , unitid, type);               
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
            alert("Please input correct home number!");
        }
	});

    $("#weight").change(function(){
       check();
	});
            
    function check(){
        var home_num = $("#home_num").val();
        var mobile_num = $("#mobile_num").val();
        if(phonenumber(mobile_num) && phonenumber(home_num)){
        }else{
            alert("Please input correct phone number!");
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
                   
                    toAppend +=  '<option disabled selected value> -- select an option -- </option>';
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

            $("#shipping_address1").val( document.getElementById("billing_address1").value );
            $("#shipping_address2").val( document.getElementById("billing_address2").value );
            $("#shipping_zip").val( document.getElementById("billing_zip").value );

            var e = document.getElementById("state");
            var val = e.options[e.selectedIndex].value;
            var text = e.options[e.selectedIndex].text;

            type = 1;
            $('#state2').val(val);
            $('#state2').select2().trigger('change');

            //var unitid = $("#city2");
            //initState(val , unitid, type);

        }
    }
</script>

@stop


