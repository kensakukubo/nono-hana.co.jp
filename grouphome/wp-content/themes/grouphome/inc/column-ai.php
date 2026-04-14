<?php
/**
 * コラム：管理画面での AI 下書き設定と定期実行（WP-Cron）。
 * 常に post_status=draft。公開は手動。
 */

const GROUPHOME_COLUMN_AI_OPTION = 'grouphome_column_ai';

/**
 * @return array<string, mixed>
 */
function grouphome_column_ai_defaults() {
	return [
		'enabled'          => 0,
		'openai_model'     => 'gpt-4o-mini',
		'theme'            => '',
		'keywords'         => '',
		'reference_urls'   => '',
		'topic_memo'       => '',
		'max_ref_chars'    => 12000,
		'frequency'        => 'disabled',
		'openai_api_key'   => '',
	];
}

/**
 * @return array<string, mixed>
 */
function grouphome_column_ai_get_options() {
	$defaults = grouphome_column_ai_defaults();
	$saved    = get_option( GROUPHOME_COLUMN_AI_OPTION, [] );
	if ( ! is_array( $saved ) ) {
		$saved = [];
	}
	return array_merge( $defaults, $saved );
}

/**
 * wp-config.php で define( 'GROUPHOME_OPENAI_API_KEY', 'sk-...' ); 可能。
 */
function grouphome_column_ai_get_openai_key() {
	if ( defined( 'GROUPHOME_OPENAI_API_KEY' ) && GROUPHOME_OPENAI_API_KEY !== '' ) {
		return (string) GROUPHOME_OPENAI_API_KEY;
	}
	$opts = grouphome_column_ai_get_options();
	return isset( $opts['openai_api_key'] ) ? (string) $opts['openai_api_key'] : '';
}

function grouphome_column_ai_register_cron_schedules( $schedules ) {
	if ( ! isset( $schedules['grouphome_weekly'] ) ) {
		$schedules['grouphome_weekly'] = [
			'interval' => 7 * DAY_IN_SECONDS,
			'display'  => __( '毎週（7日間隔）', 'grouphome' ),
		];
	}
	if ( ! isset( $schedules['grouphome_monthly'] ) ) {
		$schedules['grouphome_monthly'] = [
			'interval' => 30 * DAY_IN_SECONDS,
			'display'  => __( '毎月（30日間隔）', 'grouphome' ),
		];
	}
	return $schedules;
}
add_filter( 'cron_schedules', 'grouphome_column_ai_register_cron_schedules' );

function grouphome_column_ai_reschedule_cron() {
	wp_clear_scheduled_hook( 'grouphome_column_ai_cron' );
	$opts = grouphome_column_ai_get_options();
	if ( empty( $opts['enabled'] ) ) {
		return;
	}
	$freq = isset( $opts['frequency'] ) ? (string) $opts['frequency'] : 'disabled';
	if ( $freq === 'disabled' || $freq === '' ) {
		return;
	}
	$allowed = [ 'daily', 'grouphome_weekly', 'grouphome_monthly' ];
	if ( ! in_array( $freq, $allowed, true ) ) {
		$freq = 'grouphome_weekly';
	}
	wp_schedule_event( time() + 120, $freq, 'grouphome_column_ai_cron' );
}

function grouphome_column_ai_on_option_update( $old_value, $value ) {
	unset( $old_value, $value );
	grouphome_column_ai_reschedule_cron();
}
add_action( 'update_option_' . GROUPHOME_COLUMN_AI_OPTION, 'grouphome_column_ai_on_option_update', 10, 2 );

function grouphome_column_ai_bootstrap_cron() {
	if ( ! wp_next_scheduled( 'grouphome_column_ai_cron' ) ) {
		$opts = grouphome_column_ai_get_options();
		if ( ! empty( $opts['enabled'] ) && isset( $opts['frequency'] ) && $opts['frequency'] !== 'disabled' ) {
			grouphome_column_ai_reschedule_cron();
		}
	}
}
add_action( 'init', 'grouphome_column_ai_bootstrap_cron', 20 );

