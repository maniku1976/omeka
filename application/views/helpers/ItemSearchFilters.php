<?php
/**
 * Omeka
 *
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * Show the currently-active filters for a search/browse.
 *
 * @package Omeka\View\Helper
 */
class Omeka_View_Helper_ItemSearchFilters extends Zend_View_Helper_Abstract
{
    /**
     * Get a list of the currently-active filters for item browse/search.
     *
     * @param array $params Optional array of key-value pairs display:inline-block;to use instead of
     *  reading the current params from the request.
     * @return string HTML output
     */
    public function itemSearchFilters(array $params = null)
    {
        if ($params === null) {
            $request = Zend_Controller_Front::getInstance()->getRequest();
            $requestArray = $request->getParams();
        } else {
            $requestArray = $params;
        }

        $db = get_db();
        $displayArray = array();
        foreach ($requestArray as $key => $value) {
            if($value != null) {
                $filter = ucfirst($key);
                $displayValue = null;
                switch ($key) {
                    case 'type':
                        $filter = 'Item Type';
                        $itemType = $db->getTable('ItemType')->find($value);
                        if ($itemType) {
                            $displayValue = $itemType->name;
                        }
                        break;

                    case 'collection':
                        $collection = $db->getTable('Collection')->find($value);
                        if ($collection) {
                            $title = metadata($collection, array('Dublin Core', 'Title'), array('no_escape' => true));
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
                              case "Lönnrot to Borg":
                                $title = __('Lönnrot to Borg');
                                break;
                              case "Lönnrot to Cajan":
                                $title = __('Lönnrot to Cajan');
                                break;
                              case "Lönnrot to Europaeus":
                                $title = __('Lönnrot to Europaeus');
                                break;
                              case "Lönnrot to Ilmoni":
                                $title = __('Lönnrot to Ilmoni');
                                break;
                              case "Lönnrot to Ticklén":
                                $title = __('Lönnrot to Ticklén');
                                break;
                              case "Lönnrot to Warelius":
                                $title = __('Lönnrot to Warelius');
                                break;  
                            }
                            $displayValue = strip_formatting($title);
                        }
                        break;

                    case 'user':
                        $user = $db->getTable('User')->find($value);
                        if ($user) {
                            $displayValue = $user->name;
                        }
                        break;

                    case 'public':
                    case 'featured':
                        $displayValue = ($value == 1 ? __('Yes') : $displayValue = __('No'));
                        break;

                    case 'search':
                    case 'tags':
                    case 'range':
                        $displayValue = $value;
                        break;
                }
                if ($displayValue) {
                    $displayArray[$filter] = $displayValue;
                }
            }
        }

        $displayArray = apply_filters('item_search_filters', $displayArray, array('request_array' => $requestArray));
        // Advanced needs a separate array from $displayValue because it's
        // possible for "Specific Fields" to have multiple values due to
        // the ability to add fields.
        if(array_key_exists('advanced', $requestArray)) {
            $advancedArray = array();
            foreach ($requestArray['advanced'] as $i => $row) {
                if (!$row['element_id'] || !$row['type']) {
                    continue;
                }
                $elementID = $row['element_id'];
                $elementDb = $db->getTable('Element')->find($elementID);
                $element = __($elementDb->name);
                if ($element == __('Title')) {
                  $element = __('Recipient');
                }
                $type = __($row['type']);
                $advancedValue = $element . ' ' . $type;
                if (isset($row['terms'])) {
                    $advancedValue .= ' "' . $row['terms'] . '"';
                }
                $advancedArray[$i] = $advancedValue;
            }
        }

        $html = '';
        if (!empty($displayArray) || !empty($advancedArray)) {
            $html .= '<span id="item-filters" style="float:left;display:inline;">';
            $html .= '<ul>';
            foreach($displayArray as $name => $query) {
                $class = html_escape(strtolower(str_replace(' ', '-', $name)));
                $html .= '<li class="' . $class . '">' . html_escape(__($name)) . ': ' . html_escape($query) . '</li>';
            }
            if(!empty($advancedArray)) {
                foreach($advancedArray as $j => $advanced) {
                    $html .= '<li class="advanced">' . html_escape($advanced) . '</li>';
                }
            }
            $html .= '</ul>';
            $html .= '</span>';
        }
        return $html;
    }
}
