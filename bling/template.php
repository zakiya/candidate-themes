<?php

function bling_preprocess_page(&$vars) {
  // Add a suggestion for a per node type page template.
  if (isset($vars['node'])) {
    $vars['theme_hook_suggestions'][] =  'page__' .  $vars['node']->type;
  }
}

function bling_preprocess_html(&$vars) {
  // Add viewport to Head for mobile browsing
  $viewport = array(
    '#tag' => 'meta', 
    '#attributes' => array(
      'name' => 'viewport', 
      'content' => 'width=device-width, initial-scale=1',
    ),
  );
  drupal_add_html_head($viewport, 'viewport');
}

function bling_css_alter(&$css) {
  // If we're only a donation page node, swap out the default css for one used
  // to render donation forms.
  if (arg(0) == 'node' && is_numeric(arg(1)) && (arg(2) == 'done' || !arg(2))) {
    $node = node_load(arg(1));
    if ($node->type == 'donation_form') {
      $theme_path = drupal_get_path('theme', 'bling');
      if (isset($css[$theme_path . '/css/layout.css'])) {
        $css[$theme_path . '/css/layout.css']['data'] = $theme_path . '/css/donation-layout.css';
      }
    }
  }
}
