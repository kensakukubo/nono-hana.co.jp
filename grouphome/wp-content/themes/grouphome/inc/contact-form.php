<?php
/**
 * お問い合わせフォーム（プラグイン不要・テーマ内で送信）。
 */

/**
 * @return string[]
 */
function grouphome_contact_inquiry_types() {
	return array(
		'入居・見学',
		'採用',
		'法人・取材',
		'その他',
	);
}

/**
 * @return array<string, string>
 */
function grouphome_get_contact_mail_templates() {
	$defaults = array(
		'admin_subject' => '{{inquiry_type}}｜お問い合わせ（わおん花園）',
		'admin_body'    => <<<'TXT'
以下のとおりお問い合わせがありました。

種類: {{inquiry_type}}
お名前: {{your_name}}
メール: {{your_email}}
電話: {{your_tel}}
連絡方法: {{preferred_contact}}
件名・補足: {{your_subject}}

---- 本文 ----
{{your_message}}

----
{{date_time}} / {{remote_ip}}
TXT
		,
		'mail2_subject' => '【自動返信】{{inquiry_type}}（わおん花園）',
		'mail2_body'    => <<<'TXT'
{{your_name}} 様

お問い合わせありがとうございます。下記内容で受け付けました。
ご希望の連絡方法: {{preferred_contact}}

種類: {{inquiry_type}}
----
{{your_message}}

※自動送信です。心当たりがない場合は破棄してください。
TXT
		,
	);
	return apply_filters( 'grouphome_contact_mail_templates', $defaults );
}

/**
 * @param array<string, string> $data
 */
function grouphome_contact_format_template( $template, array $data ) {
	$map = array(
		'{{inquiry_type}}'      => $data['inquiry_type'],
		'{{your_name}}'         => $data['your_name'],
		'{{your_email}}'        => $data['your_email'],
		'{{your_tel}}'          => $data['your_tel'],
		'{{preferred_contact}}' => $data['preferred_contact'],
		'{{your_subject}}'      => $data['your_subject'],
		'{{your_message}}'      => $data['your_message'],
		'{{date_time}}'         => $data['date_time'],
		'{{remote_ip}}'         => $data['remote_ip'],
	);
	return strtr( $template, $map );
}

function grouphome_is_contact_page() {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}
	$slugs = (array) apply_filters( 'grouphome_contact_page_slugs', [ 'contact' ] );
	return $post->post_name && in_array( $post->post_name, $slugs, true );
}

function grouphome_get_contact_thanks_url() {
	$default = home_url( '/thanks/' );
	return apply_filters( 'grouphome_contact_thanks_url', $default );
}

/**
 * 管理者宛メールの送信先（複数可）。フィルタ grouphome_contact_mail_to で上書き可。
 *
 * @return string|string[]
 */
function grouphome_contact_mail_to() {
	$default = array(
		'kubo@a15.co.jp',
		'kubo@nono-hana.co.jp',
	);
	return apply_filters( 'grouphome_contact_mail_to', $default );
}

/**
 * POST を検証し、メール送信後にサンクスへリダイレクト。
 */
