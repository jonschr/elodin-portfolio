<?php
/**
 * Feautured Linked Content Widget
 */
class widget_portfolio_entries_grid extends WP_Widget {

   //* Constructor
   function widget_portfolio_entries_grid() {
      parent::WP_Widget( false, $name = 'Portfolio Entries' );	
   }

   /** @see WP_Widget::widget -- do not rename this */
   function widget( $args, $instance ) {	
     
      extract( $args );
      
      $title = apply_filters('widget_title', $instance['title']);
      $link = $instance['link'];
      $textarea = wpautop($instance['textarea']);

      $count = 0;

      echo $before_widget;

      if ( $title ) {
         
         echo '<header>';
            echo '<h4 class="widget-title widgettitle portfolio-widget-title">';
               echo $title;
            echo '</h4>';
         echo '</header>';
      }

      if ( $textarea ) {
         echo '<div class="entry-widget_content entry-content portfolio-widget-content">';
            echo $textarea;
         echo '</div>';
      }

      if ( have_posts() ) {

         echo '<div class="full-width-content post-type-archive-portfolio">';

         add_thickbox();

         $args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => '4',
         );

         $portfolio_query = new WP_Query( $args );
         
         while ( $portfolio_query->have_posts() ) {
            
            $portfolio_query->the_post();
            $add_class = array( 'one-fourth' );

            if ( $count == 0 || $count == 4 ) {
               $add_class[] = 'first';
               echo '<div class="clear"></div>';
            }

            ?>
            <article <?php post_class( $add_class ); ?>>

               <?php 
               rb_portfolio_add_image();
               // the_date( 'F Y', '<span class="portfolio-date">', '</span>' );
               genesis_do_post_title();
               // rb_portfolio_add_authors();
               rb_portfolio_display_thickbox_content();
               ?>

            </article>

            <?php
            $count++;

            }
         }

         wp_reset_query();

         echo '<div class="clear"></div>';

         echo '</div>'; // .full-width-content.post-type-archive-portfolio

         echo $after_widget;
      }
 
   /** @see WP_Widget::update -- do not rename this */
   function update( $new_instance, $old_instance ) {		
      $instance = $old_instance;
      $instance[ 'title' ] = strip_tags( $new_instance[ 'title'] );
      $instance[ 'link' ] = strip_tags( $new_instance[ 'link'] );

      if ( current_user_can( 'unfiltered_html' ) ){
         $instance[ 'textarea' ] = $new_instance[ 'textarea' ];
      }
      else {
         strip_tags( $new_instance[ 'textarea' ] );
      }
      
      return $instance;
   }
 
   /** @see WP_Widget::form -- do not rename this */
   function form( $instance ) {	
     
     $title = esc_attr($instance['title']);
     $link = esc_attr($instance['link']);
     $textarea = $instance['textarea'];
     
     ?>
      <p>
       <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
       <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
     </p>
     <p>
       <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Text (if any) for above the portfolio entries:'); ?></label> 
       <textarea class="widefat" rows="8" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
     </p>
     <?php 
   }
 
 
} // end class widget_portfolio_entries_grid

add_action('widgets_init', create_function( '', 'return register_widget( "widget_portfolio_entries_grid" ); ') );