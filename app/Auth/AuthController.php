<?php

namespace FilesService\Auth;

use FilesService\Auth\Token\AuthTokenStrategyFactory;
use FilesService\Controller;

/**
 * Class AuthController.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Auth
 * @since   1.0.0
 */
class AuthController extends Controller
{
    public function token()
    {
        $post = $this->getPost();
        if (
            !isset($post['grant_type']) || !isset($post['client_id']) ||
            !isset($post['client_secret'])
        ) {
            $this->badRequest(
                'MISSING_PARAMETERS',
                'Parameters grant_type, client_id and client_secret parameters must be provided.'
            );
        }

        $grantType = $post['grant_type'];
        $clientId = $post['client_id'];
        $clientSecret = $post['client_secret'];

        // Validate parameters
        $this->validateGrantType($grantType);
        $this->validateSecrets($clientId, $clientSecret);

        // Generate an access token for one hour
        $this->json(['token' => AuthTokenStrategyFactory::create()->generate()]);
    }

    private function validateGrantType($grantType)
    {
        if ($grantType !== 'client_credentials') {
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
