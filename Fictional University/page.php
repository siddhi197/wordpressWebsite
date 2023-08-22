<?php
  get_header();
  while(have_posts()) {
      the_post(); 
      PageBanner();
?>



  <div class="container container--narrow page-section">
    <?php 
    $theParent = wp_get_post_parent_id(get_the_ID());
    
    if($theParent){ ?>
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent);?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> 
         <span class="metabox__main"><?php echo the_title(); ?></span></p>
    </div>
    <?php } ?>


    <?php 
        $check_child_exist = get_children(get_the_ID());
         if($check_child_exist || $theParent) {
    ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent);?>"><?php echo get_the_title($theParent); ?></a></h2>
      <ul class="min-list">
        <?php 
            if($theParent){
                $findChildOf = $theParent;
            } else{
                $findChildOf = get_the_ID();
            }
            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildOf,
                'sort_column' => 'menu_order'
            )); ?>
      </ul>
    </div>
  <?php } ?>

    <div class="generic-content">
      <?php echo the_content();?>
    </div>

  </div>
   
   
<?php
}
get_footer();
?>   
