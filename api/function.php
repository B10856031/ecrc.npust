<?php
@session_start();
$_SESSION['link'] = mysqli_connect("localhost", "root", "", "farm");

//slider區塊

/**
 * 取得所有的幻燈片
 */
function get_all_slider()
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `slider` ORDER BY `SEQUENCE` ASC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得要新增之幻燈片順序
 */
function get_now_sequence()
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT `SEQUENCE` FROM `slider` ORDER BY `SEQUENCE` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    while ($row = mysqli_fetch_assoc($query)) {
      $datas[] = $row;
    }
    if ($datas) {
      $next = $datas[0];
    } else {
      $next = null;
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $next;
}

/**
 * 新增幻燈片
 */
function add_slider($IMG, $TEXT, $SEQUENCE)
{
  //宣告要回傳的結果
  $result = null;
  //新增語法
  $sql = "INSERT INTO `slider` (`IMG`, `TEXT`, `SEQUENCE`) VALUE ('{$IMG}', '{$TEXT}', '{$SEQUENCE}');";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
/**
 * 刪除幻燈片
 */
function del_slider($id)
{
  //宣告要回傳的結果
  $result = null;
  //刪除語法
  $sql = "DELETE FROM `slider` WHERE `ID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

//news區塊

/**
 * 取得所有已發布的文章
 */
function get_publish_news()
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `new` WHERE `NPUBLISH` = 1 ORDER BY `NTIME` DESC;";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得單篇文章
 */
function get_news($id)
{
  //宣告要回傳的結果
  $result = null;

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `new` WHERE `NID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
    if (mysqli_num_rows($query) == 1) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      $result = mysqli_fetch_assoc($query);
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 取得所有的文章
 */
function get_all_news()
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `new` ORDER BY `NTIME` DESC;"; // ORDER BY `create_date` DESC 代表是排序，使用 `create_date` 這欄位， DESC 是從最大到最小(最新到最舊)

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 更新文章
 */
function update_news($id, $title, $content, $publish)
{
  //宣告要回傳的結果
  $result = null;
  //建立現在的時間
  // $modify_date = date("Y-m-d H:i:s");
  //內容處理html
  // $content = htmlspecialchars($content);
  //更新語法
  $sql = "UPDATE `new` SET `NTITLE` = '{$title}', `NTEXT` = '{$content}', `NPUBLISH` = {$publish}	WHERE `NID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 刪除文章
 */
function del_news($id)
{
  //宣告要回傳的結果
  $result = null;
  //刪除語法
  $sql = "DELETE FROM `new` WHERE `NID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 新增文章
 */
function add_news($title, $content, $publish)
{
  //宣告要回傳的結果
  $result = null;
  // //建立現在的時間
  // $create_date = date("Y-m-d H:i:s");
  //內容處理html
  // $content = htmlspecialchars($content);
  // //取得登入者的id
  // $creater_id = $_SESSION['login_user_id'];
  //新增語法
  $sql = "INSERT INTO `new` (`NTITLE`, `NTEXT`, `NPUBLISH`)
  				VALUE ('{$title}', '{$content}', {$publish});";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

//product區塊

/**
 * 取得單個產品
 */
function get_product($id)
{
  //宣告要回傳的結果
  $result = null;

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` WHERE `PID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
    if (mysqli_num_rows($query) == 1) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      $result = mysqli_fetch_assoc($query);
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 取得所有指定ID的產品
 */
function find_product_byID($products)
{
  //宣告空的陣列
  $datas = array();
  foreach ($products as $product) {
    //將查詢語法當成字串，記錄在$sql變數中
    $sql = "SELECT * FROM `product` WHERE `PID` = {$product['PID']};";
    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);
    $datas[] = mysqli_fetch_assoc($query);
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  }
  //回傳結果
  return $datas;
}

/**
 * 取得所有即將販售的產品
 */
function get_all_product_willSold()
{
  //宣告空的陣列
  $datas = array();
  date_default_timezone_set('Asia/Taipei');
  $newDTime = date('Y-m-d H:i:s', time());
  $newDTime = (new DateTime($newDTime)); //當前台灣時間
  $newDTime->add(new DateInterval('P7D')); //加7天
  $newDTime  = $newDTime->format('Y-m-d\TH:i');

  $nowDTime = date('Y-m-d H:i:s', time());
  $nowDTime = (new DateTime($nowDTime))->format('Y-m-d\TH:i'); //當前台灣時間

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` WHERE `PENDTIME` > '{$newDTime}' AND `PSTARTTIME` < '{$newDTime}' AND `PSTARTTIME` > '{$nowDTime}'  ORDER BY `PSOLD` DESC,`PUPDATATIME` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得所有於販賣期間售完的產品
 */
function get_all_product_soldOut()
{
  //宣告空的陣列
  $datas = array();
  date_default_timezone_set('Asia/Taipei');
  $newDTime = date('Y-m-d H:i:s', time());
  $newDTime = (new DateTime($newDTime))->format('Y-m-d\TH:i'); //當前台灣時間
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` WHERE `PQUANTITY`=0 AND `PENDTIME` >= '{$newDTime}' AND `PSTARTTIME` <= '{$newDTime}' ORDER BY `PSOLD` DESC,`PUPDATATIME` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得所有販賣中的產品
 */
function get_all_product_onSale()
{
  //宣告空的陣列
  $datas = array();
  date_default_timezone_set('Asia/Taipei');
  $newDTime = date('Y-m-d H:i:s', time());
  $newDTime = (new DateTime($newDTime))->format('Y-m-d\TH:i'); //當前台灣時間
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` WHERE `PQUANTITY`!=0 AND `PENDTIME` >= '{$newDTime}' AND `PSTARTTIME` <= '{$newDTime}' ORDER BY `PSOLD` DESC,`PUPDATATIME` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得所有的產品
 */
function get_all_product()
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` ORDER BY `PSOLD` DESC,`PUPDATATIME` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得熱銷產品
 */
function get_hot_product($count)
{
  //宣告空的陣列
  $datas = array();
  date_default_timezone_set('Asia/Taipei');
  $newDTime = date('Y-m-d H:i:s', time());
  $newDTime = (new DateTime($newDTime))->format('Y-m-d\TH:i'); //當前台灣時間
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` where PQUANTITY > 0 and '$newDTime' < PENDTIME AND '$newDTime' > PSTARTTIME ORDER BY `PSOLD` DESC,`PUPDATATIME` DESC ;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $count -= 1;
        $datas[] = $row;
        if ($count == 0) {
          break;
        }
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得特價產品
 */
function get_specialOffer_product()
{
  //宣告空的陣列
  $datas = array();
  date_default_timezone_set('Asia/Taipei');
  $newDTime = date('Y-m-d H:i:s', time());
  $newDTime = (new DateTime($newDTime))->format('Y-m-d\TH:i'); //當前台灣時間
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` where PSTYPE = '2' AND PQUANTITY > 0 and '$newDTime' < PENDTIME AND '$newDTime' > PSTARTTIME ORDER BY `PSOLD` DESC,`PUPDATATIME` DESC ;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 取得季節限定商品
 */
function get_seasonLimited_product($count)
{
  //宣告空的陣列
  $datas = array();
  date_default_timezone_set('Asia/Taipei');
  $newDTime = date('Y-m-d H:i:s', time());
  $newDTime = (new DateTime($newDTime))->format('Y-m-d\TH:i'); //當前台灣時間
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` where PSTYPE = '3' AND PQUANTITY > 0 and '$newDTime' < PENDTIME AND '$newDTime' > PSTARTTIME ORDER BY `PSOLD` DESC,`PUPDATATIME` DESC ;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $count -= 1;
        $datas[] = $row;
        if ($count == 0) {
          break;
        }
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 新增產品
 */
function add_product($name, $text, $price, $unit, $quantity, $startTime, $endTime, $type, $stype, $images)
{
  //宣告要回傳的結果
  $result = null;
  // $content = htmlspecialchars($content);
  $id = dataSheet_get('product', 'order by PID DESC limit 1')[0]['PID'] + 1;
  // $image_path=$images;//資料夾名稱(PID)*圖片名稱*圖片名稱*圖片名稱...
  //新增語法
  $sql = "INSERT INTO `product` (`PID`,`PNAME`, `PTEXT`, `PIMG`, `PPRICE`,`PUNIT`, `PQUANTITY`,`PTYPE`,`PSTYPE`, `PSTARTTIME`, `PENDTIME`)
  				VALUE ({$id},'{$name}', '{$text}', '{$images}', {$price}, '{$unit}', {$quantity}, {$type}, {$stype}, '{$startTime}', '{$endTime}');";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = $id;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 更新產品
 */
function update_product($id, $name, $text, $price, $unit, $quantity, $startTime, $endTime, $type, $stype, $image_path)
{
  //宣告要回傳的結果
  $result = null;

  $sql = "UPDATE `product` SET `PNAME`='{$name}', `PTEXT`='{$text}', `PIMG`='{$image_path}', `PPRICE`={$price}, `PUNIT`='{$unit}', `PQUANTITY`={$quantity},`PTYPE`={$type},`PSTYPE`={$stype}, `PSTARTTIME`='{$startTime}', `PENDTIME`='{$endTime}' WHERE `PID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 刪除產品
 */
function del_product($id)
{
  //宣告要回傳的結果
  $result = null;
  //刪除語法
  $sql = "DELETE FROM `product` WHERE `PID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 檢查products(array)中的產品數量是否>=購物車中產品數量
 */
function check_product_quantity($UID, $STATE)
{
  $products = get_cart_product($UID, $STATE);
  //將查詢語法當成字串，記錄在$sql變數中
  foreach ($products as $product) {
    $sql = "SELECT `buyQuantity` FROM `cart` WHERE `PID` = {$product['PID']} AND `UID` = {$UID} AND `STATE` = {$STATE};";
    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);
    $buyQuantity = mysqli_fetch_assoc($query);
    // $_SESSION['bQ']=$buyQuantity['buyQuantity'];//測試用
    // $_SESSION['pQ']=$product['PQUANTITY'];
    if (intval($product['PQUANTITY']) < intval($buyQuantity['buyQuantity']) || intval($buyQuantity['buyQuantity']) <= 0) {
      return FALSE;
    }
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  }

  //回傳結果
  return true;
}

/**
 * 檢查products(array)中的產品數量是否>=購物車中產品數量
 */
function check_product_quantity_manager($PID, $latest_buyQuantity, $STATE)
{
  $quantity = get_product($PID)['PQUANTITY']; //當前商品庫存

  if (intval($quantity) < intval($latest_buyQuantity)) {
    return FALSE;
  }
  //回傳結果
  return true;
}

//user區塊

// /**
//  * 透過UID，獲取會員資料
// */
// function find_user_byUID($UID)
// {
//     //宣告要回傳的結果
//     $datas = array();

//     //將查詢語法當成字串，記錄在$sql變數中
//     $sql = "SELECT * FROM `user` WHERE `UID` = {$UID};";

//     //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
//     $query = mysqli_query($_SESSION['link'], $sql);

//   //如果請求成功
//   if ($query)
//   {
//     //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
//     if (mysqli_num_rows($query) > 0)
//     {
//       //取得的量大於0代表有資料
//       //while迴圈會根據查詢筆數，決定跑的次數
//       //mysqli_fetch_assoc 方法取得 一筆值
//       while ($row = mysqli_fetch_assoc($query))
//       {
//         $datas[] = $row;
//       }
//     }

//     //釋放資料庫查詢到的記憶體
//     mysqli_free_result($query);
//   }
//   else
//   {
//     echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
//   }

//   //回傳結果
//   return $datas;
// }

/**
 * 檢查資料庫有無該使用者名稱
 */
function check_has_account($account)
{
  //宣告要回傳的結果
  $result = null;

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `user` WHERE `UACCOUNT` = '{$account}';";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
    if (mysqli_num_rows($query) >= 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 註冊
 */
function add_user($account, $password, $name, $gender, $phone, $mail)
{
  //宣告要回傳的結果
  $result = null;
  //先把密碼用md5加密
  $password = md5($password);
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "INSERT INTO `user` (`UACCOUNT`, `UPASS`, `UNAME`, `UGENDER`, `UPHONE`, `UEMAIL`) VALUE ('{$account}', '{$password}', '{$name}', {$gender}, '{$phone}', '{$mail}');";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
/**
 * 登入檢查
 */
function verify_user($account, $password)
{
  //宣告要回傳的結果
  $result = null;
  //先把密碼用md5加密
  $password = md5($password);
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `user` WHERE `UACCOUNT` = '{$account}' and `UPASS` = '{$password}'";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
  $_SESSION['login_user_root'] = null;
  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 回傳 $query 請求的結果數量有幾筆，為一筆代表找到會員且密碼正確。
    $numrow = mysqli_num_rows($query);
    //取得使用者資料
    $user = mysqli_fetch_assoc($query);
    $_SESSION['login_user_root'] = $user['UROOT'];
    if ($numrow == 1 && $user['UROOT'] == 0) {


      //在session裡設定 is_login 並給 true 值，代表已經登入
      $_SESSION['is_login'] = TRUE;
      //紀錄登入者的id，之後若要隨時取得使用者資料時，可以透過 $_SESSION['login_user_id'] 取用
      $_SESSION['login_user_id'] = $user['UID'];

      //回傳的 $result 就給 true 代表驗證成功
      $result = true;
    } else if ($numrow == 1 && $user['UROOT'] == 1) {

      //在session裡設定 is_login 並給 true 值，代表已經登入
      $_SESSION['is_login_manager'] = TRUE;
      //紀錄登入者的id，之後若要隨時取得使用者資料時，可以透過 $_SESSION['login_user_id'] 取用
      $_SESSION['login_manager_id'] = $user['UID'];
      //回傳的 $result 就給 true 代表驗證成功
      $result = true;
    }
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }
  //回傳結果
  return $result;
}

/**
 * 取得所有user個資
 */

function find_user_all()
{

  $datas = array();
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `user` WHERE `UROOT`=0";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}


/**
 * 刪除會員
 */
function del_user($id)
{
  //宣告要回傳的結果
  $result = null;
  //刪除語法
  $sql = "DELETE FROM `user` WHERE `UID` = {$id};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}


/**
 * 透過UID 取得user個資
 */

function find_user_byUID($UID)
{


  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `user` WHERE `UID` = {$UID}";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    $datas = mysqli_fetch_assoc($query);
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 更新會員資料
 */
function update_user($UID, $UACCOUNT, $UPASS, $UNAME, $UGENDER, $UPHONE, $UEMAIL)
{
  //宣告要回傳的結果
  $result = null;

  $sql = "UPDATE `user` SET `UACCOUNT`='{$UACCOUNT}',`UPASS`='{$UPASS}',`UNAME`='{$UNAME}',`UGENDER`={$UGENDER},`UPHONE`='{$UPHONE}',`UEMAIL`='{$UEMAIL}' WHERE `UID` = $UID;";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}


//cart區塊

/**
 * 取得所有會員購物車中的產品
 */
function get_user_inOrder($STATE)
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `cart` WHERE `STATE`={$STATE} ORDER BY `CUPDATATIME` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  return $datas;
}


/**
 * 獲得購物車中，所有該使用者已送出、待確認之訂單
 */
function get_cart_order($UID, $STATE)
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `cart` WHERE `STATE`= {$STATE} AND `UID`= {$UID} ORDER BY `CUPDATATIME` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
    }
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }
  //回傳結果
  return $datas;
}


/**
 * 取得所有當前使用者cart的購買數量資料
 */
function get_cart_quantity($UID, $PID, $STATE)
{

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT `buyQuantity` FROM `cart` WHERE `UID`= {$UID} AND `PID`= {$PID} AND `STATE`={$STATE};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 透過UID取得所有當前使用者購物車中的產品
 */
function get_cart_product($UID, $STATE)
{
  //宣告空的陣列
  $datas = array();

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `cart` WHERE `UID`= {$UID} AND `STATE`= {$STATE} ORDER BY `CID` DESC;"; // ORDER BY代表排序

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas[] = $row;
      }
      $datas = find_product_byID($datas);
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 新增商品至個人購物車
 */
function add_cart($UID, $PID, $buyQuantity)
{
  //宣告要回傳的結果
  $result = null;
  $sql = "INSERT INTO `cart` (`UID`, `PID`, `buyQuantity`)
    VALUE ('{$UID}', '{$PID}', {$buyQuantity});";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 透過PID取得一筆當前使用者購物車中的資料
 */
function get_product_byPID($PID)
{
  //宣告空的陣列
  $datas = array();
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `product` WHERE `PID`= {$PID};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query)) {
        $datas = $row;
      }
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $datas;
}

/**
 * 更新個人購物車商品數量
 */
function update_cart($UID, $PID, $buyQuantity, $STATE)
{
  //宣告要回傳的結果
  $result = null;

  $sql = "UPDATE `cart` SET `buyQuantity`={$buyQuantity} WHERE `UID` = {$UID} AND `PID` = {$PID} AND `STATE` ={$STATE};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 刪除個人購物車商品
 */
function del_cart($UID, $PID, $STATE)
{
  //宣告要回傳的結果
  $result = null;
  //刪除語法
  $sql = "DELETE FROM `cart` WHERE `UID` = {$UID} AND `PID` = {$PID} AND `STATE` = {$STATE};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

function decide_cart_unique($UID, $PID, $STATE)
{
  //宣告要回傳的結果
  $result = 0;
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `cart` WHERE `UID` = {$UID} and `PID` = {$PID} AND `STATE` = {$STATE};";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
  //如果請求成功
  if ($query) {
    //使用 mysqli_num_rows 回傳 $query 請求的結果數量有幾筆
    if (mysqli_num_rows($query) == 1) {
      $result = 1;
    }
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

//透過UID 令購物車內，該使用者所選購的產品狀態改為"已送出"
function checkOut_cart($UID, $STATE)
{
  //宣告要回傳的結果
  $result = null;


  $sql2 = "SELECT * FROM `cart` WHERE `UID`= {$UID} AND `STATE`= {$STATE};";
  $query2 = mysqli_query($_SESSION['link'], $sql2);
  $datas = array();
  //如果請求成功
  if ($query2) {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否大於0
    if (mysqli_num_rows($query2) > 0) {
      //取得的量大於0代表有資料
      //while迴圈會根據查詢筆數，決定跑的次數
      //mysqli_fetch_assoc 方法取得 一筆值
      while ($row = mysqli_fetch_assoc($query2)) {
        $datas[] = $row;
      }

      sold_product($datas, $UID);

      foreach ($datas as $data) {
        $isUnique = decide_cart_unique($UID, $data['PID'], 1); //1=有重複 0=無重複
        if ($isUnique == 1) { //如果該會員的待確認訂單中有該項產品，進行以下動作
          $buyQuantity = $data['buyQuantity'] + get_cart_quantity($UID, $data['PID'], 1)['buyQuantity'];
          $sql3 = "UPDATE `cart` SET `buyQuantity`={$buyQuantity} WHERE `UID` = {$UID} AND `PID`={$data['PID']} AND `STATE`=1;";
          //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
          $query3 = mysqli_query($_SESSION['link'], $sql3);
          del_cart($UID, $data['PID'], 0);
        }
      }
      $sql = "UPDATE `cart` SET `STATE`=1 WHERE `UID` = {$UID} AND `STATE`=0;";
      //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
      $query = mysqli_query($_SESSION['link'], $sql);
    }
    $result = true;
    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query2);
  } else {
    echo "{$sql2} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    $result = false;
  }
  //回傳結果
  return $result;
}

//透過UID 令該使用者所選購的產品狀態改為"完成訂單"
function checkOut_cart_manager($UID, $STATE)
{
  //宣告要回傳的結果
  $result = false;
  $sql = "UPDATE `cart` SET `STATE`=2 WHERE `UID` = {$UID} AND `STATE`={$STATE};";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
  //如果請求成功
  if ($query) {
    $result = true;
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }
  //回傳結果
  return $result;
}

//產品賣出時之動作與判斷
function sold_product($products, $UID)
{
  foreach ($products as $product) {
    $PID = $product['PID'];
    $buyQuantity = $product['buyQuantity'];
    $PSOLD = get_product_byPID($PID)['PSOLD'] + $buyQuantity;
    $PQUANTITY = get_product_byPID($PID)['PQUANTITY'] - $buyQuantity;
    $sql = "UPDATE `product` SET `PSOLD`={$PSOLD},`PQUANTITY`={$PQUANTITY} WHERE `PID` = {$PID};";
    //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
    $query = mysqli_query($_SESSION['link'], $sql);
  }
}

//管理者編輯訂單時，產品數量變更
function change_product_quantity($PID, $origin_buyQuantity, $latest_buyQuantity)
{
  //宣告要回傳的結果
  $result = null;
  $change_buyQuantity = intval($latest_buyQuantity) - intval($origin_buyQuantity); //產品購買數量異動量
  $PSOLD = intval(get_product($PID)['PSOLD']) + intval($change_buyQuantity);
  $PQUANTITY = intval(get_product($PID)['PQUANTITY']) - intval($change_buyQuantity);
  $sql = "UPDATE `product` SET `PSOLD`={$PSOLD},`PQUANTITY`={$PQUANTITY} WHERE `PID` = {$PID};";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
  //如果請求成功
  if ($query) {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }
  } else {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/*
* 以下為通用CRUD區塊
*/

//新增表單資料         ( 表單名稱 , 表單欄位名稱,想新增的值)
function dataSheet_add($sheetName, $fieldNames, $values)
{
  $result = null;
  $sql = "INSERT INTO `$sheetName` $fieldNames VALUE $values;";
  $query = mysqli_query($_SESSION['link'], $sql);
  if ($query) {
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      $result = true;
    }
  }
  return $result;
}

//刪除表單資料         ( 表單名稱 , 表單主鍵值)
function dataSheet_del($sheetName, $id)
{
  $result = null;
  $sql = "DELETE from `$sheetName` where `id` = {$id};";
  $query = mysqli_query($_SESSION['link'], $sql);
  if ($query) {
    if (mysqli_affected_rows($_SESSION['link']) == 1) {
      $result = true;
    }
  }
  return $result;
}

//查詢表單資料         ( 表單名稱 , 其他搜尋相關設定)
function dataSheet_get($sheetName, $ortherSettings = '')
{
  $datas = array();
  if ($ortherSettings) {
    //獲取想要表單之'想搜尋'資料
    $sql = " SELECT * from $sheetName $ortherSettings ";
  } else {
    //獲取想要表單之'所有'資料
    $sql = " SELECT * from $sheetName ";
  }
  $result = mysqli_query($_SESSION['link'], $sql);
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $datas[] = $row;
    }
    mysqli_free_result($result);
  } else {
    return false;
  }
  return $datas;
}

//更新、修改表單資料      ( 表單名稱  , 表單主鍵值 ,想更新的表單欄位,更新筆數限制檢查)
function dataSheet_update($sheetName, $SETsection, $WHEREsection, $updateLimit = '')
{
  //宣告要回傳的結果
  $result = null;

  $sql = "UPDATE $sheetName SET $SETsection WHERE $WHEREsection;";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query) {
    if (!$updateLimit) {
      $result = true;
    } else {
      //使用mysqli_affected_rows判別異動的資料是否 = $updateLimit
      if (mysqli_affected_rows($_SESSION['link']) == $updateLimit) {
        $result = true;
      }
    }
  }
  return $result;
}
