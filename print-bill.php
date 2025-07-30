<?php
session_start();
include('connect.php');
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['print_bill']) && isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Fetch the transaction document from the database
    $filter = ['_id' => new MongoDB\BSON\ObjectId($transaction_id)];
    $transaction = executeQuery('transactions', $filter)[0] ?? null;

    if ($transaction) {
        $customer_name = htmlspecialchars($transaction->customer_name);
        $customer_mobile = htmlspecialchars($transaction->customer_mobile);
        $doctor_name =htmlspecialchars($transaction->doctor_name) ;
        $age =htmlspecialchars($transaction->age);
        $gender =  htmlspecialchars($transaction->gender);
        $time = htmlspecialchars($transaction->timestamp) ;
        $cart_items=$transaction->items;
       
        // Calculate total amount for display (if needed)
        $total_amount =htmlspecialchars($transaction->total_amount);

    } else {
        echo "<p>Transaction not found.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
</head>
<script>
// Automatically trigger print dialog on load.
window.onload = function() {
   window.print();
};

</script>
<body>
    <div class="bill">
        <div class="bill-top">
            <div class="shop-details">
                <p class="licence">DL CBE 1271/20, 1271/21</p>
                <h2 class="shop-name">Sri Sai Suriya Medicals</h2>
                <p class="address"><strong>1/233-1,Rangammal Colony,N.G.G.O Colony,CBE-22</strong></p><br>
                <p class="gst"><strong>GSTIN: </strong>33CCJPS5050D1ZR &nbsp;<strong>Phn :</strong> 9894180852</p>
                
            </div>
            
            <div class="bill-top-right">
                <p class="bill-no"><strong> Bill No:</strong><span></span></p>
                <p class="doc-name"><strong>Doctor Name:</strong> <?= $doctor_name ?><span></span></p>
                <p class="doc-name"><strong>Time:</strong> <?= $time ?><span></span></p>
            </div>
        </div>
        <div class="bill-bottom">
            <div class="customer-details"> <p class="customer-name"><strong>Name:&nbsp;&nbsp;</strong><span><?= $customer_name ?></span></p>
                <p class="age"><strong>Age:&nbsp;</strong><span><?= $age ?> Yrs</span></p>
                <p class="gender">&nbsp;<strong>Sex:&nbsp;</strong><span><?= $gender ?></span></p>
                <p class="customer-number"><strong>Mobile No: </strong><span><?= $customer_mobile ?></span></p>
            </div>
        </div>
        <p style="text-align:center;font-size:large;">Bill Summary</p>
        <div class="bill-summary">
        <table border='1'>
            <thead>
            <tr style='color: Black;'>
            <th>Name</th><th>Type</th><th>Batch No</th><th>Expiry Date</th><th>Rate</th><th>Quantity</th><th>Total Price</th><th>Discount</th></tr>
        </thead>
        <tbody><?php 
            foreach ($cart_items as $item): 
            ?>
            <?php 
            echo "<tr><td>" . htmlspecialchars($item->name) . "</td><td>" . htmlspecialchars($item->type) . "</td><td>" . htmlspecialchars($item->batch_no) . "</td><td>" . htmlspecialchars($item->expiry_date) . "</td><td>₹" . htmlspecialchars($item->price) . "</td><td>" . htmlspecialchars($item->quantity) . "</td><td>₹" . htmlspecialchars($item->quantity * $item->price) . "</td><td>" . htmlspecialchars($item->discount) . "%</td></tr>"; 
            endforeach; 
            ?>
             </tbody>
             <tr>
                <td style="text-align: right;"colspan="9">
                <div class="total-amt">
                <!-- <ul style="list-style-type: none;margin: 0%; padding: 0%;"> -->
                    <strong>Grand Total :&nbsp;₹</strong><?= htmlspecialchars($total_amount); ?><br>
                   
                    <strong>Amt To Be Paid :&nbsp;₹</strong><?= round(htmlspecialchars($total_amount)); ?>
                </div>
                </td>
            </tr>
        </table>
        </div>
    </div>
    <br>
   

</body>
<style>

    .total-amt{
        margin: 0%;
        float: right;
    }
    table {
    border-collapse: collapse;
    margin: 20px 0;
    text-align: center;
    padding:10px;
    width:1000px;
}
th{
    border: 1px solid #4CAF50;
    font-size: large;
    height:30px;
    width:150px;
    color:#4CAF50;
}
td {
    border: 1px solid #4CAF50;
    padding: 10px;
    height: 30px;
    width:150px;
    font-size: medium;
}

thead th {

    color: black;
}

    .bill-summary{
        margin-top: 20px;
        width: 1000px;
    }

   button, .button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
    margin: 5px 0;
    text-align: center;
}
.total-amt{
    font-size:x-large;
}
    
    .bill-top{
        height: 140px;
        width:1000px;
        display: flex;
    }
    
    .bill-no{
        font-size: large;
        height: 30px;
        width:300px;
        
    }
    .doc-name{
        width:300px;
        font-size:medium;
    }
    .bill{
        width:1000px;
        border: 1px solid #4CAF50;
    }
    .shop-details{
        width: 700px; 
        height: 140px;
        border: 1px solid #4CAF50;
        color:green;
    }
    .licence{
        font-size: small;
        margin: 0%;
        padding: 5px 0px 0px 5px;
        width: 200px;
    }
    .shop-name{
        text-align: center;
        font-size: 50px;
        padding-bottom: 0px;
        margin: 0%;
        display: flex;
        justify-content: center;
    }
    .address{
        display: flex;
        font-size: 20px;
        justify-content: center;
        margin: 0%;
        text-align: center;
    }
    .gst{
        display: flex;
        justify-content: center;
        margin: 0%;
        align-items: center;
        height: 20px;
        font-size: 1.2rem;
    }
    .shop-number{
        text-align:right;

    }
    .customer-details{
        border: 1px solid #4CAF50;
        width: 1000px;
        height: 60px;
        display: flex;
        justify-content: center;
       
    }
    .customer-name{
        display: flex;
        font-size: larger;
        width: 340px;
        margin-left: 0%;
    }
    .age{
        width:100px;
        display:flex;
        font-size: larger;
    }
    .gender{
        width:100px;
        font-size: larger;
        display:flex;

    }
    .customer-number{
        width: 300px;
        height: 20px;
        font-size: larger;
        
    }
    .bill-top-right{
        border: 1px solid #4CAF50;
        width: 300px;
        height: 140px;
    }



</style>
</html>