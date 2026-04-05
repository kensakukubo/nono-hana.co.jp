<?php
/**
 * Google マップ iframe 用の src。埋め込みURLの場合はそのまま、それ以外は住所を q= に渡す。
 *
 * @param string $google_map_url 管理画面の「GoogleマップURL」。
 * @param string $address_fallback マップURLが空のときに使う住所文字列。
 */
function grouphome_map_embed_src( $google_map_url, $address_fallback ) {
	$google_map_url = trim( (string) $google_map_url );
	if ( $google_map_url !== '' ) {
		if ( preg_match( '#(output=embed|/maps/embed|google\.com/maps/embed)#i', $google_map_url ) ) {
			return esc_url( $google_map_url );
		}
	}
	$q = trim( (string) $address_fallback );
	if ( $q === '' ) {
		return '';
	}
	return 'https://maps.google.com/maps?q=' . rawurlencode( $q ) . '&hl=ja&z=16&output=embed';
}

/** サイト共通：連絡先（06-4393-8474） */
function grouphome_phone_main_display() {
	return '06-4393-8474';
}

function grouphome_phone_main_tel_digits() {
	return '0643938474';
}

/** サイト共通：緊急連絡先 */
function grouphome_phone_emergency_display() {
	return '090-8523-3028';
}

function grouphome_phone_emergency_tel_digits() {
	return '09085233028';
}

/**
 * ACF のテキスト系フィールドが配列（選択肢の value 配列など）・数値のときに表示用の文字列へ。
 * PHP 8 で preg_replace / explode / esc_html に非文字列を渡さないため。
 */
function grouphome_acf_textish( $value ) {
	if ( is_string( $value ) ) {
		return $value;
	}
	if ( is_numeric( $value ) ) {
		return (string) $value;
	}
	if ( is_array( $value ) ) {
		if ( isset( $value['value'] ) && is_scalar( $value['value'] ) ) {
			return (string) $value['value'];
		}
		if ( isset( $value['label'] ) && is_scalar( $value['label'] ) ) {
			return (string) $value['label'];
		}
		$first = reset( $value );
		return is_scalar( $first ) ? (string) $first : '';
	}
	return '';
}

/**
 * 拠点ページ用の料金表（行データ）。
 *
 * @param string $variant hanazono | senbon_nishitenkachaya
 * @return array<int, array{0:string,1:string}>
 */
function grouphome_location_pricing_rows( $variant ) {
	$variants = [
		'hanazono'               => [
			[ '家賃', '40,000円/月' ],
			[ '食費', '27,000円/月' ],
			[ '光熱費', '15,000円/月' ],
			[ '日用品費', '5,000円/月' ],
			[ 'WiFi', '1,000円/月' ],
		],
		'senbon_nishitenkachaya' => [
			[ '家賃', '40,000円/月' ],
			[ '食費', '27,000円/月' ],
			[ '光熱費', '10,000円/月' ],
			[ '日用品費', '5,000円/月' ],
			[ 'WiFi', '1,000円/月' ],
		],
	];
	return isset( $variants[ $variant ] ) ? $variants[ $variant ] : [];
}

/**
 * 拠点ページで表示する料金パターンを決定（ACF → 施設名・タイトル・スラッグのヒューリスティック）。
 */
