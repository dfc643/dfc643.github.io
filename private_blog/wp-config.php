<?php
/**
 * The base configurations of the WordPress.
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、言語、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86 
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 *
 * @package WordPress
 */

// 注意: 
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - こちらの情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'fh1334em_mysql');


/** MySQL データベースのユーザー名 */
define('DB_USER', 'fcsys');


/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'fcsys');


/** MySQL のホスト名 */
define('DB_HOST', '127.0.0.1');


/** データベースのテーブルを作成する際のデータベースのキャラクターセット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'IW-Ribtpfc:I|RZrnr?*B8U7E#XM& 6t#YSf:A r<}bwQQ %V36;55+l-{,SBDb_');

define('SECURE_AUTH_KEY',  'Cki-=>>bG:SW5]>CqI`OZ+uk(GHT=eU%CJE.S~RsMLCSH{o1R;s4+dgXO%T80U.!');

define('LOGGED_IN_KEY',    '(o.]Q_f,Itwe-IH5-A[&.J|;eayA@VxD8/<3I%-C7Q2t8hX.{Aez~Z8`s{b5GpWF');

define('NONCE_KEY',        'C-e-=C0}yX`{Dg_th^p8bq[J3w(I*=R,usc8eni~og{fUFzuRA[IW|eaX2N1K#{D');

define('AUTH_SALT',        '?t0bC=(yZF*#UJw.cQ(H0507[Zc,]T5mB7Ov_D;mVg?=cSP4^x;QDHFc6POY-l,a');

define('SECURE_AUTH_SALT', '8sWR+7EucfmXMy[d)SOl||#yz4.3_>e|o7+x2[5@{B;OZkC3?UBo]Yq]<42)`5y#');

define('LOGGED_IN_SALT',   'FQD~/v4lGfE+gbRn{`WDnNa+kH8]LpxI6^cg> DhilK7[*<i`+7QdaKF0H;^$k/X');

define('NONCE_SALT',       ']:a#Ltq-;@&u/+]qd|Jo-H|OJZkA5UbPx!a*;W.n*4}Rm=mY2%lexN+:c*.+]iWj');


/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';


/**
 * ローカル言語 - このパッケージでは初期値として 'ja' (日本語 UTF-8) が設定されています。
 *
 * WordPress のローカル言語を設定します。設定した言語に対応する MO ファイルが
 * wp-content/languages にインストールされている必要があります。例えば de_DE.mo を
 * wp-content/languages にインストールし WPLANG を 'de_DE' に設定することでドイツ語がサポートされます。
 */
define('WPLANG', 'zh-CN');

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/webapp/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# Upload directly but not FTP
define('FS_METHOD','direct');
