<?php if (!defined('OT_VERSION')) exit('No direct script access allowed');
/**
 * OptionTree Admin
 *
 * @package     WordPress
 * @subpackage  OptionTree
 * @since       1.0.0
 * @author      Derek Herman
 */
class OT_Admin
{
  private $table_name = NULL;
  private $version = NULL;
  private $option_array = array();

  function __construct() 
  {
    global $table_prefix;

    $this->table_name = $table_prefix . 'fuji_option_tree';
    $this->version = OT_VERSION;
    $this->option_array = $this->option_tree_data();
  }

  /**
   * Initiate Plugin & setup main options
   *
   * @uses get_option()
   * @uses add_option()
   * @uses option_tree_activate()
   * @uses wp_redirect()
   * @uses admin_url()
   *
   * @access public
   * @since 1.0.0
   *
   * @return bool
   */
  function option_tree_init() 
  {
    // check for activation
    $check = get_option( 'option_tree_activation' );

    // redirect on activation
    if ($check != "set" && $this->option_array[0]) 
    {
      // set blank option values
      foreach ( $this->option_array as $value ) 
      {
          $key = $value->item_id;
        $new_options[$key] = '';
      }

      // add theme options
      add_option( 'option_tree', $new_options );
      add_option( 'option_tree_activation', 'set');

      // load DB activation function if updating plugin
      $this->option_tree_activate();

      // Redirect
      wp_redirect( admin_url().'admin.php?page=option_tree&xml=true' );
    }
    return false;
  }

  /**
   * Plugin Table Structure
   *
   * @access public
   * @since 1.0.0
   *
   * @param string $type
   *
   * @return string
   */
  function option_tree_table( $type = '')
  {
    if ( $type == 'create' ) 
    {
      $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            item_id VARCHAR(50) NOT NULL,
            item_title VARCHAR(100) NOT NULL,
            item_desc LONGTEXT,
            item_type VARCHAR(30) NOT NULL,
            item_options VARCHAR(250) DEFAULT NULL,
            item_sort mediumint(9) DEFAULT '0' NOT NULL,
            UNIQUE KEY (item_id)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
    }
    return $sql;
  }

