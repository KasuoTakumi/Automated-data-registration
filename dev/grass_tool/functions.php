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

function check_inputed_category($cat1 = "", $cat2 = "", $cat3 = ""){
    
    //カテゴリが入力されているか調べる
    if($cat1 != "" || $cat2 != "" || $cat3 != ""){

        //カテゴリの重複をチェック
        if($cat1 == $cat2){
            $cat2 = "";
        }
        if($cat2 == $cat3){
            $cat3 = "";
        }
        if($cat1 == $cat3){
            $cat3 = "";
        }

        $cat_array = array($cat1, $cat2, $cat3);

        //カラ配列を削除して添字を振りなおす
        $cat_array = array_filter($cat_array, "strlen");
        $cat_array = array_values($cat_array);

        return $cat_array;
    }
}

function add_product_data($product_name, $user_id, $product_id, $product_price = "0", $product_detail = "", $file_path_array, $cat_array){
    
    $dsn = get_dsn();

    //フラグを初期化（販売中）にする
    $flag = 0;
    //grass_product_listにデータを登録
    $add_product_list = $dsn->prepare('INSERT INTO `grass_product_list`(`product_id`,`name`, `price`, `flag`, `exhibitor`) VALUES (:product_id, :product_name, :product_price, :flag, :user_id)');
    $add_product_list->bindValue(':product_id', $product_id);
    $add_product_list->bindValue(':product_name', $product_name);
    $add_product_list->bindValue(':product_price', $product_price);
    $add_product_list->bindValue(':flag', $flag);
    $add_product_list->bindValue(':user_id', $user_id);
    $add_product_list->execute();


    //お気に入りと閲覧数の初期化
    $like = 0;
    $watch = 0;
    //grass_product_watchにデータを登録
    $add_product_watch = $dsn->prepare('INSERT INTO `grass_product_watch`(`product_id`, `like`, `watch`) VALUES (:product_id, :like, :watch)');
    $add_product_watch->bindValue(':product_id', $product_id);
    $add_product_watch->bindValue(':like', $like);
    $add_product_watch->bindValue(':watch', $watch);
    $add_product_watch->execute();


    //grass_product_watchにデータを登録
    $add_product_detail = $dsn->prepare('INSERT INTO `grass_product_detail`(`product_id`, `product_detail`) VALUES (:product_id, :product_detail)');
    $add_product_detail->bindValue(':product_id', $product_id);
    $add_product_detail->bindValue(':product_detail', $product_detail);
    $add_product_detail->execute();


    //cat_array配列にある数ぶんループさせる
    $cat_array_count = count($cat_array);
    for($i=0;$i<$cat_array_count;$i++){

        $cat_id = $cat_array[$i];
        //grass_product_category_listにデータを登録
        $add_product_category_list = $dsn->prepare('INSERT INTO `grass_product_category_list`(`product_id`, `category_id`) VALUES (:product_id, :cat_id)');
        $add_product_category_list->bindValue(':product_id', $product_id);
        $add_product_category_list->bindValue(':cat_id', $cat_id);
        $add_product_category_list->execute();

    }


    $file_path_array_count = count($file_path_array);
    for($i=0; $file_path_array_count>$i; $i++){
        //取得した画像パスを表示
        $add_product_img_path = $dsn->prepare('INSERT INTO `grass_product_img_path`(`product_id`, `img_path`) VALUES (:product_id, :img_path)');
        $add_product_img_path->bindValue(':product_id', $product_id);
        $add_product_img_path->bindValue(':img_path', $file_path_array[$i]);
        $add_product_img_path->execute();
    }

}

