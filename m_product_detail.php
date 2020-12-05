<?php include 'template_top.php';  ?>

<div class="container ">

    <form action="cart.php" method="post">

        <!-- mascord -->
        <div style="position: fixed; z-index: 50; bottom: 10px;  right: 1px;">
            <div>
                <input type="image" src="../img/data/mascord.png" alt="Submit Form" style="width: 100px;cursor:pointer;outline: none;" />
            </div>
        </div>
    </form>

    <div class="z-depth-1 p-3 mt-4">
        <div class="row m-0 ">
            <h4>รายละเอียดสินค้า</h4>
        </div>

        <div class="row m-0">
            <?php
            $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
            $sql = "SELECT * from  product as p	
            join category as c on p.category_id = c.category_id
            join promotion as pm on p.promotion_id = pm.promotion_id
            join unit as u on p.unit_id = u.unit_id            
            where product_id = $product_id
            ORDER BY product_id ASC";
            $result = $con->query($sql);
            $i = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <div class="mt-4">

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
                                <div class="col-6 pt-2 d-flex" style="align-items:center">
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
                    </div>
                </div>

        </div>
    <?php } ?>

    <div class="mt-4">
        <?php
        $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';

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
                <span id="dataReadonlyReview" style="font-size: 36px;" data-rating-stars="5" data-rating-readonly="true" data-rating-input="#dataReadonlyInput"
                data-rating-value="<?php if ($data_sum['SUM(rating)'] != 0 && $data_count['COUNT(product_id)'] != 0) {
                                        echo $data_sum['SUM(rating)'] / $data_count['COUNT(product_id)'];
                                    }else {
                                        echo 0;
                                    } ?>"></span>
            </div>
        </div>


        <h5 class="pb-4">รายการแสดงความคิดเห็น</h5>

        <?php
        $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
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

    function review() {
        $("#review").rating({
            "value": 2,
            "click": function(e) {
                console.log(e);
                $("#starsInput").val(e.stars);
            }
        });
    }

    function review() {
        $("#review").rating({
            "value": 2,
            "click": function(e) {
                console.log(e);
                $("#starsInput").val(e.stars);
            }
        });
    }
</script>

<?php include 'template_bottom.php';  ?>