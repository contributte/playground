<?php

namespace App\Controllers;

use Contributte\Api\Annotation\Controller\Controller;
use Contributte\Api\Annotation\Controller\Method;
use Contributte\Api\Annotation\Controller\Path;
use Contributte\Api\Annotation\Controller\RootPath;
use Contributte\Api\Http\Request\ApiRequest;
use Contributte\Api\Http\Response\ApiDataResponse;
use Contributte\Api\Http\Response\ApiResponse;

/**
 * @Controller
 * @RootPath("/users")
 */
final class UsersController extends BaseController
{

    /**
     * @Path("/")
     * @Method("GET")
     * @param ApiRequest $request
     * @param ApiDataResponse $response
     * @return ApiResponse
     */
    public function index(ApiRequest $request, ApiDataResponse $response)
    {
        $response->setData(['data' => [
            ['id' => 1, 'nick' => 'Chuck Norris'],
            ['id' => 2, 'nick' => 'Felix'],
        ]]);

        return $response;
    }

    /**
     * @Path("/user/{id}")
     * @Method("GET")
     * @param ApiRequest $request
     * @param ApiDataResponse $response
     * @return ApiResponse
     */
    public function detail(ApiRequest $request, ApiDataResponse $response)
    {
        $response->setData(['data' => [
            'id' => $request->getParameter('id'),
            'nick' => 'Felix',
            'request' => [
                'attributes' => $request->getAttributes(),
                'parameters' => $request->getParameters(),
            ],
        ]]);

        return $response;
    }

    /**
     * @Path("/create")
     * @Method("POST")
     * @param ApiRequest $request
     * @param ApiDataResponse $response
     * @return ApiResponse
     */
    public function create(ApiRequest $request, ApiDataResponse $response)
    {
        $body = (string) $request->getPsr7()->getBody();
        $response->setData(['data' => [
            'raw' => $body,
            'parsed' => json_decode($body, TRUE),
        ]]);

        return $response;
    }

    /**
     * @Path("/meta")
     * @Method("GET")
     * @param ApiRequest $request
     * @param ApiDataResponse $response
     * @return ApiResponse
     */
    public function meta(ApiRequest $request, ApiDataResponse $response)
    {
        $response->setData(['data' => [
            'params' => $request->getPsr7()->getQueryParams(),
            'attributes' => $request->getPsr7()->getAttributes(),
            'cookies' => $request->getPsr7()->getCookieParams(),
            'server' => $request->getPsr7()->getServerParams(),
            'headers' => $request->getPsr7()->getHeaders(),
        ]]);

        return $response;
    }

}