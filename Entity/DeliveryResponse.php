<?php


namespace CoffeeBike\DachserBundle\Entity;


class DeliveryResponse extends DachserMappingObject
{
    /**
     * @ORM\Column(type="string")
     */
    protected $type_identifier = '';

    protected $mapping = [
        'lieferauftragsnummer_mikado' => [
            'short' => 'A',
            'description' => 'Lieferauftragsnummer MIKADO',
            'length' => 11,
            'required' => true
        ],
        'betriebsstaettennummer' => [
            'short' => 'B',
            'description' => 'Betriebsstättennummer',
            'length' => 8,
            'required' => true
        ],
        'kundennummer_auftraggeber' => [
            'short' => 'C',
            'description' => 'Kundennummer Auftraggeber',
            'length' => 8,
            'required' => true
        ],
        'auftrraggeber_referenz_1' => [
            'short' => 'D',
            'description' => 'Auftrraggeber Referenz 1',
            'length' => 35,
            'required' => true
        ],
        'auftraggeber_referenz_2' => [
            'short' => 'E',
            'description' => 'Auftraggeber Referenz 2',
            'length' => 35,
            'required' => false
        ],
        'auftraggeber_referenz_3' => [
            'short' => 'F',
            'description' => 'Auftraggeber Referenz 3',
            'length' => 35,
            'required' => false
        ],
        'warenempfaenger_id' => [
            'short' => 'G',
            'description' => 'Warenempfänger ID',
            'length' => 17,
            'required' => false
        ],
        'warenempfaenger_name' => [
            'short' => 'H',
            'description' => 'Warenempfänger Name',
            'length' => 30,
            'required' => false
        ],
        'warenempfaenger_strasse' => [
            'short' => 'I',
            'description' => 'Warenempfänger Straße',
            'length' => 30,
            'required' => false
        ],
        'warenempfaenger_lkz' => [
            'short' => 'J',
            'description' => 'Warenempfänger LKZ',
            'length' => 3,
            'required' => false
        ],
        'warenempfaenger_plz' => [
            'short' => 'K',
            'description' => 'Warenempfänger PLZ',
            'length' => 9,
            'required' => false
        ],
        'warenempfaenger_ort' => [
            'short' => 'L',
            'description' => 'Warenempfänger Ort',
            'length' => 26,
            'required' => false
        ],
        'belegart' => [
            'short' => 'M',
            'description' => 'Belegart',
            'length' => 3,
            'required' => false
        ],
        'versandweg' => [
            'short' => 'N',
            'description' => 'Versandweg',
            'length' => 3,
            'required' => false
        ],
        'bestellnummer' => [
            'short' => 'O',
            'description' => 'Bestellnummer',
            'length' => 35,
            'required' => false
        ],
        'bestelldatum' => [
            'short' => 'P',
            'description' => 'Bestelldatum',
            'length' => 10,
            'required' => false
        ],
        'sendungsnummer_dachser' => [
            'short' => 'Q',
            'description' => 'Sendungsnummer DACHSER',
            'length' => 11,
            'required' => false
        ],
        'lieferschein_druckdatum' => [
            'short' => 'R',
            'description' => 'Lieferschein-Druckdatum',
            'length' => 10,
            'required' => false
        ],
        'voraussichtlicher_liefertermin' => [
            'short' => 'S',
            'description' => 'voraussichtlicher Liefertermin',
            'length' => 10,
            'required' => false
        ],
        'text' => [
            'short' => 'T',
            'description' => 'Text',
            'length' => 132,
            'required' => false
        ],
        'qualifier_spezialfeld_1' => [
            'short' => 'U',
            'description' => 'Qualifier Spezialfeld 1',
            'length' => 3,
            'required' => false
        ],
        'spezialfeld_1' => [
            'short' => 'V',
            'description' => 'Spezialfeld 1',
            'length' => 35,
            'required' => false
        ],
        'qualifier_spezialfeld_2' => [
            'short' => 'W',
            'description' => 'Qualifier Spezialfeld 2',
            'length' => 3,
            'required' => false
        ],
        'spezialfeld_2' => [
            'short' => 'X',
            'description' => 'Spezialfeld 2',
            'length' => 35,
            'required' => false
        ],
        'lfd_positionsnummer' => [
            'short' => 'Y',
            'description' => 'lfd. Positionsnummer',
            'length' => 7,
            'required' => true
        ],
        'original_positionsnummer' => [
            'short' => 'Z',
            'description' => 'Original-Positionsnummer',
            'length' => 7,
            'required' => false
        ],
        'artikelnummer' => [
            'short' => 'AA',
            'description' => 'Artikelnummer',
            'length' => 18,
            'required' => true
        ],
        'produktvariante' => [
            'short' => 'AB',
            'description' => 'Produktvariante',
            'length' => 3,
            'required' => false
        ],
        'artikelnummer_fuer_output' => [
            'short' => 'AC',
            'description' => 'Artikelnummer für Output',
            'length' => 35,
            'required' => false
        ],
        'kundennummer_einlagerer' => [
            'short' => 'AD',
            'description' => 'Kundennummer Einlagerer',
            'length' => 8,
            'required' => false
        ],
        'bestellnummer_position' => [
            'short' => 'AE',
            'description' => 'Bestellnummer',
            'length' => 35,
            'required' => false
        ],
        'bestellposition' => [
            'short' => 'AF',
            'description' => 'Bestellposition',
            'length' => 5,
            'required' => false
        ],
        'buchungsdatum' => [
            'short' => 'AG',
            'description' => 'Buchungsdatum',
            'length' => 10,
            'required' => true
        ],
        'auslagerungsmenge_bfe' => [
            'short' => 'AH',
            'description' => 'Auslagerungsmenge BFE',
            'length' => 12,
            'required' => true
        ],
        'mengeneinheit_bfe' => [
            'short' => 'AI',
            'description' => 'Mengeneinheit BFE',
            'length' => 3,
            'required' => true
        ],
        'original_menge_der_position' => [
            'short' => 'AJ',
            'description' => 'Original-Menge der Position',
            'length' => 12,
            'required' => false
        ],
        'charge' => [
            'short' => 'AK',
            'description' => 'Charge',
            'length' => 20,
            'required' => false
        ],
        'mhd' => [
            'short' => 'AL',
            'description' => 'MHD',
            'length' => 10,
            'required' => false
        ],
        'vkl' => [
            'short' => 'AM',
            'description' => 'VKL',
            'length' => 3,
            'required' => false
        ],
        'sperrgrund' => [
            'short' => 'AN',
            'description' => 'Sperrgrund',
            'length' => 3,
            'required' => false
        ],
        'lagerort' => [
            'short' => 'AO',
            'description' => 'Lagerort',
            'length' => 3,
            'required' => false
        ],
        'seriennummer' => [
            'short' => 'AP',
            'description' => 'Seriennummer',
            'length' => 35,
            'required' => false
        ],
        'externe_packstueck_id' => [
            'short' => 'AQ',
            'description' => 'Externe Packstück ID',
            'length' => 35,
            'required' => false
        ],
        'externe_packstueck_id_2' => [
            'short' => 'AR',
            'description' => 'Externe Packstück ID 2',
            'length' => 35,
            'required' => false
        ],
        'externe_packstueck_id_3' => [
            'short' => 'AS',
            'description' => 'Externe Packstück ID 3',
            'length' => 35,
            'required' => false
        ],
        'position_text' => [
            'short' => 'AT',
            'description' => 'Text',
            'length' => 132,
            'required' => false
        ],
        'position_qualifier_spezialfeld_1' => [
            'short' => 'AU',
            'description' => 'Qualifier Spezialfeld 1',
            'length' => 3,
            'required' => false
        ],
        'position_spezialfeld_1' => [
            'short' => 'AV',
            'description' => 'Spezialfeld 1',
            'length' => 35,
            'required' => false
        ],
        'position_qualifier_spezialfeld_2' => [
            'short' => 'AW',
            'description' => 'Qualifier Spezialfeld 2',
            'length' => 3,
            'required' => false
        ],
        'position_spezialfeld_2' => [
            'short' => 'AX',
            'description' => 'Spezialfeld 2',
            'length' => 35,
            'required' => false
        ],
        'position_qualifier_spezialfeld_3' => [
            'short' => 'AY',
            'description' => 'Qualifier Spezialfeld 3',
            'length' => 3,
            'required' => false
        ],
        'position_spezialfeld_3' => [
            'short' => 'AZ',
            'description' => 'Spezialfeld 3',
            'length' => 35,
            'required' => false
        ],
        'position_qualifier_spezialfeld_4' => [
            'short' => 'BA',
            'description' => 'Qualifier Spezialfeld 4',
            'length' => 3,
            'required' => false
        ],
        'position_spezialfeld_4' => [
            'short' => 'BB',
            'description' => 'Spezialfeld 4',
            'length' => 35,
            'required' => false
        ],
        'position_qualifier_spezialfeld_5' => [
            'short' => 'BC',
            'description' => 'Qualifier Spezialfeld 5',
            'length' => 3,
            'required' => false
        ],
        'position_spezialfeld_5' => [
            'short' => 'BD',
            'description' => 'Spezialfeld 5',
            'length' => 35,
            'required' => false
        ],
        'versand_nve' => [
            'short' => 'BE',
            'description' => 'Versand-NVE',
            'length' => 20,
            'required' => false
        ],
        'externe_ident_nummer' => [
            'short' => 'BF',
            'description' => 'Externe Ident-Nummer',
            'length' => 35,
            'required' => false
        ],
        'versandpackmittel' => [
            'short' => 'BG',
            'description' => 'Versandpackmittel',
            'length' => 3,
            'required' => false
        ],
        'pack_qualifier_spezialfeld_1' => [
            'short' => 'BH',
            'description' => 'Qualifier Spezialfeld 1',
            'length' => 3,
            'required' => false
        ],
        'pack_spezialfeld_1' => [
            'short' => 'BI',
            'description' => 'Spezialfeld 1',
            'length' => 35,
            'required' => false
        ],
        'pack_qualifier_spezialfeld_2' => [
            'short' => 'BJ',
            'description' => 'Qualifier Spezialfeld 2',
            'length' => 3,
            'required' => false
        ],
        'pack_spezialfeld_2' => [
            'short' => 'BK',
            'description' => 'Spezialfeld 2',
            'length' => 35,
            'required' => false
        ],
        'pack_qualifier_spezialfeld_3' => [
            'short' => 'BL',
            'description' => 'Qualifier Spezialfeld 3',
            'length' => 3,
            'required' => false
        ],
        'pack_spezialfeld_3' => [
            'short' => 'BM',
            'description' => 'Spezialfeld 3',
            'length' => 35,
            'required' => false
        ],
        'pack_qualifier_spezialfeld_4' => [
            'short' => 'BN',
            'description' => 'Qualifier Spezialfeld 4',
            'length' => 3,
            'required' => false
        ],
        'pack_spezialfeld_4' => [
            'short' => 'BO',
            'description' => 'Spezialfeld 4',
            'length' => 35,
            'required' => false
        ],
        'pack_qualifier_spezialfeld_5' => [
            'short' => 'BP',
            'description' => 'Qualifier Spezialfeld 5',
            'length' => 3,
            'required' => false
        ],
        'pack_spezialfeld_5' => [
            'short' => 'BQ',
            'description' => 'Spezialfeld 5',
            'length' => 35,
            'required' => false
        ],
    ];
}
