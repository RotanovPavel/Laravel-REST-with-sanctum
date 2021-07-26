<?php


namespace App\Traits;


use Symfony\Component\HttpFoundation\Response;

trait RestResponseTrait
{
    /**
     * Data Response
     * @param $data
     * @return \Illuminate\Http\Response
     */
    public function dataResponse($data)
    {
        return response()->json(['content' => $data], Response::HTTP_OK);
    }

    /**
     * Success Response
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function successResponse($message, $code = Response::HTTP_OK)
    {
        return response()->json(['success' => $message, 'code' => $code], $code);
    }

    /**
     * Error Response
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\Response
     *
     */
    public function errorResponse($message, $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}