<?php 
require('top.php');
if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
	?>
	<script>
		window.location.href='index.php';
	</script>
	<?php
}

$cart_total=0;


    if(isset($_POST['submit'])){
    echo "sadasdsad";
	$address=get_safe_value($con,$_POST['address']);
	$city=get_safe_value($con,$_POST['city']);
	$payment_type="Pay with khalti";
	$user_id=$_SESSION['USER_ID'];
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'','',$key);
		$price=$productArr[0]['price'];
		$qty=$val['qty'];
		$cart_total=$cart_total+($price*$qty);
		
	}
	$total_price=$cart_total;
	$payment_status='success';
	// if($payment_type=='COD'){
	// 	$payment_status='success';
	// }
	$order_status='1';
	$added_on=date('Y-m-d h:i:s');
    echo "$user_id','$address','$city','$payment_type','$payment_status','$order_status','$added_on','$total_price','$txnid'";
		
	mysqli_query($con,"insert into `order`(user_id,address,city,payment_type,payment_status,order_status,added_on,total_price,txnid) values('$user_id','$address','$city','$payment_type','$payment_status','$order_status','$added_on','$total_price','$txnid')");
	
	$order_id=mysqli_insert_id($con);
	
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'','',$key);
		$price=$productArr[0]['price'];
		$qty=$val['qty'];
		
		mysqli_query($con,"insert into `order_detail`(order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");
	}
	
	unset($_SESSION['cart']);

    if($payment_type=='payu'){

		$posted = array();
		if(!empty($_POST)) {
		  foreach($_POST as $key => $value) {    
			$posted[$key] = $value; 
		  }
		}
		
		$userArr=mysqli_fetch_assoc(mysqli_query($con,"select * from users where id='$user_id'"));
		
		$formError = 0;
		$posted['tAmt']=$tAmt;
		$posted['amount']=$total_price;?>
		
		<form action="https://uat.esewa.com.np/epay/main" method="POST">
			<input value="100" name="tAmt" type="hidden">
			<input value="90" name="amt" type="hidden">
			<input value="5" name="txAmt" type="hidden">
			<input value="2" name="psc" type="hidden">
			<input value="3" name="pdc" type="hidden">
			<input value="EPAYTEST" name="scd" type="hidden">
			<input value="ee2c3ca1-696b-4cc5-a6be-2c40d929d453" name="pid" type="hidden">
			<input value="'http://127.0.0.1/php/ecom/esewa_payment_success" type="hidden" name="su">
			<input value="http://127.0.0.1/php/ecom/esewa_payment_failed" type="hidden" name="fu">
			<input value="Submit" type="submit">
			</form>

	<?php
	}else{	

		?>
		<script>
			window.location.href='thank_you.php';
		</script>
		<?php
	}	
	
	
}
?>

