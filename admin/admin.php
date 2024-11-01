<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'smartchat';

$sql = "CREATE TABLE $table_name (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    Features VARCHAR(255) NOT NULL,
    Data VARCHAR(2048) NOT NULL,
    PRIMARY KEY (ID)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

 //Reply
  $key = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'key'");
  if ($key == NULL) {
    $wpdb->insert($table_name, array('Features' => 'key', 'Data' => 'pro'));
  }
  
$features = array(
  array('name' => 'icon', 'data' => 'fas fa-comment'),
  array('name' => 'language', 'data' => 'english'),
  array('name' => 'acronym', 'data' => 'en'),
  array('name' => 'Cor', 'data' => '#ff6600'),
  array('name' => 'URL', 'data' => 'Smartchat')
);

foreach ($features as $feature) {
  $result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = '".$feature['name']."'");
  if ($result == NULL) {
    $wpdb->insert($table_name, array('Features' => $feature['name'], 'Data' => $feature['data']));
  }
}

if (isset($_POST['submit'])) {
  
  $url = sanitize_text_field($_POST['url']);
  $visible = sanitize_text_field($_POST['visible']);
  $icon = sanitize_text_field($_POST['icon']);
  $cor = sanitize_text_field($_POST['cor']);
  $position = sanitize_text_field($_POST['position']);
  $personality = sanitize_text_field($_POST['personality']);
  $language = sanitize_text_field($_POST['language']);
  $language_parts = explode('_', $language);
  $language = $language_parts[1];
  $acronym = $language_parts[0];
  $info = sanitize_text_field($_POST['info']);
  $time = isset($_POST['time']) && $_POST['time'] == '1' ? '1' : '0';
  $hide_logo = isset($_POST['hide_logo']) && $_POST['hide_logo'] == '1' ? '1' : '0';

  $nome_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'Cor'");
  if (count($nome_result) > 0) {
    $wpdb->update($table_name, array('Data' =>$cor), array('Features' => 'Cor'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'Cor', 'Data' => $cor));
  }
  
  $visible_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'visible'");
  if (count($visible_result) > 0) {
    $wpdb->update($table_name, array('Data' =>$visible), array('Features' => 'visible'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'visible', 'Data' => $visible));
  }
  
  $icon_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'icon'");
  if (count($icon_result) > 0) {
    $wpdb->update($table_name, array('Data' =>$icon), array('Features' => 'icon'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'icon', 'Data' => 'fas fa-comment'));
  }

  $url_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'URL'");
  if (count($url_result) > 0) {
    $wpdb->update($table_name, array('Data' => $url), array('Features' => 'URL'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'URL', 'Data' => $url));
  }
  
  $info_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'info'");
  if (count($info_result) > 0) {
    $wpdb->update($table_name, array('Data' => $info), array('Features' => 'info'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'info', 'Data' => $info));
  }
  
  $time_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'time'");
  if (count($time_result) > 0) {
    $wpdb->update($table_name, array('Data' => $time), array('Features' => 'time'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'time', 'Data' => $time));
  } 
  
  $hide_logo_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'hide_logo'");
  if (count($hide_logo_result) > 0) {
    $wpdb->update($table_name, array('Data' => $hide_logo), array('Features' => 'hide_logo'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'hide_logo', 'Data' => $hide_logo));
  }

  $position_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'position'");
  if (count($position_result) > 0) {
    $wpdb->update($table_name, array('Data' => $position), array('Features' => 'position'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'position', 'Data' => $position));
  }
  $personality_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'personality'");
  if (count($personality_result) > 0) {
    $wpdb->update($table_name, array('Data' => $personality), array('Features' => 'personality'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'personality', 'Data' => $personality));
  }
  $language_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'language'");
  if (count($language_result) > 0) {
    $wpdb->update($table_name, array('Data' => $language), array('Features' => 'language'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'language', 'Data' => $language));
  }
  $acronym_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'acronym'");
  if (count($acronym_result) > 0) {
    $wpdb->update($table_name, array('Data' => $acronym), array('Features' => 'acronym'));
  } else {
    $wpdb->insert($table_name, array('Features' => 'acronym', 'Data' => $acronym));
  }
}

$max_info_characters = "2000";

// código para buscar os valores armazenados na tabela e preencher os campos correspondentes, caso existam

$key = '';
$key_ver = $wpdb->get_var( "SELECT Data FROM $table_name WHERE Features = 'key'" );
if ( !empty( $key_ver ) ) {
    $key = 1;
}

