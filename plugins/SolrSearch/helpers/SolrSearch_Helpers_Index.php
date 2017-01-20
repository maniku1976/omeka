<?php

/**
* @package     omeka
* @subpackage  solr-search
* @copyright   2012 Rector and Board of Visitors, University of Virginia
* @license     http://www.apache.org/licenses/LICENSE-2.0.html
*/


class SolrSearch_Helpers_Index
{


  /**
  * Connect to Solr.
  *
  * @param array $options An array of connection parameters.
  *
  * @return Apache_Solr_Service
  * @author David McClure <david.mcclure@virginia.edu>
  **/
  public static function connect($options=array())
  {

    $server = array_key_exists('solr_search_host', $options)
    ? $options['solr_search_host']
    : get_option('solr_search_host');

    $port = array_key_exists('solr_search_port', $options)
    ? $options['solr_search_port']
    : get_option('solr_search_port');

    $core = array_key_exists('solr_search_core', $options)
    ? $options['solr_search_core']
    : get_option('solr_search_core');

    return new Apache_Solr_Service($server, $port, $core);

  }

  /**
  * This indexes something that implements Mixin_ElementText into a Solr Document.
  *
  * @param array                $fields The fields to index.
  * @param Mixin_ElementText    $item   The item containing the element texts.
  * @param Apache_Solr_Document $doc    The document to index everything into.
  * @return void
  * @author Eric Rochester <erochest@virginia.edu>
  **/


  public static function indexItem($fields, $item, $doc)
  {

    foreach ($item->getAllElementTexts() as $text) {
      $field = $fields->findByText($text);
      foreach ($item->getFiles() as $file) {
        if ($file->getExtension() == 'xml') {
          // Fetch TEI file for indexing, reads it into string
          $contents = file_get_contents("http://lonnrot.finlit.fi/omeka/files/original/".metadata($file,'filename'));
          // Cut out teiHeader and opener elements
          $cut = strpos($contents, '</opener>') + strlen('</opener>');
          $end = strlen($contents);
          $contents = substr($contents, $cut, $end);
          // Fetch TEI file as object, needed for access to specific elements
          $xml = simplexml_load_file("http://lonnrot.finlit.fi/omeka/files/original/".metadata($file,'filename'));
        }
      }

      if ($field->label == 'XML File') {
        // Replace indexed text value of TEI file url field with contents of TEI file
        $text->text = $contents;
        // Append writing location element from TEI file fetched as object for indexing
        $text->location = (string)$xml->text->body->div->opener->dateline->placeName;
      }

      // Set text field.
      if ($field->is_indexed) {
        $doc->setMultiValue($field->indexKey(), $text->text);
      }

      // Set string field. For TEI file url field, place only writing location
      // as facet
      if ($field->is_facet && $field->label == 'XML File') {
        $doc->setMultiValue($field->facetKey(), $text->location);
      } else if ($field->is_facet && $field->label != 'XML File') {
        $doc->setMultiValue($field->facetKey(), $text->text);
      }
    }
  }


