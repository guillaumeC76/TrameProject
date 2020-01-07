<?php

///////////////////////////////////////
// FONCTION DE CLEAN
///////////////////////////////////////

function clean($string) {
    $cleaner = trim(strip_tags($string));
    return $cleaner; }


function debug($tableau) {
    echo '<pre>'; print_r($tableau); echo '</pre>';
}

///////////////////////////////////////
// FONCTION DE VALIDATION DE L'EMAIL
///////////////////////////////////////

function emailValid($err, $mail, $key) {
    if (!empty($mail)) {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $err[$key] = 'Email non valide';
        }
    } else {
        $err[$key] = "Veuillez renseigner ce champ";
    }
    return $err;
}

///////////////////////////////////////
// FONCTION DE VALIDATION DES TEXTES
///////////////////////////////////////

function textValid($err, $text, $key, $x, $y) {
    if (!empty($text)) {
        if (mb_strlen($text) < $x) {
            $err[$key] = 'Minimum '.$x.' caractères';
        }elseif (mb_strlen($text) > $y) {
            $err[$key] = 'Maximum '.$y.' caractères';
        }
    }else {
        $err[$key] = 'Veuillez renseigner ce champ';
    }
    return $err;
}
