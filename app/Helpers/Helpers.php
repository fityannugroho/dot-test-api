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

if (! function_exists('fetch')) {
    /**
     * Fetch data from external API.
     * @param string $url The API URL.
     * @param string $key The API key.
     * @param string $path The path to the data to return, separated by dots. Example: "data.fruits".
     * @param array $params The parameters to send to the API.
     * @return array The data fetched from the API.
     */
    function fetch($url, $key = '', $path = '', $params = [])
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $url, [
            'query' => array_merge($params, ['key' => $key])
        ]);

        $data = json_decode($response->getBody(), true);

        if (empty($path)) {
            return $data;
        }

        return getNestedVar($data, $path);
    }
}
