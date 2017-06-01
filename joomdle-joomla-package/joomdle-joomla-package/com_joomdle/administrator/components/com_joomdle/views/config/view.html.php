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
class JoomdleViewConfig extends JViewLegacy {
    function display($tpl = null) {

		$form   = $this->get('Form');
        $data   = $this->get('Data');
        $user = JFactory::getUser();

        // Check for model errors.
        if ($errors = $this->get('Errors')) {
			JFactory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');
            return false;
        }

        // Bind the form to the data.
        if ($form && $data) {
            $form->bind($data);
        }

		$this->form   = &$form;

        $this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

	protected function addToolbar()
    {
        JToolbarHelper::title(JText::_('COM_JOOMDLE_VIEW_MAILINGLIST_TITLE_CONFIGURATION'), 'config.png');
        JToolbarHelper::apply('config.apply');
        JToolbarHelper::save('config.save');
        JToolbarHelper::cancel('config.cancel');

		JHtmlSidebar::setAction('index.php?option=com_joomdle&view=courseapplications');
    }

}
?>
