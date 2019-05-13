<?php

// data from the $_POST


$title = $_POST['title'];
$text = $_POST['text'];


// validation: if no data was sent from the form

foreach ($_POST as $input) {			
	if(empty($input)){
		$errorMessage = 'The fields should not be empty';
		include 'errors.php';
		exit;
	}
}

// check the image

// variables:

$filePath  = $_FILES['upload']['tmp_name'];
$errorCode = $_FILES['upload']['error'];

// validation for image

if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {

    // arrayWithNAmes
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
        UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
        UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
        UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
        UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
        UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
        UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
    ];

    // Default unknown error
    $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

    // if the array does not have the variable - then displays unknown message
    $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;

    // displays the name of the error
    die($outputMessage);
}

// Создадим ресурс FileInfo
$fi = finfo_open(FILEINFO_MIME_TYPE);

// Получим MIME-тип
$mime = (string) finfo_file($fi, $filePath);

// Проверим ключевое слово image (image/jpeg, image/png и т. д.)
if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');


// Результат функции запишем в переменную
$image = getimagesize($filePath);

// Зададим ограничения для картинок
$limitBytes  = 1024 * 1024 * 5;
$limitWidth  = 1280;
$limitHeight = 768;

// Проверим нужные параметры
if (filesize($filePath) > $limitBytes) die('Размер изображения не должен превышать 5 Мбайт.');
if ($image[1] > $limitHeight)          die('Высота изображения не должна превышать 768 точек.');
if ($image[0] > $limitWidth)           die('Ширина изображения не должна превышать 1280 точек.');


// Сгенерируем новое имя файла на основе MD5-хеша
$name = md5_file($filePath);

// Сгенерируем расширение файла на основе типа картинки
$extension = image_type_to_extension($image[2]);

// Сократим .jpeg до .jpg
$format = str_replace('jpeg', 'jpg', $extension);









// preparation SQL query

$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');

$sql = 'INSERT INTO posts (title, text) VALUES (:title, :text)';
$statement = $pdo->prepare($sql);

// execute the query

$result = $statement->execute($_POST);				


header('Location: /task_manager-markup/index.php');