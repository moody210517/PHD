@extends('admin.main')
@section('content')   
    
<div class="page-container" id="page-container" >
	<div class="page-title padding pb-0 ">
		<h2 class="text-md mb-0">Edit Office Information</h2>
	</div>
	    
	<div class="padding">

			<div class="tab-content mb-4">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form method="post" action="{{ url('office/officeInformation')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->auto_num }}">                                        
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Company Name </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="company_name" value="{{$user->company_name}}" class="form-control" placeholder="Company Name" required="required">
                                    </div>
                                </div>

                                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Shipping Address </label>
                                    <div class="col-sm-9">
                                    <input type="text" name="physical_address1" value="{{$user->physical_address1}}" class="form-control" placeholder="Shipping Address" required="required">
                                    </div>
                                </div>   

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">  </label>
                                    <div class="col-sm-9">
                                    <input type="text" name="physical_address2"  value="{{$user->physical_address2}}" class="form-control" placeholder="Shipping Address"  required="required">
                                    </div>
                                </div>
                            
                                <!-- <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Country</label>                                
                                    
                                </div> -->
                                                                                        
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Shipping State/City/Zip </label>
                                    
                                    <div class="col-sm-2">
                                        <select id="country" name="physical_country_id"  data-plugin="select2" data-option="{}"  class="form-control" required="required">
                                            @foreach($country as $c)
                                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->country_name}} </option>                        
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-2">                                    
                                        <select id="state" name="physical_state_id" class="form-control" data-plugin="select2" data-option="{}"  required="required">    
                                            @foreach($state as $c)
                                                <option value="{{$c->auto_num}}" <?php if($c->auto_num == $user->physical_state_id) { echo "selected"; } ?> style="color:black;"> {{$c->state_name}} </option>                        
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-3">
                                        <select id="city" name="physical_city" class="form-control"  data-plugin="select2" data-option="{}"  required="required">    
                                            @foreach($physical_city as $c)
                                                <option value="{{$c->auto_num}}" <?php  if($c->auto_num == $user->physical_city) { echo "selected"; } ?> style="color:black;"> {{$c->city_name}} </option>                        
                                            @endforeach
                                        </select>                                                                
                                    </div>          
                                    
                                    <div class="col-sm-2">
                                        <input type="text" name="physical_zip"   value="{{$user->physical_zip}}" class="form-control" placeholder="Zip" required="required">
                                    </div>                        
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Mailing Address </label>
                                    <div class="col-sm-9">
                                    <input type="text" name="mailing_address1"  value="{{$user->mailing_address1}}"  class="form-control" placeholder="Mailing Address" required="required">
                                    </div>
                                </div>                                                        
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">  </label>
                                    <div class="col-sm-9">
                                    <input type="text" name="mailing_address2"  value="{{$user->mailing_address2}}"  class="form-control" placeholder="Mailing Address"  required="required">
                                    </div>
                                </div>

<!-- 
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Country</label>                                
                                    
                                </div> -->

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Shipping State/City/Zip </label>

                                    <div class="col-sm-2">
                                        <select id="country" name="mailing_country_id"  data-plugin="select2" data-option="{}"  class="form-control" required="required">
                                            @foreach($country as $c)
                                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->country_name}} </option>                        
                                            @endforeach
                                        </select>
                                    </div>

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
                                    <div class="col-sm-2">
                                        <input type="text" name="mailing_zip"   value="{{$user->mailing_zip}}"  class="form-control" placeholder="Zip" required="required">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Office Phone </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="office_phone"  value="{{$user->office_phone}}"  class="form-control" placeholder="Office Phone" required="required">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Office Fax </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="office_fax"   value="{{$user->office_fax}}"  class="form-control" placeholder="Office Fax" required="required">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Office Website </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="office_website"  value="{{$user->office_website}}"  class="form-control" placeholder="Office Website" required="required">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"> Office Email </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="office_email" value="{{$user->office_email}}"  class="form-control" placeholder="Office Email" required="required">
                                    </div>
                                </div>
                                                                
                                <div class="form-group" style="padding: 0px;">                    
                                    <button class="btn btn-primary" name="action" value="update" >Update Changes</button>
                                    <button id="btn_cancel" class="btn btn-primary" name="action" value="cancel" style="float: right;">Cancel  Changes</button>
                                </div>

                            </div>
                        </div>

                </form>

            </div>				
                </div>
	</div>
</div>

@stop



@section('script')
<script type="text/javascript">   
    
    var deleteId = "";
    function deleteUser(id){        
        deleteId = id;
    }

    $(document).ready( function() {                
        var id = $("#country").val();
        //initState(id);
    });
   
    $('#state').on('change', function() {   
        var id = this.value;        
        var unitid = $("#city");
        initState(id , unitid);               
    });

    $('#mail_state').on('change', function() {   
        var unitid = $("#mail_city");
        var id = this.value;        
        initState(id, unitid);  
    });
    
    $("#delBtn").click(function(){    
        var id = deleteId;
        //var request = $.get('{{ URL::to('admin/deleteUser')}}' + "?id=" + id);        
    });             

    function initState(id, unitid){        
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
                    
                }else{
                    alert("Failed");
                }
          }
             
        });
    }
</script>

@stop
