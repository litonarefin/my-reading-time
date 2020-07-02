<?php 

if ( !class_exists('JLAMA_MRT_Settings_API' ) ){

    class JLAMA_MRT_Settings_API {

        private $settings_api;

        function __construct() {

            $this->settings_api = new JLAMA_MRT_Settings_API_Class;

            add_action( 'admin_init', array($this, 'jltma_mrt_admin_init') );
            add_action( 'admin_menu', array($this, 'jltma_mrt_admin_menu') );

            add_action( 'admin_enqueue_scripts', array( $this, 'jltma_mrt_admin_enqueue_scripts' ) );
        }

        public function jltma_mrt_admin_enqueue_scripts(){
            wp_enqueue_style( 'mrt-admin', MRT_URL . '/assets/mrt-admin.css' );
        }


        public function jltma_mrt_admin_init() {

            //set the settings
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );
            //initialize settings
            $this->settings_api->admin_init();
        }

        public function jltma_mrt_admin_menu() {
            add_options_page(
                esc_html__('My Reading Time Settings', MRT_TD ),
                esc_html__('My Reading Time', MRT_TD ),
                'manage_options',
                'my-reading-time-settings',
                array( $this, 'plugin_page' )
            );
        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id' => 'jltma_mrt_settings',
                    'title' => esc_html__( 'Settings', MRT_TD )
                ),
                array(
                    'id' => 'jltma_mrt_free_vs_pro',
                    'title' => esc_html__( 'Free vs Pro', MRT_TD ),
                    'callback' => [$this, 'html_only']
                )
            );
            return $sections;
        }

        function html_only(){
            return 'html';
        }
        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields() {
            
            /* My Reading Time General Settings */
            $settings_fields = array(

                'jltma_mrt_settings' => array(
                    array(
                        'name'      => 'mrt_label',
                        'label'     => esc_html__( 'Reading Time Label', MRT_TD ),
                        'desc'      => esc_html__( 'Reading Time Label', MRT_TD ),
                        'type'      => 'text',
                        'default'   => esc_html__( 'Reading Time:', MRT_TD ),
                    ),
                    array(
                        'name'      => 'mrt_time_in_mins',
                        'label'     => esc_html__( 'Time in Minutes', MRT_TD ),
                        'desc'      => esc_html__( 'Minutes text after Time', MRT_TD ),
                        'default'   => esc_html__( 'mins', MRT_TD ),
                        'type'      => 'text'
                    ),  
                    array(
                        'name'      => 'mrt_time_in_min',
                        'label'     => esc_html__( 'Time in Minute', MRT_TD ),
                        'desc'      => esc_html__( 'Minute text after Time', MRT_TD ),
                        'default'   => esc_html__( 'min', MRT_TD ),
                        'type'      => 'text'
                    ),  

                    array(
                        'name'      => 'mrt_words_per_min',
                        'label'     => esc_html__( 'Words Per Minute', MRT_TD ),
                        'desc'      => esc_html__( 'How many words can read per minute. Standard 275', MRT_TD ),
                        'default'   => esc_html__( '200', MRT_TD ),
                        'type'      => 'text'
                    ),

                    array(
                        'name'      => 'mrt_before_content',
                        'label'     => esc_html__( 'Show on before Content?', MRT_TD ),
                        'desc'      => esc_html__( 'Show "My Reading Time" before Content', MRT_TD ),
                        'type'      => 'checkbox'
                    ),


                    array(
                        'name'      => 'mrt_before_excerpt',
                        'label'     => esc_html__( 'Show on before Excerpt?', MRT_TD ),
                        'desc'      => esc_html__( 'Show "My Reading Time" before Content Excerpt', MRT_TD ),
                        'type'      => 'checkbox'
                    ),


                    array(
                        'name'      => 'mrt_exclude_images',
                        'label'     => esc_html__( 'Exclude Images from Reading Time?', MRT_TD ),
                        'desc'      => esc_html__( 'Check to exclude Images from Content Reading Time', MRT_TD ),
                        'type'      => 'checkbox'
                    ),

                    array(
                        'name'      => 'mrt_shortcodes_include',
                        'label'     => esc_html__( 'Include Shortcode Contents?', MRT_TD ),
                        'desc'      => esc_html__( 'Check to count Shortcodes Contents on Reading Time', MRT_TD ),
                        'type'      => 'checkbox'
                    ),
                ),


                'jltma_mrt_free_vs_pro' => array(
                    array(
                        'name'          => '',
                        'type'          => 'html_content',
                        'reference'     => $this->jltma_mrt_free_vs_pro()
                    ),
                )

            );

            return $settings_fields;
        }


        function jltma_mrt_free_vs_pro(){
            ob_start(); ?>

                   <thead>
                      <tr>
                         <td>
                            <strong>
                               <h3><?php esc_html_e( 'Feature', MRT_TD ); ?></h3>
                            </strong>
                         </td>
                         <td style="width:20%;">
                            <strong>
                               <h3><?php esc_html_e( 'Free', MRT_TD ); ?></h3>
                            </strong>
                         </td>
                         <td style="width:20%;">
                            <strong>
                               <h3><?php esc_html_e( 'Pro', MRT_TD ); ?></h3>
                            </strong>
                         </td>
                      </tr>
                   </thead>

                   <tbody>
                      <tr>
                         <td><?php esc_html_e( 'Elementor support', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Classic Editor Support', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Gutenberg Support', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Shortcode Generator - Classic Editor', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Gutenberg Block ( My Reading Time Accordion)', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Custom Elementor blocks(Master Accordion Addon)', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Nested FAQ', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Drag & Drop Sorting FAQ Items', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Translation ready', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Heading Tags Selection', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'FAQ by Category', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'FAQ by Tags', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Accordion/Toogle Type', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Single FAQ Template', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Open/Close Icon Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Open/Close Icon Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Icon Alignment(Left/Right) Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Collapse/Open Style(1st Open, Close All, Open All) Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Title Heading Selection Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Title Color Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Title Color Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Title Background Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Title Background Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Content Background Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Individual Content Background Settings', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                   </tbody>

                   <p style="text-align: right;">
                      <a class="button button-primary button-large" href="https://jeweltheme.com/shop/wordpress-faq-plugin/?utm_source=plugin_admin&utm_medium=button&utm_campaign=dashboard" target="_blank"><?php esc_html_e('View Master Accordion Pro', MRT_TD); ?>
                      </a>
                   </p>



        <?php 
            $output = ob_get_contents();
          ob_end_clean();
          
          return $output;
        }

       function plugin_page() {
            $user = wp_get_current_user();
            ?>

                
            <div class="info-container">

                <p class="hello-user">
                    <?php echo sprintf( __( 'Hello, %s,', MRT_TD ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?>
                </p>
                <h1 class="info-title">
                    <?php echo sprintf( __( 'Welcome to %s', MRT_TD ), MRT ); ?>
                    <span class="info-version">
                        <?php echo 'v' . MRT_VERSION; ?>    
                    </span>
                </h1>
                <p class="welcome-desc">
                    <?php _e( 'Master Accordion is now installed and ready to go. To help you with the next step, we’ve gathered together on this page all the resources you might need. We hope you enjoy using Master Accordion. You can always come back to this page by going to <strong>FAQs > Settings</strong>.', MRT_TD ); ?>
                </p>


                <div class="jltmaf-theme-tabs">
                    <?php 
                        $this->settings_api->show_navigation();
                        $this->settings_api->show_forms();
                    ?>

                    <div id="jltma_mrt_support" class="jltmaf-tab support">
                        <div class="column-wrapper">
                            <div class="tab-column">
                            <span class="dashicons dashicons-sos"></span>
                            <h3><?php esc_html_e( 'Visit our forums', MRT_TD ); ?></h3>
                            <p><?php esc_html_e( 'Need help? Go ahead and visit our support forums and we\'ll be happy to assist you with any theme related questions you might have', MRT_TD ); ?></p>
                                <a href="https://jeweltheme.com/support/forum/wordpress-plugins/wp-awesome-faq/" target="_blank"><?php esc_html_e( 'Visit the forums', MRT_TD ); ?></a>              
                                </div>
                            <div class="tab-column">
                            <span class="dashicons dashicons-book-alt"></span>
                            <h3><?php esc_html_e( 'Documentation', MRT_TD ); ?></h3>
                            <p><?php esc_html_e( 'Our documentation can help you learn how to use the theme and also provides you with premade code snippets and answers to FAQs.', MRT_TD ); ?></p>
                            <a href="https://docs.jeweltheme.com/category/wordpress-plugins/awesome-faq-pro/" target="_blank"><?php esc_html_e( 'See the Documentation', MRT_TD ); ?></a>
                            </div>
                        </div>
                    </div>

                </div> <!-- jltmaf-theme-tabs -->


                <div class="jltmaf-theme-sidebar">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Review Master Accordion</h3>
                        <p>It makes us happy to hear from our users. We would appreciate a review. </p> 
                        <p><a target="_blank" href="https://wordpress.org/support/plugin/wp-awesome-faq/reviews/#new-post">Write a review here</a></p>     
                    </div>
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Changelog</h3>
                        <p>Keep informed about each theme update. </p>  
                        <p><a target="_blank" href="https://wordpress.org/plugins/wp-awesome-faq/#developers">See the changelog</a></p>       
                    </div>  
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Upgrade to Master Accordion Pro</h3>
                        <p>Take your "Master Accordions" to a whole other level by upgrading to the Pro version. </p>   
                        <p><a target="_blank" href="https://jeweltheme.com/shop/wordpress-faq-plugin/?utm_source=plugin_admin&utm_medium=button&utm_campaign=dashboard">Discover Master Accordion Pro</a></p>      
                    </div>                                  
                </div>

            </div>

            <?php 

            // echo '</div>';
        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        function get_pages() {
            $pages = get_pages();
            $pages_options = array();
            if ( $pages ) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }
}

$settings = new JLAMA_MRT_Settings_API();
