<?php
/* Template Name: Contact */
if (!defined('ABSPATH')) exit;

get_header();
the_post();

$excerpt      = has_excerpt() ? get_the_excerpt() : __('Questions, partnerships, or press—drop us a line.', 'theme4sunnydays');
$raw_content  = get_post_field('post_content', get_the_ID());
$has_shortcode = has_shortcode($raw_content, 'contact-form-7');
$formatted_content = apply_filters('the_content', $raw_content);
$custom_contact_title = trim(get_theme_mod('t4sd_contact_title', ''));
$custom_contact_blurb = trim(get_theme_mod('t4sd_contact_blurb', ''));

$hero_title = $custom_contact_title !== '' ? $custom_contact_title : get_the_title();
$hero_blurb = $custom_contact_blurb !== '' ? $custom_contact_blurb : $excerpt;
?>

<main id="main" class="sd-main sd-contact" role="main">
  <section class="page-hero page-hero--contact">
    <div class="container">
      <span class="badge badge--hero"><?php esc_html_e('Contact', 'theme4sunnydays'); ?></span>
      <h1 class="page-hero__title"><?php echo esc_html($hero_title); ?></h1>
      <?php if ($hero_blurb !== '') : ?>
        <p class="page-hero__lead"><?php echo esc_html($hero_blurb); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <section class="sd-section contact-body">
    <div class="container">
      <?php if ($has_shortcode) : ?>
        <?php echo $formatted_content; ?>
      <?php else : ?>
        <form class="contact-form" method="post" action="mailto:info@stichtingsunnydays.org" enctype="text/plain">
          <label for="contact-name" class="screen-reader-text"><?php esc_html_e('Name', 'theme4sunnydays'); ?></label>
          <input id="contact-name" type="text" name="name" placeholder="<?php esc_attr_e('Your name', 'theme4sunnydays'); ?>" required>

          <label for="contact-email" class="screen-reader-text"><?php esc_html_e('Email', 'theme4sunnydays'); ?></label>
          <input id="contact-email" type="email" name="email" placeholder="<?php esc_attr_e('Email', 'theme4sunnydays'); ?>" required>

          <label for="contact-message" class="screen-reader-text"><?php esc_html_e('Message', 'theme4sunnydays'); ?></label>
          <textarea id="contact-message" name="message" rows="6" placeholder="<?php esc_attr_e('How can we help?', 'theme4sunnydays'); ?>"></textarea>

          <button class="btn" type="submit"><?php esc_html_e('Send', 'theme4sunnydays'); ?></button>
        </form>
      <?php endif; ?>

      <?php if (!$has_shortcode && !empty(trim(strip_tags($formatted_content)))) : ?>
        <article <?php post_class('contact-article'); ?>>
          <div class="contact-article__content">
            <?php echo $formatted_content; ?>
          </div>
        </article>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
