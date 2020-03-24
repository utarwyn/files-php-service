<?php

namespace App\Util;

/**
 * Interface IdentifierStrategy.
 *
 * @package App\Util
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
interface IdentifierStrategy
{
    /**
     * Generate a new identifier based on this strategy.
     * @return string generated identifier
     */
    public function generate();

    /**
     * Validate an identifier based on this strategy.
     *
     * @param $identifier string identifier to validate
     * @return boolean true if the identifier is valid
     */
    public function validate($identifier);
}