function grouphome_column_ai_admin_menu() {
	add_submenu_page(
		'edit.php?post_type=column',
		__( 'AI下書き設定', 'grouphome' ),
		__( 'AI下書き設定', 'grouphome' ),
		'manage_options',
		'grouphome-column-ai',
		'grouphome_column_ai_render_settings_page'
	);
}
add_action( 'admin_menu', 'grouphome_column_ai_admin_menu' );

function grouphome_column_ai_register_settings() {
	register_setting(
		'grouphome_column_ai_group',
		GROUPHOME_COLUMN_AI_OPTION,
		[
			'type'              => 'array',
			'sanitize_callback' => 'grouphome_column_ai_sanitize_options',
			'default'           => grouphome_column_ai_defaults(),
		]
	);
}
add_action( 'admin_init', 'grouphome_column_ai_register_settings' );

/**
 * @param array<string, mixed> $input
 * @return array<string, mixed>
 */
function grouphome_column_ai_sanitize_options( $input ) {
	$old    = grouphome_column_ai_get_options();
	$input  = is_array( $input ) ? $input : [];
	$out    = grouphome_column_ai_defaults();
	$out['enabled']       = ! empty( $input['enabled'] ) ? 1 : 0;
	$out['openai_model']  = isset( $input['openai_model'] ) ? sanitize_text_field( (string) $input['openai_model'] ) : 'gpt-4o-mini';
	$out['theme']         = isset( $input['theme'] ) ? sanitize_textarea_field( (string) $input['theme'] ) : '';
	$out['keywords']      = isset( $input['keywords'] ) ? sanitize_textarea_field( (string) $input['keywords'] ) : '';
	$out['reference_urls']= isset( $input['reference_urls'] ) ? sanitize_textarea_field( (string) $input['reference_urls'] ) : '';
	$out['topic_memo']    = isset( $input['topic_memo'] ) ? sanitize_textarea_field( (string) $input['topic_memo'] ) : '';
	$out['max_ref_chars'] = isset( $input['max_ref_chars'] ) ? max( 1000, min( 50000, (int) $input['max_ref_chars'] ) ) : 12000;
	$freq = isset( $input['frequency'] ) ? (string) $input['frequency'] : 'disabled';
	$allowed_freq = [ 'disabled', 'daily', 'grouphome_weekly', 'grouphome_monthly' ];
	$out['frequency'] = in_array( $freq, $allowed_freq, true ) ? $freq : 'disabled';

	if ( ! empty( $input['openai_api_key'] ) ) {
		$out['openai_api_key'] = sanitize_text_field( (string) $input['openai_api_key'] );
	} else {
		$out['openai_api_key'] = isset( $old['openai_api_key'] ) ? (string) $old['openai_api_key'] : '';
	}

	return $out;
}

