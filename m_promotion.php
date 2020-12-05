<?php include 'template_top.php';  ?>

<div class="container z-depth-1 m_container" data-aos="fade-right">
    <div class="row m-0">
        <div class="col-12" style="text-align-last: end;">
            <button type="button" class="btn btn-success"><i class="fas fa-plus pr-2" aria-hidden="true"></i> <span>เพิ่ม</span> </button>
        </div>
    </div>
    <div class="row m-0 pt-2">
        <div>
            <h4>จัดการโปรโมชั่น</h4>
        </div>
        <table class="table table-striped z-depth-1">
            <thead class="info-color">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">รหัสประเภทสินค้า</th>
                    <th scope="col">ชื่อประเภทสินค้า</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php for($i=1 ; $i < 10; $i++){

                    ?>
                    <th ><?php echo $i; ?></th>
                    <td>test</td>
                    <td>test</td>
                    <td scope="row">
                    <button type="button" class="btn  btn-sm m-0  amber darken-1" style="color: #fff;">แก้ไข</button>
                    <button type="button" class="btn  btn-sm m-0 danger-color-dark" style="color: #fff;">ลบ</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>


    </div>

    <div>




    </div>


</div>

<?php include 'template_bottom.php';  ?>