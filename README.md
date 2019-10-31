動作確認環境: Mac OSX, Apache 2.4.10


# VirtualHost Hack

Web開発をしていて、ローカルのApache内でサイトごとにDocumentRootを持たせたい時、それぞれのサイトにポートを割り当てて運用することがあります。

**こんなケース**
```
Listen 12345
<VirtualHost *:12345>
  DocumentRoot /path/to/public_html
</VirtualHost>
```

```
http://127.0.0.1:12345/ にアクセス
```

通常この設定を行う場合、毎回httpd.conf(もしくは別のconfファイル)に上記を追記し、Apacheを再起動することになります。
vhh(VirtualHost Hack)を使うと、この一連の流れを無くして、ブラウザ上のインターフェースから自動で環境を構築することができるようになります。


## vhhのセットアップ

### ツールの取得と配置

```
$ mkdir /var/vhh
$ chmod 777 /var/vhh
$ git clone https://github.com/neco-tech/vhh.git /var/vhh
```

### Apacheの初期設定、再起動

/var/vhh/httpd-conf/ にApache用のconfファイルがあるので、これをhttpd.confから読み込みます。  
※デフォルトでは、10サイトの作成のみ有効になっています。  
※10個以上のサイトを作成する場合は、vhh.conf内を参照してコメントアウトを外してください。


```
Include /var/vhh/httpd-conf/vhh.conf
```

```
$ sudo apachectl configtest
```

この時、各ポートに割り当てられたDocumentRootが存在しないというWarningが出ますが、無視します。

```
$ sudo apachectl restart
もしくは
$ sudo systemctl restart httpd
など
```

### ブラウザからvhh Managerへアクセス

http://127.0.0.1:60000

サイト名とディレクトリ名を入力し[作成]ボタンを押すと、DocumentRootが作成されてポートが自動的に割り当てられます。


#### ホスト名での制限

どんなホスト名でアクセスしても**vhh Manager**は表示されますが、*127.0.0.1:60000*及び*localhost:60000*でアクセスした場合のみ、サイトの作成/削除が可能です。
例えば*192.168.1.{N}:60000*や、ローカルDNS経由でホスト名を指定してアクセスした場合、作成したサイトの一覧のみが表示されます。

---

## DocumentRootの場所

/var/vhh/sites/ 以下


## Apacheのログの場所

/var/vhh/logs/ 以下

---

## 注意点1
vhhは、**ローカルでの開発環境のみを想定したツールです**。  
本運用、ネットに公開される環境での使用は想定していません。

## 注意点2

vhhは、ポート番号60000以降を**占有します**。  
使用するポート番号を変更したい場合は、下記ファイルの該当箇所を変更してください。

- /var/vhh/manager/index.php
- /var/vhh/manager/functions.php
- /var/vhh/manager/views/index.php
- /var/vhh/httpd-conf/vhh.conf

---

## /var/vhh/以外のディレクトリにセットアップしたい場合

下記ファイルの該当箇所を変更してください。

- httpd-conf/vhh.conf
- httpd-conf/vhh-base.conf
