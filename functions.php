<?php if (!defined('ABSPATH')) exit;

define('T4SD_VERSION', '3.0.0');

/** Helpers */
function t4sd_get_mod($key, $default = '') {
  $value = get_theme_mod($key, null);
  return ($value === null) ? $default : $value;
}

// Sanitize checkbox (Customizer)
function t4sd_sanitize_checkbox($value) {
  return (isset($value) && (bool)$value) ? true : false;
}

// Sanitize limited embed HTML for Customizer textarea
function t4sd_sanitize_embed_html($value) {
  if (empty($value)) {
    return '';
  }

  $allowed = wp_kses_allowed_html('post');

  $allowed['iframe'] = [
    'src' => true,
    'width' => true,
    'height' => true,
    'style' => true,
    'loading' => true,
    'allow' => true,
    'allowfullscreen' => true,
    'frameborder' => true,
    'referrerpolicy' => true,
    'title' => true,
  ];

  $allowed['script'] = [
    'src' => true,
    'async' => true,
    'defer' => true,
    'type' => true,
    'crossorigin' => true,
  ];

  $allowed['div'] = isset($allowed['div']) ? array_merge($allowed['div'], [
    'style' => true,
    'class' => true,
    'id' => true,
    'data-instgrm-permalink' => true,
    'data-instgrm-version' => true,
  ]) : [
    'style' => true,
    'class' => true,
    'id' => true,
    'data-instgrm-permalink' => true,
    'data-instgrm-version' => true,
  ];

  $allowed['blockquote'] = isset($allowed['blockquote']) ? array_merge($allowed['blockquote'], [
    'class' => true,
    'style' => true,
    'data-instgrm-permalink' => true,
    'data-instgrm-version' => true,
  ]) : [
    'class' => true,
    'style' => true,
    'data-instgrm-permalink' => true,
    'data-instgrm-version' => true,
  ];

  return wp_kses($value, $allowed);
}

/** Theme setup */
function t4sd_setup_theme() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_post_type_support('page', 'excerpt');
  add_theme_support('html5', ['search-form','comment-form','comment-list','caption','style','script','navigation-widgets']);
  register_nav_menus(['primary' => __('Primary Menu','theme4sunnydays')]);

  add_image_size('t4sd-hero', 1920, 1080, true);
  add_image_size('t4sd-card', 800, 450, true);
}
add_action('after_setup_theme','t4sd_setup_theme');

/** Assets */
function t4sd_enqueue_assets() {
  // Cache-bust with file modification times so CSS/JS edits show immediately.
  $style_path = get_stylesheet_directory()      . '/style.css';
  $theme_css  = get_template_directory()        . '/assets/css/theme.css';
  $theme_js   = get_template_directory()        . '/assets/js/theme.js';

  $style_ver  = file_exists($style_path) ? filemtime($style_path) : ( defined('T4SD_VERSION') ? T4SD_VERSION : time() );
  $theme_ver  = file_exists($theme_css)  ? filemtime($theme_css)  : ( defined('T4SD_VERSION') ? T4SD_VERSION : time() );
  $script_ver = file_exists($theme_js)   ? filemtime($theme_js)   : ( defined('T4SD_VERSION') ? T4SD_VERSION : time() );

  // Core block CSS
  wp_enqueue_style('wp-block-library');

  // Base stylesheet (variables, defaults)
  wp_enqueue_style('t4sd-style', get_stylesheet_uri(), [], $style_ver);

  // Visual skin / section layout (loads AFTER base)
  wp_enqueue_style(
    't4sd-theme',
    get_template_directory_uri() . '/assets/css/theme.css',
    ['wp-block-library','t4sd-style'],
    $theme_ver
  );

  // Height/spacing overrides (loads AFTER theme.css)
  $heights_css = get_template_directory() . '/assets/css/skin-heights.css';
  $heights_ver = file_exists($heights_css) ? filemtime($heights_css) : ( defined('T4SD_VERSION') ? T4SD_VERSION : time() );
  wp_enqueue_style(
    't4sd-heights',
    get_template_directory_uri() . '/assets/css/skin-heights.css',
    ['t4sd-theme'],
    $heights_ver
  );
  // Final inline overrides (prints after skin-heights.css)
  $pad   = absint( get_theme_mod('t4sd_style_section_pad', 64) );
  $band  = absint( get_theme_mod('t4sd_style_band_pad', 48) );
  $hero  = absint( get_theme_mod('t4sd_style_hero_min', 64) ); // vh
  $h2    = absint( get_theme_mod('t4sd_style_h2', 32) );
  $h3    = absint( get_theme_mod('t4sd_style_h3', 20) );
  $body  = absint( get_theme_mod('t4sd_style_body', 17) );
  $sd_inline = ":root{"
             . "--sd-section-pad: {$pad}px;"
             . "--sd-band-pad: {$band}px;"
             . "--sd-hero-min: {$hero}vh;"
             . "--sd-h2-size: {$h2}px;"
             . "--sd-h3-size: {$h3}px;"
             . "--sd-body-size: {$body}px;"
             . "}";
  wp_add_inline_style('t4sd-heights', $sd_inline);

  // Theme JS
  wp_enqueue_script('t4sd-theme', get_template_directory_uri() . '/assets/js/theme.js', [], $script_ver, true);

  // (Optional) Emit a tiny comment so you can verify versions in View Source
  echo "\n<!-- sd versions: style.css={$style_ver} theme.css={$theme_ver} theme.js={$script_ver} -->\n";
}
// Load a bit later so this wins over late plugin CSS bundles
add_action('wp_enqueue_scripts','t4sd_enqueue_assets', 100);

