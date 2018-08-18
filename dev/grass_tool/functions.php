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

function generater_product_category(){

}

function generater_product_price(){

}

function generater_product_detail(){

}