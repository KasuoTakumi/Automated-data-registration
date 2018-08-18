<?php

include_once('./functions.php');

$html = file_get_contents('./index.html');

@$add_count = $_POST['max_value'];

//登録させる件数が正しく入力されている場合には登録処理を実行させる
if(isset($add_count)){
    echo'true';
    if($add_count>0){
        echo'true';
        generat_demo_data($add_count);
        $add_count = '';
    }else{
        echo'false';
    }
}else{
    echo'false';
}

echo $html;