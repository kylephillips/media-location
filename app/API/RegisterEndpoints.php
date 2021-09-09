<?php
namespace MediaLocation\API;

use MediaLocation\Repositories\AttachmentRepository;

class RegisterEndpoints
{
	public function __construct()
	{
		add_action( 'rest_api_init', [$this, 'registerRoutes']);
	}

	public function registerRoutes()
	{
		register_rest_route( 'media-location/v1', '/attachment/', [
			'methods'  => 'GET',
			'callback' => [$this, 'attachment'],
			'permission_callback' => '__return_true'
		]);
	}

	/**
	* Get attachment details, including our custom meta
	*/
	public function attachment(\WP_REST_Request $request)
	{
		try {
			$params = $request->get_query_params();
			if ( !isset($params['id']) ) throw new \Exception('An attachment ID was not provided');
			return (new AttachmentRepository)->getAttachment($params['id']);
		} catch ( \Exception $e ){
			return [
				'status' => 'error',
				'message' => $e->getMessage()
			];
		}
	}
}