<?php

namespace Helpers;

class Str
{
    /**
     * Массив замен букв.
     *
     * @var array
     */
    protected static array $replacementList = [
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

        'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
        'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
        'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
        'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
        'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
        'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
        'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
    ];

    /**
     * Массив символов
     *
     * @var array
     * */
    protected static array $symbols = [
        ',;:!?.$/*-+&@_+;./*&?$-!,',
        'abcdefghijklmnopqrstuvwxyz',
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        '1234567890'
    ];


    /**
     * Заменить русские буквы на английские.
     *
     * @param string $text
     *
     * @return string
     */
    public static function transliterate(string $text) {
        return strtr($text, static::$replacementList);
    }

    /**
     * Генерация полностью случайной строки
     * с учетом спец. символов
     *
     * @param int $size
     *
     * @return string $text
     */
    public static function fullyRandomString(int $size) {
        $text = '';
        for ($i = 1; $i <= $size; $i++) {
            $text .= substr(str_shuffle(static::$symbols[rand(0, count(static::$symbols)-1)]), 0, 1);
        }
        return $text;
    }
}
