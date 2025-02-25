<?php 

/**
 * Plugin tools.
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

?>

<!-- Main wrapper -->
<div class="wrap wphm-wrap">

	<h1 class="wphm-page-title"><?php esc_html_e( 'Tools', 'help-manager' ); ?></h1>

    <!-- Row -->
    <div class="wphm-docs-row wphm-settings-row">

        <!-- Import documents -->
        <div class="wphm-settings-box wphm-settings-box-import">

            <div class="wphm-settings-box-header">	
                <h2><?php esc_html_e( 'Import Documents', 'help-manager' ); ?></h2>
            </div>

            <div class="wphm-settings-box-inside">

                <p><?php esc_html_e( 'Use the WordPress Importer plugin to import help documents from the other Help Manager installation.', 'help-manager' ); ?></p>

                <?php
                $importer_status = $this->get_importer_status();

                // Importer not installed
                if( $importer_status === false ) {

                $importer_install_url = $this->get_importer_install_url();

                    if( $importer_install_url ) {
                    ?>
                   <a id="wphm-install-importer" class="button button-primary" href="<?php echo esc_attr( esc_url( $importer_install_url ) ); ?>"><?php esc_html_e( 'Install WordPress Importer', 'help-manager' ); ?></a>
                    <?php
                    }

                // Importer installed but not activated
                } elseif( $importer_status === 'installed' ) {

                $importer_filename = $this->get_installed_importer_filename();
                $importer_activate_url = ( $importer_filename ) ? $this->get_importer_activate_url( $importer_filename ) : false;

                    if( $importer_filename && $importer_activate_url ) {
                    ?>
                    <a id="wphm-activate-importer" class="button button-primary" href="<?php echo esc_attr( esc_url( $importer_activate_url ) ); ?>"><?php esc_html_e( 'Run WordPress Importer', 'help-manager' ); ?></a>
                    <?php
                    }

                // Importer installed and activated
                } else {
                ?>

                    <a id="wphm-run-importer" class="button button-primary" href="<?php echo esc_attr( admin_url( 'import.php?import=wordpress' ) ); ?>"><?php esc_html_e( 'Run WordPress Importer', 'help-manager' ); ?></a>

                <?php } ?>

            </div>

        </div>

        <!-- Export documents -->
        <div class="wphm-settings-box wphm-settings-box-import">

            <div class="wphm-settings-box-header">	
                <h2><?php esc_html_e( 'Export Documents', 'help-manager' ); ?></h2>
            </div>

            <div class="wphm-settings-box-inside">
                <form id="wphm-export-form" method="post">
                    
                    <?php 
                    $docs = get_posts( array( 
                        'post_type'         => 'help-docs',
                        'fields'            => 'ids',
                        'numberposts'       => -1,
                        'suppress_filters'	=> false
                    ) );
                    if( $docs ) {
                    ?>

                    <?php wp_nonce_field( 'wphm_export_form', 'wphm_export_nonce' );?>
                    <input type="hidden" name="action" value="export_help_documents">
                    
                    <p><?php esc_html_e( 'Select help documents you would like to export and use the download button to export to an XML file which you can then import to another Help Manager installation.', 'help-manager' ); ?></p>

                    <?php } else { ?>

                    <p><?php esc_html_e( 'There are no documents to export.', 'help-manager' ); ?></p>

                    <?php } ?>

                    <div class="form-field form-field-flex form-field-radio form-field-highlight">

                        <?php if( $docs ) { ?>
                        <div class="full">
                            <label><?php esc_html_e( 'Select documents' ); ?></label>
                            <div class="wphm-list-half">
                                <div>
                                    <input type="checkbox" name="wphm_docs_all" id="wphm_docs_all">
                                    <label for="wphm_docs_all">
                                        <?php esc_html_e( 'Toggle All', 'help-manager' ); ?>
                                    </label>
                                </div>
                                <?php
                                foreach( $docs as $document ) {
                                ?>
                                    <div>
                                        <input type="checkbox" name="wphm_docs[]" id="wphm_docs-<?php echo esc_attr( $document ); ?>" value="<?php echo esc_attr( $document ); ?>">
                                        <label for="wphm_docs-<?php echo esc_attr( $document ); ?>">
                                            <?php echo get_the_title( $document ); ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                    <?php if( $docs ) { ?>
                    <div class="form-field form-field-submit">
                        <div>
                            <input class="button button-primary" type="submit" value="<?php esc_attr_e( 'Export File', 'help-manager' ); ?>">
                        </div>
                    </div>
                    <?php } ?>

                </form>
            </div>

        </div>
    
    </div>

</div>
