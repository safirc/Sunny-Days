<?php
$stats_eyebrow = t4sd_get_mod('t4sd_stats_eyebrow','');
$stats_title   = t4sd_get_mod('t4sd_stats_title','Stats');
$stats_blurb   = t4sd_get_mod('t4sd_stats_blurb','');
?>
<section class="sd-section soft" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_stats_bg','var(--sd-bg)')); ?>">
  <div class="container">
    <?php if (!empty($stats_eyebrow) || !empty($stats_title) || !empty($stats_blurb)): ?>
      <div class="sd-header">
        <?php if (!empty($stats_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($stats_eyebrow); ?></div><?php endif; ?>
        <?php if (!empty($stats_title)): ?><h2><?php echo esc_html($stats_title); ?></h2><?php endif; ?>
        <?php if (!empty($stats_blurb)): ?><div class="blurb"><?php echo esc_html($stats_blurb); ?></div><?php endif; ?>
      </div>
    <?php endif; ?>
    <div class="stat-cards">
      <div class="stat"><div class="num">300+</div><div>Learners supported</div></div>
      <div class="stat"><div class="num">40+</div><div>Community sessions</div></div>
      <div class="stat"><div class="num">10</div><div>Partner orgs</div></div>
      <div class="stat"><div class="num">3</div><div>EU collaborations</div></div>
    </div>
  </div>
</section>
