<?php $bg = t4sd_get_mod('t4sd_hero_image'); $style='';
if ($bg) { $url = wp_get_attachment_image_url($bg,'t4sd-hero'); $style = "background-image:url('{$url}');background-size:cover;background-position:center;"; }
?>
<section class="sd-section hero" style="<?php echo esc_attr($style); ?>">
  <div class="container">
    <div class="eyebrow sd-eyebrow"><?php echo esc_html(t4sd_get_mod('t4sd_hero_eyebrow','Inclusive, intergenerational learning since 2020.')); ?></div>
    <h1><?php echo esc_html(t4sd_get_mod('t4sd_hero_title','Connecting generations through technology.')); ?></h1>
    <p class="lead"><?php echo esc_html(t4sd_get_mod('t4sd_hero_blurb','Hands-on smartphone classes for seniors, dialog across generations, and EU collaborations.')); ?></p>
    <div class="cta">
      <a class="btn primary" href="<?php echo esc_url(t4sd_get_mod('t4sd_hero_cta_url','/projects')); ?>"><?php echo esc_html(t4sd_get_mod('t4sd_hero_cta_text','See programs')); ?></a>
      <a class="btn" href="<?php echo esc_url(home_url('/volunteer')); ?>">Volunteer</a>
    </div>
  </div>
</section>
