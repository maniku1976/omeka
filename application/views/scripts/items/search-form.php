<!-- Some labels and titles replaced with better Finnish translations-->
<?php
if (!empty($formActionUri)):
    $formAttributes['action'] = $formActionUri;
else:
    $formAttributes['action'] = url(array('controller'=>'items',
                                          'action'=>'browse'));
endif;
$formAttributes['method'] = 'GET';
?>

<form <?php echo tag_attributes($formAttributes); ?>>
    <div id="search-narrow-by-fields" class="field">
        <div class="label"><?php echo __('Valitse hakukenttä'); ?></div>
        <div class="inputs">
        <?php
        if (!empty($_GET['advanced'])) {
            $search = $_GET['advanced'];
        } else {
            $search = array(array('field'=>'','type'=>'','value'=>''));
        }

        foreach ($search as $i => $rows): ?>
            <?php

              $table_options = get_table_options('Element', null, array(
                  'element_set_name' => 'Dublin Core',
                  'sort' => 'orderBySet'));
              // Remove unnecessary selections from advanced search fields dropdown menu
              $table_options = array_diff($table_options,
                ['Aihe', 'Kuvaus', 'Kattavuus', 'Laji', 'Formaatti', 'Julkaisija', 'Oikeudet',
                'Muu tekijä', 'Lähde', 'Suhde']);

              $table_options = str_replace('Valitse', 'Valitse hakukenttä', $table_options);
              $table_options = str_replace('Otsikko', 'Vastaanottaja', $table_options);

              $label_table_options = label_table_options(array(
                  'contains' => __('contains'),
                  'does not contain' => __('does not contain'),
                  'is exactly' => __('is exactly'),
                  'is empty' => __('is empty'),
                  'is not empty' => __('is not empty'))
              );

              $label_table_options = str_replace('Valitse', 'Valitse hakurajoite', $label_table_options);
            ?>

            <div class="search-entry">
                <?php
                echo $this->formSelect(
                    "advanced[$i][element_id]",
                    @$rows['element_id'],
                    array(
                        'title' => __("Search Field"),
                        'id' => null,
                        'class' => 'advanced-search-element'
                    ),
                    @$table_options
                );
                echo $this->formSelect(
                    "advanced[$i][type]",
                    @$rows['type'],
                    array(
                        'title' => __("Search Type"),
                        'id' => null,
                        'class' => 'advanced-search-type'
                    ),
                    @$label_table_options
                );
                echo $this->formText(
                    "advanced[$i][terms]",
                    @$rows['terms'],
                    array(
                        'size' => '20',
                        'title' => __("Search Terms"),
                        'id' => null,
                        'class' => 'advanced-search-terms',
                        'placeholder' => __('Search Terms')
                    )
                );
                ?>
                <button type="button" class="remove_search" disabled="disabled" style="display: none;" title="Poista hakukenttä"><?php echo __('-'); ?></button>
            </div>
        <?php endforeach; ?>
        </div>
        <button type="button" class="add_search" style="border-radius: 2px;" title="Lisää hakukenttä"><?php echo __('+'); ?></button>
    </div>

    <!--<div class="field">
        <?php echo $this->formLabel('tag-search', __('Search By Tags')); ?>
        <div class="inputs">
        <?php
            echo $this->formText('tags', @$_REQUEST['tags'],
                array('size' => '40', 'id' => 'tag-search')
            );
        ?>
        </div>
    </div>-->

    <?php fire_plugin_hook('public_items_search', array('view' => $this)); ?>
    <div>
        <?php if (!isset($buttonText)) $buttonText = __('Search'); ?>
        <input style="border-radius:2px;" type="submit" class="submit" name="submit_search" id="submit_search_advanced" value="<?php echo $buttonText ?>">
    </div>
</form>
<?php echo js_tag('items-search'); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Omeka.Search.activateSearchButtons();
    });
</script>
