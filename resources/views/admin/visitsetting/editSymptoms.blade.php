@extends('admin.main')
@section('content')

<div class="page-container">


<div id="content" class="flex ">
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0">Edit User Type
            <a href="{{ url('admin/userType') }}" class="btn btn-primary" style="float: right;color: white;">Back</a>
            </h2>
        </div>
        
        <div class="padding">

        <div class="tab-content mb-4">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
                <form method="post" action="{{ url('admin/editUserType')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->auto_num }}">
                    
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Email" style="line-height: 2;" value="{{ $user->user_type_name }}" required="required">
                    </div> 
                    
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required="required">                            
                            <option value="OM" <?php if($user->role == 'OM') {echo "selected";} ?> > OM </option>  
                            <option value="DO" <?php if($user->role == 'DO') {echo "selected";} ?>> DO </option>  
                            <option value="NU" <?php if($user->role == 'NU') {echo "selected";} ?>> NU </option>  
                            <option value="PA" <?php if($user->role == 'PA') {echo "selected";} ?>> PA </option>  
                            <option value="PT" <?php if($user->role == 'PT') {echo "selected";} ?>> PT </option>
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
