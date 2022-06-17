<?php
echo "<link rel='stylesheet' href='style.css'>";

$array = include_once 'parts/array.php';
$arrayUrl = include_once 'parts/arrayUrl.php';
$testArray = include_once 'parts/testArray.php';
$testArray2 = include_once 'parts/testArray2.php';

foreach ($array as $k => $item) {                       /* перебираем массив первый по ключам => элементам */

    $array1string = implode('',$item);          /* Каждый элемент массива в строку implode() */
    echo '<div>'.$array1string.'</div>';
    $url = TranslitURL($array1string);                  /* Преобразовываем транслитом с русского название в вид url строки */

    $array2string = implode('', $arrayUrl[$k]); /* Второй массив параллельно выводим по ключам и преобразовываем в строку */
    $explode = explode("/", $array2string);     /* разбиваю строку на массив, сепаратором является слэш*/

    array_pop($explode);                          /* Удаляем последний элемент массива */
    array_push($explode, $url);                   /* Добавляем на его место новый */

    $text = implode('/', $explode);
    echo '<div>'.$text.'</div>';
//    $filename = 'somefile.txt';
//    file_put_contents($filename, $text.PHP_EOL, FILE_APPEND); /* Запись в файл*/
}

function TranslitURL ($text, $translit = 'ru_en') {     /* $translit можно поменять с английского на русский, если передать аргументов в вызове функции*/

    $RU['ru'] = array(                                  /* Русские буквы заменяются на английские */
        'Ё', 'Ж', 'Ц', 'Ч', 'Щ', 'Ш', 'Ы',
        'Э', 'Ю', 'Я', 'ё', 'ж', 'ц', 'ч',
        'ш', 'щ', 'ы', 'э', 'ю', 'я', 'А',
        'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И',
        'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
        'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ъ',
        'Ь', 'а', 'б', 'в', 'г', 'д', 'е',
        'з', 'и', 'й', 'к', 'л', 'м', 'н',
        'о', 'п', 'р', 'с', 'т', 'у', 'ф',
        'х', 'ъ', 'ь', '/', '.'
    );

    $EN['en'] = array(
        "Yo", "Zh",  "Cz", "Ch", "Shh","Sh", "Y'",
        "E'", "Yu",  "Ya", "yo", "zh", "cz", "ch",
        "sh", "shh", "y'", "e'", "yu", "ya", "A",
        "B" , "V" ,  "G",  "D",  "E",  "Z",  "I",
        "Y",  "K",   "L",  "M",  "N",  "O",  "P",
        "R",  "S",   "T",  "U",  "F",  "Kh",  "''",
        "'",  "a",   "b",  "v",  "g",  "d",  "e",
        "z",  "i",   "y",  "k",  "l",  "m",  "n",
        "o",  "p",   "r",  "s",  "t",  "u",  "f",
        "h",  "''",  "'",  "-", "-"
    );
    if($translit == 'en_ru') {
        $t = str_replace($EN['en'], $RU['ru'], $text);
        $t = preg_replace('/(?<=[а-яё])Ь/u', 'ь', $t);
        $t = preg_replace('/(?<=[а-яё])Ъ/u', 'ъ', $t);
    }
    else {

        $t = str_replace($RU['ru'], $EN['en'], $text);
        $t = preg_replace("/[\s]+/u", "-", $t);
        $t = preg_replace("/[^a-z0-9_\-]/iu", "", $t);
        $t = strtolower($t);
    }
    return $t;
}