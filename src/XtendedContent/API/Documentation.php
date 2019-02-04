<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-31
 * Time: 11:59
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcfile\Controller\XtcDocumentationController;

class Documentation
{

  /**
   * @param $name
   *
   * @return string
   */
  public static function getHelp($module){
    $links =(New XtcDocumentationController())
      ->setModule($module)
      ->getHelp();
    return self::getHelpFile($module)
           . $links;
  }

  /**
   * @param $name
   *
   * @return string
   */
  public static function getHelpFile($module){
    foreach(['help/help.md'] as $path){
      $profile = [
        'type' => 'markdown',
        'abs_path' => false,
        'module' => $module,
        'path' => $path,
      ];
      $content = self::getFromProfile($profile);
      if(!empty($content)){
        return $content;
      }
    }
    return '';
  }

  public static function getDocs($module){
    $profile = [
      'type' => 'mkdocs',
      'abs_path' => false,
      'module' => $module,
      'path' => 'help/mkdocs.yml',
    ];
    $content = self::getFromProfile($profile);
    if(!empty($content) && is_array($content)) {
      return $content;
    }
    return "<h2>Documentation needs to be created.</h2>
           <p>Documentation follows <b><a href='https://www.mkdocs.org/' target='_blank'>
           mkdocs</a></b> standards.</p>
        ";
  }

  /**
   * @param $name
   *
   * @return string
   */
  public static function getDocsPage($module, $path){
    $profile = [
      'type' => 'mkdocs',
      'abs_path' => false,
      'module' => $module,
      'path' => 'help/docs/' . $path,
    ];
    $content = self::getFromProfile($profile);
    if(!empty($content)) {
      return $content;
    }
    $link = Link::createFromRoute('Index', 'xtcfile.docs.docs',
                                  ['module' => $module])->toString();
    return "<h2>Page not found.</h2>
           <p>Go back to the documentation index: $link.</p>
        ";
  }

  public static function getFromProfile($profile){
    return XtcHandler::get($profile['type'])
               ->setProfile($profile)
               ->setOptions()
               ->get();
    ;
  }


}