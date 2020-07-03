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
            wp_enqueue_style( 'mrt-admin', MRT_URL . '/assets/css/mrt-admin.css' );
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
                    'id' => 'jltma_mrt_onscroll',
                    'title' => esc_html__( 'Progressbar', MRT_TD )
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
                        'name'      => 'mrt_label_position',
                        'label'     => esc_html__( 'After/Before Reading Label', MRT_TD ),
                        'desc'      => esc_html__( 'Show Reading Label after/before time', MRT_TD ),
                        'type'      => 'select',
                        'default'   => 'before',
                        'options'   => array(
                            'before'        => esc_html__('Before Time', MRT_TD),
                            'after'         => esc_html__('After Time', MRT_TD)
                        )
                    ),
                    array(
                        'name'      => 'mrt_time_in_mins',
                        'label'     => esc_html__( 'Time in Minutes(mins)', MRT_TD ),
                        'desc'      => esc_html__( 'Minutes text after Time', MRT_TD ),
                        'default'   => esc_html__( 'mins', MRT_TD ),
                        'type'      => 'text'
                    ),  
                    array(
                        'name'      => 'mrt_time_in_min',
                        'label'     => esc_html__( 'Time in Minute(min)', MRT_TD ),
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


                'jltma_mrt_onscroll' => array(

                    array(
                        'name'      => 'mrt_enable_progress',
                        'label'     => esc_html__( 'Enable Progressbar', MRT_TD ),
                        'desc'      => esc_html__( 'Enable/Disable Progressbar', MRT_TD ),
                        'type'      => 'checkbox'
                    ),

                    array(
                        'name' => 'mrt_bg_color',
                        'label' => esc_html__( 'Background Color', MRT_TD ),
                        'desc' => esc_html__( 'Select Scrollbar Background Color. Default: #2c3e50', MRT_TD ),
                        'default' => '#2c3e50',
                        'type' => 'color'
                    ),
                    array(
                        'name' => 'mrt_progress_color',
                        'label' => esc_html__( 'Progress Color', MRT_TD ),
                        'desc' => esc_html__( 'Select Scroll Progressbar Color. Default: #007bff', MRT_TD ),
                        'default' => '#007bff',
                        'type' => 'color'
                    ),
                    array(
                        'name'      => 'mrt_progress_height',
                        'label'     => esc_html__( 'Progressbar Height(px)', MRT_TD ),
                        'desc'      => esc_html__( 'Set Height(px) for Scroll Progressbar Content', MRT_TD ),
                        'default'   => esc_html__( '5', MRT_TD ),
                        'type'      => 'text'
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
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Shortcode Support', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Fully Responsive', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Developer Friendly', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Max Words Per Minute', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Enable/Disable Progressbar', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Unlimited Progressbar Colors', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Progressbar Height', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'After/Before Reading Label', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Supports Excerpt', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Count Images on Reading Time', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                      <tr>
                         <td><?php esc_html_e( 'Count Shortcodes on Reading Time', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      
                      <tr>
                         <td><?php esc_html_e( 'All Themes Support', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'PHP Template Code', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( 'Extensive Documentation', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>
                      <tr>
                         <td><?php esc_html_e( '24/7 Support', MRT_TD ); ?></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-red"></span></td>
                         <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                      </tr>

                   </tbody>

                   <p style="text-align: right;">
                      <a class="button button-primary button-large" href="https://master-addons.com" target="_blank"><?php esc_html_e('View My Reading Time Pro', MRT_TD); ?>
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
                    <strong> Usage:</strong><br>
                    <code>
                        [my_reading_time mrt_label="Reading Time" mrt_time_in_mins="mins" mrt_time_in_min="minute"]
                    </code><br>

                   <strong> For Specific Post ID:</strong>
                    <code>
                        [my_reading_time mrt_label="Reading Time" mrt_time_in_mins="mins" mrt_time_in_min="minute" post_id="2"]
                    </code>
                    <br>

                    Or simply use <code>[my_reading_time]</code> to return the number with no labels.<br>

                    Want to insert the reading time into your theme? Use <code>do_shortcode('[my_reading_time]')</code>. 
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
                                <a href="https://jeweltheme.com/support/forum/wordpress-plugins/my-reading-time/" target="_blank"><?php esc_html_e( 'Visit the forums', MRT_TD ); ?></a>              
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
                        <h3>Review "My Reading Time"</h3>
                        <p>It makes us happy to hear from our users. We would appreciate a review. </p> 
                        <p><a target="_blank" href="https://wordpress.org/support/plugin/my-reading-time/reviews/#new-post">Write a review here</a></p>     
                    </div>
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Changelog</h3>
                        <p>Keep informed about each theme update. </p>  
                        <p><a target="_blank" href="https://wordpress.org/plugins/my-reading-time/#developers">See the changelog</a></p>       
                    </div>  
                    <hr style="margin-top:25px;margin-bottom:25px;">
                    <div class="jltmaf-sidebar-widget">
                        <h3>Upgrade to My Reading Time Pro</h3>
                        <p>Take your "My Reading Time" to a whole other level by upgrading to the Pro version. </p>   
                        <p><a target="_blank" href="https://master-addons.com">Discover My Reading Time Pro</a></p>      
                    </div>                                  
                </div>

            </div>

            <?php 
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
