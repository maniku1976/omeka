<!-- Some English titles replaced with Finnish ones -->
<?php
$pageTitle = __('Collections');
echo head(array('title'=>$pageTitle,'bodyclass' => 'collections browse'));
?>

<?php echo pagination_links(); ?>

<?php
/* Sort options for collections: title, added date */
$sortLinks[__('Title')] = 'Dublin Core,Title';
$sortLinks[__('Date Added')] = 'added';
?>
<div id="sort-links">
  <span><?php echo __('(%s collections)', $total_results); ?></span>
  <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
</div>

<div id="collection-list">
  <?php foreach (loop('collections') as $collection): ?>

    <div class="collection">

      <!-- Link to separate collection page replaced with link to items in the collection; translate titles -->
      <h2 style="padding-bottom: 0.5em;">
        <?php $title = metadata('collection', array('Dublin Core', 'Title'));
        switch ($title) {
          case "Lönnrot to Rabbe":
            $title = __('Lönnrot to Rabbe');
            break;
          case "Lönnrot to Castrén":
            $title = __('Lönnrot to Castrén');
            break;
          case "Lönnrot to Keckman":
            $title = __('Lönnrot to Keckman');
            break;
          case "Lönnrot to Elmgren":
            $title = __('Lönnrot to Elmgren');
            break;
          case "Lönnrot to Ahlqvist":
            $title = __('Lönnrot to Ahlqvist');
            break;
          case "Lönnrot to Borg":
            $title = __('Lönnrot to Borg');
            break;
          case "Lönnrot to Cajan":
            $title = __('Lönnrot to Cajan');
            break;
          case "Lönnrot to Collan":
            $title = __('Lönnrot to Collan');
            break;
          case "Lönnrot to Europaeus":
            $title = __('Lönnrot to Europaeus');
            break;
          case "Lönnrot to Ilmoni":
            $title = __('Lönnrot to Ilmoni');
            break;
          case "Lönnrot to Lindfors":
            $title = __('Lönnrot to Lindfors');
            break;
          case "Lönnrot to Saxa":
            $title = __('Lönnrot to Saxa');
            break;
          case "Lönnrot to Sjögren":
            $title = __('Lönnrot to Sjögren');
            break;
          case "Lönnrot to Ståhlberg":
            $title = __('Lönnrot to Ståhlberg');
            break;
          case "Lönnrot to Ticklén":
            $title = __('Lönnrot to Ticklén');
            break;
          case "Lönnrot to Warelius":
            $title = __('Lönnrot to Warelius');
            break;
        }
        ?>
        <?php echo link_to_items_browse($title, array('collection' => metadata('collection', 'id'))); ?>
        <?php $count = metadata($collection, 'total_items');
        if ($count == 1):
          echo ' ('.__('%s letter', $count).')';
        else:
          echo ' ('.__('%s letters', $count).')';
        endif;
        ?>
      </h2>
      <?php if ($collectionImage = record_image('collection', 'square_thumbnail')): ?>
        <!-- Link to separate collection page removed from collection thumbnail -->
        <div class="image"><?php echo $collectionImage; ?></div>
      <?php endif; ?>

      <?php if (metadata('collection', array('Dublin Core', 'Description'))): ?>
        <div class="collection-description">
          <?php $descr = metadata('collection', array('Dublin Core', 'Description'));
          switch ($descr) {
            case "Letters sent by Lönnrot to Frans Johan Rabbe":
              $descr = __("Letters sent by Lönnrot to Frans Johan Rabbe");
              break;
            case "Letters sent by Lönnrot to Matthias Alexander Castrén":
              $descr = __("Letters sent by Lönnrot to Matthias Alexander Castrén");
              break;
            case "Letters sent by Lönnrot to Carl Niklas Keckman":
              $descr = __("Letters sent by Lönnrot to Carl Niklas Keckman");
              break;
            case "Letters sent by Lönnrot to Sven Gabriel Elmgren":
              $descr = __("Letters sent by Lönnrot to Sven Gabriel Elmgren");
              break;
            case "Letters sent by Lönnrot to August Engelbrekt Ahlqvist":
              $descr = __("Letters sent by Lönnrot to August Engelbrekt Ahlqvist");
              break;
            case "Letters sent by Lönnrot to Carl Gustaf Borg":
              $descr = __("Letters sent by Lönnrot to Carl Gustaf Borg");
              break;
            case "Letters sent by Lönnrot to Johan Fredrik Cajan":
              $descr = __("Letters sent by Lönnrot to Johan Fredrik Cajan");
              break;
            case "Letters sent by Lönnrot to Fabian Collan":
              $descr = __("Letters sent by Lönnrot to Fabian Collan");
              break;
            case "Letters sent by Lönnrot to David Emanuel Daniel Europaeus":
              $descr = __("Letters sent by Lönnrot to David Emanuel Daniel Europaeus");
              break;
            case "Letters sent by Lönnrot to Immanuel Ilmoni":
              $descr = __("Letters sent by Lönnrot to Immanuel Ilmoni");
              break;
            case "Letters sent by Lönnrot to Mårten Johan Lindfors":
              $descr = __("Letters sent by Lönnrot to Mårten Johan Lindfors");
              break;
            case "Letters sent by Lönnrot to Carl Saxa":
              $descr = __("Letters sent by Lönnrot to Carl Saxa");
              break;
            case "Letters sent by Lönnrot to Anders Johan Sjögren":
              $descr = __("Letters sent by Lönnrot to Anders Johan Sjögren");
              break;
            case "Letters sent by Lönnrot to Carl Henrik Ståhlberg":
              $descr = __("Letters sent by Lönnrot to Carl Henrik Ståhlberg");
              break;
            case "Letters sent by Lönnrot to Johan Fredrik Ticklén":
              $descr = __("Letters sent by Lönnrot to Johan Fredrik Ticklén");
              break;
            case "Letters sent by Lönnrot to Antero Warelius":
              $descr = __("Letters sent by Lönnrot to Antero Warelius");
              break;
          }
          ?>
          <?php echo text_to_paragraphs($descr);
          ?>
        </div>
      <?php endif; ?>

      <?php if ($collection->hasContributor()): ?>
        <div class="collection-contributors">
          <p>
            <strong><?php echo __('Contributors'); ?>:</strong>
            <?php echo metadata('collection', array('Dublin Core', 'Contributor'), array('all'=>true, 'delimiter'=>', ')); ?>
          </p>
        </div>
      <?php endif; ?>

      <p class="view-items-link">&#8594; <?php echo link_to_items_browse(__('Letters in the collection', metadata('collection', array('Dublin Core', 'Title'))), array('collection' => metadata('collection', 'id'))); ?></p>

      <?php fire_plugin_hook('public_collections_browse_each', array('view' => $this, 'collection' => $collection)); ?>

    </div><!-- end class="collection" -->

  <?php endforeach; ?>
</div>
<?php echo pagination_links(); ?>

<?php fire_plugin_hook('public_collections_browse', array('collections'=>$collections, 'view' => $this)); ?>

<?php echo foot(); ?>
