<?php
/**
 * A utility class for geocoding addresses using the google maps API.
 *
 * @package silverstripe-addressable
 */
class OSMGeocoding {

	/**
	 * Convert an address into a latitude and longitude.
	 *
	 * @param string $address The address to geocode.
	 * @param string $region  An optional two letter region code.
	 * @return array An associative array with lat and lng keys.
	 */
	public static function address_to_point($address, $region = null) {
		// Get the URL for the Google API
		$url = Config::inst()->get('OSMGeocoding', 'api_url');
		$key = Config::inst()->get('OSMGeocoding', 'api_key');

		// Query the Google API
		$service = new RestfulService($url);
		$service->setQueryString(array(
      'format' => 'xml',
			'q' => $address,
			'country'  => $region,
      'limit' => 1
		));
		$response = $service->request()->simpleXML();

    if (!$response->place) {
      return false;
    }

		$location = $response->place->attributes();
		return array(
			'lat' => (float) $location->lat,
			'lng' => (float) $location->lon
		);
	}

}
