<?php
/**
 * 求人（job）用の最低限のメタ情報。
 * A（無料で拾われやすく）を想定し、1投稿=1求人の情報をページ内に持たせる。
 */

function grouphome_register_job_meta() {
	$defs = [
		'grouphome_job_employment_type' => [ 'type' => 'string', 'default' => '' ], // 例: パート / 正社員
		'grouphome_job_work_location'   => [ 'type' => 'string', 'default' => '' ], // 例: 大阪府大阪市〜
		'grouphome_job_salary'          => [ 'type' => 'string', 'default' => '' ], // 例: 時給1,200円〜
		'grouphome_job_hours'           => [ 'type' => 'string', 'default' => '' ], // 例: 22:00〜翌9:00
		'grouphome_job_indeed_url'      => [ 'type' => 'string', 'default' => '' ], // 任意: Indeed詳細へ
		// 項目別に運用できるように「本文」を分割する。
		'grouphome_job_description'     => [ 'type' => 'string', 'default' => '' ], // 仕事内容
		'grouphome_job_requirements'    => [ 'type' => 'string', 'default' => '' ], // 応募資格・経験
		'grouphome_job_salary_detail'   => [ 'type' => 'string', 'default' => '' ], // 給与詳細（手当等）
		'grouphome_job_hours_detail'    => [ 'type' => 'string', 'default' => '' ], // 勤務時間詳細（シフト等）
		'grouphome_job_holidays'        => [ 'type' => 'string', 'default' => '' ], // 休日・休暇
		'grouphome_job_benefits'        => [ 'type' => 'string', 'default' => '' ], // 待遇・福利厚生
		'grouphome_job_notes'           => [ 'type' => 'string', 'default' => '' ], // 備考
	];

	foreach ( $defs as $key => $def ) {
		register_post_meta(
			'job',
			$key,
			[
				'type'              => $def['type'],
				'single'            => true,
				'show_in_rest'      => true,
				'default'           => $def['default'],
				// 複数行を許可したいので textarea も保持する（保存時に wp_kses で最小限のHTMLを許可）。
				'sanitize_callback' => function( $value ) {
					$value = is_string( $value ) ? $value : '';
					$value = wp_unslash( $value );
					return wp_kses_post( $value );
				},
				'auth_callback'     => function() {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}
}
add_action( 'init', 'grouphome_register_job_meta' );

function grouphome_job_meta_box_fields() {
	return [
		[
			'key'   => 'grouphome_job_employment_type',
			'label' => '雇用形態（例: パート / 正社員）',
			'type'  => 'text',
		],
		[
			'key'   => 'grouphome_job_work_location',
			'label' => '所在地（住所）※右の「勤務地」で拠点を選ぶと、未入力時は自動で入ります。上書きも可。',
			'type'  => 'textarea',
		],
		[
			'key'   => 'grouphome_job_salary',
			'label' => '給与（例: 時給 / 月給）',
			'type'  => 'text',
		],
		[
			'key'   => 'grouphome_job_hours',
			'label' => '勤務時間',
			'type'  => 'text',
		],
		[
			'key'   => 'grouphome_job_indeed_url',
			'label' => 'Indeed URL（任意）',
			'type'  => 'text',
		],
		[
			'key'   => 'grouphome_job_description',
			'label' => '仕事内容',
			'type'  => 'textarea',
		],
		[
			'key'   => 'grouphome_job_requirements',
			'label' => '応募資格・経験',
			'type'  => 'textarea',
		],
		[
			'key'   => 'grouphome_job_salary_detail',
			'label' => '給与詳細（手当・昇給など）',
			'type'  => 'textarea',
		],
		[
			'key'   => 'grouphome_job_hours_detail',
			'label' => '勤務時間詳細（シフト・残業など）',
			'type'  => 'textarea',
		],
		[
			'key'   => 'grouphome_job_holidays',
			'label' => '休日・休暇',
			'type'  => 'textarea',
		],
		[
			'key'   => 'grouphome_job_benefits',
			'label' => '待遇・福利厚生',
			'type'  => 'textarea',
		],
		[
			'key'   => 'grouphome_job_notes',
			'label' => '備考',
			'type'  => 'textarea',
		],
	];
}

function grouphome_add_job_meta_box() {
	add_meta_box(
		'grouphome_job_meta',
		'求人情報（Indeed向け）',
		function( $post ) {
			wp_nonce_field( 'grouphome_job_meta_save', 'grouphome_job_meta_nonce' );
			echo '<table class="form-table" role="presentation"><tbody>';
			foreach ( grouphome_job_meta_box_fields() as $f ) {
				$key   = $f['key'];
				$label = $f['label'];
				$type  = isset( $f['type'] ) && is_string( $f['type'] ) ? $f['type'] : 'text';
				$val   = get_post_meta( $post->ID, $key, true );
				$val   = is_string( $val ) ? $val : '';
				if ( $type === 'textarea' ) {
					printf(
						'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><textarea class="large-text" rows="5" id="%1$s" name="%1$s">%3$s</textarea></td></tr>',
						esc_attr( $key ),
						esc_html( $label ),
						esc_textarea( $val )
					);
				} else {
					printf(
						'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><input type="text" class="regular-text" id="%1$s" name="%1$s" value="%3$s" /></td></tr>',
						esc_attr( $key ),
						esc_html( $label ),
						esc_attr( $val )
					);
				}
			}
			echo '</tbody></table>';
		},
		'job',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'grouphome_add_job_meta_box' );

function grouphome_save_job_meta_box( $post_id ) {
	if ( ! isset( $_POST['grouphome_job_meta_nonce'] ) || ! wp_verify_nonce( $_POST['grouphome_job_meta_nonce'], 'grouphome_job_meta_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( get_post_type( $post_id ) !== 'job' ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( grouphome_job_meta_box_fields() as $f ) {
		$key = $f['key'];
		$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$raw = is_string( $raw ) ? $raw : '';
		$val = wp_kses_post( $raw );
		update_post_meta( $post_id, $key, $val );
	}
}
add_action( 'save_post', 'grouphome_save_job_meta_box' );

/**
 * 拠点（勤務地タクソノミー）が選ばれていて、所在地メタが空のときは既定住所を保存する（管理画面でも自動反映）。
 */
function grouphome_job_maybe_fill_address_meta_from_terms( $post_id, $post, $update ) {
	unset( $update );
	if ( ! $post instanceof WP_Post || $post->post_type !== 'job' ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$meta = trim( (string) get_post_meta( $post_id, 'grouphome_job_work_location', true ) );
	if ( $meta !== '' ) {
		return;
	}
	$terms = get_the_terms( $post_id, 'job_location' );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return;
	}
	if ( ! function_exists( 'grouphome_job_address_from_terms' ) ) {
		return;
	}
	$addr = grouphome_job_address_from_terms( $post_id );
	if ( $addr === '' ) {
		return;
	}
	update_post_meta( $post_id, 'grouphome_job_work_location', $addr );
}
add_action( 'save_post_job', 'grouphome_job_maybe_fill_address_meta_from_terms', 50, 3 );