  /*
   * Plugin Activation
   *
   * @uses get_var()
   * @uses get_option()
   * @uses dbDelta()
   * @uses option_tree_table()
   * @uses option_tree_default_data()
   * @uses update_option()
   * @uses add_option()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_activate() 
  {
    global $wpdb;

    // check for table
    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

    // check for installed version
      $installed_ver = get_option( 'option_tree_version' );

    // add/update table
      if ( $installed_ver != $this->version ) 
      {
      // run query
          require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta( $this->option_tree_table( 'create' ) );
    }

    // new install default data
    if ( $new_installation ) 
    {
      $this->option_tree_default_data();
    }

    // New Version Update
    if ( $installed_ver != $this->version ) 
    {
      update_option( 'option_tree_version', $this->version );
    } 
    else if ( !$installed_ver ) 
    {
      add_option( 'option_tree_version', $this->version );
    }
  }

  /**
   * Plugin Deactivation delete options
   *
   * @uses delete_option()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_deactivate() 
  {
    // remove activation check & version
    delete_option( 'option_tree_activation' );
    delete_option( 'option_tree_version' );
  }

  /**
   * Plugin Activation Default Data
   *
   * @uses query()
   * @uses prepare()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_default_data() 
  {
      global $wpdb;

    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

    $ot_xml_file = OT_PLUGIN_DIR . "/theme-options.xml";           
    $rawdata = file_get_contents(  $ot_xml_file );
    $new_options = new SimpleXMLElement( $rawdata );

    // create table
    if ($new_installation) {

    $wpdb->query( "DROP TABLE $this->table_name" );    
    $wpdb->query( $this->option_tree_table( 'create' ) );

    }  

      // insert data
    foreach ( $new_options->row as $value ) 
    {
    $wpdb->insert( $this->table_name, 
      array( 
        'item_id' => $value->item_id,
        'item_title' => $value->item_title,
        'item_desc' => $value->item_desc,
        'item_type' => $value->item_type,
        'item_options' => $value->item_options
      )
    );

    }

    $string = "Theme Data Contents Here";

    // Unserialize The Array
    $new_options = unserialize( base64_decode( $string ) );

    // check if array()
    if ( is_array( $new_options ) ) 
    {
      // delete old options
      delete_option( 'option_tree' );

      // create new options
      add_option('option_tree', $new_options);

      // redirect
      //die();

      header("Location: admin.php?page=option_tree&xml=true");     

    }

  } 

  /*
   * Restore Table Data if empty
   *
   * @uses delete_option()
   * @uses option_tree_activate()
   * @uses wp_redirect()
   * @uses admin_url()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_restore_default_data() 
  {
    global $wpdb;

    // drop table
    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

    if (!$new_installation) $wpdb->query( "DROP TABLE $this->table_name" );

    // remove activation check
    delete_option( 'option_tree_version' );

    // load DB activation function
    $this->option_tree_activate();

    // Redirect
    wp_redirect( admin_url().'admin.php?page=option_tree' );
  }

  /**
   * Add Admin Menu Items & Test Actions
   *
   * @uses option_tree_export_xml()
   * @uses option_tree_data()
   * @uses get_results()
   * @uses option_tree_restore_default_data()
   * @uses option_tree_activate()
   * @uses get_option()
   * @uses option_tree_import_xml()
   * @uses get_user_option()
   * @uses add_object_page()
   * @uses add_submenu_page()
   * @uses add_action()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $param
   *
   * @return void
   */
  function option_tree_admin() 
  {
    global $wpdb;

      // export XML - run before anything else
      if ( isset($_GET['action']) && $_GET['action'] == 'ot-export-xml' )
      option_tree_export_xml( $this->option_tree_data(), $this->table_name );

    // grab saved table option
    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

    if (!$new_installation) $test_options = $wpdb->get_results( "SELECT * FROM {$this->table_name}" );

    // restore table if needed
      if ( empty( $test_options ) )
      $this->option_tree_restore_default_data();

    // upgrade DB automatically
    $this->option_tree_activate();

    // load options array
      $settings = get_option( 'option_tree' );

    // upload xml data
    $this->option_tree_import_xml();

    // set admin color
    $icon = ( get_user_option( 'admin_color' ) == 'classic' ) ? OT_PLUGIN_URL.'/assets/images/generic.png' : OT_PLUGIN_URL.'/assets/images/generic.png';

    // create menu items
    add_menu_page( 'Theme Options', 'Theme Options', 'add_users', 'option_tree', array( $this, 'option_tree_options_page' ), $icon, 58.6);
    $option_tree_options = add_submenu_page( 'option_tree', 'Theme Options', 'Theme Options', 'add_users', 'option_tree', array( $this, 'option_tree_options_page' ) );
   	// $option_tree_docs = add_submenu_page( 'option_tree', 'OptionTree', 'Documentation', 'level_7', 'option_tree_docs', array( $this, 'option_tree_docs_page' ) );
   	// $option_tree_settings = add_submenu_page( 'option_tree', 'OptionTree', 'Settings', 'level_10', 'option_tree_settings', array( $this, 'option_tree_settings_page' ) );

    // add menu items
    add_action( "admin_print_styles-$option_tree_options", array( $this, 'option_tree_load' ) );
    // add_action( "admin_print_styles-$option_tree_docs", array( $this, 'option_tree_load' ) );
    // add_action( "admin_print_styles-$option_tree_settings", array( $this, 'option_tree_load' ) );
  }

