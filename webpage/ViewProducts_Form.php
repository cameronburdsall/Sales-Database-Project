<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
      <title>Products</title>
      <link rel = 'stylesheet' type = 'text/css' href = 'MasterOwlStyle.css'>
   </head>
   <body>
       <div class = 'about'>
       <h3> Products </h3>
       <p><a href = 'sales.html'>Back</a></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        View Items<input type="submit">
        </form>
       </div>
       <div class = 'about'>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # collect input data
		 printProducts();
}

function printProducts (){
	$conn=oci_connect(); //removed server and login info for github upload
        if(!$conn) {
			print "<br> connection failed:";
        	exit;
		}
		$query = oci_parse($conn, "SELECT * FROM storeitems");
        // Execute the query
		oci_execute($query);
        while (oci_fetch($query))
        {
            $val = oci_result($query, 'ITEMID');
            echo "<b>".$val."</b>    ";
            echo "<b>".oci_result($query, 'PRICE')."</b><br>";
            $itemType = "SELECT * FROM COMICBOOKS WHERE ITEMID = :bv";
            $newQuery = oci_parse($conn, $itemType);
            oci_bind_by_name($newQuery,':bv',$val);
            oci_execute($newQuery);
            $row = oci_fetch_array($newQuery, OCI_BOTH);
            if (!empty($row[0]))
            {
                echo "Product Type: COMIC <br> Title: ".$row['TITLE']." | # of Copies: ".$row['NOOFCOPIES']." | Published: ".$row['PUBLISHEDDATE']." | ISBN: ".$row['ISBN']."<br><br>";
            }
            else{
                $itemType = "SELECT * FROM TSHIRT WHERE ITEMID = :bv";
                $newQuery = oci_parse($conn, $itemType);
                oci_bind_by_name($newQuery,':bv',$val);
                oci_execute($newQuery);
                $newrow = oci_fetch_array($newQuery, OCI_BOTH);
                echo "Product Type: TSHIRT <br> Size: ".$newrow[0].'<br><br>';
            }
            
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
