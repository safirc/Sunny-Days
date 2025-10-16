<?php $partners_eyebrow = t4sd_get_mod('t4sd_partners_eyebrow',''); ?>
<section class="sd-section" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_partners_bg','white')); ?>">
  <div class="container">
    <div class="sd-header">
      <?php if (!empty($partners_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($partners_eyebrow); ?></div><?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_partners_title','Partners')); ?></h2>
    </div>
    <div class="partner-logos" role="list">
      <?php $q = new WP_Query(['post_type'=>'partner','posts_per_page'=>8]); while ($q->have_posts()): $q->the_post(); ?>
        <a class="partner-logo" role="listitem" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
          <?php if (has_post_thumbnail()): ?>
            <?php echo get_the_post_thumbnail(get_the_ID(), 'medium', ['class'=>'partner-logo__img']); ?>
          <?php else: ?>
            <span class="partner-logo__name"><?php echo esc_html(get_the_title()); ?></span>
          <?php endif; ?>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
