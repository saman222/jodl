<?php
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once(JPATH_ADMINISTRATOR.'/components/com_joomdle/helpers/content.php');
require_once(JPATH_ADMINISTRATOR.'/components/com_joomdle/helpers/parents.php');
require_once(JPATH_ADMINISTRATOR.'/components/com_joomdle/helpers/shop.php');
require_once(JPATH_ADMINISTRATOR.'/components/com_joomdle/helpers/applications.php');
require_once(JPATH_ADMINISTRATOR.'/components/com_joomdle/helpers/mappings.php');
require_once(JPATH_ADMINISTRATOR.'/components/com_joomdle/helpers/system.php');
require_once(JPATH_ADMINISTRATOR.'/components/com_joomdle/helpers/profiletypes.php');

/**
 * Joomdle Component Controller
 */
class JoomdleController extends JControllerLegacy {

	function display ($cachable = false, $urlparams = false) 
	{
		//document object
		$jdoc = JFactory::getDocument();
		//add the stylesheet
		$jdoc->addStyleSheet(JURI::root ().'components/com_joomdle/css/joomdle.css');

		// Make sure we have a default view
		if (JFactory::getApplication()->input->get('view') == '') {
			JFactory::getApplication()->input->set('view', 'joomdle');
		}

		$mainframe =JFactory::getApplication();
		$document  =JFactory::getDocument();
		$pathway   = $mainframe->getPathway();

		parent::display();
	}

	/* User enrols manually from Joomla */
	function enrol () 
	{
		$mainframe = JFactory::getApplication();

		$user = JFactory::getUser();

		$course_id = $this->input->get('course_id');
		$course_id = (int) $course_id;

		$login_url = JoomdleHelperMappings::get_login_url ($course_id);
		if (!$user->id)
			$mainframe->redirect($login_url);

		$params =$mainframe->getParams();

		/* Check that self enrolments are OK in course */
		$enrol_methods = JoomdleHelperContent::call_method ('course_enrol_methods', $course_id);
		$self_ok = false;
		foreach ($enrol_methods as $method)
		{
			if ($method['enrol'] == 'self')
			{
				$self_ok = true;
				break;
			}
		}

		if (!$self_ok)
		{
			$url = JRoute::_ ("index.php?option=com_joomdle&view=detail&course_id=$course_id");
			$message = JText::_( 'COM_JOOMDLE_SELF_ENROLMENT_NOT_PERMITTED' );
			$this->setRedirect($url, $message);
			return;
		}

		$user = JFactory::getUser();
		$username = $user->get('username');
		JoomdleHelperContent::enrolUser ($username, $course_id);

		// Redirect to course
		$url = JoomdleHelperContent::get_course_url ($course_id);
		$mainframe->redirect ($url);
	}

	function applicate () 
	{
		$mainframe = JFactory::getApplication();

		$params =$mainframe->getParams();
		$show_motivation = $params->get( 'show_detail_application_motivation', 'no' );
		$show_experience = $params->get( 'show_detail_application_experience', 'no' );

		$user = JFactory::getUser();

		$course_id = $this->input->get('course_id');
		$course_id = (int) $course_id;

		$login_url = JoomdleHelperMappings::get_login_url ($course_id);
		if (!$user->id)
			$mainframe->redirect($login_url);

		$motivation = $this->input->get('motivation');
		$experience = $this->input->get('cexperienceourse_id');

		$message = '';
		if (($show_motivation == 'mandatory') && (!$motivation))
		{
			$url = JRoute::_ ("index.php?option=com_joomdle&view=detail&course_id=$course_id");
			$message = JText::_( 'COM_JOOMDLE_MOTIVATION_MISSING' );
			$this->setRedirect($url, $message);
			return;
		}
		if (($show_experience == 'mandatory') && (!$experience))
		{
			$url = JRoute::_ ("index.php?option=com_joomdle&view=detail&course_id=$course_id");
			$message = JText::_( 'COM_JOOMDLE_EXPERIENCE_MISSING' );
			$this->setRedirect($url, $message);
			return;
		}

		$user = JFactory::getUser();
		$username = $user->get('username');

		$message = JText::_( 'COM_JOOMDLE_MAX_APPLICATIONS_REACHED' );
		if (!JoomdleHelperApplications::user_can_applicate ($user->id, $course_id, $message))
		{
			$url = JRoute::_ ("index.php?option=com_joomdle&view=detail&course_id=$course_id");
			$this->setRedirect($url, $message);
			return;
		}

		if (JoomdleHelperApplications::applicate_for_course ($username, $course_id, $motivation, $experience))
		{
			// Redirect to course detail page by default
			$url = JRoute::_ ("index.php?option=com_joomdle&view=detail&course_id=$course_id");
			$message = JText::_( 'COM_JOOMDLE_APPLICATION_FOR_COURSE_DONE' );

			// Get custom redirect url and message
			$additional_message = '';
			$new_url = '';
			$app                = JFactory::getApplication();
			$results = $app->triggerEvent('onCourseApplicationDone', array($course_id, $user->id, &$additional_message, &$new_url));

			if ($additional_message)
				$message .= '<br>' . $additional_message;
			if ($new_url)
				$url = $new_url;
		}
		else {
			$url = JRoute::_ ("index.php?option=com_joomdle&view=detail&course_id=$course_id");
			$message = JText::_( 'COM_JOOMDLE_APPLICATION_FOR_COURSE_ALREADY_DONE' );
		}

		$this->setRedirect($url, $message);
	}


