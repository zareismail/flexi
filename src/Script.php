<?php

namespace Flexi;

class Script extends Asset
{
    /**
     * Indicates whether the script should be loaded at header or not.
     */
    public bool $toHeader = false;

    /**
     * Determines if the script should be loaded in the body.
     */
    public function isBodyScript(): bool
    {
        return ! $this->toHeader;
    }

    /**
     * Force to load script in the header.
     */
    public function toHeader()
    {
        $this->toHeader = false;

        return $this;
    }
}
