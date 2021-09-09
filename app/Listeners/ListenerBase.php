<?php 
namespace MediaLocation\Listeners;

use MediaLocation\Settings\SettingsRepository;

/**
* Base Form Handler Class
*/
abstract class ListenerBase 
{
	/**
	* Nonce
	* @var string
	*/
	protected $nonce;

	/**
	* Form Data
	* @var array
	*/
	protected $data;

	/**
	* Response
	* @var array;
	*/
	protected $response;

	/**
	* Settings Repo
	* @var object;
	*/
	protected $settings;


	public function __construct()
	{
		$this->settings = new SettingsRepository;
		$this->setData();
		$this->validateNonce();
	}

	/**
	* Set the Form Data
	*/
	protected function setData()
	{
		$this->nonce = sanitize_text_field($_POST['nonce']);
		$data = [];
		foreach( $_POST as $key => $value ){
			$data[$key] = $value;
		}
		$this->data = $data;
	}

	/**
	* Validate the Nonce
	*/
	protected function validateNonce()
	{
		if ( !wp_verify_nonce( $this->nonce, 'media-location-nonce' ) ){
			$this->response = ['status' => 'error', 'message' => __('Invalid Nonce', 'media-location')];
			$this->respond();
			die();
		}
	}

	/**
	* Return Response
	*/
	protected function respond()
	{
		return wp_send_json($this->response);
	}
}