function grouphome_resolve_location_pricing_variant( $post = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}
	$post = $post ?: get_post();
	if ( ! $post instanceof WP_Post ) {
		return '';
	}
	$acf_v = get_field( 'pricing_variant', $post->ID );
	if ( is_string( $acf_v ) && $acf_v !== '' ) {
		return $acf_v;
	}
	$slug = get_field( 'location_slug', $post->ID );
	$slug = is_string( $slug ) ? strtolower( preg_replace( '/\s+/', '', $slug ) ) : '';
	if ( $slug !== '' ) {
		if ( false !== strpos( $slug, 'hanazon' ) || false !== strpos( $slug, 'hanazono' ) ) {
			return 'hanazono';
		}
		if ( false !== strpos( $slug, 'senbon' ) || false !== strpos( $slug, 'nishiten' ) || false !== strpos( $slug, 'tenkachaya' ) ) {
			return 'senbon_nishitenkachaya';
		}
	}
	$pn = strtolower( $post->post_name );
	if ( false !== strpos( $pn, 'hanazon' ) || false !== strpos( $pn, 'hanazono' ) ) {
		return 'hanazono';
	}
	if ( false !== strpos( $pn, 'senbon' ) || false !== strpos( $pn, 'nishiten' ) || false !== strpos( $pn, 'tenkachaya' ) ) {
		return 'senbon_nishitenkachaya';
	}
	// 施設名・ページタイトル（わおん西天下茶屋 など、スラッグが wanon のみで判別できない場合）
	$utf8 = 'UTF-8';
	$facility = get_field( 'facility_name', $post->ID );
	if ( is_string( $facility ) && $facility !== '' && function_exists( 'mb_strpos' ) ) {
		if ( false !== mb_strpos( $facility, '西天下茶屋', 0, $utf8 ) || false !== mb_strpos( $facility, '千本', 0, $utf8 ) ) {
			return 'senbon_nishitenkachaya';
		}
		if ( false !== mb_strpos( $facility, '花園', 0, $utf8 ) && false === mb_strpos( $facility, '西天下', 0, $utf8 ) ) {
			return 'hanazono';
		}
	}
	$title = get_post_field( 'post_title', $post );
	if ( is_string( $title ) && $title !== '' && function_exists( 'mb_strpos' ) ) {
		if ( false !== mb_strpos( $title, '西天下茶屋', 0, $utf8 ) || false !== mb_strpos( $title, '千本', 0, $utf8 ) ) {
			return 'senbon_nishitenkachaya';
		}
		if ( false !== mb_strpos( $title, '花園', 0, $utf8 ) && false === mb_strpos( $title, '西天下', 0, $utf8 ) ) {
			return 'hanazono';
		}
	}
	return '';
}

/**
 * 拠点ページ：ACFの住所が空のとき、施設名／タイトルから既定住所を入れる（西天下茶屋を千本より先に判定）。
 */
function grouphome_apply_location_default_address( &$pref, &$city, &$street, $post = null ) {
	$post = $post ?: get_post();
	if ( ! $post instanceof WP_Post ) {
		return;
	}
	$p = trim( (string) $pref );
	$c = trim( (string) $city );
	$s = trim( (string) $street );
	if ( $p !== '' || $c !== '' || $s !== '' ) {
		return;
	}
	if ( ! function_exists( 'mb_strpos' ) ) {
		return;
	}
	$utf8     = 'UTF-8';
	$facility = function_exists( 'get_field' ) ? get_field( 'facility_name', $post->ID ) : '';
	$facility = is_string( $facility ) ? $facility : '';
	$title    = get_post_field( 'post_title', $post );
	$title    = is_string( $title ) ? $title : '';
	$blob     = $facility . $title;

	if ( false !== mb_strpos( $blob, '西天下茶屋', 0, $utf8 ) ) {
		$pref   = '大阪府';
		$city   = '大阪市西成区';
		$street = '橘3丁目5-24';
		return;
	}
	if ( false !== mb_strpos( $blob, '千本', 0, $utf8 ) ) {
		$pref   = '大阪府';
		$city   = '大阪市西成区';
		$street = '千本北1-11-4';
	}
}

/**
 * 拠点がわおん西天下茶屋か（室内ギャラリー追加分など）。
 * 千本・花園のスラッグでは false（ACFの施設名が誤っても西天下茶屋扱いにしない）。
 */
function grouphome_location_matches_nishitenkachaya( $post = null ) {
	$post = $post ?: get_post();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}
	$pn = strtolower( $post->post_name );
	if ( false !== strpos( $pn, 'senbon' ) || false !== strpos( $pn, 'hanazon' ) ) {
		return false;
	}
	if ( false !== strpos( $pn, 'nishiten' ) || false !== strpos( $pn, 'tengachaya' ) || false !== strpos( $pn, 'tenkachaya' ) ) {
		return true;
	}
	if ( function_exists( 'mb_strpos' ) ) {
		$utf8     = 'UTF-8';
		$facility = function_exists( 'get_field' ) ? get_field( 'facility_name', $post->ID ) : '';
		$facility = is_string( $facility ) ? $facility : '';
		$title    = get_post_field( 'post_title', $post );
		$title    = is_string( $title ) ? $title : '';
		$blob     = $facility . $title;
		if ( false !== mb_strpos( $blob, '西天下茶屋', 0, $utf8 ) ) {
			return true;
		}
	}
	return false;
}

/**
 * 拠点がわおん花園か（スラッグに hanazon を含む）。
 */
function grouphome_location_matches_hanazono( $post = null ) {
	$post = $post ?: get_post();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}
	return false !== strpos( strtolower( $post->post_name ), 'hanazon' );
}

/**
 * uploads 配下の相対パスから公開URL（日本語ファイル名はパスをエンコード）。
 *
 * @param string $path uploads からの相対、例 2026/04/わおん千本.webp
 */
