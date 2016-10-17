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
    <?php if ($description): ?>
        <p class="item-description">
          <?php echo 'Kirjoitusaika: '.date('j.n.Y', strtotime($date)); ?><br />
          <?php echo $description; ?>
        </p>
    <?php endif; ?>
</div>
