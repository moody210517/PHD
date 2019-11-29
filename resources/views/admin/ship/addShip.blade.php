@extends('admin.main')
@section('content')

<div class="page-container">

    <div id="content" class="flex ">
        <div class="page-container-1" id="page-container">
            <div class="page-title padding pb-0 ">
                <h2 class="text-md mb-0">Add Shipping
                <a href="{{ url('admin/ships') }}" class="btn btn-primary" style="float: right;color: white;">Back</a>
                </h2>
            </div>        
        <div class="padding">


        <div class="tab-content">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form method="post" action="{{ url('admin/addShip') }}" enctype="multipart/form-data">
                    @csrf

          

                    <div class="form-group">
                        <input type="text" name="shipping_address1" class="form-control" placeholder="Shipping Address 1" required="required">
                    </div>
                    <div class="form-group">
                        <input type="text" name="shipping_address2" class="form-control" placeholder="Shipping Address 2" required="required">
                    </div>
                    
                   

                    <div class="form-group">
                        <input type="text" name="shipping_zip" class="form-control" placeholder="Shipping Zip" required="required">
                    </div>
               

                    <div class="form-group">
                        <label class="text-muted">Country</label>
                        <select id="country" name="shipping_country"  data-plugin="select2" data-option="{}"  class="form-control" required="required">
                            @foreach($country as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->country_name}} </option>                        
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-muted">State</label>
                        <select id="state" name="shipping_state" class="form-control" data-plugin="select2" data-option="{}"  required="required">    
                            @foreach($state as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->state_name}} </option>                        
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="text-muted">City</label>
                        
                        <select id="city" name="shipping_city" class="form-control"  data-plugin="select2" data-option="{}"  required="required">    
                            @foreach($city as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->city_name}} </option>                        
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
        initState(id);                       
    });
    
    $("#delBtn").click(function(){    
        var id = deleteId;
        //var request = $.get('{{ URL::to('admin/deleteUser')}}' + "?id=" + id);
        
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


