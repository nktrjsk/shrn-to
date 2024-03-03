<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/static/php/dbh.php";

function get_categories()
{
    global $db;

    $recurse = function ($item, &$categories, $depth) use (&$recurse)
    {

        foreach ($categories as $cat_item => $value)
        {
            if ($item[3] == $cat_item)
            {
                $categories[$cat_item] += [$item[0] => []];
            }
            else
            {
                $recurse($item, $categories[$cat_item], ++$depth);
            }
        }
    };

    $categories = [];
    $items = $db->fetch_all("SELECT * FROM kategorie");

    foreach ($items as $item)
    {
        if ($item[3] == 0)
        {
            $categories += [$item[0] => []];
        }
        else
        {
            $recurse($item, $categories, 1);
        }
    }

    return $categories;
}