<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(https://s37564.pcdn.co/wp-content/uploads/2020/06/AdobeStock_336064161-scaled-e1591273002356.jpeg.optimal.jpeg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    
									<?php 
									$accordion_class='accordion__title';
									if(!isset($_SESSION['USER_LOGIN'])){
									$accordion_class='accordion__hide';
									?>
									<div class="accordion__title">
                                        Checkout Method
                                    </div>
                                    <div class="accordion__body">
                                        <div class="accordion__body__form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                        <form id="login-form" method="post">
                                                            <h5 class="checkout-method__title">Login</h5>
                                                            <div class="single-input">
                                                              <input type="email" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
																															<span class="field_error" id="login_email_error"></span>
                                                            </div>
															
                                                            <div class="single-input">
                                                              <input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
																															<span class="field_error" id="login_password_error"></span>
                                                            </div>
															
                                                            <p class="require">* Required fields</p>
                                                            <div class="dark-btn">
                                                              <button type="button" class="fv-btn" onclick="user_login()">Login</button>
                                                            </div>
																													<div class="form-output login_msg">
																														<p class="form-messege field_error"></p>
																													</div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-method__login">
                                                        <form action="#">
                                                            <h5 class="checkout-method__title">Registeration</h5>
                                                            <div class="single-input">
                                                              <input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
																															<span class="field_error" id="name_error"></span>
                                                            </div>
																														<div class="single-input">
                                                          	  <input type="email" name="email" id="email" placeholder="Your Email*" style="width:100%">
																															<span class="field_error" id="email_error"></span>
                                                            </div>
																														<div class="single-input">
																															<input type="text" name="address" id="address" placeholder="Address*" style="width:100%">
																															<span class="field_error" id="address_error"></span>
																														</div>
                                                            <div class="single-input">
                                                            	<input type="text" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%">
																															<span class="field_error" id="mobile_error"></span>
                                                            </div>
																														<div class="single-input">
                                                              <input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
																															<span class="field_error" id="password_error"></span>
                                                            </div>
																														<div class="single-input">
                                                              <input type="password" name="password2" id="password2" placeholder="Confirm Password*" style="width:100%">
																															<span class="field_error" id="password_error1"></span>
                                                            </div>
                                                            <div class="dark-btn">
                                                                <button type="button" class="fv-btn" onclick="user_register()">Register</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
																		<?php } ?>
                                    <div class="<?php echo $accordion_class?>">
                                        Address Information
                                    </div>
									<form method="post" id="paymentForm">
										<div class="accordion__body">
											<div class="bilinfo">
												
													<div class="row">
														<div class="col-md-12">
															<div class="single-input">
																<input type="text" name="address" placeholder="Street Address" required>
															</div>
														</div>
														<div class="col-md-6">
															<div class="single-input">
																<input type="text" name="city" placeholder="City/State" required>
															</div>
														</div>
														
													</div>
												
											</div>
										</div>
										<div class="<?php echo $accordion_class?>">
											payment information
										</div>
										<div class="accordion__body">
											<div class="paymentinfo">
												<!-- <div class="single-method">
													Cash On Delivery <input type="radio" name="payment_type" value="COD" required/>
												</div> -->
												<div class="single-method">
                                                <input type="submit" name="name" style="visibility:hidden;" id="success"/>
												</div>
											</div>
										</div>
                                        
                                        <input type="button" id="payment-button" value="Pay with Khalti"/>
                                        <input type="submit" name="submit" id="submitBtn" style="visibility:hidden;"/>
                                         
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                <?php
								$cart_total=0;
								foreach($_SESSION['cart'] as $key=>$val){
								$productArr=get_product($con,'','',$key);
								$pname=$productArr[0]['name'];
								$price=$productArr[0]['price'];
								$image=$productArr[0]['image'];
								$qty=$val['qty'];
								$cart_total=$cart_total+($price*$qty);
								?>
								<div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image?>"  />
                                    </div>
                                    <div class="single-item__content">
                                        <a href="#"><?php echo $pname?></a>
                                        <span class="price"><?php echo $price*$qty?></span>
                                    </div>
                                    <div class="single-item__remove">
                                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key?>','remove')"><i class="icon-trash icons"></i></a>
                                    </div>
                                </div>
								<?php } ?>
                            </div>
                            <div class="ordre-details__total">
                                <h5>Order total</h5>
                                <span class="price"><?php echo $cart_total?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_c47a65ea9f074cc49f9a6f96cbb79d6b",
            "productIdentity": "123",
            "productName": "Laptop",
            "productUrl": "http://localhost:3000",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
                ],
            "eventHandler": {
                onSuccess (payload) {
                    // hit merchant api for initiating verfication
                    var button = document.getElementById('success');
                    var submitBtn = document.getElementById('submitBtn');
                    
                    // document.getElementById("paymentForm").submit();
                    
                    submitBtn.click();
					alert('The you for payment');

					// window.location.href=('thank_you.php');
                    console.log(payload);
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            checkout.show({amount: 10000});
        }
    </script>  
        						
<?php require('footer.php')?>       