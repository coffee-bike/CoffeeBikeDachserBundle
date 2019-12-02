<?php

namespace CoffeeBike\DachserBundle\Entity;


class DeliveryRequest extends DachserMappingObject
{
    /**
     * Columns for identifier
     *
     * @var string $type_key
     *
     * @ORM\Column(type="string")
     */
    protected $type_key = 'kennzeichen_anwendungs_id';

    /**
     * Type of Response CSV File
     *
     * @var string $type_identifier
     *
     * @ORM\Column(type="string")
     */
    protected $type_identifier = 'DACHSER-DELIVERYORDER-CSV3';

    /**
     * Mapping for Request CSV File
     *
     * @var array $mapping
     */
    protected $mapping = [
        'kennzeichen_anwendungs_id' => [
            'short' => 'A ',
            'description' => 'Kennzeichen Anwendungs ID',
            'length' => 26,
            'required' => true
        ],
        'betriebsstaettennummer' => [
            'short' => 'B',
            'description' => 'Betriebsstättennummer',
            'length' => 8,
            'required' => true
        ],
        'einlagerer_kundennummer' => [
            'short' => 'C',
            'description' => 'Einlagerer-Kundennummer',
            'length' => 8,
            'required' => true
        ],
        'auftraggeber_kundennummer' => [
            'short' => 'D',
            'description' => 'Auftraggeber-Kundennummer',
            'length' => 8,
            'required' => true
        ],
        'auftragsreferenz_kunde' => [
            'short' => 'E',
            'description' => 'Auftragsreferenz Kunde',
            'length' => 35,
            'required' => true
        ],
        'warenempfaengerkundennummer' => [
            'short' => 'F',
            'description' => 'Warenempfängerkundennummer',
            'length' => 17,
            'required' => true
        ],
        'name_1_empfaenger' => [
            'short' => 'G',
            'description' => 'Name 1 Empfänger',
            'length' => 70,
            'required' => true
        ],
        'name_2_empfaenger' => [
            'short' => 'H',
            'description' => 'Name 2 Empfänger',
            'length' => 70,
            'required' => false
        ],
        'name_3_empfaenger' => [
            'short' => 'I',
            'description' => 'Name 3 Empfänger',
            'length' => 70,
            'required' => false
        ],
        'adressergaenzung_empfaenger' => [
            'short' => 'J',
            'description' => 'Adressergänzung Empfänger',
            'length' => 30,
            'required' => false
        ],
        'strasse_empfaenger' => [
            'short' => 'K',
            'description' => 'Straße Empfänger',
            'length' => 30,
            'required' => true
        ],
        'laenderkennzeichen_empfaenger' => [
            'short' => 'L',
            'description' => 'Länderkennzeichen Empfänger',
            'length' => 3,
            'required' => true
        ],
        'postleitzahl_empfaenger' => [
            'short' => 'M',
            'description' => 'Postleitzahl Empfänger',
            'length' => 17,
            'required' => true
        ],
        'ort_empfaenger' => [
            'short' => 'N',
            'description' => 'Ort Empfänger',
            'length' => 60,
            'required' => true
        ],
        'belegartenschluessel' => [
            'short' => 'O',
            'description' => 'Belegartenschlüssel',
            'length' => 3,
            'required' => false
        ],
        'versandweg' => [
            'short' => 'P',
            'description' => 'Versandweg',
            'length' => 3,
            'required' => false
        ],
        'frankatur' => [
            'short' => 'Q',
            'description' => 'Frankatur',
            'length' => 3,
            'required' => false
        ],
        'abfertigung' => [
            'short' => 'R',
            'description' => 'Abfertigung',
            'length' => 1,
            'required' => false
        ],
        'fix_lieferdatum' => [
            'short' => 'S',
            'description' => 'Fix-Lieferdatum',
            'length' => 8,
            'required' => false
        ],
        'bis_lieferdatum' => [
            'short' => 'T',
            'description' => 'Bis-Lieferdatum',
            'length' => 8,
            'required' => false
        ],
        'bestellnummer_empfaenger' => [
            'short' => 'U',
            'description' => 'Bestellnummer Empfänger',
            'length' => 35,
            'required' => false
        ],
        'bestelldatum_empfaenger' => [
            'short' => 'V',
            'description' => 'Bestelldatum Empfänger',
            'length' => 8,
            'required' => false
        ],
        'gln_empfaenger' => [
            'short' => 'W',
            'description' => 'GLN Empfänger',
            'length' => 13,
            'required' => false
        ],
        'auftragsreferenz_2' => [
            'short' => 'X',
            'description' => 'Auftragsreferenz 2',
            'length' => 35,
            'required' => false
        ],
        'auftragsreferenz_3' => [
            'short' => 'Y',
            'description' => 'Auftragsreferenz 3',
            'length' => 35,
            'required' => false
        ],
        'sprachenschluessel' => [
            'short' => 'Z',
            'description' => 'Sprachenschlüssel',
            'length' => 3,
            'required' => false
        ],
        'hebebuehne' => [
            'short' => 'AA',
            'description' => 'Hebebühne J/N',
            'length' => 1,
            'required' => false
        ],
        'avisierungsart' => [
            'short' => 'AB',
            'description' => 'Avisierungsart: Zustellvereinbarung (=AP) / Zustellankündigung (AS)',
            'length' => 2,
            'required' => false
        ],
        'kontakt_name_beim_empfaenger' => [
            'short' => 'AC',
            'description' => 'Kontakt Name beim Empfänger',
            'length' => 35,
            'required' => false
        ],
        'telefonnummer_festnetz_empfaenger' => [
            'short' => 'AD',
            'description' => 'Telefonnummer Festnetz Empfänger',
            'length' => 25,
            'required' => false
        ],
        'mobilnummer_empfaenger' => [
            'short' => 'AE',
            'description' => 'Mobilnummer Empfänger',
            'length' => 25,
            'required' => false
        ],
        'faxnummer_empfaenger' => [
            'short' => 'AF',
            'description' => 'Faxnummer Empfänger',
            'length' => 25,
            'required' => false
        ],
        'emailadresse_empfaenger' => [
            'short' => 'AG',
            'description' => 'Emailadresse Empfänger',
            'length' => 150,
            'required' => false
        ],
        'quailfier_spezialfeld_kopfebene' => [
            'short' => 'AH',
            'description' => 'Quailfier Spezialfeld Kopfebene',
            'length' => 3,
            'required' => false
        ],
        'spezialfeld_kopf_inhalt' => [
            'short' => 'AI',
            'description' => 'Spezialfeld Kopf-Inhalt',
            'length' => 35,
            'required' => false
        ],
        'kopftext_typ' => [
            'short' => 'AJ',
            'description' => 'Kopftext Typ',
            'length' => 2,
            'required' => false
        ],
        'kopftext_laufende_nummer' => [
            'short' => 'AK',
            'description' => 'Kopftext laufende Nummer',
            'length' => 3,
            'required' => false
        ],
        'kopftext_inhalt' => [
            'short' => 'AL',
            'description' => 'Kopftext Inhalt',
            'length' => 132,
            'required' => false
        ],
        'positionsnummer_einlagerer' => [
            'short' => 'AM',
            'description' => 'Positionsnummer Einlagerer',
            'length' => 7,
            'required' => true
        ],
        'artikelnummer' => [
            'short' => 'AN',
            'description' => 'Artikelnummer',
            'length' => 18,
            'required' => true
        ],
        'menge' => [
            'short' => 'AO',
            'description' => 'Menge',
            'length' => 14,
            'required' => true
        ],
        'nve' => [
            'short' => 'AP',
            'description' => 'NVE',
            'length' => 20,
            'required' => false
        ],
        'externe_packstueck_id' => [
            'short' => 'AQ',
            'description' => 'Externe Packstück ID',
            'length' => 35,
            'required' => false
        ],
        'charge' => [
            'short' => 'AR',
            'description' => 'Charge',
            'length' => 20,
            'required' => false
        ],
        'mhd' => [
            'short' => 'AS',
            'description' => 'MHD',
            'length' => 8,
            'required' => false
        ],
        'product_variante' => [
            'short' => 'AT',
            'description' => 'Product Variante',
            'length' => 3,
            'required' => false
        ],
        'variable_klassifizierung' => [
            'short' => 'AU',
            'description' => 'Variable Klassifizierung',
            'length' => 35,
            'required' => false
        ],
        'warenwert' => [
            'short' => 'AV',
            'description' => 'Warenwert',
            'length' => 17,
            'required' => false
        ],
        'warenwert_kurzbezeichnung_der_waehrung' => [
            'short' => 'AW',
            'description' => 'Warenwert - Kurzbezeichnung der Währung (z.B. EUR)',
            'length' => 3,
            'required' => false
        ],
        'quailfier_spezialfeld_positionsebene' => [
            'short' => 'AX',
            'description' => 'Quailfier Spezialfeld Positionsebene',
            'length' => 3,
            'required' => false
        ],
        'spezialfeld_positions_inhalt' => [
            'short' => 'AY',
            'description' => 'Spezialfeld Positions-Inhalt',
            'length' => 35,
            'required' => false
        ],
        'positionstext_typ' => [
            'short' => 'AZ',
            'description' => 'Positionstext Typ',
            'length' => 2,
            'required' => false
        ],
        'positionstext_laufende_nummer' => [
            'short' => 'BA',
            'description' => 'Positionstext laufende Nummer',
            'length' => 3,
            'required' => false
        ],
        'positionstext_inhalt' => [
            'short' => 'BB',
            'description' => 'Positionstext Inhalt',
            'length' => 132,
            'required' => false
        ],
        'verfuegungscode' => [
            'short' => 'BC',
            'description' => 'Verfügungscode',
            'length' => 3,
            'required' => false
        ],
        'warenempfaengerkundennummer_der_verfuegungsadresse' => [
            'short' => 'BD',
            'description' => 'Warenempfängerkundennummer  der Verfügungsadresse',
            'length' => 17,
            'required' => false
        ],
        'name_1_verfuegungsadresse' => [
            'short' => 'BE',
            'description' => 'Name 1 Verfügungsadresse',
            'length' => 70,
            'required' => false
        ],
        'name_2_verfuegungsadresse' => [
            'short' => 'BF',
            'description' => 'Name 2 Verfügungsadresse',
            'length' => 70,
            'required' => false
        ],
        'name_3_verfuegungsadresse' => [
            'short' => 'BG',
            'description' => 'Name 3 Verfügungsadresse',
            'length' => 70,
            'required' => false
        ],
        'adressergaenzung_verfuegungsadresse' => [
            'short' => 'BH',
            'description' => 'Adressergänzung Verfügungsadresse',
            'length' => 30,
            'required' => false
        ],
        'strasse_verfuegungsadresse' => [
            'short' => 'BI',
            'description' => 'Strasse Verfügungsadresse',
            'length' => 60,
            'required' => false
        ],
        'laenderkennzeichen_verfuegungsadresse' => [
            'short' => 'BJ',
            'description' => 'Länderkennzeichen Verfügungsadresse',
            'length' => 3,
            'required' => false
        ],
        'postleitzahl_verfuegungsadresse' => [
            'short' => 'BK',
            'description' => 'Postleitzahl Verfügungsadresse',
            'length' => 17,
            'required' => false
        ],
        'ort_verfuegungsadresse' => [
            'short' => 'BL',
            'description' => 'Ort Verfügungsadresse',
            'length' => 60,
            'required' => false
        ],
        'gln_verfuegungsdraesse' => [
            'short' => 'BM',
            'description' => 'GLN Verfügungsdraesse',
            'length' => 13,
            'required' => false
        ],
    ];
}
