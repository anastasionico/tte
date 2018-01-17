<?php
// $Id$

/**
 * @file
 * Example module to demonstrate using the menu system.
 * 
 * For more information about hook_menu(), see:
 * http://api.drupal.org/api/drupal/modules--system--system.api.php/function/hook_menu/7
 *
 * In this file, we are demonstrating how hook_menu() works, and how to add a simple
 * page.
 */

/**
 * Implements hook_menu().
 */
function sb_menu() {
  $items['contact'] = array(
    'title' => 'Contact Us',
    'description' => 'Contact us for a call back, test drive, email or brochure.',
    'page callback' => 'sb_contact',
    'access callback' => TRUE,
  );
  $items['index'] = array(
    'title' => 'Front Page',
    'description' => 'The front page which includes the slider, used and new van listings.',
    'page callback' => 'sb_index',
    'access callback' => TRUE,
  );
  $items['mercedes/used'] = array(
    'title' => 'Used Vehicles',
    'description' => 'Used vehicles, offers, vans, ex demonstrators and trucks.',
    'page callback' => 'sb_used',
    'access callback' => TRUE,
  );
  $items['mercedes-vans'] = array(
    'title' => 'Vans',
    'description' => 'Vans overview, citan, vito and sprinter.',
    'page callback' => 'sb_vans',
    'access callback' => TRUE,
  );
  $items['mercedes-trucks'] = array(
    'title' => 'Trucks',
    'description' => 'Trucks overview, actros, antos, axor atego and canter.',
    'page callback' => 'sb_trucks',
    'access callback' => TRUE,
  );
  $items['about-us'] = array(
    'title' => 'About Us',
    'description' => 'Overview, our team and news at S&B Commercials.',
    'page callback' => 'about_us',
    'access callback' => TRUE,
  );
  return $items;
}

/**
 * Menu callback; Index page.
 */
function sb_index() {
  $build['carousel'] = node_view(node_load(533));

  $text_top = variable_get('vehicles-new-homepage_text_top');
  if(! empty($text_top)) {
    $build['text_top'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="pad-top pad-bottom">' . variable_get('vehicles-new-homepage_text_top') . '</div>',
    );
  }

  $block_load = block_load('sb', 'vehicles-used');
  $block = _block_get_renderable_array(_block_render_blocks(array($block_load)));
//  _bootstrap_carousel_load_javascript(node_load(1));
  $build['vehicles-used'] = array(
    '#type' => 'markup',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block),
  );

  $block = block_load('sb', 'vehicles-new');
  $block_view = _block_get_renderable_array(_block_render_blocks(array($block)));
  $build['vehicles-new'] = array(
    '#type' => 'markup',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block_view),
  );

  $build['text_bottom'] = array(
    '#type' => 'markup',
    '#markup' => '<div class="pad-top pad-bottom">' . variable_get('vehicles-new-homepage_text_bottom') . '</div>',
  );

  return $build;
}

/**
 * Menu callback; Used.
 */
function sb_used() {
  $block = block_load('sb', 'vehicles-used');
  $block_view = _block_get_renderable_array(_block_render_blocks(array($block)));
  if(empty($block_view)) {
    return MENU_NOT_FOUND;
  }
  $build['vehicles-used'] = array(
    '#type' => 'markup',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block_view),
  );
  return $build;
}

/**
 * Menu callback; Vans.
 */
function sb_vans() {
  $block = block_load('sb', 'vans-index');
  $block_view = _block_get_renderable_array(_block_render_blocks(array($block)));
  if(empty($block_view)) {
    return MENU_NOT_FOUND;
  }
  $build['vans-index'] = array(
    '#type' => 'markup',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block_view),
  );
  
  return $build;
}

/**
 * Menu callback; Trucks.
 */
function sb_trucks() {
  $block = block_load('sb', 'trucks-index');
  $block_view = _block_get_renderable_array(_block_render_blocks(array($block)));
  if(empty($block_view)) {
    return MENU_NOT_FOUND;
  }
  $build['trucks-index'] = array(
    '#type' => 'markup',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block_view),
  );
  return $build;
}

/**
 * Menu callback; About Us.
 */
function about_us() {

  $block = block_load('block', 7);
  $block_view = _block_get_renderable_array(_block_render_blocks(array($block)));

  $build['overview'] = array(
    '#type' => 'markup',
    '#prefix' => '<div id="overview" class="pad-top pad-bottom border-bottom">',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block_view),
    '#suffix' => '</div>',
  );

  $block = block_load('block', 8);
  $block_view = _block_get_renderable_array(_block_render_blocks(array($block)));

  $build['the_team'] = array(
    '#type' => 'markup',
    '#prefix' => '<div id="the_team" class="pad-top pad-bottom border-bottom">',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block_view),
    '#suffix' => '</div>',
  );
  $block = block_load('views', 'blog-news');
  $block_view = _block_get_renderable_array(_block_render_blocks(array($block)));

  $build['about-us'] = array(
    '#type' => 'markup',
    '#prefix' => '<div id="news" class="pad-top pad-bottom">',
    // There is no reasonable way to render a block. https://drupal.org/node/957038
    '#markup' => drupal_render($block_view),
    '#suffix' => '</div>',
  );
  return $build;
}

/**
 * Implements hook_page_alter()
 */
function sb_page_alter(&$page) {
  if (current_path() == 'index') {
    drupal_set_title('');
    unset($page['sidebar_first']);
  }
  if(current_path() == 'trucks') {
    drupal_set_title('');
  }
  if(current_path() == 'vans') {
    drupal_set_title('');
  }

}

/**
 * Implements hook_block_info().
 */
