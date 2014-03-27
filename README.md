ITC [![Build Status](https://travis-ci.org/app2641/ITC.svg?branch=develop)](https://travis-ci.org/app2641/ITC) [![Coverage Status](https://coveralls.io/repos/app2641/ITC/badge.png?branch=develop)](https://coveralls.io/r/app2641/ITC?branch=develop)
=======
---------------------------------------------
ITC は、[IT勉強会カレンダー](https://www.google.com/calendar/embed?src=fvijvohm91uifvd9hratehf65k@group.calendar.google.com)の新着情報を Amazon S3 へ JSON 化して保存するツールです。  
JSON データを他のアプリから参照して遊んだり出来ます。


### セットアップ
#### composer
composer で必要なライブラリをインストールします。

* Composer
    * AWS SDK PHP2

```
$ composer.phar install
```

#### AWS
S3 に SDK から接続するための設定を行います。

```
$ cp data/config/aws.ini.orig data/config/aws.ini
```
コピーした Ini ファイルを開いて必要項目を記載します。


#### データベース
データベースに接続するための設定を行います。

```
$ cp data/config/database.ini.orig data/config/database.ini
```
コピーした Ini ファイルを開いて必要項目を記載します。


### 使い方
bin ディレクトリに入っている run コマンドを実行します。
run を実行すると IT 勉強会の新着情報が Json データとして S3 の指定パスに保存されます。

```
$ bin/run
```