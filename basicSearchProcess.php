<?php

require "connection.php";

$txt = $_POST["t"];
$select = $_POST["s"];

$query = "SELECT * FROM `product`";

if(!empty($txt) && $select == 0){
    $query .= " WHERE `title` LIKE '%".$txt."%'";
}else if(empty($txt) && $select != 0){
    $query .= " WHERE `category_id`='".$select."'";
}else if(!empty($txt) && $select != 0){
    $query .= " WHERE `title` LIKE '%".$txt."%' AND `category_id`='".$select."'";
}

?>

<div class="row">
    <div class="offset-lg-1 col-12 col-lg-10 text-center">
        <div class="row">

            <?php


            if ("0" != ($_POST["page"])) {
                $pageno = $_POST["page"];
            } else {
                $pageno = 1;
            }

            $product_rs = Database::search($query);
            $product_num = $product_rs->num_rows;

            $results_per_page = 5;
            $number_of_pages = ceil($product_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

            $selected_num = $selected_rs->num_rows;

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

            ?>

                <?php 

                    $image_rs = Database::search("SELECT * FROM `images` WHERE `product_id` = '".$selected_data["id"]."'");
                    $image_data = $image_rs -> fetch_assoc();
                
                ?>

                <div class="card col-6 col-lg-2 mt-2 mb-2 justify-content-center d-flex mx-auto" style="width: 18rem;">
                    <img src="<?php echo $image_data["code"] ?>" class="w-75 align-self-center">
                    <div class="card-body ms-0 m-0 text-center">
                        <h5 class="card-title"><?php echo $selected_data["title"] ?></h5>
                        <span class="card-text text-primary">Rs. <?php echo $selected_data["price"] ?>.00</span> <br>

                        <?php

                        if($selected_data["qty"]>0){

                        ?>

                            <span class="card-text text-warning fw-bold">In Stock</span>
                            <span class="card-text text-success fw-bold"><?php echo $selected_data["qty"] ?> Items Available</span> <br> <br>
                            <button class="col-12 btn btn-success">Buy Now</button>
                            <button class="col-12 btn btn-danger mt-2">Add to cart</button>

                        <?php

                        }else{

                        ?>
                            <span class="card-text text-danger fw-bold">Out of Stock</span> <br>
                            <span class="card-text text-danger fw-bold">0 items Available</span> <br><br>
                            <button class="col-12 btn btn-success disabled">Buy Now</button>
                            <button class="col-12 btn btn-danger mt-2 disabled">Add to Cart</button>

                        <?php
                        
                        }

                        ?>
                    </div>
                </div>

            <?php

            }
            ?>

            

        </div>
    </div>
    <!--  -->
    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-lg justify-content-center">
                        <li class="page-item">
                            <a class="page-link" <?php if ($pageno <= 1) {
                                                        echo ("#");
                                                    } else {
                                                    ?> onclick="basicSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                    } ?> aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php

                        for ($x = 1; $x <= $number_of_pages; $x++) {
                            if ($x == $pageno) {
                        ?>
                                <li class="page-item active">
                                    <a class="page-link" onclick="basicSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item">
                                    <a class="page-link" onclick="basicSearch(<?php echo ($x) ?>);"><?php echo $x; ?></a>
                                </li>
                        <?php
                            }
                        }

                        ?>

                        <li class="page-item">
                            <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                                        echo ("#");
                                                    } else {
                                                    ?> onclick="basicSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                    } ?> aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--  -->
</div>