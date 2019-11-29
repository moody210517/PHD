@extends('admin.main')
@section('content')

<div class="page-container">


<div id="content" class="flex ">
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0">Edit Company
            <a href="{{ url('admin/company') }}" class="btn btn-primary" style="float: right;color: white;">Back</a>
            </h2>
        </div>

        <div class="padding">
        <div class="tab-content mb-4">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form  id="AccountFrm" data-plugin="parsley" data-option="{}"  method="post" action="{{ url('admin/editCompany')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->auto_num }}">
                                        
                        <div class="card">
                            <div class="card-body">


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> First Name </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="first_name" name="first_name"  value="{{$user->first_name}}" class="form-control" placeholder="First Name" required="required">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Last Name </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="last_name" name="last_name"  value="{{$user->last_name}}" class="form-control" placeholder="Last Name" required="required">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Company Name </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="company_name" value="{{$user->company_name}}" class="form-control" placeholder="Company Name" required="required">
                                    </div>
                                </div>
                                                                                
                                
                            
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Shipping Country</label>                                
                                    <div class="col-sm-8">
                                        <select id="country" name="physical_country_id"  data-plugin="newselect2" data-option="{}"  class="form-control" required="required">
                                            @foreach($country as $c)
                                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->country_name}} </option>                        
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                        
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Shipping State/City/Zip </label>
                                    
                                    <div class="col-sm-2">                                    
                                        <select id="state" name="physical_state_id" class="form-control" data-plugin="newselect2" data-option="{}"  required="required">    
                                            @foreach($state as $c)
                                                <option value="{{$c->auto_num}}" <?php if($c->auto_num == $user->physical_state_id) { echo "selected"; } ?> style="color:black;"> {{$c->state_name}} </option>                        
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-3">
                                        <select id="city" name="physical_city" class="form-control"  data-plugin="newselect2" data-option="{}"  required="required">    
                                            @foreach($physical_city as $c)
                                                <option value="{{$c->auto_num}}" <?php  if($c->auto_num == $user->physical_city) { echo "selected"; } ?> style="color:black;"> {{$c->city_name}} </option>                        
                                            @endforeach
                                        </select>                                                                
                                    </div>          
                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="physical_zip" name="physical_zip"   value="{{$user->physical_zip}}" class="form-control" placeholder="Zip" required="required">
                                    </div>                        
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Shipping Address </label>
                                    <div class="col-sm-8">
                                    <input type="text" id="physical_address1" name="physical_address1" value="{{$user->physical_address1}}" class="form-control" placeholder="Shipping Address" required="required">
                                    </div>
                                </div>                                                        
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">  </label>
                                    <div class="col-sm-8">
                                    <input type="text" id="physical_address2" name="physical_address2"  value="{{$user->physical_address2}}" class="form-control" placeholder="Shipping Address">
                                    </div>
                                </div>



                                                                

                                <div class="form-group row center">          
                                    <div class="form-check">
                                        <input type="checkbox" onclick="popup();" value="" id="popCheckbox">
                                        <label class="col-form-label" for="popCheckbox">
                                        Billing same as shipping Address
                                        </label>
                                    </div>           
                                </div>



                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Billing Country</label>                                
                                    <div class="col-sm-8">
                                        <select id="country" name="mailing_country_id"  data-plugin="newselect2" data-option="{}"  class="form-control" required="required">
                                            @foreach($country as $c)
                                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->country_name}} </option>                        
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Billing State/City/Zip </label>
                                    <div class="col-sm-2">                                        
                                        <select id="mail_state" name="mailing_state_id" class="form-control" data-plugin="select2" data-option="{}"  required="required">    
                                            @foreach($state as $c)
                                                <option value="{{$c->auto_num}}" <?php  if($c->auto_num == $user->mailing_state_id) { echo "selected"; } ?> style="color:black;"> {{$c->state_name}} </option>                        
                                            @endforeach
                                        </select>
                                    </div>  

                                    <div class="col-sm-3">
                                        <select id="mail_city" name="mailing_city" class="form-control"  data-plugin="select2" data-option="{}"  required="required">    
                                            @foreach($mailing_city as $c)
                                                <option value="{{$c->auto_num}}" <?php  if($c->auto_num == $user->mailing_city) { echo "selected"; } ?> style="color:black;"> {{$c->city_name}} </option>                        
                                            @endforeach
                                        </select>                                                  
                                    </div>

                                    <div class="col-sm-3">
                                        <input type="text" id="mailing_zip" name="mailing_zip"   value="{{$user->mailing_zip}}"  class="form-control" placeholder="Zip" required="required">
                                    </div>                        

                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Billing Address </label>
                                    <div class="col-sm-8">
                                    <input type="text" id="mailing_address1" name="mailing_address1"  value="{{$user->mailing_address1}}"  class="form-control" placeholder="Mailing Address" required="required">
                                    </div>
                                </div>                                                        
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">  </label>
                                    <div class="col-sm-8">
                                    <input type="text" id="mailing_address2" name="mailing_address2"  value="{{$user->mailing_address2}}"  class="form-control" placeholder="Mailing Address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Office Phone </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="office_phone" name="office_phone"  value="{{$user->office_phone}}"  class="form-control" placeholder="Office Phone" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Office Fax </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="office_fax" name="office_fax"   value="{{$user->office_fax}}"  class="form-control" placeholder="Office Fax">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Office Website </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="office_website"  value="{{$user->office_website}}"  class="form-control" placeholder="Office Website">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"> Office Email </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="office_email" value="{{$user->office_email}}"  class="form-control" placeholder="Office Email" required="required">
                                    </div>
                                </div>
                                
                                
                                <div class="form-group" style="padding: 0px;">                    
                                    <button class="btn btn-primary" style="float: right;">Save</button>
                                </div>

                            </div>
                        </div>

                    
                </form>
            </div>
        </div>
    </div>
