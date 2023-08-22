<?php  
    get_header();
    PageBanner(array(
        'title' => 'All Professors',
        'subtitle' => 'Know more about our Professors'
    ));
?>
 
    <div class="container container--narrow page-section">
        <ul class= "link-list min-list">
        <?php 
            while(have_posts()){
                the_post();
        ?>
            <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
        <?php       
            }
            echo "<br>".paginate_links();
        ?>
        </ul>
    </div>

<?php get_footer();?>
