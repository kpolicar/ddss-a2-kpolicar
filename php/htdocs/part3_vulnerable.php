<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$queryParams = [];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $queryParams = $_POST;
    $v_name = $_POST['v_name'];
    $v_author = $_POST['v_author'];
    $v_category_id = $_POST['v_category_id'];
    $v_pricemin = $_POST['v_pricemin'];
    $v_pricemax = $_POST['v_pricemax'];
    $v_search_input = $_POST['v_search_input'];
    $v_search_field = $_POST['v_search_field'];
    $v_radio_match = $_POST['v_radio_match'];
    $v_sp_d = $_POST['v_sp_d'];
    $v_sp_date_range = $_POST['v_sp_date_range'];
    $v_sp_start_month = $_POST['v_sp_start_month'];
    $v_sp_start_day = $_POST['v_sp_start_day'];
    $v_sp_start_year = $_POST['v_sp_start_year'];
    $v_sp_end_month = $_POST['v_sp_end_month'];
    $v_sp_end_day = $_POST['v_sp_end_day'];
    $v_sp_end_year = $_POST['v_sp_end_year'];
    $v_sp_c = $_POST['v_sp_c'];
    $v_sp_m = $_POST['v_sp_m'];
    $v_sp_s = $_POST['v_sp_s'];
} else{
    $queryParams = $_GET;
    $v_name = $_GET['v_name'];
    $v_author = $_GET['v_author'];
    $v_category_id = $_GET['v_category_id'];
    $v_pricemin = $_GET['v_pricemin'];
    $v_pricemax = $_GET['v_pricemax'];
    $v_search_input = $_GET['v_search_input'];
    $v_search_field = $_GET['v_search_field'];
    $v_radio_match = $_GET['v_radio_match'];
    $v_sp_d = $_GET['v_sp_d'];
    $v_sp_date_range = $_GET['v_sp_date_range'];
    $v_sp_start_month = $_GET['v_sp_start_month'];
    $v_sp_start_day = $_GET['v_sp_start_day'];
    $v_sp_start_year = $_GET['v_sp_start_year'];
    $v_sp_end_month = $_GET['v_sp_end_month'];
    $v_sp_end_day = $_GET['v_sp_end_day'];
    $v_sp_end_year = $_GET['v_sp_end_year'];
    $v_sp_c = $_GET['v_sp_c'];
    $v_sp_m = $_GET['v_sp_m'];
    $v_sp_s = $_GET['v_sp_s'];
}

function buildMatchesAnyWordPattern($words) {
    return implode('|', array_map(fn($word) => "(\m$word\M)", $words));
}
function buildMatchesAllWordsPattern($words) {
    return '^'.implode('', array_map(fn($word) => "(?=.*\m$word\M)", $words)).'.*$';
}
function buildConditionQueryFragmentForAnyColumnMatchesPattern($fields, $pattern) {
    return implode(' OR ', array_map(fn($field) => "$field ~* '$pattern'", $fields));
}


$db = pg_connect("host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2");

$sql="SELECT * FROM books WHERE ";

$conditions=[];

if ($v_name) $conditions[] = "title = '$v_name'";
if ($v_author) $conditions[] = "author = '$v_author'";
if ($v_pricemin) $conditions[] = "price >= $v_pricemin";
if ($v_pricemax) $conditions[] = "price <= $v_pricemax";
if ($v_category_id) $conditions[] = "category = '$v_category_id'";


if ($v_search_input) {
    $fields = $v_search_field == 'any'
        ? ['title', 'authors']
        : [$v_search_field];

    if ($v_radio_match == 'any') {
        $words = preg_split('/\s+/', $v_search_input);
        $conditions[] = '('.buildConditionQueryFragmentForAnyColumnMatchesPattern($fields, buildMatchesAnyWordPattern($words)).')';
    } else if ($v_radio_match == 'all') {
        $words = preg_split('/\s+/', $v_search_input);
        $conditions[] = '('.buildConditionQueryFragmentForAnyColumnMatchesPattern($fields, buildMatchesAllWordsPattern($words)).')';
    } else if ($v_radio_match === 'phrase') {
        $conditions[] = '('.buildConditionQueryFragmentForAnyColumnMatchesPattern($fields, "\m$v_search_input\M").')';
    }
}

$sql .= implode(' AND ', $conditions);

// if no conditions have been added, remove the 'where' clause
if (str_ends_with($sql, ' WHERE ')) {
    $sql = str_replace(' WHERE ', '', $sql);
}

if ($v_sp_s) {
    $sql .= " ORDER BY $v_sp_s DESC";
}
if ($v_sp_c) {
    $sql .= " LIMIT $v_sp_c";
}

$_SESSION['sql_books'] = $sql;

header("Location: /part3.php?".http_build_query($queryParams));