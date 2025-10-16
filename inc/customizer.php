<?php if (!defined('ABSPATH')) exit;

add_action('customize_register', function (WP_Customize_Manager $wp) {
  // Panels
  $wp->add_panel('t4sd_home', [
    'title' => __('Sunny Days — Homepage','theme4sunnydays'),
    'priority' => 10
  ]);
  $wp->add_panel('t4sd_pages', [
    'title'    => __('Sunny Days — Pages','theme4sunnydays'),
    'priority' => 15,
  ]);

  // Section order
  $wp->add_section('t4sd_order', ['title'=>__('Section Order','theme4sunnydays'),'panel'=>'t4sd_home']);
  $wp->add_setting('t4sd_section_order', [
    'default'=>'hero,stats,projects,resources,webinars,volunteer,partners,testimonials,team,updates,newsletter,contactcta',
    'sanitize_callback'=>'sanitize_text_field'
  ]);
  $wp->add_control('t4sd_section_order', [
    'label'=>__('CSV of sections','theme4sunnydays'),
    'type'=>'text','section'=>'t4sd_order',
    'description'=>'Allowed: hero,stats,projects,resources,webinars,volunteer,partners,testimonials,team,updates,newsletter,contactcta'
  ]);

  // Reusable helper (title, blurb, eyebrow, background)
  $make = function($slug, $config) use ($wp) {
    $label    = is_array($config) ? ($config['label'] ?? '') : $config;
    $defaults = is_array($config) ? ($config['defaults'] ?? []) : [];
    $sec      = 't4sd_sec_'.$slug;

    $wp->add_section($sec,['title'=>$label,'panel'=>'t4sd_home']);

    // NEW: Show/Hide toggle
    $wp->add_setting("t4sd_{$slug}_show",['default'=>true,'sanitize_callback'=>'t4sd_sanitize_checkbox']);
    $wp->add_control("t4sd_{$slug}_show",['label'=>__('Show this section','theme4sunnydays'),'type'=>'checkbox','section'=>$sec]);

    $wp->add_setting("t4sd_{$slug}_title",['default'=>$defaults['title'] ?? $label,'sanitize_callback'=>'sanitize_text_field']);
    $wp->add_control("t4sd_{$slug}_title",['label'=>__('Title','theme4sunnydays'),'type'=>'text','section'=>$sec]);
    $wp->add_setting("t4sd_{$slug}_eyebrow",['default'=>$defaults['eyebrow'] ?? '','sanitize_callback'=>'sanitize_text_field']);
    $wp->add_control("t4sd_{$slug}_eyebrow",['label'=>__('Eyebrow','theme4sunnydays'),'type'=>'text','section'=>$sec]);
    $wp->add_setting("t4sd_{$slug}_blurb",['default'=>$defaults['blurb'] ?? '','sanitize_callback'=>'sanitize_textarea_field']);
    $wp->add_control("t4sd_{$slug}_blurb",['label'=>__('Blurb','theme4sunnydays'),'type'=>'textarea','section'=>$sec]);
    $wp->add_setting("t4sd_{$slug}_bg",['default'=>$defaults['bg'] ?? '','sanitize_callback'=>'sanitize_hex_color']);
    $wp->add_control(new WP_Customize_Color_Control($wp,"t4sd_{$slug}_bg",[ 'label'=>__('Background','theme4sunnydays'),'section'=>$sec ]));
  };

  // Sections
  foreach ([
    'hero'         => ['label'=>'Hero',        'defaults'=>['eyebrow'=>'Inclusive, intergenerational learning since 2020.']],
    'stats'        => ['label'=>'Stats'],
    'projects'     => ['label'=>'Projects'],
    'resources'    => ['label'=>'Resources'],
    'webinars'     => ['label'=>'Webinars'],
    'volunteer'    => ['label'=>'Volunteer'],
    'partners'     => ['label'=>'Partners'],
    'testimonials' => ['label'=>'Testimonials', 'defaults'=>['eyebrow'=>'Proof of impact']],
    'team'         => ['label'=>'Team'],
    'updates'      => ['label'=>'Updates'],
    'newsletter'   => ['label'=>'Newsletter'],
    'contactcta'   => ['label'=>'Contact CTA']
  ] as $slug=>$config) { $make($slug, $config); }

  // Hero extras
  $wp->add_setting('t4sd_hero_image',['sanitize_callback'=>'absint']);
  $wp->add_control(new WP_Customize_Media_Control($wp,'t4sd_hero_image',[ 'label'=>__('Hero Background','theme4sunnydays'), 'section'=>'t4sd_sec_hero', 'mime_type'=>'image' ]));
  $wp->add_setting('t4sd_hero_cta_text',['default'=>'See programs','sanitize_callback'=>'sanitize_text_field']);
  $wp->add_setting('t4sd_hero_cta_url',['default'=>'/projects','sanitize_callback'=>'esc_url_raw']);
  $wp->add_control('t4sd_hero_cta_text',['label'=>__('Primary CTA text','theme4sunnydays'),'type'=>'text','section'=>'t4sd_sec_hero']);
  $wp->add_control('t4sd_hero_cta_url',['label'=>__('Primary CTA link','theme4sunnydays'),'type'=>'url','section'=>'t4sd_sec_hero']);

  // Webinars: Zoom link storage + shortcode override
  $wp->add_setting('t4sd_webinars_zoom_link',['default'=>'','sanitize_callback'=>'esc_url_raw']);
  $wp->add_control('t4sd_webinars_zoom_link',['label'=>__('Default Zoom link for confirmation email','theme4sunnydays'),'type'=>'url','section'=>'t4sd_sec_webinars']);
  $wp->add_setting('t4sd_webinars_shortcode',['default'=>'','sanitize_callback'=>'wp_kses_post']);
  $wp->add_control('t4sd_webinars_shortcode',['label'=>__('Override: registration form shortcode (optional)','theme4sunnydays'),'type'=>'text','section'=>'t4sd_sec_webinars']);
  $wp->add_setting('t4sd_webinars_recent_url',['default'=>'','sanitize_callback'=>'esc_url_raw']);
  $wp->add_control('t4sd_webinars_recent_url',[
    'label'=>__('Recent webinar video URL','theme4sunnydays'),
    'description'=>__('Paste a full YouTube or Vimeo URL to feature as the “Most Recent” video.','theme4sunnydays'),
    'type'=>'url',
    'section'=>'t4sd_sec_webinars'
  ]);

  // Resources → Social feed controls
  $wp->add_setting('t4sd_resources_social_show',['default'=>true,'sanitize_callback'=>'t4sd_sanitize_checkbox']);
  $wp->add_control('t4sd_resources_social_show',[
    'label'=>__('Show Social feed next to Resources','theme4sunnydays'),
    'type'=>'checkbox',
    'section'=>'t4sd_sec_resources'
  ]);
  $wp->add_setting('t4sd_social_title',['default'=>'Social','sanitize_callback'=>'sanitize_text_field']);
  $wp->add_control('t4sd_social_title',[
    'label'=>__('Social feed title','theme4sunnydays'),
    'type'=>'text',
    'section'=>'t4sd_sec_resources'
  ]);
  $wp->add_setting('t4sd_social_blurb',['default'=>'','sanitize_callback'=>'sanitize_textarea_field']);
  $wp->add_control('t4sd_social_blurb',[
    'label'=>__('Social feed blurb','theme4sunnydays'),
    'type'=>'textarea',
    'section'=>'t4sd_sec_resources'
  ]);
  $wp->add_setting('t4sd_social_embed',['default'=>'','sanitize_callback'=>'t4sd_sanitize_embed_html']);
  $wp->add_control('t4sd_social_embed',[
    'label'=>__('Social feed embed code','theme4sunnydays'),
    'description'=>__('Paste the Instagram/Facebook embed code or shortcode.','theme4sunnydays'),
    'type'=>'textarea',
    'section'=>'t4sd_sec_resources'
  ]);


// === Global Styles (tokens) ===
$wp->add_section('t4sd_style', ['title'=>__('Global Styles','theme4sunnydays'), 'priority'=>5]);

// Typography tokens
$wp->add_setting('t4sd_style_h2',   ['default'=>36, 'sanitize_callback'=>'absint']);
$wp->add_setting('t4sd_style_h3',   ['default'=>20, 'sanitize_callback'=>'absint']);
$wp->add_setting('t4sd_style_body', ['default'=>17, 'sanitize_callback'=>'absint']);
$wp->add_control('t4sd_style_h2',   ['label'=>__('Section H2 size (px)','theme4sunnydays'),'type'=>'number','section'=>'t4sd_style','input_attrs'=>['min'=>24,'max'=>64]]);
$wp->add_control('t4sd_style_h3',   ['label'=>__('Card/Item H3 size (px)','theme4sunnydays'),'type'=>'number','section'=>'t4sd_style','input_attrs'=>['min'=>16,'max'=>36]]);
$wp->add_control('t4sd_style_body', ['label'=>__('Base body size (px)','theme4sunnydays'),'type'=>'number','section'=>'t4sd_style','input_attrs'=>['min'=>14,'max'=>22]]);

// Section rhythm tokens
$wp->add_setting('t4sd_style_section_pad', ['default'=>64, 'sanitize_callback'=>'absint']);
$wp->add_setting('t4sd_style_band_pad',    ['default'=>48, 'sanitize_callback'=>'absint']);
  $wp->add_setting('t4sd_style_hero_min',    ['default'=>64, 'sanitize_callback'=>'absint']);
  $wp->add_control('t4sd_style_section_pad', ['label'=>__('Section padding (px)','theme4sunnydays'),'type'=>'number','section'=>'t4sd_style','input_attrs'=>['min'=>24,'max'=>128]]);
  $wp->add_control('t4sd_style_band_pad',    ['label'=>__('Band padding (px)','theme4sunnydays'),'type'=>'number','section'=>'t4sd_style','input_attrs'=>['min'=>16,'max'=>96]]);
  $wp->add_control('t4sd_style_hero_min',    ['label'=>__('Hero minimum height (vh)','theme4sunnydays'),'type'=>'number','section'=>'t4sd_style','input_attrs'=>['min'=>40,'max'=>92]]);

  // Standalone pages — About
  $wp->add_section('t4sd_page_about', [
    'title'       => __('About Page Hero','theme4sunnydays'),
    'panel'       => 't4sd_pages',
    'priority'    => 10,
    'description' => __('Customize the headline and blurb shown on the About hero.', 'theme4sunnydays'),
  ]);
  $wp->add_setting('t4sd_about_title', [
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ]);
  $wp->add_control('t4sd_about_title', [
    'label'   => __('Custom title','theme4sunnydays'),
    'type'    => 'text',
    'section' => 't4sd_page_about',
  ]);
  $wp->add_setting('t4sd_about_blurb', [
    'default'           => '',
    'sanitize_callback' => 'sanitize_textarea_field',
  ]);
  $wp->add_control('t4sd_about_blurb', [
    'label'       => __('Hero blurb','theme4sunnydays'),
    'type'        => 'textarea',
    'section'     => 't4sd_page_about',
    'description' => __('Leave blank to fall back to the page excerpt.', 'theme4sunnydays'),
  ]);

  // Standalone pages — Contact
  $wp->add_section('t4sd_page_contact', [
    'title'       => __('Contact Page Hero','theme4sunnydays'),
    'panel'       => 't4sd_pages',
    'priority'    => 20,
    'description' => __('Customize the headline and blurb shown on the Contact hero.', 'theme4sunnydays'),
  ]);
  $wp->add_setting('t4sd_contact_title', [
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ]);
  $wp->add_control('t4sd_contact_title', [
    'label'   => __('Custom title','theme4sunnydays'),
    'type'    => 'text',
    'section' => 't4sd_page_contact',
  ]);
  $wp->add_setting('t4sd_contact_blurb', [
    'default'           => '',
    'sanitize_callback' => 'sanitize_textarea_field',
  ]);
  $wp->add_control('t4sd_contact_blurb', [
    'label'       => __('Hero blurb','theme4sunnydays'),
    'type'        => 'textarea',
    'section'     => 't4sd_page_contact',
    'description' => __('Leave blank to fall back to the page excerpt.', 'theme4sunnydays'),
  ]);

});
