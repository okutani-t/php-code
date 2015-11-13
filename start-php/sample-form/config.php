<?php

/*
 ** データベースの作成処理 **
 ** 下記はmysqlにログインして実行します **

 ** データベースの作成
   create database sample_form_db;

 ** データベースをいじるユーザーの作成→やらなくてもOK
   grant all on sample_form_db.* to dbuser@localhost identified by '********';

 ** 使うデータベースの変更
   use sample_form_db

 ** tableの作成
   create table entries (
   id int not null auto_increment primary key,
   name varchar(255),
   email varchar(255),
   memo text,
   created datetime,
   modified datetime
   );

 ** 降順で表示
   desc entries;

 */

// データベース各種設定
// これを読みこめばDBにアクセス出来る
define('DSN', 'mysql:host=localhost;dbname=sample_form_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '5gd345hsndf');

// 楽にURLを指定
define('SITE_URL', 'http://localhost/php-code/start-php/sample-form/');
define('ADMIN_URL', SITE_URL.'admin/');

// エラーをNOTICE以外出力
error_reporting(E_ALL & ~E_NOTICE);

// セッションの有効範囲
session_set_cookie_params(0, '/sample-form/');
