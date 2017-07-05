<?php
// src/OagBundle/Service/Geocoder.php
namespace OagBundle\Service;

use OagBundle\Service\OagServiceInterface;

class Geocoder implements OagServiceInterface {
    public function autocodeXml($sometext)
    {
        return $this->autocodeText();
    }

    public function autocodeText($sometext)
    {
        $json = '[{
    "project_id": "P-TD-KF0-005",
    "title": "",
    "locations": [{
            "name": "Salamat",
            "id": 242048,
            "geometry": {
                "type": "Point",
                "coordinates": [
                    "20.5",
                    "11"
                ]
            },
            "featureDesignation": {
                "code": "ADM1",
                "name": "first-order administrative division"
            },
            "type": "geocoding",
            "activityDescription": "Maize ",
            "locationClass": {
                "code": "1",
                "name": "Administrative Region",
                "language": "en",
                "description": "The designated geographic location is an administrative region (state, county, province, district, municipality etc.)"
            },
            "exactness": {
                "code": "1",
                "name": "Exact",
                "language": "en",
                "description": "The designated geographic location is exact"
            },
            "country": {
                "code": 216,
                "name": "Chad"
            },
            "admin1": {
                "code": 2812,
                "name": "Salamat"
            },
            "admin2": {
                "code": 32286,
                "name": "Barh Azoum"
            },
            "rollbackData": {
                "name": "Salamat",
                "id": 242048,
                "geometry": {
                    "type": "Point",
                    "coordinates": [
                        "20.5",
                        "11"
                    ]
                },
                "featureDesignation": {
                    "code": "ADM1",
                    "name": "first-order administrative division"
                },
                "type": "geocoding",
                "activityDescription": "Maize ",
                "locationClass": {
                    "code": "1",
                    "name": "Administrative Region",
                    "language": "en",
                    "description": "The designated geographic location is an administrative region (state, county, province, district, municipality etc.)"
                },
                "exactness": {
                    "code": "1",
                    "name": "Exact",
                    "language": "en",
                    "description": "The designated geographic location is exact"
                },
                "country": {
                    "code": 216,
                    "name": "Chad"
                },
                "admin1": {
                    "code": 2812,
                    "name": "Salamat"
                },
                "admin2": {
                    "code": 32286,
                    "name": "Barh Azoum"
                },
                "rollbackData": {
                    "name": "Salamat",
                    "id": 242048,
                    "geometry": {
                        "type": "Point",
                        "coordinates": [
                            "20.5",
                            "11"
                        ]
                    },
                    "featureDesignation": {
                        "code": "ADM1",
                        "name": "first-order administrative division"
                    },
                    "type": "geocoding",
                    "activityDescription": "Maize ",
                    "locationClass": {
                        "code": "1",
                        "name": "Administrative Region",
                        "language": "en",
                        "description": "The designated geographic location is an administrative region (state, county, province, district, municipality etc.)"
                    },
                    "exactness": {
                        "code": "1",
                        "name": "Exact",
                        "language": "en",
                        "description": "The designated geographic location is exact"
                    },
                    "country": {
                        "code": 216,
                        "name": "Chad"
                    },
                    "admin1": {
                        "code": 2812,
                        "name": "Salamat"
                    },
                    "admin2": {
                        "code": 32286,
                        "name": "Barh Azoum"
                    },
                    "rollbackData": null
                }
            }
        },
        {
            "name": "Massakory",
            "id": 2428228,
            "geometry": {
                "type": "Point",
                "coordinates": [
                    "15.72927",
                    "12.996"
                ]
            },
            "featureDesignation": {
                "code": "PPLA",
                "name": "seat of a first-order administrative division"
            },
            "type": "geocoding",
            "activityDescription": "Building school",
            "locationClass": {
                "code": "2",
                "name": "Populated Place",
                "language": "en",
                "description": "The designated geographic location is a populated place (town, village, farm etc.)"
            },
            "exactness": {
                "code": "2",
                "name": "Approximate",
                "language": "en",
                "description": "The designated geographic location is approximate"
            },
            "country": {
                "code": 216,
                "name": "Chad"
            },
            "admin1": {
                "code": 2802,
                "name": "Hadjer-Lamis"
            },
            "admin2": {
                "code": 32256,
                "name": "Dagana"
            }
        }
    ]
}]';

        return $json;
    }
}
