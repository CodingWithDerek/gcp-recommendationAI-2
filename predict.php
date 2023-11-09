<?php
putenv("GOOGLE_APPLICATION_CREDENTIALS=" . __DIR__ . '/service-account.json');
require 'vendor/autoload.php';

use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\PredictResponse;
use Google\Cloud\Retail\V2\PredictionServiceClient;
use Google\Cloud\Retail\V2\UserEvent;
function predict_sample(
    string $placement,
    string $userEventEventType,
    string $userEventVisitorId
){
    // Create a client.
    $predictionServiceClient = new PredictionServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $userEvent = (new UserEvent())
        ->setEventType($userEventEventType)
        ->setVisitorId($userEventVisitorId);

    // Call the API and handle any network failures.
    try {
        /** @var PredictResponse $response */
        $response = $predictionServiceClient->predict($placement, $userEvent);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
function callSample()
{
    $placement = 'projects/derek-recommendation-ai/locations/global/catalogs/default_catalog/placements/recently_viewed_default';
    $userEventEventType = 'detail-page-view';
    $userEventVisitorId = '123456';

    predict_sample($placement, $userEventEventType, $userEventVisitorId);
}
callSample();