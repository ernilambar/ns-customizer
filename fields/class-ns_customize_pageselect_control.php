<?php
/**
 * Customize for Page Select
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
  return NULL;

class NS_Customize_Pageselect_Control extends WP_Customize_Control {

  public $type = 'pageselect';

  public function render_content() {
    $pargs = array(
      'posts_per_page' => -1,
      'orderby'        => 'title',
      'order'          => 'asc',
      'post_type'      => 'page',
      );
    $all_posts = get_posts($pargs);

    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
       <?php if (!empty($all_posts)): ?>
         <select <?php echo $this->link(); ?>>
            <?php foreach ($all_posts as $key => $page): ?>
              <?php
                printf('<option value="%s" %s>%s</option>', $page->ID, selected($this->value(), $page->ID, false), $page->post_title);
               ?>
            <?php endforeach ?>
         </select>
       <?php endif ?>

    </label>
    <?php
  }

}
