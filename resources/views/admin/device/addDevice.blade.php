
@extends('admin.main')
@section('content')

<div class="page-container">

    <div id="content" class="flex ">
        <div class="page-container-1" id="page-container">
            <div class="page-title padding pb-0 ">
                <h2 class="text-md mb-0">Add Device
                <a href="{{ url('admin/devices') }}" class="btn btn-primary" style="float: right;color: white;">Back</a>
                </h2>
            </div>        
        <div class="padding">


        <div class="tab-content">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form method="post" action="{{ url('admin/addDevice') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="serial_num" class="form-control" placeholder="Serial Number" required="required">
                    </div>


                    <div class="form-group">
                        <label class="text-muted">Company</label>
                        <select id="company_id" name="company_id"  data-plugin="select2" data-option="{}"  class="form-control" required="required">
                            @foreach($company as $c)
                                <option value="{{$c->auto_num}}" style="color:black;"> {{$c->company_name}} </option>                        
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



