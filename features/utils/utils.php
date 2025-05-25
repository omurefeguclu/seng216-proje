<?php

function isAbsolutePath($path) {
    if (!is_string($path)) {
        $mess = sprintf('String expected but was given %s', gettype($path));
        throw new \InvalidArgumentException($mess);
    }
    if (!ctype_print($path)) {
        $mess = 'Path can NOT have non-printable characters or be empty';
        throw new \DomainException($mess);
    }
    // Optional wrapper(s).
    $regExp = '%^(?<wrappers>(?:[[:print:]]{2,}://)*)';
    // Optional root prefix.
    $regExp .= '(?<root>(?:[[:alpha:]]:/|/)?)';
    // Actual path.
    $regExp .= '(?<path>(?:[[:print:]]*))$%';
    $parts = [];
    if (!preg_match($regExp, $path, $parts)) {
        $mess = sprintf('Path is NOT valid, was given %s', $path);
        throw new \DomainException($mess);
    }
    if ('' !== $parts['root']) {
        return true;
    }
    return false;
}