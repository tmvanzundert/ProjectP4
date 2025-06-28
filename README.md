# Project Setup en Configuratie

## Vereisten

Voor het uitvoeren van dit project zijn de volgende dependencies vereist:
- **PHPMailer** - Voor e-mail functionaliteit
- **PHPUnit** - Voor unit testing

## Installatie

Installeer de benodigde packages via Composer:

```bash
composer install
```

## Gebruikersaccounts

Het systeem bevat twee vooraf geconfigureerde accounts voor testing:

### Gebruikersaccount
- **Gebruikersnaam:** `epost`
- **Wachtwoord:** `welkom123`

### Beheerdersaccount
- **Gebruikersnaam:** `hdevries`
- **Wachtwoord:** `welkom123`

## Tests Uitvoeren

Alle tests uitvoeren:
```bash
./vendor/bin/phpunit tests/
```

Specifieke test uitvoeren:
```bash
./vendor/bin/phpunit tests/contactinfotest.php
```