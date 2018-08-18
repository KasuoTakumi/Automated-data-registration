<?php


function get_dsn(){
//初期化
    static $dsn = null;
    //すでに読み込んでいる場合には処理をスキップ
    if ($dsn === null) {
        //MySQL Login information
        $db_user = "grass_account";
        $db_pass = "Ljf2;fq2Jfoa1hfal1m.z01";
        $db_host = "localhost";
        $db_name = "grass";
        $db_type = "mysql";
        
        //データソースネームを使って接続
        $dsn = new PDO("$db_type:hots=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    }
    return $dsn;
}

function generat_demo_data($add_loop){

    $product_array_data = generat_product_name();

    for($i=0;$i<$add_loop;$i++){
        $product_rand = rand(0,309);
        $product_name = $product_array_data[0][$product_rand];
        $product_price = rand(300,100000);
        $category_id = generat_category(rand(0,3));
        $user_id = 'KasuoTakumi';
        $product_id = uniqid(rand());
        $product_detail = '商品の状態です。商品の状態です。商品の状態です。';
        $file_path_array = array('./dir/16289003725b7379633797d/60d4cfcc51fc4ef5673059a2a1d93049.jpg');
        $cat_array = generat_category(rand(0,3));
        add_product_data($product_name, $user_id, $product_id, $product_price, $product_detail, $file_path_array, $cat_array);
    }

}

function generat_product_name(){
    
    //商品名の配列
    $product_name_array = array();

    $f = fopen("./csv/data.csv", "r");
    $i = 0;
    while($line = fgetcsv($f)){
        array_push($product_name_array,$line);
        $i +=1;
    }
    // data.csvを閉じます。
    fclose($f);

    return $product_name_array;
}

function generat_category($loop){

    $cat_array = array();
    for($i=0; $i>$loop; $i++){
        array_push($cat_array,rand(0,10));
    }
    return $cat_array;

}

function generater_product_detail(){

}