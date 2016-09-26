<!-- Some English titles replaced with Finnish ones -->
<div id="<?php echo $options['id']; ?>">
<ul>
    <?php echo $query; ?>
    <li><?php echo __('Kysely:');?> <?php echo html_escape($query); ?></li>
    <li><?php echo __('Kyselyn laji:');?> <?php echo html_escape($query_type); ?></li>
    <li><?php echo __('Dokumenttilajit:');?>
        <ul>
            <?php foreach ($record_types as $record_type): ?>
            <li><?php echo html_escape($record_type); ?></li>
            <?php endforeach; ?>
        </ul>
    </li>
</ul>
</div>
