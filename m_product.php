<?php include 'template_top.php';  ?>


<?php
$sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                ORDER BY product_id ASC";
$result = $con->query($sql);
while ($data = mysqli_fetch_array($result)) {
    $pid = $data['product_id'];
?>
    <!--Modal: Login / Register Form-->
    <div class="modal fade " id="modalLRForm<?php echo $data["product_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog cascading-modal modal-lg " role="document">
            <!--Content-->
            <div class="modal-content p-3">

                <div class="container h-100">
                    <div class="col-12">
                        <h2>ข้อมูลเพิ่มเติม</h2>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="h-100">
                                <img style="text-align: center;border: 3px dashed #e2e2e2;background-color: #f3f3f3;position: relative;width: 100%;object-fit: contain;height: 100%;" src="../img/upload/<?php echo $data["picture"]; ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 pb-2">
                                    <span>รหัสสินค้า : </span>
                                    <span id="m_id"><?php echo $data["product_id"]; ?></span>
                                </div>
                                <div class="col-12 pb-2">
                                    <span>ชื่อสินค้า : </span>
                                    <span id="m_name"><?php echo $data["product_name"]; ?></span>
                                </div>
                                <div class="col-12 pb-2">
                                    <span>โปรโมชั่น : </span>
                                    <span id="m_promotion"><?php echo $data["promotion_name"]; ?></span>
                                </div>
                                <div class="col-6 pb-2" style="text-decoration: line-through;">
                                    <span>ราคาเริ่มต้น : </span>
                                    <span id="m_price_start"><?php echo $data["product_price_start"]; ?></span>
                                </div>
                                <div class="col-6 pb-2" style="color: #f57224;">
                                    <span>ราคาขาย : </span>
                                    <span id="m_price_total"><?php echo $data["product_price_total"]; ?></span>
                                    <span>บาท</span>
                                </div>
                                <div class="col-12 pb-2">
                                    <span>ประเภท : </span>
                                    <span id="m_category"><?php echo $data["category_name"]; ?></span>
                                </div>
                                <div class="col-12 pb-2">
                                    <span>ภูมิภาค : </span>
                                    <span id="m_category"><?php echo $data["province_name"]; ?></span>
                                </div>
                                <div class="col-6 pb-2">
                                    <span>คงเหลือ : </span>
                                    <span id="m_qty"><?php echo $data["product_qty"]; ?></span>
                                    <span id="m_unit"><?php echo $data["unit_name"]; ?></span>
                                </div>
                                <div class="col-6 pb-2">
                                </div>
                                <div class="col-12 pb-2">
                                    <span>รายละเอียดสินค้า : </span>
                                    <div style="overflow: overlay;height: 110px;background: whitesmoke;">
                                        <span id="m_detail"><?php echo $data["product_detail"]; ?></span>
                                    </div>
                                </div>
                                <div class=" col pt-2 d-flex" style="    align-items:center">
                                </div>
                                <?php
                                $user_id = $_SESSION["user_id"];
                                $sql_fav = "SELECT * from `favorite` WHERE user_id = $user_id AND product_id = $pid";
                                $result_fav = $con->query($sql_fav);
                                $data_fav = mysqli_fetch_array($result_fav);

                                if (isset($data_fav['user_id']) != $user_id && isset($data_fav['product_id']) != $data['product_id']) {
                                ?>
                                    <div class="col-7 pt-2" style="text-align: end;">
                                        <form action="favorite.php?add_fav=<?php echo $data["product_id"]; ?>" method="post">
                                            <input id="product_id" name="product_id" value="<?php echo $data["product_id"]; ?>" hidden>
                                            <input type="submit" class="btn btn-purple" value="เพิ่มสินค้าที่ชอบ" style="border-radius: 5px;color: #fff;">
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-7 pt-2" style="text-align: end;">
                                        <form action="favorite.php?delete_id=<?php echo $data_fav["fav_id"]; ?>" method="post">
                                            <input id="product_id" name="product_id" value="<?php echo $data["product_id"]; ?>" hidden>
                                            <input type="submit" class="btn btn-danger" value="ลบสินค้าที่ชอบ" style="border-radius: 5px;color: #fff;">
                                        </form>
                                    </div>
                                <?php } ?>
                                <div class=" col-6 pt-2 d-flex" style="    align-items:center">
                                    <span>จำนวน</span>
                                    <input type="number" name="total_qty<?php echo $data['product_id']; ?>" id="total_qty<?php echo $data['product_id']; ?>" value="1" onblur="return KeyNum(this,<?php echo $data['product_qty']; ?>,<?php echo $data['product_id']; ?>)" onkeypress="return KeyNum(this,<?php echo $data['product_qty']; ?>,<?php echo $data['product_id']; ?>)" class="form-control ml-2">
                                </div>
                                <div class="col-6 pt-2" style="text-align: end;">
                                    <form action="check_qty.php" method="post">
                                        <input id="product_id" name="product_id" value="<?php echo $data["product_id"]; ?>" hidden>
                                        <input type="number" id="product_qty<?php echo $data['product_id']; ?>" name="product_qty" value="1" hidden>
                                        <input type="submit" class="btn btn-outline-success waves-effect" value="สั่งซื้อ" style="border-radius: 5px;color: #fff;">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><br>

                    <div class="mt-4">
                        <?php
                        $product_id = $data["product_id"];
                        $sql_sum = "SELECT SUM(rating) FROM `review` WHERE product_id = $product_id";
                        $result_sum = $con->query($sql_sum);
                        $data_sum = mysqli_fetch_array($result_sum);

                        $sql_count = "SELECT COUNT(product_id) FROM `review` WHERE product_id = $product_id";
                        $result_count = $con->query($sql_count);
                        $data_count = mysqli_fetch_array($result_count);

                        ?>

                        <div class="row pb-3">
                            <div class="col-12">
                                <h5>คะแนนของสินค้า</h5>
                            </div>
                            <div class="col">
                                <span id="dataReadonlyReview" style="font-size: 36px;" data-rating-stars="5" data-rating-readonly="true" data-rating-input="#dataReadonlyInput" data-rating-value="<?php if ($data_sum['SUM(rating)'] != 0 && $data_count['COUNT(product_id)'] != 0) {
                                                                                                                                                                                                        echo $data_sum['SUM(rating)'] / $data_count['COUNT(product_id)'];
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        echo 0;
                                                                                                                                                                                                    } ?>"></span>
                            </div>
                        </div>


                        <h5 class="pb-4">รายการแสดงความคิดเห็น</h5>

                        <?php
                        $product_id = $data["product_id"];
                        $sql_review = "SELECT * FROM `review` as r 
                        join `member` as m on r.user_id = m.user_id
                        WHERE product_id = $product_id ORDER BY review_date DESC";
                        $result_review = $con->query($sql_review);

                        if (mysqli_num_rows($result_review) == 0) {
                            echo "ไม่มีความคิดเห็น";
                        }

                        while ($data_review = mysqli_fetch_array($result_review)) {
                            $review_date = date_create($data_review['review_date']);

                        ?>
                            <div class="row">
                                <div class="col-12">
                                    <span style="font-size: 20px;"><?php echo $data_review["user_name"]; ?></span>
                                </div>
                                <div class="col-12 pb-2">
                                    <div id="dataReadonlyReview" data-rating-stars="5" data-rating-readonly="true" data-rating-value="<?php echo $data_review['rating'] ?>" data-rating-input="#dataReadonlyInput"></div>
                                </div>
                                <div class="col-12 pb-2">
                                    <span id="m_promotion"><?php echo $data_review["comment"]; ?></span>
                                </div>
                                <div class="col-12 pb-2 text-black-50" style="font-size: 14px;">
                                    <span id="m_id"><?php echo date_format($review_date, "d/m/y H:i:s") ?></span>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>


                    </div>

                </div>


            </div>
            <!--/.Content-->
        </div>
    </div>
    <!--Modal: Login / Register Form-->
<?php } ?>



