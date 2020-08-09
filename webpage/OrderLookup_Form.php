<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Order Lookup Form</title>
      <link rel = 'stylesheet' type = 'text/css' href = 'MasterOwlStyle.css'>
   </head>
   <body>
       <div class = 'about'>
       <h3> Order Lookup </h3>
       <p><a href = 'sales.html'>Back</a></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Order ID: <input type="text" name="orderid" id="orderid">
        <input type="submit">
        </form>
       </div>
       <div class = 'about'>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $orderid = $_POST['orderid'];

     if (!empty($orderid)){
		 printItemOrder($orderid);
	}
}

function printItemOrder ($orderid){
	$conn=oci_connect(); //removed server and login info for github upload
        if(!$conn) {
			print "<br> connection failed:";
        	exit;
		}
		$query = oci_parse($conn, "SELECT * FROM itemorder where orderid= :bv");
		oci_bind_by_name($query,':bv',$orderid);
        // Execute the query
		oci_execute($query);
        $row = oci_fetch_array($query, OCI_BOTH);
        if (empty($row[0]))
        {
            echo 'Invalid Order ID';
            exit;
        }
        echo "OrderID: $orderid<br>";
        echo '<ul>';
		echo 'CustID: '.$row['CUSTID']."<br>";
		echo 'ItemID: '.$row['ITEMID'].'<br><br>';
        echo 'Date Ordered: '.$row['DATEOFORDER'].'<br>';
        
        
		if (!empty($row['SHIPPEDDATE']))
		{
			echo 'Date Shipped: '.$row['SHIPPEDDATE'].'<br>';
		}
		else{
			echo 'Date Shipped: Shipping Pending <br>';
		}
		
		echo '<br>Shipping Fee: $'.$row['SHIPPINGFEE'].'<br>';
        echo '# of Items: '.$row['NOOFITEMS'].'<br>';
		$query = oci_parse($conn, "SELECT computeTotal(:bv) FROM itemorder where orderid= :bv");
		oci_bind_by_name($query,':bv',$orderid);;
		oci_execute($query);
		$row = oci_fetch_array($query, OCI_BOTH);
		echo '<br><b>Total: $'.$row[0].'</b>';

        echo '</ul>';

		return;
}
function prepareInput($inputData){
	// Removes any leading or trailing white space
	$inputData = trim($inputData);
	// Removes any special characters that are not allowed in the input

  	$inputData  = htmlspecialchars($inputData);

  	return $inputData;
}

?>
</div>
<!-- end PHP script -->
   </body>
</html>
