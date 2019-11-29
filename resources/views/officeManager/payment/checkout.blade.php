@extends('admin.main')
@section('content')     
    <div class="page-container-1" id="page-container">
        <div class="page-title padding pb-0 ">
            <h2 class="text-md mb-0" style="padding-bottom: 35px;">Card
                        
            </h2>
        </div>


        <input type="hidden" id="username" value="{{$username}}" />
	    <input type="hidden" id="phone" value="{{$phone}}" />
        <input type="hidden" id="token" value="{{$token}}" />


        <div class="padding pt-0 ">

            <div class="padding pt-0">
                <h2 class="text-md payment_text">Shipping</h2>
            
                <table id="shipping_table"  class="table table-theme v-middle" style="width:100%;">
                    <tr>
                        
                    <tr>
                </table>
                

                <div class="pt-1">
                
                <h2 class="text-md payment_text">Payment</h2>
                </div>                
                <table id="payment_table"  class="table table-theme v-middle" style="width:100%;">
                    <tr>
                       
                    <tr>
                </table>

            </div>


            <div class="table-responsive">
                
                <!-- <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable" style="margin-top: -15px;"> -->

                <!-- data-plugin="bootstrapTable" -->
                <table  class="table table-theme v-middle"
                    id="table"
                    data-toolbar="#toolbar"
                    data-search="false"
                    data-search-align="left"
                    data-show-columns="false"
                    data-show-export="false"
                    data-detail-view="false"
                    data-mobile-responsive="true"
                    data-pagination="false"
                    data-page-list="[10, 25, 50, 100, ALL]">                                                           
                    <tbody>                                                                   
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="padding pt-0" class="inline" style="float:right;">
                    
        <button  onclick="confirm();" id="btnCheckout" type="submit" class="btn btn-rised btn-wave indigo" >Confirm Order</button>
            
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
    var shipping_cost = 0;

    $(document).ready( function() {        
        token = document.getElementById("token").value;
        document.getElementById("btnCheckout").disabled = true;

        add_to_cart("", "");

        
    });
		
    var keys = [];
    var quantities = [];

    function get_shipping(){
        var params = {};
        params["rt"] = 'a/checkout/shipping';        
        params["mode"] = "list";
        params["api_key"] = api_key;
        params["token"] = token;

        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, 
			dataType: "json",
			success: function (data) {
                //$("#shipping_table").bootstrapTable("destroy");

                if(data.status == '3'){
                    alert("No Products");
                }else{
                    tbody = $("#shipping_table tbody");                 
                    var s = "";
                    //for (i = 0; i < data.shipping_methods; i++) {
                        s += "<tr>";
                            s += ("<td> <span>" + document.getElementById("username").value + "</span> </td>");
                            s += ("<td> <span>" + data.address + "</span> </td>");
                            s += ("<td> <span>" + data.shipping_methods.default_flat_rate_shipping.quote.default_flat_rate_shipping.title + "</span> </td>");                        
                        s += "</tr>";
                    //}
                    $( tbody ).html(s);
                    // $('#shipping_table').bootstrapTable({            
                    // });
                    
                    
                    shipping_cost = data.shipping_methods.default_flat_rate_shipping.quote.default_flat_rate_shipping.cost;

                    tb = $("#table tbody"); 
                    showTable(tb, table_data);
                    

                    select_shipping();
                }

               
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

    function select_shipping(){
        
        var params = {};
        params["rt"] = 'a/checkout/shipping';        
        params["mode"] = "select";
        params["shipping_method"] = "default_flat_rate_shipping.default_flat_rate_shipping";
        params["api_key"] = api_key;
        params["token"] = token;

        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, 
			dataType: "json",
			success: function (data) {
                get_payment();          
			},
			error: function(obj, status, msg)
			{				
				alert(obj.responseText);
			}
        });
    }


    function get_payment(){
        var params = {};
        params["rt"] = 'a/checkout/payment';        
        params["mode"] = "list";
        params["api_key"] = api_key;
        params["token"] = token;

        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, 
			dataType: "json",
			success: function (data) {
                tbody = $("#payment_table tbody");                 
                var s = "";
                //for (i = 0; i < data.shipping_methods; i++) {
                    s += "<tr>";
                        s += ("<td> <span>" + document.getElementById("username").value + "</span> </td>");
                        s += ("<td> <span>" + data.address + "</span> </td>");
                        s += ("<td> <span>" + data.payment_methods.default_cod.title + "</span> </td>");                        
                    s += "</tr>";
                //}
                $( tbody ).html(s);
                // $('#shipping_table').bootstrapTable({            
                // });
                
                select_payment();
                                
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

    function select_payment(){        
        var params = {};
        params["rt"] = 'a/checkout/payment';        
        params["mode"] = "select";
        params["payment_method"] = "default_cod";
        params["api_key"] = api_key;
        params["token"] = token;
        params["agree"] = "1";

        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, 
			dataType: "json",
			success: function (data) {
                if(data.status == 1){                    
                    document.getElementById("btnCheckout").disabled = false;
                }                
			},
			error: function(obj, status, msg)
			{				
				alert(obj.responseText);
			}
        });

    }


        
	
    var table_data;
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
                                        
                table_data = data;
                //$("#table").bootstrapTable("destroy");
                

                get_shipping();

				
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
    

    function showTable(tbody, input){
        var s = "";
        var total_price = 0;

        var results = input.products;
        for (i = 0; i < results.length; i++) {
            
               s += "<tr>";
                //s += "<td> <input type='hidden' name='txtKey' value='" + results[i].key + "' /> </td>";
                  //s += "<td><input type='checkbox' class='checkboxes' value='' id ='td" + i +"'/></td>";
                s += ("<td> <span> <img src='" + results[i].thumb + "' /> </span>  </td>");
                s += ("<td> <span>" + results[i].name + "</span> </td>");
                s += ("<td> <span>" + results[i].model + "</span> </td>");
                s += ("<td> <span>" + results[i].price + "</span> </td>");
                s += ("<td> <span> " + results[i].quantity + " </span> </td>");
                s += ("<td> <span>" + results[i].total + "</span> </td>");                    	
                //s += '<td> <button onclick="removeItem('+results[i].key+');" class="btn btn-raised btn-wave btn-icon btn-rounded mb-2 i-con-h-a green"> <i class="i-con i-con-trash b-2x"> <i> </i></i></button> </td>';
               s += "</tr>";
              
              //  tobody.fnAddData( [results[i].RsvNo, results[i].RsvDate, results[i].Flag, results[i].BankId, results[i].BankName, results[i].UserName,results[i].UserName, results[i].RsvDesc, results[i].OrderId]);
              
        }

        total_price = input.totals[0].value;
        s += "<tr>";
        s += ("<td> <span> </span>  </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> Sub-Total: </span> </td>");
        s += ("<td> <span> $" + total_price + "</span> </td>");    
        s += "</tr>";
        s += "<tr>";
        s += ("<td> <span> </span>  </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> Flat Shipping Rate: </span> </td>");
        s += ("<td> <span>$" + shipping_cost +  "</span> </td>"); 
        s += "</tr>";   

        s += "<tr>";
        s += ("<td> <span> </span>  </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span> </span> </td>");
        s += ("<td> <span style=' color:#00A1CB;font-size:18px;'> Total: </span> </td>");
        s += ("<td> <span style=' color:#00A1CB;font-size:18px;'>$" + (parseInt(total_price) +  parseInt(shipping_cost)) +  "</span> </td>"); 
        s += "</tr>"; 


        $( tbody ).html(s);
        // $('#table').bootstrapTable({            
        // });
		// $('#datatable').dataTable({            
      	// });		                 
	}
        
    
    function confirm(){        
        var params = {};
        params["rt"] = 'a/checkout/confirm';                
        params["api_key"] = api_key;
        params["token"] = token;
        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, 
			dataType: "json",
			success: function (data) {                
                if(data.email != ""){                    
                    process();
                }                
			},
			error: function(obj, status, msg)
			{				
				alert(obj.responseText);
			}
        });

    }

    function process(){        
        var params = {};
        params["rt"] = 'a/checkout/process';                
        params["api_key"] = api_key;
        params["token"] = token;
        $.ajax({
			type: 'POST',
			url: abantecart_ssl_url,
			data: params, 
			dataType: "json",
			success: function (data) {                
                if(data.status == 1){                    
                    //alert("Success");
                    window.location.href = "{{URL::to('office/suppliers2')}}"
                }                
			},
			error: function(obj, status, msg)
			{				
				alert(obj.responseText);
			}
        });

    }

        	    
</script>

@stop
