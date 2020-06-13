<?php

if (!class_exists('Assets_Manager')) {

    class Assets_Manager
    {
        use Singleton;

        public static function register()
        {
            $instance = self::get_instance();

//            add_action('admin_enqueue_scripts', [$instance, 'admin_assets']);
            add_action('wp_enqueue_scripts', [$instance, 'dev_frontend_assets']);
        }

        public function admin_assets()
        {

            if (is_admin()) {
                $this->wordpress_special_assets();
            }

            $scripts = [
                'ammap' => 'https://www.amcharts.com/lib/3/ammap.js',
                'wordflow' => 'https://www.amcharts.com/lib/3/maps/js/worldLow.js',
                'light' => 'https://www.amcharts.com/lib/3/themes/light.js',
                'theme_options' => THEME_URL . '/admin/js/theme_options.js'
            ];

            $styles = [
                'theme_options' => THEME_URL . '/admin/css/theme_options.css',
                'services_metabox' => THEME_URL . '/admin/css/services_metabox.css'
            ];

            wp_enqueue_style('services_metabox', $styles['services_metabox']);
            wp_enqueue_style('theme_options', $styles['theme_options'], '', '5.7');
            wp_enqueue_style('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css');
            wp_enqueue_style('codemirror-theme', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.30.0/theme/dracula.css');

            wp_enqueue_script('ammap', $scripts['ammap'], []);
            wp_enqueue_script('wordflow', $scripts['wordflow'], []);
            wp_enqueue_script('light', $scripts['light'], []);

            wp_enqueue_script('theme_options', $scripts['theme_options'], ['jquery'], '5.8');
        }

        private function wordpress_special_assets()
        {

            wp_enqueue_media();

            wp_enqueue_script('picture-upload', THEME_URL . '/admin/js/media-uploader.js', [
                'jquery',
                'media-upload',
                'thickbox'
            ], true);

            wp_enqueue_style('wp-color-picker');

            wp_enqueue_script('codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js', [], true);
            wp_enqueue_script('codemirror-xml', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js', [], true);

            wp_enqueue_script('iris', admin_url('js/iris.min.js'), [
                'jquery-ui-draggable',
                'jquery-ui-slider',
                'jquery-touch-punch'
            ], false, 1);

            wp_enqueue_script('wp-color-picker', admin_url('js/color-picker.min.js'), ['iris'], false, 1);
        }

        public function dev_frontend_assets()
        {

            $v_style_main = filemtime(THEME_DIR . '/assets/css/main.css');
            $v_script_main = filemtime(THEME_DIR . '/assets/js/main.js');

            $scripts = [
                'main-js' => ASSETS . '/js/main.js?v=' . $v_script_main,
            ];

            $styles = [
                'main-css' => ASSETS . '/css/main.css?v=' . $v_style_main
            ];

            wp_enqueue_script('main-js', $scripts['main-js'], ['jquery'], null, true);
            wp_enqueue_style('main-css', $styles['main-css'], null);

//            wp_localize_script('main-js', 'wpVars', [
//                'ajaxUrl' => admin_url('admin-ajax.php'),
//                'postNonce' => wp_create_nonce('ajax-post-nonce'),
//                'shareLinkedin' => get_option('follow_linkedin'),
//                'appAsset' => APP_SITE,
//                'appSiteUrl' => APP_SITE,
//                'appStorage' => APP_SITE . 'storage/'
//            ]);
//
//            remove_action('comment_form', ['Akismet', 'load_form_js']);
//            wp_dequeue_style('wsl-widget');
        }
    }
}