function grouphome_contact_handle_post() {
	if ( ! isset( $_POST['grouphome_contact'] ) || (string) $_POST['grouphome_contact'] !== '1' ) {
		return;
	}
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}
	if ( ! grouphome_is_contact_page() ) {
		return;
	}
	if ( ! isset( $_POST['grouphome_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['grouphome_contact_nonce'] ) ), 'grouphome_contact' ) ) {
		$back = wp_get_referer() ?: get_permalink() ?: home_url( '/' );
		wp_safe_redirect( add_query_arg( 'contact', 'nonce', $back ) );
		exit;
	}

	$back_here = wp_get_referer() ?: get_permalink() ?: home_url( '/' );

	$hp = isset( $_POST['website'] ) ? trim( (string) wp_unslash( $_POST['website'] ) ) : '';
	if ( $hp !== '' ) {
		wp_safe_redirect( grouphome_get_contact_thanks_url() );
		exit;
	}

	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rl_key = 'grouphome_contact_rl_' . md5( $ip ?: 'unknown' );
	if ( get_transient( $rl_key ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'wait', $back_here ) );
		exit;
	}

	$types = grouphome_contact_inquiry_types();
	$inquiry = isset( $_POST['inquiry_type'] ) ? sanitize_text_field( wp_unslash( $_POST['inquiry_type'] ) ) : '';
	if ( $inquiry === '' || ! in_array( $inquiry, $types, true ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $back_here ) );
		exit;
	}

	$name = isset( $_POST['your_name'] ) ? sanitize_text_field( wp_unslash( $_POST['your_name'] ) ) : '';
	if ( $name === '' || mb_strlen( $name ) > 100 ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $back_here ) );
		exit;
	}

	$email = isset( $_POST['your_email'] ) ? sanitize_email( wp_unslash( $_POST['your_email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $back_here ) );
		exit;
	}

	$tel = isset( $_POST['your_tel'] ) ? sanitize_text_field( wp_unslash( $_POST['your_tel'] ) ) : '';
	if ( mb_strlen( $tel ) > 40 ) {
		$tel = mb_substr( $tel, 0, 40 );
	}

	$pref = isset( $_POST['preferred_contact'] ) ? sanitize_text_field( wp_unslash( $_POST['preferred_contact'] ) ) : '';
	if ( ! in_array( $pref, [ 'メール', 'お電話' ], true ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $back_here ) );
		exit;
	}

	$subject_extra = isset( $_POST['your_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['your_subject'] ) ) : '';
	if ( mb_strlen( $subject_extra ) > 200 ) {
		$subject_extra = mb_substr( $subject_extra, 0, 200 );
	}

	$message = isset( $_POST['your_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['your_message'] ) ) : '';
	if ( $message === '' || mb_strlen( $message ) > 12000 ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $back_here ) );
		exit;
	}

	$privacy = isset( $_POST['privacy'] ) ? (string) wp_unslash( $_POST['privacy'] ) : '';
	if ( $privacy !== '1' ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $back_here ) );
		exit;
	}

	$date_time = wp_date( 'Y-m-d H:i:s' );
	$data      = array(
		'inquiry_type'      => $inquiry,
		'your_name'         => $name,
		'your_email'        => $email,
		'your_tel'          => $tel,
		'preferred_contact' => $pref,
		'your_subject'      => $subject_extra,
		'your_message'      => $message,
		'date_time'         => $date_time,
		'remote_ip'         => $ip,
	);

	$templates = grouphome_get_contact_mail_templates();
	$subj        = grouphome_contact_format_template( $templates['admin_subject'], $data );
	$body        = grouphome_contact_format_template( $templates['admin_body'], $data );

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$to = grouphome_contact_mail_to();
	$sent = wp_mail( $to, $subj, $body, $headers );

	if ( apply_filters( 'grouphome_contact_send_auto_reply', true ) && $sent ) {
		$subj2 = grouphome_contact_format_template( $templates['mail2_subject'], $data );
		$body2 = grouphome_contact_format_template( $templates['mail2_body'], $data );
		wp_mail( $email, $subj2, $body2, array( 'Content-Type: text/plain; charset=UTF-8' ) );
	}

	if ( $sent ) {
		set_transient( $rl_key, 1, 60 );
		wp_safe_redirect( grouphome_get_contact_thanks_url() );
		exit;
	}

	wp_safe_redirect( add_query_arg( 'contact', 'fail', $back_here ) );
	exit;
}
add_action( 'template_redirect', 'grouphome_contact_handle_post', 1 );

/**
 * お問い合わせフォーム HTML。
 */
