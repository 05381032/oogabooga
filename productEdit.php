<?php include "template.php";
/**  @var $conn */
?>
<title>Edit Product</title>

<?php

if (isset($_GET["prodCode"])) {
    $prodCode = $_GET["prodCode"];
    $queryCategories = $conn->query("SELECT DISTINCT category FROM Products");
} else {
    header("location:index.php");
}

$query = $conn->query("SELECT * FROM products WHERE code='$prodCode'");
$prodData = $query->fetchArray();
$prodName = $prodData[1];
$prodPrice = $prodData[2];
$prodCategory = $prodData[3];
$prodQuantity = $prodData[4];
$prodImage = $prodData[5];
?>

<h1 class='text-primary'>Edit Product - <?= $prodName ?> </h1>


<!-- Front End -->

<?php
// Check to see if User is Administrator (level 1)
// If they are, allow functionality, otherwise redirect them back to the front page.
if ($_SESSION['AccessLevel'] == 1) {
    ?>
    <form action="productEdit.php?prodCode=<?= $prodCode ?>" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <!--Customer Details-->
                <div class="col-md-6">
                    <h2>Products Details</h2>
                    <p>Product Name<input type="text" name="prodName" class="form-control" required="required"
                                          value="<?= $prodName ?>"></p>
                    <p>Product Category
                        <input type="text" name="prodCategory" class="form-control" required="required"
                               value="<?= $prodCategory ?>"></p>
                    </p>
                    <p>Quantity<input type="number" name="prodQuantity" class="form-control" required="required"
                                      value="<?= $prodQuantity ?>"></p>
                </div>
                <div class="col-md-6">
                    <h2>More Details</h2>
                    <!--Product List-->
                    <p>Price<input type="number" step="0.01" name="prodPrice" class="form-control" required="required"
                                   value="<?= $prodPrice ?>">
                    </p>
                    <p>Product Code<input type="text" name="prodCode" class="form-control" required="required"
                                          value="<?= $prodCode ?>"></p>
                    <p>Product Picture
                        <img src='images/productImages/<?= $prodImage ?>' width='100' height='100'>
                        <input type="file" name="prodImage" class="form-control" required="required"></p>
                </div>
            </div>
        </div>
        <input type="submit" name="formSubmit" value="Update">
    </form>

    <?php
} else {
    header("location:index.php");
}
?>


<?php
// Back End
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    Customer Details
    $newName = sanitiseData($_POST['prodName']);
    $newCategory = sanitiseData($_POST['prodCategory']);
    $newQuantity = sanitiseData($_POST['prodQuantity']);
    $newPrice = sanitiseData($_POST['prodPrice']);
    $newCode = sanitiseData($_POST['prodCode']);

    // Image details
    $file = $_FILES['prodImage'];
    $fileName = $_FILES['prodImage']['name'];
    $fileTmpName = $_FILES['prodImage']['tmp_name'];
    $fileSize = $_FILES['prodImage']['size'];
    $fileError = $_FILES['prodImage']['error'];
    $fileType = $_FILES['prodImage']['type'];

    // defining what type of file is allowed
    // We separate the file, and obtain the file extension.
    $fileExtension = explode('.', $fileName);
    $fileActualExtension = strtolower(end($fileExtension));

    $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');

    //We ensure the extension is allowable
    if (in_array($fileActualExtension, $allowedExtensions)) {
        if ($fileError === 0) {
            // File is smaller than arbitrary size
            if ($fileSize < 10000000000) {
                //file name is now a unique ID based on time with IMG- preceeding it, followed by the file type.
                $fileNameNew = uniqid('IMG-', True) . "." . $fileActualExtension;
                //upload location
                $fileDestination = 'images/productImages/' . $fileNameNew;
                // Upload file
                move_uploaded_file($fileTmpName, $fileDestination);

                // Write details to database
                $sql = "UPDATE Products SET ProductName= :newProdName, Category= :newProdCategory, Quantity= :newProdQuantity, Price= :newProdPrice, Image= :newProdImage, Code= :newProdCode WHERE code='$prodCode'";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':newProdName', $newName);
                $stmt->bindValue(':newProdCategory', $newCategory);
                $stmt->bindValue(':newProdQuantity', $newQuantity);
                $stmt->bindValue(':newProdPrice', $newPrice);
                $stmt->bindValue(':newProdImage', $fileNameNew);
                $stmt->bindValue(':newProdCode', $newCode);
                $stmt->execute();
                header("location:productList.php");
            } else {
                echo "Your image is too big!";
            }
        } else {
            echo "there was an error uploading your image!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}

?>


</body>
</html>


