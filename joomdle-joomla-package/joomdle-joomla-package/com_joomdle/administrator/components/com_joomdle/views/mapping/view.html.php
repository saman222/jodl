<?php
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

// no direct access
defined('_JEXEC') or die('Restricted access');
// Import Joomla! libraries
jimport( 'joomla.application.component.view');
require_once( JPATH_COMPONENT.'/helpers/content.php' );
require_once( JPATH_COMPONENT.'/helpers/mappings.php' );

class JoomdleViewMapping extends JViewLegacy {

    protected $form;

    protected $item;

    function display($tpl = null) {
	    global $mainframe, $option;

		$this->form         = $this->get('Form');
        $this->item         = $this->get('Item');

		$params = JComponentHelper::getParams( 'com_joomdle' );
		$additional_data_source = $params->get( 'additional_data_source' );

		if ($additional_data_source == 'no')
		{
			echo JText::_ ('COM_JOOMDLE_YOU_NEED_TO_SELECT_AN_ADDITIONAL_DATA_SOURCE');
			return;
		}

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
			JFactory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');
            return false;
        }

        parent::display($tpl);
		$this->addToolbar();

    }

	protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);

		JToolbarHelper::title(JText::_('COM_JOOMDLE_VIEW_MAPPINGS_TITLE'), 'mapping');
		JToolbarHelper::apply('mapping.apply');
		JToolbarHelper::save('mapping.save');

        if (empty($this->item->id))  {
            JToolbarHelper::cancel('mapping.cancel');
        } else {
            JToolbarHelper::cancel('mapping.cancel', 'JTOOLBAR_CLOSE');
        }
    }

}
?>
