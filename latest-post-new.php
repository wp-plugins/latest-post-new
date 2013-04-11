<?php
/*
Plugin Name: latest-post-new 
Plugin URI: http://profiles.wordpress.org/all_is_well
Description: Select the post type from available post type and add the options, so this plugin will Displays the latest post from that post type. 
version:1.0
Author: All Is Well
Author URI: http://profiles.wordpress.org/all_is_well
*/


class fr_Excerpt_post extends WP_Widget {
        
        function fr_Excerpt_post() {
		     $this->fr_Excerpt_post_init();
            $widget_ops = array( 'description' => 'Recent Post Reloaded ' );
            parent::WP_Widget( false, 'Recent Post Reloaded ', $widget_ops );
        }
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
			$instance['post_type'] = strip_tags( $new_instance['post_type'] );
			$instance['post_numb'] = strip_tags( $new_instance['post_numb'] );
			$instance['limit_word'] = strip_tags( $new_instance['limit_word'] );
			$instance['post_thumbnail'] = strip_tags( $new_instance['post_thumbnail'] );
			
			$instance['class_for_all'] = strip_tags( $new_instance['class_for_all'] );
			
			$instance['width_thumb'] = strip_tags( $new_instance['width_thumb'] );
			$instance['height_thumb'] = strip_tags( $new_instance['height_thumb'] );
		
			$instance['comment_number'] = strip_tags( $new_instance['comment_number'] );
			$instance['date_post'] = strip_tags( $new_instance['date_post'] );
			
			$instance['read_more'] = strip_tags( $new_instance['read_more'] );
			$instance['read_more_text'] = strip_tags( $new_instance['read_more_text'] );
		
