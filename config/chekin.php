<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base uri
    |--------------------------------------------------------------------------
    */

    'base_uri' => 'https://a.chekin.io/api/v3/',

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    */

    'email' => env('CHEKIN_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

    'password' => env('CHEKIN_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Request Configuration
    |--------------------------------------------------------------------------
    */

    'request' => [
        'statuses' => [
            'new' => 'NEW',
            'progress' => 'PROGRESS',
            'complete' => 'COMPLETE',
            'error' => 'ERROR',
            'not_used' => 'NOT_USED',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Police types
    |--------------------------------------------------------------------------
    */

    'police_types' => [
        'FAKE' => 'FAKE',
        'POL' => 'ES - Policía Nacional',
        'NAT' => 'ES - Guardia Civil',
        'ERT' => 'ES - Ertzaintza',
        'MOS' => 'ES - Mossos d\'Esquadra',
        'SEF' => 'PT - Serviço de Estrangeiros e Fronteiras',
        'ISP' => 'IT - Polizia di Stato',
    ],

    /*
    |--------------------------------------------------------------------------
    | STAT types
    |--------------------------------------------------------------------------
    */

    'stat_types' => [
        'FAKE' => 'FAKE',
        'ITRA' => 'Italy Radar',
        'ITCA' => 'Italy Campania',
        'ITER' => 'Emilia-Romagna',
        'ITAB' => 'Abruzzo',
        'ITLO' => 'Lombardia',
        'ITPI' => 'Piemonte',
        'ITVE' => 'Veneto',
        'ITT3' => 'Toscana Turistat3',
        'ITSA' => 'Sardegna',
        'ITTR' => 'Trentino',
        'ITMA' => 'Marche',
        'ITTO' => 'Toscana Ricestat',
    ],

    /*
    |--------------------------------------------------------------------------
    | STAT types Italy required
    |--------------------------------------------------------------------------
    */

    'stat_types_italy_required' => [
        'ITER',
        'ITAB',
        'ITLO',
        'ITPI',
        'ITT3',
        'ITSA',
        'ITMA',
        'ITTO',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sardegna City codes
    |--------------------------------------------------------------------------
    */

    'sardegna_city_codes' => [
        'iw_ca' => 'Cagliari',
        'iw_ci' => 'Ministero degli Affari Esteri',
        'iw_vs' => 'Regione Autonoma Della Sardegna',
        'iw_nu' => 'Nuoro',
        'iw_og' => 'Ogliastra',
        'iw_ot' => 'Olbia Tempo',
        'iw_or' => 'Oristano',
        'iw_ss' => 'Sassari',
    ],

    /*
    |--------------------------------------------------------------------------
    | Toscana City codes
    |--------------------------------------------------------------------------
    */

    'toscana_province_codes' => [
        'Siena' => 'Siena',
        'Arezzo' => 'Arezzo',
        'Grosseto' => 'Grosseto',
        'Livorno' => 'Livorno',
        'Lucca' => 'Lucca',
        'Massa Carrara' => 'Massa Carrara',
        'Pisa' => 'Pisa',
    ],

    /*
    |--------------------------------------------------------------------------
    | Doc Types
    |--------------------------------------------------------------------------
    */

    'doc_types' => [
        'ES' => [
            "ES_D" => "Spanish ID card, called DNI",
            "ES_C" => "Spanish Driving Licence",
            "ES_N" => "Spanish residence permission",
            "ES_I" => "European ID card",
            "ES_X" => "Foreign residence permission",
            "ES_P" => "Passport",
        ],
        'PT' => [
            "PT_B" => "BILHETE DE IDENTIDADE",
            "PT_P" => "Passport",
            "PT_O" => "Any other documents",
        ],
        'IT' => [
            "IT_IDELE" => "CARTA IDENTITA' ELETTRONICA",
            "IT_IDENT" => "CARTA DI IDENTITA'",
            "IT_PASOR" => "PASSAPORTO ORDINARIO",
            "IT_ACMIL" => "TESS. APP.TO AG.CUSTODIA",
            "IT_ACSOT" => "TESS. SOTT.LI AG.CUSTODIA",
            "IT_ACUFF" => "TESS. UFF.LI AG.CUSTODIA",
            "IT_AMMIL" => "TESS. MILITARE TRUPPA A.M",
            "IT_AMSOT" => "TESS. SOTTUFFICIALI A.M",
            "IT_AMUFF" => "TESS. UFFICIALI A.M.",
            "IT_CCMIL" => "TESS. APP.TO CARABINIERI",
            "IT_CCSOT" => "TESS. SOTTUFFICIALI CC",
            "IT_CCUFF" => "TESS. UFFICIALE",
            "IT_CERID" => "CERTIFICATO D'IDENTITA'",
            "IT_CFMIL" => "TESS. AG. E AG.SC. C.F.S",
            "IT_CFSOT" => "TESS. SOTTUFICIALI C.F.S.",
            "IT_CFUFF" => "TESS. UFFICIALI C.F.S.",
            "IT_CIDIP" => "CARTA ID. DIPLOMATICA",
            "IT_DESIS" => "TESS. S.I.S.D.E.",
            "IT_EIMIL" => "TESS. MILITARE E.I.",
            "IT_EISOT" => "TESS. SOTTUFFICIALI E.I.",
            "IT_EIUFF" => "TESS. UFFICIALI E.I.",
            "IT_GFMIL" => "TESS. APP.TO FINANZIERE",
            "IT_GFSOT" => "TESS. SOTT.LI G.D.F.",
            "IT_GFTRI" => "TESS. POL. TRIB. G.D.F.",
            "IT_GFUFF" => "TESS. UFFICIALI G.D.F.",
            "IT_MAGIS" => "TESS. PERS. MAGISTRATI",
            "IT_MMMIL" => "TESS. MILIT. M.M.",
            "IT_MMSOT" => "TESS. SOTTUFICIALI M.M.",
            "IT_MMUFF" => "TESS. UFFICIALI M.M.",
            "IT_PARLA" => "TESS. PARLAMENTARI",
            "IT_PASDI" => "PASSAPORTO DIPLOMATICO",
            "IT_PASSE" => "PASSAPORTO DI SERVIZIO",
            "IT_PATEN" => "PATENTE DI GUIDA",
            "IT_PATNA" => "PATENTE NAUTICA",
            "IT_PORM1" => "PORTO FUCILE USO CACCIA",
            "IT_PORM2" => "PORTO FUCILE DIF. PERSON.",
            "IT_PORM3" => "PORTO D'ARMI USO SPORTIVO",
            "IT_PORM4" => "PORTO PISTOLA DIF. PERSON",
            "IT_PORM5" => "PORTO D'ARMI GUARDIE GIUR",
            "IT_PPAGE" => "TESS. AGENTI/ASS.TI P.P.",
            "IT_PPISP" => "TESS. ISPETTORI P.P.",
            "IT_PPSOV" => "TESS. SOVRINTENDENTI P.P.",
            "IT_PPUFF" => "TESS. UFFICIALI P.P.",
            "IT_PSAPP" => "TESS. AGENTI/ASS.TI P.S.",
            "IT_PSFEM" => "TESS. POLIZIA FEMMINILE",
            "IT_PSFUN" => "TESS. FUNZIONARI P.S.",
            "IT_PSISP" => "TESS. ISPETTORI P.S.",
            "IT_PSSOT" => "TESS. SOVRINTENDENTI P.S.",
            "IT_PSUFF" => "TESS. UFFICIALI P.S.",
            "IT_RIFUG" => "TITOLO VIAGGIO RIF.POLIT.",
            "IT_SDMIL" => "TESS. MILIT. TRUPPA SISMI",
            "IT_SDSOT" => "TESS. SOTTUFFICIALI SISMI",
            "IT_SDUFF" => "TESS. UFFICIALI SISMI",
            "IT_TEAMC" => "TESS. ISCR. ALBO MED/CHI.",
            "IT_TEAOD" => "TESS. ISCRIZ. ALBO ODONT.",
            "IT_TECAM" => "TES. UNICO PER LA CAMERA",
            "IT_TECOC" => "TESS. CORTE DEI CONTI",
            "IT_TEDOG" => "TES.DOGANALE RIL.MIN.FIN.",
            "IT_TEFSE" => "TESS. FERROV. SENATO",
            "IT_TEMPI" => "TESS. MIN.PUBB.ISTRUZIONE",
            "IT_TENAT" => "TESS. MILITARE NATO",
            "IT_TENAV" => "TES. ENTE NAZ. ASSIS.VOLO",
            "IT_TEPOL" => "TESS.MIN.POLIT.AGRIC.FOR.",
            "IT_TESAE" => "TESS. MIN. AFFARI ESTERI",
            "IT_TESAR" => "TESS.ISCR.ALBO ARCHITETTI",
            "IT_TESAV" => "TESSERA ISCR. ALBO AVVOC.",
            "IT_TESCA" => "TESS. CORTE D'APPELLO",
            "IT_TESCS" => "TESS. CONSIGLIO DI STATO",
            "IT_TESDI" => "TESSERA RICONOSC. D.I.A.",
            "IT_TESEA" => "TESS. MEMBRO EQUIP. AEREO",
            "IT_TESIN" => "TESS.ISCR. ALBO INGEGNERI",
            "IT_TESLP" => "TESS. MINISTERO LAVORI PU",
            "IT_TESMB" => "TESS. MIN.BEN.E ATT.CULT.",
            "IT_TESMD" => "TESS. MINISTERO DIFESA",
            "IT_TESMF" => "TESS. MINISTERO FINANZE",
            "IT_TESMG" => "TESS. MINISTERO GIUSTIZIA",
            "IT_TESMI" => "TESS. MINISTERO INTERNO",
            "IT_TESMN" => "TESS. MINIST. TRASP/NAVIG",
            "IT_TESMS" => "TESS. MINISTERO SANITA'",
            "IT_TESMT" => "TESS. MINISTERO TESORO",
            "IT_TESNO" => "TESSERA DELL'ORDINE NOTAI",
            "IT_TESOG" => "TESS. ORDINE GIORNALISTI",
            "IT_TESPC" => "TESS. PRES.ZA CONS. MIN.",
            "IT_TESPI" => "TESS. PUBBLICA ISTRUZIONE",
            "IT_TESPT" => "TES. POSTE E TELECOMUNIC.",
            "IT_TESUN" => "TESSERA U.N.U.C.I.",
            "IT_TETEL" => "TESS. IDENTIF.TELECOM IT.",
            "IT_TFERD" => "TES. FERROVIARIA DEPUTATI",
            "IT_TFEXD" => "TES. FERROV. EX DEPUTATI",
            "IT_VIMIL" => "TESS. APP.TO/VIG. URBANO",
            "IT_VISOT" => "TESS. SOTT.LI VIG. URBANI",
            "IT_VIUFF" => "TESS. SOTT.LI VIG. URBANI",
            "IT_VVMIL" => "TESS. APP.TO/VIG. VV.FF.",
            "IT_VVSOT" => "TESS. SOTTUFF.LI VV.FF.",
            "IT_VVUFF" => "TESS. UFFICIALI VV.FF.",
        ],
    ]
];