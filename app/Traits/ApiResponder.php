<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait ApiResponder
{

    protected $statusCode = 200;
    protected $success = 1;
    protected $failure = 0;

    public function __construct()
    {
        //$this->acceptLanguage('ar')) .. try witjout ac lang in header
        $lang= request()->server('HTTP_ACCEPT_LANGUAGE');
        App::setLocale($lang);
    }

    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getSuccess()
    {
        return $this->success;
    }
    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     * Setter for statusCode
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    protected function respond($data, $headers = [])
    {
        return response()->json($data, 200, $headers);
    }

    public function successStatus($message = null )
    {
        return $this->respond([
            'status' => $this->getSuccess(),
            'data' => [],
            'code' => $this->getStatusCode(),
            'message' => $message ?? __('msg.successStatus'),
        ]);
    }
    public function errorStatus($message = null )
    {
        return $this->respond([
            'status' => $this->getFailure(),
            'data' => [],
            'code' => $this->setStatusCode(404)->getStatusCode(),
            'message' => $message ?? __('msg.errorStatus'),
        ]);
    }

    public function notAllowedStatus($message = null )
    {
        return $this->respond([
            'status' => $this->getFailure(),
            'data' => [],
            'code' => $this->setStatusCode(405)->getStatusCode(),
            'message' => $message ?? __('msg.errorStatus'),
        ]);
    }


    public function respondWithItem($item, $message = null )
    {
        return $this->respond([
            'status' => $this->getSuccess(),
            'data' => [$item],
            'code' => $this->getStatusCode(),
            'message' => $message ??  __('msg.resourceMsg'),

        ]);
    }
    public function respondUser($status = 1, $message = null , $is_user_found = true, $item)
    {
        return $this->respond([
            'status' => $status,
            'message' => $message ?? __('msg.resourceMsg'),
            'is_user_found' => $is_user_found,
            'data' => [$item],

        ]);
    }


    public function respondWithCollection($collection, $message =  null)
    {
        return $this->respond([
            'status' => $this->getSuccess(),
            'data' => $collection,
            'code' => $this->getStatusCode(),
            'message' => $message ?? __('msg.successStatus'),

        ]);
    }


    public function respondWithMessage($message)
    {
        return $this->setStatusCode(200)
            ->respond([
                'status' => $this->getSuccess(),
                'data' => [],
                'code' => $this->getStatusCode(),
                'message' => $message
            ]);
    }

    public function respondNoContent($message = null )
    {
        return $this->setStatusCode(204)
            ->respond([
                'status' => $this->getSuccess(),
                'data' => [],
                'code' => $this->getStatusCode(),
                'message' => $message ?? __('msg.respondNoContent'),
            ]);
    }

    public function respondCreated($data, $message = null)
    {
        return $this->setStatusCode(201)
            ->respond([
                'status' => $this->getSuccess(),
                'data' => [$data],
                'code' => $this->getStatusCode(),
                'message' => $message ?? __('msg.respondCreated'),
            ]);
    }

    protected function respondWithError($message)
    {
        if (is_array($message)) {
            $message = [
                'errors' => [$message]
            ];
        }

        return $this->respond([
            'status' => 0,
            'data' => [],
            'code' => $this->getStatusCode(),
            'message' => $message
        ]);
    }

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorForbidden($message = null)
    {
        return $this->setStatusCode(403)
            ->respondWithError($message ?? __('msg.errorForbidden'));
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorInternalError($message = null)
    {
        return $this->setStatusCode(500)
            ->respondWithError($message ?? __('msg.errorInternalError'));
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorNotFound($message = null )
    {
        return $this->setStatusCode(404)
            ->respondWithError($message ?? __('msg.errorNotFound'));
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorUnauthorized($message = null)
    {
        return $this->setStatusCode(401)
            ->respondWithError($message ?? __('msg.errorUnauthorized'));
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorUnauthenticated($message = null)
    {
        return $this->setStatusCode(401)
            ->respondWithError($message ?? __('msg.Unauthenticated'));
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return Response
     */
    public function errorWrongArgs($message)
    {
        return $this->setStatusCode(400)
            ->respondWithError($message);
    }

    //
    public function sendResponse($result, $message)
    {
        $response = [

            'status' => $this->getSuccess(),
            'data' => [$result],
            'code' => $this->getStatusCode(),
            'message' => $message

        ];

        return response()->json($response, 200);
    }


    public function sendError($error, $errorMessage = [])
    {
        $response = [

            'status' => $this->getFailure(),
            'data' => $errorMessage,
            'code' => $this->getStatusCode(),
            'message' => $error
        ];


        return response()->json($response,200);
    }

    /*public function acceptLanguage($locale)
	{


		if ($locale==locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{

			return true;
		}

		return false;

	}*/
}
