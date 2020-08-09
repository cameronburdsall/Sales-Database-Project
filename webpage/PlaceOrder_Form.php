<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Place Order Form</title>
      <link rel = 'stylesheet' type = 'text/css' href = 'MasterOwlStyle.css'>
   </head>
   <body>
       <div class = 'about'>
       <h3> Place Order </h3>
       <p><a href = 'sales.html'>Back</a></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Customer ID: <input type="text" name="custid" id="custid"> <br>
        Item ID: <input type="text" name="item" id="item"><br>
        Quantity: <input type="text" name="num" id="num"><br>
        <input type="submit">
        </form>
       </div>
       <div class = 'about'>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $custid = $_POST['custid'];
     $item = $_POST['item'];
     $num = $_POST['num'];
     if (!empty($custid) and !empty($item) and !empty($num)){
		 submitOrder($custid, $item, $num);
	}
}

function submitOrder ($custid, $item, $num){
	$conn=oci_connect();//removed server and login info for github upload
        if(!$conn) {
			print "<br> connection failed:";
        	exit;
		}
        $tdate = getdate();
        $date = '2020-06-02';
        //generate orderid
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $orderid = '';
        for ($i = 0; $i < 5; $i++)
        {
            $j = rand(0, strlen($characters)-1);
            $orderid .= $characters[$j];
        }
        //$sql = "call addItemOrder('192ab','yu452','bb321', DATE '2020-06-02',1)";

        //prepare query to execute addItemOrder() PL/SQL function
        $query = oci_parse($conn, "CALL addItemOrder(:orderid, :itemid , :custid , DATE '2020-".$tdate['mon']."-".$tdate['mday']."' , :num)");
		oci_bind_by_name($query,':orderid',$orderid);
        oci_bind_by_name($query,':itemid',$item);
        oci_bind_by_name($query,':custid',$custid);
        oci_bind_by_name($query,':num',$num);
        // Execute the query
		oci_execute($query);
        $query = oci_parse($conn, "SELECT computeTotal(:bv) FROM itemorder where orderid= :bv");
		oci_bind_by_name($query,':bv',$orderid);
        // Execute the query
		oci_execute($query);
		$row = oci_fetch_array($query, OCI_BOTH);
        if (empty($row[0]))
        {
            echo "Not enough copies of that item left";
            exit;
        }
        echo 'Total: $<b>'.$row[0].'</b><br>';
        echo 'Order Submitted, your Order ID is: <b>'.$orderid.'</b><br>';

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
