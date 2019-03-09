<?php
/**
 * Plugin Name: NadHat sms manager
 * Plugin URI: https://www.kinoki.fr/
 * Description: Use with Nadbian
 * Version: 1.0
 * Author: Kinoki
 * Author URI: http://kinoki.fr/
 **/


/* plugin  activaté */
register_activation_hook( __FILE__, 'nadhat_sms_manager_install' );

/* plugin desactivaté*/
register_deactivation_hook( __FILE__, 'nadhat_sms_manager_remove' );


// créer la page + l'url
function nadhat_sms_manager_install() {
	global $wpdb;
	$the_page_title = 'NadHat sms manager';
	$the_page_name = 'nadhat-sms-manager';
	delete_option( "nadhat_sms_manager_title" );
	add_option( "nadhat_sms_manager_title", $the_page_title, '', 'yes' );
	delete_option( "nadhat_sms_manager_name" );
	add_option( "nadhat_sms_manager_name", $the_page_name, '', 'yes' );
	delete_option( "nadhat_sms_manager_id" );
	add_option( "nadhat_sms_manager_id", '0', '', 'yes' );
	$the_page = get_page_by_title( $the_page_title );
	if ( !$the_page ) {
		$_p = array();
		$_p[ 'post_title' ] = $the_page_title;
		$_p[ 'post_status' ] = 'publish';
		$_p[ 'post_type' ] = 'page';
		$_p[ 'comment_status' ] = 'closed';
		$_p[ 'ping_status' ] = 'closed';
		$_p[ 'post_category' ] = array( 1 );
		$the_page_id = wp_insert_post( $_p );
	} else {
		$the_page_id = $the_page->ID;
		$the_page->post_status = 'publish';
		$the_page_id = wp_update_post( $the_page );
	}
	delete_option( 'nadhat_sms_manager_id' );
	add_option( 'nadhat_sms_manager_id', $the_page_id );
}

// supprimer la page
function nadhat_sms_manager_remove() {
	global $wpdb;
	$the_page_title = get_option( "nadhat_sms_manager_title" );
	$the_page_name = get_option( "nadhat_sms_manager_name" );
	$the_page_id = get_option( 'nadhat_sms_manager_id' );
	if ( $the_page_id ) {
		wp_delete_post( $the_page_id );
	}
	delete_option( "nadhat_sms_manager_title" );
	delete_option( "nadhat_sms_manager_name" );
	delete_option( "nadhat_sms_manager_id" );
}

// affecter un template à la page
function nadhat_manager_set_page_template( $page_template ) {
	if ( is_page( 'nadhat-sms-manager' ) ) {
		$page_template = dirname( __FILE__ ) . '/templates/manager.php';
	}
	return $page_template;
}
add_filter( 'page_template', 'nadhat_manager_set_page_template' );



/* reglages du plugin */

// crer le bouton reglages sur la page du plugin
function plugin_add_settings_link( $links ) {
	$settings_link = '<a href="options-general.php?page=nadhat_manager">' . __( 'Settings' ) . '</a>';
	array_push( $links, $settings_link );
	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

// register les options
function nadhat_manager_register_settings() {
	add_option( 'nadhat_manager_ip', '' );
	add_option( 'nadhat_manager_port', '' );
	register_setting( 'nadhat_manager_options_group', 'nadhat_manager_ip', 'nadhat_manager_callback' );
	register_setting( 'nadhat_manager_options_group', 'nadhat_manager_port', 'nadhat_manager_callback' );
}
add_action( 'admin_init', 'nadhat_manager_register_settings' );

// ajouter l'onglet dans le menu reglages du site
function nadhat_manager_register_options_page() {
	add_options_page( 'Nadhat sms manager', 'Nadhat sms manager', 'manage_options', 'nadhat_manager', 'nadhat_manager_options_page' );
}
add_action( 'admin_menu', 'nadhat_manager_register_options_page' );

// afficher la page de reglages
function nadhat_manager_options_page() {
	?>
	<style>
		blockquote{
			background-color: lightgrey;
			padding: 10px;
			display: inline;
			font-family: Monaco, "Courier New", "monospace";
		}
	</style>
	<div class="wrap">
		<h1>Nadhat sms manager</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'nadhat_manager_options_group' ); ?>
			
			<table class="form-table">
				<tbody>
					
				<tr>
					<th scope="row">
						<label for="nadhat_manager_ip">IP du NadHat</label>
					</th>
					<td>
						<input class="regular-text" placeholder="http://192.168.xxx.xxx" type="text" id="nadhat_manager_ip" name="nadhat_manager_ip" value="<?php echo get_option('nadhat_manager_ip'); ?>"/>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="nadhat_manager_port">Port du NadHat</label>
					</th>
					<td>
						<input class="regular-text" placeholder="3000" type="text" id="nadhat_manager_port" name="nadhat_manager_port" value="<?php echo get_option('nadhat_manager_port'); ?>"/>
					</td>
				</tr>
					
				</tbody>
			</table>
			<?php  submit_button(); ?>
		</form>
	  <div>
		  
		  <h4>Comment configurer le NadHat ?</h4>
		  <p><a href="https://blog.garatronic.fr/index.php/fr/actualites-en/47-distribution-nadbian-lite-fr" target="_blank">https://blog.garatronic.fr/index.php/fr/actualites-en/47-distribution-nadbian-lite-fr</a></p>
		  <h4>Comment installer l'appli sur le Raspberry ?</h4>
		  <p>0- Connectez le raspberry pi à votre box internet (wifi ou rj45)</p>
		  <p>1- Connectez-vous au raspberry pi en ssh (vous pouvez connaître son adresse IP en allant sur le routeur de votre box)</p>
		  <p>2- Vous arrivez dans /home/pi, copiez-y l'appli : <blockquote>git clone git://github.com/lesitevideo/nadhat_manager</blockquote></p>
		  <p>3- Allez dans le dossier : <blockquote>cd nadhat_manager</blockquote></p>
		  <p>4- Installez l'appli : <blockquote>npm install</blockquote></p>
		  <p>5- Pour que l'appli se lance au démarrage du raspberry, editez le fichier /etc/rc.local <blockquote>sudo nano /etc/rc.local</blockquote></p>
		  <p>6- Après les commentaires du début, ajoutez la ligne <blockquote>su pi -c '/usr/bin/node /home/pi/nadhat_manager/index.js < /dev/null &'</blockquote></p>
		  <p>7- Enfin, faites un chmod pour pouvoir lire les fichiers de gammu-smsd <blockquote>sudo su</blockquote></p>
		  <p><blockquote>sudo chmod a+r /var/spool/gammu/*</blockquote></p>
		  <p><blockquote>exit</blockquote></p>
		  <p>Cette dernière opération peut sembler un problème de sécurité, mais dans la mesure où le NadHat est sur votre réseau local, il n'y a pas de risques !</p>
		</div>
		
	</div>
	<?php
}
/* fin reglages du plugin */


?>