<?php
/**
*
* Controller for the front end Manufacturerviews
*
* @package	VirtueMart
* @subpackage User
* @author Max Milbers, Stan
* @link https://virtuemart.net
* @copyright Copyright (c) 2004 - 2020 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: manufacturer.php 2420 2010-06-01 21:12:57Z oscar $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * VirtueMart Component Controller
 *
 * @package		VirtueMart
 */
class VirtueMartControllerVendor extends JControllerLegacy
{

	/**
	* Send the ask question email.
	* @author Kohl Patrick, Christopher Roussel
	*/
	public function mailAskquestion () {

		vRequest::vmCheckToken();

		$model = VmModel::getModel('vendor');
		$mainframe = JFactory::getApplication();
		$vars = array();
		$min = VmConfig::get('asks_minimum_comment_length', 50)+1;
		$max = VmConfig::get('asks_maximum_comment_length', 2000)-1 ;
		$commentSize = vRequest::getString ('comment');
		if (function_exists('mb_strlen')) {
			$commentSize =  mb_strlen($commentSize);
		} else {
			$commentSize =  strlen($commentSize);
		}

		$validMail = filter_var(vRequest::getVar('email'), FILTER_VALIDATE_EMAIL);

		$virtuemart_vendor_id = vRequest::getInt('virtuemart_vendor_id',1);

		$userId = VirtueMartModelVendor::getUserIdByVendorId($virtuemart_vendor_id);

		//$vendorUser = JFactory::getUser($userId);

		if ( $commentSize<$min || $commentSize>$max || !$validMail ) {
			vmWarn('COM_VIRTUEMART_COMMENT_NOT_VALID_JS');
			$this->setRedirect(JRoute::_ ( 'index.php?option=com_virtuemart&view=vendor&task=contact&virtuemart_vendor_id=' . $virtuemart_vendor_id , FALSE));
			return ;
		}

		$user = JFactory::getUser();

		
		if(!$this->checkCaptcha( 'index.php?option=com_virtuemart&view=vendor&layout=contact&virtuemart_vendor_id=1' ) ){
				return ;
			}
		

		$fromMail = vRequest::getVar('email');	//is sanitized then
		$fromName = vRequest::getVar('name','');//is sanitized then
		$fromMail = str_replace(array('\'','"',',','%','*','/','\\','?','^','`','{','}','|','~'),array(''),$fromMail);
		$fromName = str_replace(array('\'','"',',','%','*','/','\\','?','^','`','{','}','|','~'),array(''),$fromName);
		if (!empty($user->id)) {
			if(empty($fromMail)){
				$fromMail = $user->email;
			}
			if(empty($fromName)){
				$fromName = $user->name;
			}
		}

		$vars['user'] = array('name' => $fromName, 'email' => $fromMail);

		$VendorEmail = $model->getVendorEmail($virtuemart_vendor_id);
		$vars['vendor'] = array('vendor_store_name' => $fromName );

		if (shopFunctionsF::renderMail('vendor', $VendorEmail, $vars,'vendor')) {
			$string = 'COM_VIRTUEMART_MAIL_SEND_SUCCESSFULLY';
		}
		else {
			$string = 'COM_VIRTUEMART_MAIL_NOT_SEND_SUCCESSFULLY';
		}
		$mainframe->enqueueMessage(vmText::_($string));

		// Display it all
		$view = $this->getView('vendor', 'html');

		$view->setLayout('mail_confirmed');
		$view->display();
	}

	/**
	 *
	 * @author Stan of RuposTel
	 *
	 */
	function checkCaptcha($retUrl){

		

			$msg = shopFunctionsF::checkCaptcha('ask_captcha');
			if($msg !== TRUE){
				vmWarn('PLG_RECAPTCHA_ERROR_INCORRECT_CAPTCHA_SOL');
				$this->setRedirect (JRoute::_ ($retUrl . '&captcha=1', FALSE) );
				return FALSE;
			} 
				
			return TRUE;
		
	}

}

// No closing tag
