<?php

  /**
   * blank_riders functions and definitions
   *
   * @link https://developer.wordpress.org/themes/basics/theme-functions/
   *
   * @package blank_riders
   */
  if (!function_exists('blank_riders_setup')) :

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        function blank_riders_setup() {
              /*
               * Make theme available for translation.
               * Translations can be filed in the /languages/ directory.
               * If you're building a theme based on blank_riders, use a find and replace
               * to change 'blank_riders' to the name of your theme in all the template files.
               */
              load_theme_textdomain('blank_riders', get_template_directory() . '/languages');

              // Add default posts and comments RSS feed links to head.
              add_theme_support('automatic-feed-links');

              /*
               * Let WordPress manage the document title.
               * By adding theme support, we declare that this theme does not use a
               * hard-coded <title> tag in the document head, and expect WordPress to
               * provide it for us.
               */
              add_theme_support('title-tag');

              /*
               * Enable support for Post Thumbnails on posts and pages.
               *
               * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
               */
              add_theme_support('post-thumbnails');

              // This theme uses wp_nav_menu() in one location.
              register_nav_menus(array(
                    'menu-1' => esc_html__('Primary', 'blank_riders'),
              ));

              /*
               * Switch default core markup for search form, comment form, and comments
               * to output valid HTML5.
               */
              add_theme_support('html5', array(
                    'search-form',
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
              ));

              // Set up the WordPress core custom background feature.
              add_theme_support('custom-background', apply_filters('blank_riders_custom_background_args', array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
              )));

              // Add theme support for selective refresh for widgets.
              add_theme_support('customize-selective-refresh-widgets');

              /**
               * Add support for core custom logo.
               *
               * @link https://codex.wordpress.org/Theme_Logo
               */
        }

  endif;
  add_action('after_setup_theme', 'blank_riders_setup');

  /**
   * Set the content width in pixels, based on the theme's design and stylesheet.
   *
   * Priority 0 to make it available to lower priority callbacks.
   *
   * @global int $content_width
   */
  function blank_riders_content_width() {
        // This variable is intended to be overruled from themes.
        // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        $GLOBALS['content_width'] = apply_filters('blank_riders_content_width', 640);
  }

  add_action('after_setup_theme', 'blank_riders_content_width', 0);

  /**
   * Register widget area.
   *
   * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
   */
  function blank_riders_widgets_init() {
        register_sidebar(array(
              'name' => esc_html__('Sidebar', 'blank_riders'),
              'id' => 'sidebar-1',
              'description' => esc_html__('Add widgets here.', 'blank_riders'),
              'before_widget' => '<section id="%1$s" class="widget %2$s">',
              'after_widget' => '</section>',
              'before_title' => '<h2 class="widget-title">',
              'after_title' => '</h2>',
        ));
  }

  add_action('widgets_init', 'blank_riders_widgets_init');

  /**
   * Enqueue scripts and styles.
   */
  function blank_riders_scripts() {
        wp_enqueue_style('blank_riders-style', get_stylesheet_uri());

        wp_enqueue_script('blank_riders-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

        wp_enqueue_script('blank_riders-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
              wp_enqueue_script('comment-reply');
        }
  }

  add_action('wp_enqueue_scripts', 'blank_riders_scripts');

  /**
   * Implement the Custom Header feature.
   */
  require get_template_directory() . '/inc/custom-header.php';

  /**
   * Custom template tags for this theme.
   */
  require get_template_directory() . '/inc/template-tags.php';

  /**
   * Functions which enhance the theme by hooking into WordPress.
   */
  require get_template_directory() . '/inc/template-functions.php';

  /**
   * Customizer additions.
   */
  require get_template_directory() . '/inc/customizer.php';

  /**
   * Load Jetpack compatibility file.
   */
  if (defined('JETPACK__VERSION')) {
        require get_template_directory() . '/inc/jetpack.php';
  }


  include get_template_directory() . '/custom_function.php';

  function fiu_upload_file() {
        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['basedir'];
        // print_r($_FILES); //this will print out the received name, temp name, type, size, etc.
        $target_file = $target_dir . '/recordings/' . basename($_FILES["audio_data"]["name"]) . ".wav";
        $input = $_FILES['audio_data']['tmp_name']; //get the temporary name that PHP gave to the uploaded file

        move_uploaded_file($input, $target_file);
        if (move_uploaded_file) {



              echo str_replace("/home/ridersway/public_html", home_url(), $target_file);
              echo " ";
              echo "File uploaded";
              die();
        }
  }

  add_action('wp_ajax_fiu_upload_file', 'fiu_upload_file');
  add_action('wp_ajax_nopriv_fiu_upload_file', 'fiu_upload_file');