function grouphome_render_contact_form() {
	$permalink = get_permalink();
	if ( ! $permalink ) {
		return;
	}
	$types = grouphome_contact_inquiry_types();
	?>
	<div class="grouphome-cf7">
		<form class="grouphome-cf7-fields" method="post" action="<?php echo esc_url( $permalink ); ?>" id="grouphome-contact-form">
			<?php wp_nonce_field( 'grouphome_contact', 'grouphome_contact_nonce' ); ?>
			<input type="hidden" name="grouphome_contact" value="1" />
			<p class="grouphome-cf7__field grouphome-cf7__hp" aria-hidden="true">
				<label for="grouphome-contact-website">Website</label>
				<input type="text" name="website" id="grouphome-contact-website" value="" tabindex="-1" autocomplete="off" />
			</p>
			<p class="grouphome-cf7__hint">用件に近い種類を選ぶと、返信が早くなります。</p>
			<p class="grouphome-cf7__field">
				<label for="grouphome-inquiry-type">
					<span class="grouphome-cf7__field-title">お問い合わせの種類 <span class="grouphome-cf7__req" aria-hidden="true">必須</span></span>
				</label>
				<select name="inquiry_type" id="grouphome-inquiry-type" required>
					<option value="" disabled selected>選択してください</option>
					<?php foreach ( $types as $t ) : ?>
						<option value="<?php echo esc_attr( $t ); ?>"><?php echo esc_html( $t ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<p class="grouphome-cf7__field">
				<label for="grouphome-your-name">
					<span class="grouphome-cf7__field-title">お名前 <span class="grouphome-cf7__req" aria-hidden="true">必須</span></span>
				</label>
				<input type="text" name="your_name" id="grouphome-your-name" required maxlength="100" placeholder="山田 太郎" autocomplete="name" />
			</p>
			<p class="grouphome-cf7__field">
				<label for="grouphome-your-email">
					<span class="grouphome-cf7__field-title">メールアドレス <span class="grouphome-cf7__req" aria-hidden="true">必須</span></span>
				</label>
				<input type="email" name="your_email" id="grouphome-your-email" required autocomplete="email" />
			</p>
			<p class="grouphome-cf7__field">
				<label for="grouphome-your-tel">
					<span class="grouphome-cf7__field-title">電話番号 <span class="grouphome-cf7__opt">任意</span></span>
				</label>
				<input type="tel" name="your_tel" id="grouphome-your-tel" maxlength="40" placeholder="090-1234-5678" autocomplete="tel" />
			</p>
			<div class="grouphome-cf7__field grouphome-cf7__field--radio">
				<span class="grouphome-cf7__field-title" id="grouphome-pref-label">ご希望の連絡方法 <span class="grouphome-cf7__req" aria-hidden="true">必須</span></span>
				<div class="grouphome-cf7__radios" role="radiogroup" aria-labelledby="grouphome-pref-label">
					<label class="grouphome-cf7__radio-option"><input type="radio" name="preferred_contact" value="メール" required /> メール</label>
					<label class="grouphome-cf7__radio-option"><input type="radio" name="preferred_contact" value="お電話" /> お電話</label>
				</div>
			</div>
			<p class="grouphome-cf7__field">
				<label for="grouphome-your-subject">
					<span class="grouphome-cf7__field-title">件名・補足 <span class="grouphome-cf7__opt">任意</span></span>
				</label>
				<input type="text" name="your_subject" id="grouphome-your-subject" maxlength="200" placeholder="見学希望日など" />
			</p>
			<p class="grouphome-cf7__field grouphome-cf7__field--full">
				<label for="grouphome-your-message">
					<span class="grouphome-cf7__field-title">お問い合わせ内容 <span class="grouphome-cf7__req" aria-hidden="true">必須</span></span>
				</label>
				<textarea name="your_message" id="grouphome-your-message" required maxlength="12000" placeholder="内容をご記入ください"></textarea>
			</p>
			<p class="grouphome-cf7__accept">
				<label>
					<input type="checkbox" name="privacy" value="1" required /> 個人情報の取り扱いに同意する
				</label>
			</p>
			<p class="grouphome-cf7__submit">
				<input type="submit" class="grouphome-cf7__btn" value="送信する" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * ?contact= のメッセージ
 */
function grouphome_contact_notice_text() {
	if ( ! isset( $_GET['contact'] ) ) {
		return '';
	}
	$code = sanitize_text_field( wp_unslash( $_GET['contact'] ) );
	$map  = array(
		'invalid' => '入力内容を確認してください。',
		'nonce'   => '送信を完了できませんでした。ページを更新して再度お試しください。',
		'fail'    => '送信に失敗しました。時間をおいて再度お試しください。',
		'wait'    => '連続送信を防いでいます。しばらくしてから再度お試しください。',
	);
	return isset( $map[ $code ] ) ? $map[ $code ] : '';
}
