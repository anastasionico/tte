<?php
// $Id$

/**
 * @file
 * An associative array describing data structures for the views module.
 * https://api.drupal.org/api/views/views.api.php/function/hook_views_data/7
 */

/**
 * Implements hook_views_data().
 *
 * @return array
 */
function sb_views_data() {
  $data['vehicles_pictures'] = array(
    'table' => array(
      'group' => t('Vehicles Pictures'),
      'base' => array(
        'field' => 'vehicle_id', // This is the identifier field for the view.
        'title' => t('Vehicles Pictures'),
        'help' => t('Main vehicle pictures table.'),
        'weight' => 1,
        'database' => 'previous_cms',
      ),
      'join' => array(
        'vehicles_index' => array(
          'left_field' => 'vehicle_id',
          'field' => 'id',
        ),
      ),
    ),
    'vehicle_id' => array(
      'title' => t('Vehicle ID'),
      'help' => t('Vehicle Primary key.'),
    ),
    'thumb' => array(
      'title' => t('Thumbnail'),
      'help' => t('Thumbnail picture.'),
      'field' => array(
         'handler' => 'views_handler_field',
      ),
    ),
    'small' => array(
      'title' => t('Small'),
      'help' => t('Small picture.'),
      'field' => array(
         'handler' => 'views_handler_field',
      ),
    ),
    'medium' => array(
      'title' => t('Medium'),
      'help' => t('Medium picture.'),
      'field' => array(
         'handler' => 'views_handler_field',
      ),
    ),
    'large' => array(
      'title' => t('Large'),
      'help' => t('Large picture.'),
      'field' => array(
         'handler' => 'views_handler_field',
      ),
    ),
    'reg' => array(
      'title' => t('Primary'),
      'help' => t('Primary Indicator.'),
      'field' => array(
         'handler' => 'views_handler_boolean',
      ),
    ),
  );
  $data['vehicles_index'] = array(
    'table' => array(
      'group' => t('Vehicles'),
      'base' => array(
        'field' => 'id', // This is the identifier field for the view.
        'title' => t('Vehicles Index'),
        'help' => t('Main vehicle table containing rows for new and used vehicle listings.'),
        'weight' => 1,
        'database' => 'previous_cms',
      ),
      'join' => array(
        'vehicles_pictures' => array(
          'left_field' => 'id',
          'field' => 'vehicle_id',
        ),
      ),
    ),
    'id' => array(
      'title' => t('ID'),
      'help' => t('Primary key.'),
    ),
    'reg' => array(
      'title' => t('Reg'),
      'help' => t('A registration plate.'),
      'field' => array(
         'handler' => 'views_handler_field',
       ),
    ),
    'area' => array(
      'title' => t('Area'),
      'help' => t('Area of website, could be "used" or "new".'),
    ),
    'category' => array(
      'title' => t('Category'),
      'help' => t('The category, could be "van" or "truck".'),
    ),
    'model_id' => array(
      'title' => t('Model ID'),
      'help' => t('Models primary key.'),
    ),
    'model_description' => array(
      'title' => t('Model description'),
      'help' => t('A description of the model, for example: 313CDi MWB Panel Van.'),
    ),
    'brand' => array(
      'title' => t('Brand'),
      'help' => t('The vehicle manufacturer, for example: Mercedes-Benz.'),
    ),
    'price' => array(
      'title' => t('Price'),
      'help' => t('Price excluding VAT.'),
    ),
    'year' => array(
      'title' => t('Year'),
      'help' => t('Year'),
    ),
    'mileage' => array(
      'title' => t('Mileage'),
      'help' => t('Mileage, odometer current reading.'),
    ),
    'additional_details' => array(
      'title' => t('Additional Details'),
      'help' => t('Any additional details covering the description of the vehicle.'),
    ),
    'sold' => array(
      'title' => t('Sold'),
      'help' => t('A boolean for sold indicator.'),
      'field' => array(
        'handler' => 'views_handler_field_boolean',
      ),
    ),
    'attention' => array(
      'title' => t('Attension'),
      'help' => t('The attention banner, example: "deal of the week"'),
    ),
    'youtube_address' => array(
      'title' => t('Youtube address'),
      'help' => t('Full youtube URL for embedded video.'),
    ),
    'exdemonstrator' => array(
      'title' => t('Ex Demonstrator'),
      'help' => t('A boolean for ex demo indicator.'),
      'field' => array(
        'handler' => 'views_handler_field_boolean',
      ),
    ),
  );

  return $data;
}