  /**
   * Load Scripts & Styles
   *
   * @uses wp_enqueue_style()
   * @uses get_user_option()
   * @uses add_thickbox()
   * @uses wp_enqueue_script()
   * @uses wp_deregister_style()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_load() 
  {
    // enqueue styles
    wp_enqueue_style( 'option-tree-style', OT_PLUGIN_URL.'/assets/css/style.css', false, $this->version, 'screen');

    // classic admin theme styles
    if ( get_user_option( 'admin_color') == 'classic' ) 
      wp_enqueue_style( 'option-tree-style-classic', OT_PLUGIN_URL.'/assets/css/style-classic.css', array( 'option-tree-style' ), $this->version, 'screen');

    // enqueue scripts
    add_thickbox();
    wp_enqueue_script( 'jquery-table-dnd', OT_PLUGIN_URL.'/assets/js/jquery.table.dnd.js', array('jquery'), $this->version );
    wp_enqueue_script( 'jquery-color-picker', OT_PLUGIN_URL.'/assets/js/jquery.color.picker.js', array('jquery'), $this->version );
    wp_enqueue_script( 'jquery-option-tree', OT_PLUGIN_URL.'/assets/js/jquery.option.tree.js', array('jquery','media-upload','thickbox','jquery-ui-core','jquery-ui-tabs','jquery-table-dnd','jquery-color-picker', 'jquery-ui-sortable'), $this->version );

    // remove GD star rating conflicts
    wp_deregister_style( 'gdsr-jquery-ui-core' );
    wp_deregister_style( 'gdsr-jquery-ui-theme' );
  }

  /**
   * Grab the wp_option_tree table options array
   *
   * @uses get_results()
   *
   * @access public
   * @since 1.0.0
   *
   * @return array
   */
  function option_tree_data() 
  {
    global $wpdb;

    // create an array of options

    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;    
    if (!$new_installation)
    $db_options = $wpdb->get_results( "SELECT * FROM {$this->table_name} ORDER BY item_sort ASC" );
    return $db_options;
  }

  /**
   * Theme Options Page
   *
   * @uses get_option()
   * @uses get_option_page_ID()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_notice_post_locked()
   *
   * @access public
   * @since 1.0.0
   *
   * @return string
   */
  function option_tree_options_page() 
  {
    // set 
    $ot_array = $this->option_array;

    // load saved option_tree
    $settings = get_option( 'option_tree' );

    // private page ID
    $post_id = $this->get_option_page_ID( 'media' );

    // set post lock
    if ( $last = $this->option_tree_check_post_lock( $post_id ) ) 
    {
      $message = $this->option_tree_notice_post_locked( $post_id );
      } 
      else 
      {
          $this->option_tree_set_post_lock( $post_id );
      }

    // Grab Options Page
    include( OT_PLUGIN_DIR.'/front-end/options.php' );
  }

  /**
   * Settings Page
   *
   * @uses get_option()
   * @uses get_option_page_ID()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_notice_post_locked()
   *
   * @access public
   * @since 1.0.0
   *
   * @return string
   */
  function option_tree_settings_page() 
  {
    $ot_array = $this->option_array;

    // Load Saved Options
      $settings = get_option('option_tree');

      // private page ID
    $post_id = $this->get_option_page_ID( 'options' );

    // set post lock
    if ( $last = $this->option_tree_check_post_lock( $post_id ) ) 
    {
      $message = $this->option_tree_notice_post_locked( $post_id );
      } 
      else 
      {
          $this->option_tree_set_post_lock( $post_id );
      }

    // Get Settings Page
    include( OT_PLUGIN_DIR.'/front-end/settings.php');
  }

  /**
   * Documentation Page
   *
   * @access public
   * @since 1.0.0
   *
   * @return string
   */
  function option_tree_docs_page() 
  {
    // Get Settings Page
    include( OT_PLUGIN_DIR.'/front-end/docs.php');
  }