</div>


<div>

@stop




@section('script')
<script src="https://unpkg.com/imask"></script>
<script type="text/javascript">   
    
    var deleteId = "";
    var type = 0;

    function deleteUser(id){        
        deleteId = id;
    }    
    $(document).ready( function() {                        
        var id = $("#country").val();                
        var phoneMask = IMask(
        document.getElementById('office_phone'), {
            mask: '000-000-0000'
        });

        var phoneMask = IMask(
        document.getElementById('office_fax'), {
            mask: '000-000-0000'
        });

    });

   
    $('#state').on('change', function() {   
        var id = this.value;        
        var unitid = $("#city");
        initState(id , unitid, 0);               
    });

    $('#mail_state').on('change', function() {   
        var unitid = $("#mail_city");
        var id = this.value;        
        initState(id, unitid, type);  
    });
    
    $("#delBtn").click(function(){    
        var id = deleteId;
        //var request = $.get('{{ URL::to('admin/deleteUser')}}' + "?id=" + id);        
    });             

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
                        //select2
                        //$('#mail_city').val(val);
                        //$('#mail_city').select2().trigger('change');
                        //select
                        document.getElementById("mail_city").value = val;
                        $('#mail_city').trigger("change");
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

            $("#mailing_address1").val( document.getElementById("physical_address1").value );
            $("#mailing_address2").val( document.getElementById("physical_address2").value );
            $("#mailing_zip").val( document.getElementById("physical_zip").value );

            var e = document.getElementById("state");
            var val = e.options[e.selectedIndex].value;
            v ar text = e.options[e.selectedIndex].text;

            type = 1;
            //$('#mail_state').val(val);
            //$('#mail_state').select2().trigger('change');

            document.getElementById("mail_state").value = val;
            $('#mail_state').trigger("change");

            //document.getElementById("mail_state").selectedIndex = val;

            //var unitid = $("#city2");
            //initState(val , unitid, type);

        }
    }

   

</script>

@stop

