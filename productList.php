<?php include "template.php";
/**  @var $conn */
?>
<title>Product List</title>

<h1 class='text-primary'>Product List</h1>

<?php
$productList = $conn->query("SELECT ProductName, Image, Code FROM Products");
?>

<?php
// Check to see if User is Administrator (level 1)
// If they are, allow functionality, otherwise redirect them back to the front page.
if ($_SESSION['AccessLevel'] == 1) {
    ?>
    <!--  Display a list of the products  -->
    <div class="container-fluid">
        <?php
        while ($productData = $productList->fetchArray()) {
            ?>
            <!-- Display each product as [Image] [ProductName] [Edit Link]-->
            <div class="row">
                <div class="col-md-2">
                    <?php
                    echo '<img src="images/productImages/' . $productData[1] . '" width="50" height="50">';
                    ?>
                </div>
                <div class="col-md-4">
                    <?php echo $productData[0]; ?>
                </div>
                <div class="col-md-2">
                    <!-- edit button-->
                    <a href="productEdit.php?prodCode=<?php echo $productData[2]; ?>">Edit</a>
                </div>
                <div class="col-md-2">
                    <!-- remove button-->
                    <a href="productRemove.php?prodCode=<?php echo $productData[2]; ?>">Remove</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
} else {
    header("location:index.php");
}
?>