  /**
   * Save Theme Option via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update_option()
   * @uses option_tree_set_post_lock()
   * @uses get_option_page_ID()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_array_save() 
  {
    // Check AJAX Referer
    check_ajax_referer( '_theme_options', '_ajax_nonce' );

    // set option values
    foreach ( $this->option_array as $value ) 
    {
      $key = trim( $value->item_id );
      if ( isset( $_REQUEST[$key] ) )
      { 
        $val = $_REQUEST[$key];
        $new_settings[$key] = $val;
      }
      }

      // Update Theme Options
    update_option( 'option_tree', $new_settings );
    $this->option_tree_set_post_lock( $this->get_option_page_ID( 'media' ) );

      die();

  }

  /**
   * Reset Theme Option via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update_option()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_array_reset() 
  {
    // Check AJAX Referer
    check_ajax_referer( '_theme_options', '_ajax_nonce' );

    // clear option values
    foreach ( $this->option_array as $value ) 
    {
      $key = $value->item_id;
      $new_options[$key] = '';
    }

    // update theme Options
    update_option( 'option_tree', $new_options );

      die();
  }

  /**
   * Insert Row into Option Setting Table via AJAX
   *
   * @uses check_ajax_referer()
   * @uses get_results()
   * @uses insert()
   * @uses get_var()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_add() {
      global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // grab fresh options array
    $ot_array = $wpdb->get_results( "SELECT * FROM {$this->table_name}" );

    // get form data
    $id = $_POST['id'];
      $item_id       = htmlspecialchars(stripslashes(trim($_POST['item_id'])), ENT_QUOTES,'UTF-8',true);
      $item_title    = htmlspecialchars(stripslashes(trim($_POST['item_title'])), ENT_QUOTES,'UTF-8',true);
      $item_desc     = htmlspecialchars(stripslashes(trim($_POST['item_desc'])), ENT_QUOTES,'UTF-8',true);
      $item_type     = htmlspecialchars(stripslashes(trim($_POST['item_type'])), ENT_QUOTES,'UTF-8',true);
      $item_options  = htmlspecialchars(stripslashes(trim($_POST['item_options'])), ENT_QUOTES,'UTF-8',true);

      // validate item key
      foreach( $ot_array as $value ) 
      {
      if ( $item_id == $value->item_id ) 
      {
        die( "That option key is already in use." );
      }
      }

      // verify key is alphanumeric
    if ( eregi( '[^a-z0-9_]', $item_id ) ) 
      die("You must enter a valid option key.");

      // verify title
    if (strlen($item_title) < 1 ) 
      die("You must give your option a title.");

    if ( $item_type == 'textarea' && !is_numeric( $item_options ) )
      die("The row value must be numeric.");

    // update row
    $wpdb->insert( $this->table_name, 
      array( 
        'item_id' => $item_id,
        'item_title' => $item_title,
        'item_desc' => $item_desc,
        'item_type' => $item_type,
        'item_options' => $item_options,
        'item_sort' => $id
      )
    );

    // verify values in the DB are updated
    $updated = $wpdb->get_var(" 
      SELECT id 
      FROM {$this->table_name}
      WHERE item_id = '$item_id'
      AND item_title = '$item_title'
      AND item_type = '$item_type'
      AND item_options = '$item_options'
      ");

    // if updated
    if ( $updated )
    {
      die('updated');
    } 
    else
    {
      die("There was an error, please try again.");
    }
  }

  /**
   * Update Option Setting Table via AJAX
   *
   * @uses check_ajax_referer()
   * @uses get_results()
   * @uses update()
   * @uses get_var()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_edit() {
      global $wpdb;

    // Check AJAX Referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // grab fresh options array
    $ot_array = $wpdb->get_results( "SELECT * FROM {$this->table_name}" );

    // get form data
      $id = $_POST['id'];
      $item_id       = htmlspecialchars(stripslashes(trim($_POST['item_id'])), ENT_QUOTES,'UTF-8',true);
      $item_title    = htmlspecialchars(stripslashes(trim($_POST['item_title'])), ENT_QUOTES,'UTF-8',true);
      $item_desc     = htmlspecialchars(stripslashes(trim($_POST['item_desc'])), ENT_QUOTES,'UTF-8',true);
      $item_type     = htmlspecialchars(stripslashes(trim($_POST['item_type'])), ENT_QUOTES,'UTF-8',true);
      $item_options  = htmlspecialchars(stripslashes(trim($_POST['item_options'])), ENT_QUOTES,'UTF-8',true);

      // validate item key
      foreach($ot_array as $value) 
      {
      if ( $value->item_sort == $id ) 
      {
        if ($item_id == $value->item_id && $value->item_sort != $id) 
        {
          die("That option key is already in use.");
        }
      } 
      else if ($item_id == $value->item_id && $value->id != $id) 
      {
        die("That option key is already in use.");
      }
      }

      // verify key is alphanumeric
    if ( eregi( '[^a-z0-9_]', $item_id ) ) 
      die("You must enter a valid option key.");

      // verify title
      if ( strlen( $item_title ) < 1 ) 
      die("You must give your option a title.");

    if ( $item_type == 'textarea' && !is_numeric( $item_options ) )
      die("The row value must be numeric.");

    // update row
    $wpdb->update( $this->table_name, 
      array( 
        'item_id' => $item_id, 
        'item_title' => $item_title, 
        'item_desc' => $item_desc, 
        'item_type' => $item_type, 
        'item_options' => $item_options 
      ), 
      array( 
        'id' => $id 
      )
    );

    // verify values in the DB are updated
    $updated = $wpdb->get_var(" 
      SELECT id 
      FROM {$this->table_name}
      WHERE item_id = '$item_id'
      AND item_title = '$item_title'
      AND item_type = '$item_type'
      AND item_options = '$item_options'
      ");

    // if updated
    if ( $updated ) 
    {
      die('updated');
    } 
    else 
    {
      die("There was an error, please try again.");
    }
  }

  /**
   * Remove Option via AJAX
   *
   * @uses check_ajax_referer()
   * @uses query()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_delete() 
  {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // grab ID
      $id = $_REQUEST['id'];

    // delete item
      $wpdb->query(" 
      DELETE FROM $this->table_name 
      WHERE id = '$id'
    ");

      die('removed');
  }

  /**
   * Get Option ID via AJAX
   *
   * @uses check_ajax_referer()
   * @uses delete_post_meta()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_next_id() 
  {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // get ID
    $id = $wpdb->get_var( "SELECT id FROM {$this->table_name} ORDER BY id DESC LIMIT 1" );

    // return ID
      die($id);
  }

  /**
   * Update Sort Order via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_sort() {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // create an array of IDs
      $fields = explode('&', $_REQUEST['id']);

      // set order
      $order = 0;

    // update the sort order
      foreach( $fields as $field ) {
          $order++;
          $key = explode('=', $field);
          $id = urldecode($key[1]);
          $wpdb->update( $this->table_name, 
        array(
          'item_sort' => $order 
        ), 
        array( 
          'id' => $id 
        )
      );
      }
      die();
  }

  /**
   * Upload XML Option Data
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_import_xml() 
  {
    global $wpdb;

    // action == upload
    if ( isset($_GET['action']) && $_GET['action'] == 'upload' ) 
    {
      // fail no file
      if ( $_FILES["import"]['name'] == null )
      {
        header("Location: admin.php?page=option_tree_settings&nofile=true#import_options");
        die();
      }
      // fail errors
      else if ( $_FILES["import"]["error"] > 0 )
      {
        header("Location: admin.php?page=option_tree_settings&error=true#import_options");
        die();
      } 
      else 
      {
        // success - it's XML
        if ( preg_match( "/(.xml)$/i", $_FILES["import"]['name'] ) ) 
        {
          $rawdata = file_get_contents( $_FILES["import"]["tmp_name"] );
          $new_options = new SimpleXMLElement( $rawdata );

          // drop table
          $wpdb->query( "DROP TABLE $this->table_name" );

          // create table
            $wpdb->query( $this->option_tree_table( 'create' ) );

            // insert data
          foreach ( $new_options->row as $value ) 
          {
            $wpdb->insert( $this->table_name, 
              array( 
                'item_id' => $value->item_id,
                'item_title' => $value->item_title,
                'item_desc' => $value->item_desc,
                'item_type' => $value->item_type,
                'item_options' => $value->item_options
              )
            );
          }
          // success redirect
          header("Location: admin.php?page=option_tree_settings&xml=true#import_options");
          die();
        }
        // fail
        else
        {
          // redirect
          header("Location: admin.php?page=option_tree_settings&error=true#import_options");
          die();
        }
      }
    }
  }

  /**
   * Import Option Data via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_import_data() 
  {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( '_import_data', '_ajax_nonce' );

    // Get Data
    $string = $_REQUEST['import_options'];

    // Unserialize The Array
    $new_options = unserialize( base64_decode( $string ) );

    // check if array()
    if ( is_array( $new_options ) ) 
    {
      // delete old options
      delete_option( 'option_tree' );

      // create new options
      add_option('option_tree', $new_options);

      // redirect
      die();
    }
    // failed
    die(-1);
  }

  function option_tree_add_slider() 
  {
    $count = $_GET['count'] + 1;
    $id = $_GET['slide_id'];
    $image = array(
      'order'       => $count,
      'title'       => '',
      'image'       => '',
      'link'        => '',
      'description' => ''
    );
    option_tree_slider_view( $id, $image, $this->get_option_page_ID('media'), $count );
    die();
  }

  /**
   * Returns the ID of a cutom post tpye
   *
   * @uses get_results()
   *
   * @access public
   * @since 1.0.0
   *
   * @param string $page_title
   *
   * @return int
   */
  function get_option_page_ID( $page_title = '' ) 
  {
    global $wpdb;

    return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '{$page_title}' AND post_type = 'option-tree' AND post_status != 'trash'");
  }

