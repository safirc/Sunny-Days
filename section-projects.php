<?php
$projects_eyebrow = t4sd_get_mod('t4sd_projects_eyebrow','');
$projects_blurb   = t4sd_get_mod('t4sd_projects_blurb','Co-created trainings with partners.');
?>
<section class="sd-section section-projects" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_projects_bg','white')); ?>">
  <div class="container">
    <div class="sd-header">
      <div class="titlewrap">
        <?php if (!empty($projects_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($projects_eyebrow); ?></div><?php endif; ?>
        <h2><?php echo esc_html(t4sd_get_mod('t4sd_projects_title','Projects')); ?></h2>
        <?php if (!empty($projects_blurb)): ?><div class="blurb"><?php echo esc_html($projects_blurb); ?></div><?php endif; ?>
      </div>
      <div class="actions"><a class="badge seeall" href="<?php echo esc_url(get_post_type_archive_link('project')); ?>"><?php esc_html_e('See all →','theme4sunnydays'); ?></a></div>
    </div>
    <div class="cards-grid">
      <?php $q = new WP_Query(['post_type'=>'project','posts_per_page'=>3]); while ($q->have_posts()): $q->the_post(); ?>
        <article class="card">
          <?php if (has_post_thumbnail()) the_post_thumbnail('t4sd-card'); ?>
          <div class="pad">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="meta"><?php the_excerpt(); ?></p>
            <p><a class="btn secondary" href="<?php the_permalink(); ?>">Learn more →</a></p>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
