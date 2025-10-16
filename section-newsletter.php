<?php if (!defined('ABSPATH')) exit; ?>
<?php $newsletter_eyebrow = t4sd_get_mod('t4sd_newsletter_eyebrow',''); ?>
<section class="sd-section band newsletter cta-band" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_newsletter_bg','var(--sd-cta-grad)')); ?>">
  <div class="container">
    <div class="sd-header">
      <?php if (!empty($newsletter_eyebrow)): ?>
        <div class="sd-eyebrow"><?php echo esc_html($newsletter_eyebrow); ?></div>
      <?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_newsletter_title','Get monthly updates in your inbox')); ?></h2>
    </div>

    <form class="newsletter-signup" method="post" action="#">
      <label class="screen-reader-text" for="newsletter-email">
        <?php esc_html_e('Email address','theme4sunnydays'); ?>
      </label>
      <input id="newsletter-email" class="input" name="newsletter-email" type="email" placeholder="you@example.org" required>
      <button class="btn secondary" type="submit"><?php esc_html_e('Subscribe','theme4sunnydays'); ?></button>
    </form>

    <p class="blurb">
      <?php echo esc_html(t4sd_get_mod('t4sd_newsletter_blurb','No spam. Unsubscribe anytime.')); ?>
    </p>
  </div>
</section>