            return $instance;  
        }
        function widget($args, $instance) {
            extract( $args );
            
            $title = apply_filters('widget_title', $instance['title'] );
    		
			echo '<div class="fr_post_wrapper">
								<div class="'.$instance['class_for_all'].'">
									 '.$before_title.$title.$after_title; 
								      echo $before_widget;
								     ?>
								   
                                   <?php $post_type1=$instance['post_type'];    
								         $post_numb=$instance['post_numb'];
										 $post_limit=$instance['limit_word'];
										 if($post_type1){
                                         query_posts('showposts='.$post_numb.'&post_type='.$post_type1.'');						 
										 }
										 else{
										 query_posts('showposts='.$post_numb.'');
										 }
                     					 if (have_posts()) : 
                    				     while (have_posts()) : the_post(); ?>
                                         <h3>
										 <a href="<?php the_permalink() ?>"> <?php the_title(); ?></a>
                                         </h3>
                                         <div style="clear:both"></div>
                                                <?php if($instance['date_post']){ ?>
                                        			<div class="fr_date_of_the_post"><?php the_time('F jS, Y') ?></div>
                                                <?php } ?>
                                                
                                                <?php if($instance['comment_number']){ ?>
                                         			<div class="fr_comment_number">
											    	  <?php $a=get_comments_number();
                                            	 	  echo $a.' comments';  ?>
                                         		    </div>
                                                <?php } ?>  
                                                
                                         <div style="clear:both"></div>
                                         <?php if($instance['post_thumbnail']){ 
										           $postid = get_the_ID(); 
												   $thumb_url = wp_get_attachment_url(get_post_thumbnail_id($postid));
												  ?>
                                                  <?php if(has_post_thumbnail()){ ?>
                                                        <div class="fr_post_thumbanil">
                                        	 			<a href="<?php the_permalink() ?>">
                                         				   <img src="<?php echo $thumb_url; ?>" width="<?php echo $instance['width_thumb']; ?>" height="<?php echo $instance['height_thumb'];?>" alt="<?php echo $thumb_url; ?>" title="<?php the_title_attribute(); ?>" />
                                         				 </a>
                                                         </div>
                                                   <?php  } ?> 
                                         <?php } ?>
                                         <p>
                                         <?php
										 if($post_limit){
										 echo substr(get_the_content(),0,$post_limit);
										 }
										 else {
										   the_excerpt();
										 }
								   ?>
                                        </p> 
                                        <div style="clear:both;"></div>
                                        <?php if($instance['read_more']){ ?>
                                            <div class="fr_read_more">
                                            <a href="<?php the_permalink() ?>">
                                              <?php if($instance['read_more_text']){
											   echo $instance['read_more_text'];
											  } 
											  else {
											  echo 'Read more';
											  }
											  ?>
                                            </a>
                                            </div>
                                            
                                        <?php } ?>
                                                                 
                                <?php   endwhile;  wp_reset_query();  ?> 
           						<?php   else : ?>
           						<?php   endif; ?>  
									<div style="clear:both;"></div>
                                   <?php echo $after_widget; ?>
								</div>
							</div>
      <?php   }

		
		
        function form($instance) {
            
            $defaults = array( 'title' => 'Exerpt post widget', 'back_color' => '#ffffff', 'width' => ' ', 'widget_margin' => '20' );
            $instance = wp_parse_args( (array) $instance, $defaults ); ?>
    
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
                <input class="widefat fr_name" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </p>
    		    

             <p>
                <label for="<?php echo $this->get_field_id( 'class_for_all' ); ?>">Wrapper Class :</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'class_for_all' ); ?>" name="<?php echo $this->get_field_name( 'class_for_all' ); ?>" value="<?php echo $instance['class_for_all']; ?>" />
            </p>
             
             <p>
                <label for="<?php echo $this->get_field_id( 'post_type' ); ?>">Post ype :</label>
 				<?php 
				   $args=array(
					'public'   => true,
					'_builtin' => false
					); 
					$output = 'names'; // names or objects, note names is the default
					$operator = 'and'; // 'and' or 'or'
					$post_types=get_post_types($args,$output,$operator);  ?>
				  <select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" >
           <?php echo '<option value="post" '.($instance['post_type']=="post"? 'selected="selected"' : '').'>post</option>'; ?>
				 <?php	foreach ($post_types  as $post_type ) { 
                	echo '<option value="'.$post_type.'" '.($instance['post_type']==$post_type ? 'selected="selected"' : '').'>'.$post_type.'</option>';
				   }
				 ?>
                
                 </select>
                 </p>
           <!-- thumb nail here -->
           
            <p>
              <input  id="checklist123"  name="<?php echo $this->get_field_name( 'post_thumbnail' ); ?>" value="1"  type="checkbox"  <?php if( $instance['post_thumbnail']) echo 'checked="checked";' ?>  onclick="jQuery(this).parent().parent().find('#thumb_details').slideToggle();"/>
              <label for="<?php echo $this->get_field_id( 'post_thumbnail' ); ?>">Display Thumbnail
              </label>
            </p>  
            
            <p> 
            <?php if($instance['post_thumbnail']){ ?>
			 <div id="thumb_details" style="display:block;">
			<?php } 
			  else {
			?>
            <div id="thumb_details" style="display:none;">
            <?php } ?>
                   <label for="<?php echo $this->get_field_id( 'width_thumb' ); ?>">Thumbnail width :</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'width_thumb' ); ?>" name="<?php echo $this->get_field_name( 'width_thumb' ); ?>" value="<?php echo $instance['width_thumb']; ?>" />
                
                  <label for="<?php echo $this->get_field_id( 'height_thumb' ); ?>">Thumbnail Height :</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'height_thumb' ); ?>" name="<?php echo $this->get_field_name( 'height_thumb' ); ?>" value="<?php echo $instance['height_thumb']; ?>" />
            
            </div>
            
            </p>
             <!-- thumbnail ends here -->
             
             <!-- display the comment number   -->
             <p>
              <input  id="comment_number"  name="<?php echo $this->get_field_name('comment_number'); ?>" value="1"  type="checkbox"  <?php if( $instance['comment_number']) echo 'checked="checked";' ?> />
              <label for="<?php echo $this->get_field_id( 'comment_number' ); ?>">Display Comment Number
              </label>
            </p>  
            <!-- comment number ends here-->
                
           <!-- dispaly date   -->
             <p>
              <input  id="date_post"  name="<?php echo $this->get_field_name('date_post'); ?>" value="1"  type="checkbox"  <?php if( $instance['date_post']) echo 'checked="checked";' ?> />
              <label for="<?php echo $this->get_field_id( 'date_post' ); ?>">Display Date of the post
              </label>
            </p>  
           <!--  date ends here  -->
           
             <!-- dispaly Read more    -->
             <p>
              <input  id="read_more"  name="<?php echo $this->get_field_name('read_more'); ?>" value="1"  type="checkbox"  <?php if( $instance['read_more']) echo 'checked="checked";' ?>  onclick="jQuery(this).parent().parent().find('#Read_more_text').slideToggle();" />
              <label for="<?php echo $this->get_field_id( 'read_more' ); ?>">Display Read more
              </label>
            </p>  
            <p>
            <?php if($instance['read_more']){ ?>
			 <div id="Read_more_text" style="display:block;">
			<?php } 
			  else {
			?>
            <div id="Read_more_text" style="display:none;">
            <?php } ?>
              <label for="<?php echo $this->get_field_id( 'read_more_text' ); ?>">Read more Text:</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'read_more_text' ); ?>" name="<?php echo $this->get_field_name( 'read_more_text' ); ?>" value="<?php echo $instance['read_more_text']; ?>" />
            
            </div>
            
            

           <!--  Read more  ends here  -->
             <p>
                <label for="<?php echo $this->get_field_id( 'post_numb' ); ?>">Number of post (blank for all post):</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'post_numb' ); ?>" name="<?php echo $this->get_field_name( 'post_numb' ); ?>" value="<?php echo $instance['post_numb']; ?>" />
            </p>
             <p>
                <label for="<?php echo $this->get_field_id( 'limit_word' ); ?>">Charecter Limit ( Leave for default ):</label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'limit_word' ); ?>" name="<?php echo $this->get_field_name( 'limit_word' ); ?>" value="<?php echo $instance['limit_word']; ?>" />
            </p>

        <?php  }
		 private function fr_Excerpt_post_init() { 
   			 if(!defined('fr_Excerpt_post')) { 
      		define('fr_Excerpt_post', 'Recent Post Reloaded'); 
    		}
  		} 
		
		
    }
    add_action( 'widgets_init', 'fr_Excerpt_post_init1' );
    function fr_Excerpt_post_init1(){ 
        register_widget('fr_Excerpt_post');
    }
?>