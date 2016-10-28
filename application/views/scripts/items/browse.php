<!-- Some English titles replaced with Finnish ones-->
<?php
$pageTitle = __('Browse Items');
echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

<!--<h3 style="margin-top:0.5em;margin:left:0.5em;margin-bottom:none;"><?php echo __('%s total', $total_results); ?></h3>-->

<!--<nav class="items-nav navigation secondary-nav">
    <?php echo public_nav_items(); ?>
</nav>-->




<?php if ($total_results > 0): ?>

<?php

/* Sort options for items: writing date, title, writer */
$sortLinks[__('Date')] = 'Dublin Core,Date';
$sortLinks[__('Title')] = 'Dublin Core,Title';
$sortLinks[__('Creator')] = 'Dublin Core,Creator';
?>

<div style="float:left;font-size:18px;display:inline-block">
  <?php echo item_search_filters(); ?>
  <span style="font-size: 20px;"><?php if ($total_results == 1): ?>
    <?php echo __("%s letter", $total_results); ?>
  <?php elseif ($total_results > 1): ?>
    <?php echo __("%s letters", $total_results); ?>
  <?php endif; ?></span>
</div>
<div id="sort-links">
    <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
</div>

<?php echo pagination_links(); ?>
<?php endif; ?>

<div id="item-main-list">
  <?php foreach (loop('items') as $item): ?>
  <div class="item hentry">
    <p><?php echo link_to_item(metadata('item', array('Dublin Core', 'Title')), array('class'=>'permalink')); ?></p>
    <div class="item-meta">
    <?php if (metadata('item', 'has files')): ?>
    <div class="item-img">
        <?php echo link_to_item(item_image('square_thumbnail')); ?>
    </div>
    <?php endif; ?>

    <?php if ($date = metadata('item', array('Dublin Core', 'Date'), array('snippet'=>250))): ?>
    <div class="item-date">
        <?php
          /* Display writing date for each item, format d.m.yyyy */
          echo __('Date').': '.date('j.n.Y', strtotime($date)); ?>
    </div>
    <?php endif; ?>

    <?php if ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>250))): ?>
    <div class="item-description">
      <!--replace description with translatable 'writing location' + location picked from TEI-->
      <?php $files = $item->Files;
      foreach($files as $file) {
        if ($file->getExtension() == 'xml') {
          $xml = simplexml_load_file("http://localhost/files/original/".metadata($file,'filename'));
          $location = $xml->text->body->div->opener->dateline->placeName;
          if ($location == 'puuttuu') { /* if location 'puuttuu'/'empty', replace with translatable word */
            $location = str_replace($location, __('missing'), $location);
          }
          echo __('Sent from: ').$location;
        }
      }
      ?>
    </div>
    <?php endif; ?>

    <?php if (metadata('item', 'has tags')): ?>
    <div class="tags"><p><strong><?php echo __('Tags'); ?>:</strong>
        <?php echo tag_string('items'); ?></p>
    </div>
    <?php endif; ?>

    <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>

    </div><!-- end class="item-meta" -->
  </div><!-- end class="item hentry" -->
  <?php endforeach; ?>
</div>

<?php echo pagination_links(); ?>

<div id="outputs">
    <span class="outputs-label"><?php echo __('Formats:'); ?></span>
    <?php echo output_format_list(false); ?>
</div>

<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

<?php echo foot(); ?>
