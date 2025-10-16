<?php if (!defined('ABSPATH')) exit; get_header(); $pt = get_post_type(); ?>
<section class="sd-section" style="background:<?php echo esc_attr(get_theme_mod('t4sd_archives_'.$pt.'_bg','white')); ?>">
  <div class="container">
    <div class="sd-header">
      <h2><?php echo esc_html(get_theme_mod('t4sd_archives_'.$pt.'_title', post_type_archive_title('', false))); ?></h2>
      <div class="blurb"><?php echo esc_html(get_theme_mod('t4sd_archives_'.$pt.'_blurb','')); ?></div>
    </div>
    <div class="cards-grid">
      <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article class="card">
          <?php if (has_post_thumbnail()) the_post_thumbnail('t4sd-card'); ?>
          <div class="pad">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="meta"><?php echo esc_html(get_the_date()); ?></p>
            <p><?php the_excerpt(); ?></p>
          </div>
        </article>
      <?php endwhile; the_posts_pagination(); else: ?>
        <p>No entries yet.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php get_footer(); ?>
