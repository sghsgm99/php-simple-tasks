<?php
    $csv_file    = file_get_contents('medianet - report 1.csv');
    $txt_file    = file_get_contents('keywords.txt');
    $rows        = explode("\n", $txt_file);
    array_shift($rows);

    foreach($rows as $row => $data)
    {
        $cmp_str = $data;

        $rm_str = str_replace(' ', '', $cmp_str);

        $csv_file = str_replace($rm_str, $cmp_str, $csv_file);
    }

    $file = 'medianet - report 1(new).csv';

    file_put_contents($file, $csv_file);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Content-Length: ' . filesize($file));
    header('Pragma: public');

    flush();
    readfile($file,true);

    die;
?>