@extends('admin.main')
@section('content')   
    
<div class="page-container" id="page-container" >
	<div class="page-title padding pb-0 ">

		<div class="row">
			<div class="col-xl-6">
				<h2 class="text-md mb-0">PHD Suppliers</h2>
			</div>
			<div class="col-xl-6" >			
				<ul id="ic_cart" class="nav navbar-menu order-1 order-lg-2" style="float:right;">
					<li class="nav-item dropdown">
							<a class="nav-link px-2 i-con-h-a mr-lg-2" href='{{ URL::to("office/card") }}'>
								<i class="i-con i-con-shop"><i></i></i>
								<span id="products" class="badge badge-pill badge-up bg-primary"></span>
							</a>
					</li>
				</ul>			
			</div>
		</div>
						
	</div>

	<div class="padding">

	<input type="hidden" id="username" value="{{$username}}" />
	<input type="hidden" id="password" value="{{$password}}" />				

	<div class = "row row-sm">	
		@foreach ($products as $product)
						
			<div class="col-lg-12 col-sm-6 col-xl-4">
				<div class="card">
					<div class="card-body">

						<div class="">		
							<img src="{{json_decode($product->content, true)['cell']['thumb']}}" style="width:80%;"/>
							<div class="mt-1" style="width:90%;margin:auto;">
								<span class="text-md text-success">{{json_decode($product->content, true)['cell']['name']}}</span>	
							</div>

							<!-- <div class="mt-1">
								<span class="text-muted">Includes:</span>	
							</div>
							
							<div class="">
							<span class="text-muted">1 - PHD ANS IOT Device</span>	
							</div>
							<div class="">
							<span class="text-muted">1 - Bluetooth Pulse Oximeter</span>
							</div>
							<div class="">
							<span class="text-muted">1 - Bluetooth Blood Pressure Sensor</span>
							</div>
							<div class="">
							<span class="text-muted">1 - GSR Sensor Cable </span>
							</div>
							<div class="">
							<span class="text-muted">100 - GSR Sensor Foot Pads Sets(2)</span>
							</div> -->
							<div class="mt-1" style="width:26%;margin:auto;">
							<span class="text-md text-success">${{json_decode($product->content, true)['cell']['price']}}</span>	
							</div>		
							<div class="mt-2" style="width:50%;margin:auto;">
								<button class="btn w-100 btn-rounded btn-danger" onclick="addCard( {{ json_decode($product->content, true)['id'] }} );">										
									Add to Card
								</button>
							</div>

						</div>	

					</div>
				</div>
				
			</div>
			
		@endforeach


				
	</div>




</div>


<div id="m" class="modal" data-backdrop="true" aria-hidden="true" style="display: none;">		
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title">Notification</h5>
				</div>
				<div class="modal-body text-center p-lg">
				<p>Item Successfully Added</p>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
				<button type="button" id="go_cart"  class="btn btn-primary" data-dismiss="modal">Go to Cart</button>
				</div>
			</div><!-- /.modal-content -->
		</div>
</div>


@stop



@section('script')
<script type="text/javascript">   

	
	var api_key= "1mzP2T12A4dB7H0e";
	var token = "";
	var abantecart_ssl_url = "https://prohealthdetect.com/phd-store/index.php";

    $(document).ready( function() {			
			document.getElementById("ic_cart").style.display = "none";			
			login();

			$("#go_cart").click(function(){
				window.location.href = '{{URL::to("office/card")}}';
			});
    });

	function onMyFrameLoad() {
		alert('myframe is loaded');
	};

	function addCard (id){		
		add_to_cart(id, "1");
	}
			
	function login () {			
		$.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: {'rt': 'a/account/login', 'loginname' : $('#username').val(), 'password' : $('#password').val(), 'api_key' : api_key },
			dataType: "json",
			success: function (data) {
				//alert(JSON.stringify(data));
				console.log(data);
				console.log('Token: '+ data.token);
				token = data.token;
				add_to_cart("", "");
			},
			error: function(obj, status, msg)
			{
				console.log(obj);
				console.log(status);
				console.log(msg);
				alert(obj.responseText);
			}
		});
	}

	function add_to_cart(product_id, quantity) {		
		$.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: {'rt': 'a/checkout/cart', 'product_id' : product_id , 'quantity' : quantity , 'api_key' : api_key , 'token' : token },
			dataType: "json",
			success: function (data) {
				//alert(JSON.stringify(data));
				console.log(data);				
				if(product_id == "")
				{
					document.getElementById("ic_cart").style.display = "block";		
				}else{
					//document.getElementById("ic_cart").style.display = "none";
					$("#m").modal();
				}

				var products = data.products;
				var quantity = 0;
				for(i = 0 ;  i < products.length ; i++){
					quantity = quantity + products[i].quantity;					
				}					
				document.getElementById("products").textContent=quantity;		
				// show the notification dialog				
			},
			error: function(obj, status, msg)
			{
				console.log(obj);
				console.log(status);
				console.log(msg);
				alert(obj.responseText);
			}
		});
	}

	function update_cart () {
		var pa = 'quantity[' + $('#product_id').val() + ']';
		$.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: {'rt': 'a/checkout/cart', 'product_id' : $('#product_id').val(), pa : $('#quantity').val(), 'api_key' : api_key , 'token' : token },
			dataType: "json",
			success: function (data) {
				//alert(JSON.stringify(data));
				console.log(data);
				console.log('Token: '+ data.token);
				token = data.token;
			},
			error: function(obj, status, msg)
			{
				console.log(obj);
				console.log(status);
				console.log(msg);
				alert(obj.responseText);
			}
		});
	}

</script>
@stop

