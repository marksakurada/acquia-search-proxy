<?php

require 'vendor/autoload.php';

$app = Acquia\Search\Proxy\App::bootstrap(array(
    //'conf_file' => __DIR__ . '/conf/config.yml',
    //'auth_file' => __DIR__ . '/conf/indexes.json',
));

/**
 * A simple landing page that gives basic info about the app.
 */
$app->get('/', function () use ($app) {
    return $app->json(array(
        'status'  => 'ok',
        'message' => 'Acquia Search Proxy',
    ));
});

/**
 * Autocomplete using the "suggest" component.
 */
$app->get('/autocomplete/{query}', function ($query) use ($app) {

    $result = \PSolr\Request\Suggest::factory()
        ->setQuery($query)
        ->sendRequest($app['acquia.search.index'])
    ;

    return $app->json(array(
        'query'       => $query,
        'suggestions' => $result->suggestions(),
        'collation'   => $result->collation(),
    ));
});


$app->run();
