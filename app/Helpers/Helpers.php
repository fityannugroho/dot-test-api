<?php

if (! function_exists('getNestedVar')) {
    /**
     * Get a nested variable from an array.
     * @param array|object $context The array to get the variable from.
     * @param string $location The variable location to get separated by dots. Example: "fruits.orange.quantity".
     * @param mixed $default The default value to return if the variable is not found.
     */
    function getNestedVar(&$context, $location, $default = null)
    {
        $pieces = explode('.', $location);

        foreach ($pieces as $piece) {
            if (!is_array($context) || !array_key_exists($piece, $context)) {
                // error occurred
                return $default;
            }

            $context = &$context[$piece];
        }

        return $context;
    }
}
