<?php

include_once('./functions.php');

$html = file_get_contents('./index.html');

//登録させる件数
@$add_count = $_POST['max_value'];
$product_name_array = array();
$f = fopen("./csv/data.csv", "r");
$i = 0;
while($line = fgetcsv($f)){
    array_push($product_name_array,$line);
    $i +=1;
}
// test.csvを閉じます。
fclose($f);

var_dump($product_name_array);
//登録させる件数が正しく入力されている場合には登録処理を実行させる
if(isset($add_count)){
    if($add_count>0){
        echo'hello';
    }
}

echo $html;