  /**
   * Register custom post type & create two posts
   *
   * @uses get_results()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function create_option_post() 
  {
    register_post_type( 'option-tree', array(
        'labels' => array(
            'name' => __( 'Options' ),
        ),
        'public' => true,
        'show_ui' => false,
        'capability_type' => 'post',
        'exclude_from_search' => true,
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array( 'title', 'editor' ),
        'can_export' => true,
        'show_in_nav_menus' => false,
    ) );

    // create a private page to attach media to
    if ( isset($_GET['page']) && $_GET['page'] == 'option_tree' ) 
    {  
      // look for custom page
      $page_id = $this->get_option_page_ID( 'media' );

      // no page create it
      if ( ! $page_id ) 
      {
        // create post object
        $_p = array();
        $_p['post_title'] = 'Media';
        $_p['post_status'] = 'private';
        $_p['post_type'] = 'option-tree';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';

        // insert the post into the database
        $page_id = wp_insert_post( $_p );
      }
    }

    // create a private page for settings page
    if ( isset($_GET['page']) && $_GET['page'] == 'option_tree_settings' ) 
    {  
      // look for custom page
      $page_id = $this->get_option_page_ID( 'options' );

      // no page create it
      if ( ! $page_id ) 
      {
        // create post object
        $_p = array();
        $_p['post_title'] = 'Options';
        $_p['post_status'] = 'private';
        $_p['post_type'] = 'option-tree';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';

        // insert the post into the database
        $page_id = wp_insert_post( $_p );
      }
    }
  }

  /**
   * Outputs the notice message to say that someone else is editing this post at the moment.
   *
   * @uses get_userdata()
   * @uses get_post_meta()
   * @uses esc_html()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return string
   */
  function option_tree_notice_post_locked( $post_id ) 
  {
    if ( !$post_id )
          return false;

      $last_user = get_userdata( get_post_meta( $post_id, '_edit_last', true ) );
    $last_user_name = $last_user ? $last_user->display_name : __('Somebody');
    $the_page = ( $_GET['page'] == 'option_tree' ) ? __('Theme Options') : __('Settings');

    $message = sprintf( __( 'Warning: %s is currently editing the %s.' ), esc_html( $last_user_name ), $the_page );
    return '<div class="message warning"><span>&nbsp;</span>'.$message.'</div>';
  }

