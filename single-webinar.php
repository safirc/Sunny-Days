<?php if (!defined('ABSPATH')) exit; get_header(); the_post(); ?>
<section class="sd-section">
  <div class="container">
    <article class="single">
      <h1><?php the_title(); ?></h1>
      <div class="content"><?php the_content(); ?></div>
      <h3>Register</h3>
      <?php if ($short = t4sd_get_mod('t4sd_webinars_shortcode','')): echo do_shortcode($short); else: ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display:flex;gap:12px;align-items:center">
          <input type="hidden" name="action" value="t4sd_register">
          <?php wp_nonce_field('t4sd_reg','t4sd_reg_nonce'); ?>
          <input type="hidden" name="t4sd_title" value="<?php the_title_attribute(); ?>">
          <input type="email" name="t4sd_email" placeholder="Email address" required style="flex:1;padding:14px 18px;border:1px solid #cfd9ea;border-radius:999px">
          <button class="btn" type="submit">Register</button>
        </form>
      <?php endif; ?>
    </article>
  </div>
</section>
<?php get_footer(); ?>
