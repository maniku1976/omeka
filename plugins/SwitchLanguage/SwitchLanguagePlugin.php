<?php

function normalizeLangCode($lang_code) {
    $lang_code_match = array("en" => "en_US", "el" => "el_GR", "es" => "es", "fi" => "fi_FI");

    if (array_key_exists($lang_code,$lang_code_match)){
      $lang_code = $lang_code_match[$lang_code];
    }
    return $lang_code;
}

function listAvailableLang() {
  foreach (glob(BASE_DIR."/application/languages/*.mo") as $file){
    $lang_code = basename($file, ".mo");
    $the_lang = new Zend_Locale($lang_code);
    $the_language = ucfirst(Zend_Locale::getTranslation($the_lang->getLanguage(), 'language', $lang_code));
    $the_region = $the_lang->getRegion();
    if ( isset($the_region) && $the_region ){
      $the_region = ucfirst(Zend_Locale::getTranslation($the_region, 'territory', $lang_code));
      $string_lang = $the_language. " (".$the_region.")";
    } else {
      $string_lang = $the_language;
    }
    $available_lang[$lang_code] = $string_lang;
  }
  //Add English manually
  $available_lang["sv_SE"] = "SE";
  $available_lang["fi"] = "FI";

  //print_r($available_lang);
  return $available_lang;
}

function getLanguageForOmekaSwitch(){
  // Choose POST value
  if( isset($_POST['locale_lang_code']) && Zend_Locale::isLocale($_POST['locale_lang_code']) ) {
    $the_lang = normalizeLangCode($_POST['locale_lang_code']);
    $_SESSION['the_lang_omeka'] = $the_lang;
    //echo "choice: POST";
  }
  // Else choose GET value
  elseif( isset($_GET['lang']) && Zend_Locale::isLocale($_GET['lang']) ) {
    $the_lang = normalizeLangCode($_GET['lang']);
    $_SESSION['the_lang_omeka'] = $the_lang;
    //echo "choice: GET";
  }
  // Else choose SESSION value
  elseif( isset($_SESSION['the_lang_omeka']) && Zend_Locale::isLocale($_SESSION['the_lang_omeka']) ) {
    $the_lang=$_SESSION['the_lang_omeka'];
    //echo "choice: SESSION";
  }
  // Else choose PLUGIN OPTION value
  elseif ( get_option('locale_lang_code') != "" && Zend_Locale::isLocale(get_option('locale_lang_code')) ) {
    $the_lang = get_option('locale_lang_code');
    //echo "choice: OPTION";
  }
  // Else choose ZEND DEFAULT value
  else {
    $the_lang = "en"; //Zend_Locale::getLanguage();
    //echo "choice: DEFAULT";
  }
  return $the_lang;
}

function findFlag($code){
  $path_parts = pathinfo($_SERVER['PHP_SELF']);
  $omeka_dir = $path_parts['dirname'];
  $theme = get_option('public_theme');
  $theme_subdir = get_option('theme_subdir');
  $theme_flag_dir   = $omeka_dir."/themes/".$theme."/".$theme_subdir;
  $plugin_flag_dir = $omeka_dir."/plugins/SwitchLanguage/round-icons/";

  $flag = $theme_flag_dir."flag-".$code.".png";
  if(!is_readable($_SERVER['DOCUMENT_ROOT'].$flag)){
    $flag = $plugin_flag_dir."flag-".$code.".png";
  }
  return $flag;
}

function createImgLink($src, $code, $language, $content){
  return "<a href=\"?lang=".$code."\"><img style=\"vertical-align:middle;\" src='".$src."' alt='flag of ".$language."' title=\"".$language."\" width=\"25px\" height=\"25px\">".$content."</a>&nbsp; ";
}

function createTxtLink($code, $language, $content){
  return "<a href=\"?lang=".$code."\" title=\"".$language."\">".$content."</a>&nbsp; ";
}

class SwitchLanguagePlugin extends Omeka_Plugin_AbstractPlugin
{

  public $_hooks = array('install', 'uninstall', 'config', 'config_form', 'initialize', 'public_body');
  public $_filters = array('public_navigation_admin_bar', 'locale');

  public function hookInstall()
  {
    //$this->_installOptions();
  }
  public function hookUninstall()
  {
    //$this->_uninstallOptions();
  }

  public function hookInitialize()
  {
    //Add the translations for this very plugin
    add_translation_source(dirname(__FILE__) . '/languages');
  }

