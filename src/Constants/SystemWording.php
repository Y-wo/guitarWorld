<?php

namespace App\Constants;

abstract class SystemWording
{

    // Registration
    const ERROR_MESSAGE = "Etwas ist leider schiefgelaufen. Bitte wiederholen Sie den Vorgang";
    const SUCCESS_REGISTRATION = "User erfolgreich angelegt. Bitte bestätigen Sie den Link, den wir an Ihre Adresse geschickt haben.";
    const USER_ALREADY_EXISTS = "Diese E-Mail existiert bereits.";
    const ERROR_REGISTRATION = "E-Mail oder Passwort stimmen nicht überein.";

    // Roles
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    // Use Cases
    const HELLO = 'Herzlich Willkommen!';
}
