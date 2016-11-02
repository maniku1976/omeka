<div class="item record">
    <?php
    $title = metadata($item, array('Dublin Core', 'Title'));
    $description = metadata($item, array('Dublin Core', 'Description'), array('snippet' => 150));
    $date = metadata($item, array('Dublin Core', 'Date'));
    ?>
    <h3><?php echo link_to($item, 'show', strip_formatting($title)); ?></h3>
    <?php if (metadata($item, 'has files')) {
        echo link_to_item(
            item_image('square_thumbnail', array(), 0, $item),
            array('class' => 'image'), 'show', $item
        );
    }
    ?>
    <!-- recent items: date in format d.m.yyyy; replace description with translatable 'sent from' + location
    picked from TEI -->
    <?php if ($description): ?>
        <p class="item-description">
          <?php echo __('Date').": ".date('j.n.Y', strtotime($date)); ?><br />
          <?php $files = $item->Files;
          foreach($files as $file) {
            if ($file->getExtension() == 'xml') {
              $xml = simplexml_load_file("http://".$_SERVER['SERVER_NAME']."/omeka/files/original/".metadata($file,'filename'));
              $location = $xml->text->body->div->opener->dateline->placeName;
              if ($location == 'puuttuu') { /* if location 'puuttuu'/'empty', replace with translatable word */
                $location = str_replace($location, __('missing'), $location);
              }
              echo __('Sent from: ').$location;
            }
          }
          ?>
        </p>
    <?php endif; ?>
</div>
