<?php
/*
Website: http://machine-learning.co.nz
*/

session_start();
include('db.php');
$status="";
if (isset($_POST['code']) && $_POST['code']!=""){
$code = $_POST['code'];
$result = mysqli_query($con,"SELECT * FROM `products` WHERE `code`='$code'");
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$code = $row['code'];
$price = $row['price'];
$image = $row['image'];
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
$cartArray = array(
        $code=>array(
        'name'=>$name,
        'code'=>$code,
        'price'=>$price,
        'quantity'=>$quantity,
        'image'=>$image)
);

if(empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='box'>Product is added to your cart!</div>";
}else{
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if(in_array($code,$array_keys)) {
                $_SESSION["shopping_cart"][$code]['quantity'] += $quantity;
                $status = "<div class='box'>Product is added to your cart!</div>";
        } else {
                $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
                $status = "<div class='box'>Product is added to your cart!</div>";
        }

        }
}
?>
<html>
<head>
<title>Demo Simple Shopping Cart using PHP and MySQL</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>Demo Simple Shopping Cart using PHP and MySQL</h2>

<?php
if(!empty($_SESSION["shopping_cart"]) && is_array($_SESSION["shopping_cart"])) {
foreach($_SESSION["shopping_cart"] as $cart_item){
        $cart_count += isset($cart_item['quantity']) && $cart_item['quantity'] != '' ? (int)$cart_item['quantity']: 1;
}
?>
<div class="cart_div">
<a href="cart.php"><img src="cart-icon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($con,"SELECT * FROM `products`");
while($row = mysqli_fetch_assoc($result)){
                echo "<div class='product_wrapper'>
                          <form method='post' action=''>
                          <input type='hidden' name='code' value=".$row['code']." />
                          <div class='image'><img src='".$row['image']."' /></div>
                          <div class='name'>".$row['name']."</div>
                          <div class='price'>$".(float)$row['price']."</div>
                          <input type='number' name='quantity' min='1' value='1' class='quantity'><button type='submit' class='buy'>Buy Now</button>
                          </form>
                          </div>";
        }
mysqli_close($con);
?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>
</div>
</body>
</html>
