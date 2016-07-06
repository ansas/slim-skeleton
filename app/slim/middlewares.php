<?php

use App\Middleware\TrailingSlash;

$app->add(new TrailingSlash(TrailingSlash::SLASH_REMOVE));
