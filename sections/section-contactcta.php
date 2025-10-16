<?php $contact_eyebrow = t4sd_get_mod('t4sd_contactcta_eyebrow',''); ?>
<section class="sd-section donate-cta" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_contactcta_bg','#0b1521')); ?>">
  <div class="container">
    <div class="sd-header">
      <?php if (!empty($contact_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($contact_eyebrow); ?></div><?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_contactcta_title','Ready to power inclusive learning?')); ?></h2>
      <p class="blurb"><?php echo esc_html(t4sd_get_mod('t4sd_contactcta_blurb','Each contribution helps bridge the digital gap.')); ?></p>
    </div>
    <div class="cta-actions"><a class="btn primary" href="<?php echo esc_url(home_url('/donate')); ?>"><?php esc_html_e('Donate now','theme4sunnydays'); ?></a></div>
  </div>
</section>
