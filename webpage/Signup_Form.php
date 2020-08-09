<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Sign Up Form</title>
      <link rel = 'stylesheet' type = 'text/css' href = 'MasterOwlStyle.css'>
   </head>
   <body>
       <div class = 'about'>
       <h3> Sign Up </h3>
       <p><a href = 'sales.html'>Back</a></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Name: <input type="text" name="name" id="name"> <br>
        Phone (XXXXXXXXXX): <input type="phone" name="phone" id="item"><br>
        Email: <input type="text" name="mail" id="mail"><br>
        Address: <input type="text" name="ad" id="ad"><br>
        <input type = "hidden" name = "gold" value = "No">
        Sign up for Gold Membership? <input type = "checkbox" name = "gold" id = "gold" value = "Yes"><br>
        <input type="submit">
        </form>
       </div>
       <div class = 'about'>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
     $name = $_POST['name'];
     $phone = $_POST['phone'];
     $mail = $_POST['mail'];
     $ad = $_POST['ad'];
     $gold = $_POST['gold'];
     if (!empty($name) and !empty($phone) and !empty($mail) and !empty ($ad)){
		 signUp($name, $phone, $mail, $ad, $gold);
	}
}

function signUp ($name, $phone, $mail, $ad, $gold){
	$conn=oci_connect();//removed server and login info for github upload
        if(!$conn) {
			print "<br> connection failed:";
        	exit;
		}
        $tdate = getdate();
        //generate orderid
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $custid = '';
        for ($i = 0; $i < 5; $i++)
        {
            $j = rand(0, strlen($characters)-1);
            $custid .= $characters[$j];
        }

        //prepare query to execute addItemOrder() PL/SQL function
        $sql = "INSERT INTO CUSTOMERS VALUES (:custid, :n , :p , :e , :a)";
    $query = oci_parse ($conn, $sql);
		oci_bind_by_name($query,':n',$name);
        oci_bind_by_name($query,':p',$phone);
        oci_bind_by_name($query,':custid',$custid);
        //oci_bind_by_name($query,':date',$date);
        oci_bind_by_name($query,':e',$mail);
        oci_bind_by_name($query, 'a', $ad);
        // Execute the query
        //echo $query;
		oci_execute($query);

        echo 'Sign up Successful, welcome, '.$name.'!<br>';
        echo 'Your account ID is: <b>'.$custid.'</b><br>';

        /* Set if gold member   */
        if ($gold == 'Yes')
        {
            $sql = "INSERT INTO GOLDCUSTOMERS VALUES (DATE '2020-".$tdate['mon']."-".$tdate['mday']."', :custid)";
            $query = oci_parse ($conn, $sql);
            oci_bind_by_name($query,':custid',$custid);
            oci_execute($query);
            echo "Welcome to Gold Membership!";
        }
    
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
