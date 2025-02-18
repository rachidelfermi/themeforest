<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_system_info' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_system_info extends ReduxFramework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }    

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true,
            );
            $this->field = wp_parse_args( $this->field, $defaults );  

            $default_val = array(
                'ids' => '',
                'team' => ''
            );

            $this->value = wp_parse_args( $this->value, $default_val);          
            
        }

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {
            global $redux;
            require_once THEME_INCLUDES . '/sys-info.php';

            $system_info = new Simple_System_Info();

            $output = '';
         
            $output .= '<div id="system_info_default_section_group' . '">';
            $output .= '<div id="redux-system-info">';
            $output .= $system_info->get( true );
            $output .= '</div>';
            $output .= '</div>';
            
            echo $output;
        }
    
        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        // public function enqueue() {

        //     $extension = ReduxFramework_extension_team_member::getInstance();
            
        //     wp_enqueue_script('jquery-ui-sortable');

        //     wp_enqueue_script(
        //         'redux-field-team-js', 
        //         $this->extension_url . 'field_team_member.js', 
        //         array( 'jquery' ),
        //         time(),
        //         true
        //     );

        //     $button_name = array(
        //         'btn_name' => __( 'Remove item', 'BERG' )
        //     );

        //     wp_localize_script('redux-field-team-js', 'php_data', $button_name );

        //     wp_enqueue_style(
        //         'redux-field-team-css', 
        //         $this->extension_url . 'field_team_member.css',
        //         time(),
        //         true
        //     );
        
        // }
        
        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */        
        public function output() {

            if ( $this->field['enqueue_frontend'] ) {

            }
            
        }        
        
    }
}
