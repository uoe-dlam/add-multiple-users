<?php
/**
 * Handles AMU Config Settings.
 *
 * @author    Learning Applications Development Team <ltw-apps-dev@ed.ac.uk>
 * @copyright University of Edinburgh
 */
class AMU_Settings {

    public $updated;
    public $errors = [];

    public function __construct() {
        $this->initialize_options();

        // register page
        add_action( 'network_admin_menu', [ $this, 'create_setup_page' ] );

        // update settings
        add_action( 'network_admin_menu', [ $this, 'update' ] );
    }

    /**
     * Initialize network options
     *
     * @return void
     */
    public function initialize_options() {

        if ( ! get_site_option( 'amu_ldap_username_validation' ) ) {
            add_site_option( 'amu_ldap_username_validation', 0 );
        }

    }

    /**
     * Creates AMU Config settings page and menu item.
     *
     * @return AMU_Settings_Config
     */
    public function create_setup_page() {
        add_submenu_page(
            'settings.php',
            __( 'AMU Settings', 'amu-config-group' ),
            __( 'AMU Settings' ),
            'manage_options',
            'amu-options',
            [ $this, 'show_page' ]
        );

        return $this;
    }

    /**
     * Display settings page.
     *
     * @return void
     */
    public function show_page() {
        ?>

        <div class="wrap">

            <h2><?php _e( 'AMU Settings Admin', 'amu-config-group' ); ?></h2>

            <?php if ( $this->updated ) : ?>
                <div class="updated notice is-dismissible">
                    <p><?php _e( 'Settings updated successfully!', 'amu-config-group' ); ?></p>
                </div>
            <?php endif; ?>
            <?php if ( ! empty( $this->errors ) ) : ?>
                <div class="notice notice-error">
                    <?php foreach ( $this->errors as $error ) : ?>
                        <p><?php _e( $error, 'amu-config-group' ); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post">

                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="amu_ldap_username_validation">
                                <?php _e( 'Do you want to turn on ldap username validation?', 'amu-config-group' ); ?>
                            </label>
                        </th>
                        <td>
                            <input id="amu_ldap_username_validation" name="amu_ldap_username_validation" type="checkbox" value="1" <?php checked( '1', get_site_option( 'amu_ldap_username_validation' ) ); ?>>
                        </td>
                    </tr>
                </table>
                <?php wp_nonce_field( 'amu_settings_nonce', 'amu_settings_nonce' ); ?>
                <?php submit_button(); ?>

            </form>

        </div>

        <?php
    }

    /**
     * Verify settings page and update settings.
     *
     * @return void
     */
    public function update() {
        if ( isset( $_POST['submit'] ) ) {

            // verify authentication (nonce)
            if ( ! isset( $_POST['amu_settings_nonce'] ) ) {
                return;
            }

            // verify authentication (nonce)
            if ( ! wp_verify_nonce( $_POST['amu_settings_nonce'], 'amu_settings_nonce' ) ) {
                return;
            }

            $this->update_settings();
        }
    }

    /**
     * Update settings on form submission.
     *
     * @return void
     */
    public function update_settings() {

        if ( isset( $_POST['amu_ldap_username_validation'] ) ) {
            update_site_option( 'amu_ldap_username_validation', 1 );
        } else {
            update_site_option( 'amu_ldap_username_validation', 0 );
        }

        $this->updated = true;
    }

}
