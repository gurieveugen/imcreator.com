<?php
class GCOptionsPage{
    //                          __              __      
    //   _________  ____  _____/ /_____ _____  / /______
    //  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
    // / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
    // \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
    const PARENT_PAGE = 'themes.php';
    //                __  _                 
    //   ____  ____  / /_(_)___  ____  _____
    //  / __ \/ __ \/ __/ / __ \/ __ \/ ___/
    // / /_/ / /_/ / /_/ / /_/ / / / (__  ) 
    // \____/ .___/\__/_/\____/_/ /_/____/  
    //     /_/                              
    private $options;

    //                    __  __              __    
    //    ____ ___  ___  / /_/ /_  ____  ____/ /____
    //   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
    //  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
    // /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_submenu_page(self::PARENT_PAGE, __('Default social options'), __('Default social options'), 'administrator', __FILE__, array($this, 'create_admin_page'), 'favicon.ico'); 
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        $this->options = $this->getAllOptions();       

        ?>
        <div class="wrap">
            <?php screen_icon(); ?>                 
            <form method="post" action="options.php">
            <?php                
                settings_fields('gc_options_page');   
                do_settings_sections(__FILE__);
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Get all options
     */
    public function getAllOptions()
    {
        return get_option('gcoptions');
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting('gc_options_page', 'gcoptions', array($this, 'sanitize'));
        add_settings_section('default_settings', __('Options'), null, __FILE__); 

        add_settings_field('default_facebook_page', __('Default Facebook Page'), array($this, 'default_facebook_page_callback'), __FILE__, 'default_settings');
        add_settings_field('default_twitter_username', __('Default twitter user name'), array($this, 'default_twitter_username_callback'), __FILE__, 'default_settings');        
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();     

        if(isset($input['default_facebook_page'])) $new_input['default_facebook_page']       = strip_tags($input['default_facebook_page']);
        if(isset($input['default_twitter_username'])) $new_input['default_twitter_username'] = strip_tags($input['default_twitter_username']);

        return $new_input;
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function default_facebook_page_callback()
    {
        printf('<input type="text" id="default_facebook_page" name="gcoptions[default_facebook_page]" value="%s" />', isset($this->options['default_facebook_page']) ? esc_attr($this->options['default_facebook_page']) : '');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function default_twitter_username_callback()
    {
        printf('<input type="text" id="default_twitter_username" name="gcoptions[default_twitter_username]" value="%s" />', isset($this->options['default_twitter_username']) ? esc_attr($this->options['default_twitter_username']) : '');
    }
}
// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['gcoptions'] = new GCOptionsPage();