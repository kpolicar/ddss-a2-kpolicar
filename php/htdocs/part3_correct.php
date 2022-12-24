<?php
try {
    error_reporting(0);
    session_start();
    require_once __DIR__ . '/vendor/autoload.php';

    $queryParams = [];
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $queryParams = $_POST;
        $c_name = $_POST['c_name'];
        $c_author = $_POST['c_author'];
        $c_category_id = $_POST['c_category_id'];
        $c_pricemin = $_POST['c_pricemin'];
        $c_pricemax = $_POST['c_pricemax'];
        $c_search_input = $_POST['c_search_input'];
        $c_search_field = $_POST['c_search_field'];
        $c_radio_match = $_POST['c_radio_match'];
        $c_sp_d = $_POST['c_sp_d'];
        $c_sp_date_range = $_POST['c_sp_date_range'];
        $c_sp_start_month = $_POST['c_sp_start_month'];
        $c_sp_start_day = $_POST['c_sp_start_day'];
        $c_sp_start_year = $_POST['c_sp_start_year'];
        $c_sp_end_month = $_POST['c_sp_end_month'];
        $c_sp_end_day = $_POST['c_sp_end_day'];
        $c_sp_end_year = $_POST['c_sp_end_year'];
        $c_sp_c = $_POST['c_sp_c'];
        $c_sp_m = $_POST['c_sp_m'];
        $c_sp_s = $_POST['c_sp_s'];
    } else{
        $queryParams = $_GET;
        $c_name = $_GET['c_name'];
        $c_author = $_GET['c_author'];
        $c_category_id = $_GET['c_category_id'];
        $c_pricemin = $_GET['c_pricemin'];
        $c_pricemax = $_GET['c_pricemax'];
        $c_search_input = $_GET['c_search_input'];
        $c_search_field = $_GET['c_search_field'];
        $c_radio_match = $_GET['c_radio_match'];
        $c_sp_d = $_GET['c_sp_d'];
        $c_sp_date_range = $_GET['c_sp_date_range'];
        $c_sp_start_month = $_GET['c_sp_start_month'];
        $c_sp_start_day = $_GET['c_sp_start_day'];
        $c_sp_start_year = $_GET['c_sp_start_year'];
        $c_sp_end_month = $_GET['c_sp_end_month'];
        $c_sp_end_day = $_GET['c_sp_end_day'];
        $c_sp_end_year = $_GET['c_sp_end_year'];
        $c_sp_c = $_GET['c_sp_c'];
        $c_sp_m = $_GET['c_sp_m'];
        $c_sp_s = $_GET['c_sp_s'];
    }

    function buildMatchesAnyWordPattern($db, $words) {
        return implode('|', array_map(fn($word) => "(\m".preg_quote($word)."\M)", $words));
    }
    function buildMatchesAllWordsPattern($db, $words) {
        return '^'.implode('', array_map(fn($word) => "(?=.*\m".preg_quote($word)."\M)", $words)).'.*$';
    }
    function buildConditionQueryFragmentForAnyColumnMatchesPattern($db, $fields, $pattern) {
        return implode(' OR ', array_map(fn($field) => "$field ~* ".pg_escape_literal($db, $pattern), $fields));
    }


    $db = pg_connect("host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2");

    $sql="SELECT * FROM books WHERE ";

    $conditions=[];

    if ($c_name) $conditions[] = "title = ".pg_escape_literal($db, $c_name);
    if ($c_author) $conditions[] = "authors = ".pg_escape_literal($db, $c_author);
    if ($c_pricemin) $conditions[] = "price >= ".pg_escape_literal($db, $c_pricemin);
    if ($c_pricemax) $conditions[] = "price <= ".pg_escape_literal($db, $c_pricemax);
    if ($c_category_id) $conditions[] = "category = ".pg_escape_literal($db, $c_category_id);
    if ($c_sp_d == 'custom') {
        $days = $c_sp_date_range;
        if ($days != -1) {
            $conditions[] = "book_date >= current_date - interval ".pg_escape_literal($db, $days.' days');
        }
    } else if ($c_sp_d == 'specific') {
        if ($c_sp_start_month && $c_sp_start_day && $c_sp_start_year) {
            $conditions[] = "book_date >= ".pg_escape_literal($db, "$c_sp_start_year-$c_sp_start_month-$c_sp_start_day");
        }
        if ($c_sp_end_month && $c_sp_end_day && $c_sp_end_year) {
            $conditions[] = "book_date <= ".pg_escape_literal($db, "$c_sp_start_year-$c_sp_start_month-$c_sp_start_day");
        }
    }


    if ($c_search_input) {
        $fields = $c_search_field == 'any'
            ? ['title', 'authors', 'category', 'description', 'keywords', 'notes']
            : [$c_search_field];

        if ($c_radio_match == 'any') {
            $words = preg_split('/\s+/', $c_search_input);
            $conditions[] = '('.buildConditionQueryFragmentForAnyColumnMatchesPattern($db, $fields, buildMatchesAnyWordPattern($db, $words)).')';
        } else if ($c_radio_match == 'all') {
            $words = preg_split('/\s+/', $c_search_input);
            $conditions[] = '('.buildConditionQueryFragmentForAnyColumnMatchesPattern($db, $fields, buildMatchesAllWordsPattern($db, $words)).')';
        } else if ($c_radio_match === 'phrase') {
            $conditions[] = '('.buildConditionQueryFragmentForAnyColumnMatchesPattern($db, $fields, "\m".preg_quote($c_search_input)."\M").')';
        }
    }

    $sql .= implode(' AND ', $conditions);

// if no conditions have been added, remove the 'where' clause
    if (str_ends_with($sql, ' WHERE ')) {
        $sql = str_replace(' WHERE ', '', $sql);
    }

    if ($c_sp_s) {
        $sql .= " ORDER BY ".pg_escape_string($db, $c_sp_s)." DESC";
    }
    if ($c_sp_c) {
        $sql .= " LIMIT ".pg_escape_literal($db, $c_sp_c);
    }

    $_SESSION['sql_books'] = $sql;

    header("Location: /part3.php?".http_build_query($queryParams));
} catch (Exception $e) {
    exit(500);
}