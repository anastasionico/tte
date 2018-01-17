<?php

/**
 * @file
 * template.php
 */
function sbtheme_preprocess_page(&$variables) {
  $variables['path'] = base_path() . path_to_theme();
}

/**
 * Remove height and width for drupal images
 */
function sbtheme_preprocess_image(&$variables) {
  if(isset($variables['style_name'])) {
    if($variables['style_name'] == 'responsive') {
      foreach(array('width','height') as $key) {
       unset($variables[$key]);
      }
    }
  }
}

/**
 * Add image responsive class to any images with 
 * the style 'responsive'.
 */
function sbtheme_preprocess_image_style(&$variables) {
  if($variables['style_name'] == 'responsive') {
    $variables['attributes']['class'][] = 'img-responsive'; // can be 'img-rounded', 'img-circle', or 'img-thumbnail'
  }
}

/**
 * Add some chevrons spans to the pager links
 */
function sbtheme_pager_link($variables) {
  $text = $variables['text'];
  $page_new = $variables['page_new'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $attributes = $variables['attributes'];

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = drupal_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('« first') => t('Go to first page'),
        t('‹ previous') => t('Go to previous page'),
        t('next ›') => t('Go to next page'),
        t('last »') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    elseif (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  // @todo l() cannot be used here, since it adds an 'active' class based on the
  //   path only (which is always the current path for pager links). Apparently,
  //   none of the pager links is active at any time - but it should still be
  //   possible to use l() here.
  // @see http://drupal.org/node/1410574
  $attributes['href'] = url($_GET['q'], array('query' => $query));
  return '<a' . drupal_attributes($attributes) . '><span class="chevron"></span>' . check_plain($text) . '</a>';
}

/**
 * Theme wrapper function for the van menu links.
 */
function sbtheme_menu_tree__menu_van_menu(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function sbtheme_menu_link__menu_van_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
/**
 * Theme wrapper function for the van menu links.
 */
function sbtheme_menu_tree__menu_truck_menu(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function sbtheme_menu_link__menu_truck_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
/**
 * Theme wrapper function for the van menu links.
 */
function sbtheme_menu_tree__menu_used_menu(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function sbtheme_menu_link__menu_used_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
/**
 * Theme wrapper function for the van menu links.
 */
function sbtheme_menu_tree__menu_parts(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function sbtheme_menu_link__menu_parts(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
/**
 * Theme wrapper function for the van menu links.
 */
function sbtheme_menu_tree__menu_service_menu(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function sbtheme_menu_link__menu_service_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
/**
 * Theme wrapper function for the van menu links.
 */
function sbtheme_menu_tree__menu_about_us_menu(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function sbtheme_menu_link__menu_about_us_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
/**
 * Theme wrapper function for the van menu links.
 */
function sbtheme_menu_tree__menu_contact_menu(&$variables) {
  return '<ul>' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function sbtheme_menu_link__menu_contact_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function sbtheme_preprocess_html(&$variables) {
    $path = isset($_GET['q']) ? $_GET['q'] : 'index';
    if($path == 'index') {
        $variables['head_title'] = 'S & B Commercials | Used Mercedes Vans, Trucks & Parts Dealer';
        $variables['head_description'] = 'S & B Commercials | Used Mercedes Vans, Trucks & Parts Dealer';
    }
    if($path == 'mercedes/used') $variables['head_title'] = 'Used Commercial Vehicles | Vans & Trucks from S&B Commercials';
    if($path == 'mercedes/used/c/curtainside') $variables['head_title'] = 'Curtainside Trucks | Used Trucks from S&B Commercials Mercedes-Benz';
    if($path == 'mercedes/used/c/dualiner') $variables['head_title'] = 'Mercedes Benz Dualiner | Vito, Citan & Sprinter | S&B Commercials';
    if($path == 'mercedes/used/c/luton_box') $variables['head_title'] = 'Luton Box | Used Trucks from S&B Commercials Mercedes-Benz';
    if($path == 'mercedes/used/c/mini_bus') $variables['head_title'] = 'Mercedes Benz Mini Bus | Used Vans from S&B Commercials';
    if($path == 'mercedes/used/c/panel_van') $variables['head_title'] = 'Mercedes-Benz Panel Van | Used Vans from S&B Commercials';
    if($path == 'mercedes/used/c/people_carrier') $variables['head_title'] = 'Mercedes-Benz People Carrier | Used Vans from S&B Commercials ';
    if($path == 'mercedes/used/c/refrigerated') $variables['head_title'] = 'Refrigerated Trucks & Vans | Used Vehicles from S&B Mercedes-Benz';
    if($path == 'mercedes/used/c/specialist') $variables['head_title'] = 'Specialist Trucks & Vans| Used Vehicles from S&B Mercedes-Benz';
    if($path == 'mercedes/used/c/tractor_unit') $variables['head_title'] = 'Tractor Unit | S&B Commercials Plc Mercedes-Benz';
    if($path == 'mercedes/used/c/traveliner') $variables['head_title'] = 'Mercedes Benz Traveliner | Vito, Citan & Sprinter | S&B Commercials';
    if($path == 'mercedes/used/c/truck_dropside') $variables['head_title'] = 'Dropside | Used Trucks from S&B Commercials Mercedes-Benz';
    if($path == 'mercedes/used/c/truck_tipper') $variables['head_title'] = 'Tipper | Used Trucks from S&B Commercials Mercedes-Benz';
    if($path == 'mercedes-trucks') $variables['head_title'] = 'Mercedes Benz Trucks | S&B Commercials Plc';
    if($path == 'mercedes-vans') $variables['head_title'] = 'Mercedes Benz Vans | S&B Commercials Plc';
    if($path == 'service') $variables['head_title'] = 'Mercedes Benz Service | S&B Commercials Plc';
}

