<?php
function containsBadWord($message) {
    // $bad_words = ['dog', 'fuck', 'bsdk', 'bitch']; // vulgar words list
    $bad_words = [
    // English vulgar / explicit words
    'fuck', 'fuk', 'fck', 'shit', 'bitch', 'bastard', 'asshole', 'dick', 'pussy', 'slut', 'whore',
    'motherfucker', 'mf', 'cunt', 'faggot', 'jerk', 'suck my dick', 'cock', 'nigger',

    // Roman Urdu Galiyan & phonetic variations
    'gaand', 'gand', 'gando', 'gandu', 'gaand mara', 'chutiya', 'chootiya', 'bhosri', 'bhosdike', 'bhenchod', 'behnchod',
    'madarchod', 'madharchod', 'mc', 'bc', 'loda', 'lund', 'randi', 'haraami', 'harami', 'kutti', 'kutte', 'kutta',
    'suar', 'suwar', 'chut', 'choot', 'chootad', 'gaandu', 'chakka', 'bakchod', 'bakchodi',

    // Sexual terms / slang
    'sex', 'sexy', 'nude', 'boobs', 'nangi', 'bra', 'panty', 'xxx', '69', 'horny', 'masturbate', 'porn', 'nipple',

    // Insults & racist/abusive remarks
    'jaahil', 'jahil', 'ghatiya', 'kamina', 'kameeni', 'cheap', 'nonsence', 'nasli', 'kutta', 'kaminey', 'tatti', 'gutter', 'lowclass',

    // Spelling evasion / code words
    'b h e n c h o d', 'm a d a r c h o d', 'g a a n d', 's e x', 'b c', 'm c', 'f u c k', 'l u n d', 'chootia', 'lundwa'
];

    preg_match('/\b(' . implode('|', $bad_words) . ')\b/', $message);

    $message = strtolower($message); // case insensitive check

    foreach ($bad_words as $word) {
        if (strpos($message, $word) !== false) {
            return true;
        }
    }
    return false;
}
?>
