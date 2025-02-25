<?php 

/**
 * Plugin settings.
 *
 * @link       https://bohemiaplugins.com/
 * @since      1.0.0
 *
 * @package    Help_Manager
 * @subpackage Help_Manager/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
$tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : null;
?>

<!-- Main wrapper -->
<div class="wrap wphm-wrap">

	<h1 class="wphm-page-title">
		<?php esc_html_e( 'Settings', 'help-manager' ); ?>
	</h1>

	<?php settings_errors(); ?>

	<div class="wphm-settings-wrapper">

		<!-- Tabs -->
		<div class="wphm-settings-tabs">
			<div class="inner">
				<a <?php if( $tab === null ) echo 'class="active" ';?>href="admin.php?page=help-manager-settings">
					<?php esc_html_e( 'Admin settings', 'help-manager' ); ?>
				</a>
				<a <?php if( $tab === 'document' ) echo 'class="active" ';?>href="admin.php?page=help-manager-settings&tab=document">
					<?php esc_html_e( 'Document settings', 'help-manager') ?>
				</a>
				<a <?php if( $tab === 'permissions' ) echo 'class="active" ';?>href="admin.php?page=help-manager-settings&tab=permissions">
					<?php esc_html_e( 'User permissions', 'help-manager' ); ?>
				</a>
				<a <?php if( $tab === 'custom-css' ) echo 'class="active" ';?>href="admin.php?page=help-manager-settings&tab=custom-css">
					<?php esc_html_e( 'Custom CSS', 'help-manager') ?>
				</a>
				<a <?php if( $tab === 'advanced' ) echo 'class="active" ';?>href="admin.php?page=help-manager-settings&tab=advanced">
					<?php esc_html_e( 'Advanced settings', 'help-manager') ?>
				</a>
			</div>
		</div>

		<!-- Settings form -->
		<form method="post" name="help-manager_options" action="options.php" autocomplete="off">
		
			<!------------------------------------
			---- Admin Settings
			------------------------------------>
			<?php
			if( $tab === null ) {

				$options = get_option( $this->plugin_name . '-admin' );

				if( $options !== false ) {
					
					// Make headline WPML translatable
					if( class_exists( 'SitePress' ) && defined( 'ICL_LANGUAGE_CODE' ) ) {
						$current_language = sanitize_key( ICL_LANGUAGE_CODE );
						$headline = ( isset( $options ) && isset( $options['headline_' . $current_language] ) && $options['headline_' . $current_language] !== '' ) ? esc_html( $options['headline_' . $current_language] ) : __( 'Publishing Help', 'help-manager' );
					} else {
						$headline = ( isset( $options ) && isset( $options['headline'] ) && $options['headline'] !== '' ) ? esc_html( $options['headline'] ) : __( 'Publishing Help', 'help-manager' );
					}

					$menu_icon = isset( $options['menu_icon'] ) && $options['menu_icon'] !== '' 
						? sanitize_key( $options['menu_icon'] ) 
						: 'dashicons-editor-help';
					$menu_position = isset( $options['menu_position'] )
						? intval( $options['menu_position'] )
						: 2;
					$dashboard_widget = isset( $options['dashboard_widget'] ) 
						? boolval( $options['dashboard_widget'] ) 
						: true;
					$admin_bar = isset( $options['admin_bar'] ) 
						? boolval( $options['admin_bar'] ) 
						: true;
				} else {
					$headline = _x( 'Publishing Help', 'default plugin headline', 'help-manager' );
					$menu_icon = 'dashicons-editor-help';
					$menu_position = 2;
					$dashboard_widget = true;
					$admin_bar = true;
				}

				$settings_name = $this->plugin_name . '-admin';
				settings_fields( $settings_name );
				do_settings_sections( $settings_name );

				?>

				<!-- Row -->
				<div class="wphm-docs-row wphm-settings-row">

					<!-- Headline -->
					<div class="wphm-settings-box wphm-settings-box-menu">

						<div class="wphm-settings-box-header">
							<h2><?php esc_html_e( 'Admin menu', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">
							
							<p><?php esc_html_e( 'Change the appearance of Help Manager in the WordPress admin menu.', 'help-manager' ); ?></p>

							<div class="form-field">
								<div>
									<label for="<?php echo esc_attr( $settings_name ); ?>-headline">
										<?php esc_html_e( 'Headline', 'help-manager' ); ?>
									</label>
									<?php if( class_exists( 'SitePress' ) ) { ?>
										<div class="headline-wpml">
											<?php 
											$languages = icl_get_languages('skip_missing=0&orderby=code');
											if( ! empty( $languages ) ) {
												if( defined( 'ICL_LANGUAGE_CODE' ) ) {
													$current_language = sanitize_key( ICL_LANGUAGE_CODE );
													foreach( $languages as $language ) {
														if( $language['language_code'] == $current_language ) {
															$flag_url = $language['country_flag_url'];
															echo '<div><img src="' . esc_attr( esc_url( $flag_url ) ) . '"></img></div>';
														}
													}
												}
											}
											?>
											<input type="text" id="<?php echo esc_attr( $settings_name ); ?>-headline_<?php echo esc_attr( $current_language ); ?>" name="<?php echo esc_attr( $settings_name ); ?>[headline_<?php echo ICL_LANGUAGE_CODE; ?>]" value="<?php echo esc_attr( $headline ); ?>">
										</div>
									<?php } else { ?>
										<input type="text" id="<?php echo esc_attr( $settings_name ); ?>-headline" name="<?php echo esc_attr( $settings_name ); ?>[headline]" value="<?php echo esc_attr( $headline ); ?>">
									<?php } ?>
									<p class="description"><?php esc_html_e( 'The headline is displayed in the admin menu, dashboard widget, and document listing page.', 'help-manager' ); ?>
									</p>
								</div>
							</div>

							<div class="form-field form-field-flex form-field-three">
								<div>
									<label for="<?php echo esc_attr( $settings_name ); ?>-menu_icon">
										<?php esc_html_e( 'Dashicon class', 'help-manager' ); ?>
									</label>
									<input type="text" id="<?php echo esc_attr( $settings_name ); ?>-menu_icon" name="<?php echo esc_attr( $settings_name ); ?>[menu_icon]" value="<?php echo esc_attr( $menu_icon ); ?>">
									<p class="description">
										<a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">
											<?php esc_html_e( 'Browse all Dashicons', 'help-manager' ); ?>
										</a>
									</p>
								</div>
								<div>
									<label for="<?php echo esc_attr( $settings_name ); ?>-menu_position">
										<?php esc_html_e( 'Menu order', 'help-manager' ); ?>
									</label>
									<input type="number" id="<?php echo esc_attr( $settings_name ); ?>-menu_position" name="<?php echo esc_attr( $settings_name ); ?>[menu_position]"  value="<?php echo esc_attr( $menu_position ); ?>">
									<p class="description">
										<?php printf( 
											'%s <a href="https://developer.wordpress.org/reference/functions/add_menu_page/#menu-structure" target="_blank">%s</a>',
											esc_html__( 'See values for', 'help-manager' ),
											esc_html__( 'other menu items', 'help-manager' )
										); ?>
									</p>
								</div>
							</div>

						</div>

					</div>

					<!-- Dashboard -->
					<div class="wphm-settings-box wphm-settings-box-menu">

						<div class="wphm-settings-box-header">
							<h2><?php esc_html_e( 'Admin dashboard', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">
							
							<p><?php esc_html_e( 'Show the list of help documents on the admin dashboard.', 'help-manager' ); ?></p>

							<div class="form-field form-field-radio">
								<div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-dashboard_widget" name="<?php echo esc_attr( $settings_name ); ?>[dashboard_widget]" <?php checked( $dashboard_widget, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-dashboard_widget">
											<?php esc_html_e( 'Show dashboard widget', 'help-manager' ); ?>
										</label>
									</div>
								</div>
							</div>

						</div>

					</div>

					<!-- Admin bar -->
					<div class="wphm-settings-box wphm-settings-box-menu">

						<div class="wphm-settings-box-header">
							<h2><?php esc_html_e( 'Admin bar', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">
							
							<p><?php esc_html_e( 'Show the link to help documents in the admin bar.', 'help-manager' ); ?></p>

							<div class="form-field form-field-radio">
								<div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-admin_bar" name="<?php echo esc_attr( $settings_name ); ?>[admin_bar]" <?php checked( $admin_bar, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-admin_bar">
											<?php esc_html_e( 'Show in the admin bar', 'help-manager' ); ?>
										</label>
									</div>
								</div>
							</div>

						</div>

					</div>

				</div>
				
				<!-- Submit button -->
				<div>
					<?php 
					$submit_btn_text = esc_html__( 'Save changes', 'help-manager' );
					submit_button( $submit_btn_text, 'button button-primary', 'submit', false );
					?>
				</div>
			
			<!------------------------------------
			---- Document Settings
			------------------------------------>	
			<?php
			} elseif( $tab === 'document' ) {

				$options = get_option( $this->plugin_name . '-document' );

				if( $options !== false ) {
					$quick_navigation = isset( $options['quick_navigation'] ) ? boolval( $options['quick_navigation'] ) : true;
					$child_navigation = isset( $options['child_navigation'] ) ? boolval( $options['child_navigation'] ) : true;
					$post_navigation = isset( $options['post_navigation'] ) ? boolval( $options['post_navigation'] ) : true;
					$scroll_to_top = isset( $options['scroll_to_top'] ) ? boolval( $options['scroll_to_top'] ) : true;
					$format_tables = isset( $options['format_tables'] ) ? boolval( $options['format_tables'] ) : true;
					$format_iframes = isset( $options['format_iframes'] ) ? boolval( $options['format_iframes'] ) : true;
					$image_popup = isset( $options['image_popup'] ) ? boolval( $options['image_popup'] ) : true;
				} else {
					$quick_navigation = true;
					$child_navigation = true;
					$post_navigation = true;
					$scroll_to_top = true;
					$format_tables = true;
					$format_iframes = true;
					$image_popup = true;
				}

				$settings_name = $this->plugin_name . '-document';
				settings_fields( $settings_name );
				do_settings_sections( $settings_name );
				
				?>
				
				<!-- Row -->
				<div class="wphm-docs-row wphm-settings-row">

					<!-- User interface -->
					<div class="wphm-settings-box wphm-settings-box-import">

						<div class="wphm-settings-box-header">	
							<h2><?php esc_html_e( 'Navigation features', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">
								
							<!-- <p><?php esc_html_e( 'Turn on/off document navigation features.', 'help-manager' ); ?></p> -->

							<div class="form-field form-field-radio">
								
								<div>
									<!-- <label>
										<?php esc_html_e( 'Active features', 'help-manager' ); ?>
									</label> -->
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-quick_navigation" name="<?php echo esc_attr( $settings_name ); ?>[quick_navigation]" <?php checked( $quick_navigation, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-quick_navigation">
											<?php echo esc_html__( 'Document navigation', 'help-manager' ); ?>
										</label>
									</div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-child_navigation" name="<?php echo esc_attr( $settings_name ); ?>[child_navigation]" <?php checked( $child_navigation, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-child_navigation">
											<?php echo esc_html__( 'Child documents list', 'help-manager' ); ?>
										</label>
									</div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-post_navigation" name="<?php echo esc_attr( $settings_name ); ?>[post_navigation]" <?php checked( $post_navigation, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-post_navigation">
											<?php echo esc_html__( 'Previous and next document links', 'help-manager' ); ?>
										</label>
									</div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-scroll_to_top" name="<?php echo esc_attr( $settings_name ); ?>[scroll_to_top]" <?php checked( $scroll_to_top, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-scroll_to_top">
											<?php echo esc_html__( 'Scroll to top link', 'help-manager' ); ?>
										</label>
									</div>
								</div>

							</div>

						</div>

					</div>

					<!-- Formatting Features -->
					<div class="wphm-settings-box wphm-settings-box-import">

						<div class="wphm-settings-box-header">	
							<h2><?php esc_html_e( 'Formatting features', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">
								
							<!-- <p><?php esc_html_e( 'Turn on/off automatic formatting features.', 'help-manager' ); ?></p> -->

							<div class="form-field form-field-radio">

								<div>
									<!-- <label>
										<?php esc_html_e( 'Active features', 'help-manager' ); ?>
									</label> -->
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-image_popup" name="<?php echo esc_attr( $settings_name ); ?>[image_popup]" <?php checked( $image_popup, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-image_popup">
											<?php echo esc_html__( 'Open linked images in a popup using', 'help-manager' ) . ' <a href="https://dimsemenov.com/plugins/magnific-popup/" target="_blank">Magnific Popup</a>'; ?>
										</label>
									</div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-format_iframes" name="<?php echo esc_attr( $settings_name ); ?>[format_iframes]" <?php checked( $format_iframes, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-format_iframes">
											<?php echo esc_html__( 'Responsive iframes using', 'help-manager' ) . ' <a href="https://dollarshaveclub.github.io/reframe.js/" target="_blank">Reframe.js</a>'; ?>
										</label>
									</div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-format_tables" name="<?php echo esc_attr( $settings_name ); ?>[format_tables]" <?php checked( $format_tables, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-format_tables">
											<?php echo esc_html__( 'Responsive tables', 'help-manager' ); ?>
										</label>
									</div>
								</div>

							</div>

						</div>

					</div>

				</div>

				<!-- Submit button -->
				<div>
					<?php 
					$submit_btn_text = esc_html__( 'Save changes', 'help-manager' );
					submit_button( $submit_btn_text, 'button button-primary', 'submit', false );
					?>
				</div>

			<!------------------------------------
			---- Permissions
			------------------------------------>	
			<?php
			} elseif( $tab === 'permissions' ) {

				$options = get_option( $this->plugin_name . '-permissions' );

				if( $options !== false ) {
					$admin = isset( $options['admin'] ) && is_array( $options['admin'] ) ? $options['admin'] : array();
					$editor = isset( $options['editor'] ) && is_array( $options['editor'] ) ? $options['editor'] : array();
					$reader = isset( $options['reader'] ) && is_array( $options['reader'] ) ? $options['reader'] : array();
				} else {
					// If table is missing, create it according to current assigned capabilities
					$admin = array();
					$editor = array();
					$reader = array();
				}
				
				$settings_name = $this->plugin_name . '-permissions';
				settings_fields( $settings_name );
				do_settings_sections( $settings_name );

				?>

				<!-- Row -->
				<div class="wphm-docs-row wphm-settings-row">

					<!-- User Permissions -->
					<div class="wphm-settings-box wphm-settings-box-permissions">

						<div class="wphm-settings-box-header">
							<h2><?php esc_html_e( 'Permissions', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">
								
							<p><?php esc_html_e( 'Define user permissions for accessing and modifying the help documents.', 'help-manager' ); ?></p>

							<div class="form-field form-field-flex form-field-radio form-field-highlight">

								<div class="full">
									<label><?php esc_html_e( 'Admins - can access plugin settings and change user permissions', 'help-manager' ); ?></label>
									<div class="wphm-list-half">
									<?php 
									$users = get_users( array( 
										'role' => 'administrator',
										'fields' => array( 'ID', 'user_login', 'user_email' )
									) );
									if( $users ) {
										$i = 0;
										foreach( $users as $user ) {
											$i++;
											?>
											<div>
												<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-admin_<?php echo esc_attr( $i ); ?>" name="<?php echo esc_attr( $settings_name ); ?>[admin][]" value="<?php echo esc_attr( $user->ID ); ?>" <?php if( $user->ID == get_current_user_id() ) { echo 'data-current-user="1"'; } ?> <?php checked( in_array( $user->ID, $admin ), true ); ?>>
												<label for="<?php echo esc_attr( $settings_name ); ?>-admin_<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $user->user_login ) . ' (' . esc_html( $user->user_email ) . ')'; ?></label>
											</div>
										<?php } ?>
									<?php } ?>
									</div>
								</div>

								<div class="half">
									<label><?php esc_html_e( 'Editors - can add, edit and delete help documents', 'help-manager' ); ?></label>
									<?php 
									$roles = $this->get_all_user_roles();
									if( $roles ) {
										$j = 0;
										foreach( $roles as $role_slug => $role ) {
										$j++;
										?>
										<div>
											<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-editor_<?php echo esc_attr( $j ); ?>" name="<?php echo esc_attr( $settings_name ); ?>[editor][]" value="<?php echo esc_attr( $role_slug ); ?>" <?php checked( in_array( $role_slug, $editor ), true ); ?>>
											<label for="<?php echo esc_attr( $settings_name ); ?>-editor_<?php echo esc_attr( $j ); ?>"><?php echo esc_html( $role['name'] ); ?></label>
										</div>
										<?php } ?>
									<?php } ?>
								</div>

								<div class="half">
									<label><?php esc_html_e( 'Readers - can view help documents', 'help-manager' ); ?></label>
									<?php 
									$roles = $this->get_all_user_roles();
									if( $roles ) {
										$j = 0;
										foreach( $roles as $role_slug => $role ) {
										$j++;
										?>
										<div>
											<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-reader_<?php echo esc_attr( $j ); ?>" name="<?php echo esc_attr( $settings_name ); ?>[reader][]" value="<?php echo esc_attr( $role_slug ); ?>" <?php checked( in_array( $role_slug, $reader ), true ); ?>>
											<label for="<?php echo esc_attr( $settings_name ); ?>-reader_<?php echo esc_attr( $j ); ?>"><?php echo esc_html( $role['name'] ); ?></label>
										</div>
										<?php } ?>
									<?php } ?>
								</div>

							</div>

						</div>

					</div>

				</div>

				<!-- Submit button -->
				<div>
					<?php 
					$submit_btn_text = esc_html__( 'Save changes', 'help-manager' );
					submit_button( $submit_btn_text, 'button button-primary', 'submit', false );
					?>
				</div>

			<!------------------------------------
			---- Custom CSS
			------------------------------------>	
			<?php
			} elseif( $tab === 'custom-css' ) {
				
				$options = get_option( $this->plugin_name . '-custom-css' );

				$default_css = "/* Document content wrapper */\r\n#wphm-content-main {\r\n\r\n}";
				if( $options !== false ) {
					$custom_css = isset( $options['custom-css'] ) ? $options['custom-css'] : $default_css;
				} else {
					$custom_css = $default_css;
				}

				$settings_name = $this->plugin_name . '-custom-css';
				settings_fields( $settings_name );
				do_settings_sections( $settings_name );

				?>

				<!-- Row -->
				<div class="wphm-docs-row wphm-settings-row">

					<!-- Custom CSS -->
					<div class="wphm-settings-box wphm-settings-box-import">

						<div class="wphm-settings-box-header">	
							<h2><?php esc_html_e( 'Custom CSS', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">

							<p><?php esc_html_e( 'Add custom CSS to modify the view of your help documents.', 'help-manager' ); ?></p>

							<div class="form-field">
								<div>
									<textarea name="<?php echo esc_attr( $settings_name ); ?>[custom-css]" id="<?php echo esc_attr( $settings_name ); ?>-custom-css" cols="30" rows="10"><?php echo $custom_css; ?></textarea>
								</div>
							</div>

						</div>

					</div>

				</div>

				<!-- Submit button -->
				<div>
					<?php 
					$submit_btn_text = esc_html__( 'Save changes', 'help-manager' );
					submit_button( $submit_btn_text, 'button button-primary', 'submit', false );
					?>
				</div>
			
			<!------------------------------------
			---- Advanced settings
			------------------------------------>	
			<?php
			} elseif( $tab === 'advanced' ) {
				
				$options = get_option( $this->plugin_name . '-advanced' );

				if( $options !== false ) {
					$delete_options = isset( $options['delete_options'] ) ? boolval( $options['delete_options'] ) : true;
					$delete_documents = isset( $options['delete_documents'] ) ? boolval( $options['delete_documents'] ) : false;
				} else {
					$delete_options = true;
					$delete_documents = false;
				}

				$settings_name = $this->plugin_name . '-advanced';
				settings_fields( $settings_name );
				do_settings_sections( $settings_name );

				?>

				<!-- Row -->
				<div class="wphm-docs-row wphm-settings-row">

					<!-- User interface -->
					<div class="wphm-settings-box wphm-settings-box-import">

						<div class="wphm-settings-box-header">	
							<h2><?php esc_html_e( 'Uninstall', 'help-manager' ); ?></h2>
						</div>

						<div class="wphm-settings-box-inside">
								
							<p><?php echo wp_kses_post( __( 'Choose which data you want to delete upon uninstallation. Please note that <strong>it is not possible</strong> to recover data after deletion.', 'help-manager' ) ); ?></p>

							<div class="form-field form-field-radio">
								
								<div>
									<!-- <label>
										<?php esc_html_e( 'Active features', 'help-manager' ); ?>
									</label> -->
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-delete_options" name="<?php echo esc_attr( $settings_name ); ?>[delete_options]" <?php checked( $delete_options, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-delete_options">
											<?php echo esc_html__( 'Delete plugin options', 'help-manager' ); ?>
										</label>
									</div>
									<div>
										<input type="checkbox" id="<?php echo esc_attr( $settings_name ); ?>-delete_documents" name="<?php echo esc_attr( $settings_name ); ?>[delete_documents]" <?php checked( $delete_documents, true ); ?>>
										<label for="<?php echo esc_attr( $settings_name ); ?>-delete_documents">
											<?php echo esc_html__( 'Delete help documents', 'help-manager' ); ?>
										</label>
									</div>
								</div>

							</div>

						</div>

					</div>

				</div>

				<!-- Submit button -->
				<div>
					<?php 
					$submit_btn_text = esc_html__( 'Save changes', 'help-manager' );
					submit_button( $submit_btn_text, 'button button-primary', 'submit', false );
					?>
				</div>

			<?php } ?>

		</form>

	</div>

</div>
