<?php
$volunteer_bg      = t4sd_get_mod('t4sd_volunteer_bg', 'var(--sd-cta-grad)');
$volunteer_eyebrow = t4sd_get_mod('t4sd_volunteer_eyebrow','');
$volunteer_blurb   = t4sd_get_mod('t4sd_volunteer_blurb','Bring your time, laptop, or expertise—support events, trainings, or content creation.');
?>
<section class="sd-section band cta-band" style="background:<?php echo esc_attr($volunteer_bg ?: 'var(--sd-cta-grad)'); ?>">
  <div class="container volunteer-cta">
    <div class="sd-header">
      <?php if (!empty($volunteer_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($volunteer_eyebrow); ?></div><?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_volunteer_title','Ready to make a change?')); ?></h2>
      <div class="blurb"><?php echo esc_html($volunteer_blurb); ?></div>
    </div>
    <div class="cta-actions"><a class="btn" href="<?php echo esc_url(home_url('/volunteer')); ?>">Volunteer with Sunny Days</a></div>
  </div>
</section>
