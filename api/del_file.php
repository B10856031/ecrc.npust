<?php

//判別有無在登入狀態
//if(isset($_SESSION['is_login']) && $_SESSION['is_login']){

if (file_exists($_POST['file'])) {
	//若為檔案存在 就刪除
	deldir($_POST['file']);
	// unlink("../" . $_POST['file']);

	//印出yes
	echo 'yes';
} else {
	//若為不存在代表失敗
	echo '檔案不存在';
}
// }
// else
// {
// 	//若為 null 或者 false 代表失敗
// 	echo '尚未登入';	
// }
//清空資料夾函式和清空資料夾後刪除空資料夾函式的處理
function deldir($path)
{
	//如果是目錄則繼續
	if (is_dir($path)) {
		//掃描一個資料夾內的所有資料夾和檔案並返回陣列
		$p = scandir($path);
		foreach ($p as $val) {
			//排除目錄中的.和..
			if ($val != "." && $val != "..") {
				//如果是目錄則遞迴子目錄，繼續操作
				if (is_dir($path . $val)) {
					//子目錄中操作刪除資料夾和檔案
					deldir($path . $val . '/');
					//目錄清空後刪除空資料夾
					@rmdir($path . $val . '/');
				} else {
					//如果是檔案直接刪除
					unlink($path.'/'. $val);
				}
			}
		}
	}
}
