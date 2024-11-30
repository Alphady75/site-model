<?php

namespace App\Service;

use Symfony\Component\Intl\Countries;

namespace App\Service;

use Symfony\Component\Intl\Countries;

class CountryService
{
  public function getCountryFlagsWithPostalCodes(): array
  {
    // Liste des indicatifs téléphoniques des pays (à compléter ou ajuster selon vos besoins)
    $countryPostalCodes = $this->getCoutries();

    $countries = [];
    foreach (Countries::getNames() as $code => $name) {
      if (isset($countryPostalCodes[$code])) {
        $flag = $this->getFlagEmoji($code);
        $postalCode = $countryPostalCodes[$code];
        $countries[$postalCode] = $flag . ' +' . $postalCode; // Affiche le drapeau suivi du code postal
      }
    }

    return $countries;
  }

  private function getFlagEmoji(string $countryCode): string
  {
    // Convertit le code pays en emoji drapeau
    return mb_convert_encoding('&#' . (127397 + ord($countryCode[0])) . ';' .
      '&#' . (127397 + ord($countryCode[1])) . ';', 'UTF-8', 'HTML-ENTITIES');
  }

  private function getCoutries()
  {
    $countryPostalCodes = [
      'AF' => '93',  // Afghanistan
      'AL' => '355',  // Albanie
      'DZ' => '213',  // Algérie
      'AS' => '1-684',  // Samoa américaines
      'AD' => '376',  // Andorre
      'AO' => '244',  // Angola
      'AI' => '1-264',  // Anguilla
      'AG' => '1-268',  // Antigua-et-Barbuda
      'AR' => '54',  // Argentine
      'AM' => '374',  // Arménie
      'AW' => '297',  // Aruba
      'AU' => '61',  // Australie
      'AT' => '43',  // Autriche
      'AZ' => '994',  // Azerbaïdjan
      'BS' => '1-242',  // Bahamas
      'BH' => '973',  // Bahreïn
      'BD' => '880',  // Bangladesh
      'BB' => '1-246',  // Barbade
      'BY' => '375',  // Biélorussie
      'BE' => '32',  // Belgique
      'BZ' => '501',  // Belize
      'BJ' => '229',  // Bénin
      'BM' => '1-441',  // Bermudes
      'BT' => '975',  // Bhoutan
      'BO' => '591',  // Bolivie
      'BA' => '387',  // Bosnie-Herzégovine
      'BW' => '267',  // Botswana
      'BR' => '55',  // Brésil
      'BN' => '673',  // Brunei
      'BG' => '359',  // Bulgarie
      'BF' => '226',  // Burkina Faso
      'BI' => '257',  // Burundi
      'KH' => '855',  // Cambodge
      'CM' => '237',  // Cameroun
      'CA' => '1',  // Canada
      'CV' => '238',  // Cap-Vert
      'KY' => '1-345',  // Îles Caïmans
      'CF' => '236',  // République centrafricaine
      'TD' => '235',  // Tchad
      'CL' => '56',  // Chili
      'CN' => '86',  // Chine
      'CO' => '57',  // Colombie
      'KM' => '269',  // Comores
      'CG' => '242',  // Congo-Brazzaville
      'CD' => '243',  // République démocratique du Congo
      'CR' => '506',  // Costa Rica
      'CI' => '225',  // Côte d'Ivoire
      'HR' => '385',  // Croatie
      'CU' => '53',  // Cuba
      'CY' => '357',  // Chypre
      'CZ' => '420',  // République tchèque
      'DK' => '45',  // Danemark
      'DJ' => '253',  // Djibouti
      'DM' => '1-767',  // Dominique
      'DO' => '1-809',  // République dominicaine
      'EC' => '593',  // Équateur
      'EG' => '20',  // Égypte
      'SV' => '503',  // Salvador
      'GQ' => '240',  // Guinée équatoriale
      'ER' => '291',  // Érythrée
      'EE' => '372',  // Estonie
      'ET' => '251',  // Éthiopie
      'FJ' => '679',  // Fidji
      'FI' => '358',  // Finlande
      'FR' => '33',  // France
      'GA' => '241',  // Gabon
      'GM' => '220',  // Gambie
      'GE' => '995',  // Géorgie
      'DE' => '49',  // Allemagne
      'GH' => '233',  // Ghana
      'GR' => '30',  // Grèce
      'GD' => '1-473',  // Grenade
      'GT' => '502',  // Guatemala
      'GN' => '224',  // Guinée
      'GW' => '245',  // Guinée-Bissau
      'GY' => '592',  // Guyana
      'HT' => '509',  // Haïti
      'HN' => '504',  // Honduras
      'HU' => '36',  // Hongrie
      'IS' => '354',  // Islande
      'IN' => '91',  // Inde
      'ID' => '62',  // Indonésie
      'IR' => '98',  // Iran
      'IQ' => '964',  // Irak
      'IE' => '353',  // Irlande
      'IL' => '972',  // Israël
      'IT' => '39',  // Italie
      'JM' => '1-876',  // Jamaïque
      'JP' => '81',  // Japon
      'JO' => '962',  // Jordanie
      'KZ' => '7',  // Kazakhstan
      'KE' => '254',  // Kenya
      'KI' => '686',  // Kiribati
      'KP' => '850',  // Corée du Nord
      'KR' => '82',  // Corée du Sud
      'KW' => '965',  // Koweït
      'KG' => '996',  // Kirghizistan
      'LA' => '856',  // Laos
      'LV' => '371',  // Lettonie
      'LB' => '961',  // Liban
      'LS' => '266',  // Lesotho
      'LR' => '231',  // Libéria
      'LY' => '218',  // Libye
      'LI' => '423',  // Liechtenstein
      'LT' => '370',  // Lituanie
      'LU' => '352',  // Luxembourg
      'MG' => '261',  // Madagascar
      'MW' => '265',  // Malawi
      'MY' => '60',  // Malaisie
      'MV' => '960',  // Maldives
      'ML' => '223',  // Mali
      'MT' => '356',  // Malte
      'MH' => '692',  // Îles Marshall
      'MR' => '222',  // Mauritanie
      'MU' => '230',  // Maurice
      'MX' => '52',  // Mexique
      'FM' => '691',  // Micronésie
      'MD' => '373',  // Moldavie
      'MC' => '377',  // Monaco
      'MN' => '976',  // Mongolie
      'ME' => '382',  // Monténégro
      'MA' => '212',  // Maroc
      'MZ' => '258',  // Mozambique
      'MM' => '95',  // Myanmar (Birmanie)
      'NA' => '264',  // Namibie
      'NR' => '674',  // Nauru
      'NP' => '977',  // Népal
      'NL' => '31',  // Pays-Bas
      'NZ' => '64',  // Nouvelle-Zélande
      'NI' => '505',  // Nicaragua
      'NE' => '227',  // Niger
      'NG' => '234',  // Nigéria
      'NO' => '47',  // Norvège
      'OM' => '968',  // Oman
      'PK' => '92',  // Pakistan
      'PW' => '680',  // Palaos
      'PA' => '507',  // Panama
      'PG' => '675',  // Papouasie-Nouvelle-Guinée
      'PY' => '595',  // Paraguay
      'PE' => '51',  // Pérou
      'PH' => '63',  // Philippines
      'PL' => '48',  // Pologne
      'PT' => '351',  // Portugal
      'QA' => '974',  // Qatar
      'RO' => '40',  // Roumanie
      'RU' => '7',  // Russie
      'RW' => '250',  // Rwanda
      'KN' => '1-869',  // Saint-Christophe-et-Niévès
      'LC' => '1-758',  // Sainte-Lucie
      'VC' => '1-784',  // Saint-Vincent-et-les-Grenadines
      'WS' => '685',  // Samoa
      'SM' => '378',  // Saint-Marin
      'ST' => '239',  // Sao Tomé-et-Principe
      'SA' => '966',  // Arabie saoudite
      'SN' => '221',  // Sénégal
      'RS' => '381',  // Serbie
      'SC' => '248',  // Seychelles
      'SL' => '232',  // Sierra Leone
      'SG' => '65',  // Singapour
      'SK' => '421',  // Slovaquie
      'SI' => '386',  // Slovénie
      'SB' => '677',  // Îles Salomon
      'SO' => '252',  // Somalie
      'ZA' => '27',  // Afrique du Sud
      'SS' => '211',  // Soudan du Sud
      'ES' => '34',  // Espagne
      'LK' => '94',  // Sri Lanka
      'SD' => '249',  // Soudan
      'SR' => '597',  // Suriname
      'SZ' => '268',  // Eswatini
      'SE' => '46',  // Suède
      'CH' => '41',  // Suisse
      'SY' => '963',  // Syrie
      'TW' => '886',  // Taïwan
      'TJ' => '992',  // Tadjikistan
      'TZ' => '255',  // Tanzanie
      'TH' => '66',  // Thaïlande
      'TG' => '228',  // Togo
      'TO' => '676',  // Tonga
      'TT' => '1-868',  // Trinité-et-Tobago
      'TN' => '216',  // Tunisie
      'TR' => '90',  // Turquie
      'TM' => '993',  // Turkménistan
      'TV' => '688',  // Tuvalu
      'UG' => '256',  // Ouganda
      'UA' => '380',  // Ukraine
      'AE' => '971',  // Émirats arabes unis
      'GB' => '44',  // Royaume-Uni
      'US' => '1',  // États-Unis
      'UY' => '598',  // Uruguay
      'UZ' => '998',  // Ouzbékistan
      'VU' => '678',  // Vanuatu
      'VA' => '379',  // Vatican
      'VE' => '58',  // Venezuela
      'VN' => '84',  // Viêt Nam
      'YE' => '967',  // Yémen
      'ZM' => '260',  // Zambie
      'ZW' => '263',  // Zimbabwe
    ];

    return $countryPostalCodes;
  }
}
