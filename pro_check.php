<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'smartchat';

$languages = [
  'en_english' => 'English',
  'pt_portuguese' => 'Português',
  'es_spanish' => 'Español',
  'fr_french' => 'Français',
  'de_german' => 'Deutsch',
  'it_italian' => 'Italiano'
  /*'ja_japanese' => '日本語',
  'zh_chinese' => '中文',
  'ar_arabic' => 'العربية',
  'bn_bengali' => 'বাংলা',
  'gu_gujarati' => 'ગુજરાતી',
  'hi_hindi' => 'हिन्दी',
  'id_indonesian' => 'Bahasa Indonesia',
  'jv_javanese' => 'Basa Jawa',
  'ko_korean' => '한국어',
  'mr_marathi' => 'मराठी',
  'pa_punjabi' => 'ਪੰਜਾਬੀ',
  'ru_russian' => 'Русский',
  'sw_swahili' => 'Kiswahili',
  'ta_tamil' => 'தமிழ்',
  'te_telugu' => 'తెలుగు',
  'tr_turkish' => 'Türkçe',
  'uk_ukrainian' => 'Українська',
  'ur_urdu' => 'اردو',
  'vi_vietnamese' => 'Tiếng Việt',
  'yo_yoruba' => 'Yorùbá',
  'zu_zulu' => 'isiZulu'*/
];
asort($languages);

// Store user's language preference
$language_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'language'");
$acronym_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'acronym'");

// Set default language
$default_language = 'en';

// Detect user's language preference
if (isset($_SESSION['language'])) {
    $acronym = sanitize_text_field($_SESSION['language']);
} else {
    $acronym = sanitize_text_field(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
}
if ( ! ctype_alpha( $acronym ) ) {
   $acronym = 'en';
}

if (count($language_result) > 0) {
  $language_sql = $language_result[0]->Data;
  $acronym_sql = $acronym_result[0]->Data;
  $language = $language_sql;
  $acronym = $acronym_sql;
}

// Load language file
include_once ( plugin_dir_path( __FILE__ ) . 'languages/' . $acronym . '.php' );

$key = '';
$key_ver = $wpdb->get_var( "SELECT Data FROM $table_name WHERE Features = 'key'" );
if ( !empty( $key_ver ) ) {
    $key = 1;
}
?>

<div class="g-sidenav-show bg-gray-100 margin-body">
	<div class="container-fluid py-4 centralizar">				
	<form method="post">
		
		<div class="container-fluid width-admin">
			<div class="page-header min-width-800 min-height-150 border-radius-xl mt-4" style="background-image: url('<?php echo plugin_dir_url( __FILE__ ) . 'img/curved0.jpg'; ?>'); background-position-y: 50%;">
				<span class="mask bg-gradient-primary opacity-6"></span>
			</div>
			<div class="card card-body blur shadow-blur mx-4 mt-n6 centralizar">
				<div class="row gx-4">
					<div class="col-auto">
						<div href="https://agendavirtual.net/app" class="m-5 text-center ">
							<img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/logo_smartchat.png'; ?>" alt="Logo Agenda Virtual" width="200px" height="auto">
						</div>
					</div>
				</div>
			</div>
		</div>
	
			<div class="container-fluid py-4 centralizar">				
				<div class="card container-fluid min-width-800">
					<div class="card-body pt-4 p-3">
							<div class="row">
								<!-- Nome de usuário -->				
								<div class="col-md-12">
									<div class="form-group">
									<?php
									if ( !empty( $key ) ) {
										?>
										<div class="m-3 centralizar d-flex  p-2 centralizar">
											<div class="icon icon-shape rounded-circle bg-gradient-success shadow text-center">
												<i class="fas fa-check opacity-10" aria-hidden="true"></i>
											</div>
											<div>
												<h4 class="ps-3 pt-1 opacity-8"><?php echo esc_attr($lang['pro_version_active']); ?></h4>
											</div>
										</div>
									<?php }else{?>
										<div class="m-3 centralizar">
											<h6 class="mb-0"><?php echo esc_attr($lang['key_code']); ?></h6>
										</div>
									<?php }?>
										<label class="form-control-label" for="url"><?php echo esc_attr($lang['key_code']); ?></label>
										<input class="form-control" value="<?php echo esc_attr($key_ver); ?>" placeholder="<?php echo esc_attr($lang['key_code_here']); ?>" type="text" name="key" id="key" required autocomplete="off" autofocus="">
									</div>
								</div>
							</div>


							<div class="text-center">
								<button type="submit" name="submit" id="kt_sign_in_submit" class="btn bg-gradient-primary mt-3 w-100">
									<span class="indicator-label"><?php echo esc_attr($lang['save']); ?></span>
								</button>
							</div>		
						<a href="<?php echo admin_url( 'admin.php?page=smartchat-admin' ); ?>"><?php echo esc_attr($lang['return']); ?></a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
if(isset($_POST['submit'])) {
    $keycode = sanitize_text_field($_POST['key']);
	if ( ! ctype_alnum( $keycode ) ) {
		$keycode = NULL;
	}
    $url = 'http://smartchat.agendavirtual.net/validation/?key=' . $keycode;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$params = array();
    $response = wp_remote_post( $url, array(
		'method' => 'POST',
		'body' => $params
	) );

	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
	} else {
		$resposta = wp_remote_retrieve_body( $response );
	}
    curl_close($ch);
	
	$inicio = strpos($resposta, "Value@:") + strlen("Value@:");
	$fim = strpos($resposta, "end@", $inicio);
	$dados = substr($resposta, $inicio, $fim - $inicio);
}

if(isset($dados) && !empty($dados)) {
	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE Features = 'key'" );
	if ( count( $results ) > 0 ) {
		$wpdb->update( $table_name, array(
			'Data' => $dados,
		), array(
			'Features' => 'key',
		) );
	} else {
		$wpdb->insert( $table_name, array(
			'Features' => 'key',
			'Data' => $dados,
		) );
	}
}

?>