function grouphome_uploads_public_url( $path ) {
	$path = trim( str_replace( '\\', '/', (string) $path ), '/' );
	if ( $path === '' ) {
		return '';
	}
	$upload = wp_upload_dir();
	if ( ! empty( $upload['error'] ) ) {
		return '';
	}
	$segments = explode( '/', $path );
	$segments = array_map( 'rawurlencode', $segments );
	return trailingslashit( $upload['baseurl'] ) . implode( '/', $segments );
}

/**
 * わおん西天下茶屋「室内の様子」に追加する固定画像（メディアライブラリURL）。
 *
 * @return array<int, array{url:string, alt:string, caption:string}>
 */
function grouphome_get_nishitenkachaya_extra_room_slides() {
	return [
		[
			'url'     => grouphome_uploads_public_url( '2026/04/千本_2.png' ),
			'alt'     => 'わおん西天下茶屋',
			'caption' => '',
		],
		[
			'url'     => grouphome_uploads_public_url( '2026/04/千本_1.jpg' ),
			'alt'     => 'わおん西天下茶屋',
			'caption' => '',
		],
	];
}

/**
 * わおん花園「室内の様子」に追加する固定画像。
 *
 * @return array<int, array{url:string, alt:string, caption:string}>
 */
function grouphome_get_hanazono_extra_room_slides() {
	return [
		[
			'url'     => grouphome_uploads_public_url( '2026/04/S__56811555.jpg' ),
			'alt'     => 'わおん花園',
			'caption' => '',
		],
		[
			'url'     => grouphome_uploads_public_url( '2026/04/名称未設定のデザイン-19.png' ),
			'alt'     => 'わおん花園',
			'caption' => '',
		],
		[
			'url'     => grouphome_uploads_public_url( '2026/04/S__56811559.jpg' ),
			'alt'     => 'わおん花園',
			'caption' => '',
		],
	];
}

/**
 * 西天下茶屋「室内」用にテーマで差し込む uploads ファイルか（千本ページのACF誤登録では出さない）。
 */
function grouphome_slide_is_nishitenkachaya_extra_room_asset( $slide ) {
	if ( ! is_array( $slide ) ) {
		return false;
	}
	$markers = [ '千本_2.png', '千本_1.jpg' ];
	if ( ! empty( $slide['id'] ) ) {
		$id   = (int) $slide['id'];
		$file = get_post_meta( $id, '_wp_attached_file', true );
		$file = is_string( $file ) ? $file : '';
		foreach ( $markers as $m ) {
			if ( $file !== '' && false !== strpos( $file, $m ) ) {
				return true;
			}
		}
		$url = wp_get_attachment_url( $id );
		$url = is_string( $url ) ? $url : '';
		foreach ( $markers as $m ) {
			if ( $url !== '' && ( false !== strpos( $url, $m ) || false !== strpos( $url, rawurlencode( $m ) ) ) ) {
				return true;
			}
		}
	}
	if ( ! empty( $slide['url'] ) ) {
		$u = (string) $slide['url'];
		foreach ( $markers as $m ) {
			if ( false !== strpos( $u, $m ) || false !== strpos( $u, rawurlencode( $m ) ) ) {
				return true;
			}
		}
	}
	return false;
}

/**
 * 既存スライドのURL集合（重複追加の判定用）。
 *
 * @param array<int, array{id?:int, url?:string, alt:string, caption:string}> $slides
 * @return array<string, true>
 */
function grouphome_room_slide_urls_for_dedup( $slides ) {
	$urls = [];
	foreach ( $slides as $s ) {
		if ( ! empty( $s['url'] ) ) {
			$urls[ $s['url'] ] = true;
			continue;
		}
		if ( ! empty( $s['id'] ) ) {
			$id = (int) $s['id'];
			foreach ( [ 'full', 'large', 'medium' ] as $sz ) {
				$u = wp_get_attachment_image_url( $id, $sz );
				if ( $u ) {
					$urls[ $u ] = true;
				}
			}
			$direct = wp_get_attachment_url( $id );
			if ( $direct ) {
				$urls[ $direct ] = true;
			}
		}
	}
	return $urls;
}

/**
 * 拠点ページ・メイン写真（概要左・テーブル横）：ACF「施設写真」が空のときの既定URL。
 * 花園・千本は uploads の固定ファイル、西天下茶屋はテーマ同梱の廊下写真。
 */
