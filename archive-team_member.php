<?php
if (!defined('ABSPATH')) exit;

get_header();

global $wp_query;

$pt_object  = get_post_type_object('team_member');
$title      = get_theme_mod('t4sd_archives_team_member_title', $pt_object ? $pt_object->labels->name : __('Team', 'theme4sunnydays'));
$blurb      = get_theme_mod('t4sd_archives_team_member_blurb', __('Meet the volunteers, facilitators, and partners who keep Sunny Days moving forward.', 'theme4sunnydays'));
$background = get_theme_mod('t4sd_archives_team_member_bg', '#ffffff');
$paged      = max(1, get_query_var('paged'));
?>

<main id="main" class="sd-main sd-archive sd-archive--team" role="main">
  <section class="page-hero page-hero--archive">
    <div class="container">
      <span class="badge badge--hero"><?php echo esc_html($pt_object ? $pt_object->labels->name : __('Team', 'theme4sunnydays')); ?></span>
      <h1 class="page-hero__title"><?php echo esc_html($title); ?></h1>
      <?php if (!empty($blurb)) : ?>
        <p class="page-hero__lead"><?php echo esc_html($blurb); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <section class="sd-section archive-grid" style="background:<?php echo esc_attr($background); ?>">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="cards-grid">
          <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('card'); ?>>
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('t4sd-card'); ?>
              <?php endif; ?>
              <div class="pad">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php if ($role = get_post_meta(get_the_ID(), 'team_member_role', true)) : ?>
                  <p class="meta"><?php echo esc_html($role); ?></p>
                <?php endif; ?>
                <p><?php echo wp_kses_post(get_the_excerpt()); ?></p>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

        <?php
        $pagination = paginate_links([
          'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
          'format'    => '?paged=%#%',
          'current'   => $paged,
          'total'     => $wp_query->max_num_pages,
          'type'      => 'list',
          'prev_text' => __('Previous', 'theme4sunnydays'),
          'next_text' => __('Next', 'theme4sunnydays'),
        ]);
        if ($pagination) :
          ?>
          <nav class="pagination" aria-label="<?php esc_attr_e('Team pagination', 'theme4sunnydays'); ?>">
            <?php echo $pagination; ?>
          </nav>
        <?php endif; ?>
      <?php else : ?>
        <p class="archive-empty"><?php esc_html_e('Our team page is being updated. Please check back soon.', 'theme4sunnydays'); ?></p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
