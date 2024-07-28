<?php

dataset('bin list success responses', [
    '371775 - American Express [CREDIT] (MX)' => [
        [
            "number" => [],
            "scheme" => "american express",
            "type" => "credit",
            "country" => [
                "numeric" => "484",
                "alpha2" => "MX",
                "name" => "Mexico",
                "emoji" => "<F0><9F><87><B2><F0><9F><87><BD>",
                "currency" => "MXN",
                "latitude" => 23,
                "longitude" => -102,
            ],
            "bank" => [],
        ]
    ],
    '554629 - Mastercard [CREDIT] (MX)' => [
        [
            "number" => [],
            "scheme" => "mastercard",
            "type" => "credit",
            "brand" => "Gold Mastercard",
            "country" => [
                "numeric" => "484",
                "alpha2" => "MX",
                "name" => "Mexico",
                "emoji" => "<F0><9F><87><B2><F0><9F><87><BD>",
                "currency" => "MXN",
                "latitude" => 23,
                "longitude" => -102,
            ],
            "bank" => [
                "name" => "Bbva Bancomer, Sa Instit. De Banca Multiple Grupo Financier",
            ],
        ]
    ],
    '452421 - Visa [CREDIT] (MX)' => [
        [
            "number" => [],
            "scheme" => "visa",
            "type" => "credit",
            "brand" => "Visa Classic",
            "country" => [
                "numeric" => "484",
                "alpha2" => "MX",
                "name" => "Mexico",
                "emoji" => "<F0><9F><87><B2><F0><9F><87><BD>",
                "currency" => "MXN",
                "latitude" => 23,
                "longitude" => -102,
            ],
            "bank" => [
                "name" => "Hsbc Mexico S.A., Institucion De Banca Multiple, Grupo Financiero Hsbc",
            ],
        ]
    ]
]);

dataset('bin check success responses', [
    '371775 - American Express [CREDIT] (MX)' => [
        [
            "success" => true,
            "code" => 200,
            "BIN" => [
                "valid" => true,
                "number" => 371775,
                "length" => 6,
                "scheme" => "AMERICAN EXPRESS",
                "brand" => "AMERICAN EXPRESS",
                "type" => "CREDIT",
                "level" => "PERSONAL",
                "is_commercial" => "false",
                "is_prepaid" => "false",
                "currency" => "MXN",
                "issuer" => [
                    "name" => "",
                    "website" => "",
                    "phone" => "",
                ],
                "country" => [
                    "name" => "MEXICO",
                    "native" => "M<C3><A9>xico",
                    "flag" => "<F0><9F><87><B2><F0><9F><87><BD>",
                    "numeric" => "484",
                    "capital" => "Ciudad de México",
                    "currency" => "MXN",
                    "currency_name" => "Mexican peso",
                    "currency_symbol" => "$",
                    "region" => "Americas",
                    "subregion" => "Central America",
                    "idd" => "52",
                    "alpha2" => "MX",
                    "alpha3" => "MEX",
                    "language" => "Spanish",
                    "language_code" => "ES",
                ],
            ],
        ]
    ],
    '554629 - Mastercard [CREDIT] (MX)' => [
        [
            "success" => true,
            "code" => 200,
            "BIN" => [
                "valid" => true,
                "number" => 554629,
                "length" => 6,
                "scheme" => "MASTERCARD",
                "brand" => "MASTERCARD",
                "type" => "CREDIT",
                "level" => "GOLD",
                "is_commercial" => "false",
                "is_prepaid" => "false",
                "currency" => "MXN",
                "issuer" => [
                    "name" => "BBVA BANCOMER, SA INSTIT. DE BANCA MULTIPLE GRUPO FINANCIER",
                    "website" => "https://www.bbva.mx",
                    "phone" => "+525556241113",
                ],
                "country" => [
                    "name" => "MEXICO",
                    "native" => "México",
                    "flag" => "<F0><9F><87><B2><F0><9F><87><BD>",
                    "numeric" => "484",
                    "capital" => "Ciudad de México",
                    "currency" => "MXN",
                    "currency_name" => "Mexican peso",
                    "currency_symbol" => "$",
                    "region" => "Americas",
                    "subregion" => "Central America",
                    "idd" => "52",
                    "alpha2" => "MX",
                    "alpha3" => "MEX",
                    "language" => "Spanish",
                    "language_code" => "ES",
                ],
            ],
        ]
    ],
    '452421 - Visa [CREDIT] (MX)' => [
        [
            "success" => true,
            "code" => 200,
            "BIN" => [
                "valid" => true,
                "number" => 452421,
                "length" => 6,
                "scheme" => "VISA",
                "brand" => "VISA",
                "type" => "CREDIT",
                "level" => "CLASSIC",
                "is_commercial" => "false",
                "is_prepaid" => "false",
                "currency" => "MXN",
                "issuer" => [
                    "name" => "HSBC MEXICO S.A., INSTITUCION DE BANCA MULTIPLE, GRUPO FINANCIERO HSBC",
                    "website" => "",
                    "phone" => "",
                ],
                "country" => [
                    "name" => "MEXICO",
                    "native" => "México",
                    "flag" => "<F0><9F><87><B2><F0><9F><87><BD>",
                    "numeric" => "484",
                    "capital" => "Ciudad de México",
                    "currency" => "MXN",
                    "currency_name" => "Mexican peso",
                    "currency_symbol" => "$",
                    "region" => "Americas",
                    "subregion" => "Central America",
                    "idd" => "52",
                    "alpha2" => "MX",
                    "alpha3" => "MEX",
                    "language" => "Spanish",
                    "language_code" => "ES",
                ],
            ],
        ]
    ]
]);

