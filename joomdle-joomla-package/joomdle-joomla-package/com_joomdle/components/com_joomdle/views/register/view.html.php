<?php
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Registration component
 *
 * @package		Joomla
 * @subpackage	Registration
 * @since 1.0
 */
class JoomdleViewRegister extends JViewLegacy
{
	function display($tpl = null)
	{

		// Check if registration is allowed
		$usersConfig =JComponentHelper::getParams( 'com_users' );
		if (!$usersConfig->get( 'allowUserRegistration' )) {
			echo JText::_ ('COM_JOOMDLE_USER_REGISTRATION_DISABLED');
			return;
		}

		$app                = JFactory::getApplication();
		$pathway =$app->getPathWay();
		$document = JFactory::getDocument();

		$params = $app->getParams();

	 	// Page Title
		$app        = JFactory::getApplication();
		$menus      = $app->getMenu();
		$menu	= $menus->getActive();

		$params->set('page_title',	JText::_( 'COM_JOOMDLE_CHILDREN_REGISRATION' ));
		$document->setTitle( $params->get( 'page_title' ) );

		$pathway->addItem( JText::_( 'New' ));

		// Load the form validation behavior
		JHTML::_('behavior.formvalidation');

		$user = new JUser ();
		$this->assignRef('user', $user);
		$this->assignRef('params',		$params);
		parent::display($tpl);
	}
}
