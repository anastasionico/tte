<?php

/**
 * @file
 * Rules module integration.
 */

/**
 * Implements hook_rules_action_info().
 * @ingroup rules
 */
function node_expire_rules_action_info() {
  return array(
    'node_expire_unset_expired' => array(
      'arguments' => array(
        'node' => array('type' => 'node', 'label' => t('content expired')),
      ),
      'label' => t('Unset the expired flag'),
//       'module' => 'Node',
      'module' => 'node_expire',
    ),
    'node_expire_update_lastnotify' => array(
      'arguments' => array(
        'node' => array(
          'type' => 'node',
          'label' => t('content expired'),
        ),
      ),
      'label' => t('Update lastnotify'),
//       'module' => 'Node',
      'module' => 'node_expire',
    ),
  );
}

/**
 * Implements hook_rules_condition_info().
 * @ingroup rules
 */
function node_expire_rules_condition_info() {
  return array(
    'node_expire_rules_expired_check' => array(
      'arguments' => array(
        'node' => array('type' => 'node', 'label' => t('Content')),
      ),
      'label' => t('Content is expired'),
      'help' => 'Evaluates to TRUE, if the given content has one of the selected content types.',
//       'module' => 'Node',
      'module' => 'node_expire',
    ),
    'node_expire_rules_expired_check_lastnotify' => array(
      'arguments' => array(
        'node' => array(
          'type' => 'node',
          'label' => t('Content'),
        ),
      ),
      'label' => t('Content is expired: Check lastnotify'),
      'help' => 'Evaluates to TRUE, if the given content is expired and lastnotified 2 weeks ago.',
//       'module' => 'Node',
      'module' => 'node_expire',
    ),
    'node_expire_rules_expired_check_lastnotify_is_set' => array(
      'arguments' => array(
        'node'      => array('type' => 'node', 'label' => t('Content')),
      ),
      'label'     => t('Content is expired: Check lastnotify is set'),
      'help'      => 'Evaluates to TRUE, if the given content is expired and lastnotified is set.',
//       'module' => 'Node',
      'module' => 'node_expire',
    ),
  );
}

/**
 * Implements hook_rules_event_info().
 * @ingroup rules
 */
function node_expire_rules_event_info() {
  $events['node_expired'] = array(
    'label' => t('content expired'),
    'group' => t('Node'),
    'variables' => array(
      'node' => array(
        'type' => 'node',
        'label' => t('Node'),
      ),
    ),
  );
  return $events;
}

/**
 * Check if the node has the the "Expired" flag on.
 *
 * @param $node
 *   Object. The Node object.
 */
function node_expire_rules_expired_check($node) {
  return (!empty($node->expire) && $node->expire <= REQUEST_TIME && $node->expired == 1);
}

/**
 * Check if the node has the the "Expired" flag on
 * and lastnotify greater than or equal to 2 weeks.
 * @param $node
 *   Object. The Node object.
 */
function node_expire_rules_expired_check_lastnotify($node) {
  return (!empty($node->expire) && $node->expire <= REQUEST_TIME && $node->expired == 1 && $node->lastnotify <= (REQUEST_TIME - (14 * 24 * 60 * 60)));
}

/**
 * Check if the node has the the "Expired" flag on
 * and lastnotify is set.
 * @param $node
 *   Object. The Node object.
 */
function node_expire_rules_expired_check_lastnotify_is_set($node) {
  return (!empty($node->expire) && $node->expire <= time() && $node->expired == 1 && $node->lastnotify != 0 );
}

/**
 * Unset the "Expired" flag on nodes.
 *
 * @param $nids
 *   Object. The Node object with all node IDs
 *   that should unset the expired flag.
 */
function node_expire_unset_expired($nids) {
  // TODO Please convert this statement to the D7 database API syntax.
//   db_query("UPDATE {node_expire} SET expired = '0', lastnotify = '0' WHERE nid = '" . $nids->nid . "'");
    db_update('node_expire')
      ->fields(array('expired' => 0,
                     'lastnotify' => 0))
          ->condition('nid', $nids->nid)
      ->execute();
}

/**
 * Update lastnotify on nodes.
 *
 * @param $nids
 *   Object. The Node object with all node IDs
 *   that should update lastnotify.
 */
function node_expire_update_lastnotify($nids) {
  // TODO Please convert this statement to the D7 database API syntax.
//   db_query("UPDATE {node_expire} SET lastnotify = '" . REQUEST_TIME . "' WHERE nid = '" . $nids->nid . "'");
    db_update('node_expire')
      ->fields(array('lastnotify' => REQUEST_TIME))
      ->condition('nid', $nids->nid)
      ->execute();
}
