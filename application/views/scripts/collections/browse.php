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

      <!-- Link to separate collection page replaced with link to items in the collection; translate titles, variable for correspondence years -->
      <h2 style="padding-bottom: 0.5em;">
        <?php $title = metadata('collection', array('Dublin Core', 'Title'));
        $years = '';
        switch ($title) {
          case "Lönnrot to Rabbe":
            $years = '1833 - 1871';
            break;
          case "Lönnrot to Castrén":
            $years = '1839 - 1851';
            break;
          case "Lönnrot to Keckman":
            $years = '1826 - 1838';
            break;
          case "Lönnrot to Elmgren":
            $years = '1848 - 1865';
            break;
          case "Lönnrot to Ahlqvist":
            $years = '1845 - 1881';
            break;
          case "Lönnrot to Borg":
            $years = '1863 - 1884';
            break;
          case "Lönnrot to Cajan":
            $years = '1836 - 1845';
            break;
          case "Lönnrot to Collan":
            $years = '1834 - 1852';
            break;
          case "Lönnrot to Europaeus":
            $years = '1845 - 1850';
            break;
          case "Lönnrot to Ilmoni":
            $years = '1833 - 1849';
            break;
          case "Lönnrot to Lindfors":
            $years = '1835 - 1843';
            break;
          case "Lönnrot to Saxa":
            $years = '1833 - 1848';
            break;
          case "Lönnrot to Sjögren":
            $years = '1840 - 1852';
            break;
          case "Lönnrot to Ståhlberg":
            $years = '1836 - 1876';
            break;
          case "Lönnrot to Ticklén":
            $years = '1833 - 1837';
            break;
          case "Lönnrot to Warelius":
            $years = '1848 - 1883';
            break;
          case "Lönnrot to Schildt-Kilpinen":
            $years = '1843 - 1874';
            break;
          case "Lönnrot to Granlund":
            $years = '1856 - 1874';
            break;
          case "Lönnrot to Akiander":
            $years = '1840 - 1869';
            break;
          case "Lönnrot to Barck":
            $years = '1833 - 1865';
            break;
          case "Lönnrot to Roos":
            $years = '1831 - 1847';
            break;
          case "Lönnrot to Snellman":
            $years = '1844 - 1868';
            break;
          case "Lönnrot to Thuneberg":
            $years = '1833 - 1840';
            break;
          case "Lönnrot to Tikkanen":
            $years = '1849 - 1870';
            break;
          case "Lönnrot to Appelgren":
            $years = '1833 - 1837';
            break;
          case "Lönnrot to Asp":
            $years = '1842 - 1849';
            break;
          case "Lönnrot to Forbus":
            $years = '1833 - 1868';
            break;
          case "Lönnrot to Hedberg":
            $years = '1833 - 1836';
            break;
          case "Lönnrot to Höglund":
            $years = '1833 - 1849';
            break;
          case "Lönnrot to Ingman":
            $years = '1834 - 1836';
            break;
          case "Lönnrot to Kellgren":
            $years = '1834 - 1847';
            break;
          case "Lönnrot to Kiljander":
            $years = '1847 - 1871';
            break;
          case "Lönnrot to Krohn":
            $years = '1863 - 1882';
            break;
          case "Lönnrot to Lindh":
            $years = '1847 - 1850';
            break;
          case "Lönnrot to Linsén":
            $years = '1834 - 1838';
            break;
          case "Lönnrot to Rein":
            $years = '1835 - 1866';
            break;
          case "Lönnrot Rothsten":
            $years = '1871 - 1880';
            break;
          case "Lönnrot to Skogman":
            $years = '1833 - 1836';
            break;
          case "Lönnrot to Öhman":
            $years = '1842 - 1847';
            break;
        }
        ?>
        <?php echo link_to_items_browse(__($title), array('collection' => metadata('collection', 'id'))); ?>
        <?php $count = metadata($collection, 'total_items');
        /* Show number of letters and correspondence years for each collection */
        echo __('(%1$s letters, %2$s)', $count, $years);
        ?>
      </h2>
      <?php if ($collectionImage = record_image('collection', 'square_thumbnail')): ?>
        <!-- Link to separate collection page removed from collection thumbnail -->
        <div class="image"><?php echo $collectionImage; ?></div>
      <?php endif; ?>

      <?php if (metadata('collection', array('Dublin Core', 'Subject'))): ?>
        <div class="collection-description">
          <?php $descr = metadata('collection', array('Dublin Core', 'Subject'));?>
          <?php echo text_to_paragraphs(__($descr)); ?>
          <?php echo text_to_paragraphs(metadata('collection', array('Dublin Core', 'Description'))); ?>
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
