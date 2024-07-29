<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'API for fetching and caching BIN (Bank Identification Number) information using multiple providers.',
    title: 'BinFinder API'
)]

abstract class Controller
{
    //
}
