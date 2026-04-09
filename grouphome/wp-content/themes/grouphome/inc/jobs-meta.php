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
				'sanitize_callback' => 'sanitize_text_field',
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
		],
		[
			'key'   => 'grouphome_job_work_location',
			'label' => '勤務地（住所やエリア）',
		],
		[
			'key'   => 'grouphome_job_salary',
			'label' => '給与（例: 時給 / 月給）',
		],
		[
			'key'   => 'grouphome_job_hours',
			'label' => '勤務時間',
		],
		[
			'key'   => 'grouphome_job_indeed_url',
			'label' => 'Indeed URL（任意）',
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
				$val   = get_post_meta( $post->ID, $key, true );
				$val   = is_string( $val ) ? $val : '';
				printf(
					'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><input type="text" class="regular-text" id="%1$s" name="%1$s" value="%3$s" /></td></tr>',
					esc_attr( $key ),
					esc_html( $label ),
					esc_attr( $val )
				);
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
		$raw = isset( $_POST[ $key ] ) ? (string) wp_unslash( $_POST[ $key ] ) : '';
		$val = sanitize_text_field( $raw );
		update_post_meta( $post_id, $key, $val );
	}
}
add_action( 'save_post', 'grouphome_save_job_meta_box' );

