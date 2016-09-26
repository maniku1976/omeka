<!-- Some English titles replaced with Finnish ones-->
<?php
$pageTitle = __('Selaa kirjeitä');
echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

<!--<h1><?php echo __('Kirjeitä yhteensä %s', $total_results); ?></h1>-->

<nav class="items-nav navigation secondary-nav">
    <!--<?php echo public_nav_items(); ?>-->
</nav>

<?php echo item_search_filters(); ?>

<?php echo pagination_links(); ?>

<?php if ($total_results > 0): ?>

<?php

/* Sort options for items: writing date, title, writer */
$sortLinks[__('Kirjoitusaika')] = 'Dublin Core,Date';
$sortLinks[__('Otsikko')] = 'Dublin Core,Title';
$sortLinks[__('Kirjoittaja')] = 'Dublin Core,Creator';
?>
<div id="sort-links">
    <span class="sort-label"><?php echo __('Järjestä: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
</div>

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
          echo "Kirjoitusaika: ".date('j.n.Y', strtotime($date)); ?>
    </div>
    <?php endif; ?>

    <?php if ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>250))): ?>
    <div class="item-description">
        <?php echo $description; ?>
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
    <span class="outputs-label"><?php echo __('Formaatit:'); ?></span>
    <?php echo output_format_list(false); ?>
</div>

<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

<?php echo foot(); ?>
