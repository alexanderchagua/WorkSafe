<?php
/*
 * Custom functions library
 */

// Validates email address
function checkEmail($clientEmail)
{
    return filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
}

/**
 * Checks password:
 * - Minimum 8 characters
 * - At least 1 uppercase
 * - At least 1 lowercase
 * - At least 1 number
 * - At least 1 special character (non-word character)
 */
function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).{8,}$/';
    return preg_match($pattern, $clientPassword);
}
