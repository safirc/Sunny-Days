<?php if (!defined('ABSPATH')) exit;

add_action('customize_register', function (WP_Customize_Manager $wp) {
  $wp->add_panel('t4sd_archives',[ 'title'=>__('Archives (List Pages)','theme4sunnydays'), 'priority'=>45 ]);

  $types = [
    'project'     => __('Projects','theme4sunnydays'),
    'webinar'     => __('Webinars','theme4sunnydays'),
    'team_member' => __('Team','theme4sunnydays'),
    'partner'     => __('Partners','theme4sunnydays'),
    'resource'    => __('Resources','theme4sunnydays'),
    'update'      => __('Updates','theme4sunnydays'),
  ];

  foreach ($types as $pt => $label) {
    $sec = "t4sd_archives_{$pt}";
    $wp->add_section($sec,['title'=>$label,'panel'=>'t4sd_archives']);
    $wp->add_setting("t4sd_archives_{$pt}_title",['default'=>$label,'sanitize_callback'=>'sanitize_text_field']);
    $wp->add_control("t4sd_archives_{$pt}_title",['label'=>__('Title','theme4sunnydays'),'type'=>'text','section'=>$sec]);
    $wp->add_setting("t4sd_archives_{$pt}_blurb",['default'=>'','sanitize_callback'=>'sanitize_textarea_field']);
    $wp->add_control("t4sd_archives_{$pt}_blurb",['label'=>__('Blurb','theme4sunnydays'),'type'=>'textarea','section'=>$sec]);
    $wp->add_setting("t4sd_archives_{$pt}_bg",['default'=>'','sanitize_callback'=>'sanitize_hex_color']);
    $wp->add_control(new WP_Customize_Color_Control($wp,"t4sd_archives_{$pt}_bg",[ 'label'=>__('Background','theme4sunnydays'),'section'=>$sec ]));
  }
});
