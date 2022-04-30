<div class="col-md-2 productBlock2">
    <div class="infoBlock2">
        <?php
        if (strpos($product_soldOut['PIMG'], "*") !== false) { //處理IMG字串
            $imgarr = explode("*", $product_soldOut['PIMG']);
        } else {
            $imgarr = array();
            $imgarr[] = $product_soldOut['PIMG'];
        }
        ?>
        <img src='<?php echo  'files/images/' . $product_soldOut['PID'] . '/' . $imgarr[0]; ?>' class="img-responsive img-thumbnail imggray" alt="<?php echo $product_soldOut['PNAME']; ?>" title="<?php echo $product_soldOut['PNAME']; ?>">
        <img class="soldOut" />
    </div>
    <h4>
        <?php echo $product_soldOut['PNAME']; ?>
    </h4>
    <div style="text-align:left; position: static; margin-left:5%; margin-right:5%;">
        <div style="flex-grow:1; width:50%; float:left; ">
            <span>$<?php echo (isset($product['PUNIT']) && $product['PUNIT'] != "***") ? ($product['PPRICE'] . ' / ' . $product['PUNIT']) : ($product['PPRICE']); ?></span>
        </div>
        <div style="width:50%; float:right; text-align: right;">剩餘數量 <?php echo $product_soldOut['PQUANTITY']; ?></div>
    </div>
</div>