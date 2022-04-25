<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
	
    
    // Prepare a select statement
    $sql = "SELECT * FROM customer WHERE CUSTOMER_NUM = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $custNo = $row["CUSTOMER_NUM"];
                $custName = $row["CUSTOMER_NAME"];
                $street = $row["STREET"];
                $city = $row["CITY"];
                $state = $row["STATE"];
                $zip = $row["ZIP"];
                $repnum = $row["REP_NUM"];

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Customer Number</label>
                            <input type="text" name="custNo" class="form-control <?php echo (!empty($custNo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $custNo; ?>">
                            <span class="invalid-feedback"><?php echo $custNo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Customer Name</label>
                            <input type="text" name="custName" class="form-control <?php echo (!empty($custName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $custName; ?>">
                            <span class="invalid-feedback"><?php echo $custName_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Street</label>
                            <textarea name="street" class="form-control <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>"><?php echo $street; ?></textarea>
                            <span class="invalid-feedback"><?php echo $street_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <textarea name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>"><?php echo $city; ?></textarea>
                            <span class="invalid-feedback"><?php echo $city_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <textarea name="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>"><?php echo $state; ?></textarea>
                            <span class="invalid-feedback"><?php echo $state_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>ZIP</label>
                            <textarea type="text" name="zip" class="form-control <?php echo (!empty($zip_err)) ? 'is-invalid' : ''; ?>"><?php echo $zip; ?></textarea>
                            <span class="invalid-feedback"><?php echo $zip_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Representative Number</label>
                            <input type="text" name="repnum" class="form-control <?php echo (!empty($repnum_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $repnum; ?>">
                            <span class="invalid-feedback"><?php echo $repnum_err;?></span>
                        </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>