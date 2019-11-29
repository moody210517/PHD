
@extends('admin.main')
@section('content')

<div class="page-container">

    <div id="content" class="flex ">
        <div class="page-container-1" id="page-container">
            <div class="page-title padding pb-0 ">
                <h2 class="text-md mb-0">Add User Type
                <a href="{{ url('admin/userType') }}" class="btn btn-primary" style="float: right;color: white;">Back</a>
                </h2>
            </div>        
        <div class="padding">


        <div class="tab-content">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form method="post" action="{{ url('admin/addUserType') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" style="line-height: 2;" required="required">
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required="required">

                            <option value="OM" > OM </option>  
                            <option value="DO" > DO </option>  
                            <option value="NU" > NU </option>  
                            <option value="PA" > PA </option>  
                            <option value="PT" > PT </option>
                            
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



