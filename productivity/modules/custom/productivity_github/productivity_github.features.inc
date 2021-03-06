<?php
/**
 * @file
 * productivity_github.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function productivity_github_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function productivity_github_node_info() {
  $items = array(
    'github_issue' => array(
      'name' => t('Github Issue'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
