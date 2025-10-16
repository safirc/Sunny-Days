<?php $webinars_eyebrow = t4sd_get_mod('t4sd_webinars_eyebrow',''); ?>
<section class="sd-section" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_webinars_bg','white')); ?>">
  <div class="container">
    <div class="sd-header">
      <?php if (!empty($webinars_eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($webinars_eyebrow); ?></div><?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_webinars_title','Webinars')); ?></h2>
      <div class="actions"><a class="badge seeall" href="<?php echo esc_url(get_post_type_archive_link('webinar')); ?>"><?php esc_html_e('See all →','theme4sunnydays'); ?></a></div>
    </div>
    <div class="split-2">
      <div class="card"><div class="pad">
        <div class="badge">UPCOMING</div>
        <h3><?php echo esc_html(get_theme_mod('t4sd_upcoming_title','Smartphone Safety 101 (60+)')); ?></h3>
        <p class="meta"><?php echo esc_html(get_theme_mod('t4sd_upcoming_meta','Thu, Oct 9 · 18:00–19:00 (Europe/Istanbul) · Free · Zoom')); ?></p>
        <ul>
          <li>Recognize common scams and phishing</li>
          <li>Privacy settings basics</li>
          <li>Safer messaging habits</li>
        </ul>
        <?php if ($short = t4sd_get_mod('t4sd_webinars_shortcode','')): ?>
          <?php echo do_shortcode($short); ?>
        <?php else: ?>
          <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display:flex;gap:12px;align-items:center">
            <input type="hidden" name="action" value="t4sd_register">
            <?php wp_nonce_field('t4sd_reg','t4sd_reg_nonce'); ?>
            <input type="hidden" name="t4sd_title" value="<?php echo esc_attr(get_theme_mod('t4sd_upcoming_title','Webinar')); ?>">
            <input type="email" name="t4sd_email" placeholder="Email address" required style="flex:1;padding:14px 18px;border:1px solid #cfd9ea;border-radius:999px">
            <button class="btn" type="submit">Register</button>
          </form>
          <?php if (isset($_GET['registered'])) echo '<p class="meta">Thank you! You will receive the Zoom link by email.</p>'; ?>
        <?php endif; ?>
      </div></div>
      <div class="card"><div class="pad">
        <div class="badge">MOST RECENT</div>
        <h3><?php echo esc_html(get_theme_mod('t4sd_recent_title','Co-Mentoring Across Generations — Highlights')); ?></h3>
        <?php
          $recent_url = t4sd_get_mod('t4sd_webinars_recent_url', '');
          $recent_embed = '';
          if ($recent_url) {
            $recent_embed = wp_oembed_get($recent_url, ['width' => 640]);
            if (!$recent_embed) {
              $recent_embed = '<p style="margin:0"><a href="'.esc_url($recent_url).'" target="_blank" rel="noopener">'.esc_html__('Watch the recent webinar','theme4sunnydays').'</a></p>';
            }
          }
        ?>
        <div style="background:#eaf1fa;border:1px solid #d6e2f2;border-radius:14px;padding:16px;min-height:260px;margin-top:8px;display:flex;align-items:center;justify-content:center">
          <?php if ($recent_embed): ?>
            <?php echo $recent_embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          <?php else: ?>
            <p style="margin:0;color:#4a607c;text-align:center">YouTube embed</p>
          <?php endif; ?>
        </div>
        <p class="meta">Recorded session</p>
      </div></div>
    </div>
  </div>
</section>