  /**
  * This takes an Omeka_Record instance and returns a populated
  * Apache_Solr_Document.
  *
  * @param Omeka_Record $item The record to index.
  *
  * @return Apache_Solr_Document
  * @author Eric Rochester <erochest@virginia.edu>
  **/
  public static function itemToDocument($item)
  {

    $fields = get_db()->getTable('SolrSearchField');

    $doc = new Apache_Solr_Document();
    $doc->setField('id', "Item_{$item->id}");
    $doc->setField('resulttype', 'Item');
    $doc->setField('model', 'Item');
    $doc->setField('modelid', $item->id);

    // extend $doc to to include and items public / private status
    $doc->setField('public', $item->public);

    // Title:
    $title = metadata($item, array('Dublin Core', 'Title'));
    $doc->setField('title', $title);

    // Elements:

    foreach ($item->getFiles() as $file) {
      if ($file->getExtension() == 'xml') {

      // Load TEI file again as object
        $xml = simplexml_load_file("http://lonnrot,finlit.fi/omeka/files/original/".metadata($file,'filename'));

        // Create new Solr search field from writing location element for indexing
        $locField = new SolrSearchField();
        $locField->slug = 70; // needed for indexing key below
        $locField->is_indexed = 1; // field is indexed
        $locField->is_facet = 0; // field is not facet
        $locField->text = (string)$xml->text->body->div->opener->dateline->placeName; //field text value
        $doc->setMultiValue($locField->indexKey(), $locField->text); //append to Solr search document

        // Create new Solr search field for letter recipient element for indexing
        $rcField = new SolrSearchField();

        $rcField->slug = 75; // slug for indexing key below
        $rcField->is_indexed = 1; // field is indexed
        $rcField->is_facet = 0; // field is not facet
        // field text value
        $rcField->text = (string)$xml->teiHeader->fileDesc->sourceDesc->msDesc->msContents->msItem[0]->title->surname.
        ", ".(string)$xml->teiHeader->fileDesc->sourceDesc->msDesc->msContents->msItem[0]->title->forename;

        $doc->setMultiValue($rcField->indexKey(), $rcField->text); //append to Solr search document

      }
    }

    self::indexItem($fields, $item, $doc);

    // Tags:
    foreach ($item->getTags() as $tag) {
      $doc->setMultiValue('tag', $tag->name);
    }

    // Collection:
    if ($collection = $item->getCollection()) {
      $doc->collection = metadata($collection, array('Dublin Core', 'Title')
    );
  }

  // Item type:
  if ($itemType = $item->getItemType()) {
    $doc->itemtype = $itemType->name;
  }

  $doc->featured = (bool) $item->featured;

  // File metadata
  foreach ($item->getFiles() as $file) {
    self::indexItem($fields, $file, $doc);
  }
  return $doc;

}


/**
* This returns the URI for an Omeka_Record.
*
* @param Omeka_Record $record The record to return the URI for.
*
* @return string $uri The URI to access the record with.
* @author Eric Rochester <erochest@virginia.edu>
**/
public static function getUri($record)
{
  $uri    = '';
  $action = 'show';
  $rc     = get_class($record);

  if ($rc === 'SimplePagesPage') {
    $uri = url($record->slug);
  }

  else if ($rc === 'ExhibitPage') {

    $exhibit = $record->getExhibit();
    $exUri   = self::getSlugUri($exhibit, $action);
    $uri     = "$exUri/$record->slug";

  } else if (property_exists($record, 'slug')) {
    $uri = self::getSlugUri($record, $action);
  } else {
    $uri = record_url($record, $action);
  }

  // Always index public URLs.
  $uri = preg_replace('|/admin/|', '/', $uri, 1);

  return $uri;
}


/**
* This returns the URL for an Omeka_Record with a 'slug' property.
*
* @param Omeka_Record $record The sluggable record to create the URL for.
* @param string       $action The action to access the record with.
*
* @return string $uri The URI for the record.
* @author Eric Rochester <erochest@virginia.edu>
**/
public static function getSlugURI($record, $action)
{
  // Copied from omeka/applications/helpers/UrlFunctions.php, record_uri.
  // Yuck.
  $recordClass = get_class($record);
  $inflector   = new Zend_Filter_Word_CamelCaseToDash();
  $controller  = strtolower($inflector->filter($recordClass));
  $controller  = Inflector::pluralize($controller);
  $options     = array(
    'controller' => $controller,
    'action'     => $action,
    'id'         => $record->slug
  );
  $uri = url($options, 'id');

  return $uri;
}


/**
* This pings the Solr server with the given options and returns true if
* it's currently up.
*
* @param array $options The configuration to test. Missing values will be
* pulled from the current set of options.
*
* @return bool
* @author Eric Rochester <erochest@virginia.edu>
*/
public static function pingSolrServer($options=array())
{
  try {
    return self::connect($options)->ping();
  } catch (Exception $e) {
    return false;
  }
}


/**
* This re-indexes everything in the Omeka DB.
*
* @return void
* @author Eric Rochester
**/
public static function indexAll($options=array())
{

  $solr = self::connect($options);

  $db     = get_db();
  $table  = $db->getTable('Item');
  $select = $table->getSelect();

  // Removed in order to index both public and private items
  // $table->filterByPublic($select, true);
  $table->applySorting($select, 'id', 'ASC');

  $excTable = $db->getTable('SolrSearchExclude');
  $excludes = array();
  foreach ($excTable->findAll() as $e) {
    $excludes[] = $e->collection_id;
  }
  if (!empty($excludes)) {
    $select->where(
    'collection_id IS NULL OR collection_id NOT IN (?)',
    $excludes);
  }

  // First get the items.
  $pager = new SolrSearch_DbPager($db, $table, $select);
  while ($items = $pager->next()) {
    foreach ($items as $item) {
      $docs = array();
      $doc = self::itemToDocument($item);
      $docs[] = $doc;
      $solr->addDocuments($docs);
    }
    $solr->commit();
  }

  // Now the other addon stuff.
  $mgr  = new SolrSearch_Addon_Manager($db);
  $docs = $mgr->reindexAddons();
  $solr->addDocuments($docs);
  $solr->commit();

  $solr->optimize();

}


/**
* This deletes everything in the Solr index.
*
* @param array $options The configuration to test. Missing values will be
* pulled from the current set of options.
*
* @return void
* @author Eric Rochester
**/
public static function deleteAll($options=array())
{

  $solr = self::connect($options);

  $solr->deleteByQuery('*:*');
  $solr->commit();
  $solr->optimize();

}


}
