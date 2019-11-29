@extends('admin.main')
@section('content')

<div class="page-container">


<div id="content" class="flex ">
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0">Edit Bill
            <a href="{{ url('admin/bills') }}" class="btn btn-primary" style="float: right;color: white;">Back</a>
            </h2>
        </div>
        
        <div class="padding">

        <div class="tab-content mb-4">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form method="post" action="{{ url('admin/editBill')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->auto_num }}">
                                        


                     <div class="form-group">
                        <input type="text" name="billing_address1" class="form-control"  value="{{ $user->billing_address1 }}" placeholder="Name"  required="required">
                    </div>
                    <div class="form-group">
                        <input type="text" name="billing_address2" class="form-control" value="{{ $user->billing_address2 }}" placeholder="Name"  required="required">
                    </div>
                 
                               
                    <div class="form-group">
                        <input type="text" name="billing_zip" class="form-control" value="{{ $user->billing_zip }}" placeholder="Name"  required="required">
                    </div>
                   
            

                    <div class="form-group">
                        <label class="text-muted">Country</label>
                        <select id="country" name="billing_country_id" class="form-control" data-plugin="newselect2" data-option="{}"  required="required">
                            @foreach($country as $c)
                                <option value="{{$c->auto_num}}"  style="color:black;"  <?php if($c->auto_num == $user->billing_country_id) echo "selected"; ?> > {{$c->country_name}} </option>                        
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-muted">State</label>
                        <select id="state" name="billing_state_id" class="form-control" data-plugin="newselect2" data-option="{}"  required="required">    
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;" <?php if($c->auto_num == $user->billing_state_id) echo "selected"; ?> > {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label class="text-muted">City</label>
                        
                        <select id="city" name="billing_city" class="form-control"  data-plugin="newselect2" data-option="{}"  required="required">    
                            @foreach($city as $c)
                                <option value="{{$c->auto_num}}" style="color:black;" <?php if($c->auto_num == $user->billing_city) echo "selected"; ?> > {{$c->city_name}} </option>                        
                            @endforeach
                        </select>
                    </div>

                   


                    <div class="form-group" style="padding: 0px;">                        
                        <button class="btn btn-primary" style="float: right;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div>

@stop


@section('script')
<script type="text/javascript">   

    var deleteId = "";

    function deleteUser(id){
        
        deleteId = id;
    }

    $( document ).ready(function() {

        // setInterval(function(){         
        // },1000);
        var id = $("#country").val();             
    });


    $('#state').on('change', function() {
   
        var id = this.value;        
        initState(id)
                       
    });
             
    function initState(id){
        var unitid = $("#city");
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

