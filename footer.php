<?php if (!defined('ABSPATH')) exit; ?>

<section class="footer-cta cta-band">
  <div class="container">
    <div class="sd-header">
      <div class="sd-eyebrow"><?php esc_html_e('Get in touch','theme4sunnydays'); ?></div>
      <h2><?php esc_html_e('Questions, partnerships, or press?','theme4sunnydays'); ?></h2>
      <p class="blurb"><?php esc_html_e('Reach us via the contact form or drop us an email.','theme4sunnydays'); ?></p>
    </div>
    <div class="cta-actions">
      <a class="btn" href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact','theme4sunnydays'); ?></a>
    </div>
  </div>
</section>

<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <h4>Sunny Days</h4>
      <p>Utrecht, Netherlands · KVK 76964760<br>Inclusive, intergenerational learning since 2020.</p>
    </div>
    <div>
      <h4>Programs</h4>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/projects')); ?>">Digital Bridges (60+)</a></li>
        <li><a href="<?php echo esc_url(home_url('/projects')); ?>">Youth Dialogue &amp; Media Literacy</a></li>
        <li><a href="<?php echo esc_url(home_url('/projects')); ?>">Erasmus+ Adult Education</a></li>
      </ul>
    </div>
    <div>
      <h4>Get Involved</h4>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/volunteer')); ?>">Volunteer</a></li>
        <li><a href="<?php echo esc_url(home_url('/donate')); ?>">Donate</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
      </ul>
    </div>
    <div>
      <h4>Follow</h4>
      <ul>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">LinkedIn</a></li>
        <li><a href="#">Facebook</a></li>
      </ul>
    </div>
  </div>
  <div class="container footer-bottom">
    &copy; <?php echo date('Y'); ?> Stichting Sunny Days. All rights reserved.
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
