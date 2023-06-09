
<?php
include "template.php";
/** @var $conn
 */
// The invoices page has a number of use cases to satisfy:
//        1. If user is not logged in, then redirect them to index.php
//        2. Users to view their "open" orders as a list.
//        3. Users to view invoices from individual orders (using the order variable in url, e.g `invoice.php?order=234`)
//        4. Inform users if they have not previously made any orders.
//        5. Administrators to view all orders
//        6. Administrators can OPEN and CLOSE orders
if (!isset($_SESSION["CustomerID"])) {
    // Case 1. The user is not logged in.
    header("Location:index.php");
} else {
    if (empty($_GET["order"])) {
        // no 'order' variable detected in the url.
        $custID = $_SESSION['CustomerID'];

        if ($_SESSION["AccessLevel"] == 1) {
            // Case 5 - Generate a list of all invoices for administrators
            $query = $conn->query("SELECT OrderNumber FROM Orders");
            $count = $conn->querySingle("SELECT OrderNumber FROM Orders");
        } else {
            // Case 2 - Generate a list of open invoices for user
            $query = $conn->query("SELECT OrderNumber FROM Orders WHERE CustomerID='$custID' AND Status='OPEN'");
            $count = $conn->querySingle("SELECT OrderNumber FROM Orders WHERE customerID='$custID' AND status='OPEN'");
        }

        $orderCodesForUser = [];

        if ($count > 0) {  // Has the User made orders previously?
            // Case 2: Display open orders
            while ($data = $query->fetchArray()) {
                $orderCode = $data[0];
                array_push($orderCodesForUser, $orderCode);
            }
            //Gets the unique order numbers from the extracted table above.
            $unique_orders = array_unique($orderCodesForUser);
            echo "<div class='container-fluid'>";
            // Produce a list of links of the Orders for the user.
            foreach ($unique_orders as $order_ID) {
                ?>
                <div class='row'>
                    <div class='col-12'><a href='invoice.php?order=<?= $order_ID ?>'>Order : <?= $order_ID ?></a></div>
                </div>
                <?php
            }
            echo "</div>";
        } else {
            // Case 4: No orders found for the logged in user.
            echo "<div class='badge bg-danger text-wrap fs-5'>You don't have any open orders. Please make an order to view them</div>";

        }
    } else {
        // Case 3 - 'order' variable detected.
        $orderNumber = $_GET["order"];
        $query = $conn->query("SELECT p.ProductName, p.Price, o.Quantity, p.Price*o.Quantity as SubTotal, o.OrderDate, o.Status FROM Orders o INNER JOIN Products p on o.ProductID = p.ProductID WHERE o.OrderNumber='$orderNumber'");
        $total = 0;
        ?>
        <div class='container-fluid'>
        <div class='row'>
            <div class='col text-success display-6'>Product Name</div>
            <div class='col text-success display-6'>Price</div>
            <div class='col text-success display-6'>Quantity</div>
            <div class='col text-success display-6'>Subtotal</div>
        </div>

        <?php
        while ($data = $query->fetchArray()) {
            echo "<div class='row'>";
            $productName = $data["ProductName"];
            $price = $data["Price"];
            $quantity = $data["Quantity"];
            $subtotal = $data["SubTotal"];
            $orderDate = $data["OrderDate"];
            $status = $data["Status"];
            $total = $total + $subtotal; // Running Total
            echo "<div class='col'>" . $productName . "</div>";
            echo "<div class='col'>$" . $price . "</div>";
            echo "<div class='col'>" . $quantity . "</div>";
            echo "<div class='col'>$" . $subtotal . "</div>";

            echo "</div>";
        }
        ?>

        <div class='row'>
            <div class='col'></div>
            <div class='col'></div>
            <div class='col display-6'>Total : $<?= $total ?></div>
        </div>
        <div class='row'>
            <div class='col'></div>
            <div class='col'></div>
            <div class='col'><?= $orderDate ?></div>
        </div>

        <?php
        if ($_SESSION["AccessLevel"] == 1) {
            if (!empty($_GET["status"])) {
                if ($_GET["status"] == "CLOSED") {
                    $conn->exec("UPDATE Orders SET status='CLOSED' WHERE OrderNumber='$orderNumber'");
                    $orderMessage = "Order #:" . $orderNumber . " has been closed";
                } else {
                    $conn->exec("UPDATE Orders SET status='OPEN' WHERE OrderNumber='$orderNumber'");
                    $orderMessage = "Order #:" . $orderNumber . " has been re-opened";
                }
            }
            if ($status == "OPEN") {
                echo "STATUS: OPEN";
                echo "<p><a href='invoice.php?order=" . $orderNumber . "&status=CLOSED'>Click here to close</a></p>";
            } else {
                echo "STATUS: CLOSED";
                echo "<p><a href='invoice.php?order=" . $orderNumber . "&status=OPEN'>Click here to open</a></p>";
            }
        }


    }
}


/*
 *
 *
 *
 */