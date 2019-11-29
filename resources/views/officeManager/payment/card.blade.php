@extends('admin.main')
@section('content')     
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0" style="padding-bottom: 35px;">Card
                        
            </h2>
        </div>


        <input type="hidden" id="username" value="{{$username}}" />
	    <input type="hidden" id="password" value="{{$password}}" />				


        <div class="padding pt-0 ">
            <div class="table-responsive">
                
                <!-- <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable" style="margin-top: -15px;"> -->

                <table  class="table table-theme v-middle" data-plugin="bootstrapTable"
                    id="table"
                    data-toolbar="#toolbar"
                    data-search="true"
                    data-search-align="left"
                    data-show-columns="true"
                    data-show-export="false"
                    data-detail-view="false"
                    data-mobile-responsive="true"
                    data-pagination="true"
                    data-page-list="[10, 25, 50, 100, ALL]"
                    >
                    
                    <thead>
                        <tr>
                            <th style="display:none;"><span class="text-muted"></span></th>
                            <th><span class="text-muted">Image</span></th>
                            <th><span class="text-muted">Name</span></th>
                            <th><span class="text-muted">Model</span></th>
                            <th><span class="text-muted">Unit Price</span></th>
                            <th><span class="text-muted">Quantity</span></th>
                            <th><span class="text-muted">Total</span></th>
                            <th><span class="text-muted">Delete</span></th>
                            <!-- <th><span class="text-muted">Action</span></th> -->
                        </tr>
                    </thead>
                    
                    <tbody>
                                                                   
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="padding pt-0" class="inline" style="float:right;">
                        
            <form method="post" action="{{ url('office/checkout') }}"  enctype="multipart/form-data">
            @csrf
            <button onclick="update();" id="btnUpdate" type="button" class="btn btn-primary">Update</button>        
            <input type="hidden" id="token" name="token" value="" />
            <button id="btnCheckout" type="submit" class="btn btn-rised btn-wave indigo" >Checkout</button>
            </form>

            

        </div>

    </div>


<!-- modal -->
<div id="m" class="modal" data-backdrop="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Are you sure to execute this action?</h5>
        </div>
        <!-- <div class="modal-body text-center p-lg">
        <p></p>
        </div> -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        <button id="delBtn" type="button" class="btn btn-primary delBtn" data-dismiss="modal">Yes</button>
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
        login();
    });

	function onMyFrameLoad() {
		alert('myframe is loaded');
	};

	function addCard(product_id){
		//alert(product_id);
		add_to_cart(product_id, 1);
    }
        
    var keys = [];
    var quantities = [];

    function clear_card(){
        var params = {};
        params["rt"] = 'a/checkout/cart';        
        params["remove_all"] = true;
        params["api_key"] = api_key;
        params["token"] = token;

        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, 
			dataType: "json",
			success: function (data) {
                keys = [];
                quantities = [];                
                $('input[name="txtKey"]').each(function(key,val){            
                    //alert(val.value)
                    keys.push(val.value);
                })

                $('input[name="txtQuantity"]').each(function(key,val){
                    //alert(val.value)
                    quantities.push(val.value);            
                })
                
				updateCard();
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
    function update(){

        document.getElementById("btnCheckout").disabled = true;
        document.getElementById("btnUpdate").disabled = true;
        clear_card();
                
    }

    function updateCard(){     
        var params = {};
        for(i = 0 ; i < keys.length; i++){
            //alert(keys[i])
             //products[0][product_id]=120, products[0][quantity]=1
            var pName = "products[" + i + "][product_id]";
            var Qty = "products[" + i + "][quantity]";
            params[pName] = keys[i];
            params[Qty] = quantities[i];
        }
        params["rt"] = 'a/checkout/cart';        
        params["api_key"] = api_key;
        params["token"] = token;
       
        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, //{"rt": 'a/checkout/cart', "product_id" : product_id, pa : count, "api_key" : api_key , "token" : token }
			dataType: "json",
			success: function (data) {
				//alert(JSON.stringify(data));								
				$("#table").bootstrapTable("destroy");
                tbody = $("#table tbody"); 
                showTable(tbody, data.products);
                document.getElementById("btnCheckout").disabled = false;
                document.getElementById("btnUpdate").disabled = false;
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
                document.getElementById("token").value = token;
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
				
				var products = data.products;
				var quantity = 0;
				for(i = 0 ;  i < products.length ; i++){
					quantity = quantity + products[i].quantity;					
				}					
				                                
                // $("#datatable").dataTable().fnDestroy();
                // tbody = $("#datatable tbody"); 
                // showTable(tbody, data.products);
                                        
                $("#table").bootstrapTable("destroy");
                tbody = $("#table tbody"); 
                showTable(tbody, data.products);

				
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
    
    function removeItem(product_id){
        //add_to_cart(product_id, );
        update_cart(product_id, "0");
    }


    function update_cart(product_id, count) {

        var pa = 'quantity[' + product_id + ']';
        var params = {};
        params["rt"] = 'a/checkout/cart';
        params["product_id"] = product_id;
        params[pa] = count;
        params["api_key"] = api_key;
        params["token"] = token;
        
		$.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, //{"rt": 'a/checkout/cart', "product_id" : product_id, pa : count, "api_key" : api_key , "token" : token }
			dataType: "json",
			success: function (data) {
				//alert(JSON.stringify(data));								
				$("#table").bootstrapTable("destroy");
                tbody = $("#table tbody"); 
                showTable(tbody, data.products);
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
    

    function showTable(tbody, results){
        var s = "";
        for (i = 0; i < results.length; i++) {
            
               s += "<tr>";
                s += "<td> <input type='hidden' name='txtKey' value='" + results[i].key + "' /> </td>";
                  //s += "<td><input type='checkbox' class='checkboxes' value='' id ='td" + i +"'/></td>";
                s += ("<td> <span> <img src='" + results[i].thumb + "' /> </span>  </td>");
                s += ("<td> <span>" + results[i].name + "</span> </td>");
                s += ("<td> <span>" + results[i].model + "</span> </td>");
                s += ("<td> <span>" + results[i].price + "</span> </td>");
                s += ("<td> <span> <input name='txtQuantity' value='" + results[i].quantity + "' /> </span> </td>");
                s += ("<td> <span>" + results[i].total + "</span> </td>");                    	
                s += '<td> <button onclick="removeItem('+results[i].key+');" class="btn btn-raised btn-wave btn-icon btn-rounded mb-2 i-con-h-a green"> <i class="i-con i-con-trash b-2x"> <i> </i></i></button> </td>';
               s += "</tr>";
              //  tobody.fnAddData( [results[i].RsvNo, results[i].RsvDate, results[i].Flag, results[i].BankId, results[i].BankName, results[i].UserName,results[i].UserName, results[i].RsvDesc, results[i].OrderId]);
              
          }
        $( tbody ).html(s);
        $('#table').bootstrapTable({            
        });
		// $('#datatable').dataTable({            
      	// });
			
    
        
     

	}
        
        	    
</script>

@stop
