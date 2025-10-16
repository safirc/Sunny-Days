<?php
/* Template Name: Volunteer */
if (!defined('ABSPATH')) exit; get_header(); the_post(); ?>
<section class="sd-section">
  <div class="container">
    <div class="sd-header"><h2>Volunteer with Sunny Days</h2><div class="blurb">Help facilitate trainings, support events, or contribute skills behind the scenes.</div></div>
    <div class="cards-grid">
      <article class="card"><div class="pad"><h3>Classroom Assistant</h3><p>Support smartphone classes for seniors.</p></div></article>
      <article class="card"><div class="pad"><h3>Event Support</h3><p>Help with venue setup and attendee flow.</p></div></article>
      <article class="card"><div class="pad"><h3>Digital Mentor</h3><p>Provide one-on-one help during open hours.</p></div></article>
    </div>
    <p style="margin-top:16px"><a class="btn" href="<?php echo esc_url(home_url('/contact')); ?>">Express interest</a></p>
    <div class="content"><?php the_content(); ?></div>
  </div>
</section>
<?php get_footer(); ?>
