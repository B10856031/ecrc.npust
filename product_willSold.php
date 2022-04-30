<div class="col-md-2 productBlock2">
    <div class="infoBlock2">
        <?php
        if (strpos($product_willSold['PIMG'], "*") !== false) { //處理IMG字串
            $imgarr = explode("*", $product_willSold['PIMG']);
        } else {
            $imgarr = array();
            $imgarr[] = $product_willSold['PIMG'];
        }
        ?>
        <img src='<?php echo  'files/images/' . $product_willSold['PID'] . '/' . $imgarr[0]; ?>' class="img-responsive img-thumbnail imggrayw" alt="<?php echo $product_willSold['PNAME']; ?>" title="<?php echo $product_willSold['PNAME']; ?>">
        <img class="willSold" />
    </div>
    <h4>
        <?php echo $product_willSold['PNAME']; ?>
    </h4>
    <div>
        <center>將於<?php echo $product_willSold['PSTARTTIME']; ?>開始販售</center>
    </div>
</div>