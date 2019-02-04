<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcsearch\SearchBuilder\XtcSearchBuilder;

class XtcAutocomplete
{

  /**
   * @param $name
   *
   * @return array
   */
  public static function get($name): array {
    $xtcform = (XtcForm::get($name))->getForm();
    $search = New XtcSearchBuilder($xtcform);
    $search->triggerSearch();
    if(!empty($search->getResultSet())){
      $items = $search->getResultSet()->getSuggests()['completion_q'][0]['options'];
      $textList = [];

      foreach($items as $key => $item){
        $value = strtolower(ToolBox::replaceAccents($item['text']));
        if(!in_array($value, $textList)) {
          $options[$key] = [
            'value' => $value,
            'label' => $value,
          ];
          $textList[] = $value;
        }
      }
    }
    return $options ?? [];
  }

}