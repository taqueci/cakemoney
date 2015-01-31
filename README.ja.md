# CakeMoney

CakeMoneyはCakePHPで作られたシンプルな家計簿です。(妻のために作りました。)

複式簿記の考え方が取り入れられています。(素人なので、何かが間違っているかもしれません。)

*Read this in other languages: [English](README.md), [日本語](README.ja.md).*


## 要件

CakeMoneyはデータベースとしてMySQLを使用します。
MySQL以外では動作しません。

あと、BoostCake, Searchプラグイン、bootstrap-datepickerを使用します。


## インストール

まずはgitでCakeMoneyのリポジトリをcloneします。

    $ git clone https://github.com/taqueci/cakemoney.git

ComposerでBoostCakeとSearchプラグインをインストールします。

    $ cd cakemoney
    $ composer install

`bootstrap-datepicker.js` をディレクトリ `webroot/js` に置きます。

以下のSQLを実行して、データベースをセットアップします。

    CREATE TABLE categories (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      account_id INT UNSIGNED NOT NULL,
      description TEXT DEFAULT NULL,
      PRIMARY KEY (id),
      UNIQUE KEY name (name)
    ) DEFAULT CHARSET=utf8;

    CREATE TABLE journals (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      date date NOT NULL,
      debit_id INT UNSIGNED NOT NULL,
      credit_id INT UNSIGNED NOT NULL,
      amount INT NOT NULL,
      description TEXT DEFAULT NULL,
      asset INT NOT NULL,
      liability INT NOT NULL,
      income INT NOT NULL,
      expense INT NOT NULL,
      equity INT NOT NULL,
      created DATETIME NOT NULL,
      modified DATETIME NOT NULL,
      PRIMARY KEY (id),
      UNIQUE KEY id (id)
    ) DEFAULT CHARSET=utf8;

最後に、CakePHPのデータベース設定ファイル `Config/database.php` を作成してください。


## 使い方

まずはカテゴリを追加してください。
ナビゲーションバーから「カテゴリ」ページを開き、右側の「新しいカテゴリ」をクリックします。
(または http://www.example.com/cakemoney/categories/add にアクセスします。)

お金のやりとりが発生したら、「仕訳帳」ページの右側にある「新しい仕訳」をクリックします。
(または http://www.example.com/cakemoney/journals/add にアクセスします。)

まとめが知りたくなったら、「レポート」ページを開いてください。


## ライセンス

[MIT](https://github.com/taqueci/cakemoney/blob/master/LICENCE)


## 作者

なかむら たけし