function sb_block_info() {
  $blocks['vehicles-new'] = array(
    'info' => t('New Vehicles'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['vehicles-used'] = array(
    'info' => t('Used Vehicles'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['parts-order_form'] = array(
    'info' => t('Parts Order Form'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['service-order_form'] = array(
    'info' => t('Service Order Form'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['vans-index'] = array(
    'info' => t('Vans Index'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['trucks-index'] = array(
    'info' => t('Trucks Index'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['sidebar-more'] = array(
    'info' => t('Sidebar More'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['topbar-second'] = array(
    'info' => t('Topbar Second'),
    'cache' => DRUPAL_NO_CACHE,
  );
  $blocks['footer-menu'] = array(
    'info' => t('Footer Menu'),
    'cache' => DRUPAL_NO_CACHE,
  );
  return $blocks;
}

/**
 * Implements hook_block_configure().
 */
function sb_block_configure($delta='') {
  $form = array();
 
  switch($delta) {
    case 'vehicles-used' : 
      $form['homepage_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Homepage Text'),
        '#default_value' => variable_get('homepage_text', ''),
      );
      // Text fields
      $form['offer_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Offer Text'),
        '#default_value' => variable_get('offer_text', ''),
      );
      // File selection form element
      $form['offer_image'] = array(
        '#name' => 'used_offer_image',
        '#type' => 'managed_file',
        '#title' => t('Offer image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('used_offer_image_fid', ''),
        '#cardinality' => FIELD_CARDINALITY_UNLIMITED,
        '#upload_location' => 'public://used_offer_image/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['van_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Van Text'),
        '#default_value' => variable_get('van_text', ''),
      );
      $form['exdemo_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Ex Demonstrator Text'),
        '#default_value' => variable_get('exdemo_text', ''),
      );
      $form['truck_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Truck Text'),
        '#default_value' => variable_get('truck_text', ''),
      );
      // model texts
      $form['used-text-m-vito'] = array(
          '#type' => 'text_format',
          '#title' => t('Vito Model Text'),
          '#default_value' => variable_get('used-text-m-vito', ''),
      );
      $form['used-text-m-sprinter'] = array(
          '#type' => 'text_format',
          '#title' => t('Sprinter Model Text'),
          '#default_value' => variable_get('used-text-m-sprinter', ''),
      );
      $form['used-text-m-vario'] = array(
          '#type' => 'text_format',
          '#title' => t('Vario Model Text'),
          '#default_value' => variable_get('used-text-m-vario', ''),
      );
      $form['used-text-m-actros'] = array(
          '#type' => 'text_format',
          '#title' => t('Actros Model Text'),
          '#default_value' => variable_get('used-text-m-actros', ''),
      );
      $form['used-text-m-axor'] = array(
          '#type' => 'text_format',
          '#title' => t('Axor Model Text'),
          '#default_value' => variable_get('used-text-m-axor', ''),
      );
      $form['used-text-m-atego'] = array(
          '#type' => 'text_format',
          '#title' => t('Atego Model Text'),
          '#default_value' => variable_get('used-text-m-atego', ''),
      );
      $form['used-text-m-econic'] = array(
          '#type' => 'text_format',
          '#title' => t('Econic Model Text'),
          '#default_value' => variable_get('used-text-m-econic', ''),
      );
      $form['used-text-m-canter'] = array(
          '#type' => 'text_format',
          '#title' => t('Canter Model Text'),
          '#default_value' => variable_get('used-text-m-canter', ''),
      );
      $form['used-text-m-citan'] = array(
          '#type' => 'text_format',
          '#title' => t('Citan Model Text'),
          '#default_value' => variable_get('used-text-m-citan', ''),
      );
      // category texts
      $form['used-text-c-panel_van'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Panel Van'),
          '#default_value' => variable_get('used-text-c-panel_van', ''),
      );
      $form['used-text-c-dualiner'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Dualiner'),
          '#default_value' => variable_get('used-text-c-dualiner', ''),
      );
      $form['used-text-c-crew_cab'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Crew Cab'),
          '#default_value' => variable_get('used-text-c-crew_cab', ''),
      );
      $form['used-text-c-mini_bus'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Mini Bus'),
          '#default_value' => variable_get('used-text-c-mini_bus', ''),
      );
      $form['used-text-c-people_carrier'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - People Carrier'),
          '#default_value' => variable_get('used-text-c-people_carrier', ''),
      );
      $form['used-text-c-traveliner'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Traveliner'),
          '#default_value' => variable_get('used-text-c-traveliner', ''),
      );
      $form['used-text-c-luton_box'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Luton Box'),
          '#default_value' => variable_get('used-text-c-luton_box', ''),
      );
      $form['used-text-c-tipper'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Tipper'),
          '#default_value' => variable_get('used-text-c-tipper', ''),
      );
      $form['used-text-c-dropside'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Dropside'),
          '#default_value' => variable_get('used-text-c-dropside', ''),
      );
      $form['used-text-c-refrigerated'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Refrigerated'),
          '#default_value' => variable_get('used-text-c-refrigerated', ''),
      );
      $form['used-text-c-specialist'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Specialist'),
          '#default_value' => variable_get('used-text-c-specialist', ''),
      );
      $form['used-text-c-tractor_unit'] = array(
          '#type' => 'text_format',
          '#title' => t('Truck - Tractor Unit'),
          '#default_value' => variable_get('used-text-c-tractor_unit', ''),
      );
      $form['used-text-c-truck_box'] = array(
          '#type' => 'text_format',
          '#title' => t('Truck - Box'),
          '#default_value' => variable_get('used-text-c-truck_box', ''),
      );
      $form['used-text-c-curtainside'] = array(
          '#type' => 'text_format',
          '#title' => t('Truck - Curtainside'),
          '#default_value' => variable_get('used-text-c-curtainside', ''),
      );
      $form['used-text-c-truck_dropside'] = array(
          '#type' => 'text_format',
          '#title' => t('Truck - Dropside'),
          '#default_value' => variable_get('used-text-c-truck_dropside', ''),
      );
      $form['used-text-c-truck_tipper'] = array(
          '#type' => 'text_format',
          '#title' => t('Truck - Tipper'),
          '#default_value' => variable_get('used-text-c-truck_tipper', ''),
      );
      $form['used-text-c-truck_refrigerated'] = array(
          '#type' => 'text_format',
          '#title' => t('Truck - Refrigerated'),
          '#default_value' => variable_get('used-text-c-truck_refrigerated', ''),
      );
      $form['used-text-c-truck_specialist'] = array(
          '#type' => 'text_format',
          '#title' => t('Truck - Specialist'),
          '#default_value' => variable_get('used-text-c-truck_specialist', ''),
      );
      $form['used-text-c-taxi'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Taxi'),
          '#default_value' => variable_get('used-text-c-taxi', ''),
      );
      $form['used-text-c-viano'] = array(
          '#type' => 'text_format',
          '#title' => t('Van - Viano'),
          '#default_value' => variable_get('used-text-c-viano', ''),
      );
      break;

    case 'parts-order_form' :
      // Text field form element
      $form['text_body'] = array(
        '#type' => 'text_format',
        '#title' => t('Enter your text here in WYSIWYG format'),
        '#default_value' => variable_get('text_variable', ''),
      );
 
      // File selection form element
      $form['file'] = array(
        '#name' => 'block_image',
        '#type' => 'managed_file',
        '#title' => t('Choose an Image File'),
        '#description' => t('Select an Image for the custom block.  Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('block_image_fid', ''),
        '#upload_location' => 'public://block_image/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      break;

    case 'service-order_form' :
      // File selection form element
      $form['service_order_form_img'] = array(
        '#name' => 'service_order_form_img',
        '#type' => 'managed_file',
        '#title' => t('Choose an Image File'),
        '#description' => t('Select an Image for the custom block.  Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('service_order_form_img_fid', ''),
        '#upload_location' => 'public://service_order_form_img/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      break;

    case 'vans-index' : 
      $form['overview_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Overview Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('overview_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['overview_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Overview Text'),
        '#default_value' => variable_get('overview_text', ''),
      );
      $form['overview_image'] = array(
        '#name' => 'van-overview_image',
        '#type' => 'managed_file',
        '#title' => t('Overview image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('van-overview_image_fid', ''),
        '#upload_location' => 'public://vans-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['citan_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Citan Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('citan_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['citan_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Citan Text'),
        '#default_value' => variable_get('citan_text', ''),
      );
      $form['citan_image'] = array(
        '#name' => 'van-citan_image',
        '#type' => 'managed_file',
        '#title' => t('Citan image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('van-citan_image_fid', ''),
        '#upload_location' => 'public://vans-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['vito_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Vito Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('vito_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['vito_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Vito Text'),
        '#default_value' => variable_get('vito_text', ''),
      );
      $form['vito_image'] = array(
        '#name' => 'van-vito_image',
        '#type' => 'managed_file',
        '#title' => t('Vito image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('van-vito_image_fid', ''),
        '#upload_location' => 'public://vans-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['sprinter_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Sprinter Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('sprinter_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['sprinter_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Sprinter Text'),
        '#default_value' => variable_get('sprinter_text', ''),
      );
      $form['sprinter_image'] = array(
        '#name' => 'van-sprinter_image',
        '#type' => 'managed_file',
        '#title' => t('Sprinter image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('van-sprinter_image_fid', ''),
        '#upload_location' => 'public://vans-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      break;

    case 'trucks-index' : 
      $form['truck_overview_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Overview Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('truck_overview_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['truck_overview_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Overview Text'),
        '#default_value' => variable_get('truck_overview_text', ''),
      );
      $form['truck_overview_image'] = array(
        '#name' => 'truck-overview_image',
        '#type' => 'managed_file',
        '#title' => t('Overview image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('truck-overview_image_fid', ''),
        '#upload_location' => 'public://truck-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['actros_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Actros Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('actros_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['actros_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Actros Text'),
        '#default_value' => variable_get('actros_text', ''),
      );
      $form['actros_image'] = array(
        '#name' => 'truck-actros_image',
        '#type' => 'managed_file',
        '#title' => t('Actros image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('truck-actros_image_fid', ''),
        '#upload_location' => 'public://truck-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['antos_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Antos Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('antos_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['antos_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Antos Text'),
        '#default_value' => variable_get('antos_text', ''),
      );
      $form['antos_image'] = array(
        '#name' => 'truck-antos_image',
        '#type' => 'managed_file',
        '#title' => t('Antos image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('truck-antos_image_fid', ''),
        '#upload_location' => 'public://truck-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['arocs_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Arocs Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('arocs_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['arocs_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Arocs Text'),
        '#default_value' => variable_get('arocs_text', ''),
      );
      $form['arocs_image'] = array(
        '#name' => 'truck-arocs_image',
        '#type' => 'managed_file',
        '#title' => t('Arocs image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('truck-arocs_image_fid', ''),
        '#upload_location' => 'public://truck-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['atego_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Atego Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('atego_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['atego_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Atego Text'),
        '#default_value' => variable_get('atego_text', ''),
      );
      $form['atego_image'] = array(
        '#name' => 'truck-atego_image',
        '#type' => 'managed_file',
        '#title' => t('Atego image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('truck-atego_image_fid', ''),
        '#upload_location' => 'public://truck-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['econic_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Econic Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('econic_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['econic_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Econic Text'),
        '#default_value' => variable_get('econic_text', ''),
      );
      $form['econic_image'] = array(
        '#name' => 'truck-econic_image',
        '#type' => 'managed_file',
        '#title' => t('Econic image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('truck-econic_image_fid', ''),
        '#upload_location' => 'public://truck-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      $form['canter_position'] = array(
        '#type' => 'textfield', 
        '#title' => t('Canter Image Position'), 
        '#description' => t('Please use full, left, right or none.'),
        '#default_value' => variable_get('canter_position', ''), 
        '#size' => 60, 
        '#maxlength' => 128, 
      );
      $form['canter_text'] = array(
        '#type' => 'text_format',
        '#title' => t('Canter Text'),
        '#default_value' => variable_get('canter_text', ''),
      );
      $form['canter_image'] = array(
        '#name' => 'truck-canter_image',
        '#type' => 'managed_file',
        '#title' => t('Canter image'),
        '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
        '#default_value' => variable_get('truck-canter_image_fid', ''),
        '#upload_location' => 'public://truck-index/',
        '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
        ),
      );
      break;

    case 'vehicles-new' : 
      $form['vehicles-new-homepage_text_top'] = array(
        '#type' => 'text_format',
        '#title' => t('Homepage Text Top'),
        '#default_value' => variable_get('vehicles-new-homepage_text_top', ''),
      );
      $form['vehicles-new-homepage_text_bottom'] = array(
        '#type' => 'text_format',
        '#title' => t('Homepage Text Bottom'),
        '#default_value' => variable_get('vehicles-new-homepage_text_bottom', ''),
      );
      foreach(range(1, 9) as $number) {
        // Text fields
        $form['vehicles-new-vehicle_text_' . $number] = array(
          '#type' => 'text_format',
          '#title' => t('Vehicle Text ' . $number),
          '#default_value' => variable_get('vehicles-new-vehicle_text_' . $number, ''),
        );
        $form['vehicles-new-vehicle_head_' . $number] = array(
          '#type' => 'text_format',
          '#title' => t('Vehicle Header ' . $number),
          '#default_value' => variable_get('vehicles-new-vehicle_head_' . $number, ''),
        );
        $form['vehicles-new-vehicle_link_' . $number] = array(
          '#type' => 'text_format',
          '#title' => t('Vehicle Link ' . $number),
          '#default_value' => variable_get('vehicles-new-vehicle_link_' . $number, ''),
        );
        // File selection form element
        $form['vehicles-new-vehicle_image_' . $number] = array(
          '#name' => 'vehicles-new-vehicle_image_' . $number,
          '#type' => 'managed_file',
          '#title' => t('Vehicle Image ' . $number),
          '#description' => t('Select an Image to be displayed next to offers text. Only *.gif, *.png, *.jpg, and *.jpeg images allowed.'),
          '#default_value' => variable_get('vehicles-new-vehicle_image_' . $number . '_fid', ''),
          '#cardinality' => FIELD_CARDINALITY_UNLIMITED,
          '#upload_location' => 'public://vehicles-new/',
          '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
          ),
        );
      }
      break;

  }
  return $form;
}

/**
 * Implements hook_block_save().
 * http://fourkitchens.com/blog/2012/07/18/building-custom-blocks-drupal-7
 */
function sb_block_save($delta = '', $edit = array()) {
  switch($delta) {
    case 'vehicles-new' :
      // Saving the WYSIWYG text      
      variable_set('vehicles-new-homepage_text_top', $edit['vehicles-new-homepage_text_top']['value']);
      variable_set('vehicles-new-homepage_text_bottom', $edit['vehicles-new-homepage_text_bottom']['value']);

      foreach(range(1, 9) as $number) {
        variable_set('vehicles-new-vehicle_text_' . $number, $edit['vehicles-new-vehicle_text_' . $number]['value']);
        variable_set('vehicles-new-vehicle_head_' . $number, $edit['vehicles-new-vehicle_head_' . $number]['value']);
        variable_set('vehicles-new-vehicle_link_' . $number, $edit['vehicles-new-vehicle_link_' . $number]['value']);
        // Saving the file, setting it to a permanent state, setting a FID variable
        $file = file_load($edit['vehicles-new-vehicle_image_' . $number]);
        if($file) {
          $file->status = FILE_STATUS_PERMANENT;
          file_save($file);
          $block = block_load('sb', $delta);
          file_usage_add($file, 'sb', 'block', $block->bid);
          variable_set('vehicles-new-vehicle_image_' . $number . '_fid', $file->fid);
        }
      }
      break;

    case 'vehicles-used' :
      // Saving the WYSIWYG text      
      variable_set('homepage_text', $edit['homepage_text']['value']);
      variable_set('offer_text', $edit['offer_text']['value']);
      variable_set('van_text', $edit['van_text']['value']);
      variable_set('exdemo_text', $edit['exdemo_text']['value']);
      variable_set('truck_text', $edit['truck_text']['value']);
      variable_set('used-text-m-vito', $edit['used-text-m-vito']['value']);
	  variable_set('used-text-m-sprinter', $edit['used-text-m-sprinter']['value']);
	  variable_set('used-text-m-vario', $edit['used-text-m-vario']['value']);
	  variable_set('used-text-m-actros', $edit['used-text-m-actros']['value']);
	  variable_set('used-text-m-axor', $edit['used-text-m-axor']['value']);
	  variable_set('used-text-m-atego', $edit['used-text-m-atego']['value']);
	  variable_set('used-text-m-econic', $edit['used-text-m-econic']['value']);
	  variable_set('used-text-m-canter', $edit['used-text-m-canter']['value']);
      variable_set('used-text-m-citan', $edit['used-text-m-citan']['value']);
      variable_set('used-text-c-panel_van', $edit['used-text-c-panel_van']['value']);
	  variable_set('used-text-c-dualiner', $edit['used-text-c-dualiner']['value']);
	  variable_set('used-text-c-crew_cab', $edit['used-text-c-crew_cab']['value']);
	  variable_set('used-text-c-mini_bus', $edit['used-text-c-mini_bus']['value']);
	  variable_set('used-text-c-people_carrier', $edit['used-text-c-people_carrier']['value']);
	  variable_set('used-text-c-traveliner', $edit['used-text-c-traveliner']['value']);
	  variable_set('used-text-c-luton_box', $edit['used-text-c-luton_box']['value']);
	  variable_set('used-text-c-tipper', $edit['used-text-c-tipper']['value']);
	  variable_set('used-text-c-dropside', $edit['used-text-c-dropside']['value']);
	  variable_set('used-text-c-refrigerated', $edit['used-text-c-refrigerated']['value']);
	  variable_set('used-text-c-specialist', $edit['used-text-c-specialist']['value']);
	  variable_set('used-text-c-tractor_unit', $edit['used-text-c-tractor_unit']['value']);
	  variable_set('used-text-c-truck_box', $edit['used-text-c-truck_box']['value']);
	  variable_set('used-text-c-curtainside', $edit['used-text-c-curtainside']['value']);
	  variable_set('used-text-c-truck_dropside', $edit['used-text-c-truck_dropside']['value']);
	  variable_set('used-text-c-truck_tipper', $edit['used-text-c-truck_tipper']['value']);
	  variable_set('used-text-c-truck_refrigerated', $edit['used-text-c-truck_refrigerated']['value']);
	  variable_set('used-text-c-truck_specialist', $edit['used-text-c-truck_specialist']['value']);
	  variable_set('used-text-c-taxi', $edit['used-text-c-taxi']['value']);
	  variable_set('used-text-c-viano', $edit['used-text-c-viano']['value']);
      /*
    vito
	sprinter
	vario
	actros
	axor
	atego
	econic
	canter
    citan

    panel_van
	dualiner
	crew_cab
	Bus	mini_bus
	Carrier	people_carrier
	traveliner
	luton_box
	tipper
	dropside
	refrigerated
	specialist
	tractor_unit
	truck_box
	curtainside
	truck_dropside
	truck_tipper
	truck_refrigerated
	truck_specialist
	taxi
	viano
       */
 
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['offer_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('used_offer_image_fid', $file->fid);
      break;

    case 'parts-order_form' :
      // Saving the WYSIWYG text
      variable_set('text_variable', $edit['text_body']['value']);
 
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['file']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('block_image_fid', $file->fid);
      break;

    case 'service-order_form' :
 
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['service_order_form_img']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('service_order_form_img_fid', $file->fid);
      break;

    case 'vans-index' :
      // Saving the WYSIWYG text
      //dpm($edit);
      variable_set('overview_position', $edit['overview_position']);
      variable_set('overview_text', $edit['overview_text']['value']);
      variable_set('citan_position', $edit['citan_position']);
      variable_set('citan_text', $edit['citan_text']['value']);
      variable_set('vito_position', $edit['vito_position']);
      variable_set('vito_text', $edit['vito_text']['value']);
      variable_set('sprinter_position', $edit['sprinter_position']);
      variable_set('sprinter_text', $edit['sprinter_text']['value']);
 
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['overview_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('van-overview_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['citan_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('van-citan_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['vito_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('van-vito_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['sprinter_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('van-sprinter_image_fid', $file->fid);
      break;

    case 'trucks-index' :
      // Saving the WYSIWYG text
      variable_set('truck_overview_position', $edit['truck_overview_position']);
      variable_set('truck_overview_text', $edit['truck_overview_text']['value']);
      variable_set('actros_position', $edit['actros_position']);
      variable_set('actros_text', $edit['actros_text']['value']);
      variable_set('antos_position', $edit['antos_position']);
      variable_set('antos_text', $edit['antos_text']['value']);
      variable_set('arocs_position', $edit['arocs_position']);
      variable_set('arocs_text', $edit['arocs_text']['value']);
      variable_set('atego_position', $edit['atego_position']);
      variable_set('atego_text', $edit['atego_text']['value']);
      variable_set('econic_position', $edit['econic_position']);
      variable_set('econic_text', $edit['econic_text']['value']);
      variable_set('canter_position', $edit['canter_position']);
      variable_set('canter_text', $edit['canter_text']['value']);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['truck_overview_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('truck-truck_overview_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['actros_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('truck-actros_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['antos_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('truck-antos_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['arocs_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('truck-arocs_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['atego_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('truck-atego_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['econic_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('truck-econic_image_fid', $file->fid);
      // Saving the file, setting it to a permanent state, setting a FID variable
      $file = file_load($edit['canter_image']);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);
      $block = block_load('sb', $delta);
      file_usage_add($file, 'sb', 'block', $block->bid);
      variable_set('truck-canter_image_fid', $file->fid);

      break;


  }
}

/**
 * Implements hook_block_view().
 */
function sb_block_view($delta = '') {
  $block = array();

  switch($delta) {
    case 'vehicles-new':
      $block = vehicles_new_view();
      break;
    case 'vehicles-used':
      $block = vehicles_used_form_view();
      break;
    case 'parts-order_form':
      $block['content'] = parts_order_form_view();
      break;
    case 'service-order_form':
      $block['content'] = service_order_form_view();
      break;
    case 'vans-index':
      $block['content'] = vans_index_view();
      break;
    case 'trucks-index':
      $block['content'] = trucks_index_view();
      break;
    case 'sidebar-more':
      $block['content'] = sidebar_more_view();
      break;
    case 'topbar-second':
      $block['content'] = topbar_second_view();
      break;
    case 'footer-menu':
      $block['content'] = footer_view();
      break;
  }
  return $block;
}

function vehicles_new_view() {
  $block = array();
  $block['content'] = '
    <h2>New Vehicles</h2>
    <div class="row">';
 
  foreach(range(1, 9) as $number) {

    $image_file = file_load(variable_get('vehicles-new-vehicle_image_' . $number . '_fid', ''));
    $image_path = '';
   
    if (isset($image_file->uri)) {
      $image_path = $image_file->uri;
    }
   
    $image = theme_image(array(
      'path' => ($image_path),
//      'alt' => t('Image description here.'),
//      'title' => t('This is our block image.'),
      'attributes' => array('class' => 'img-responsive'),
    ));
   
    // Capture WYSIWYG text from the variable
    $link = variable_get('vehicles-new-vehicle_link_' . $number, '');
    $head = variable_get('vehicles-new-vehicle_head_' . $number, '');
    $desc = variable_get('vehicles-new-vehicle_text_' . $number, '');

    $block['content'] .= '
      <div class="col-xs-12 col-sm-4 used-item">
        <a href="' . $link . '" class="vehicle-thumb">
          ' . $image . '
          <small>New Vehicles</small>
          <h3>' . $head . '</h3>
          <span class="desc">' . $desc . '</span>
        </a>
      </div>';
    if($number % 3 == 0)
      $block['content'] .= '</div><div class="row">';
  }

  // Block output in HTML with div wrapper
  $block['content'] .= '</div>';
 
  return $block;
}
/**
 * Custom function to assemble renderable array for block content.
 * Returns a renderable array with the block content.
 * @return
 *   returns a renderable array of block content.
 */
function vehicles_used_form_view() {
  $path = isset($_GET['q']) ? $_GET['q'] : 'index';
  $block = array();
 
  switch($path) {
    // vehicle listing page, vans.
    case 'mercedes/used/vans':
      drupal_set_title('Used Vans');
      $vehicles = sb_get_vehicles('used', 0, 'van');
      $categorys = sb_split_vehicle_categorys($vehicles);
      $i = 1;
      $block['content'] = '<div class="box-divide">
          <div class="row">
            <div class="col-xs-12">
              ' . variable_get('van_text', '') . '
            </div>
          </div><!--/.row-->
        </div>
          <div class="row">
            <div class="col-xs-12">
              <ul class="mix-filters">
                <li class="filter" data-filter="all">
                <span class="indicator"><i class="fa fa-check-square-o"></i></span> All</li>
                ';
        foreach($categorys as $category) {
          // not sure why this bug happens, i just wanna make bonus...
          if(! isset($category['category']))
            $category['category'] = $category['name'];

          $block['content'] .= '<li class="filter" data-filter="cat-' . $category['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $category['category'] . ' (' . $category['count'] . ')
            </li>';
        }
      $block['content'] .= '</ul>
              <div class="clearfix"></div>
            </div>
          </div><!--/.row-->
        <div id="vehicles-used-listing" class="row">';
      foreach($vehicles as $vehicle) {
        //$block['content'] .= '<img itemprop="image" class="lazy" src="http://www.sbcommercials.co.uk/inc/img/blank.png" data-src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['small'] . '" />';
        $block['content'] .= '<div class="mix';
        foreach($vehicle['categorys'] as $category) {
          $block['content'] .= ' cat-' . $category['addr'];
        }
        $block['content'] .= ' col-xs-12 col-md-6">
            <div class="vehicle">
              <div class="row">
                <div class="col-xs-12 col-sm-5">
                  <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                    <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                  </a>
                </div>
                <div class="col-xs-12 col-sm-7">
                  <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                  $block['content'] .= '">
                    <span itemprop="brand">' . $vehicle['brand'] . '</span>
                    <span itemprop="name">' . $vehicle['model'] . ' ';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                  $block['content'] .= '</span>
                  </a></h3>
                  <p><span>' . $vehicle['model_description'] . '</span>
                  <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + VAT';
          }
          else {
            $block['content'] .= 'POA';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>Year: ' . $vehicle['year'] . '</span> 
                    <span>Mileage: ' . number_format($vehicle['mileage']) . '</span></p>
                    <p class="description">
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\S+)?$/', '', substr($description_string, 0, 200)) . '...
                  </p>
                </div>
              </div>
            </div>
          </div>';
          if($i % 2 == 0) $block['content'] .= '<div class="clearfix visible-md-block"></div>';
          $i++;
      }
      $block['content'] .= '</div><!--/.row-->';
      break;
    // vehicle listing page, exdemo.
    case 'mercedes/used/exdemonstrators':
      drupal_set_title('Ex Demonstrators');
      $vehicles = sb_get_vehicles('used', 0, 0, 0, 0, 1);
      $categorys = sb_split_vehicle_categorys($vehicles);
      $i = 1;
      $block['content'] = '<div class="box-divide">
          <div class="row">
            <div class="col-xs-12">
              ' . variable_get('exdemo_text', '') . '
            </div>
          </div><!--/.row-->
        </div>
          <div class="row">
            <div class="col-xs-12">
              <ul class="mix-filters">
                <li class="filter" data-filter="all">
                <span class="indicator"><i class="fa fa-check-square-o"></i></span> All</li>
                ';
        foreach($categorys as $category) {
          // not sure why this bug happens, i just wanna make bonus...
          if(! isset($category['category']))
            $category['category'] = $category['name'];

          $block['content'] .= '<li class="filter" data-filter="cat-' . $category['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $category['category'] . ' (' . $category['count'] . ')
            </li>';
        }
      $block['content'] .= '</ul>
              <div class="clearfix"></div>
            </div>
          </div><!--/.row-->
        <div id="vehicles-used-listing" class="row">';
      foreach($vehicles as $vehicle) {
        //$block['content'] .= '<img itemprop="image" class="lazy" src="http://www.sbcommercials.co.uk/inc/img/blank.png" data-src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['small'] . '" />';
        $block['content'] .= '<div class="mix';
        foreach($vehicle['categorys'] as $category) {
          $block['content'] .= ' cat-' . $category['addr'];
        }
        $block['content'] .= ' col-xs-12 col-md-6">
            <div class="vehicle">
              <div class="row">
                <div class="col-xs-12 col-sm-5">
                  <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                    <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                  </a>
                </div>
                <div class="col-xs-12 col-sm-7">
                  <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                  $block['content'] .= '">
                    <span itemprop="brand">' . $vehicle['brand'] . '</span>
                    <span itemprop="name">' . $vehicle['model'] . ' ';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                  $block['content'] .= '</span>
                  </a></h3>
                  <p><span>' . $vehicle['model_description'] . '</span>
                  <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + VAT';
          }
          else {
            $block['content'] .= 'POA';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>Year: ' . $vehicle['year'] . '</span> 
                    <span>Mileage: ' . number_format($vehicle['mileage']) . '</span><br>
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\S+)?$/', '', substr($description_string, 0, 200)) . '...
                </div>
              </div>
            </div>
          </div>';
          if($i % 2 == 0) $block['content'] .= '<div class="clearfix visible-md-block"></div>';
          $i++;
      }
      $block['content'] .= '</div>';
      break;
    // vehicle listing page, truck.
    case 'mercedes/used/trucks':
      drupal_set_title('Used Trucks');
      $vehicles = sb_get_vehicles('used', 0, 'truck');
      $categorys = sb_split_vehicle_categorys($vehicles);
      $i = 1;
      $block['content'] = '<div class="box-divide">
          <div class="row">
            <div class="col-xs-12">
              ' . variable_get('truck_text', '') . '
            </div>
          </div><!--/.row-->
        </div>
          <div class="row">
            <div class="col-xs-12">
              <ul class="mix-filters">
                <li class="filter" data-filter="all">
                <span class="indicator"><i class="fa fa-check-square-o"></i></span> All</li>
                ';
        foreach($categorys as $category) {
          // not sure why this bug happens, i just wanna make bonus...
          if(! isset($category['category']))
            $category['category'] = $category['name'];

          $block['content'] .= '<li class="filter" data-filter="cat-' . $category['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $category['category'] . ' (' . $category['count'] . ')
            </li>';
        }
      $block['content'] .= '</ul>
              <div class="clearfix"></div>
            </div>
          </div><!--/.row-->
        <div id="vehicles-used-listing" class="row">';
      foreach($vehicles as $vehicle) {
        //$block['content'] .= '<img itemprop="image" class="lazy" src="http://www.sbcommercials.co.uk/inc/img/blank.png" data-src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['small'] . '" />';
        $block['content'] .= '<div class="mix';
        foreach($vehicle['categorys'] as $category) {
          $block['content'] .= ' cat-' . $category['addr'];
        }
        $block['content'] .= ' col-xs-12 col-md-6">
            <div class="vehicle">
              <div class="row">
                <div class="col-xs-12 col-sm-5">
                  <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                    <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                  </a>
                </div>
                <div class="col-xs-12 col-sm-7">
                  <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                  $block['content'] .= '">
                    <span itemprop="brand">' . $vehicle['brand'] . '</span>
                    <span itemprop="name">' . $vehicle['model'] . ' ';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                  $block['content'] .= '</span>
                  </a></h3>
                  <p><span>' . $vehicle['model_description'] . '</span>
                  <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + VAT';
          }
          else {
            $block['content'] .= 'POA';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>Year: ' . $vehicle['year'] . '</span> 
                    <span>Mileage: ' . number_format($vehicle['mileage']) . '</span><br>
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\S+)?$/', '', substr($description_string, 0, 200)) . '...
                </div>
              </div>
            </div>
          </div>';
          if($i % 2 == 0) $block['content'] .= '<div class="clearfix visible-md-block"></div>';
          $i++;
      }
      $block['content'] .= '</div>';
      break;
    // vehicle used index page.
    case 'mercedes/used':
      $vehicles_van = sb_get_vehicles('used', 0, 'van');
      $vehicles_exdemo = sb_get_vehicles('used', 0, 0, 0, 0, 1);
      $vehicles_truck = sb_get_vehicles('used', 0, 'truck');
      $image_file = file_load(variable_get('used_offer_image_fid', ''));
      $image_path = '';
     
      $categorys = sb_split_vehicle_categorys($vehicles_van);
      $models = sb_split_vehicle_models($vehicles_van);
      

      if (isset($image_file->uri)) {
        $image_path = $image_file->uri;
      }
     
      $image = theme_image(array(
        'path' => ($image_path),
        'alt' => t('Used vehicle offer.'),
        'attributes' => array('class' => 'img-responsive'),
      ));

      $block['content'] = '
        <div id="overview" class="box-divide">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              ' . variable_get('offer_text', '') . '
            </div>
            <div class="col-xs-12 col-md-6">
              ' . $image . '
            </div>
          </div>
        </div>
        <div id="vans" class="mixem box-divide">
          <div class="row">
            <div class="col-xs-12">
              <h2><a href="/mercedes/used/vans">Vans</a></h2>
              <ul class="mix-filters">
                <li class="filter" data-filter="all">
                <span class="indicator"><i class="fa fa-check-square-o"></i></span> All</li>
                ';
        foreach($categorys as $category) {
          // not sure why this bug happens
          if(! isset($category['category']))
            $category['category'] = $category['name'];

          $block['content'] .= '<li class="filter" data-filter="cat-' . $category['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $category['category'] . ' (' . $category['count'] . ')
            </li>';
        }
        foreach($models as $model) {
          $block['content'] .= '<li class="filter" data-filter="mod-' . $model['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $model['name'] . ' (' . $model['count'] . ')
            </li>';
          }
      $block['content'] .= '</ul>
              <div class="clearfix"></div>
              <div class="pad-right-bottom">' . variable_get('van_text', '') . '</div>

              <div id="carousel-vehicles-van" class="carousel slide" data-ride="carousel" data-interval="false">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <div class="item active">
                    <div class="row">';
        $i = 1;
        $slides = 1;
        $no_vehicles = count($vehicles_van);

        foreach($vehicles_van as $vehicle) {
          //$block['content'] .= '<img itemprop="image" class="lazy" src="http://www.sbcommercials.co.uk/inc/img/blank.png" data-src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['small'] . '" />';
          
          $title = ($vehicle['categorys'][0]['category'] != 'Viano') ? $vehicle['model'] : '';
          $title .= ' ' . $vehicle['categorys'][0]['category'];
          if($vehicle['price'] > 0) $title .= ' &#163;' . $vehicle['price'];

          $block['content'] .= '<div class="mix';
          foreach($vehicle['categorys'] as $category) {
            $block['content'] .= ' cat-' . $category['addr'];
          }

          $block['content'] .= ' mod-' . $vehicle['model_addr'];

          $block['content'] .= ' col-xs-12 col-md-6">
              <div class="vehicle">
                <div class="row">
                  <div class="col-xs-12 col-sm-5">
                    <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                      $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                      $block['content'] .= '">
                      <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                    </a>
                  </div>
                  <div class="col-xs-12 col-sm-7">
                    <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                      <span itemprop="brand">' . $vehicle['brand'] . '</span>
                      <span itemprop="name">' . $vehicle['model'] . ' ';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                    $block['content'] .= '</span>
                    </a></h3>
                    <p><span>' . $vehicle['model_description'] . '</span>
                    <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + VAT';
          }
          else {
            $block['content'] .= 'POA';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>Year: ' . $vehicle['year'] . '</span> 
                    <span>Mileage: ' . number_format($vehicle['mileage']) . '</span></p>
                    <p class="description">
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\S+)?$/', '', substr($description_string, 0, 200)) . '...
                  </p>
                </div>
              </div>
            </div>
          </div>';
  

          if((($i % 2) == 0) && (($i % 6) != 0)) {
            $block['content'] .= '<div class="clearfix"> </div>';
          }
          if((($i % 6) == 0) && $i != $no_vehicles) {
            $block['content'] .= '</div></div><div class="item"><div class="row">';
            $slides++;
          }
          $i++;
        }
        $block['content'] .= '
                    </div><!--/.row-->
                  </div><!--/.item-->
                </div><!--/.carousel-inner-->

                <!-- Controls -->
                <div class="carousel-control left" href="#carousel-vehicles-van" data-slide="prev"><span class="chevron-left"></span></div>
                <div class="carousel-control right" href="#carousel-vehicles-van" data-slide="next"><span class="chevron-right"></span></div>
                <ol class="carousel-indicators carousel-ind-bottom">';
          for ($i = 0; $i < $slides; $i++) {
            $block['content'] .= '<li data-target="#carousel-vehicles-van" data-slide-to="' . $i . '"';
            if($i == 0) $block['content'] .= ' class="active"';
            $block['content'] .= '></li>';
          }
          $block['content'] .= '</ol>';
        $block['content'] .= '
              </div>
              
            </div>
          </div><!--/.row-->
        </div><!--/.box-divide-->
        <div id="exdemonstrators" class="mixem box-divide">
          <div class="row">
            <div class="col-xs-12">
              <h2><a href="/mercedes/used/exdemonstrators">Ex Demonstrators</a></h2>
              <ul class="mix-filters">
                <li class="filter" data-filter="all">
                <span class="indicator"><i class="fa fa-check-square-o"></i></span> All</li>
                ';
        $categorys = sb_split_vehicle_categorys($vehicles_exdemo);
        $models = sb_split_vehicle_models($vehicles_exdemo);
        foreach($categorys as $category) {
          // not sure why this bug happens, i just wanna make bonus...
          if(! isset($category['category']))
            $category['category'] = $category['name'];

          $block['content'] .= '<li class="filter" data-filter="cat-' . $category['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $category['category'] . ' (' . $category['count'] . ')
            </li>';
        }
        foreach($models as $model) {
          $block['content'] .= '<li class="filter" data-filter="mod-' . $model['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $model['name'] . ' (' . $model['count'] . ')
            </li>';
        }
      $block['content'] .= '</ul>
              <div class="clearfix"></div>
              <div class="pad-right-bottom">' . variable_get('exdemo_text', '') . '</div>

              <div id="carousel-vehicles-exdemo" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <div class="item active">
                    <div class="row">';

        $i = 1;
        $no_vehicles = count($vehicles_exdemo);
        $slides = 1;

        foreach($vehicles_exdemo as $vehicle) {
          //$block['content'] .= '<img itemprop="image" class="lazy" src="http://www.sbcommercials.co.uk/inc/img/blank.png" data-src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['small'] . '" />';
          
          $title = ($vehicle['categorys'][0]['category'] != 'Viano') ? $vehicle['model'] : '';
          $title .= ' ' . $vehicle['categorys'][0]['category'];
          if($vehicle['price'] > 0) $title .= ' &#163;' . $vehicle['price'];

  /*
          $block['content'] .= '<div class="mix';
          foreach($vehicle['categorys'] as $category) {
            $block['content'] .= ' cat-' . $category['addr'];
          }
   */

          $block['content'] .= '<div class="mix';
          foreach($vehicle['categorys'] as $category) {
            $block['content'] .= ' cat-' . $category['addr'];
          }
          $block['content'] .= ' mod-' . $vehicle['model_addr'];
          $block['content'] .= ' col-xs-12 col-md-6">
              <div class="vehicle">
                <div class="row">
                  <div class="col-xs-12 col-sm-5">
                    <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                      $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                      $block['content'] .= '">
                      <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                    </a>
                  </div>
                  <div class="col-xs-12 col-sm-7">
                    <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                      <span itemprop="brand">' . $vehicle['brand'] . '</span>
                      <span itemprop="name">' . $vehicle['model'] . ' ';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                    $block['content'] .= '</span>
                    </a></h3>
                    <p><span>' . $vehicle['model_description'] . '</span>
                    <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + VAT';
          }
          else {
            $block['content'] .= 'POA';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>Year: ' . $vehicle['year'] . '</span> 
                    <span>Mileage: ' . number_format($vehicle['mileage']) . '</span></p>
                    <p class="description">
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\S+)?$/', '', substr($description_string, 0, 200)) . '...
                  </p>
                </div>
              </div>
            </div>
          </div>';
  

          if((($i % 2) == 0) && (($i % 6) != 0)) {
            $block['content'] .= '<div class="clearfix"> </div>';
          }
          if((($i % 6) == 0) && $i != $no_vehicles) {
            $block['content'] .= '</div></div><div class="item"><div class="row">';
            $slides++;
          }
          $i++;
        }


        $block['content'] .= '
                    </div><!--/.row-->
                  </div><!--/.item-->
                </div><!--/.carousel-inner-->
                ';
        if($no_vehicles > 6) {
          $block['content'] .= '
                <!-- Controls -->
                <div class="carousel-control left" href="#carousel-vehicles-exdemo" data-slide="prev"><span class="chevron-left"></span></div>
                <div class="carousel-control right" href="#carousel-vehicles-exdemo" data-slide="next"><span class="chevron-right"></span></div>
                <ol class="carousel-indicators carousel-ind-bottom">';
          for ($i = 0; $i < $slides; $i++) {
            $block['content'] .= '<li data-target="#carousel-vehicles-exdemo" data-slide-to="' . $i . '"';
            if($i == 0) $block['content'] .= ' class="active"';
            $block['content'] .= '></li>';
          }
          $block['content'] .= '</ol>';
        }
        $block['content'] .= '
              </div>
            </div>
          </div><!--/.row-->
        </div><!--/.box-divide-->
        <div id="trucks" class="mixem box-divide">
          <div class="row">
            <div class="col-xs-12">
              <h2><a href="/mercedes/used/trucks/">Trucks</a></h2>
              <ul class="mix-filters">
                <li class="filter" data-filter="all">
                <span class="indicator"><i class="fa fa-check-square-o"></i></span> All</li>
                ';
        $categorys = sb_split_vehicle_categorys($vehicles_truck);
        $models = sb_split_vehicle_models($vehicles_truck);

        foreach($categorys as $category) {
          // not sure why this bug happens, i just wanna make bonus...
          if(! isset($category['category']))
            $category['category'] = $category['name'];

          $block['content'] .= '<li class="filter" data-filter="cat-' . $category['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $category['category'] . ' (' . $category['count'] . ')
            </li>';
        }
        foreach($models as $model) {
          $block['content'] .= '<li class="filter" data-filter="mod-' . $model['addr'] . '">
              <span class="indicator"><i class="fa fa-check-square-o"></i></span> ' . $model['name'] . ' (' . $model['count'] . ')
            </li>';
        }
      $block['content'] .= '</ul>
              <div class="clearfix"></div>

              <div class="pad-right-bottom">' . variable_get('truck_text', '') . '</div>

              <div id="carousel-vehicles-truck" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <div class="item active">
                    <div class="row">';
        $i = 1;
        $no_vehicles = count($vehicles_truck);
        $slides = 1;

        foreach($vehicles_truck as $vehicle) {
          //$block['content'] .= '<img itemprop="image" class="lazy" src="http://www.sbcommercials.co.uk/inc/img/blank.png" data-src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['small'] . '" />';
          
          $title = ($vehicle['categorys'][0]['category'] != 'Viano') ? $vehicle['model'] : '';
          $title .= ' ' . $vehicle['categorys'][0]['category'];
          if($vehicle['price'] > 0) $title .= ' &#163;' . $vehicle['price'];

  /*
          $block['content'] .= '<div class="mix';
          foreach($vehicle['categorys'] as $category) {
            $block['content'] .= ' cat-' . $category['addr'];
          }
   */

          $block['content'] .= '<div class="mix';
          foreach($vehicle['categorys'] as $category) {
            $block['content'] .= ' cat-' . $category['addr'];
          }
          $block['content'] .= ' mod-' . $vehicle['model_addr'];
          $block['content'] .= ' col-xs-12 col-md-6">
              <div class="vehicle">
                <div class="row">
                  <div class="col-xs-12 col-sm-5">
                    <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                      $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                      $block['content'] .= '">
                      <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                    </a>
                  </div>
                  <div class="col-xs-12 col-sm-7">
                    <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                      <span itemprop="brand">' . $vehicle['brand'] . '</span>
                      <span itemprop="name">' . $vehicle['model'] . ' ';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                    $block['content'] .= '</span>
                    </a></h3>
                    <p><span>' . $vehicle['model_description'] . '</span>
                    <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + VAT';
          }
          else {
            $block['content'] .= 'POA';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>Year: ' . $vehicle['year'] . '</span> 
                    <span>Mileage: ' . number_format($vehicle['mileage']) . '</span></p>
                    <p class="description">
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\S+)?$/', '', substr($description_string, 0, 200)) . '...
                  </p>
                </div>
              </div>
            </div>
          </div>';
  

          if((($i % 2) == 0) && (($i % 6) != 0)) {
            $block['content'] .= '<div class="clearfix"> </div>';
          }
          if((($i % 6) == 0) && $i != $no_vehicles) {
            $block['content'] .= '</div></div><div class="item"><div class="row">';
            $slides++;
          }
          $i++;
        }
        $block['content'] .= '
                    </div><!--/.row-->
                  </div><!--/.item-->
                </div><!--/.carousel-inner-->';

        if($no_vehicles > 6) {
          $block['content'] .= '
                <!-- Controls -->
                <div class="carousel-control left" href="#carousel-vehicles-truck" data-slide="prev"><span class="chevron-left"></span></div>
                <div class="carousel-control right" href="#carousel-vehicles-truck" data-slide="next"><span class="chevron-right"></span></div>
                <ol class="carousel-indicators carousel-ind-bottom">';
          for ($i = 0; $i < $slides; $i++) {
            $block['content'] .= '<li data-target="#carousel-vehicles-truck" data-slide-to="' . $i . '"';
            if($i == 0) $block['content'] .= ' class="active"';
            $block['content'] .= '></li>';
          }
          $block['content'] .= '</ol>';
        }
        $block['content'] .= '
              </div>
            </div>
          </div><!--/.row-->
        </div><!--/.box-divide-->';
      break;

    // used on homepage
    case 'index':
      $block['subject'] = t('Used Vehicles');
      $block['content'] = '
          <h2><a href="/mercedes/used">Used Vehicles</a></h2>
        <div class="row">
          <div class="col-xs-12">
            <div class="wysiwyg-block">
              ' . variable_get('homepage_text', '') . '
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div id="carousel-vehicles-truck" class="carrot slide">
              <!-- Wrapper for slides -->
              <div class="carrot-inner">
                <div class="item active">
                  <div class="row">';
      $vehicles = sb_get_vehicles('used', 0, 0, 0, 0, 2);
      $i = 1;
      $slides = 1;
      $no_vehicles = count($vehicles);
      foreach($vehicles as $vehicle) {
        $title = ($vehicle['categorys'][0]['category'] != 'Viano') ? $vehicle['model'] : '';
        $title .= ' ' . $vehicle['categorys'][0]['category'];

          $block['content'] .= '<div class="col-xs-6 col-md-3 used-item">
                          <a href="/mercedes/used/v/' . $vehicle['id'] . '" class="vehicle-thumb">
                            <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' . $vehicle['pictures'][0]['medium'] . '" alt="Van" class="img-responsive">
                            <small>Used Vehicles</small>
                            <h3>' . $title . '</h3>
                            <span class="price">';
        if($vehicle['price'] != 0) $block['content'] .= '&#163;' . number_format($vehicle['price']);
        else $block['content'] .= 'POA';
        $block['content'] .= '</span>
                            <span class="desc hidden-xs">';
                            $description_string = '';
                            if($vehicle['category'] == 'van') {
                              $first = 1;
                              foreach($vehicle['features'] as $feature) {
                                if($first) {
                                  $description_string .= $feature['description'];
                                  $first = 0;
                                }
                                else {
                                  $description_string .= ', ' . $feature['description'];
                                }
                              }
                              $description_string .= '.';
                            }
                            else {
                              $description_string .= $vehicle['additional_details'];
                            }
                            $block['content'] .= preg_replace('/\s+?(\S+)?$/', '', substr($description_string, 0, 120)) . '...
                            </span>
                          </a>
                        </div>';
          if(($i % 2) == 0) {
            $block['content'] .= '<div class="clearfix visible-xs visible-sm"></div>';
          }
          if((($i % 4) == 0) && (($i % 8) != 0)) {
            $block['content'] .= '<div class="clearfix"></div>';
          }
          if((($i % 8) == 0) && ($i != $no_vehicles)) {
            $block['content'] .= '</div></div><div class="item"><div class="row">';
            $slides++;
          }
          $i++;
        }
        $block['content'] .= '
                  </div><!--/.row-->
                </div><!--/.item-->
              </div><!--/.carrot-inner-->';

        if($no_vehicles > 1) {
          $block['content'] .= '
                <!-- Controls -->
                <div class="carrot-control left hidden-xs hidden-sm" href="#carousel-vehicles-truck" data-slide="prev"><span class="chevron-left"></span></div>
                <div class="carrot-control right hidden-xs hidden-sm" href="#carousel-vehicles-truck" data-slide="next"><span class="chevron-right"></span></div>
                <ol class="carousel-indicators carousel-ind-bottom">';
          for ($i = 0; $i < $slides; $i++) {
            $block['content'] .= '<li data-target="#carousel-vehicles-truck" data-slide-to="' . $i . '"';
            if($i == 0) $block['content'] .= ' class="active"';
            $block['content'] .= '></li>';
          }
          $block['content'] .= '</ol>';
        }
        $block['content'] .= '
          </div><!--.carousel -->
        </div><!--.col-->
      </div><!-- row -->';



      break;
  }

  /*
   * category pages
   */
  if(substr($path, 0, 16) === 'mercedes/used/c/') {

    $vehicles = array();
    list( , , , $address) = explode("/", $path);
    $category = sb_get_categorys($address);

    if($category && sb_get_vehicles_by_category($category['id'])) {
      foreach(sb_get_vehicles_by_category($category['id']) as $c) {
        $vehicles[] = sb_get_vehicles('used', 0, 0, $c['vehicle_id'], 0, 2);
      }

      drupal_set_title($category['category']);

      $i = 1;
      $text = variable_get('used-text-c-mini_bus', '');

      if(!empty($text)) $block['content'] = '<p>' . $text . '</p>';
      else $block['content'] = '';

      $block['content'] .= '<div id="vehicles-used-listing" class="row">';
      foreach($vehicles as $vehicle) {
        $block['content'] .= '<div class="col-xs-12 col-md-6">
            <div class="vehicle">
              <div class="row">
                <div class="col-xs-12 col-sm-5">
                  <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                    <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                  </a>
                </div>
                <div class="col-xs-12 col-sm-7">
                  <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                  $block['content'] .= '">
                    <span itemprop="brand">' . $vehicle['brand'] . '</span>
                    <span itemprop="name">' . $vehicle['model'] . ' ';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                  $block['content'] .= '</span>
                  </a></h3>
                  <p><span>' . $vehicle['model_description'] . '</span>
                  <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + vat';
          }
          else {
            $block['content'] .= 'poa';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>year: ' . $vehicle['year'] . '</span> 
                    <span>mileage: ' . number_format($vehicle['mileage']) . '</span><br>
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\s+)?$/', '', substr($description_string, 0, 200)) . '...
                </div>
              </div>
            </div>
          </div>';

          if($i % 2 == 0) {
            $block['content'] .= '<div class="clearfix"></div>';
          }

          $i++;
      }



      $block['content'] .= '</div>';

    }
    else if(! empty($category)) {
      drupal_set_title($category['category']);
      $category_title = $category['category'];
      if($category_title != 'specialist' && $category_title != 'refrigerated') $category_title .= 's';
      if($category_title == 'specialist') $category_title = 'specialist vehicles';
      if($category_title == 'refrigerated') $category_title = 'refrigerated vehicles';
      $block['content'] = '<p>Unfortunately we currently do not have any ' . $category_title . ' available at this time.  Please use the links above to search our current stock or contact us to leave your details as we are often able to source specific vehicles.</p>';
    }
  }

  /*
   * model pages
   */
  if(substr($path, 0, 16) === 'mercedes/used/m/') {

    list( , , , $address) = explode("/", $path);
    $vehicles = sb_get_vehicles('used', 0, 0, 0, $address);

    if($address && count($vehicles) > 0) {

      drupal_set_title(ucfirst($address));
      $i = 1;
      $text = variable_get('used-text-m-' . $address, '');

      if(!empty($text)) $block['content'] = '<p>' . $text . '</p>';
      else $block['content'] = '';

      $block['content'] .= '<div id="vehicles-used-listing" class="row">';

      foreach($vehicles as $vehicle) {
        $block['content'] .= '<div class="col-xs-12 col-md-6">
            <div class="vehicle">
              <div class="row">
                <div class="col-xs-12 col-sm-5">
                  <a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                    $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                    $block['content'] .= '">
                    <img src="http://www.sbcommercials.co.uk/inc/img/vehicles/' .  $vehicle['pictures'][0]['medium'] . '" class="img-responsive" />
                  </a>
                </div>
                <div class="col-xs-12 col-sm-7">
                  <h3><a href="/mercedes/used/v/' . $vehicle['id'] . '-' . $vehicle['model_addr'] . '_';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['addr'])) ? $vehicle['categorys'][0]['addr'] : '';
                  $block['content'] .= '">
                    <span itemprop="brand">' . $vehicle['brand'] . '</span>
                    <span itemprop="name">' . $vehicle['model'] . ' ';
                  $block['content'] .= (!empty($vehicle['categorys'][0]['category'])) ? $vehicle['categorys'][0]['category'] : '';
                  $block['content'] .= '</span>
                  </a></h3>
                  <p><span>' . $vehicle['model_description'] . '</span>
                  <span itemprop="price">';
          if($vehicle['price'] != 0) {
            $block['content'] .= '&#163;' . number_format($vehicle['price']) . ' + vat';
          }
          else {
            $block['content'] .= 'poa';
          }
                    $block['content'] .= '</span><br>
                    <span class="reg">' . $vehicle['reg'] . '</span> 
                    <span>year: ' . $vehicle['year'] . '</span> 
                    <span>mileage: ' . number_format($vehicle['mileage']) . '</span><br>
                  ';
          $description_string = '';
          if($vehicle['category'] == 'van') {
            $first = 1;
            foreach($vehicle['features'] as $feature) {
              if($first) {
                $description_string .= $feature['description'];
                $first = 0;
              }
              else {
                $description_string .= ', ' . $feature['description'];
              }
            }
            $description_string .= '.';
          }
          else {
            $description_string .= $vehicle['additional_details'];
          }
          $block['content'] .= preg_replace('/\s+?(\s+)?$/', '', substr($description_string, 0, 200)) . '...
                </div>
              </div>
            </div>
          </div>';

          if($i % 2 == 0) {
            $block['content'] .= '<div class="clearfix"></div>';
          }

          $i++;
      }



      $block['content'] .= '</div>';

    }
    else {
      drupal_set_title($category['category']);
      $category_title = $category['category'];
      if($category_title != 'specialist' && $category_title != 'refrigerated') $category_title .= 's';
      if($category_title == 'specialist') $category_title = 'specialist vehicles';
      if($category_title == 'refrigerated') $category_title = 'refrigerated vehicles';
      $block['content'] = '<p>Unfortunately we currently do not have any ' . $category_title . ' available at this time.  Please use the links above to search our current stock or contact us to leave your details as we are often able to source specific vehicles.</p>';
    }
  }

/*
      $block['content'] .= '<ul>';
      foreach(sb_get_categorys() as $category) {
        $block['content'] .= '<li><a href="/used/c/' . $category['addr'] . '/">>' . $category['category'] . '</a></li>';
      }
      $block['content'] .= '</ul>';
*/

  return $block;
}

/**
 * Custom function to assemble renderable array for block content.
 * Returns a renderable array with the block content.
 * @return
 *   returns a renderable array of block content.
 */
function parts_order_form_view() {
  $block = array();
 
  // capture the image file path and form into html with attributes
  $image_file = file_load(variable_get('block_image_fid', ''));
  $image_path = '';
 
  if (isset($image_file->uri)) {
    $image_path = $image_file->uri;
  }
 
  $image = theme_image(array(
    'path' => ($image_path),
    'alt' => t('image description here.'),
    'title' => t('this is our block image.'),
    'attributes' => array('class' => 'img-responsive'),
  ));
 
  // Capture WYSIWYG text from the variable
  $text = variable_get('text_variable', '');
 
  // Block output in HTML with div wrapper
  $block = array(
    'image' => array(
//      '#prefix' => '<div class="background-">',
      '#type' => 'markup',
      '#markup' => $image,
    ),
    'form_reg_lookup' => array(
      '#prefix' => '<div id="order_online" class="row"><div class="col-xs-8 col-md-4">',
      '#type' => 'markup',
      '#markup' => '<form method="post" action="reglookup.php" class="form">
		      <div class="form-group">
            <label for="my-reg">Enter your reg below</label>
		        <input type="text" name="my-reg" id="my-reg" class="form-control" placeholder="YOUR REG">
		      </div>
          <input type="submit" value="GO" id="lookupsub" class="btn btn-primary">
        </form>',
    ),
    'form_models' => array(
      '#type' => 'markup',
      '#markup' => '<form id="vehicle-select-form" name="myform" class="form">
        <div class="form-group">
          <label for="optone">Or, select your vehicle</label>
          <select id="optone" name="optone" class="form-control">
            <option value=" " selected="selected">> SELECT</option>
            <option value="1">VITO (1996-2003)</option>
            <option value="2">VITO (2003-PRESENT)</option>
            <option value="3">SPRINTER (1995-2006)</option>
            <option value="4">SPRINTER (2006-PRESENT)</option>
          </select>
        </div>
        <div class="form-group">
          <select name="opttwo" class="form-control">
            <option value=" " selected="selected">> SELECT A VEHICLE ABOVE</option>
          </select>
        </div>
        <input type="button" id="go" name="go" value="GO" class="btn btn-primary">
      </form>',
      '#suffix' => '</div></div>',
    ),
    'form-links' => array(
      '#type' => 'markup',
      '#markup' => '<div class="row">
        <div class="col-xs-6 col-sm-3 col-md-3">
          <h3>Vito</h3>
          <span class="year">1996-2003</span>
          <ul>
            <li><a href="/parts/638-vito/108D/">108D</a><li><a href="/parts/638-vito/108CDI/">108CDI</a><li><a href="/parts/638-vito/110CDI/">110CDI</a><li><a href="/parts/638-vito/112CDI/">112CDI</a><li><a href="/parts/638-vito/113CDI/">113CDI</a><li><a href="/parts/638-vito/110D/">110D</a><li><a href="/parts/638-vito/112D/">112D</a><li><a href="/parts/638-vito/113D/">113D</a>
          </ul>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
          <h3>Vito</h3>
          <span class="year">2003-Present</span>
          <ul>
            <li><a href="/parts/639-vito/109CDI/">109CDI</a><li><a href="/parts/639-vito/111CDI/">111CDI</a><li><a href="/parts/639-vito/113CDI/">113CDI</a><li><a href="/parts/639-vito/115CDI/">115CDI</a><li><a href="/parts/639-vito/120CDI/">120CDI</a>
          </ul>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-xs-6 col-sm-3 col-md-3">
          <h3>Sprinter</h3>
          <span class="year">1995-2006</span>
          <ul>
            <li><a href="/parts/901-sprinter/308D/">308D</a><li><a href="/parts/901-sprinter/308CDI/">308CDI</a><li><a href="/parts/901-sprinter/310D/">310D</a><li><a href="/parts/901-sprinter/311CDI/">311CDI</a><li><a href="/parts/901-sprinter/312D/">312D</a><li><a href="/parts/901-sprinter/416CDI/">416CDI</a><li><a href="/parts/901-sprinter/313CDI/">313CDI</a><li><a href="/parts/901-sprinter/316CDI/">316CDI</a><li><a href="/parts/901-sprinter/318CDI/">318CDI</a><li><a href="/parts/901-sprinter/314D/">314D</a>
          </ul>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
          <h3>Sprinter</h3>
          <span class="year">2006-Present</span>
          <ul>
            <li><a href="/parts/906-sprinter/311CDI/">311CDI</a><li><a href="/parts/906-sprinter/313CDI/">313CDI</a><li><a href="/parts/906-sprinter/515CDI/">515CDI</a><li><a href="/parts/906-sprinter/518CDI/">518CDI</a><li><a href="/parts/906-sprinter/309CDI/">309CDI</a><li><a href="/parts/906-sprinter/315CDI/">315CDI</a><li><a href="/parts/906-sprinter/318CDI/">318CDI</a>
          </ul>
        </div>
      </div>',
    ),
    /*
    'message' => array(
      '#type' => 'markup',
      '#markup' => $text,
    ),
     */
  );
 
  return $block;
}

function service_order_form_view() {
  $block = array();

  // capture the image file path and form into html with attributes
  $image_file = file_load(variable_get('service_order_form_img_fid', ''));
  $image_path = '';
 
  if (isset($image_file->uri)) {
    $image_path = $image_file->uri;
  }
 
  $image = theme_image(array(
    'path' => ($image_path),
    'alt' => t('image description here.'),
    'title' => t('this is our block image.'),
    'attributes' => array('class' => 'img-responsive'),
  ));
 
  // Block output in HTML with div wrapper
  $block = array(
    'header' => array(
      '#type' => 'markup',
      '#markup' => '<h1>Book your service online</h1>',
    ),
    'image' => array(
      '#type' => 'markup',
      '#markup' => '<div id="service-booking">' . $image,
    ),
    'form' => array(
      '#type' => 'markup',
      '#markup' => '
        <div class="row">
          <form action="/yourservice/order/" method="post" role="form" accept-charset="utf-8">
            <div class="col-xs-12 col-sm-3">
              <div class="form-group">
                <label for="reg">1. Reg.</label>
                <input type="text" id="reg" name="reg" class="form-control">
              </div>
            </div>
            <div class="col-xs-12 col-sm-3">
              <div class="form-group">
                <label for="mileage">2. Mileage</label>
                <input type="text" id="mileage" name="mileage" class="form-control">
              </div>
            </div>
            <div class="col-xs-12 col-sm-3">
              <div class="form-group">
                <label for="type">3. Service Type</label>
                <div>
                  <div class="inline">
                    <input type="radio" name="type" value="a" id="type_a">
                    <label for="type_a">
                      Service A
                      <span class="spanner"></span>
                    </label>
                  </div>
                  <div class="inline">
                    <input type="radio" name="type" value="b" id="type_b">
                    <label for="type_b">
                      Service B
                      <span class="spanner"></span>
                      <span class="spanner"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-3">
              <div class="form-group">
                <label for="site">4. Select Workshop</label>
                <select name="site" id="site" class="form-control">
                  <option value="wg">Welham Green</option>
                  <option value="th">Thurrock</option>
                  <option value="st">Stansted</option>
                </select>
              </div>
            </div>
            <div class="clearfix"> </div>
            <div class="col-xs-12 text-right">
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Next Step</button>
              </div>
            </div>
          </form>
        </div><!--/.row-->
      </div><!--/#service-booking-->',
    ),
  );
 
  return $block;
}

function vans_index_view() {
  $block = array();
  $images = array();
  $image_names = array('overview', 'citan', 'vito', 'sprinter');

  foreach($image_names as $image_name) {
    // Capture the image file path and form into HTML with attributes
    $image_file = file_load(variable_get('van-' . $image_name . '_image_fid', ''));
    $image_path = '';
    if (isset($image_file->uri)) {
      $image_path = $image_file->uri;
    }
    $images[$image_name] = theme_image(array(
      'path' => ($image_path),
      'attributes' => array('class' => 'img-responsive'),
    ));
  }

  $content = '<div id="overview" class="box-padded">
    <div class="row">';
  $overview_position = variable_get('overview_position');
  if($overview_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('overview_text') . '
      </div>
      <div class="col-md-6">
        ' . $images['overview'] . '
      </div>';
  }
  else if($overview_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['overview'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('overview_text') . '
      </div>';
  }
  else if($overview_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['overview'] . '
      </div>';
  }
  else {
    $content .= '<div class="col-md-12">' . variable_get('overview_text') . '</div>';
  }
  $content .= '
    </div>
  </div>

  <div id="citan" class="box-padded box-white">
    <div class="row">';
  $citan_position = variable_get('citan_position');
  if($citan_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('citan_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['citan'] . '
      </div>';
  }
  else if($citan_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['citan'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('citan_text', '') . '
      </div>';
  }
  else if($citan_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['citan'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
      ' . variable_get('citan_text', '') . '
      </div>';
  }
  $content .= '
    </div>
  </div>

  <div id="vito" class="box-padded">
    <div class="row">';
  $vito_position = variable_get('vito_position');
  if($vito_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('vito_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['vito'] . '
      </div>';
  }
  else if($vito_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['vito'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('vito_text', '') . '
      </div>';
  }
  else if($vito_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['vito'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('vito_text', '') . '
      </div>';
  }
  $content .= '
    </div>
  </div>

  <div id="sprinter" class="box-padded box-white">
    <div class="row">';
  $sprinter_position = variable_get('sprinter_position');
  if($sprinter_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('sprinter_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['sprinter'] . '
      </div>';
  }
  else if($sprinter_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['sprinter'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('sprinter_text', '') . '
      </div>';
  }
  else if($sprinter_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['sprinter'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('sprinter_text') . '
      </div>';
  }
  $content .= '
    </div>
  </div>';

 
  $block = array(
    'content' => array(
      '#type' => 'markup',
      '#markup' => $content,
    ),
  );
 
  return $block;
}

function trucks_index_view() {
  $block = array();
  $images = array();
  $image_names = array('truck_overview', 'actros', 'antos', 'arocs', 'atego', 'econic', 'canter');

  foreach($image_names as $image_name) {
    // Capture the image file path and form into HTML with attributes
    $image_file = file_load(variable_get('truck-' . $image_name . '_image_fid', ''));
    $image_path = '';
    if (isset($image_file->uri)) {
      $image_path = $image_file->uri;
    }
    $images[$image_name] = theme_image(array(
      'path' => ($image_path),
      'attributes' => array('class' => 'img-responsive'),
    ));
  }
 
  $content = '<div id="overview" class="box-padded">
    <div class="row">';
  $truck_overview_position = variable_get('truck_overview_position');
  if($truck_overview_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('truck_overview_text') . '
      </div>
      <div class="col-md-6">
        ' . $images['truck_overview'] . '
      </div>';
  }
  else if($truck_overview_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['truck_overview'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('truck_overview_text') . '
      </div>';
  }
  else if($truck_overview_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['truck_overview'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('truck_overview_text') . '
      </div>';
  }
  $content .= '
    </div>
  </div>
  <div id="actros" class="box-padded box-white">
  <div class="row">';
  $actros_position = variable_get('actros_position');
  if($actros_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('actros_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['actros'] . '
      </div>';
  }
  else if($actros_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['actros'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('actros_text', '') . '
      </div>';
  }
  else if($actros_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['actros'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('actros_text', '') . '
      </div>';
  }
  $content .= '
    </div>
  </div>
  <div id="antos" class="box-padded">
  <div class="row">';
  $antos_position = variable_get('antos_position');
  if($antos_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('antos_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['antos'] . '
      </div>
      ';
  }
  else if($antos_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['antos'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('antos_text', '') . '
      </div>
      ';
  }
  else if($antos_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['antos'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('antos_text', '') . '
      </div>
      ';
  }
  $content .= '
    </div>
  </div>
  <div id="arocs" class="box-padded box-white">
  <div class="row">';
  $arocs_position = variable_get('arocs_position');
  if($arocs_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('arocs_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['arocs'] . '
      </div>
      ';
  }
  else if($arocs_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['arocs'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('arocs_text', '') . '
      </div>
      ';
  }
  else if($arocs_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['arocs'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('arocs_text', '') . '
      </div>
      ';

  }
  $content .= '
    </div>
  </div>
  <div id="atego" class="box-padded">
  <div class="row">';
  $atego_position = variable_get('atego_position');
  if($atego_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('atego_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['atego'] . '
      </div>';
  }
  else if($atego_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['atego'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('atego_text', '') . '
      </div>';
  }
  else if($atego_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['atego'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('atego_text', '') . '
      </div>';
  }
  $content .= '
    </div>
  </div>
  <div id="econic" class="box-padded box-white">
  <div class="row">';
  $econic_position = variable_get('econic_position');
  if($econic_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('econic_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['econic'] . '
      </div>';
  }
  else if($econic_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['econic'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('econic_text', '') . '
      </div>';
  }
  else if($econic_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['econic'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('econic_text', '') . '
      </div>';
  }
  $content .= '
    </div>

  </div>
  <div id="canter" class="box-padded">
  <div class="row">';
  $canter_position = variable_get('canter_position');
  if($canter_position == 'right') {
    $content .= '
      <div class="col-md-6">
        ' . variable_get('canter_text', '') . '
      </div>
      <div class="col-md-6">
        ' . $images['canter'] . '
        </div>';
  }
  else if($canter_position == 'left') {
    $content .= '
      <div class="col-md-6">
        ' . $images['canter'] . '
      </div>
      <div class="col-md-6">
        ' . variable_get('canter_text', '') . '
      </div>';
  }
  else if($canter_position == 'full') {
    $content .= '
      <div class="col-md-12">
        ' . $images['canter'] . '
      </div>';
  }
  else {
    $content .= '
      <div class="col-md-12">
        ' . variable_get('canter_text', '') . '
      </div>';
  }
  $content .= '
    </div>
  </div>';

  $block = array(
    'content' => array(
      '#type' => 'markup',
      '#markup' => $content,
    ),
  );
 
  return $block;
}

function sidebar_more_view() {
  //$path = isset($_GET['q']) ? $_GET['q'] : 'index';
  $path = drupal_get_path_alias();

  $markup = '<ul class="sidenav">
          <li class="visible-xs"><a href="/">Home</a></li>';

  if(substr($path, 0, 13) == 'mercedes-vans') {
    $tree = menu_tree_output(menu_tree_all_data('menu-van-menu'));
    $markup .= '
      <li class="active">
        <a href="/mercedes-vans">Vans</a>
        ' . drupal_render($tree) . '
      </li>';
  }
  else {
    $markup .= '<li class="visible-xs"><a href="/mercedes-vans">Vans</a></li>';
  }
  if(substr($path, 0, 15) == 'mercedes-trucks') {
    $tree = menu_tree_output(menu_tree_all_data('menu-truck-menu'));
    $markup .= '
      <li class="active">
        <a href="/mercedes-trucks">Trucks</a>
        ' . drupal_render($tree) . '
      </li>';
  }
  else {
    $markup .= '<li class="visible-xs"><a href="/mercedes-trucks">Trucks</a></li>';
  }
  if(substr($path, 0, 13) == 'mercedes/used') {
    $tree = menu_tree_output(menu_tree_all_data('menu-used-menu'));
    $markup .= '
      <li class="active">
        <a href="/mercedes/used">Used</a>
        ' . drupal_render($tree) . '
        <ul>
          <li><a href="/mercedes/used/c/panel_van">Panel Van</a></li>
          <li><a href="/mercedes/used/c/dualiner">Dualiner</a></li>
          <li><a href="/mercedes/used/c/crew_cab">Crew Cab</a></li>
          <li><a href="/mercedes/used/c/mini_bus">Mini Bus</a></li>
          <li><a href="/mercedes/used/c/people_carrier">People Carrier</a></li>
          <li><a href="/mercedes/used/c/traveliner">Traveliner</a></li>
          <li><a href="/mercedes/used/c/luton_box">Luton Box Vans</a></li>
          <li><a href="/mercedes/used/c/tipper">Tipper Vans</a></li>
          <li><a href="/mercedes/used/c/dropside">Dropside Vans</a></li>
          <li><a href="/mercedes/used/c/refrigerated">Refrigerated Vans</a></li>
          <li><a href="/mercedes/used/c/specialist">Specialist Vans</a></li>
          <li><a href="/mercedes/used/c/tractor_unit">Tractor Unit</a></li>
          <li><a href="/mercedes/used/c/truck_luton_box">Luton Box Trucks</a></li>
          <li><a href="/mercedes/used/c/curtainside">Curtainside</a></li>
          <li><a href="/mercedes/used/c/truck_dropside">Dropside Trucks</a></li>
          <li><a href="/mercedes/used/c/truck_tipper">Tipper Trucks</a></li>
          <li><a href="/mercedes/used/c/truck_refrigerated">Refrigerated Trucks</a></li>
          <li><a href="/mercedes/used/c/truck_specialist">Specialist Trucks</a></li>
        </ul>
      </li>';
  }
  else {
    $markup .= '<li class="visible-xs"><a href="/mercedes/used">Used</a></li>';
  }
  if(substr($path, 0, 5) == 'parts') {
    $tree = menu_tree_output(menu_tree_all_data('menu-parts'));
    $markup .= '
      <li class="active">
        <a href="/parts">Parts</a>
        ' . drupal_render($tree) . '
      </li>';
  }
  else {
    $markup .= '<li class="visible-xs"><a href="/parts">Parts</a></li>';
  }
  if(substr($path, 0, 7) == 'service') {
    $tree = menu_tree_output(menu_tree_all_data('menu-service-menu'));
    $markup .= '
      <li class="active">
        <a href="/service">Service</a>
        ' . drupal_render($tree) . '
      </li>';
  }
  else {
    $markup .= '<li class="visible-xs"><a href="/service">Service</a></li>';
  }
  if(substr($path, 0, 8) == 'about-us') {
    $tree = menu_tree_output(menu_tree_all_data('menu-about-us-menu'));
    $markup .= '
      <li class="active">
        <a href="/about-us">About Us</a>
        ' . drupal_render($tree) . '
      </li>';
  }
  else {
    $markup .= '<li class="visible-xs"><a href="/about-us">About Us</a></li>';
  }
  if(substr($path, 0, 7) == 'contact') {
    $tree = menu_tree_output(menu_tree_all_data(' menu-contact-menu'));
    $markup .= '
      <li class="active">
        <a href="/contact">Contact</a>
        ' . drupal_render($tree) . '
      </li>';
  }
  else {
    $markup .= '<li class="visible-xs"><a href="/contact">Contact</a></li>';
  }
  $markup .= '</ul>';

  return $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => $markup,
      ),
    );
}

function topbar_second_view() {
  //$path = isset($_GET['q']) ? $_GET['q'] : 'index';
  $path = drupal_get_path_alias();
  list( , $subpath) = explode("/", $path);

  if(substr($path, 0, 13) == 'mercedes-vans' && $subpath == NULL) {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="javascript:void(0)">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li class="active">
            <a href="#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="#citan">Citan<span class="arrow"></span></a></li>
          <li><a href="#vito">Vito<span class="arrow"></span></a></li>
          <li><a href="#sprinter">Sprinter<span class="arrow"></span></a></li>
          <li><a href="#offers">Offers<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }
  if(substr($path, 0, 13) == 'mercedes-vans' && ! empty($subpath)) {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="javascript:void(0)">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li>
            <a href="/mercedes-vans#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="/mercedes-vans#citan">Citan<span class="arrow"></span></a></li>
          <li><a href="/mercedes-vans#vito">Vito<span class="arrow"></span></a></li>
          <li><a href="/mercedes-vans#sprinter">Sprinter<span class="arrow"></span></a></li>
          <li><a href="/mercedes-vans#offers">Offers<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }
  if(substr($path, 0, 15) == 'mercedes-trucks' && $subpath == NULL) {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="#">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li class="active">
            <a href="#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="#actros">Actros<span class="arrow"></span></a></li>
          <li><a href="#antos">Antos<span class="arrow"></span></a></li>
          <li><a href="#arocs">Arocs<span class="arrow"></span></a></li>
          <li><a href="#atego">Atego<span class="arrow"></span></a></li>
          <li><a href="#econic">Econic<span class="arrow"></span></a></li>
          <li><a href="#canter">Canter<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }
  if(substr($path, 0, 15) == 'mercedes-trucks' && ! empty($subpath)) {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="#">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li>
            <a href="/mercedes-trucks#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="/mercedes-trucks#actros">Actros<span class="arrow"></span></a></li>
          <li><a href="/mercedes-trucks#antos">Antos<span class="arrow"></span></a></li>
          <li><a href="/mercedes-trucks#arocs">Arocs<span class="arrow"></span></a></li>
          <li><a href="/mercedes-trucks#atego">Atego<span class="arrow"></span></a></li>
          <li><a href="/mercedes-trucks#econic">Econic<span class="arrow"></span></a></li>
          <li><a href="/mercedes-trucks#canter">Canter<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }
  if(substr($path, 0, 13) == 'mercedes/used') {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="#">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li class="active">
            <a href="/mercedes/used#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="/mercedes/used#vans">Vans<span class="arrow"></span></a></li>
          <li><a href="/mercedes/used#exdemonstrators">Ex Demonstrators<span class="arrow"></span></a></li>
          <li><a href="/mercedes/used#trucks">Trucks<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }
  if(substr($path, 0, 5) == 'parts' || substr($path, 0, 4) == 'part') {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="#">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li class="active">
            <a href="/parts#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="/parts#order_online">Order Online<span class="arrow"></span></a></li>
          <li><a href="/parts#offers">Offers<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }
  if(substr($path, 0, 7) == 'service') {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="#">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li class="active">
            <a href="/service#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="/service#order_online">Order Online<span class="arrow"></span></a></li>
          <li><a href="/service#offers">Offers<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }
  if(substr($path, 0, 8) == 'about-us') {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
      <div class="subnav">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="#">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li class="active">
            <a href="/about-us#overview">
              Overview
              <span class="arrow"></span>
            </a>
          </li>
          <li><a href="/about-us#the_team">The Team<span class="arrow"></span></a></li>
          <li><a href="/about-us#news">News<span class="arrow"></span></a></li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }

  if(empty($block)) {
    $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => '
        <div class="subnav visible-xs">
        <ul class="nav">
          <li class="slim">
            <a class="snap-left" href="#">
              <span class="icon-label">More</span>
            </a>
          </li>
          <li class="slim-only">01707 261111</li>
        </ul>
      </div>
        ',
      ),
    );
  }

  return $block;
}

function footer_view() {
  // vans
  $markup = '<div class="row">
    <div class="col-sm-6 col-md-3"><h3>Vans</h3>';
  //$tree = menu_tree_output(menu_tree_all_data('menu-van-menu', NULL, 1));
  $tree = menu_tree_output(menu_tree_all_data('menu-van-menu', NULL, 1));
  $markup .= drupal_render($tree) . '</div>';

  $markup .= '<div class="col-sm-6 col-md-3"><h3>Trucks</h3>';
  $tree = menu_tree_output(menu_tree_all_data('menu-truck-menu', NULL, 1));
  $markup .= drupal_render($tree) . '</div>';

  $markup .= '<div class="col-sm-6 col-md-3"><h3>Used</h3>';
  $tree = menu_tree_output(menu_tree_all_data('menu-used-menu', NULL, 1));
  $markup .= drupal_render($tree) . '</div>';

  $markup .= '<div class="col-sm-6 col-md-3"><h3>Parts</h3>';
  $tree = menu_tree_output(menu_tree_all_data('menu-parts', NULL, 1));
  $markup .= drupal_render($tree) . '</div></div><div class="row">';

  $markup .= '<div class="col-sm-6 col-md-3"><h3>Service</h3>';
  $tree = menu_tree_output(menu_tree_all_data('menu-service-menu', NULL, 1));
  $markup .= drupal_render($tree) . '</div>';

  $markup .= '<div class="col-sm-6 col-md-3"><h3>About Us</h3>';
  $tree = menu_tree_output(menu_tree_all_data('menu-about-us-menu', NULL, 1));
  $markup .= drupal_render($tree) . '</div>';

  $markup .= '<div class="col-sm-6 col-md-3"><h3>Contact</h3>';
  $tree = menu_tree_output(menu_tree_all_data('menu-contact-menu', NULL, 1));
  $markup .= drupal_render($tree) . '</div>';

  $markup .= '</div>';

  return $block = array(
      'content' => array(
        '#type' => 'markup',
        '#markup' => $markup,
      ),
    );
}
function sb_get_vehicles($area, $limit = 0, $category = 0, $id = 0, $model = 0, $exdemonstrators = 0) {
  db_set_active('previous_cms');

  $id = preg_replace('/[^0-9]/', '', $id);
  $sql = 'SELECT vehicles_index.*,
    vehicles_models.name as model,
    vehicles_models.addr as model_addr
    FROM vehicles_index
    JOIN vehicles_models ON vehicles_index.model_id = vehicles_models.id
    WHERE vehicles_index.sold = 0';
 
  if(! $id) {
    $sql .= ' && area = \'' . $area . '\'';
  }
  $values = array();

  // additional where clauses
  if($category) {
    $sql .= ' && vehicles_index.category = :category';
    $values[':category'] = $category;
  }
  else if($id) {
    $sql .= ' && vehicles_index.id = :id';
    $values[':id'] = $id;
  }
  else if($model) {
    $sql .= ' && vehicles_models.addr = :model';
    $values[':model'] = $model;
  }
  if($exdemonstrators == 2) {
  }
  else if($exdemonstrators == 1) {
    $sql .= ' && vehicles_index.exdemonstrator = 1';
  }
  else {
    $sql .= ' && vehicles_index.exdemonstrator = 0';
  }

  // limit
  if($limit != 0) {
    $sql .= ' LIMIT ' . $limit;
  }

  $vehicles = db_query($sql, $values)->fetchAll(PDO::FETCH_ASSOC);
  if(count($vehicles) > 0) {
    foreach($vehicles as &$vehicle) {
      $vehicle['categorys'] = db_query('SELECT vehicles_categorys.id, vehicles_categorys.category, vehicles_categorys.addr FROM vehicles_listed_categorys
        JOIN vehicles_categorys ON vehicles_listed_categorys.category_id = vehicles_categorys.id WHERE vehicle_id = ' . $vehicle['id'])->fetchAll(PDO::FETCH_ASSOC);
      $vehicle['features'] = db_query('SELECT vehicles_features.id, vehicles_features.description FROM vehicles_listed_features
        JOIN vehicles_features ON vehicles_listed_features.feature_id = vehicles_features.id WHERE vehicle_id = ' . $vehicle['id'] . '
        ORDER BY vehicles_features.id ASC')->fetchAll(PDO::FETCH_ASSOC);
      $vehicle['pictures'] = db_query('SELECT thumb, small, medium, large FROM vehicles_pictures WHERE vehicle_id = ' . $vehicle['id'] . ' ORDER BY `primary` DESC')->fetchAll(PDO::FETCH_ASSOC);
//      $vehicle['finance'] = $this->finance_model->calculator($vehicles[$number]['price']);
    }
    db_set_active();
    return (count($vehicles) == 1 && $id >= 1) ? $vehicles[0] : $vehicles;
  }
  else {
    db_set_active();
    return NULL;
  }
}

function sb_get_categorys($addr = 0) {
  db_set_active('previous_cms');
  if($addr)
  {
    $category = db_query('SELECT * FROM vehicles_categorys WHERE addr = :addr LIMIT 1', array(':addr' => $addr))->fetch(PDO::FETCH_ASSOC);
    if(count($category) > 0) {
      db_set_active();
      return $category;
    }
    else {
      db_set_active();
      return NULL;
    }
  }
  else {
    return db_query('SELECT DISTINCT vehicles_categorys.id, vehicles_categorys.category, vehicles_categorys.addr FROM vehicles_listed_categorys
      JOIN vehicles_categorys ON vehicles_listed_categorys.category_id = vehicles_categorys.id
      JOIN vehicles_index ON vehicles_listed_categorys.vehicle_id = vehicles_index.id
      WHERE vehicles_index.sold = 0
      ORDER BY vehicles_categorys.id')->fetchAll(PDO::FETCH_ASSOC);
  }
}

function sb_get_vehicles_by_category($category)
{
  db_set_active('previous_cms');
  $category = preg_replace('/[^0-9]/', '', $category);
  $vehicles = db_query('SELECT vehicles_listed_categorys.vehicle_id FROM vehicles_listed_categorys
    JOIN vehicles_index ON vehicles_listed_categorys.vehicle_id = vehicles_index.id
    WHERE vehicles_listed_categorys.category_id = :category && vehicles_index.sold = 0', array(':category' => $category))->fetchAll(PDO::FETCH_ASSOC);
  db_set_active();
  if(count($vehicles) > 0) {
    return $vehicles;
  }
  else {
    return NULL;
  }
}

/**
 * A function for sorting and counting vehicle categorys.
 * Expects $vehicles to be an array as returned by the sb_get_vehicles() function.
 */
function sb_split_vehicle_categorys($vehicles) {
  $categorys_done = array();
  $sorted_categorys = array();
  $count = array();

  foreach($vehicles as $vehicle) {
    foreach($vehicle['categorys'] as $category) {
      if(in_array($category['addr'], $categorys_done)) {
        $count[$category['addr']]++;
      }
      else {
        $count[$category['addr']] = 1;
        $categorys_done[] = $category['addr'];
        $sorted_categorys[] = array(
          'name' => $category['category'],
          'addr' => $category['addr'],
        );
      }
    }
  }

  // add counts to sorted categorys
  foreach($sorted_categorys as &$category) {
    $category['count'] = $count[$category['addr']];
  }

  return $sorted_categorys;
}

/**
 * A function for sorting and counting vehicle models.
 * Expects $vehicles to be an array as returned by the sb_get_vehicles() function.
 */
function sb_split_vehicle_models($vehicles) {
  $models_done = array();
  $sorted_models = array();
  $count = array();

  foreach($vehicles as $vehicle) {
      if(in_array($vehicle['model_addr'], $models_done)) {
        $count[$vehicle['model_addr']]++;
      }
      else {
        $count[$vehicle['model_addr']] = 1;
        $models_done[] = $vehicle['model_addr'];
        $sorted_models[] = array(
          'name' => $vehicle['model'],
          'addr' => $vehicle['model_addr'],
        );
      }
  }

  // add counts to sorted categorys
  foreach($sorted_models as &$model) {
    $model['count'] = $count[$model['addr']];
  }

  return $sorted_models;
}


/**
 * Implements hook_views_api().
 *
 * @return array
 */
function sb_views_api() {
  return array(
    'api' => 3,
    'path' => drupal_get_path('module', 'sb'),
  );
}

/**
 * This hook allows to alter the commands which are used on a views ajax
 * request.
 *
 * @param $commands
 *   An array of ajax commands
 * @param $view view
 *   The view which is requested.
 */
function sb_views_ajax_data_alter(&$commands, $view) {
  // Replace Views' method for scrolling to the top of the element with your
  // custom scrolling method.
  foreach ($commands as &$command) {
    if ($command['command'] == 'viewsScrollTop') {
      $command['command'] = 'customViewsScrollTop';
    }
  }
}








/**
 * @file
 * Contact page callback and forms.
 */

/**
 * Menu callback; Contact us page.
 */
function sb_contact($arg1 = NULL) {

  $butchered = '
 <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 600px }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALdzRkRef9t_S5AErdbHLc7vnSYCVuCNM&sensor=true">
    </script>
    <script type="text/javascript">
/*
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(-34.397, 150.644),
          zoom: 8
        };
        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
      }
      google.maps.event.addDomListener(window, \'load\', initialize);
 */


	    // Google maps script
	      function initialize() {
			var style = [
			    {
			      featureType: "all",
			      elementType: "",
			      stylers: [
			        { saturation: -100 }, // <-- THIS,
			        { lightness: 20 }
			        // {visibility: "simplified"}
			      ]
			    }
			];
			var loc_center = new google.maps.LatLng(51.69777,0)
			var loc_wg = new google.maps.LatLng(51.74021,-0.21597)
			var loc_th = new google.maps.LatLng(51.483208,0.272421)
			var loc_st = new google.maps.LatLng(51.869732,0.212868)

	        var mapOptions = {
	          center: loc_center,
	          zoom: 10,
			    // panControl: false,
			    // zoomControl: false,
			    // scaleControl: false,
			    // mapTypeControl: false,
			    scrollwheel: false,
          draggable: false,
			    disableDefaultUI:true,
			    mapTypeControlOptions: {
			         mapTypeIds: [google.maps.MapTypeId.ROADMAP, \'gray\']
			    }
	        };
	        var map = new google.maps.Map(document.getElementById("map-canvas"),
	            mapOptions);

			var mapType = new google.maps.StyledMapType(style, { name:"Grayscale" });    
			map.mapTypes.set(\'gray\', mapType);
			map.setMapTypeId(\'gray\');

			var wg = new google.maps.Marker({
				position: 	loc_wg,
				map: 		map,
				icon: 		\'/sites/all/themes/sbtheme/img/map-icon.png\'
			});
			var th = new google.maps.Marker({
				position: 	loc_th,
				map: 		map,
				icon: 		\'/sites/all/themes/sbtheme/img/map-icon.png\'
			});
			var st = new google.maps.Marker({
				position: 	loc_st,
				map: 		map,
				icon: 		\'/sites/all/themes/sbtheme/img/map-icon.png\'
			});


			$(window).resize(function(){
				map.setCenter(loc_center);
			});
	      }
	      google.maps.event.addDomListener(window, \'load\', initialize);
	    

    </script>
   

        </section>
      </div>
    </section>
  </div>
</div>

<div class="hidden-xs">
<div id="map-canvas"></div>
</div>

<div class="main-container container">

  <div class="row">
    <section class="col-sm-12">
      <div class="region region-content">
        <section class="block block-system clearfix">

          <div class="box-padded">
            <div class="row">
              <div class="col-md-4">
                <div class="address">
                  <h2><a href="/locations/hertfordshire/welham-green">Welham Green</a></h2>
                  <p>
                  Travellers Lane, Welham Green, Hatfield,<br>
                  Hertfordshire, AL9 7HN<br><br>
                  Tel: (01707) 261111<br>
                  Fax: (01707) 274546<br>
                  </p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="address">
                  <h2><a href="/locations/essex/thurrock">Thurrock</a></h2>
                  <p>
                  Central Avenue, West Thurrock,<br>
                  Essex, RM20 3WD<br><br>
                  Tel: (01708) 892500<br>
                  Fax: (01708) 892555
                  </p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="address">
                  <h2><a href="/locations/greater-london/stansted">Stansted</a></h2>
                  <p>
                  Unit 2a Stansted Distribution Centre, Start Hill,<br>
                  Bishops Stortford, Hertfordshire, CM22 7DG<br><br>
                  Tel: (01279) 712200<br>
                  Fax: (01279) 712260
                  </p>
                </div>
              </div>
            </div>
          </div>
          ';
  

  $request_types = sb_contact_get('request_types');
  $stage_2_class = (array_key_exists($arg1, $request_types)) ? ' contact-stage-active' : '';
  $stage_1_class = (empty($stage_2_class)) ? ' contact-stage-active' : '';
  
  $build = array(
    'top' => array(
      '#type' => 'markup',
      '#markup' => $butchered,
    ),
    'stage_1_open' => array(
        '#type' => 'markup',
        '#markup' => '

        <div class="row">
          <div class="col-xs-12 col-md-6">
        
        <div class="contact-stage contact-stage-1' . $stage_1_class . '">
           <div class="contact-stage-header">
             <div class="contact-stage-indicator">1</div>
             <div class="contact-stage-header-text">Contact Request</div>
           </div>',
    ),
    'sb_contact_form' => drupal_get_form('sb_contact_form'),
    'stage_1_close' => array(
        '#type' => 'markup',
        '#markup' => '</div>',
    ),
    'stage_2_open' => array(
        '#type' => 'markup',
        '#markup' => '<div class="contact-stage contact-stage-2' . $stage_2_class . '">
           <div class="contact-stage-header">
             <div class="contact-stage-indicator">2</div>
             <div class="contact-stage-header-text">Your Details</div>
           </div>',
    ),
    'form_call_back' => drupal_get_form('sb_contact_call_back_form'),
    'form_test_drive' => drupal_get_form('sb_contact_test_drive_form'),
    'form_email' => drupal_get_form('sb_contact_email_form'),
    'form_brochure' => drupal_get_form('sb_contact_brochure_form'),
    'stage_2_close' => array(
        '#type' => 'markup',
        '#markup' => '<div class="contact-stage-indicator-end"></div></div>
        
        
        </div>
        <div class="col-xs-12 col-md-6">',
    ),
  );

  $build['spam_text'] = node_view(node_load(539));

  $build['end'] = array(
    '#type' => 'markup',
    '#markup' => '</div></div>',
  );

  foreach($request_types as $key => $request_name)
  {
    if($key != $arg1) {
      // hide the forms thats are not set to be active
      $build['form_' . $key]['#attributes']['class'][] = 'display-none';
    }
    else {
      // set the selected radio as there is a form active
      $build['sb_contact_form']['request_type'][$key]['#value'] = $key;
    }
  }

  return $build;
}

function sb_contact_get($array_name) {
  switch($array_name) {
    case 'request_types':
      return array(
        'call_back' => 'Call Back',
        'test_drive' => 'Test Drive',
        'email' => 'Email',
        'brochure' => 'Brochure',       
      );
    break;
  }
}

/**
 * Contact us form, stage 1. Just displays some radio buttons to find out
 * what contact request the user wants. These being:
 *  - Call Back
 *  - Test Drive
 *  - Email
 *  - Brochure
 */
function sb_contact_form($form, &$form_submit) {
  $form['#attributes'] = array(
    'class' => 'form-inline',
  );
  $form['request_type'] = array(
    '#title' => t('Request Type'),
    '#type' => 'radios',
    '#options' => sb_contact_get('request_types'),
    '#title_display' => 'attribute',
  );
  
  return $form;
}

/**
 * Contact form mailer. Sends all submitted forms to marketing for processing.
 */
function sb_contact_form_mail($key, &$message, $params) {
  $message['headers'] = array(
    'MIME-Version' => '1.0',
    'Content-Type' => 'text/plain; charset=UTF-8;',
    'Content-Transfer-Encoding' => '8Bit',
    'X-Mailer' => 'Drupal',
  );
  $message['subject'] = $params['subject'];
  $message['body'] = $params['body'];
}

/**
 * Contact us form, stage 2: call back.
 */
function sb_contact_call_back_form($form, &$form_submit) {
  $form['#action'] = url('contact/call_back');
      
  $path = request_path();
  $path = (! empty($path) ) ? $path : current_path();
  $form['request_path'] = array('#type' => 'hidden', '#value' => $path);
  $form['request_page_section'] = array('#type' => 'hidden', '#value' => '');
  
  $form['name'] = array(
    '#title' => t('Name'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['number'] = array(
    '#title' => t('Number'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['email'] = array(
    '#title' => t('Email'),
    '#type' => 'textfield',
  );
  $form['honeypot'] = array(
    '#title' => t('Honeypot'),
    '#type' => 'textarea',
  );
  $form['message'] = array(
    '#title' => t('Message'),
    '#type' => 'textarea',
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
  );
  
  return $form;
}

/**
 * Contact us form submit, stage 2: call back.
 */
function sb_contact_call_back_form_submit($form, &$form_state) {
  $to = 'enquiry@sbcommercials.co.uk';
  $from = 'noreply@example.com';
  $body = 'URL : ' . $form_state['input']['request_path'] . '<br>';
  $body .= 'Page Section : ' . $form_state['input']['request_page_section'] . '<br>';
  $body .= 'Name : ' . $form_state['input']['name'] . '<br>';
  $body .= 'Number : ' . $form_state['input']['number'] . '<br>';
  $body .= 'Email : ' . $form_state['input']['email'] . '<br>';
  $body .= 'Message : ' . $form_state['input']['message'] . '<br>';
  $params = array(
    'subject' => 'Contact us: call back form submit',
    'body' => array($body),
  );
  if($form_state['input']['honeypot'] == '') { 
      drupal_mail('sb_contact_form', 'key', $to, language_default(), $params, $from, TRUE);
  }
  drupal_set_message('Thanks, we will be in contact with more information soon.');
}

/**
 * Contact us form, stage 2: test drive.
 */
function sb_contact_test_drive_form($form, &$form_submit) {
  $form['#action'] = url('contact/test_drive');

  $path = request_path();
  $path = (! empty($path) ) ? $path : current_path();
  $form['request_path'] = array('#type' => 'hidden', '#value' => $path);
  $form['request_page_section'] = array('#type' => 'hidden', '#value' => '');

  $vehicle_models = array(
    'citan' => 'Citan',
    'vito' => 'Vito',
    'sprinter' => 'Sprinter',
    'canter' => 'Canter',
    'atego' => 'Atego',
    'antos' => 'Antos',
    'actros' => 'Actros',
    'arocs' => 'Arocs',
    'econic' => 'Econic',
  );
  
  $form['name'] = array(
    '#title' => t('Name'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['number'] = array(
    '#title' => t('Number'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['email'] = array(
    '#title' => t('Email'),
    '#type' => 'textfield',
  );
  $form['vehicle'] = array(
    '#title' => t('Vehicle'),
    '#type' => 'select',
    '#options' => $vehicle_models,
    '#required' => TRUE,
  );
  $form['honeypot'] = array(
    '#title' => t('Honeypot'),
    '#type' => 'textarea',
  );
  $form['message'] = array(
    '#title' => t('Message'),
    '#type' => 'textarea',
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
  );
  
  return $form;
}

/**
 * Contact us form submit, stage 2: test drive.
 */
function sb_contact_test_drive_form_submit($form, &$form_state) {
  $to = 'enquiry@sbcommercials.co.uk';
  $from = 'noreply@example.com';
  $body = 'URL : ' . $form_state['input']['request_path'] . '<br>';
  $body .= 'Page Section : ' . $form_state['input']['request_page_section'] . '<br>';
  $body .= 'Name : ' . $form_state['input']['name'] . '<br>';
  $body .= 'Number : ' . $form_state['input']['number'] . '<br>';
  $body .= 'Email : ' . $form_state['input']['email'] . '<br>';
  $body .= 'Vehicle : ' . $form_state['input']['vehicle'] . '<br>';
  $body .= 'Message : ' . $form_state['input']['message'] . '<br>';
  $params = array(
    'subject' => 'Contact us: test drive form submit',
    'body' => array($body),
  );
  if($form_state['input']['honeypot'] == '') { 
      drupal_mail('sb_contact_form', 'key', $to, language_default(), $params, $from, TRUE);
  }
  drupal_set_message('Thanks, we will be in contact with more information soon.');
}

/**
 * Contact us form, stage 2: email.
 */
function sb_contact_email_form($form, &$form_submit) {
  $form['#action'] = url('contact/email');

  $path = request_path();
  $path = (! empty($path) ) ? $path : current_path();
  $form['request_path'] = array('#type' => 'hidden', '#value' => $path);
  $form['request_page_section'] = array('#type' => 'hidden', '#value' => $path);

  
  $form['name'] = array(
    '#title' => t('Name'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['email'] = array(
    '#title' => t('Email'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['honeypot'] = array(
    '#title' => t('Honeypot'),
    '#type' => 'textarea',
  );
  $form['message'] = array(
    '#title' => t('Message'),
    '#type' => 'textarea',
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
  );
  
  return $form;
}

/**
 * Contact us form submit, stage 2: email.
 */
function sb_contact_email_form_submit($form, &$form_state) {
  $to = 'enquiry@sbcommercials.co.uk';
  $from = 'noreply@example.com';
  $body = 'URL : ' . $form_state['input']['request_path'] . '<br>';
  $body .= 'Page Section : ' . $form_state['input']['request_page_section'] . '<br>';
  $body .= 'Name : ' . $form_state['input']['name'] . '<br>';
  $body .= 'Email : ' . $form_state['input']['email'] . '<br>';
  $body .= 'Message : ' . $form_state['input']['message'] . '<br>';
  $params = array(
    'subject' => 'Contact us: email form submit',
    'body' => array($body),
  );
  if($form_state['input']['honeypot'] == '') { 
      drupal_mail('sb_contact_form', 'key', $to, language_default(), $params, $from, TRUE);
  }
  drupal_set_message('Thanks, we will be in contact with more information soon.');
}

/**
 * Contact us form, stage 2: brochure.
 */
function sb_contact_brochure_form($form, &$form_submit) {
  $form['#action'] = url('contact/brochure');

  $path = request_path();
  $path = (! empty($path) ) ? $path : current_path();
  $form['request_path'] = array('#type' => 'hidden', '#value' => $path);
  $form['request_page_section'] = array('#type' => 'hidden', '#value' => $path);

  
  $form['name'] = array(
    '#title' => t('Name'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['email'] = array(
    '#title' => t('Email'),
    '#type' => 'textfield',
    '#required' => TRUE,
  );
  $form['address'] = array(
    '#title' => t('Address'),
    '#type' => 'textarea',
    '#required' => TRUE,
  );
  $form['honeypot'] = array(
    '#title' => t('Honeypot'),
    '#type' => 'textarea',
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
  );
  
  return $form;
}

/**
 * Contact us form submit, stage 2: brochure.
 */
function sb_contact_brochure_form_submit($form, &$form_state) {
  $to = 'enquiry@sbcommercials.co.uk';
  $from = 'noreply@example.com';
  $body = 'URL : ' . $form_state['input']['request_path'] . '<br>';
  $body .= 'Page Section : ' . $form_state['input']['request_page_request'] . '<br>';
  $body .= 'Name : ' . $form_state['input']['name'] . '<br>';
  $body .= 'Email : ' . $form_state['input']['email'] . '<br>';
  $body .= 'Address : ' . $form_state['input']['address'] . '<br>';
  $params = array(
    'subject' => 'Contact us: brochure form submit',
    'body' => array($body),
  );
  if($form_state['input']['honeypot'] == '') { 
      drupal_mail('sb_contact_form', 'key', $to, language_default(), $params, $from, TRUE);
  }
  drupal_set_message('Thanks, we will be in contact with more information soon.');
}



