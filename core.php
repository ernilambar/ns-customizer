<?php
if ( ! class_exists('NS_Customizer')):

  class NS_Customizer
  {

    var $base_args;
    var $options;
    var $theme_slug;
    var $theme_option_slug;


    function __construct($args)
    {
      $this->base_args = $args;

      if ( isset( $args['theme_slug'] ) && !empty( $args['theme_slug'] ) ) {
        $this->theme_slug = $args['theme_slug'];
      }
      else{
        $this->theme_slug = get_stylesheet();
      }
      $this->theme_option_slug = $this->theme_slug . '_theme_options';

      add_action( 'customize_register', array($this,'register_customizer') );

      $this->options = $this->get_options();

    }

    public function get_option( $key, $default = '' ){

      $value = $default;
      if ( isset( $this->options[$key] ) ) {
        $value = $this->options[$key];
      }
      return $value;

    }

    private function get_options(){

      $output = array();
      $option_key = 'theme_mods_'.$this->theme_slug;
      $mod_options = get_option( $option_key );
      if ( empty( $mod_options ) ) {
        return $output;
      }
      foreach ($this->base_args['sections'] as $section_key => $section) {

        foreach ( $section['fields'] as $field_key => $field ) {

          $output[$field['id']] = $mod_options[$section_key][$field['id']];

        }

      }

      return $output;

    }

    function register_customizer( $wp_customize ){

      $built_in_controls = array(
        'text',
        'checkbox',
        'select',
        'radio',
        );


      foreach ($this->base_args['sections'] as $section_key => $section) {

        // Add Section
        $section_args = array(
              'title'       => $section['title'],
              'priority'    => 100,
              'capability'  => 'edit_theme_options',
              'description' => '',
           );
        if (isset($section['description'])) {
          $section_args['description'] = $section['description'];
        }
        if (isset($section['priority'])) {
          $section_args['priority'] = $section['priority'];
        }

        $wp_customize->add_section( $section['slug'], $section_args );
        if (!empty($section['fields'])) {

          foreach ($section['fields'] as $field_key => $field) {

            // Add Setting
            $setting_args = array(
                  'type'       => 'theme_mod',
                  'capability' => 'edit_theme_options',
                  'transport'  => 'refresh',
               );
            if (isset($field['default'])) {
              $setting_args['default'] = $field['default'];
            }
            $wp_customize->add_setting( $section['slug'].'['.$field['id'].']', $setting_args );

            // Add Control
            // For Builtin Controls
            if (in_array($field['type'], $built_in_controls)) {
              $control_args = array(
                    'label'    => $field['title'],
                    'section'  => $section['slug'],
                    'type'     => $field['type'],
                    'priority' => 100,
              );
              if (isset($field['priority'])) {
                $control_args['priority'] = $field['priority'];
              }
              if (isset($field['choices'])) {
                $control_args['choices'] = $field['choices'];
              }
              $wp_customize->add_control($section['slug'].'['.$field['id'].']', $control_args );
            }// end if builtin
            else{

              $class_name = 'WP_Customize_'.ucfirst($field['type']).'_Control';
              $class_exists = false;
              if (class_exists($class_name)) {
                $class_exists = true;
              }
              if ( ! $class_exists) {
                $class_name = 'NS_Customize_'.ucfirst($field['type']).'_Control';
                if (class_exists($class_name)) {
                  $class_exists = true;
                }
              }


              if (class_exists($class_name)) {
                $control_args = array(
                      'label'    => $field['title'],
                      'section'  => $section['slug'],
                      'priority' => 100,
                );
                if (isset($field['priority'])) {
                  $control_args['priority'] = $field['priority'];
                }

                $obj = new $class_name(
                  $wp_customize,
                  $section['slug'].'['.$field['id'].']',
                  $control_args
                );
                $wp_customize->add_control($obj);

              }
              else{
                echo $class_name . ' does not exists.';
              }

            }

          }

        }

      } //end foreach section loop


    }


  }

endif;