/** CPTs */
function t4sd_register_cpts() {
  $common = [
    'public'             => true,
    'show_in_rest'       => true,
    'publicly_queryable' => true,
    'show_in_nav_menus'  => true,
    'supports'           => ['title','editor','excerpt','thumbnail'],
  ];

  register_post_type('project', array_merge($common, [
    'label'       => __('Projects','theme4sunnydays'),
    'has_archive' => 'projects',
    'rewrite'     => ['slug' => 'projects', 'with_front' => false],
  ]));

  register_post_type('resource', array_merge($common, [
    'label'       => __('Resources','theme4sunnydays'),
    'has_archive' => 'resources',
    'rewrite'     => ['slug' => 'resources', 'with_front' => false],
  ]));

  register_post_type('webinar', array_merge($common, [
    'label'       => __('Webinars','theme4sunnydays'),
    'has_archive' => 'webinars',
    'rewrite'     => ['slug' => 'webinars', 'with_front' => false],
  ]));

  register_post_type('partner', array_merge($common, [
    'label'       => __('Partners','theme4sunnydays'),
    'has_archive' => 'partners',
    'rewrite'     => ['slug' => 'partners', 'with_front' => false],
  ]));

  register_post_type('team_member', array_merge($common, [
    'label'       => __('Team','theme4sunnydays'),
    'has_archive' => 'team',
    'rewrite'     => ['slug' => 'team', 'with_front' => false],
  ]));

  register_post_type('update', array_merge($common, [
    'label'       => __('Updates','theme4sunnydays'),
    'has_archive' => 'updates',
    'rewrite'     => ['slug' => 'updates', 'with_front' => false],
  ]));

  // Private store for registrations (unchanged)
  register_post_type('t4sd_reg', [
    'public'    => false,
    'show_ui'   => true,
    'label'     => __('Registrations','theme4sunnydays'),
    'supports'  => ['title','editor','custom-fields'],
  ]);
}
add_action('init','t4sd_register_cpts');

/** Simple meta for Team position */
function t4sd_team_meta_box() {
  add_meta_box('t4sd_team_position','Position / Title','t4sd_team_meta_cb','team_member','side');
}
function t4sd_team_meta_cb($post) {
  $pos = get_post_meta($post->ID,'t4sd_position',true);
  echo '<label for="t4sd_position">'.esc_html__('Position / Title','theme4sunnydays').'</label>';
  echo '<input type="text" id="t4sd_position" name="t4sd_position" value="'.esc_attr($pos).'" style="width:100%" />';
}
function t4sd_team_meta_save($post_id) {
  if (array_key_exists('t4sd_position',$_POST)) {
    update_post_meta($post_id,'t4sd_position',sanitize_text_field($_POST['t4sd_position']));
  }
}
add_action('add_meta_boxes','t4sd_team_meta_box');
add_action('save_post','t4sd_team_meta_save');

