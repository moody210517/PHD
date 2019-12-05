@extends('admin.main')
@section('content')   
<div class="" id="page-container">
    <input type="hidden" value="{{Session::get('user_id')}}" id="user_id"/>
    <input type="hidden" value="{{Session::get('company_id')}}" id="company_id"/>
    <input type="hidden" value="{{$allocation->first()?$allocation->first()->step:'0'}}" id="step_id"/>
    @if($allocation->first())                                                                                        
      <input type="hidden" value="{{$allocation->first()->auto_num}}"  id="allocation_id"/>
    @else
    <input type="hidden" value="-1"  id="allocation_id"/>
    @endif   

	<div class="page-title padding pb-0 ">
		<h2 class="text-md mb-0" id="page_title">New Test</h2>
	</div>
	<div class="padding">
  

  <div class="card">
    <div class="card-header">
      <strong id="step_title">Patient Test Step 1 : Select Patient and select PHD Device</strong>
    </div>

    <div class="card-body"  data-plugin="parsley" data-option="{}" >
        <form id="form">
          <div id="rootwizard" data-plugin="bootstrapWizard" data-option="{
            tabClass: '',
            nextSelector: '.button-next', 
            previousSelector: '.button-previous', 
            firstSelector: '.button-first', 
            lastSelector: '.button-last',
            onTabClick: function(tab, navigation, index) {
              return false;
            },
            onNext: function(tab, navigation, index) {
              var instance = $('#form').parsley();
              instance.validate();
              if(!instance.isValid()) {                  
                return false;
              }              
              onNext(index);
            },
            onPrevious: function(tab, navigation, index) {
              var instance = $('#form').parsley();
              instance.validate();
              if(!instance.isValid()) {                  
                return false;
              }
              onPrevious(index);
              
            }
          }">
                    
            <ul class="nav mb-1">

              <!-- first step -->
              @if($allocation->first())
              <li class="nav-item">
                <a class="nav-link " href="#tab1" data-toggle="tab">
              @else
              <li class="nav-item active show">
                <a class="nav-link active show" href="#tab1" data-toggle="tab">
              @endif              
                  <span class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-success">1</span>
                  <div class="mt-2">
                    <span>Step 1</span>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>

              <!-- second step  -->
              @if($allocation->first())
              <li class="nav-item <?php if($allocation->first()->step == "1") echo " active show"; ?>">
                <a class="nav-link  <?php if($allocation->first()->step == "1") echo " active show"; ?>" href="#tab2" data-toggle="tab">
              @else
              <li class="nav-item">
                <a class="nav-link" href="#tab2" data-toggle="tab">
              @endif
                  <span class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-success">2</span>
                  <div class="mt-2">
                    <span>Step 2</span>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>

              <!-- third step  -->
              @if($allocation->first())
              <li class="nav-item <?php if($allocation->first()->step == "2") echo " active show"; ?>">
                <a class="nav-link  <?php if($allocation->first()->step == "2") echo " active show"; ?>" href="#tab3" data-toggle="tab">
              @else
              <li class="nav-item">
                <a class="nav-link" href="#tab3" data-toggle="tab">
              @endif              
                  <span class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-success">3</span>
                  <div class="mt-2">
                    <span>Step 3</span>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>

              <!-- fourth step  -->
              @if($allocation->first())
              <li class="nav-item <?php if($allocation->first()->step == "3") echo " active show"; ?>">
                <a class="nav-link  <?php if($allocation->first()->step == "3") echo " active show"; ?>" href="#tab4" data-toggle="tab">
              @else
              <li class="nav-item">
                <a class="nav-link" href="#tab4" data-toggle="tab">
              @endif
                  <span class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-success">4</span>
                  <div class="mt-2">
                    <span>Step 4</span>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>
              
              <!-- fifth step -->
              @if($allocation->first())
              <li class="nav-item <?php if($allocation->first()->step == "4") echo " active show"; ?>">
                <a class="nav-link  <?php if($allocation->first()->step == "4") echo " active show"; ?>" href="#tab5" data-toggle="tab">
              @else
              <li class="nav-item">
                <a class="nav-link" href="#tab5" data-toggle="tab">
              @endif                           
                  <span class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-success">5</span>
                  <div class="mt-2">
                    <span>Step 5</span>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>

              <!-- sixth step -->
              @if($allocation->first())
              <li class="nav-item <?php if($allocation->first()->step == "5") echo " active show"; ?>">
                <a class="nav-link  <?php if($allocation->first()->step == "5") echo " active show"; ?>" href="#tab6" data-toggle="tab">
              @else
              <li class="nav-item">
                <a class="nav-link" href="#tab6" data-toggle="tab">
              @endif             
                  <span class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-success">6</span>
                  <div class="mt-2">
                    <span>Step 6</span>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>



              <!-- seventh step -->
              @if($allocation->first())
              <li class="nav-item <?php if($allocation->first()->step == "6") echo " active show"; ?>">
                <a class="nav-link  <?php if($allocation->first()->step == "6") echo " active show"; ?>" href="#tab7" data-toggle="tab">
              @else
              <li class="nav-item">
                <a class="nav-link" href="#tab7" data-toggle="tab">
              @endif             
                  <span class="w-32 d-inline-flex align-items-center justify-content-center circle bg-light active-bg-success">7</span>
                  <div class="mt-2">
                    <span>Step 7</span>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>


              <!-- completed step -->
              @if($allocation->first())
              <li class="nav-item <?php if($allocation->first()->step == "7") echo " active show"; ?>">
                <a class="nav-link  <?php if($allocation->first()->step == "7") echo " active show"; ?>" href="#tab8" data-toggle="tab">
              @else
              <li class="nav-item">
                <a class="nav-link" href="#tab8" data-toggle="tab">
              @endif             
                  <span class="w-32 d-inline-flex align-items-center justify-content-center "></span>
                  <div class="mt-2">                    
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>
              
              <!-- complete parameter 0: complete, 1: allocated , 2: aborted -->                            
              <li class="right" style="text-align: right; float:right !important">
                <a class="nav-link" style="float:right;">        
                  <div class="col-xl-4 col-md-12" style="float:right;">  
                    <button type="button" class="btn btn-primary" id="abort" data-toggle="modal" data-target="#m" style="float:right; display: none;">Abort Test</button>
                    <div class="text-muted"></div>
                  </div>
                </a>
              </li>                                           
            </ul>


            <div class="tab-content p-3">      
              @if($allocation->first())
              <div class="tab-pane" id="tab1"> 
              @else
              <div class="tab-pane active" id="tab1"> 
              @endif                
                               
                     <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="block px-4 py-3">
                            <div class="row col-1g-12">                                  
                                  <div class="col-lg-6 col-12">
                                        <div class="d-flex align-items-center i-con-h-a my-1">
                                            <div>
                                                <span class="avatar w-40 b-a b-2x">
                                                <i class="i-con i-con-user b-2x text-primary"><i></i></i>                                        
                                                </span>                                                  
                                                <label class="text-muted">Patient</label>                             
                                            </div>                                                                        
                                            <div class="col-lg-8">                                         
                                                <label> {{ $patient->first_name.", ".$patient->last_name }} <label>
                                                <input value="{{$patient->id}}" id="patient_id" name="patient_id" type="hidden" />
                                                <input value="{{$visit_form_id}}" id="visit_form_id" name="visit_form_id" type="hidden" />
                                                <input value="{{$diabet_risk_id}}" id="diabet_risk_id" name="diabet_risk_id" type="hidden" />
                                                <input value='{{ $patient->first_name.", ".$patient->last_name }}' id="patient_name" name="patient_name" type="hidden" />                                                
                                            </div>
                                        </div>
                                    </div>
                                                                
                                    <div class="col-lg-6 col-12">
                                        <div class="d-flex align-items-center i-con-h-a my-1">
                                            <div>
                                                <span class="avatar w-40 b-a b-2x">
                                                <i class="i-con i-con-history b-2x text-success"><i></i></i>
                                                </span>
                                                <label class="text-muted">Device</label>   
                                            </div>
                                            <div class="col-lg-8">                                                               
                                                <select id="device_id" name="device_id"  class="form-control" required="required">
                                                    @if($allocation->first())
                                                    
                                                        @foreach($devices as $c)
                                                            <option value="{{$c->auto_num}}" style="color:black;"  <?php  if($c->auto_num == $allocation->first()->serial_num) { echo "selected";} ?>  > {{$c->serial_num}} </option>
                                                        @endforeach
                                                    @else
                                                        @foreach($devices as $c)
                                                            <option value="{{$c->auto_num}}" style="color:black;" > {{$c->serial_num}} </option>                        
                                                        @endforeach
                                                    @endif
                                                    
                                                </select>                                        
                                            </div>
                                        </div>
                                    </div>                                    
                            </div>       
                                                    
                            
                            <div class="col-md-4 col-lg-6 col-12">
                              <div class="card-body">
                                  <div class="form-control">

                                      <strong value="text" >Disable Sensors</strong>

                                      <div class="checkbox">
                                          <label class="ui-check">
                                            <input type="checkbox"  id="oxymeter" <?php $data = $allocation->first(); if($data){ if(strpos($data->tracking, '1') !== false) {echo "checked";} } ?> >
                                            <i class="dark-white"></i>                                            
                                            Pulse Oximeter
                                          </label>
                                      </div>

                                       <div class="checkbox">
                                          <label class="ui-check">
                                            <input type="checkbox" id="blood"  <?php $data = $allocation->first(); if($data){ if(strpos($data->tracking, '2') !== false) {echo "checked";} } ?>  >
                                            <i class="dark-white"></i>
                                            Blood Pressure
                                          </label>
                                      </div>


                                       <div class="checkbox">
                                          <label class="ui-check">
                                            <input type="checkbox" id="gsr"  
                                             <?php                                              
                                              $data = $allocation->first();
                                              if($gsr){echo "checked disabled";}
                                              if($data){ if(strpos($data->tracking, '3') !== false) {echo "checked";} }                                             
                                             ?> >
                                            <i class="dark-white"></i>
                                            GSR
                                          </label>
                                      </div>


                                  </div>                  
                              </div>                                            
                            </div>


                        </div>
                    </div>

                  <!-- <div class="checkbox">
                    <label class="ui-check">
                      <input type="checkbox" name="check" checked required="true"><i></i> I agree to test this patient and device.
                    </label>                   
                  </div> -->

                  <div class="">
                    <label class="ui-check">
                      Step 1 - please select PHD device you are about to use
                    </label>                   
                  </div>

                </div>
               
               
                @if($allocation->first())
                <div class="tab-pane <?php $step = $allocation->first()->step; if( $step == "1" || $step == "2" ||$step == "3" || $step == "4" || $step == "5" || $step == "6") echo " active"; ?>" id="tab2"> 
                @else
                <div class="tab-pane" id="tab2"> 
                @endif

                  <div class="row row-sm">    

                        <div class="col-xl-8">
                          <strong id="step_description">Step 2 - please hook up all sensors to patient and begin sending data.  Click Start when the PHD device shows it is sending data successfully. Click Stop when all sensor tests have passed. Create task</strong>
                        </div>

                        <div class="col-xl-4">
                          <div class="form-group">
                            <button id="btn_start" type="button"  class="btn w-sm mb-1 btn-rounded btn-outline-info" onClick="start()">Start</button>
                            <button id="btn_stop" type="button"  class="btn w-sm mb-1 btn-rounded btn-outline-danger" onClick="stop()" >Stop</button>
                            <button id="btn_reset" type="button" class="btn w-sm mb-1 btn-rounded btn-outline-warning" onClick="resetAllocation()" >Reset</button>
                          </div>
                        </div>
                        
                  </div>
                  
                  <div class="row row-sm">        
                          @if($allocation->first())
                            @if( strpos($allocation->first()->tracking, '1') !== false )

                              <div class="col-xl-12 col-lg-12 col-md-12" id="div_chart_oxygen" style="display:none">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 300px">                            
                                          <canvas data-plugin="chartjs" id="chart_oxygen"></canvas>
                                        </div>                              
                                </div>                            
                              </div>                              
                            @else
                                @if( strlen($allocation->first()->tracking) == 0 )
                                <div class="col-xl-4 col-lg-12 col-md-12" id="div_chart_oxygen">
                                @elseif( strlen($allocation->first()->tracking) == 1 )
                                <div class="col-xl-6 col-lg-12 col-md-12" id="div_chart_oxygen">
                                @elseif(strlen($allocation->first()->tracking) == 2)
                                <div class="col-xl-12 col-lg-12 col-md-12" id="div_chart_oxygen">
                                @endif
                                  <div class="card">			        	                                           
                                          <div class="form-control" style="height: 300px">                            
                                            <canvas data-plugin="chartjs" id="chart_oxygen"></canvas>
                                          </div>                              
                                  </div>                            
                                </div>
                            @endif
                               
                            
                            @if( strpos($allocation->first()->tracking, '2') !== false )
                              <div class="col-xl-12 col-lg-12 col-md-12" id="div_chart_blood" style="display:none">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 300px">                            
                                          <canvas data-plugin="chartjs" id="chart_blood"></canvas>
                                        </div>                              
                                </div>                            
                              </div>                              
                            @else                              
                              @if( strlen($allocation->first()->tracking) == 0 )
                              <div class="col-xl-4 col-lg-12 col-md-12" id="div_chart_blood">
                              @elseif(strlen($allocation->first()->tracking) == 1)
                              <div class="col-xl-6 col-lg-12 col-md-12" id="div_chart_blood">
                              @elseif(strlen($allocation->first()->tracking) == 2)
                              <div class="col-xl-12 col-lg-12 col-md-12" id="div_chart_blood">
                              @endif                              
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 300px">                            
                                          <canvas data-plugin="chartjs" id="chart_blood"></canvas>
                                        </div>                              
                                </div>                            
                              </div>
                            @endif

                            @if( strpos($allocation->first()->tracking, '3') !== false )
                              <div class="col-xl-12 col-lg-12 col-md-12" id="div_chart_gsr" style="display:none">
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 300px">                            
                                          <canvas data-plugin="chartjs" id="chartchart_gsr_oxygen"></canvas>
                                        </div>                              
                                </div>                            
                              </div>                              
                            @else
                              @if( strlen($allocation->first()->tracking) == 0 )
                              <div class="col-xl-4 col-lg-12 col-md-12" id="div_chart_gsr">
                              @elseif(strlen($allocation->first()->tracking) == 1)
                              <div class="col-xl-6 col-lg-12 col-md-12" id="div_chart_gsr">
                              @elseif(strlen($allocation->first()->tracking) == 2)
                              <div class="col-xl-12 col-lg-12 col-md-12" id="div_chart_gsr">
                              @endif
                                <div class="card">			        	                                           
                                        <div class="form-control" style="height: 300px">                            
                                          <canvas data-plugin="chartjs" id="chart_gsr"></canvas>
                                        </div>                              
                                </div>                            
                              </div>
                            @endif
                                                                                

                          @else
                          <div class="col-xl-4 col-lg-12 col-md-12" id="div_chart_oxygen">
                            <div class="card">			        	                                           
                                  <div class="form-control" style="height: 300px">                            
                                    <canvas data-plugin="chartjs" id="chart_oxygen"></canvas>
                                  </div>                              
                            </div>                            
                          </div>

                          <div class="col-xl-4 col-lg-12 col-md-12" id="div_chart_blood">
                            <div class="card">			   
                              <div  class="form-control" style="height: 300px">
                                <canvas data-plugin="chartjs" id="chart_blood"></canvas>
                              </div>
                            </div>                            
                          </div>
                          

                          <div class="col-xl-4 col-lg-12 col-md-12" id="div_chart_gsr">
                            <div class="card">
                              <div class="form-control" style="height: 300px">
                                <canvas data-plugin="chartjs" id="chart_gsr"></canvas>
                              </div>
                            </div>                            
                          </div>  
                          @endif
                          
                                                    
                  </div>          


                  <div class="row row-sm">                        
                          <div class="col-xl-8 col-lg-10 col-md-12">                            
                                  <div class="form-control"  style="align:center">  
                                      
                                        <label>Sensor Status</label>
                                        <div class="row row-sm">
                                            <div class="col-xl-4 col-lg-12 col-md-12">                                              
                                              <div class="alert alert-light" role="alert">
                                                <i id="status_oximeter" class="i-con i-con-ok bg-success w-16 b-2x"></i> 
                                                <span class="mx-1">Pulse Oximeter</span>
                                              </div>
                                              </div>

                                              <div class="col-xl-4 col-lg-12 col-md-12">
                                              <div class="alert alert-light" role="alert">
                                                <i id = "status_blood" class="i-con i-con-ok bg-success w-16 b-2x"></i> 
                                                <span class="mx-1">Blood Pressure</span>
                                              </div>
                                              </div>

                                              <div class="col-xl-4 col-lg-12 col-md-12">
                                              <div class="alert alert-light" role="alert">
                                                <i id="status_gsr" class="i-con i-con-ok bg-success w-16 b-2x"></i> 
                                                <span class="mx-1">GSR</span>
                                              </div>
                                            </div>
                                                                                                                                    
                                        </div> 
                                        
                                                                                            
                                  </div>
                                                                                                      
                          </div>  
                    </div>                                         
                </div>
                

                @if($allocation->first())
                <div class="tab-pane <?php $step = $allocation->first()->step; if( $step == "7") echo " active"; ?>" id="tab8"> 
                @else
                <div class="tab-pane" id="tab8"> 
                @endif                      
                      <div class="row row-sm">     
                          <div class="col-lg-6 col-12">
                              <div class="card">
                                Complete !!!                            
                                <div class="mt-2">  
                                  <button type="button" class="btn btn-primary" onClick="completeStep(0)" style="float:right;">Complete</button>
                                  <div class="text-muted"></div>
                                </div>
                              </div>
                          </div>
                      </div>

                </div>


                <div class="row py-1">
                  <div class="col-xl-6 col-12">                       
                      
                    <!-- <a href="#" class="btn btn-white button-next i-con-h-a"><i class="i-con i-con-left"><i></i></i></a> -->                    
                    <!-- <a href="#" class="btn btn-white button-previous i-con-h-a"><i class="i-con i-con-arrow-left"><i></i></i></a> -->
                  </div>  
                  <div class="col-xl-6 col-12">
                    <div class="d-flex justify-content-end">
                      <a href="#" id="btn_next" class="btn btn-white button-next i-con-h-a"> Next </a>
                      <!-- <a href="#" class="btn btn-white button-last i-con-h-a"><i class="i-con i-con-right"><i></i></i></a> -->                      
                    </div>
                  </div>
                </div>

                
            </div>  


          </div>
        </form>
    </div>
  </div>
</div>

</div>


<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure you want to abort the test?</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        <button id="abortYes" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Yes</button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>
@stop


@section('script')
<script type="text/javascript"> 
    $(document).ready(function() {         
        document.getElementById('step_title').innerHTML = STEPS[0];    
        //document.getElementById('page_title').innerHTML = STEPS[0];           
    });        

    $("#abortYes").click(function(){            
      var allocation_id = $("#allocation_id").val();
      completeStep(2);
    });
</script>
@stop