<?php if (!defined('ABSPATH')) exit; get_header(); the_post(); $pos = get_post_meta(get_the_ID(),'t4sd_position',true); ?>
<section class="sd-section">
  <div class="container">
    <article class="single">
      <div class="team-member-layout">
        <div class="team-member-layout__media"><?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?></div>
        <div>
          <h1><?php the_title(); ?></h1>
          <?php if ($pos): ?><div class="meta"><?php echo esc_html($pos); ?></div><?php endif; ?>
          <div class="content"><?php the_content(); ?></div>
        </div>
      </div>
    </article>
  </div>
</section>
<?php get_footer(); ?>