/** Homepage sections order + renderer */
function t4sd_get_section_order() {
  $default = 'hero,stats,projects,resources,social,webinars,volunteer,partners,testimonials,team,updates,newsletter,contactcta';
  $csv = t4sd_get_mod('t4sd_section_order', $default);
  $parts = array_filter(array_map('trim', explode(',', $csv)));
  // normalize legacy (resourcesocial → resources + social)
  $out = [];
  foreach ($parts as $p) {
    if ($p === 'resourcesocial') { $out[]='resources'; $out[]='social'; continue; }
    $out[] = $p;
  }
  // append missing defaults (never truncate page)
  foreach (explode(',', $default) as $p) { if (!in_array($p,$out,true)) $out[] = $p; }
  return $out;
}

function t4sd_render_home_sections() {
  foreach (t4sd_get_section_order() as $slug) {

    // Respect Customizer show/hide (default: shown)
    $show = get_theme_mod("t4sd_{$slug}_show", true);
    if (!$show) {
      continue;
    }

    $tpl = get_template_directory().'/sections/section-'.$slug.'.php';
    if (file_exists($tpl)) {
      include $tpl;
    }
  }
}

/** Customizer */
require get_template_directory().'/inc/customizer.php';
require get_template_directory().'/inc/customizer-archives.php';

/** Front page + activation bootstrap */
function t4sd_maybe_create_page($title, $slug, $tpl = '') {
  if ($p = get_page_by_path($slug)) return $p->ID;
  $id = wp_insert_post(['post_title'=>$title,'post_name'=>$slug,'post_type'=>'page','post_status'=>'publish']);
  if ($tpl) update_post_meta($id,'_wp_page_template',$tpl);
  return $id;
}

function t4sd_theme_activate() {
  // Create key pages
  $home = t4sd_maybe_create_page('Home','home','templates/homepage.php');
  t4sd_maybe_create_page('Webinars','webinars','');
  t4sd_maybe_create_page('Volunteer','volunteer','templates/page-volunteer.php');
  t4sd_maybe_create_page('Donate','donate','templates/page-donate.php');
  t4sd_maybe_create_page('Contact','contact','templates/page-contact.php');

  // Set static homepage
  update_option('show_on_front','page');
  update_option('page_on_front',$home);

  // Seed 3 projects/resources/partners/team for visual completeness (only if empty)
  $seed = function($type, $titles) {
    if (wp_count_posts($type)->publish > 0) return;
    foreach ($titles as $t) {
      wp_insert_post(['post_type'=>$type,'post_title'=>$t,'post_status'=>'publish','post_content'=>'Demo content for '.$t.'. Replace from wp-admin.']);
    }
  };
  $seed('project',['Digital Bridges (Elderly 60+)','Hate Speech & Cultural Diversity (Youth)','Erasmus+ Collaboration & Adult Education']);
  $seed('resource',['Digital skills hub','Media literacy toolkit','Intergenerational practice']);
  $seed('partner',['Partner One','Partner Two','Partner Three']);
  $seed('team_member',['Team Member One','Team Member Two','Team Member Three','Team Member Four']);

  flush_rewrite_rules();
}
add_action('after_switch_theme','t4sd_theme_activate');

/** Simple registration handler */
function t4sd_register_webinar() {
  if (!isset($_POST['t4sd_reg_nonce']) || !wp_verify_nonce($_POST['t4sd_reg_nonce'],'t4sd_reg')) return;
  $email = sanitize_email($_POST['t4sd_email'] ?? '');
  $title = sanitize_text_field($_POST['t4sd_title'] ?? '');
  if (!$email) return;
  $ip = $_SERVER['REMOTE_ADDR'] ?? '';
  $post_id = wp_insert_post([
    'post_type'=>'t4sd_reg','post_status'=>'publish','post_title'=>$email.' — '.$title,
    'post_content'=>'IP: '.$ip.' — Time: '.current_time('mysql')
  ]);
  // Send confirmation (relies on t4sd_webinars_zoom_link mod)
  $zoom = t4sd_get_mod('t4sd_webinars_zoom_link','');
  $msg = "Thank you for registering for ".$title.". Your Zoom link: ".$zoom;
  wp_mail($email, 'Webinar registration', $msg);
  wp_safe_redirect(add_query_arg('registered','1', wp_get_referer() ?: home_url('/')));
  exit;
}
add_action('admin_post_nopriv_t4sd_register','t4sd_register_webinar');
add_action('admin_post_t4sd_register','t4sd_register_webinar');
