# Tualo Office - PKPass

Eine PHP-Bibliothek zur Erstellung von Apple Wallet Passes (PKPass) für Tualo Office.

## Beschreibung

Dieses Modul ermöglicht die Generierung von Apple Wallet Passes (z.B. Event-Tickets, Boarding-Pässe, Coupons) direkt aus Tualo Office heraus. Es nutzt die Apple PassKit API und erstellt signierte .pkpass Dateien, die auf iOS-Geräten in der Wallet-App gespeichert werden können.

## Installation

```bash
composer require tualo/pkpass
```

## Funktionen

- Erstellung von Apple Wallet Event-Tickets
- Automatische Signierung mit Apple Zertifikaten
- QR-Code Integration für Ticket-Validierung
- Konfigurierbare Farben und Branding
- Unterstützung für Icons, Logos und Hintergrundbilder
- Dynamische Felder für Ticket-Informationen
- Integration mit Tualo Office DS-Files System

## Konfiguration

Das Modul benötigt folgende Umgebungsvariablen in der Datenbank-Tabelle `pkpass_environment`:

### Erforderliche Apple Zertifikate
- `apple_certificate` - Pass Certificate (.p12)
- `apple_cert_pass` - Passwort für das Zertifikat
- `apple_wwdr_certificate` - Apple WWDR Certificate (.cer)

### Apple Pass Identifikation
- `apple_passTypeIdentifier` - Pass Type Identifier
- `apple_teamIdentifier` - Team Identifier
- `apple_organizationName` - Organisationsname

### Design-Elemente
- `apple_icon` - Icon (29x29pt)
- `apple_icon2x` - Icon @2x (58x58pt)
- `apple_logo` - Logo
- `apple_strip` - Strip-Bild (optional)
- `apple_background` - Hintergrundbild (optional)

## Verwendung

```php
use Tualo\Office\PKPass\PKPass;

// Parameter für den Pass
$params = [
    'apple_backgroundColor' => 'rgb(240,240,240)',
    'apple_foregroundColor' => 'rgb(0,0,0)',
    'apple_labelColor' => 'rgb(0,0,0)',
    'apple_logoText' => 'Meine Veranstaltung',
    'description' => 'Event Ticket',
    'KEY_PRIMERY:LABEL' => 'Veranstaltung',
    'KEY_PRIMERY:VALUE' => 'Konzert 2026',
    'KEY_HEADER_LOCATION_DATE:LABEL' => 'Datum',
    'KEY_HEADER_LOCATION_DATE:VALUE' => '19.01.2026 20:00',
    'utc_datetime' => '2026-01-19T20:00:00+01:00'
];

// Pass erstellen
PKPass::pass('UNIQUE-TICKET-ID', $params);
```

## Pass-Felder

Das Modul unterstützt verschiedene Feldtypen für Event-Tickets:

- **Primary Fields**: Hauptinformationen (Veranstaltungsname)
- **Header Fields**: Datum/Uhrzeit
- **Secondary Fields**: Ticket-Typ
- **Auxiliary Fields**: Sitzplatznummer
- **Back Fields**: Zusätzliche Informationen auf der Rückseite

## Anforderungen

- PHP >= 7.4
- Tualo Office Framework
- pkpass/pkpass ~2.4.0
- Gültiges Apple Developer Zertifikat
- Apple WWDR Zertifikat

## Weiterführende Dokumentation

Offizielle Apple PassKit Dokumentation:
https://developer.apple.com/library/archive/documentation/UserExperience/Conceptual/PassKit_PG/Creating.html

## Lizenz

MIT License

## Autor

Thomas Hoffmann - thomas.hoffmann@tualo.de
