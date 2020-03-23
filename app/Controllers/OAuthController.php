<?php

namespace App\Controllers;

use App\Controller;

class OAuthController extends Controller
{
    public function token()
    {
        if (!isset($_POST['grant_type']) || !isset($_POST['client_id']) ||
            !isset($_POST['client_secret'])) {
            $this->badRequest(
                'MISSING_PARAMETERS',
                'You need to provide grant_type, client_id and client_secret parameters.'
            );
        }

        $grantType = $_POST['grant_type'];
        $clientId = $_POST['client_id'];
        $clientSecret = $_POST['client_secret'];

        // Validate parameters
        $this->validateGrantType($grantType);
        $this->validateSecrets($clientId, $clientSecret);

        // Generate an access token for one hour
        $this->json([
            'token' => $this->generateAuthToken()
        ]);
    }

    private function validateGrantType($grantType)
    {
        if ($grantType !== 'client_credentials')
        {
            $this->badRequest('WRONG_GRANT_TYPE', "grant_type must be 'client_credentials'");
        }
    }

    private function validateSecrets($id, $secret)
    {
        $store = preg_split('/;/', getenv('SECRETS'));

        foreach ($store as $item) {
            list($itemId, $itemSecret) = preg_split('/:/', $item);

            if ($itemId === $id && $itemSecret === $secret) {
                return;
            }
        }

        $this->badRequest('WRONG_CLIENT_CREDENTIALS', 'Wrong credentials');
    }
}
