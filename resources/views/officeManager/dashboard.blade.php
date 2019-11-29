@extends('admin.main')
@section('content')   
    
<div class="page-container" id="page-container" >
	<div class="page-title padding pb-0 ">
		<h2 class="text-md mb-0">Dashboard</h2>
	</div>
	<div class="padding">
	<div class="row row-sm">
		<div class="col-md-12 col-lg-4 col-xl-3">
			<div class="row row-sm">
				<div class="col-lg-12 col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="mb-4">
								<sup class="text-muted">$</sup>
								<span class="h3" data-plugin="countTo" data-option="{
								from: 50,
							    to: 2350,
							    refreshInterval: 10,
							    formatter: function (value, options) {
							      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
							    }
							    }"></span>
									
								<div class="text-muted mt-2 text-sm">Total  Test  Count</div>

								<div>
									<span class="text-success">Medical</span> 
									<span class="text-muted"> Device Sensor </span>
								</div>
							</div>
							
							
							 @if(Session::get('user_type') != '0')
							 <button class="btn btn-sm w-100 btn-rounded btn-danger text-align-auto i-con-h-a mb-2" onClick="location.href='{{ URL::to('admin/steps') }}'">
							 @else
							 <button class="btn btn-sm w-100 btn-rounded btn-danger text-align-auto i-con-h-a mb-2">
							 @endif


							<i class="i-con i-con-arrow-right float-right"><i></i></i>
								Go to New Test
							</button>
						</div>

						<div class="card-body b-t">
							<div class="row no-gutters">
								<div class="col">
									<small class="text-muted">Visit Users</small>
					            	<div class="progress my-2" style="height:3px;">
					                  <div class="progress-bar bg-primary" style="width: 45%"></div>
					              	</div>
								</div>
								<div class="col">
									<small class="text-muted">U-Views</small>
										<div class="progress my-2" style="height:3px;">
											<div class="progress-bar bg-warning" style="width: 35%"></div>
										</div>
								</div>
							</div>


						</div>
					</div>
				</div>
				<div class="col-lg-12 col-sm-6">
					<div class="card">
			        	<div class="card-body">
			        		<div class="d-flex i-con-h-a">
			        			<span class="text-md">
                      Real time Graphic analytic
				        		</span>							    
			        			<span class="mx-2 mt-1">
			        				<i class="i-con i-con-trending-up text-success"><i></i></i>			        				
			        			</span>
			        		</div>
			        		
			        	</div>
			        	<div style="height: 138px">
				          	<canvas data-plugin="chartjs" id="chart-line-4"></canvas>
				        </div>
			        </div>
		        </div>
	        </div>
		</div>
		
		<div class="col-md-12 col-lg-8 col-xl-9">
			<div class="block px-4 py-3">
	          <div class="row">

              <div class="col-lg-3 col-6">
	              <div class="d-flex align-items-center i-con-h-a my-1">
	                <div>
	                  <span class="avatar w-40 b-a b-2x">
	                    <i class="i-con i-con-users b-2x text-warning"><i></i></i>
	                  </span>
	                </div>
	                <div class="mx-3">
	                  <a href="" class="d-block ajax"><strong>550</strong></a>
	                  <small class="text-muted">Total Users</small>
	                </div>
	              </div>
                </div>
                
	            <div class="col-lg-3 col-6">
	              <div class="d-flex align-items-center i-con-h-a my-1">
	                <div>
	                  <span class="avatar w-40 b-a b-2x">
                      <i class="i-con i-con-history b-2x text-success"><i></i></i>
	                  </span>
	                </div>
	                <div class="mx-3">
	                  <a href="" class="d-block ajax"><strong>60</strong></a>
	                  <small class="text-muted">Devices</small>
	                </div>
	              </div>
                </div>
                
	            <div class="col-lg-3 col-6">
	              <div class="d-flex align-items-center i-con-h-a my-1">
	                <div>
	                  <span class="avatar w-40 b-a b-2x">
                      <i class="i-con i-con-users b-2x text-warning"><i></i></i>
	                  </span>
	                </div>
	                <div class="mx-3">
	                  <a href="" class="d-block ajax"><strong>13</strong></a>
	                  <small class="text-muted">Doctors</small>
	                </div>
	              </div>
	            </div>
	            
	            <div class="col-lg-3 col-6">
	              <div class="d-flex align-items-center i-con-h-a my-1">
	                <div>
	                  <span class="avatar w-40 b-a b-2x">
                      <i class="i-con i-con-users b-2x text-warning"><i></i></i>
	                  </span>
	                </div>
	                <div class="mx-3">
	                  <a href="" class="d-block ajax"><strong>302</strong></a>
	                  <small class="text-muted">Patient</small>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="row row-sm">
	        	<div class="col-md-12">
			        <div class="card p-4">
			        	<div class="pb-4">
			        		<div class="d-flex mb-3">
			        			<span class="text-md">What is PHD?</span>
			        			<span class="flex"></span>
			        			
			        		</div>
			        		<div class="d-flex">
                                <small class="text-muted">PHD stands for Proactive Health Detection. Its purpose is to help medical professionals help patients that are at risk of becoming Type 2 Diabetic. The data gathered by our sensors gives the medical professional the information they need to treat their patients properly.</small>				        		
			        		</div>
				        </div>
                        
                        <div class="pb-3">
			        		<div>
			        			<span class="text-md">Qualified Doctors</span>			        						        			
			        		</div>			        		
                            <small class="text-muted">25 years of experience</small>			        		
                        </div>
                        <div class="pb-3">
			        		<div>
			        			<span class="text-md">Modern Equipment</span>			        						        			
			        		</div>			        		
                            <small class="text-muted">Branded and time tested</small>			        		
                        </div>
                        <div class="pb-3">
			        		<div>
			        			<span class="text-md">Proper Testing</span>			        						        			
			        		</div>			        		
                            <small class="text-muted">Get the right information</small>			        		
                        </div>
                        <div class="pb-3">
			        		<div>
			        			<span class="text-md">Individual Approach</span>			        						        			
			        		</div>			        		
                    <small class="text-muted">Each patient's data is unique</small>			        		
                  </div>

                        
			        </div>
		        </div>
	        	<!-- <div class="col-md-4">
	        		<div class="card bg-success--lt p-4">
	        			<div>
	        				<span class="text-fade">Online sells</span>
	        				<div class="_300">$5,000</div>
	        			</div>
	        			<div style="height: 60px">
	        				<canvas data-plugin="chartjs" id="chart-line-6"></canvas>
				        </div>
	        		</div>
	        		<div class="card">
			          <div class="p-4">
			          	<p><strong>Trending</strong></p>
			            <div class="easypiechart" data-plugin="easyPieChart" data-option="{barColor: theme.color.primary}" data-percent="75" data-line-width="3" data-size="110" data-scale-length="0" data-line-cap="square">
			              <div>
			                <span class="text-primary text-md">75%</span>
			                <small class="text-muted">Trending up</small>
			              </div>
			            </div>
			          </div>
			          <div class="card-footer text-center">
			            <div class="row">
			              <div class="col">
			                <div>$6,000</div>
			                <small class="text-muted">Target</small>
			              </div>
			              <div class="col">
			                <div>$2,500</div>
			                <small class="text-muted">Last Month</small>
			              </div>
			            </div>
			          </div>
			        </div>
	        	</div> -->
	        </div>
	    </div>
	    <!-- <div class="col-12">
	    	<div class="card">
		      <div class="p-4 b-b d-flex">
		      	<strong>World sells</strong>
		      	<span class="flex"></span>
		      	<div><span class="badge badge-pill bg-success mx-2">48</span></div>
		      	<span class="text-muted">countries</span>
		      </div>
		      <div class="row no-gutters">
		        <div class="col-sm-6">
		          <div class="p-4">
		            <div id="jqvmap-world" data-plugin="vectorMap" style="height: 240px">
		            </div>
		          </div>
		        </div>
		        <div class="col-sm-3 p-4">
		          <div class="">
		            <div class="d-flex my-4">
		              <div class="peity" data-plugin="peity" data-tooltip="true" data-title="Profile" data-option="
		                'donut',
		                {
		                  height: 40,
		                  width: 40,
		                  padding: 0.2,
		                  fill: [theme.color.primary, 'rgba(120, 130, 140, 0.1)']
		                }">20,80
		              </div>
		              <div class="mx-3">
		                <small class="text-muted d-block mb-1">
		                  North America
		                </small>
		                <small class="text-primary">35%</small>
		              </div>
		            </div>
		            <div class="d-flex my-4">
		              <div class="peity" data-plugin="peity" data-tooltip="true" data-title="Profile" data-option="
		                'donut',
		                {
		                  height: 40,
		                  width: 40,
		                  padding: 0.2,
		                  fill: [theme.color.success, 'rgba(120, 130, 140, 0.1)']
		                }">10,90
		              </div>
		              <div class="mx-3">
		                <small class="text-muted d-block mb-1">
		                  Europe
		                </small>
		                <small class="text-success">10%</small>
		              </div>
		            </div>
		            <div class="d-flex my-4">
		              <div class="peity" data-plugin="peity" data-tooltip="true" data-title="Profile" data-option="
		                'donut',
		                {
		                  height: 40,
		                  width: 40,
		                  padding: 0.2,
		                  fill: [theme.color.warning, 'rgba(120, 130, 140, 0.1)']
		                }">30,70
		              </div>
		              <div class="mx-3">
		                <small class="text-muted d-block mb-1">
		                  Asia
		                </small>
		                <small class="text-waring">30%</small>
		              </div>
		            </div>
		          </div>
		        </div>
		        <div class="col-sm-3 b-l p-0">
		          <div class="p-4 text-center b-b">
		            <h3 class="m-0">Europe</h3>
		          </div>
		          <div class="p-4 row text-center">
		            <div class="col b-r">
		              530
		              <div class="text-muted text-sm">Cities</div>
		            </div>
		            <div class="col">
		              54,040
		              <div class="text-muted text-sm">Population</div>
		            </div>
		          </div>
		          <div class="p-4 text-center text-center">
		            <span class="text-md text-primary">45%</span>
		            <div class="text-muted text-sm">Profit</div>
		          </div>
		        </div>
		      </div>
		  </div>
	    </div> -->
	
	
	</div>
</div>

</div>

@stop
