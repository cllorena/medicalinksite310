<?php
if( !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

/**
 * Abstract class for extended plugins
 * This class provides some standard methods that can implemented to add features into the VM core
 *
 *
 * @package	VirtueMart
 * @subpackage Plugins
 * @author Christopher Roussel, Max Milbers
 * @link https://virtuemart.net
 * @copyright Copyright (c) 2011 - 2021 VirtueMart Team. All rights reserved.
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */


abstract class vmExtendedPlugin extends vmPlugin {
	/**
	 * @var string path to this plugin's directory
	 * @access protected
	 */
	//abstract protected $_path = '';
	protected $_path = '';

	/**
	 * @var string plugin name
	 * @access private
	 */
	//protected $_name = '';
	public $_name = '';

	/**
	 * Method to get the plugin name
	 *
	 * The plugin name parsed using the classname
	 * (adapted from Joomla's JModel)
	 *
	 * @return	string The name of the plugin
	 */
	protected function getName() {
		$name = $this->_name;

		if (empty($name)) {
			$r = null;
			preg_match('/VmExtended(.*)/i', get_class($this), $r);
			$name = (empty($r)) ? '' : strtolower($r[1]);
			$this->_name = $name;
		}

		return $name;
	}

	/**
	 * Constructor
	 *
	 * @param object $subject The object to observe
	 * @param array  $config  An array that holds the plugin configuration
	 */
	public function __construct (&$subject, $config=array()) {
		parent::__construct($subject, $config);
		$this->_path = VMPATH_ROOT .'/plugins/'. $this->getName();

		//$lang = vmLanguage::getLanguage();
		//$lang->load('plg_vmextended_'.$this->getName(),JPATH_ADMINISTRATOR);

	}

	/**
	 * Plugs into the backend controller logic to insert a custom controller into the VM component space
	 * This means that links can be constructed as index.php?option=com_virtuemart&view=myaddon and work
	 *
	 * @param string $controller Name of controller requested
	 * @return True if this loads a file (null otherwise)
	 */
	public function onVmAdminController ($controller) { return null; }
/*		example:
		if ($controller = 'myplug') {
			require_once($this->_path .'/controllers/myplug_admin.php');
			return true;
		}*/


	/**
	 * Plugs into the frontend controller logic to insert a custom controller into the VM component space
	 * This means that links can be constructed as index.php?option=com_virtuemart&view=myaddon and work
	 *
	 * @param string $controller Name of controller requested
	 * @return True if this loads a file (null otherwise)
	 */
	public function onVmSiteController ($controller) { return null; }
/*		example:
		if ($controller = 'myplug') {
			require_once($this->_path .'/controllers/myplug.php');
			return true;
		}*/

	/**
	 * Plugs into the updater model to remove additional VM data (useful if the plugin depends on fields in a VM table)
	 *
	 * @param object $updater VirtueMartModelUpdatesMigration object
	 */
	public function onVmSqlRemove (&$updater) { return null; }
/*		example:
		$filename = $this->_path .'/install/uninstall_required_data.sql';
		$updater->execSQLFile($filename);*/

	/**
	 * Plugs into the updater model to reinstall additional VM data (useful if the plugin depends on fields in a VM table)
	 *
	 * @param object $updater VirtueMartModelUpdatesMigration object
	 */
	public function onVmSqlRestore (&$updater) { return null; }
/*		example:
		$filename = $this->_path .'/install/install_required_data.sql';
		$updater->execSQLFile($filename);*/

}