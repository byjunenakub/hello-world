<?php include 'template_top.php';  ?>

<div class="container z-depth-1 m_container" data-aos="fade-right">
    <div class="mt-2">

        <div class="row m-0 mt-2">
            <h4>สินค้าที่ชอบ</h4>
        </div>

        <div class="row m-0 mt-4">
            <table class="table table-striped z-depth-1">
                <thead class="info-color">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">สินค้า</th>
                        <th scope="col">รายละเอียดสินค้า</th>
                        <th scope="col">ราคาเริ่มต้น</th>
                        <th scope="col">ราคาขาย</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION["user_id"];

                    $sql = "SELECT * from `favorite` as f 
                            join `product` as p on f.product_id = p.product_id 
                            WHERE user_id = $user_id
                            ORDER BY fav_id ASC";
                    $result = $con->query($sql);

                    $i = 1;
                    while ($datarow = mysqli_fetch_array($result)) {

                    ?>

                        <tr>
                            <th><?php echo $i; ?></th>
                            <th hidden><?php echo $datarow['fav_id']; ?></th>
                            <td style="width: 180px; height: 180px;">
                                <img src="../img/upload/<?php echo $datarow["picture"]; ?>" style=" object-fit: cover;" class="w-100 h-100" alt="">
                            </td>
                            <td><?php echo     $datarow["product_name"]; ?></td>
                            <td><?php echo     $datarow["product_detail"]; ?></td>
                            <td><?php echo     $datarow["product_price_start"]; ?></td>
                            <td><?php echo     $datarow["product_price_total"]; ?></td>
                            <td style="width:30%">
                                <a href="favorite.php?delete_id=<?php echo $datarow["fav_id"]; ?>" class="btn btn-danger m-0">ลบออกจากสินค้าที่ชอบ</a>
                                <a href="m_product_detail.php?product_id=<?php echo $datarow["product_id"]; ?>" class="btn btn-success m-0" target="_blank">ซื้อสินค้า</a>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
        <div class="col">
            <?php if (mysqli_num_rows($result) == 0) {
                echo "ยังไม่มีสินค้าที่ชอบ";
            } ?>
        </div>
    </div>
</div>

<script>
    var btn_bill = document.getElementById('btn_bill');
    var payment = document.getElementById('payment');
    var bank = document.getElementById('bank');
    var Payapl = document.getElementById('Payapl');
    var Fbank = document.getElementById('Fbank');
    var FPayapl = document.getElementById('FPayapl');

    btn_bill.onclick = function() {
        btn_bill.hidden = true;
        payment.hidden = !payment.hidden;
        FPayapl.hidden = true;
    }

    bank.onclick = function() {
        Fbank.hidden = false;
        FPayapl.hidden = true;
    }
    Payapl.onclick = function() {
        FPayapl.hidden = false;
        Fbank.hidden = true;
    }



    function readURL(input) {
        // var picz = [];
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function(e) {
                // picz.push(e.target.result);
                document.getElementById('icon').style = "display:none";
                document.getElementById('show_img').style = "display:block";
                document.getElementById('show_img').src = e.target.result;
                document.getElementById('close').style = "display:block;    color: #e9ecef;";
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function delete_pic() {
        document.getElementById('show_img').style = "display:none";
        document.getElementById('icon').style = "display:block";
        document.getElementById('close').style = "display:none";
        // document.getElementById('show').src ="";
        picz = null;
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