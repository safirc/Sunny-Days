<?php
$testimonials = [
  [
    'quote' => 'These sessions made me feel confident using my phone. My grandson and I now share photos every day.',
    'meta'  => ['Leyla, 72', 'Utrecht', '2024'],
  ],
  [
    'quote' => 'Teaching digital basics taught me patience and listening. We learned from each other.',
    'meta'  => ['Mira, 19', 'Volunteer', '2024'],
  ],
  [
    'quote' => 'The intergenerational approach is genius—skills flow both ways, relationships grow.',
    'meta'  => ['NGO Partner', 'Spain', '2023'],
  ],
];
$eyebrow = t4sd_get_mod('t4sd_testimonials_eyebrow','Proof of impact');
$blurb   = t4sd_get_mod('t4sd_testimonials_blurb','');
?>
<section class="sd-section sd-testimonials soft" style="background:<?php echo esc_attr(t4sd_get_mod('t4sd_testimonials_bg','#f6fbff')); ?>">
  <div class="container">
    <div class="sd-header">
      <?php if (!empty($eyebrow)): ?><div class="sd-eyebrow"><?php echo esc_html($eyebrow); ?></div><?php endif; ?>
      <h2><?php echo esc_html(t4sd_get_mod('t4sd_testimonials_title','Testimonials')); ?></h2>
      <?php if (!empty($blurb)): ?><div class="blurb"><?php echo esc_html($blurb); ?></div><?php endif; ?>
    </div>
    <div class="cards-grid testimonials-grid">
      <?php foreach ($testimonials as $item): ?>
        <?php $meta_parts = array_filter($item['meta']); ?>
        <blockquote class="card">
          <div class="pad">
            <p>&ldquo;<?php echo esc_html($item['quote']); ?>&rdquo;</p>
            <?php if (!empty($meta_parts)): ?>
              <p class="meta">&mdash; <?php echo esc_html(implode(' • ', $meta_parts)); ?></p>
            <?php endif; ?>
          </div>
        </blockquote>
      <?php endforeach; ?>
    </div>
  </div>
</section>
