<?php


namespace App\Controller;


use App\Constant\Messages;
use App\Helper\Util;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


abstract class BaseController extends AbstractController
{
    /**
     * @return array
     */
    private function getHeaders(): array
    {
        return [
            'Access-Control-Allow-Origin' => '*'
        ];
    }

    /**
     * @param $data
     * @param int $statusCode
     * @param $message
     * @param array $headers
     * @return mixed
     */
    public function sendSuccess($data, int $statusCode = 200, string $message = '', array $headers = [])
    {
        return $this->processResponse('success', $message, $data, $statusCode, $headers);
    }

    /**
     * @param $message
     * @param int $statusCode
     * @param null $data
     * @param array $headers
     * @return mixed
     */
    public function sendError(string $message, int $statusCode = 500, $data = null, array $headers = [])
    {
        return $this->processResponse('error', $message, $data, $statusCode, $headers);
    }

    /**
     * @param $status
     * @param $message
     * @param $data
     * @param int $statusCode
     * @param $headers
     * @return mixed
     */
    private function processResponse(string $status, string $message, $data, int $statusCode, array $headers)
    {
        $response = [
            'status' => $status
        ];
        if (!is_null($message)) {
            $response['message'] = $message;
        }
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        $headers = array_merge($headers, $this->getHeaders());
        return $this->json($response, $statusCode, $headers);
    }

    protected function validateParameters(array $data, array $rules): array
    {
        $validated = \GUMP::is_valid($data, $rules);
        if ($validated === true) {
            return ['status' => true];
        }
        $messageList = Util::stripHtmlTags($validated);
        $message = sprintf(Messages::INVALID_PARAM, implode(',', $messageList));
        return ['status' => false, 'message' => $message, 'data' => $messageList];
    }
}