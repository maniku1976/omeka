<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * XSLT stylesheets controller.
 *
 * @package     omeka
 * @subpackage  teidisplay
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


class TeiDisplay_StylesheetsController extends
    Omeka_Controller_AbstractActionController
{

    /**
     * Get tables, set constants.
     *
     * @return void
     */
    public function init()
    {
        $modelName = 'TeiDisplayStylesheet';
        $this->_helper->db->setDefaultModelName($modelName);
        $this->_table = $this->_helper->db->getTable($modelName);
        $this->_browseRecordsPerPage = get_option('per_page_admin');
    }

    /**
     * Create stylesheet.
     *
     * @return void
     */
    public function addAction()
    {

        // Create record and form.
        $stylesheet = new TeiDisplayStylesheet;
        $form = $this->_getForm($stylesheet);
        $this->view->form = $form;

        if ($this->_request->isPost()) {

            // Validate the form.
            if ($form->isValid($this->_request->getPost())) {

                // Save and redirect.
                $stylesheet->saveForm($form);
                $this->_redirect('tei/stylesheets');

            }

        }

    }

    /**
     * Edit stylesheet.
     *
     * @return void
     */
    public function editAction()
    {

        // Get the stylesheet and form.
        $stylesheet = $this->_helper->db->findById();
        $form = $this->_getForm($stylesheet);
        $this->view->form = $form;

        if ($this->_request->isPost()) {

            // Validate the form.
            if ($form->isValid($this->_request->getPost())) {

                // Save and redirect.
                $stylesheet->saveForm($form);
                $this->_redirect('tei/stylesheets');

            }

        }

    }

    /**
     * Set add success message.
     */
    protected function _getAddSuccessMessage($stylesheet)
    {
        return __('The stylesheet "%s" was successfully added!',
            $stylesheet->title);
    }

    /**
     * Set edit success message.
     */
    protected function _getEditSuccessMessage($stylesheet)
    {
        return __('The stylesheet "%s" was successfully changed!',
            $stylesheet->title);
    }

    /**
     * Set delete success message.
     */
    protected function _getDeleteSuccessMessage($stylesheet)
    {
        return __('The stylesheet "%s" was successfully deleted!',
            $stylesheet->title);
    }

    /**
     * Set delete confirm message.
     */
    protected function _getDeleteConfirmMessage($stylesheet)
    {
        return __('This will delete the stylesheet "%s".',
            $stylesheet->title);
    }

    /**
     * Construct the add/edit form.
     */
    private function _getForm(TeiDisplayStylesheet $stylesheet)
    {

        // Build the form.
        $form = new TeiDisplay_Form_Stylesheet(array(
            'stylesheet' => $stylesheet));

        // Set the transfer adapter.
        $form->getElement('xslt')->setTransferAdapter(
            Zend_Registry::get('adapter'));

        return $form;

    }

}
