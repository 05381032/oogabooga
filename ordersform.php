<title>Order Form</title>
<?php include "template.php";
/**  @var $conn */
?>
<link rel="stylesheet" href="css/orderForm.css">

<h1 class="text-primary">Order Form</h1>

<?php
$status = "";
if (isset($_POST['Code']) && $_POST['Code'] != "") {
    $code = $_POST['Code'];
    $row = $conn->querySingle("SELECT * FROM products WHERE code='$code'", true);
    $name = $row['ProductName'];
    $price = $row['Price'];
    $image = $row['Image'];
    $id = $row['ProductID'];

    $cartArray = array(
        $code => array(
            'id' => $id,
            'productName' => $name,
            'code' => $code,
            'price' => $price,
            'quantity' => 1,
            'image' => $image)
    );

    // Debug Purposes
    // echo '<pre>'; print_r($cartArray); echo '</pre>';

    if (empty($_SESSION["ShoppingCart"])) {
        $_SESSION["ShoppingCart"] = $cartArray;
        $status = "<div class='box'>Product is added to your cart!</div>";
    } else {
        $array_keys = array_keys($_SESSION["ShoppingCart"]);
        if (in_array($code, $array_keys)) {
            $status = "<div class='box' style='color:red;'>Product is already added to your cart!</div>";
        } else {
            $_SESSION["ShoppingCart"] = array_merge(
                $_SESSION["ShoppingCart"], $cartArray
            );
            $status = "<div class='box'>Product is added to your cart!</div>";
        }
    }
}
?>

<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>

<?php

if (!empty($_SESSION["ShoppingCart"])) {
    $cart_count = count(array_keys($_SESSION["ShoppingCart"]));
    ?>
    <div class="cart_div">
        <a href="cart.php"><img src="images/cart-icon.png"/> Cart<span>
<?php echo $cart_count; ?></span></a>
    </div>
    <?php
}

$result = $conn->query("SELECT * FROM Products");
while ($row = $result->fetchArray()) {
    echo "<div class='product_wrapper'>
    <form method ='post' action =''>
    <input type='hidden' name='Code' value=" . $row['Code'] . " />
    <div class='image'><img src='images/productImages/" . $row['Image'] . "' width='100' height='100'/></div>
    <div class='name'>" . $row['ProductName'] . "</div>
    <div class='price'>$" . $row['Price'] . "</div>
    <button type='submit' class='buy'>Add to Cart</button>
    </form>
    </div>";
}

?>