	function assigncourses ()
	{
		$children = $this->input->get('children', array (), 'array');

		if (!JoomdleHelperParents::check_assign_availability ($children))
		{
			$message = JText::_( 'COM_JOOMDLE_NOT_ENOUGH_COURSES' );
			$this->setRedirect('index.php?option=com_joomdle&view=assigncourses', $message); //XXX poenr un get current uri
		}
		else
		{
			JoomdleHelperParents::assign_courses ($children);
			$message = JText::_( 'COM_JOOMDLE_COURSES_ASSIGNED' );
			$this->setRedirect('index.php?option=com_joomdle&view=assigncourses', $message); //XXX poenr un get current uri
		}
	}

	function register_save ()
	{
		$otherlanguage = JFactory::getLanguage();
		$otherlanguage->load( 'com_user', JPATH_SITE );

		$usersConfig =JComponentHelper::getParams( 'com_users' );
		if ($usersConfig->get('allowUserRegistration') == '0') {
                $error = JText::_( 'JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN' );
                JFactory::getApplication()->enqueueMessage($error, 'error');
				return;
		}

		$authorize      = JFactory::getACL();
		$user = new JUser ();

		$system = 2; // ID of Registered
		$user->groups = array ();
		$user->groups[] = $system;


		// Bind the post array to the user object
		$post = $this->input->post->getArray();

		if (!$user->bind( $post, 'usertype' )) {
                JFactory::getApplication()->enqueueMessage($user->getError(), 'error');
                return;

		}

		// Set some initial user values
		$user->set('id', 0);

		$date = JFactory::getDate();
		$user->set('registerDate', $date->toSql());

		$parent = JFactory::getUser();
		$user->setParam('u'.$parent->id.'_parent_id', $parent->id);

		// If user activation is turned on, we need to set the activation information
		$useractivation = $usersConfig->get( 'useractivation' );
		if (($useractivation == 1) || ($useractivation == 2))
		{
				jimport('joomla.user.helper');
				$user->set('activation', JApplication::getHash( JUserHelper::genRandomPassword()) );
				$user->set('block', '1');
		}

		// If there was an error with registration, set the message and display form
		if ( !$user->save() )
		{
                $error = JText::_( $user->getError() );
                JFactory::getApplication()->enqueueMessage($error, 'error');
				$this->setRedirect('index.php?option=com_joomdle&view=register');
				return false;
		}

		// Add to profile type if needed
		$params =JComponentHelper::getParams( 'com_joomdle' );
		$children_pt = $params->get('children_profiletype');
		if ($children_pt)
		{
			JoomdleHelperProfiletypes::add_user_to_profile ($user->id, $children_pt);
		}

		// Send registration confirmation mail
		$course_id = $this->input->get('password', '');
		$password = preg_replace('/[\x00-\x1F\x7F]/', '', $password); //Disallow control chars in the email

		JoomdleHelperSystem::send_registration_email ($user->username, $password);


		$parent_user   = JFactory::getUser();
		// Set parent role in Moodle
		JoomdleHelperContent::call_method ("add_parent_role", $user->username, $parent_user->username);

		$message = JText::_( 'COM_JOOMDLE_USER_CREATED' );
		$this->setRedirect('index.php?option=com_joomdle&view=register', $message); //XXX poenr un get current uri
	}

	function login ()
	{
		$mainframe = JFactory::getApplication();

		$params =$mainframe->getParams();
		$moodle_url = $params->get( 'MOODLE_URL' );

		$login_data = $this->input->get('data', '', 'string');
		$wantsurl = $this->input->get('wantsurl', '', 'string');

		if (!$login_data)
		{
			echo "Login error";
			exit ();
		}

		$data = base64_decode ($login_data);

		$fields = explode (':', $data);

		$credentials['username'] = $fields[0];
		$credentials['password'] = $fields[1];

		$options = array ('skip_joomdlehooks' => '1');

		$mainframe->login($credentials, $options);

		if (!$wantsurl)
			$wantsurl = $moodle_url;
		$mainframe->redirect( $wantsurl );

	}

	/* User unenrols manually from Joomla */
	function unenrol () 
	{
		$mainframe = JFactory::getApplication();

		$user = JFactory::getUser();

		$course_id = $this->input->get('course_id');
		$course_id = (int) $course_id;

		$login_url = JoomdleHelperMappings::get_login_url ($course_id);
		if (!$user->id)
			$mainframe->redirect($login_url);

		$params =$mainframe->getParams();

		$user = JFactory::getUser();
		$username = $user->username;
		JoomdleHelperContent::call_method ('unenrol_user', $username, $course_id);

		// Redirect to caller URI
		$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
		$mainframe->redirect ($url);
	}
}
?>
