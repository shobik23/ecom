<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');

$pid=get_safe_value($con,$_POST['pid']);
$qty=get_safe_value($con,$_POST['qty']);
$type=get_safe_value($con,$_POST['type']);

$productSoldQtyByProductId=productSoldQtyByProductId($con,$pid);
$productQty=productQty($con,$pid);

$pending_qty=($productQty-$productSoldQtyByProductId);

if($qty<=0){
	echo "not_avaliable";
	die();
}

$obj=new add_to_cart();

if($type=='add'){
	$obj->addProduct($pid,$qty);
}

if($type=='remove'){
	$obj->removeProduct($pid);
}

if($type=='update'){
	$obj->updateProduct($pid,$qty);
}

echo $obj->totalProduct();{
	if($type=='add'){
echo"<script>
          alert('Item  Added To Cart');
          window.location.href='cart.php';
        </script>";
      }
			else if($type=='remove'){
				echo"<script>
          alert('Item  Removed From Cart');
          window.location.href='cart.php';
        </script>";
			}
			else if($type=='update'){
				echo"<script>
          alert('Item  Updated To Cart');
          window.location.href='cart.php';
        </script>";
			}
		}
?>