<?php
/* Template Name: About */
if (!defined('ABSPATH')) exit;

get_header();
the_post();
$post_content = get_post_field('post_content', get_the_ID());
$custom_about_title = trim(get_theme_mod('t4sd_about_title', ''));
$default_about_blurb = has_excerpt()
  ? get_the_excerpt()
  : __('Stichting Sunny Days helps neighbours of every age exchange skills, stories, and confidence through intergenerational learning.', 'theme4sunnydays');
$custom_about_blurb = trim(get_theme_mod('t4sd_about_blurb', ''));

$hero_title = $custom_about_title !== '' ? $custom_about_title : get_the_title();
$hero_blurb = $custom_about_blurb !== '' ? $custom_about_blurb : $default_about_blurb;

$pillars = [
  [
    'title'       => __('Purpose', 'theme4sunnydays'),
    'description' => __('We nurture inclusive, sustainable learning circles so every generation feels confident sharing knowledge, culture, and digital skills.', 'theme4sunnydays'),
  ],
  [
    'title'       => __('Approach', 'theme4sunnydays'),
    'description' => __('Our programmes mix co-created workshops, mentoring, and neighbourhood events that pair practical skill-building with gentle social connection.', 'theme4sunnydays'),
  ],
  [
    'title'       => __('Who We Bring Together', 'theme4sunnydays'),
    'description' => __('Older adults, young people, newcomers, and international neighbours collaborate with volunteers, Erasmus+ partners, and local libraries.', 'theme4sunnydays'),
  ],
  [
    'title'       => __('Values', 'theme4sunnydays'),
    'description' => __('Curiosity, accessibility, and mutual care guide everything we do—simple, human ways to meet, talk, and learn at every stage of life.', 'theme4sunnydays'),
  ],
];

$timeline = [
  [
    'year'    => '2019',
    'title'   => __('Idea Takes Shape', 'theme4sunnydays'),
    'summary' => __('Community members mapped the gaps in digital confidence and imagined a space where generations teach one another.', 'theme4sunnydays'),
  ],
  [
    'year'    => '2020',
    'title'   => __('First Neighbourhood Labs', 'theme4sunnydays'),
    'summary' => __('We piloted small-group gatherings in Utrecht, blending digital coaching with intergenerational storytelling.', 'theme4sunnydays'),
  ],
  [
    'year'    => '2021',
    'title'   => __('Recognised by Erasmus+', 'theme4sunnydays'),
    'summary' => __('Cross-border collaborators joined, helping us adapt our format for diverse languages, cultures, and access needs.', 'theme4sunnydays'),
  ],
  [
    'year'    => '2022',
    'title'   => __('Partners Multiply', 'theme4sunnydays'),
    'summary' => __('Libraries, youth organisations, and senior associations began running Sunny Days sessions with their own teams.', 'theme4sunnydays'),
  ],
  [
    'year'    => '2023',
    'title'   => __('Digital Learning Hub', 'theme4sunnydays'),
    'summary' => __('We launched an open resource library featuring bite-sized lessons, conversation guides, and impact stories.', 'theme4sunnydays'),
  ],
  [
    'year'    => '2024',
    'title'   => __('Scaling What Works', 'theme4sunnydays'),
    'summary' => __('Our facilitators train new cohorts and share insights through webinars so communities across Europe can replicate the model.', 'theme4sunnydays'),
  ],
];
?>

<main id="main" class="sd-main sd-about" role="main">
  <section class="page-hero page-hero--about">
    <div class="container">
      <span class="badge badge--hero"><?php esc_html_e('About', 'theme4sunnydays'); ?></span>
      <h1 class="page-hero__title"><?php echo esc_html($hero_title); ?></h1>
      <?php if ($hero_blurb !== '') : ?>
        <p class="page-hero__lead"><?php echo esc_html($hero_blurb); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <section class="about-overview sd-section">
    <div class="container split-2">
      <div class="about-pillars">
        <?php foreach ($pillars as $pillar) : ?>
          <article class="about-card">
            <h3><?php echo esc_html($pillar['title']); ?></h3>
            <p><?php echo esc_html($pillar['description']); ?></p>
          </article>
        <?php endforeach; ?>
      </div>

      <aside class="about-story">
        <span class="badge"><?php esc_html_e('Our Story', 'theme4sunnydays'); ?></span>
        <div class="about-timeline" role="list">
          <?php foreach ($timeline as $event) : ?>
            <div class="timeline-item" role="listitem">
              <div class="timeline-item__marker" aria-hidden="true"></div>
              <div class="timeline-item__body">
                <span class="timeline-item__year"><?php echo esc_html($event['year']); ?></span>
                <h4 class="timeline-item__title"><?php echo esc_html($event['title']); ?></h4>
                <p class="timeline-item__summary"><?php echo esc_html($event['summary']); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </aside>
    </div>
  </section>

  <?php if (!empty(trim($post_content))) : ?>
    <section class="sd-section about-body">
      <div class="container">
        <article <?php post_class('about-article'); ?>>
          <div class="about-article__content">
            <?php the_content(); ?>
          </div>
        </article>
      </div>
    </section>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
