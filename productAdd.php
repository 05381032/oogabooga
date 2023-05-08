<?php include "template.php";
/**  @var $conn */
?>
<title>Add Products</title>
<h1 class='text-primary'>Add Products</h1>

<?php
$query = $conn->query("SELECT DISTINCT category FROM Products");
?>

<!-- Front End -->

<?php
// Check to see if User is Administrator (level 1)
// If they are, allow functionality, otherwise redirect them back to the front page.
if ($_SESSION['AccessLevel'] == 1) {
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <!--Customer Details-->
                <div class="col-md-6">
                    <h2>Products Details</h2>
                    <p>Product Name<input type="text" name="prodName" class="form-control" required="required"></p>
                    <p>Product Category
                         <input type="text" name="prodCategory" class="form-control" required="required">
<!--                        <select name="prodCategory">-->
<!--                            --><?php
//                            while ($row = $query->fetchArray()) {
//                                echo '<option>' . $row[0] . '</option>';
//                            }
//                            ?>
<!--                        </select>-->
                    </p>
                    <p>Quantity<input type="number" name="prodQuantity" class="form-control" required="required"></p>
                </div>
                <div class="col-md-6">
                    <h2>More Details</h2>
                    <!--Product List-->
                    <p>Price<input type="number" step="0.01" name="prodPrice" class="form-control" required="required">
                    </p>
                    <p>Product Code<input type="text" name="prodCode" class="form-control" required="required"></p>
                    <p>Product Picture <input type="file" name="prodImage" class="form-control" required="required"></p>
                </div>
            </div>
        </div>
        <input type="submit" name="formSubmit" value="Submit">
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
    $prodName = sanitiseData($_POST['prodName']);
    $prodCategory = sanitiseData($_POST['prodCategory']);
    $prodQuantity = sanitiseData($_POST['prodQuantity']);
    $prodPrice = sanitiseData($_POST['prodPrice']);
    $prodCode = sanitiseData($_POST['prodCode']);

//check if product exists.
    $query = $conn->query("SELECT COUNT(*) FROM Products WHERE code='$prodCode'");
    $data = $query->fetchArray();
    $numberOfProducts = (int)$data[0];

    if ($numberOfProducts > 0) {
        echo "Sorry, product already taken";
    } else {
        // Product Registration commences

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
                    $sql = "INSERT INTO Products (ProductName, Category, Quantity, Price, Image, Code) VALUES (:newProdName, :newProdCategory, :newProdQuantity, :newProdPrice, :newProdImage, :newProdCode)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':newProdName', $prodName);
                    $stmt->bindValue(':newProdCategory', $prodCategory);
                    $stmt->bindValue(':newProdQuantity', $prodQuantity);
                    $stmt->bindValue(':newProdPrice', $prodPrice);
                    $stmt->bindValue(':newProdImage', $fileNameNew);
                    $stmt->bindValue(':newProdCode', $prodCode);
                    $stmt->execute();
                    header("location:index.php");
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
}

?>


</body>
</html>