dataset('bin codes success responses', [
    '371775 - American Express [CREDIT] (MX)' => [
        [
            "bin" => "371775",
            "bank" => "AE MEXICO GLOBESTAR CONS REVOLVE",
            "card" => "AMERICAN EXPRESS",
            "type" => "CREDIT",
            "level" => "PERSONAL REVOLVE",
            "country" => "MEXICO",
            "countrycode" => "MX",
            "website" => "",
            "phone" => "",
            "valid" => "true",
        ]
    ],
    '554629 - Mastercard [CREDIT] (MX)' => [
        [
            "bin" => "554629",
            "bank" => "BBVA BANCOMER, SA INSTIT. DE BANCA MULTIPLE GRUPO FINANCIER",
            "card" => "MASTERCARD",
            "type" => "CREDIT",
            "level" => "GOLD",
            "country" => "MEXICO",
            "countrycode" => "MX",
            "website" => "",
            "phone" => "",
            "valid" => "true",
        ]
    ],
    '452421 - Visa [CREDIT] (MX)' => [
        [
            "bin" => "452421",
            "bank" => "HSBC MEXICO S.A., INSTITUCION DE BANCA MULTIPLE, GRUPO FINAN",
            "card" => "VISA",
            "type" => "CREDIT",
            "level" => "CLASSIC",
            "country" => "MEXICO",
            "countrycode" => "MX",
            "website" => "HTTP://WWW.HSBC.COM.MX/",
            "phone" => "5721- 3390",
            "valid" => "true",
        ]
    ]
]);


dataset('Greip success responses', [
    '452421 - Visa [CREDIT] (MX)' => [
        [
            "data" => [
                "reason" => "",
                "isValid" => true,
                "info" => [
                    "scheme" => [
                        "name" => "Visa",
                        "coName" => "Mada",
                        "isLuna" => true,
                        "isPrepaid" => false,
                        "isCommercial" => false,
                        "type" => "debit",
                        "brand" => "Traditional",
                        "currency" => "SAR"
                    ],
                    "detected_digits" => "4",
                    "syntax" => [
                        "gaps" => [4, 8, 12],
                        "lengths" => [16, 18, 19],
                        "code" => [
                            "name" => "CVV",
                            "size" => 3
                        ]
                    ],
                    "bank" => [
                        "id" => "588847",
                        "identifier" => "80",
                        "name" => "AL RAJHI BANKING AND INVESTMENT CORP.",
                        "city" => "Riyadh",
                        "url" => "https://www.alrajhibank.com.sa",
                        "phone" => "+96611211600",
                        "logo" => "https://greip.io/img/banks/al-rajhi.jpg",
                        "latitude" => "25",
                        "longitude" => "45"
                    ],
                    "country" => [
                        "alpha2" => "SA",
                        "name" => "Saudi Arabia",
                        "code" => "966",
                        "numeric" => "682",
                        "emoji" => "🇸🇦",
                        "continent" => "Asia",
                        "languageCode" => "ar",
                        "languageNative" => "العربية"
                    ]
                ]
            ],
            "status" => "success",
            "executionTime" => 2
        ]
    ]
]);


dataset('Iin list success responses', [
    '452421 - Visa [CREDIT] (MX)' => [
        [
            "count" => 1,
            "_embedded" => [
                "cards" => [
                    [
                        "scheme" => [
                            "name" => "Visa"
                        ],
                        "range" => [
                            "type" => "account"
                        ],
                        "product" => [
                            "name" => "Visa Classic",
                            "segment" => "consumer"
                        ],
                        "account" => [
                            "funding" => "debit",
                            "country" => [
                                "code" => "DK"
                            ],
                            "currency" => [
                                "code" => "DKK"
                            ]
                        ],
                        "issuer" => [
                            "name" => "Foreningen Af Danske Kortudstedere F.M.B.A"
                        ],
                        "fast_funds" => [
                            "domestic" => false,
                            "cross_border" => false
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
