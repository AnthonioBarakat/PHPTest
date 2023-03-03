<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
    crossorigin="anonymous">
    </script>
    <link href="css/main.css" rel="stylesheet">
    <title>Product List</title>
</head>

<body>
<form method="post" action="delete.php">
    <div class="clearfix">
        <h1>Product List</h1>
        <div class=buttons>
            <a href="addForm.html" class="btn btn-primary">ADD</a>
            <input type="submit" class="btn btn-danger" value ="MASS DELETE" id="delete-product-btn">
        </div>    
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <?php
            require_once dirname(__FILE__) . '/prepare.php';
            use Prepare\All;
            $a = new All();
            $all_products = $a->integrateAll();
            foreach ($all_products as $prod) {?>
                <div class="col-lg-3">
                    <div class="card border-dark">
                        <div class="card-body">
                            <p><input type="checkbox" class="delete-checkbox" name="del_items[]" 
                            value="<?php echo $prod->getSKU(); ?>" ></p>
                            <?php echo $prod; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</form>
<div class="footer">
    <hr>
    <p class="text-center"><b>Scandiweb Test Assigment</b></p>
</div>
</body>
</html>
