# File searcher
File searcher - библиотека, с помощью которой можно искать все вхождения строки в заданном файле.

Возвращает двумерный массив, где индексы подмассивов - номера строк, а значения подмассивов - позиции в текущей строке. Если вхождение не найдено, возвращает пустой массив.

## Требования
Php не ниже 7.2

## Установка
Через [composer](https://getcomposer.org/):

#### `composer require wauxhall/file-searcher`

## Использование
`$searcher = new \Wauxhall\FileSearcher\FileSearcher("path_to_file_or_url");
$result = $searcher->search("searchString");`

В переменной **$result** будет лежать двумерный массив вида:

`[ 0 => [ 1, 56 ], 5 => [ 3 ] ]`

где 0 и 5 - номера строк файла, где найдена строка, а подмассивы - позиции в строке.

В случае ошибок, библиотека кидает **LogicException** или **RuntimeException** в зависимости от природы ошибки.

В конструктор необходимо передать локальный путь к файлу или url, по которому его можно скачать, тогда библиотека автоматически скачает файл в локальное хранилище.

Также, программа по умолчанию производит автоматическую валидацию заданного в конструкторе файла. Чтобы отключить ее, передайте в конструктор второй параметр = **true**. Это отключит проверку файла.

## Конфигурирование
В корне библиотеки в папке config лежит **common.yaml** - в нем можно выставлять желаемые настройки. Пока в нем доступны только правила валидации файла.

## Разработка
Библиотека позволяет писать свои модули. Пример простого модуля уже присутствует в библиотеке - класс **HashsumChecker** (модуль сравнивает поданный на вход хэш и хэш-сумму файла).

Для написания модуля, достаточно наследовать свой класс от абстрактного **FileLib**. Это позволит использовать возможности библиотеки, такие, как чтение файла, валидация, скачивание с удаленного сервера.

## Тесты
Тесты расположены в папке **_tests_**. Главный тест - FileSearcherTest, позволяет протестировать полную работу библиотеки.

## Устранение проблем
Библиотека использует расширение **_finfo_**, которое по умолчанию идет с Php, однако на платформах Windows может возникнуть ошибка вида

`class finfo not found`

Для устранения этой проблемы, достаточно вписать в ваш _**php.ini**_ строку: `extension=php_fileinfo.dll`