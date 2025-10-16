<?php
/* Template Name: Donate */
if (!defined('ABSPATH')) exit; get_header(); the_post(); ?>
<section class="sd-section">
  <div class="container">
    <div class="sd-header"><h2>Support our work</h2><div class="blurb">Your contribution helps keep programs free for seniors and youth.</div></div>
    <div class="cards-grid">
      <article class="card"><div class="pad"><h3>€25</h3><p>Buys a smartphone SIM for a participant for a month.</p><p><a class="btn secondary" href="#">Donate €25</a></p></div></article>
      <article class="card"><div class="pad"><h3>€50</h3><p>Funds a classroom kit and printed guides.</p><p><a class="btn secondary" href="#">Donate €50</a></p></div></article>
      <article class="card"><div class="pad"><h3>Custom</h3><p>Choose your amount; one-time or recurring.</p><p><a class="btn secondary" href="#">Donate</a></p></div></article>
    </div>
    <div class="content"><?php the_content(); ?></div>
  </div>
</section>
<?php get_footer(); ?>
