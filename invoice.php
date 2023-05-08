<?php include "template.php"
/** @var $productNames */
/** @var $productPrices */
?>
<title>Invoice</title>
<body>

<?php

$invoiceNumber = intval(sanitiseData($_GET["invoiceNumber"]));

// Read the contents of the file
$currentRow = 1;
if (($handle = fopen("orders.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($currentRow == $invoiceNumber) {
            // Customer Details
            $cusNameFirst = $data[0];
            $cusNameSecond = $data[1];
            $cusAddress = $data[2];
            $cusEmail = $data[3];
            $cusPhone = $data[4];

            // Product Quantities
            $prod1Quantity = $data[5];
            $prod2Quantity = $data[6];
            $prod3Quantity = $data[7];
            $prod4Quantity = $data[8];
            $prod5Quantity = $data[9];
        }
        $currentRow++; //Add one to the current row
    }
    fclose($handle);    // Closes the File

    $prod1SubTotal = $prod1Quantity * $productPrices["product1"];
    $prod2SubTotal = $prod2Quantity * $productPrices["product2"];
    $prod3SubTotal = $prod3Quantity * $productPrices["product3"];
    $prod4SubTotal = $prod4Quantity * $productPrices["product4"];
    $prod5SubTotal = $prod5Quantity * $productPrices["product5"];
    $invoiceTotal = $prod1SubTotal + $prod2SubTotal + $prod3SubTotal + $prod4SubTotal + $prod5SubTotal;
}

?>

<!--Customer Details-->
<h1 class="text-primary">Invoice</h1>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-secondary">Customer Details</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-primary">
            Customer Name
        </div>
        <div class="col-md-6 text-bg-light">
            <?= $cusNameFirst . " " . $cusNameSecond ?>
        </div>
        <div class="col-md-6 text-primary">
            Address
        </div>
        <div class="col-md-6 text-bg-light">
            <?= $cusAddress ?>
        </div>

        <div class="col-md-6 text-primary">
            Email
        </div>
        <div class="col-md-6 text-bg-light">
            <?= $cusEmail ?>
        </div>

        <div class="col-md-6 text-primary">
            Phone
        </div>
        <div class="col-md-6 text-bg-light">
            <?= $cusPhone ?>
        </div>
    </div>
</div>
<!--Products ordered -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-secondary">Products Ordered</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3"><?php echo $productNames["product1"]; ?> </div>
        <div class="col-lg-3">$<?= $productPrices["product1"]; ?></div>
        <div class="col-lg-3"><?= $prod1Quantity ?></div>
        <div class="col-lg-3">$<?= $prod1SubTotal ?></div>
    </div>
    <div class="row">
        <div class="col-lg-3"><?php echo $productNames["product2"]; ?> </div>
        <div class="col-lg-3">$<?= $productPrices["product2"]; ?></div>
        <div class="col-lg-3"><?= $prod2Quantity ?></div>
        <div class="col-lg-3">$<?= $prod2SubTotal ?></div>
    </div>
    <div class="row">
        <div class="col-lg-3"><?php echo $productNames["product3"]; ?> </div>
        <div class="col-lg-3">$<?= $productPrices["product3"]; ?></div>
        <div class="col-lg-3"><?= $prod3Quantity ?></div>
        <div class="col-lg-3">$<?= $prod3SubTotal ?></div>
    </div>
    <div class="row">
        <div class="col-lg-3"><?php echo $productNames["product4"]; ?> </div>
        <div class="col-lg-3">$<?= $productPrices["product4"]; ?></div>
        <div class="col-lg-3"><?= $prod4Quantity ?></div>
        <div class="col-lg-3">$<?= $prod4SubTotal ?></div>
    </div>
    <div class="row">
        <div class="col-lg-3"><?php echo $productNames["product5"]; ?> </div>
        <div class="col-lg-3">$<?= $productPrices["product5"]; ?></div>
        <div class="col-lg-3"><?= $prod5Quantity ?></div>
        <div class="col-lg-3">$<?= $prod5SubTotal ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-secondary text-sm-end">$<?= $invoiceTotal ?></h2>
        </div>
    </div>
</div>

<?php echo footer() ?>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
</html>