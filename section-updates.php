<?php $updates_eyebrow = t4sd_get_mod('t4sd_updates_eyebrow',''); ?>
<section class="sd-section soft sd-updates" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_updates_bg','#f5f9ff')); ?>">
  <div class="container">
    <div class="sd-header">
      <?php if (!empty($updates_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($updates_eyebrow); ?></div><?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_updates_title','News & Events')); ?></h2>
      <div class="actions"><a class="badge seeall" href="<?php echo esc_url(get_post_type_archive_link('update')); ?>"><?php esc_html_e('See all →','theme4sunnydays'); ?></a></div>
    </div>
    <ul class="news-list">
      <?php
        $q = new WP_Query(['post_type'=>'update','posts_per_page'=>5]);
        while ($q->have_posts()): $q->the_post();
      ?>
        <li class="news-item">
          <a class="inner" href="<?php the_permalink(); ?>">
            <div>
              <h3><?php the_title(); ?></h3>
              <p class="meta"><?php echo esc_html(get_the_date()); ?></p>
            </div>
            <span class="read"><?php esc_html_e('Read More →','theme4sunnydays'); ?></span>
          </a>
        </li>
      <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  </div>
</section>