  /**
   * Check to see if the post is currently being edited by another user.
   *
   * @uses get_post_meta()
   * @uses apply_filters()
   * @uses get_current_user_id()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return bool
   */
  function option_tree_check_post_lock( $post_id ) 
  { 
      if ( !$post_id )
          return false;

      $lock = get_post_meta( $post_id, '_edit_lock', true );
      $last = get_post_meta( $post_id, '_edit_last', true );

      $time_window = apply_filters( 'wp_check_post_lock_window', 30 );

      if ( $lock && $lock > time() - $time_window && $last != get_current_user_id() )
          return $last;

      return false;
  }

  /**
   * Mark the post as currently being edited by the current user
   *
   * @uses update_post_meta()
   * @uses get_current_user_id()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return bool
   */
  function option_tree_set_post_lock( $post_id ) 
  {
      if ( !$post_id )
          return false;

      if ( 0 == get_current_user_id() )
          return false;

      $now = time();

      update_post_meta( $post_id, '_edit_lock', $now );
      update_post_meta( $post_id, '_edit_last', get_current_user_id() );
  }

  /**
   * Remove the post lock
   *
   * @uses delete_post_meta()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return bool
   */
  function option_tree_remove_post_lock( $post_id ) 
  {
      if ( !$post_id )
          return false;

      delete_post_meta( $post_id, '_edit_lock' );
      delete_post_meta( $post_id, '_edit_last' );
  }

}

