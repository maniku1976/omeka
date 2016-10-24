<?php 

$currentLocaleCode = get_option('locale_lang_code');
if (!$currentLocaleCode){ $currentLocaleCode = "en"; }
$language_option = explode("#",get_option('languages_options'));
$codes = listAvailableLang();
$show_ways = array("m_n"=>"Drop-down menu with language name",
		   "m_c"=>"Drop-down menu with language code",
                   "l_n"=>"Links          with language name",
		   "l_c"=>"Links          with language code",
                   "b_o"=>"Flags only",
		   "b_n"=>"Flags          with language name",
		   "b_c"=>"Flags          with language code",
		   );
asort($codes);
?>

<div class="field">
    <div class="two columns alpha">
        <label><?php echo __('Language'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("Default language of the public site (and admin interface)."); ?> </p>
        <div class="input-block">
            <?php echo get_view()->formSelect('locale_lang_code', $currentLocaleCode, null, $codes);   ?> 
  <p class="explanation"><i><?php echo __('Some parts of the site might not have been translated into your language yet. To learn more about contributing to translations, <a href=\'http://omeka.org/codex/Translate_Omeka\'>read this</a>.'); ?> </i></p>
        </div><!--formSelect is a function in Zend Framework-->
    </div>
  <div class="two columns alpha">
    <label><?php echo __('Display type'); ?></label>
  </div>
  <div class="inputs five columns omega">
    <p class="explanation"><?php echo __("The way lang choice will be available on public site."); ?> </p>
  <div class="input-block">
            <?php 
            echo __(get_view()->formSelect('show_way', get_option('show_way'), null, $show_ways));  ?> 
        </div><!--formSelect is a function in Zend Framework-->
  </div>
  <div class="two columns alpha">
    <label><?php echo __('Theme subdirectory for flags (optionnal)'); ?></label>
  </div>
  <div class="inputs five columns omega">
  <p class="explanation"><?php echo __("Subdirectory containing custom flags. (e.g. \"flags/\")"); ?></p>
  <div class="input-block">
  <input type="text" name="theme_subdir" value="<?php echo get_option('theme_subdir'); ?>" />
  </div>
    <p class="explanation"><?php echo __("<ul><li>File names must be: \"flag-\$LANGCODE.png\" (e.g. \"flag-fr.png\")</li><li>Images have to be PNG and will be display with height and width of 25px</li><li>If no flag is found in the theme, plugin flags will be used</li><li>If no subdirectory is specified, the plugin will look for an \"img/\" directory</li></ul>"); ?> </p>
    </div>
    <div class="two columns alpha">
         <label><?php echo __("Available languages"); ?></label>
    </div>
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __("Choose the languages that will be available on the public site."); ?>
        <div class="input-block">
            <?php 
  foreach ($codes as $code => $language) {
    //if(in_array($code, $_SESSION['languages_options'])){
    if(in_array($code, $language_option)){
      echo "<input type='checkbox' checked='checked' name='language_option[]' value='".$code."' />";
    } else { 
      echo "<input type='checkbox' name='language_option[]' value='".$code."' />";
    }
    echo "&nbsp;".$language." <code>[".$code."]</code>";
    echo "<br/>\n";
  }
 ?>
        </div>
    </div>
</div>
