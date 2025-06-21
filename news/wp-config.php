<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * データベース設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link https://ja.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** データベース設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define( 'DB_NAME', 'xs710041_wp2' );

/** データベースのユーザー名 */
define( 'DB_USER', 'xs710041_wp2' );

/** データベースのパスワード */
define( 'DB_PASSWORD', '03wvewso4e' );

/** データベースのホスト名 */
define( 'DB_HOST', 'mysql10087.xserver.jp' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define( 'DB_COLLATE', '' );

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~29A`D4qf$jr E`e}qpKS-YHDkUF(NEmxkCEisUZ.(CxiY<mm?5lg;Z33j],Nlsd' );
define( 'SECURE_AUTH_KEY',  'JmiuwAjfL}jLi,7NeyIqG[&qQ;.h4x:rwQ?MhdJLnL fDv`Wjg[af[[X=yRDu 91' );
define( 'LOGGED_IN_KEY',    '+eOqoM^:~TagoFhOU3C9czs{d Zm#nRlBFrrqz^e>?Wke) 7QfJh>Tw*Dp`Q~VS>' );
define( 'NONCE_KEY',        'lA^6_1o:;MLa|1DYzLW[K:Z700 }Vd:aW#ZQC2u[S*voU*XC9*qZj&6>@TkMxS~(' );
define( 'AUTH_SALT',        '{Yo}~HeX+L.d2Y;7w}LaX:sf!^9tdS1Row2WgDm50&$KXo7fc_X=WX/8}9eu.rOZ' );
define( 'SECURE_AUTH_SALT', '1Ev`7ec*}a>6,xTWV~!l0$-5b =$PLf{PA2Ne)3#o vmlwBt9426He7-5= P*WTK' );
define( 'LOGGED_IN_SALT',   'cGWCt5]6,3*J>;2>a66*oJ5I)^vA]iA}w0-p_=?FmC)*ByfPZ#Ab!Jd9,&ozBl_p' );
define( 'NONCE_SALT',       '&Jp.7?|)O23B{(*n5K-<o:k7:+9qq]Fqw]>p-aaxw9t00lc|1&LR&=VIOmYFntr_' );
define( 'WP_CACHE_KEY_SALT','7+eisK=*LOKl{x]RFKZ*?egXrV^F,EN8O61X0_hkZwI#l_`3WpEib4w9+=I` MrN' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数についてはドキュメンテーションをご覧ください。
 *
 * @link https://ja.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* カスタム値は、この行と「編集が必要なのはここまでです」の行の間に追加してください。 */



/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
