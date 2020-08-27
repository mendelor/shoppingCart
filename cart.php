<?php
/*
Website: http://machine-learning.co.nz
*/

session_start();
$ajaxAaction = @$_REQUEST['ajax_action'];
if($ajaxAaction == 'change'){
        $quantity = 0;
        if(!empty($_SESSION["shopping_cart"]) && is_array($_SESSION["shopping_cart"])) {
                foreach($_SESSION["shopping_cart"] as &$value){
                        if($value['code'] === @$_REQUEST["code"]){
                                $value['quantity'] = $_REQUEST["quantity"];
                                break;
                        }
                }
                foreach($_SESSION["shopping_cart"] as $cart_item){
                        $quantity += isset($cart_item['quantity']) && $cart_item['quantity'] != '' ? (int)$cart_item['quantity']: 1;
                }
        }
        echo $quantity;
}
if(!$ajaxAaction) {
$status="";
if (isset($_POST['action']) && $_POST['action']=="remove"){
if(!empty($_SESSION["shopping_cart"])) {
        foreach($_SESSION["shopping_cart"] as $key => $value) {
                if($_POST["code"] == $key){
                unset($_SESSION["shopping_cart"][$key]);
                $status = "<div class='box' style='color:red;'>
                Product is removed from your cart!</div>";
                }
                if(empty($_SESSION["shopping_cart"]))
                unset($_SESSION["shopping_cart"]);
                        }
                }
}
?>
<html>
<head>
<title>Demo Shopping Cart</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>Demo Shopping Cart</h2>

<?php
if(!empty($_SESSION["shopping_cart"]) && is_array($_SESSION["shopping_cart"])) {
        foreach($_SESSION["shopping_cart"] as $cart_item){
                $cart_count += isset($cart_item['quantity']) && $cart_item['quantity'] != '' ? (int)$cart_item['quantity']: 1;
        }
?>
<div class="cart_div">
<a href="cart.php">
<img src="cart-icon.png" /> Cart
<span class="cart-count"><?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>

<div class="cart">
<?php
if(isset($_SESSION["shopping_cart"])){
    $total_price = 0;
?>
<table class="table">
<tbody>
<tr>
<td></td>
<td>ITEM NAME</td>
<td>UNIT PRICE</td>
<td>QUANTITY</td>
<td>ITEMS TOTAL</td>
</tr>
<?php
foreach ($_SESSION["shopping_cart"] as $product){
?>
<tr>
<td><img src='<?php echo $product["image"]; ?>' width="50" height="40" /></td>
<td><?php echo $product["name"]; ?><br />
<form method='post' action=''>
<input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
<input type='hidden' name='action' value="remove" />
<button type='submit' class='remove'>Remove Item</button>
</form>
</td>
<td><?php echo "$".(float)$product["price"]; ?></td>
<td>
<input data-price='<?php echo (float)$product["price"]; ?>' data-code='<?php echo $product['code'];?>' class='quantity change-quantity' value='<?php echo $product['quantity'];?>' name='quantity' type='number' min='1'>
</form>
</td>
<td>$<span class='product-price'><?php echo (float)$product["price"]*$product["quantity"]; ?></span></td>
</tr>
<?php
$total_price += ($product["price"]*$product["quantity"]);
}
?>
<tr>
<td colspan="5" align="right">
<strong>TOTAL: $<span class='cart-total'><?php echo (float)$total_price; ?></span></strong>
</td>
</tr>
</tbody>
</table>
  <?php
}else{
        echo "<h3>Your cart is empty!</h3>";
        }
?>
</div>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>

<p><a href="index.php">Back to home page</a></p>
</div>
<script>
jQuery(document).ready(function($){
        $('.change-quantity').on('change', function(){
                var code = $(this).attr('data-code');
                var quantity = $(this).val();
                var price = $(this).attr('data-price');
                var product = $(this).parent().parent();
                console.log(parseFloat(price));
                var totalProductPrice = parseFloat(price)*parseInt(quantity);
                product.find('.product-price').html(parseFloat(totalProductPrice.toFixed(3)));
                var totalPrice = 0;
                $('.product-price').each(function(idx,val){
                        totalPrice += parseFloat($(val).text());
                })
                $('.cart-total').html(parseFloat(totalPrice.toFixed(3)));
                $.ajax({
                        url: '?ajax_action=change&code='+code+'&quantity='+quantity,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(res){
                                $('.cart-count').html(res);
                        }
                })
        })
})
</script>
</body>
</html>
<?php
}
?>
