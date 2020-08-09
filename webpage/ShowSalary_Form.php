<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Place Order</title>
   </head>
   <body>
	   <h3> Place Order </h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Order ID: <input type="text" name="orderid" id="orderid">
  <input type="submit">
 </form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $orderid = $_POST['orderid'];

     if (!empty($orderid)){
		 printItemOrder($orderid);
	}
}

function printItemOrder ($orderid){
	$conn=oci_connect();//removed server and login info for github upload
        if(!$conn) {
			print "<br> connection failed:";
        	exit;
		}
		$query = oci_parse($conn, "SELECT * FROM itemorder where orderid= :bv");
		oci_bind_by_name($query,':bv',$orderid);
        // Execute the query
		oci_execute($query);
		$row = oci_fetch_array($query, OCI_BOTH);
		echo "OrderID: $orderid<br>";
		echo 'CustID: '.$row['CUSTID']."<br>";
		echo 'ItemID: '.$row['ITEMID'].'<br>';
		echo 'Date Ordered: '.$row['DATEOFORDER'].'<br>';
		echo '# of Items: '.$row['NOOFITEMS'].'<br>';
		if (!empty($row['SHIPPEDDATE']))
		{
			echo 'Date Shipped: '.$row['SHIPPEDDATE'].'<br>';
		}
		else{
			echo 'Date Shipped: Shipping Pending <br>';
		}
		
		echo 'Shipping Fee: $'.$row['SHIPPINGFEE'].'<br>';

		$query = oci_parse($conn, "SELECT computeTotal(:bv) FROM itemorder where orderid= :bv");
		oci_bind_by_name($query,':bv',$orderid);
        // Execute the query
        echo $query;
		oci_execute($query);
		$row = oci_fetch_array($query, OCI_BOTH);
		echo 'Total: $'.$row[0];

		return;
}

function getCusitid($orderid){
	$conn=oci_connect();
        if(!$conn) {
             print "<br> connection failed:";
        exit;
        }
        //       Parse the SQL query
        $query = oci_parse($conn, "SELECT * FROM itemorder where orderid= :bv");

        oci_bind_by_name($query,':bv',$orderid);
        // Execute the query
		oci_execute($query);
		

        if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
                // We can use either numeric indexed starting at 0
                // or the column name as an associative array index to access the colum value
                // Use the uppercase column names for the associative array indices
                //echo $row[0] . " and " . $row['SALARY']   . " are the same<br>\n";
                $custid = $row['custid'];
        }
        else {
                echo "No such employee <br>\n";
        }
        oci_free_statement($query);
        oci_close($conn);

        return $custid;
}
function getSalaryFromDB($name){
	//connect to your database
	$conn=oci_connect();
	if(!$conn) {
	     print "<br> connection failed:";
        exit;
	}
	//	 Parse the SQL query
	$query = oci_parse($conn, "SELECT salary FROM AlphacoEmp where name= :bv");

	oci_bind_by_name($query,':bv',$name);
	// Execute the query
	oci_execute($query);

	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		echo $row[0] . " and " . $row['SALARY']   . " are the same<br>\n";
		$salary = $row['SALARY'];
	}
	else {
		echo "No such employee <br>\n";
	}
	oci_free_statement($query);
	oci_close($conn);

	return $salary;
}
function prepareInput($inputData){
	// Removes any leading or trailing white space
	$inputData = trim($inputData);
	// Removes any special characters that are not allowed in the input

  	$inputData  = htmlspecialchars($inputData);

  	return $inputData;
}

?>
<!-- end PHP script -->
   </body>
</html>
