<?php

// Note: last added middleware is executed first!

// Add trailing slash middleware at latest possible point to enable early redirect
$app->add(new App\Middleware\TrailingSlash(App\Middleware\TrailingSlash::SLASH_REMOVE));

// Add runtime middleware last to get most accurate result
$app->add(new App\Middleware\Runtime());
