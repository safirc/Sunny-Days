<?php $team_eyebrow = t4sd_get_mod('t4sd_team_eyebrow',''); ?>
<section class="sd-section" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_team_bg','white')); ?>">
  <div class="container">
    <div class="sd-header">
      <?php if (!empty($team_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($team_eyebrow); ?></div><?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_team_title','Our Team')); ?></h2>
    </div>
    <div class="team-grid">
      <?php $q = new WP_Query(['post_type'=>'team_member','posts_per_page'=>8]); while ($q->have_posts()): $q->the_post(); ?>
        <article class="member">
          <?php if (has_post_thumbnail()) the_post_thumbnail('medium'); ?>
          <div class="pad">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="pos"><?php echo esc_html(get_post_meta(get_the_ID(),'t4sd_position',true)); ?></div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <p style="margin-top:16px"><a class="badge" href="<?php echo esc_url(get_post_type_archive_link('team_member')); ?>">Meet everyone →</a></p>
  </div>
</section>
