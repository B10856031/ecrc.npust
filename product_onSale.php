<div class="col-md-2 productBlock">
    <div class="infoBlock" onclick="location.href='product_forEach.php?p=<?php echo $product['PID']; ?>';">
        <?php
        if (strpos($product['PIMG'], "*") !== false) { //處理IMG字串
            $imgarr = explode("*", $product['PIMG']);
        } else {
            $imgarr = array();
            $imgarr[] = $product['PIMG'];
        }
        ?>
        <img src='<?php echo  'files/images/' . $product['PID'] . '/' . $imgarr[0]; ?>' class="img-responsive img-thumbnail" alt="<?php echo $product['PNAME']; ?>" title="<?php echo $product['PNAME']; ?>">
    </div>
    <h4>
        <?php echo $product['PNAME']; ?>
    </h4>
    <div style="text-align:left; position: static; margin-left:5%; margin-right:5%;">
        <div style="flex-grow:1; width:50%; float:left; ">
            <span>$<?php echo (isset($product['PUNIT']) && $product['PUNIT'] != "***") ? ($product['PPRICE'] . ' / ' . $product['PUNIT']) : ($product['PPRICE']); ?></span>
        </div>
        <div style="width:50%; float:right; text-align: right;">剩餘數量 <?php echo $product['PQUANTITY']; ?></div>
    </div>

    <br>
    <?php array_push($decideUnique, (isset($_SESSION['login_user_id'])) ? (decide_cart_unique($_SESSION['login_user_id'], $product['PID'], 0)) : (0)); ?>
    <form style="padding-top:5%" class="buyBlock" id="postToCart<?php echo ++$count; ?>" data-id="<?php echo $product['PID']; ?>" data-quantity="<?php echo (isset($_SESSION['login_user_id'])) ? (get_cart_quantity($_SESSION['login_user_id'], $product['PID'], 0)['buyQuantity']) : (0); ?>">
        <div style="text-align:center; position: static; padding:5%;">
            <?php
            if (isset($_SESSION['login_user_id'])) {
                if (decide_cart_unique($_SESSION['login_user_id'], $product['PID'], 0) == 1) { //如果該項商品已出現於該會員之購物車中:
                    $nowCartQuantity = get_cart_quantity($_SESSION['login_user_id'], $product['PID'], 0)['buyQuantity'];
                } else {
                    $nowCartQuantity = 0;
                }
            } else {
                $nowCartQuantity = 0;
            }
            ?>
            <input type="button" class="reduce" id="minusBtn<?php echo $count; ?>" value="-" data-id="<?php echo $product['PID']; ?>">
            <input type="text" id="buyQuantityText<?php echo $count; ?>" value="0" data-id="<?php echo $product['PID']; ?>" data-maxQuantity="<?php echo $product['PQUANTITY'] - $nowCartQuantity; ?>" oninput="value=value.replace(/[^\d]/g,'')">
            <input type="button" class="add" id="plusBtn<?php echo $count; ?>" value="+" data-id="<?php echo $product['PID']; ?>" data-maxQuantity="<?php echo $product['PQUANTITY'] - $nowCartQuantity; ?>">
        </div>
        <div style="text-align:center; position: static;">
            <div style="flex-grow: 1;"><input type="hidden"></div>
            <div style="flex-grow: 1;"><input type="submit" id="addToCart<?php echo $count; ?>" value="加入購物車"></div>
            <div><input type="hidden"></div>
        </div>
    </form>
</div>