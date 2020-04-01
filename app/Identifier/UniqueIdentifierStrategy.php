<?php

namespace FilesService\Identifier;

use Ramsey\Uuid\Uuid;

/**
 * Class UniqueIdentifierStrategy.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Identifier
 * @since   1.0.0
 */
class UniqueIdentifierStrategy implements IdentifierStrategy
{
    /**
     * @inheritDoc
     */
    public function generate()
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @inheritDoc
     */
    public function validate($identifier)
    {
        return Uuid::isValid($identifier);
    }
}