function grouphome_column_ai_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$opts = grouphome_column_ai_get_options();
	$key  = grouphome_column_ai_get_openai_key();
	$next = wp_next_scheduled( 'grouphome_column_ai_cron' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html__( 'コラム AI 下書き', 'grouphome' ); ?></h1>
		<p><?php echo esc_html__( '設定した内容に基づき、OpenAI で本文を生成し「コラム」を下書きで作成します。公開は手動で行ってください。', 'grouphome' ); ?></p>
		<?php if ( defined( 'GROUPHOME_OPENAI_API_KEY' ) && GROUPHOME_OPENAI_API_KEY !== '' ) : ?>
			<p><strong><?php echo esc_html__( 'APIキーは wp-config.php の GROUPHOME_OPENAI_API_KEY を使用しています。', 'grouphome' ); ?></strong></p>
		<?php endif; ?>
		<?php if ( $next ) : ?>
			<p><?php echo esc_html( sprintf( /* translators: %s: localized datetime */ __( '次回の自動実行予定（サイトのタイムゾーン基準・目安）: %s', 'grouphome' ), wp_date( 'Y-m-d H:i:s', $next ) ) ); ?></p>
		<?php else : ?>
			<p><?php echo esc_html__( '自動実行はスケジュールされていません（無効、または未保存）。', 'grouphome' ); ?></p>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'grouphome_column_ai_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php echo esc_html__( '自動下書きを有効にする', 'grouphome' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[enabled]" value="1" <?php checked( ! empty( $opts['enabled'] ) ); ?> />
							<?php echo esc_html__( '有効', 'grouphome' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo esc_html__( '投稿頻度', 'grouphome' ); ?></th>
					<td>
						<select name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[frequency]">
							<option value="disabled" <?php selected( $opts['frequency'], 'disabled' ); ?>><?php echo esc_html__( '無効（手動のみ）', 'grouphome' ); ?></option>
							<option value="daily" <?php selected( $opts['frequency'], 'daily' ); ?>><?php echo esc_html__( '毎日', 'grouphome' ); ?></option>
							<option value="grouphome_weekly" <?php selected( $opts['frequency'], 'grouphome_weekly' ); ?>><?php echo esc_html__( '毎週（7日間隔）', 'grouphome' ); ?></option>
							<option value="grouphome_monthly" <?php selected( $opts['frequency'], 'grouphome_monthly' ); ?>><?php echo esc_html__( '毎月（30日間隔）', 'grouphome' ); ?></option>
						</select>
						<p class="description"><?php echo esc_html__( 'WordPress の疑似 Cron（サイトにアクセスがあったときに実行）です。正確な定時にはサーバーから wp-cron.php を定期実行することを推奨します。', 'grouphome' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gh-cai-model"><?php echo esc_html__( 'OpenAI モデル', 'grouphome' ); ?></label></th>
					<td>
						<input type="text" class="regular-text" id="gh-cai-model" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[openai_model]" value="<?php echo esc_attr( (string) $opts['openai_model'] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gh-cai-key"><?php echo esc_html__( 'OpenAI API キー', 'grouphome' ); ?></label></th>
					<td>
						<?php if ( defined( 'GROUPHOME_OPENAI_API_KEY' ) && GROUPHOME_OPENAI_API_KEY !== '' ) : ?>
							<em><?php echo esc_html__( 'wp-config で定義済みのため、この欄は無視されます。', 'grouphome' ); ?></em>
						<?php else : ?>
							<input type="password" class="regular-text" id="gh-cai-key" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[openai_api_key]" value="" autocomplete="new-password" placeholder="<?php echo esc_attr__( '変更する場合のみ入力', 'grouphome' ); ?>" />
							<p class="description"><?php echo esc_html__( '空のまま保存すると既存のキーを維持します。', 'grouphome' ); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gh-cai-theme"><?php echo esc_html__( 'テーマ・方向性', 'grouphome' ); ?></label></th>
					<td>
						<textarea class="large-text" rows="3" id="gh-cai-theme" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[theme]"><?php echo esc_textarea( (string) $opts['theme'] ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gh-cai-kw"><?php echo esc_html__( 'キーワード', 'grouphome' ); ?></label></th>
					<td>
						<textarea class="large-text" rows="4" id="gh-cai-kw" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[keywords]" placeholder="<?php echo esc_attr__( '1行に1つ、またはカンマ区切り', 'grouphome' ); ?>"><?php echo esc_textarea( (string) $opts['keywords'] ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gh-cai-ref"><?php echo esc_html__( '参考ページ URL', 'grouphome' ); ?></label></th>
					<td>
						<textarea class="large-text" rows="5" id="gh-cai-ref" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[reference_urls]" placeholder="https://&#10;https://"><?php echo esc_textarea( (string) $opts['reference_urls'] ); ?></textarea>
						<p class="description"><?php echo esc_html__( '1行に1URL。公開ページのみ。本文テキストを取得してプロンプトに含めます。', 'grouphome' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gh-cai-max"><?php echo esc_html__( '参考文の最大文字数（各URL）', 'grouphome' ); ?></label></th>
					<td>
						<input type="number" class="small-text" id="gh-cai-max" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[max_ref_chars]" value="<?php echo esc_attr( (string) $opts['max_ref_chars'] ); ?>" min="1000" max="50000" step="500" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gh-cai-memo"><?php echo esc_html__( 'メモ・構成の希望', 'grouphome' ); ?></label></th>
					<td>
						<textarea class="large-text" rows="5" id="gh-cai-memo" name="<?php echo esc_attr( GROUPHOME_COLUMN_AI_OPTION ); ?>[topic_memo]"><?php echo esc_textarea( (string) $opts['topic_memo'] ); ?></textarea>
					</td>
				</tr>
			</table>
			<?php submit_button( __( '設定を保存', 'grouphome' ) ); ?>
		</form>

		<hr />
		<h2><?php echo esc_html__( '今すぐ下書きを1件作成（テスト）', 'grouphome' ); ?></h2>
		<p><?php echo esc_html__( '上記の設定で即時に1件だけ下書きを作成します（Cron とは別）。', 'grouphome' ); ?></p>
		<form method="post" action="">
			<?php wp_nonce_field( 'grouphome_column_ai_run_now', 'grouphome_column_ai_run_nonce' ); ?>
			<input type="hidden" name="grouphome_column_ai_run_now" value="1" />
			<?php submit_button( __( '今すぐ下書きを作成', 'grouphome' ), 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}

function grouphome_column_ai_handle_run_now() {
	if ( ! isset( $_POST['grouphome_column_ai_run_now'] ) || ! isset( $_POST['grouphome_column_ai_run_nonce'] ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['grouphome_column_ai_run_nonce'] ) ), 'grouphome_column_ai_run_now' ) ) {
		return;
	}
	$result = grouphome_column_ai_run_job();
	$redir  = admin_url( 'edit.php?post_type=column&page=grouphome-column-ai' );
	if ( is_wp_error( $result ) ) {
		set_transient( 'grouphome_column_ai_notice', [ 'type' => 'error', 'message' => $result->get_error_message() ], 45 );
	} else {
		if ( ! empty( $result['edit_link'] ) ) {
			$msg = '<strong>' . esc_html__( '下書きを作成しました。', 'grouphome' ) . '</strong> ';
			$msg .= '<a href="' . esc_url( $result['edit_link'] ) . '">' . esc_html__( '編集画面を開く', 'grouphome' ) . '</a>';
		} else {
			$msg = esc_html__( '下書きを作成しました。', 'grouphome' );
		}
		set_transient( 'grouphome_column_ai_notice', [ 'type' => 'success', 'message' => $msg ], 45 );
	}
	wp_safe_redirect( $redir );
	exit;
}
add_action( 'admin_init', 'grouphome_column_ai_handle_run_now' );

function grouphome_column_ai_admin_notices() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$ok_screen = false;
	if ( function_exists( 'get_current_screen' ) ) {
		$screen = get_current_screen();
		if ( $screen && isset( $screen->id ) && $screen->id === 'column_page_grouphome-column-ai' ) {
			$ok_screen = true;
		}
	}
	if ( ! $ok_screen && ( ! isset( $_GET['page'] ) || sanitize_text_field( wp_unslash( $_GET['page'] ) ) !== 'grouphome-column-ai' ) ) {
		return;
	}
	$n = get_transient( 'grouphome_column_ai_notice' );
	if ( is_array( $n ) && ! empty( $n['message'] ) ) {
		delete_transient( 'grouphome_column_ai_notice' );
		$type = ( isset( $n['type'] ) && $n['type'] === 'error' ) ? 'error' : 'success';
		printf(
			'<div class="notice notice-%1$s is-dismissible"><p>%2$s</p></div>',
			esc_attr( $type ),
			wp_kses_post( $n['message'] )
		);
	}
}
add_action( 'admin_notices', 'grouphome_column_ai_admin_notices' );

/**
 * HTML をざっくりプレーンテキストへ。
 */
function grouphome_column_ai_html_to_text( $html ) {
	$html = preg_replace( '@(?is)<script[^>]*>.*?</script>@', ' ', $html );
	$html = preg_replace( '@(?is)<style[^>]*>.*?</style>@', ' ', $html );
	$html = wp_strip_all_tags( $html );
	$html = preg_replace( '/\s+/u', ' ', $html );
	return trim( (string) $html );
}

/**
 * @param array<string, mixed> $opts
 * @return string
 */
function grouphome_column_ai_build_user_prompt( $opts ) {
	$theme = isset( $opts['theme'] ) ? trim( (string) $opts['theme'] ) : '';
	$memo  = isset( $opts['topic_memo'] ) ? trim( (string) $opts['topic_memo'] ) : '';
	$kwraw = isset( $opts['keywords'] ) ? (string) $opts['keywords'] : '';
	$keywords = [];
	foreach ( preg_split( '/[\r\n,、]+/u', $kwraw, -1, PREG_SPLIT_NO_EMPTY ) as $k ) {
		$k = trim( $k );
		if ( $k !== '' ) {
			$keywords[] = $k;
		}
	}
	$urls_raw = isset( $opts['reference_urls'] ) ? (string) $opts['reference_urls'] : '';
	$urls     = [];
	foreach ( preg_split( '/\s+/u', trim( $urls_raw ), -1, PREG_SPLIT_NO_EMPTY ) as $u ) {
		if ( preg_match( '#^https?://#i', $u ) ) {
			$urls[] = esc_url_raw( $u );
		}
	}
	$max_chars = isset( $opts['max_ref_chars'] ) ? max( 1000, min( 50000, (int) $opts['max_ref_chars'] ) ) : 12000;

	$lines   = [];
	$lines[] = '以下の条件に従い、コラムの下書き用原稿を作成してください。';
	$lines[] = '';
	$lines[] = '## コラムの方向性（テーマ）';
	$lines[] = $theme !== '' ? $theme : '（未指定：全体のトーンはグループホーム・介護福祉向け）';
	$lines[] = '';
	$lines[] = '## 取り上げたい内容・メモ・構成の希望';
	$lines[] = $memo !== '' ? $memo : '（未指定）';
	$lines[] = '';
	$lines[] = '## キーワード（可能な範囲で自然に記事へ含める。無理に詰め込まない）';
	if ( $keywords !== [] ) {
		foreach ( $keywords as $kw ) {
			$lines[] = '- ' . $kw;
		}
	} else {
		$lines[] = '（未指定）';
	}
	$lines[] = '';
	$lines[] = '## 参考ページから抽出したテキスト（参考用。長文のコピーはせず、内容を理解したうえで独自の文章にすること）';
	if ( $urls !== [] ) {
		foreach ( $urls as $url ) {
			$lines[] = '### ' . $url;
			$body    = grouphome_column_ai_fetch_url_body( $url );
			if ( is_wp_error( $body ) ) {
				$lines[] = '（取得エラー: ' . $body->get_error_message() . '）';
			} else {
				$text = grouphome_column_ai_html_to_text( $body );
				if ( function_exists( 'mb_strlen' ) && function_exists( 'mb_substr' ) ) {
					if ( mb_strlen( $text, 'UTF-8' ) > $max_chars ) {
						$text = mb_substr( $text, 0, $max_chars - 1, 'UTF-8' ) . '…';
					}
				} elseif ( strlen( $text ) > $max_chars ) {
					$text = substr( $text, 0, $max_chars - 1 ) . '…';
				}
				$lines[] = $text;
			}
			$lines[] = '';
		}
	} else {
		$lines[] = '（参考URLなし）';
	}
	return implode( "\n", $lines );
}

/**
 * @return string|\WP_Error
 */
function grouphome_column_ai_fetch_url_body( $url ) {
	$r = wp_remote_get(
		$url,
		[
			'timeout'    => 30,
			'user-agent' => 'WordPress/grouphome-column-ai; ' . home_url( '/' ),
		]
	);
	if ( is_wp_error( $r ) ) {
		return $r;
	}
	$code = wp_remote_retrieve_response_code( $r );
	if ( $code < 200 || $code >= 400 ) {
		return new WP_Error( 'http', 'HTTP ' . (int) $code );
	}
	return (string) wp_remote_retrieve_body( $r );
}

/**
 * @return array<string, string>|WP_Error
 */
function grouphome_column_ai_openai_generate( $user_prompt, $api_key, $model ) {
	$payload = [
		'model'             => $model,
		'messages'          => [
			[
				'role'    => 'system',
				'content' => 'あなたは日本のグループホーム・介護福祉に関するコラム執筆者です。'
					. '出力は次のJSONだけ。他の文は書かない。JSONのキーは title, excerpt, content_html。'
					. 'title は40文字以内が目安。excerpt は160文字以内の紹介文。'
					. 'content_html は本文のみ。見出しは h2/h3、段落は p、箇条書きは ul/li。'
					. '誇大・断定的な医療効果の表現は避け、事実と一般的な説明に留める。'
					. '参考テキストがある場合は著作権に配慮し、言い換えと要約にとどめ、原文の転載はしないこと。',
			],
			[
				'role'    => 'user',
				'content' => $user_prompt,
			],
		],
		'temperature'       => 0.7,
		'response_format'   => [ 'type' => 'json_object' ],
	];
	$res = wp_remote_post(
		'https://api.openai.com/v1/chat/completions',
		[
			'timeout' => 120,
			'headers' => [
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bearer ' . $api_key,
			],
			'body'    => wp_json_encode( $payload ),
		]
	);
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	$code = wp_remote_retrieve_response_code( $res );
	$raw  = (string) wp_remote_retrieve_body( $res );
	if ( $code < 200 || $code >= 300 ) {
		return new WP_Error( 'openai_http', 'OpenAI HTTP ' . (int) $code . ' ' . $raw );
	}
	$data = json_decode( $raw, true );
	if ( ! is_array( $data ) ) {
		return new WP_Error( 'openai_json', 'OpenAI 応答が不正です。' );
	}
	$content = $data['choices'][0]['message']['content'] ?? '';
	if ( ! is_string( $content ) || $content === '' ) {
		return new WP_Error( 'openai_empty', 'OpenAI の本文が空です。' );
	}
	if ( preg_match( '/\{[\s\S]*\}/u', $content, $m ) ) {
		$content = $m[0];
	}
	$obj = json_decode( $content, true );
	if ( ! is_array( $obj ) ) {
		return new WP_Error( 'openai_parse', 'JSON の解析に失敗しました。' );
	}
	foreach ( [ 'title', 'excerpt', 'content_html' ] as $k ) {
		if ( empty( $obj[ $k ] ) || ! is_string( $obj[ $k ] ) ) {
			return new WP_Error( 'openai_keys', 'JSON に ' . $k . ' がありません。' );
		}
	}
	return [
		'title'         => trim( $obj['title'] ),
		'excerpt'       => trim( $obj['excerpt'] ),
		'content_html'  => trim( $obj['content_html'] ),
	];
}

/**
 * @param array<string, string> $article
 * @return int|\WP_Error
 */
function grouphome_column_ai_insert_draft( $article ) {
	$post_id = wp_insert_post(
		[
			'post_type'    => 'column',
			'post_status'  => 'draft',
			'post_title'   => $article['title'],
			'post_excerpt' => $article['excerpt'],
			'post_content' => $article['content_html'],
		],
		true
	);
	if ( is_wp_error( $post_id ) ) {
		return $post_id;
	}
	return (int) $post_id;
}

/**
 * @return array{edit_link: string}|int|\WP_Error
 */
function grouphome_column_ai_run_job() {
	$opts = grouphome_column_ai_get_options();
	$key  = grouphome_column_ai_get_openai_key();
	if ( $key === '' ) {
		return new WP_Error( 'no_key', __( 'OpenAI API キーが未設定です。', 'grouphome' ) );
	}
	$model = isset( $opts['openai_model'] ) ? (string) $opts['openai_model'] : 'gpt-4o-mini';
	$prompt = grouphome_column_ai_build_user_prompt( $opts );
	$gen    = grouphome_column_ai_openai_generate( $prompt, $key, $model );
	if ( is_wp_error( $gen ) ) {
		return $gen;
	}
	$pid = grouphome_column_ai_insert_draft( $gen );
	if ( is_wp_error( $pid ) ) {
		return $pid;
	}
	return [
		'post_id'   => $pid,
		'edit_link' => admin_url( 'post.php?post=' . $pid . '&action=edit' ),
	];
}

function grouphome_column_ai_cron_callback() {
	$result = grouphome_column_ai_run_job();
	if ( is_wp_error( $result ) ) {
		error_log( 'grouphome_column_ai_cron: ' . $result->get_error_message() );
	}
}
add_action( 'grouphome_column_ai_cron', 'grouphome_column_ai_cron_callback' );