<div class="container ">

    <form action="cart.php" method="post">

        <!-- mascord -->
        <div style="position: fixed; z-index: 50; bottom: 10px;  right: 1px;">
            <div>
                <input type="image" src="../img/data/mascord.png" alt="Submit Form" style="width: 100px;cursor:pointer;outline: none;" />
            </div>
        </div>
    </form>

    <!-- รูปภาพโชว์ -->
    <!--Carousel Wrapper-->
    <div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel">
        <!--Indicators-->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-1z" data-slide-to="1"></li>
            <li data-target="#carousel-example-1z" data-slide-to="2"></li>
        </ol>
        <!--/.Indicators-->
        <!--Slides-->
        <div class="carousel-inner" role="listbox">
            <!--First slide-->
            <div class="carousel-item active">
                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(141).jpg" alt="First slide">
            </div>
            <!--/First slide-->
            <!--Second slide-->
            <div class="carousel-item">
                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(136).jpg" alt="Second slide">
            </div>
            <!--/Second slide-->
            <!--Third slide-->
            <div class="carousel-item">
                <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(137).jpg" alt="Third slide">
            </div>
            <!--/Third slide-->
        </div>
        <!--/.Slides-->
        <!--Controls-->
        <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!--/.Controls-->
    </div>
    <!--/.Carousel Wrapper-->

    <div class="z-depth-1 p-3 mt-4">

        <div class="row m-0 ">
            <h4>สินค้าต่างๆ</h4>
        </div>
        <div class="row m-0">
            <div class="col-md-12 p-0">
                <form action="m_product.php" method="post">
                    <div class="md-form active-cyan-2 mb-3 mt-2 d-flex" style="align-items: center;">

                        <input class="col-3 m-2 form-control" type="text" name="search" placeholder="ค้นหา" aria-label="Search">

                        <select class="col-2 m-2 browser-default custom-select" name="search_category" id="search_category">
                            <option value="" selected disabled>ประเภทสินค้า</option>
                            <?php
                            include "connect.php";
                            $sql_category = "SELECT * from category order by category_id asc  ";
                            $result_category = $con->query($sql_category);
                            while ($data_category = mysqli_fetch_array($result_category)) {
                            ?>
                                <option value="<?php echo $data_category["category_id"]; ?>"><?php echo $data_category["category_name"]; ?></option>
                            <?php } ?>
                        </select>

                        <select class="col-2 m-2 browser-default custom-select" name="search_promotion" id="search_promotion">
                            <option value="" selected disabled>โปรโมชั่น</option>
                            <?php
                            include "connect.php";
                            $sql_promotion = "SELECT * from promotion order by promotion_id asc  ";
                            $result_promotion = $con->query($sql_promotion);
                            while ($data_promotion = mysqli_fetch_array($result_promotion)) {
                            ?>
                                <option value="<?php echo $data_promotion["promotion_id"]; ?>"><?php echo $data_promotion["promotion_name"]; ?></option>
                            <?php } ?>
                        </select>

                        <select class="col-2 m-2 browser-default custom-select" name="search_province" id="search_province">
                            <option value="" selected disabled>สินค้าตามภูมิภาค</option>
                            <?php
                            include "connect.php";
                            $sql_province = "SELECT * from province order by province_id asc  ";
                            $result_province = $con->query($sql_province);
                            while ($data_province = mysqli_fetch_array($result_province)) {
                            ?>
                                <option value="<?php echo $data_province["province_id"]; ?>"><?php echo $data_province["province_name"]; ?></option>
                            <?php } ?>
                        </select>

                        <button type="submit" class="btn btn-outline-primary waves-effect px-3"><i class="fas fa-search" aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row m-0">
            <?php
            $search_category = isset($_POST['search_category']) ? $_POST['search_category'] : '';
            $search_promotion = isset($_POST['search_promotion']) ? $_POST['search_promotion'] : '';
            $search_province = isset($_POST['search_province']) ? $_POST['search_province'] : '';
            $search_name = isset($_POST['search']) ? $_POST['search'] : '';
            $search_name =  trim($search_name);
            $search = "%" . $search_name . "%";


            if ($search != "" && $search_category != "" && $search_promotion != "" && $search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_name LIKE '$search' 
                AND p.category_id = $search_category
                AND p.promotion_id = $search_promotion
                AND p.province_id = $search_province
                ORDER BY product_id ASC";
            } else if ($search != "" && $search_category != "" && $search_promotion != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_name LIKE '$search' 
                AND p.category_id = $search_category
                AND p.promotion_id = $search_promotion
                ORDER BY product_id ASC";
            } else if ($search != "" && $search_category != "" && $search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_name LIKE '$search' 
                AND p.category_id = $search_category
                AND p.province_id = $search_province
                ORDER BY product_id ASC";
            } else if ($search != "" && $search_promotion != "" && $search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_name LIKE '$search'
                AND p.promotion_id = $search_promotion
                AND p.province_id = $search_province
                ORDER BY product_id ASC";
            } else if ($search != "" && $search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_name LIKE '$search'
                AND p.province_id = $search_province
                ORDER BY product_id ASC";
            } else if ($search_category != "" && $search_promotion != "" && $search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.category_id = $search_category
                AND p.promotion_id = $search_promotion
                AND p.province_id = $search_province
                ORDER BY product_id ASC";
            } else if ($search != "" && $search_category != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_name LIKE '$search'
                AND p.category_id = $search_category
                ORDER BY product_id ASC";
            } else if ($search != "" && $search_promotion != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_name LIKE '$search'
                AND p.promotion_id = $search_promotion
                ORDER BY product_id ASC";
            } else if ($search_category != "" && $search_promotion != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.category_id = $search_category
                AND p.promotion_id = $search_promotion
                ORDER BY product_id ASC";
            } else if ($search_category != "" && $search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.category_id = $search_category
                AND p.province_id = $search_province
                ORDER BY product_id ASC";
            } else if ($search_promotion != "" && $search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.promotion_id = $search_promotion
                AND p.province_id = $search_province
                ORDER BY product_id ASC";
            } else if ($search_category != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.category_id = $search_category
                ORDER BY product_id ASC";
            } else if ($search_promotion != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.promotion_id = $search_promotion
                ORDER BY product_id ASC";
            } else if ($search_province != "") {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.province_id = $search_province
                ORDER BY product_id ASC";
            } else {
                $sql = "SELECT * FROM  product AS p	
                JOIN category AS c ON p.category_id = c.category_id
                JOIN promotion AS pm ON p.promotion_id = pm.promotion_id
                JOIN unit AS u ON p.unit_id = u.unit_id
                JOIN province AS pv ON p.province_id = pv.province_id
                WHERE p.product_id LIKE '$search'  
                OR p.product_name LIKE '$search' 
                OR p.product_price_total = '$search'
                ORDER BY product_id ASC";
            }
            /* echo $sql; */
            $result = $con->query($sql);
            $i = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3 pt-2">

                    <!-- Card -->
                    <div class="card">

                        <!-- Card image -->
                        <div class="view overlay" style="height: 150px;">
                            <img class="card-img-top" style="height: 150px;    object-fit: cover;" src="../img/upload/<?php echo $data["picture"]; ?>" alt="Card image cap">
                            <a data-toggle="modal" data-target="#modalLRForm<?php echo $data["product_id"]; ?>">
                                <div class="mask rgba-white-slight"></div>
                            </a>
                        </div>

                        <!-- Card content -->
                        <div class="card-body" style="height: 215px;">

                            <!-- Title -->
                            <span class="row_select" style="font-size: 22px;"><?php echo $data["product_name"]; ?></span>
                            <!-- Text -->
                            <p class="card-text row_select"><?php echo $data["product_detail"]; ?></p>
                            <!-- Button -->
                            <div>
                                <span style="text-decoration:line-through;color:#ff4444">฿<?php echo $data["product_price_start"]; ?></span>
                                <span style="color:#616161;font-size: 12px;"> ลด <?php echo $data["promotion_discount"]; ?> %</span>

                            </div>
                            <h4 class="card-title" style="color:#00C851;">฿<?php echo $data["product_price_total"]; ?> บาท</h4>
                            <button type="button" class="btn btn-outline-info btn-rounded waves-effect" style="color: #fff;border-radius: 5px;" data-toggle="modal" data-target="#modalLRForm<?php echo $data["product_id"]; ?>">ดูเพิ่มเติม</button>


                        </div>

                    </div>
                    <!-- Card -->

                </div>
            <?php } ?>
            

        </div>

    </div>

</div>


<script>
    function KeyNum(e, qty, id) {
        var total_qty = document.getElementById('total_qty' + id);
        var product_qty = document.getElementById('product_qty' + id);

        product_qty.value = total_qty.value;

        if (total_qty.value > qty) {
            qty = parseInt(qty);
            total_qty.value = qty;
            product_qty.value = qty;
        }

        if (total_qty.value < 1) {
            total_qty.value = 1;
            product_qty.value = 1;
        }


        if (event.keyCode >= 48 && event.keyCode <= 57) //48-57(ตัวเลข)
        {
            return true;
        } else {
            return false;
        }
    }
</script>

<?php include 'template_bottom.php';  ?>