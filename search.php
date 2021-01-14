<?php get_header(); ?>
<div class="content thin">
  <?php if (have_posts()) : ?>
    <div class="page-title">
      <h4>
        <?php __('Results for', 'kurtcms'); echo " '" . get_search_query() . "'"; ?>
      </h4>
    </div>
    <!-- /page-title -->
    <div class="posts" id="posts">
      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', get_post_format()); ?>
      <?php endwhile; ?>
    </div>
    <!-- /posts -->
    <?php if ($wp_query->max_num_pages > 1) : ?>
      <div class="archive-nav">
        <?php echo get_next_posts_link('&laquo; ' . __('Previous', 'kurtcms')); ?>
        <?php echo get_previous_posts_link(__('Next', 'kurtcms') . ' &raquo;'); ?>
        <div class="clear"></div>
      </div>
      <!-- /post-nav archive-nav -->
    <?php endif; ?>
  <?php else : ?>
    <div class="post single">
      <div class="post-body">
        <div class="post-content">
          <p>
            <?php __('No result for', 'kurtcms'); echo " '" . get_search_query() . "'. "; __('Try something else?', 'kurtcms'); ?>
          </p>
          <?php get_search_form(); ?>
        </div>
        <!-- /post-content -->
      </div>
      <!-- /post-inner -->
      <div class="clear"></div>
    </div>
    <!-- /post -->
  <?php endif; ?>
</div>
<!-- /content -->
<?php get_footer(); ?>