$nome_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'Cor'");
$cor = '';
if (count($nome_result) > 0) {
  $cor = $nome_result[0]->Data;
}

$visible_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'visible'");
$visible = '';
if (count($visible_result) > 0) {
  $visible = $visible_result[0]->Data;
}

$icon_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'icon'");
$icon = '';
if (count($icon_result) > 0) {
  $icon = $icon_result[0]->Data;
}

$url_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'URL'");
$url = '';
if (count($url_result) > 0) {
  $url = $url_result[0]->Data;
}

$info_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'info'");
$info = '';
if (count($info_result) > 0) {
  $info = $info_result[0]->Data;
}

$time_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'time'");
$time = '';
if (count($time_result) > 0) {
  $time = $time_result[0]->Data;
}

$hide_logo_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'hide_logo'");
$hide_logo = '';
if (count($hide_logo_result) > 0) {
  $hide_logo = $hide_logo_result[0]->Data;
}

$position_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'position'");
$position = 'inferior_direito'; // definindo "inferior_direito" como padrão
if (count($position_result) > 0) {
  $position = $position_result[0]->Data;
}

$personality_result = $wpdb->get_results("SELECT * FROM $table_name WHERE Features = 'personality'");
$personality = 'divertida'; // definindo "divertida" como padrão
if (count($personality_result) > 0) {
  $personality = $personality_result[0]->Data;
}

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

