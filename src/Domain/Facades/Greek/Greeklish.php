<?php

namespace DevPM\Domain\Facades\Greek;

class Greeklish
{
    private static array $lookout_table = [
        'α' => 'a',
        'ά' => 'a',
        'ε' => 'e',
        'έ' => 'e',
        'ι' => 'i',
        'ί' => 'i',
        'η' => 'i',
        'ή' => 'i',
        'υ' => 'u',
        'ύ' => 'u',
        'ο' => 'o',
        'ό' => 'o',
        'ω' => 'o',
        'ώ' => 'o',
        'β' => 'b',
        'γ' => 'g',
        'δ' => 'd',
        'ζ' => 'z',
        'θ' => 'th',
        'κ' => 'k',
        'λ' => 'l',
        'μ' => 'm',
        'ν' => 'n',
        'ξ' => 'x',
        'π' => 'p',
        'ρ' => 'r',
        'σ' => 's',
        'ς' => 's',
        'τ' => 't',
        'φ' => 'f',
        'χ' => 'x',
        'ψ' => 'ps',
        ' ' => ' ',
        '-' => '-',
        'a' => 'a',
        'b' => 'b',
        'c' => 'c',
        'd' => 'd',
        'e' => 'e',
        'f' => 'f',
        'g' => 'g',
        'h' => 'h',
        'i' => 'i',
        'j' => 'j',
        'k' => 'k',
        'l' => 'l',
        'm' => 'm',
        'n' => 'n',
        'o' => 'o',
        'p' => 'p',
        'q' => 'q',
        'r' => 'r',
        's' => 's',
        't' => 't',
        'u' => 'u',
        'v' => 'v',
        'w' => 'w',
        'x' => 'x',
        'y' => 'y',
        'z' => 'z',
    ];

    public static array $unaccentCharacters = [
        'Ά' => 'Α',
        'Έ' => 'Ε',
        'Ή' => 'Η',
        'Ί' => 'Ι',
        'Ό' => 'Ο',
        'Ύ' => 'Υ',
        'Ώ' => 'Ω',
        'ά' => 'α',
        'έ' => 'ε',
        'ή' => 'η',
        'ί' => 'ι',
        'ό' => 'ο',
        'ύ' => 'υ',
        'ώ' => 'ω',
        'ΰ' => 'ϋ',
        'ΐ' => 'ϊ',
        'ϊ' => 'ι',
        'ΆΙ' => 'ΑΪ',
        'ΆΥ' => 'ΑΫ',
        'ΈΙ' => 'ΕΪ',
        'ΌΙ' => 'ΟΪ',
        'ΈΥ' => 'ΕΫ',
        'ΌΥ' => 'ΟΫ',
        'άι' => 'αϊ',
        'έι' => 'εϊ',
        'Άυ' => 'αϋ',
        'άυ' => 'αϋ',
        'όι' => 'οϊ',
        'Έυ' => 'εϋ',
        'έυ' => 'εϋ',
        'όυ' => 'οϋ',
        'Όυ' => 'οϋ',
    ];

    private static function mbStringToArray($string): array
    {
        $strlen = mb_strlen($string);
        $array = [];
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, 'UTF-8');
            $string = mb_substr($string, 1, $strlen, 'UTF-8');
            $strlen = mb_strlen($string);
        }

        return $array;
    }

    public static function convert($string): string
    {
        $string = mb_strtolower($string, 'utf8');
        $string = str_replace('&', 'kai', $string);

        $letter_array = static::mbStringToArray($string);
        $letter_array = array_map(function ($letter) {
            if (! isset(static::$lookout_table[$letter])) {
                return '';
            }

            return static::$lookout_table[$letter];
        }, $letter_array);

        return implode('', $letter_array);
    }

    public static function removeAccentsFromText(string $string): string
    {
        $letterArray = static::mbStringToArray($string);
        $letterArray = array_map(function ($letter) {
            if (! isset(static::$unaccentCharacters[$letter])) {
                return $letter;
            }

            return static::$unaccentCharacters[$letter];
        }, $letterArray);

        return implode('', $letterArray);
    }
}
