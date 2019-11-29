<div id="aside" class="page-sidenav no-shrink  nav-expand  animate fadeInLeft fade" aria-hidden="true">


    <div class="sidenav h-100 modal-dialog bg-white box-shadow">
        <!-- sidenav top -->
        <!-- Flex nav content -->
        <div class="flex scrollable hover">
            <div class="nav-border b-primary" data-nav>
                <ul class="nav bg">
                    <!-- <li class="nav-header hidden-folded">
                        <span>Main</span>
                    </li>
                    <li class="{!! Request::is('admin/dashboard') || Request::is('loginCheck') ? 'active' : '' !!}">
                        <a href="{{ URL::to('admin/dashboard')}}" class="i-con-h-a location-href" data-link="dashboard">
                        <span class="nav-icon">
                        <i class="i-con i-con-home"><i></i></i>
                        </span>
                        <span class="nav-text">Dashboard</span>
                        </a>
                    </li> -->
                    
                    <!-- {!! Request::is('admin/dashboard') ? 'active' : '' !!} -->

                    <!-- <li class="nav-header hidden-folded">
                        <span></span>
                    </li>                                                                       
                    -->
                    
                    @if(Session::get('user_type') == '0') 

                        <li> 
                            <a href="{{ url('admin/dashboard') }}" class="i-con-h-a">
                            <span class="nav-icon">
                                <i class="i-con i-con-home"><i></i></i>
                            </span>
                            <span class="nav-text">Home</span>
                            </a>
                        </li>

                        <!-- in the case of admin -->
                        <li class="nav-header hidden-folded">
                        <span>Customer management </span>
                        </li>

                        <!-- <li class="{!! Request::is('admin/users') || Request::is('admin/addUser') || Request::is('admin/editUser/*')|| Request::is('admin/editUser')|| Request::is('loginCheck') ? 'active' : '' !!}">
                            <a href="{{ URL::to('admin/users') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Office Manager</span> 
                            </a>
                        </li> --> 

                        <li class="{!! Request::is('admin/allUsers') ||   Request::is('admin/editUser') ||  Request::is('admin/editUser/*')  ? 'active' : '' !!}">
                            <a href="{{ URL::to('admin/allUsers') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">All Users</span> 
                            </a>
                        </li>


                        <li class="{!! Request::is('admin/company') || Request::is('admin/addCompany')  || Request::is('admin/editCompany/*') || Request::is('admin/editCompany') ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/company') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">Customer</span> 
                            </a>
                        </li>  

                        
                        <li class="{!! Request::is('admin/addUser')  ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/addUser') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">Add OfficeManager</span> 
                            </a>
                        </li>  


                        <li class="{!! Request::is('admin/devices') || Request::is('admin/addDevice')  || Request::is('admin/editDevice/*') || Request::is('admin/editDevice') ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/devices') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">PHD Devices</span> 
                            </a>
                        </li>  


                        <!-- <li class="{!! Request::is('admin/ships') || Request::is('admin/addShip') || Request::is('admin/editShip/*')|| Request::is('admin/editShip')|| Request::is('loginCheck') ? 'active' : '' !!}">
                            <a href="{{ URL::to('admin/ships') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-lock"><i></i></i> </span>
                            <span class="nav-text">Shipping</span> 
                            </a>
                        </li>
                        

                        <li class="{!! Request::is('admin/bills') || Request::is('admin/addBill') || Request::is('admin/editBill/*')|| Request::is('admin/editBill')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('admin/bills') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-lock"><i></i></i> </span>
                            <span class="nav-text">Billing</span> 
                            </a>
                        </li>          -->
                                                                        
                        <li class="nav-header hidden-folded">

                        
                        <li class="nav-header hidden-folded">
                            <span>Settings </span>
                        </li>

                        <li class="{!! Request::is('admin/country') ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/country') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">Country</span> 
                            </a>
                        </li>
                        
                        <li class="{!! Request::is('admin/state') ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/state') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">State</span> 
                            </a>
                        </li>

                        <li class="{!! Request::is('admin/cities') ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/cities') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">City</span> 
                            </a>
                        </li>


                        <li class="{!! Request::is('admin/usertype') || Request::is('admin/addUserType')  || Request::is('admin/editUserType/*')   || Request::is('admin/editUserType')   ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/usertype') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">User Type</span> 
                            </a>
                        </li>     

                        <li class="nav-header hidden-folded">
                            <span> Visit Settings </span>
                        </li>
                        <li class="{!! Request::is('admin/symptoms') || Request::is('admin/addSymptoms')  || Request::is('admin/editSymptoms/*')   || Request::is('admin/editSymptoms')   ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/symptoms') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">Visit Symptoms </span> 
                            </a>
                        </li>           
                        
                        <li class="{!! Request::is('admin/disease') || Request::is('admin/addDisease')  || Request::is('admin/editDisease/*')   || Request::is('admin/editDisease')   ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/disease') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">Visit Disease </span> 
                            </a>
                        </li>    
                        
                        <li class="{!! Request::is('admin/treatment') || Request::is('admin/addTreatment')  || Request::is('admin/editTreatment/*')   || Request::is('admin/editTreatment')   ? 'active' : '' !!}"> 
                            <a href="{{ url('admin/treatment') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-grid"><i></i></i> </span>
                            <span class="nav-text">Visit Treatment</span> 
                            </a>
                        </li>
                        

                        <!-- office manger case  -->
                    @elseif(Session::get('user_type') == '1')  
                        <li class="{!! Request::is('office/dashboard')  ? 'active' : '' !!}"> 
                            <a href="{{ url('office/dashboard') }}" class="i-con-h-a">
                            <span class="nav-icon">
                                <i class="i-con i-con-home"><i></i></i>
                            </span>
                            <span class="nav-text">Home</span>
                            </a>
                        </li>

                        <li class="nav-header hidden-folded">
                            <span>Patient Menu </span>
                        </li>

                        <!-- <li class="{!! Request::is('office/patients/add')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/patients/add') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">All Patients</span> 
                            </a>
                        </li> -->

                        <li class="{!! Request::is('office/addPatient') || Request::is('office/editUser/*')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/addPatient') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Add New Patient</span> 
                            </a>
                        </li>

                        <li class="{!! Request::is('office/patients/edit') || Request::is('office/editPatient') || Request::is('office/editPatient/*')|| Request::is('office/editUser')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/patients/edit') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Edit Patient</span> 
                            </a>
                        </li>                        
                        <li class="{!! Request::is('office/patients/delete') || Request::is('office/deletePatient') || Request::is('office/deletePatient/*')|| Request::is('office/editUser')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/patients/delete') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Delete Patient</span> 
                            </a>
                        </li>

                        <li class="{!! Request::is('office/testInformation') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/testInformation') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text">Test Information</span> 
                            </a>
                        </li>

                        <li class="nav-header hidden-folded">
                            <span>Office Menu </span>
                        </li>

                        <!-- <li class="{!! Request::is('office/users/add')|| Request::is('loginCheck') ? 'active' : '' !!}">        
                            <a href="{{ URL::to('office/users/add') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">All Users</span> 
                            </a>
                        </li> -->

                        <li class="{!! Request::is('office/addUser') || Request::is('loginCheck') ? 'active' : '' !!}">        
                            <a href="{{ URL::to('office/addUser') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Add User</span> 
                            </a>
                        </li>
                        
                        <li class="{!! Request::is('office/users/edit') || Request::is('office/users') || Request::is('office/editUser/*')|| Request::is('office/editUser')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/users/edit') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Edit User</span> 
                            </a>
                        </li>                                                

                        <li class="{!! Request::is('office/officeInformation') ||   Request::is('office/officeInformation/*')  ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/officeInformation') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text"> Edit Office Information </span> 
                            </a>
                        </li>
                        
                        <li class="{!! Request::is('office/suppliers2') || Request::is('office/card') || Request::is('office/checkout')  ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/suppliers2') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text"> Order PHD Suppliers </span> 
                            </a>
                        </li>

                        <li class="{!! Request::is('office/officeMessages') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/officeMessages') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text"> Office Messages </span> 
                            </a>
                        </li>

                                               
                    @elseif(Session::get('user_type') == '2' || Session::get('user_type') == '3' || Session::get('user_type') == '4' || Session::get('user_type') == '5')                  

                        <!-- <li class="{!! Request::is('doctor/dashboard')  ? 'active' : '' !!}"> 
                            <a href="{{ url('doctor/dashboard') }}" class="i-con-h-a">
                            <span class="nav-icon">
                                <i class="i-con i-con-home"><i></i></i>
                            </span>
                                <span class="nav-text">Home</span>
                            </a>
                        </li> -->

                        
                        <li class="{!! Request::is('doctor/testland')  || Request::is('doctor/prestep*')  || Request::is('doctor/pastTest*') 
                             || Request::is('doctor/testlists*')   || Request::is('doctor/editVisitForm*') || Request::is('doctor/review*')   ? 'active' : '' !!}"> 
                            <a href="{{ url('doctor/testland') }}" class="i-con-h-a">
                            <span class="nav-icon">
                                <i class="i-con i-con-home"><i></i></i>
                            </span>
                            <span class="nav-text">Test Menu</span>
                            </a>
                        </li>


                       

                        <li class="nav-header hidden-folded">
                            <span>Patient Test </span>
                        </li>

                        <!-- <li class="{!! Request::is('admin/steps') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('admin/steps') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text">New  Test</span> 
                            </a>
                        </li>

                        <li class="{!! Request::is('admin/graphic') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('admin/graphic') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text">Graphic Data Analytic</span> 
                            </a>
                        </li>
                                                
                        <li class="{!! Request::is('admin/tables') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('admin/tables') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text">Show Data in Table</span> 
                            </a>
                        </li> 

                        <li class="{!! Request::is('admin/history') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('admin/history') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text">Show History</span> 
                            </a>
                        </li>  -->

                        <li class="{!! Request::is('admin/test') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('admin/test') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-page"><i></i></i> </span>
                            <span class="nav-text">Test Review</span> 
                            </a>
                        </li> 



                        <li class="nav-header hidden-folded">
                            <span>Patient Menu </span>
                        </li>

                        <!-- <li class="{!! Request::is('office/patients/add')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/patients/add') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">All Patients</span> 
                            </a>
                        </li> -->

                        <li class="{!! Request::is('office/addPatient') || Request::is('office/editUser/*')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/addPatient') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Add New Patient</span> 
                            </a>
                        </li>

                        <li class="{!! Request::is('office/patients/edit') || Request::is('office/editPatient') || Request::is('office/editPatient/*')|| Request::is('office/editUser')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/patients/edit') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Edit Patient</span> 
                            </a>
                        </li>                        
                        <li class="{!! Request::is('office/patients/delete') || Request::is('office/deletePatient') || Request::is('office/deletePatient/*')|| Request::is('office/editUser')|| Request::is('loginCheck') ? 'active' : '' !!}">                                
                            <a href="{{ URL::to('office/patients/delete') }}" class="i-con-h-a location-href" data-link="calendar">
                            <span class="nav-icon"><i class="i-con i-con-users"><i></i></i> </span>
                            <span class="nav-text">Delete Patient</span> 
                            </a>
                        </li>

                        

                    @elseif(Session::get('user_type') == '3')

                    @elseif(Session::get('user_type') == '4')

                    @else

                    @endif

                    @if(Session::get('user_type') != '0')
                        

                    @endif                   

                    
                    @if(Session::get('user_type') == '0')
                        

                    @endif
                                          

                </ul>
            </div>
        </div>
        <!-- sidenav bottom -->
        <div class="no-shrink ">
            <div class="text-sm p-3 b-t">
                <div class="hidden-folded text-sm">
                    <div class="mt-1">
                    </div>
                    <div class="text-muted"><small class="text-muted">&copy; Copyright 2019</small></div>
                </div>
            </div>
        </div>
    </div>
</div>