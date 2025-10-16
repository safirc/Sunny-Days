<?php
$social_show = get_theme_mod('t4sd_resources_social_show', true);
$social_embed = t4sd_get_mod('t4sd_social_embed', '');
$social_embed_output = $social_embed ? do_shortcode($social_embed) : '';
$resources_eyebrow = t4sd_get_mod('t4sd_resources_eyebrow','');
$resources_blurb   = t4sd_get_mod('t4sd_resources_blurb','Updated periodically');
?>
<section class="sd-section soft" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_resources_bg','#f5f9ff')); ?>">
  <div class="container split-2">
    <div>
      <div class="sd-header">
        <?php if (!empty($resources_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($resources_eyebrow); ?></div><?php endif; ?>
        <h2><?php echo esc_html(t4sd_get_mod('t4sd_resources_title','Resources')); ?></h2>
        <?php if (!empty($resources_blurb)): ?><div class="blurb"><?php echo esc_html($resources_blurb); ?></div><?php endif; ?>
      </div>
      <ul>
        <?php $q = new WP_Query(['post_type'=>'resource','posts_per_page'=>9]); while ($q->have_posts()): $q->the_post(); ?>
          <li style="margin:8px 0">• <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
    </div>
    <?php if ($social_show): ?>
      <div>
        <div class="sd-header"><h2><?php echo esc_html(t4sd_get_mod('t4sd_social_title','Social')); ?></h2>
          <?php if ($social_blurb = t4sd_get_mod('t4sd_social_blurb','')): ?>
            <div class="blurb"><?php echo esc_html($social_blurb); ?></div>
          <?php endif; ?>
        </div>
        <div class="feed" style="background:#eaf1fa;border:1px solid #d6e2f2;border-radius:18px;padding:28px;">
          <?php if ($social_embed_output): ?>
            <?php echo $social_embed_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          <?php else: ?>
            <p style="margin:0;color:#4a607c;text-align:center">Social feed embed</p>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
