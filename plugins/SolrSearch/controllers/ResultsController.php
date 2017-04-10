<?php

/**
* @package     omeka
* @subpackage  solr-search
* @copyright   2012 Rector and Board of Visitors, University of Virginia
* @license     http://www.apache.org/licenses/LICENSE-2.0.html
*/


class SolrSearch_ResultsController
extends Omeka_Controller_AbstractActionController
{


  /**
  * Cache the facets table.
  */
  public function init()
  {
    $this->_fields = $this->_helper->db->getTable('SolrSearchField');
  }


  /**
  * Intercept queries from the simple search form.
  */
  public function interceptorAction()
  {
    $this->_redirect('solr-search?'.http_build_query(array(
      'q' => $this->_request->getParam('query')
    )));
  }


  /**
  * Display Solr results.
  */
  public function indexAction()
  {

    // Get pagination settings.
    $limit = get_option('per_page_public');
    $page  = $this->_request->page ? $this->_request->page : 1;
    $start = ($page-1) * $limit;


    // determine whether to display private items or not
    // items will only be displayed if:
    // solr_search_display_private_items has been enabled in the Solr Search admin panel
    // user is logged in
    // user_role has sufficient permissions

    $user = current_user();
    if(get_option('solr_search_display_private_items')
    && $user
    && is_allowed('Items','showNotPublic')) {
      // limit to public items
      $limitToPublicItems = false;
    } else {
      $limitToPublicItems = true;
    }

    // Execute the query.
    $results = $this->_search($start, $limit, $limitToPublicItems);

    // Set the pagination.
    Zend_Registry::set('pagination', array(
      'page'          => $page,
      'total_results' => $results->response->numFound,
      'per_page'      => $limit
    ));

    // Push results to the view.
    $this->view->results = $results;

    // Modification: unpaginated results needed for zip files of TEI docs
    $allResults = $this->_search($start, $results->response->numFound, $limitToPublicItems);

    // Modification: if zip button is clicked in results view, create and download zip of TEI files
    if(isset($_POST['tei'])){
      $zip = new ZipArchive();
      $zip_name = "tei.zip";
      $zip->open(sys_get_temp_dir().'/'.$zip_name, ZipArchive::CREATE);

      // Loop through unpaginated search results, exclude Simple Pages results, fetch each item and copy their TEI files locally
      foreach ($allResults->response->docs as $doc) {
        if (strpos($doc->id, 'SimplePagesPage') === false) {
          $item = get_db()->getTable($doc->model)->find($doc->modelid);
          $xml = metadata($item, array('Item Type Metadata', 'XML File'));
          copy($xml, sys_get_temp_dir().'/'.basename($xml));
        }
      }

      // Add local copies of TEI files to zip
      foreach (glob(sys_get_temp_dir().'/*.xml') as $tei) {
        $zip->addFile($tei, basename($tei));
      }

      $zip->close();

      // Download zip file
      header('Content-Type: application/zip');
      header('Content-Disposition: attachment; filename='.sys_get_temp_dir().'/'.$zip_name);
      header('Content-Length: ' . filesize(sys_get_temp_dir().'/'.$zip_name));
      ob_clean();
      flush();
      readfile(sys_get_temp_dir().'/'.$zip_name);
      array_map('unlink', glob(sys_get_temp_dir().'/*.xml')); //delete TEI files from tmp folder after downloading zip
      unlink(sys_get_temp_dir().'/'.'tei.zip'); //delete tmp zip file after download
      exit();
    }

  }


  /**
  * Pass setting to Solr search
  *
  * @param int $offset Results offset
  * @param int $limit  Limit per page
  * @return SolrResultDoc Solr results
  */
  protected function _search($offset, $limit, $limitToPublicItems = true)
  {

    // Connect to Solr.
    $solr = SolrSearch_Helpers_Index::connect();

    // Get the parameters.
    $params = $this->_getParameters();

    // Construct the query.
    $query = $this->_getQuery($limitToPublicItems);

    // Execute the query.
    return $solr->search($query, $offset, $limit, $params);

  }


  /**
  * Form the complete Solr query.
  *
  * @return string The Solr query.
  */
  protected function _getQuery($limitToPublicItems = true)
  {

    // Get the `q` GET parameter.
    $query = $this->_request->q;

    // If defined, replace `:`; otherwise, revert to `*:*`.
    // Also, clean it up some.
    if (!empty($query)) {
      // For Swedish users: queries on document type (letter, draft etc)
      if ($query == 'brev') {
        $query = 'kirje';
      } else if (strpos($query, 'koncept') !== false) {
        $query = '*konsepti*';
      // Lönnrot's special characters. If query involves words that
      // are present in transcriptions both with and without special
      // character, construct OR query containing both alternatives
      } else if (strpos($query, 'ae') !== false) {
        $query1 = str_replace('ae', '\u00E6', $query);
        $query .= " OR {$query1}";
      } else if (strpos($query, 'c') !== false) {
        $query2 = str_replace('c', '\u00E7', $query);
        $query .= " OR {$query2}";
      } else if (strpos($query, 'e') !== false) {
        $query3 = str_replace('e', '\u00E9', $query);
        $query .= " OR {$query3}";
      } else if (strpos($query, 'ä') !== false) {
        $query4 = str_replace('ä', '\u00E6', $query);
        $query .= " OR {$query4}";
      }


      $query = str_replace(':', ' ', $query);
      $to_remove = array('[', ']');
      foreach ($to_remove as $c) {
        $query = str_replace($c, '', $query);
      }
    } else {
      $query = '*:*';
    }

    // Get the `facet` GET parameter
    $facet = $this->_request->facet;

    // Form the composite Solr query.
    // Add round brackets around query: needed when query involves special
    // characters, in order for it to be interpreted correctly.
    // '(a OR b) AND c' versus 'a OR b AND c'
    if (!empty($facet)) $query = "({$query})". " AND {$facet}";

    // Limit the query to public items if required
    /*if($limitToPublicItems) {
    $query .= ' AND public:"true"';
  }*/

  return $query;

}


/**
* Construct the Solr search parameters.
*
* @return array Array of fields to pass to Solr
*/
protected function _getParameters()
{

  // Get a list of active facets.
  $facets = $this->_fields->getActiveFacetKeys();

  return array(

    'facet'               => 'true',
    'facet.field'         => $facets,
    'facet.mincount'      => 1,
    'facet.limit'         => get_option('solr_search_facet_limit'),
    'facet.sort'          => get_option('solr_search_facet_sort'),
    'hl'                  => get_option('solr_search_hl')?'true':'false',
    'hl.snippets'         => get_option('solr_search_hl_snippets'),
    'hl.fragsize'         => get_option('solr_search_hl_fragsize'),
    'hl.maxAnalyzedChars' => get_option('solr_search_hl_max_analyzed_chars'),
    'hl.fl'               => '*_t'

  );

}


}
