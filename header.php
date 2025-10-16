<?php if (!defined('ABSPATH')) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="sd-site-header" role="banner">
  <div class="container sd-site-header__inner">
    <div class="sd-site-header__brand">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="sd-logo-link" aria-label="<?php esc_attr_e('Homepage','theme4sunnydays'); ?>">
        <img
          src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/SunnyDaysLogo.png"
          alt="<?php bloginfo('name'); ?>"
          class="sd-logo"
          height="60"
          loading="eager"
          decoding="async"
        />
      </a>
    </div>

    <!-- Mobile toggle -->
    <button class="sd-nav-toggle" id="sdNavToggle" aria-controls="sd-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation','theme4sunnydays'); ?>">
      <span class="sd-nav-toggle__bar"></span>
      <span class="sd-nav-toggle__bar"></span>
      <span class="sd-nav-toggle__bar"></span>
    </button>

    <nav class="sd-primary-nav" role="navigation" aria-label="<?php esc_attr_e('Primary','theme4sunnydays'); ?>">
      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'menu_id'        => 'sd-menu',
          'menu_class'     => 'sd-menu',
          'container'      => false,
          'fallback_cb'    => false,
        ]);
      ?>
    </nav>

    <div class="sd-site-header__cta">
      <a class="btn primary" href="<?php echo esc_url(home_url('/donate')); ?>">
        <?php _e('Donate','theme4sunnydays'); ?>
      </a>
    </div>
  </div>
</header>
