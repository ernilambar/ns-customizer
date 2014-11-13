
<?php
require_once 'ns-customizer/init.php';
$my_settings = array(
  'sections' => array(

    array(
      'title'       => 'YAMYAM: Header',
      'description' => 'YamYam header',
      'slug'        => 'yamyam_header_option',
      'priority'    => 100,
      'fields'    => array(
        'sample_text' => array(
          'title'    => 'Sample Text',
          'id'       => 'sample_text',
          'type'     => 'text',
          'default'  => 'just demo',
          'priority' => 100,
          ),
        'sample_upload' => array(
          'title'    => 'Sample Upload',
          'id'       => 'sample_upload',
          'type'     => 'image',
          'priority' => 100,
          ),
        'sample_image' => array(
          'title'    => 'Sample Image',
          'id'       => 'sample_image',
          'type'     => 'image',
          'priority' => 100,
          ),
        'sample_color' => array(
          'title'    => 'Sample Color',
          'id'       => 'sample_color',
          'type'     => 'color',
          'default'     => '#ffff00',
          'priority' => 100,
          ),
        'sample_radio' => array(
          'title'   => 'Sample Radio',
          'id'      => 'sample_radio',
          'type'    => 'radio',
          'default' => 'male',
          'choices' => array(
            'male'   => __( 'Male' ),
            'female' => __( 'Female' ),
            ),
          ),
        'sample_select' => array(
          'title'   => 'Sure?',
          'id'      => 'sample_select',
          'type'    => 'select',
          'default' => 'yes',
          'choices' => array(
            'yes' => __( 'Yes' ),
            'no'  => __( 'No' ),
            ),
          ),
        'sample_checkbox' => array(
          'title' => 'Sample Checkbox',
          'id'    => 'sample_checkbox',
          'type'  => 'checkbox',
          ),
        ),
      ),

    array(
      'title'       => 'YAMYAM: Footer',
      'description' => 'YamYam footer',
      'slug'        => 'yamyam_footer_option',
      'priority'    => 150,
      'fields'    => array(
        'another_sample_text' => array(
          'title'   => 'Another Text',
          'id'      => 'another_sample_text',
          'type'    => 'text',
          'default' => 'just default',
          'priority' => 200,
          ),
        ),
      ),

    ),

  );

$yamyam_customizer = new NS_Customizer($my_settings);

?>
