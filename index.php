<?php

require_once 'CsvIterator.php';

$csv = new CsvIterator(__DIR__ .DIRECTORY_SEPARATOR . 'input.html' , '<');

foreach ($csv as $row) {
    
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'output.html';
    $record = true;                                                 // разрешение записи следующей строки
    $i=1;                                                           
    // цикл перебора строки 
    while (isset ($row[$i])) { 
        if ((strpos ($row[$i], 'title>') !== false) ||              // если в строке найдены искомые фразы
            (strpos ($row[$i], 'keywords') !== false)) { 
                unset ($row[$i]);                                   // удаляем элемент строки
                $record = false;                                    // выходим из цикла без записи перехода на следующую строку
                                                                    // иначе в исходном файле будут пустые строки
            }                  
        else file_put_contents($file,  '<'. $row[$i] , FILE_APPEND); // записываем строку в файл
        $i++;
    }

    if ($record) file_put_contents($file, "\n" , FILE_APPEND);     // запись перехода на следующую строку
}

if (file_exists (__DIR__ . DIRECTORY_SEPARATOR . 'output.html')) {
    $data = 'файл успешно записан!';
}
else $data='что-то пошло не так';
?>

<h2 align= center><?php echo $data?></h2>

