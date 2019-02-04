<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\Core\Block\BlockBase;

class XtcSearch
{

  public static function get($name): array {
    $xtcsearch = XtcForm::get($name);
    return \Drupal::formBuilder()
                  ->getForm($xtcsearch->getForm());
  }

  public static function getBlock($name) {
    $block_manager = \Drupal::service('plugin.manager.block');
    $config = [];
    $plugin_block = $block_manager->createInstance($name, $config);
    if($plugin_block instanceof BlockBase) {
      $access_result = $plugin_block->access(\Drupal::currentUser());
      if(is_object($access_result) && $access_result->isForbidden()
         || is_bool($access_result) && !$access_result) {
        // You might need to add some cache tags/contexts.
        return [];
      }
      return $plugin_block->build();
    }
  }

}