  public function hookConfig($args)
  {
    $post = $args['post'];
    set_option('locale_lang_code', $post['locale_lang_code']);
    set_option('theme_subdir', $post['theme_subdir']);
    if( isset($post['show_way']) ) {
      set_option('show_way',$post['show_way']);
    }
    else {
      set_option('show_way','m_n');
    }
    if ( isset($post['position']) ){//todo: declare in plugin form
      set_option('position',$post['position']);
      //top_left top_right menu (only txt) admin_bar (only txt)
    } else {
      set_option('position',"top_right");
    }
    if(isset($post['language_option'])){
      $lang_list = implode("#",$post['language_option']);
      if ( ! in_array($post['locale_lang_code'], $post['language_option'])){
	$lang_list .= "#".$post['locale_lang_code'];
      }
	set_option('languages_options',$lang_list);
    }
  }

  public function hookConfigForm()
  {
    include('config_form.php');
  }

  public function hookPublicBody()
  {
    $show_way = get_option('show_way');
    if ( in_array($show_way, array('m_n', 'm_c', 'b_o', 'b_n', 'b_c') )){
      $lang_list = listAvailableLang();
      $current_locale_code = getLanguageForOmekaSwitch();
      if (strpos(get_option('languages_options'), "#")){
	$language_option = explode("#",get_option('languages_options'));
      } else {
	$language_option = array($current_locale_code);
      }

      $position = get_option('position');//todo: everything ;-)
      //position choices: top_left top_right menu (only txt) admin_bar (only txt)
      foreach ($language_option as $key => $value) {
	$language_name[$value] = $lang_list[$value];
	$language_code[$value] = $value;
      }


      //public page show
      echo "<div class='navigation' style='float:right; margin:5px;'>";
      echo "<form method='POST' name='form_langSwitch' id='form_langSwitch'>";

      switch ($show_way) {
      case 'm_n': //drop-down Menu + language Name
	echo get_view()->formSelect('locale_lang_code', $current_locale_code, array('onchange' => "this.form.submit()"), array_map("ucfirst", $language_name));
	break;
      case 'm_c': //drop-down Menu + language Code
	echo get_view()->formSelect('locale_lang_code', $current_locale_code, array('onchange' => "this.form.submit()"), array_map("strtoupper",$language_code));
	break;
      case 'b_o': //Banner only
	foreach ($language_name as $code => $language) {
	  $flag = findFlag($code);
	  echo createImgLink($flag, $code, $language, null);
	}
	break;
      case 'b_n': //Banner + language Name
	foreach ($language_name as $code => $language) {
	  $flag = findFlag($code);
	  echo createImgLink($flag, $code, $language, " ".ucfirst($language));
	}
	break;
      case 'b_c': //Banner + language Code
	foreach ($language_name as $code => $language) {
	  $flag = findFlag($code);
	  $content = $code;
	  echo createImgLink($flag, $code, $language, " ".strtoupper($code));
	}
	break;
      default: //'m_c'
	echo get_view()->formSelect('locale_lang_code', $current_locale_code, array('onchange' => "this.form.submit()"), array_map("strtoupper",$language_code));
	break;
      }
      echo "</form></div>";
    }
  }

  public function filterLocale($value)
  {
    $current_locale_code = getLanguageForOmekaSwitch();
    return $current_locale_code;
  }

  public function filterPublicNavigationAdminBar($nav)
  {
    $show_way = get_option('show_way');
    if ( in_array($show_way, array('l_n', 'l_c') )){
      $lang_list = listAvailableLang();
      $current_locale_code = getLanguageForOmekaSwitch();
      if (strpos(get_option('languages_options'), "#")){
	$language_option = explode("#",get_option('languages_options'));
      } else {
	$language_option = array($current_locale_code);
      }
      $position = get_option('position');//todo: everything ;-)
      //position choices: top_left top_right menu (only txt) admin_bar (only txt)
      foreach ($language_option as $key => $value) {
	$language_name[$value] = $lang_list[$value];
	$language_code[$value] = $value;
      }

      switch ($show_way) {
      case 'l_n': //Links + language Name
        foreach ($language_name as $code => $language) {
	  $nav[$code] = array(
			      'label' => ucfirst($language),
			      'uri' => url('?lang='.$code)
			      );
        }
        break;
      case 'l_c': //Links + language Code
        foreach ($language_name as $code => $language) {
	  $nav[$code] = array(
			      'label' => strtoupper($code),
			      'uri' => url('?lang='.$code)
			      );

	}
        break;
      }
    }
    return $nav;
  }
}
?>