if ( empty( $key ) ) {
	$hide_logo = 0;
	$time = 0;
}
?>
<div class="g-sidenav-show bg-gray-100 margin-body">
	<div class="container-fluid py-4 centralizar">				
		<form method="post">
		
		<div class="container-fluid width-admin">
			<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('<?php echo plugin_dir_url( __FILE__ ) . 'img/curved0.jpg'; ?>'); background-position-y: 50%;">
				<span class="mask bg-gradient-primary opacity-6"></span>
			</div>
			<div class="card card-body blur shadow-blur mx-4 mt-n6">
				<div class="row gx-4">
					<div class="col-auto">
						<div href="https://agendavirtual.net/app" class="m-5 text-center ">
							<img src="<?php echo plugin_dir_url( __FILE__ ) . 'img/logo_smartchat.png'; ?>" alt="Logo Agenda Virtual" width="200px" height="auto">
						</div>
					</div>
					<div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
						<div class="nav-wrapper position-relative end-0 text-center">
							<label class="form-control-label" for="language"><?php echo esc_attr(strtoupper($lang['language'])); ?></label></br>
							<!-- idioma -->				
							<div class="col-md-12">
								<div class="form-group">
									<select id="language" name="language">
									<?php foreach ($languages as $code => $language): ?>
									  <option value="<?php echo esc_attr($code); ?>"<?php if ($code === $acronym_sql . "_" . $language_sql) { echo ' selected'; } ?>><?php echo esc_attr($language); ?></option>
									<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
			<div class="container-fluid py-4 centralizar">				
				<div class="card container-fluid">
					<h5 class="opacity-9 centralizar"><?php echo esc_attr($lang['title']); ?></h5>
					<hr class="horizontal dark mt-1 mb-3">
					<div class="card-body pt-4 p-3">
							<div class="row">
								<!-- Nome de usuário -->				
								<div class="col-md-4">
									<div class="form-group">
										<label class="form-control-label" for="url"><?php echo esc_attr($lang['assistant_name']); ?></label>
										<input class="form-control" value="<?php echo esc_attr($url); ?>" placeholder="<?php echo esc_attr($lang['assistant_name_placeholder']); ?>" type="text" name="url" required="" autocomplete="off" autofocus="">
									</div>
								</div>
								
								<!-- Personalidade -->	
								<div class="col-md-8">
									<div class="form-group">
										<label class="form-control-label" for="personality"><?php echo esc_attr($lang['speaking_style']); ?></label></br>
										<select class="form-control" name="personality" required>
											<option value="formal, respectful, and professional" <?php echo ($personality === 'formal, respectful, and professional') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_formal']); ?></option>
											<option value="friendly, establishing an emotional connection" <?php echo ($personality === 'friendly, establishing an emotional connection') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_friendly']); ?></option>
											<option value="fun, playful, and relaxed" <?php echo ($personality === 'fun, playful, and relaxed') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_fun']); ?></option>
											<option value="polite, courteous, and refined" <?php echo ($personality === 'polite, courteous, and refined') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_polite']); ?></option>
											<option value="technical, precise, and objective, providing detailed information" <?php echo ($personality === 'technical, precise, and objective, providing detailed information') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_technical']); ?></option>
											<option value="empathetic, understanding, showing solidarity and concern" <?php echo ($personality === 'empathetic, understanding, showing solidarity and concern') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_empathetic']); ?></option>
											<option value="youthful, relaxed, and informal" <?php echo ($personality === 'youthful, relaxed, and informal') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_youthful']); ?></option>
											<option value="direct, offering brief and precise answers" <?php echo ($personality === 'direct, offering brief and precise answers') ? 'selected' : ''; ?>><?php echo esc_attr($lang['speaking_style_direct']); ?></option>
										  </select>
									</div>
								</div>
							</div>
							<div class="row">
								<!-- Informações -->				
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-control-label" for="info"><?php echo esc_attr($lang['main_informations']); ?></label><label class="form-control-label text-muted"><?php echo esc_attr($lang['maximum'] . " " . $max_info_characters . " " . $lang['characters']); ?></label></br>
										<textarea class="form-control form-control-lg" name="info" rows="5" maxlength="<?php echo esc_attr($max_info_characters); ?>" placeholder="<?php echo esc_attr($lang['maximum_characters_placeholder']); ?>"><?php echo esc_attr($info); ?></textarea>
									</div>
								</div>
							</div>

							<input type="hidden" name="visible" value="1">
							<div class="row"> 
								<!-- Cor do botão -->
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-control-label" for="cor"><?php echo esc_attr($lang['button_color']); ?></label>
										<input class="form-control form-control-solid" value="<?php echo esc_attr($cor); ?>" type="color" name="cor">
									</div>
								</div>
								<!-- Icon Picker -->
								<div class="col-md-3">
									<div class="form-group">
										<label class="form-control-label" for="cor"><?php echo esc_attr($lang['choose_icon']); ?></label><br/>
										<button class="btn btn-secondary" data-placement="left" data-icon="<?php echo esc_attr($icon); ?>" role="iconpicker"></button>
									</div>
								</div>
								<!-- Posição -->
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-control-label" for="position"><?php echo esc_attr($lang['position']); ?></label></br>
										<select class="form-control" name="position" required>
											<option value="inferior_direito" <?php echo ($position === 'inferior_direito') ? 'selected' : ''; ?>><?php echo esc_attr($lang['position_bottom_right']); ?></option>
											<option value="inferior_esquerdo" <?php echo ($position === 'inferior_esquerdo') ? 'selected' : ''; ?>><?php echo esc_attr($lang['position_bottom_left']); ?></option>
											<option value="superior_direito" <?php echo ($position === 'superior_direito') ? 'selected' : ''; ?>><?php echo esc_attr($lang['position_top_right']); ?></option>
											<option value="superior_esquerdo" <?php echo ($position === 'superior_esquerdo') ? 'selected' : ''; ?>><?php echo esc_attr($lang['position_top_left']); ?></option>
										  </select>
									</div>
								</div>
							</div>
								<div class="row">
									<!-- Tempo de resposta -->				
									<div class="col-md-6">
										<div class="form-group">
											<div class="form-check form-switch ms-auto">
												<input class="form-check-input" type="checkbox" id="time" name="time" value="1" <?php echo $time == '1' ? 'checked' : ''; ?> <?php echo $key != 1 ? 'disabled' : ''; ?>>
												<label class="form-control-label" for="time"><?php echo esc_attr($lang['simulate_real_conversation']); ?><i class="fas fa-question-circle ms-1" title="<?php echo esc_attr($lang['simulate_real_conversation_help']); ?>"></i></label></br>											
											</div>
										</div>
									</div>
									
									<!-- Logo -->	
									<div class="col-md-6">
										<div class="form-group">
											<div class="form-check form-switch ms-auto">
												<input class="form-check-input" type="checkbox" id="hide_logo" name="hide_logo" value="1" <?php echo $hide_logo == '1' ? 'checked' : ''; ?> <?php echo $key != 1 ? 'disabled' : ''; ?>>
												<label class="form-control-label" for="hide_logo"><?php echo esc_attr($lang['hide_logo']); ?></label></br>
											</div>
										</div>
									</div>
								</div>
							<div class="text-center">
								<button type="submit" name="submit" id="kt_sign_in_submit" class="btn bg-gradient-primary mt-3 w-100">
									<span class="indicator-label"><?php echo esc_attr($lang['save']); ?></span>
								</button>
							</div>		
					</div>
				</div>
			</div>
		</form>
	</div>
</div>