<?php

/**
 * @package     omeka
 * @subpackage  solr-search
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

?>


<?php queue_css_file('results'); ?>
<?php echo head(array('title' => __('Solr-haku')));?>


<h2><?php echo __('Hakusanat'); ?></h2>

<!-- Search form. -->
<div class="solr">
  <form id="solr-search-form">
    <input type="submit" value="Haku" />
    <span class="float-wrap">
      <input type="text" title="<?php echo __('Hae hakusanoilla') ?>" name="q" value="<?php
        echo array_key_exists('q', $_GET) ? $_GET['q'] : '';
      ?>" placeholder="Hae kirjeitä"/>
    </span>
  </form>
</div>


<!-- Applied facets. -->
<div id="solr-applied-facets">

  <ul>

    <!-- Get the applied facets. -->
    <?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f): ?>
      <li>
        <!-- Facet label. -->
        <?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
        <?php $label = str_replace('XML File', 'Paikka', $label);
        $label = str_replace('Language', 'Kieli', $label);
        $label = str_replace('Type', 'Laji', $label);
        ?>
        <span class="applied-facet-label"><?php echo $label; ?></span> >
        <span class="applied-facet-value"><?php echo $f[1]; ?></span>

        <!-- Remove link. -->
        <?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
        (<a href="<?php echo $url; ?>">poista</a>)

      </li>
    <?php endforeach; ?>

  </ul>

</div>


<!-- Facets. -->
<div id="solr-facets">

  <h2><?php echo __('Rajaa hakua'); ?></h2>

  <?php foreach ($results->facet_counts->facet_fields as $name => $facets): ?>

    <!-- Does the facet have any hits? -->
    <?php if (count(get_object_vars($facets))): ?>

      <!-- Facet label. -->
      <?php $label = SolrSearch_Helpers_Facet::keyToLabel($name);
        $label = str_replace('Language', 'Kieli', $label);
        $label = str_replace('XML File', 'Kirjoituspaikka', $label);
        $label = str_replace('Type', 'Laji', $label);
      ?>
      <strong><?php echo $label; ?></strong>

      <ul>
        <!-- Facets. -->
        <?php foreach ($facets as $value => $count): ?>
          <li class="<?php echo $value; ?>">

            <!-- Facet URL. -->
            <?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>

            <!-- Facet link. -->
            <a href="<?php echo $url; ?>" class="facet-value">
              <?php if ($label == 'Kirjoituspaikka') {
                $value = ucfirst($value);
              } ?>
              <?php echo $value; ?>
            </a>

            <!-- Facet count. -->
            (<span class="facet-count"><?php echo $count; ?></span>)

          </li>
        <?php endforeach; ?>
      </ul>

    <?php endif; ?>

  <?php endforeach; ?>
</div>


<!-- Results. -->
<div id="solr-results">

  <!-- Number found. -->
  <h2 id="num-found">
    Kirjeitä löytyi: <?php echo $results->response->numFound; ?>
  </h2>
  <?php foreach ($results->response->docs as $doc): ?>
    <!-- Document. -->
    <div class="result">

      <!-- Header. -->
      <div class="result-header">

        <!-- Record URL. -->
        <?php $url = SolrSearch_Helpers_View::getDocumentUrl($doc); ?>

        <!-- Title. -->
        <a href="<?php echo $url; ?>" class="result-title"><?php
                $title = is_array($doc->title) ? $doc->title[0] : $doc->title;
                if (empty($title)) {
                    $title = '<i>' . __('Nimetön') . '</i>';
                }
                $date = '40_t';
                echo $title.", ".date('j.n.Y', strtotime($doc->$date));
            ?></a>

        <!-- Result type. -->
        <!--<span class="result-type">(<?php echo $doc->resulttype; ?>)</span>-->

      </div>

      <!-- Highlighting. -->
      <?php if (get_option('solr_search_hl')): ?>
        <ul class="hl">
          <?php foreach($results->highlighting->{$doc->id} as $field): ?>
            <?php foreach($field as $hl): ?>
              <li class="snippet"><?php echo strip_tags($hl, '<em>'); ?></li>
            <?php endforeach; ?>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php
        $item = get_db()->getTable($doc->model)->find($doc->modelid);
        echo item_image_gallery(
            array('wrapper' => array('class' => 'gallery')),
            'square_thumbnail',
            false,
            $item
        );
      ?>

    </div>

  <?php endforeach; ?>

</div>


<?php echo pagination_links(); ?>
<?php echo foot();