function grouphome_location_default_facility_image_url( $post = null ) {
	$post = $post ?: get_post();
	if ( ! $post instanceof WP_Post ) {
		return '';
	}
	$pn = strtolower( $post->post_name );
	if ( false !== strpos( $pn, 'senbon' ) ) {
		return grouphome_uploads_public_url( '2026/04/わおん千本.webp' );
	}
	if ( false !== strpos( $pn, 'hanazon' ) ) {
		return grouphome_uploads_public_url( '2026/04/S__56811553.jpg' );
	}
	if ( grouphome_location_matches_nishitenkachaya( $post ) ) {
		return grouphome_facility_default_interior_image_url();
	}
	return '';
}

/**
 * 「拠点を選ぶ」カードの固定画像（固定ページスラッグ → uploads からの相対パス）。
 *
 * 本番URL:
 * - 花園 …/uploads/2026/04/S__56811553.jpg
 * - 西天下茶屋 …/uploads/2026/04/わおん天下茶屋.webp
 * - 千本 …/uploads/2026/04/わおん千本.webp
 *
 * @return string 相対パス（例 2026/04/わおん千本.webp）／該当なしは空文字
 */
function grouphome_location_card_fixed_upload_relative( $post_name ) {
	$post_name = is_string( $post_name ) ? $post_name : '';
	$map       = [
		'hanazono'         => '2026/04/S__56811553.jpg',
		'nishi-tengachaya' => '2026/04/わおん天下茶屋.webp',
		'senboncho'        => '2026/04/わおん千本.webp',
	];
	return isset( $map[ $post_name ] ) ? $map[ $post_name ] : '';
}

/**
 * 施設紹介「拠点を選ぶ」カード画像。
 * 1) ACF「拠点一覧カード用写真」 2) 上記マップ（スラッグ一致） 3) ACF「施設写真」
 *
 * @return array{url:string, alt:string}|null
 */
function grouphome_get_location_card_image( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id || ! function_exists( 'get_field' ) ) {
		return null;
	}
	$title = get_the_title( $post_id );
	$post  = get_post( $post_id );
	$img   = get_field( 'location_card_image', $post_id );
	if ( is_array( $img ) && ! empty( $img['ID'] ) ) {
		$url = wp_get_attachment_image_url( (int) $img['ID'], 'large' );
		if ( $url ) {
			return [
				'url' => $url,
				'alt' => ! empty( $img['alt'] ) ? (string) $img['alt'] : $title,
			];
		}
	}
	if ( $post instanceof WP_Post ) {
		$rel = grouphome_location_card_fixed_upload_relative( $post->post_name );
		if ( $rel !== '' ) {
			$url = grouphome_uploads_public_url( $rel );
			if ( $url !== '' ) {
				return [
					'url' => $url,
					'alt' => $title,
				];
			}
		}
	}
	$img = get_field( 'facility_image', $post_id );
	if ( is_array( $img ) && ! empty( $img['ID'] ) ) {
		$url = wp_get_attachment_image_url( (int) $img['ID'], 'large' );
		if ( $url ) {
			return [
				'url' => $url,
				'alt' => ! empty( $img['alt'] ) ? (string) $img['alt'] : $title,
			];
		}
	}
	return null;
}

/**
 * 施設紹介・室内ギャラリー共通の既定写真（テーマ同梱）。
 */
function grouphome_facility_default_interior_image_url() {
	return get_template_directory_uri() . '/assets/img/facility-interior-hall.png';
}

/**
 * ACF「施設写真」（メイン・概要用）の添付ID。室内ギャラリーからは除外する。
 */
function grouphome_get_facility_image_attachment_id( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id || ! function_exists( 'get_field' ) ) {
		return 0;
	}
	$img = get_field( 'facility_image', $post_id );
	if ( is_array( $img ) && ! empty( $img['ID'] ) ) {
		return (int) $img['ID'];
	}
	return 0;
}

/**
 * メイン施設写真と同一URLか（ギャラリーがURL行のみのとき用）。
 *
 * @param string $url
 * @param int    $facility_attachment_id
 */
function grouphome_is_same_attachment_url_as_facility_image( $url, $facility_attachment_id ) {
	$url = trim( (string) $url );
	if ( $url === '' || $facility_attachment_id <= 0 ) {
		return false;
	}
	foreach ( [ 'full', 'large', 'medium' ] as $size ) {
		$u = wp_get_attachment_image_url( $facility_attachment_id, $size );
		if ( $u && $u === $url ) {
			return true;
		}
	}
	$direct = wp_get_attachment_url( $facility_attachment_id );
	return ( $direct && $direct === $url );
}

/**
 * 拠点ページ「室内の様子」用スライド配列。ACF room_gallery が空なら既定1枚。
 * メイン施設写真（facility_image）と同じ画像は室内に出さない（誤登録時の除外）。
 *
 * @return array<int, array{id?:int, url?:string, alt:string, caption:string}>
 */
