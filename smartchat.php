<?php
/*
Plugin Name: Smartchat - ChatGPT on your website
Plugin URI: https://smartchat.agendavirtual.net
Description: Transforme a interação com seus clientes com nosso incrível plugin de assistente virtual, que utiliza a inteligência artificial do ChatGPT para fornecer respostas precisas e eficientes em tempo real. Insira facilmente informações importantes para que a assistente virtual possa personalizar as respostas de acordo com as necessidades dos usuários e aprimorar a experiência do cliente.
Version: 2.2.6
Author: Smartchat
Author URI: https://smartchat.agendavirtual.net
License: GPL2
*/

// Carrega o script JavaScript
function plugin_smartchat() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartchat';
    $url = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'URL'");
    $visible = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'visible'");
    $cor = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'Cor'");
    $position_button = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'position'");
    $icon = $wpdb->get_var("SELECT Data FROM $table_name WHERE Features = 'icon'");
    
    wp_enqueue_script( 'bootstrap-script', plugin_dir_url( __FILE__ ) . 'public/js/bootstrap.bundle.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'smartchat-script', plugin_dir_url( __FILE__ ) . 'public/js/smartchat-script.js', array( 'bootstrap-script' ), '2.1.1', true );
    wp_enqueue_style( 'smartchat-style', plugin_dir_url( __FILE__ ) . 'public/css/smartchat.css', array(), '1.6.5' );
	wp_enqueue_style( 'smartchat-script', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');

    $data = array('url' => $url);
    wp_localize_script('smartchat-script', 'smartChatData', $data);
    $dataview = array('visible' => $visible);
    wp_localize_script('smartchat-script', 'smartChatVisible', $dataview);
    $dataposition = array('position' => $position_button);
    wp_localize_script('smartchat-script', 'smartChatDataPosition', $dataposition);
    $dataicon = array('icon' => $icon);
    wp_localize_script('smartchat-script', 'smartChatDataIcon', $dataicon);
    $datacor = array('cor' => $cor);
    wp_localize_script('smartchat-script', 'smartChatDataCor', $datacor);
}
add_action( 'wp_enqueue_scripts', 'plugin_smartchat' );

//Area adminsitrativa do Plugin
function smart_chat_admin_menu() {
    global $pagenow;
	
	if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] === 'smartchat-admin' ) {
        wp_enqueue_style( 'smartchat-style', plugin_dir_url( __FILE__ ) . 'admin/css/admin-av.css', array(), '1.8', false );
        wp_enqueue_style( 'fontawesome-style', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');
        wp_enqueue_script( 'jquery-script', plugin_dir_url( __FILE__ ) . 'public/js/bootstrap.bundle.min.js', array(), '5.2.3', true );
        wp_enqueue_script( 'smartchat-script', plugin_dir_url( __FILE__ ) . 'admin/js/av_admin.js', array(), '1.4', true );
	}

    add_menu_page(
        'Smartchat',
        'Smartchat',
        'manage_options',
        'smartchat-admin',
        'smart_chat_admin_page',
		'dashicons-format-status',
		'15'
    );
}

add_action( 'admin_menu', 'smart_chat_admin_menu' );

function smart_chat_admin_page() {
	include( plugin_dir_path( __FILE__ ) . 'admin/admin.php' );
}

// Função para a página "smartchat-pro-check"
function smart_chat_pro_check_page() {
	include_once( plugin_dir_path( __FILE__ ) . 'admin/pro_check.php' );
}

add_action('wp_ajax_update_visible', 'update_visible');
add_action('wp_ajax_nopriv_update_visible', 'update_visible');

function smart_chat_html() {
    echo '<div class="botao-smartchat"></div>';
    echo '<div id="virtual-assistant-box" class="virtual-assistant-box">';
    include(plugin_dir_path(__FILE__) . 'public/chat.php');
    echo '</div>';
    
    // Adicionando o script abaixo
    echo '<script type="text/javascript">';
    echo '$("#smc-message").on(\'keypress\', function (e) {
            if (e.key === \'Enter\' || e.keyCode === 13) {
                $("#submit").click();
                $(\'#virtual-assistant-box\').scrollTop($(\'#virtual-assistant-box\')[0].scrollHeight);
            }
        });
        $(document).ready(function() {
            $("#virtual-assistant-box").hover(function() {
                $(this).css("overflow-y", "scroll");
            }, function() {
                $(this).css("overflow-y", "hidden");
            });
        });';
    echo '</script>';
}

add_action( 'wp_footer', 'smart_chat_html' );

?>
