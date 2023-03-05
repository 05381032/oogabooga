<?php include "template.php"
/** @var $productNames */
?>
<title>Order Form</title>
<body>

<div class="container-fluid">
    <h1 class="text-primary">Order Form</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
            <div class="row">
                <!--Customer Details-->

                <div class="col-md-6">
                    <h2>Customer Details</h2>
                    <p>Please enter your details:</p>
                    <label for="customerNameFirst" class="form-label">First Name</label>
                    <input class="form-control" id="customerNameFirst" name="customerNameFirst"
                           placeholder="...">
                    <label for="customerNameSecond" class="form-label">Second Name</label>
                    <input class="form-control" id="customerNameSecond" name="customerNameSecond"
                           placeholder="...">
                    <label for="customerAddress" class="form-label">Address</label>
                    <input class="form-control" id="customerAddress" name="customerAddress"
                           placeholder="...">
                    <label for="customerPhone" class="form-label">Phone Number</label>
                    <input class="form-control" id="customerPhone" name="customerPhone"
                           placeholder="...">
                    <label for="customerEmail" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="customerEmail" name="customerEmail"
                           placeholder="name@email.com">

                </div>
                <div class="col-md-6">
                    <h2>Products</h2>
                    <!--Product List-->
                    <p>Please enter the quantities of each product:</p>
                    <label for="orderProduct1" class="form-label"><?php echo $productNames["product1"]; ?></label>
                    <input type="number" class="form-control" id="orderProduct1" name="orderProduct1"
                           value="0">
                    <label for="orderProduct2" class="form-label"><?php echo $productNames["product2"]; ?></label>
                    <input type="number" class="form-control" id="orderProduct2" name="orderProduct2"
                           value="0">
                    <label for="orderProduct3" class="form-label"><?php echo $productNames["product3"]; ?></label>
                    <input type="number" class="form-control" id="orderProduct3" name="orderProduct3"
                           value="0">
                    <label for="orderProduct4" class="form-label"><?php echo $productNames["product4"]; ?></label>
                    <input type="number" class="form-control" id="orderProduct4" name="orderProduct4"
                           value="0">
                    <label for="orderProduct5" class="form-label"><?php echo $productNames["product5"]; ?></label>
                    <input type="number" class="form-control" id="orderProduct5" name="orderProduct5"
                           value="0">

                </div>
            </div>
        </div>
        <input type="submit" name="formSubmit" value="Submit">
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Customer Details
    $cusNameFirst = sanitiseData($_POST['customerNameFirst']);
    $cusNameSecond = sanitiseData($_POST['customerNameSecond']);
    $cusAddress = sanitiseData($_POST['customerAddress']);
    $cusEmail = sanitiseData($_POST['customerEmail']);
    $cusPhone = sanitiseData($_POST['customerPhone']);

// Product Quantities
    $prodQuantity1 = sanitiseData($_POST['orderProduct1']);
    $prodQuantity2 = sanitiseData($_POST['orderProduct2']);
    $prodQuantity3 = sanitiseData($_POST['orderProduct3']);
    $prodQuantity4 = sanitiseData($_POST['orderProduct4']);
    $prodQuantity5 = sanitiseData($_POST['orderProduct5']);
    if ($prodQuantity1 < 0) {
        $prodQuantity1 = 0;
    }
    if ($prodQuantity2 < 0) {
        $prodQuantity2= 0;
    }
    if ($prodQuantity3 < 0) {
        $prodQuantity3= 0;
    }
    if ($prodQuantity4 < 0) {
        $prodQuantity4= 0;
    }
    if ($prodQuantity5< 0) {
        $prodQuantity5= 0;
    }
    $csvFile = fopen("orders.csv", "a");
// Write the string to the end of the file.
    fwrite($csvFile, $cusNameFirst . "," . $cusNameSecond . "," . $cusAddress . "," . $cusEmail . "," . $cusPhone . "," . $prodQuantity1 . "," . $prodQuantity2 . "," . $prodQuantity3 . "," . $prodQuantity4 . "," . $prodQuantity5 . "," . "\n");
// Close the connection to the file.
    fclose($csvFile);
}
?>

<?php echo footer() ?>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
</html>
