<?php

namespace _YabeUkiyo\Hidehalo\Nanoid;

class Generator implements GeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function random($size)
    {
        return \unpack('C*', \random_bytes($size));
    }
}