function grouphome_get_room_gallery_slides( $post_id ) {
	$post_id = (int) $post_id;
	$slides  = [];
	if ( $post_id && function_exists( 'get_field' ) ) {
		$g = get_field( 'room_gallery', $post_id );
		if ( is_array( $g ) ) {
			foreach ( $g as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}
				$id = isset( $row['ID'] ) ? (int) $row['ID'] : 0;
				if ( $id > 0 ) {
					$alt = isset( $row['alt'] ) ? (string) $row['alt'] : '';
					if ( $alt === '' ) {
						$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
					}
					$caption = isset( $row['caption'] ) && $row['caption'] !== '' ? (string) $row['caption'] : (string) wp_get_attachment_caption( $id );
					$slides[] = [
						'id'      => $id,
						'alt'     => $alt,
						'caption' => $caption,
					];
					continue;
				}
				if ( ! empty( $row['url'] ) ) {
					$slides[] = [
						'url'     => (string) $row['url'],
						'alt'     => isset( $row['alt'] ) ? (string) $row['alt'] : '',
						'caption' => isset( $row['caption'] ) ? (string) $row['caption'] : '',
					];
				}
			}
		}
	}
	$main_id = grouphome_get_facility_image_attachment_id( $post_id );
	if ( $main_id > 0 && $slides !== [] ) {
		$filtered = [];
		foreach ( $slides as $slide ) {
			if ( ! empty( $slide['id'] ) && (int) $slide['id'] === $main_id ) {
				continue;
			}
			if ( ! empty( $slide['url'] ) && grouphome_is_same_attachment_url_as_facility_image( $slide['url'], $main_id ) ) {
				continue;
			}
			$filtered[] = $slide;
		}
		$slides = $filtered;
	}
	$post_obj = get_post( $post_id );
	if ( $post_obj instanceof WP_Post && false !== strpos( strtolower( $post_obj->post_name ), 'senbon' ) ) {
		$filtered_senbon = [];
		foreach ( $slides as $slide ) {
			if ( grouphome_slide_is_nishitenkachaya_extra_room_asset( $slide ) ) {
				continue;
			}
			$filtered_senbon[] = $slide;
		}
		$slides = $filtered_senbon;
	}
	if ( $post_obj instanceof WP_Post && grouphome_location_matches_nishitenkachaya( $post_obj ) ) {
		$known = grouphome_room_slide_urls_for_dedup( $slides );
		foreach ( grouphome_get_nishitenkachaya_extra_room_slides() as $extra ) {
			$u = $extra['url'];
			if ( $u !== '' && empty( $known[ $u ] ) ) {
				$slides[] = $extra;
				$known[ $u ] = true;
			}
		}
	}
	if ( $post_obj instanceof WP_Post && grouphome_location_matches_hanazono( $post_obj ) ) {
		$known = grouphome_room_slide_urls_for_dedup( $slides );
		foreach ( grouphome_get_hanazono_extra_room_slides() as $extra ) {
			$u = $extra['url'];
			if ( $u !== '' && empty( $known[ $u ] ) ) {
				$slides[] = $extra;
				$known[ $u ] = true;
			}
		}
	}
	if ( ! empty( $slides ) ) {
		return $slides;
	}
	return [
		[
			'url'     => grouphome_facility_default_interior_image_url(),
			'alt'     => 'グループホームの共用廊下・階段',
			'caption' => '共用廊下・階段（イメージ）',
		],
	];
}

/**
 * テンプレート「拠点」の固定ページ一覧（施設紹介ハブ用）。
 *
 * @return WP_Post[]
 */
function grouphome_get_location_pages() {
	return get_pages(
		[
			'sort_column' => 'menu_order',
			'sort_order'  => 'ASC',
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-location.php',
		]
	);
}

function grouphome_page_has_visible_content( $post = null ) {
    $post = $post ?: get_post();
    if ( ! $post instanceof WP_Post ) {
        return false;
    }
    $rendered = apply_filters( 'the_content', $post->post_content );
    $text       = trim( wp_strip_all_tags( str_replace( "\xc2\xa0", ' ', $rendered ) ) );
    return '' !== $text;
}

function grouphome_picture_tag( $attachment_id, $size = 'large', $alt = '' ) {
    $webp = get_post_meta( $attachment_id, '_webp_url', true );
    $src  = wp_get_attachment_image_url( $attachment_id, $size );
    $alt  = esc_attr( $alt );
    if ( $webp ) {
        return "<picture><source type=\"image/webp\" srcset=\"{$webp}\"><img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\"></picture>";
    }
    return "<img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\">";
}
