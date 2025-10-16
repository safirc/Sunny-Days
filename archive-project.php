<?php
if (!defined('ABSPATH')) exit;

get_header();

$pt_object     = get_post_type_object('project');
$title         = get_theme_mod('t4sd_archives_project_title', $pt_object ? $pt_object->labels->name : __('Projects', 'theme4sunnydays'));
$blurb         = get_theme_mod('t4sd_archives_project_blurb', __('Explore how we co-create learning experiences and neighbourhood labs with our partners.', 'theme4sunnydays'));
$background    = get_theme_mod('t4sd_archives_project_bg', '#ffffff');
$search_term   = isset($_GET['q']) ? sanitize_text_field(wp_unslash($_GET['q'])) : '';
$paged         = max(1, get_query_var('paged'));

$query_args = [
  'post_type'      => 'project',
  'post_status'    => 'publish',
  'paged'          => $paged,
  'posts_per_page' => get_option('posts_per_page'),
];

if (!empty($search_term)) {
  $query_args['s'] = $search_term;
}

$projects = new WP_Query($query_args);
?>

<main id="main" class="sd-main sd-archive sd-archive--projects" role="main">
  <section class="page-hero page-hero--archive">
    <div class="container">
      <span class="badge badge--hero"><?php echo esc_html($pt_object ? $pt_object->labels->name : __('Projects', 'theme4sunnydays')); ?></span>
      <h1 class="page-hero__title"><?php echo esc_html($title); ?></h1>
      <?php if (!empty($blurb)) : ?>
        <p class="page-hero__lead"><?php echo esc_html($blurb); ?></p>
      <?php endif; ?>

      <form class="page-hero__search" role="search" method="get" action="<?php echo esc_url(get_post_type_archive_link('project')); ?>">
        <label class="screen-reader-text" for="project-search"><?php esc_html_e('Search projects', 'theme4sunnydays'); ?></label>
        <input id="project-search" type="search" name="q" value="<?php echo esc_attr($search_term); ?>" placeholder="<?php esc_attr_e('Search projects', 'theme4sunnydays'); ?>">
        <button class="btn" type="submit"><?php esc_html_e('Search', 'theme4sunnydays'); ?></button>
      </form>
    </div>
  </section>

  <section class="sd-section archive-grid" style="background:<?php echo esc_attr($background); ?>">
    <div class="container">
      <?php if ($projects->have_posts()) : ?>
        <div class="cards-grid">
          <?php while ($projects->have_posts()) : $projects->the_post(); ?>
            <article <?php post_class('card'); ?>>
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('t4sd-card'); ?>
              <?php endif; ?>
              <div class="pad">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="meta"><?php echo esc_html(get_the_date()); ?></p>
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
          'total'     => $projects->max_num_pages,
          'type'      => 'list',
          'add_args'  => !empty($search_term) ? ['q' => $search_term] : false,
          'prev_text' => __('Previous', 'theme4sunnydays'),
          'next_text' => __('Next', 'theme4sunnydays'),
        ]);
        if ($pagination) :
          ?>
          <nav class="pagination" aria-label="<?php esc_attr_e('Projects pagination', 'theme4sunnydays'); ?>">
            <?php echo $pagination; ?>
          </nav>
        <?php endif; ?>

      <?php else : ?>
        <p class="archive-empty"><?php esc_html_e('No projects found right now. Try another search or check back soon.', 'theme4sunnydays'); ?></p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php
wp_reset_postdata();
get_footer();
