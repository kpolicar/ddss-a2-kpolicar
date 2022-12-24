<?php require_once __DIR__ . '/vendor/autoload.php';
session_start();
$db = pg_connect("host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2");
?>
<!DOCTYPE html>
<!--

    =========================================
    Design and Development of Secure Software
    ============= MSI 2019/2020 =============
    ======== Practical Assignment #2 ========
    ================ Part #1 ================
    =========================================

      Department of Informatics Engineering
              University of Coimbra          
   
        Nuno Antunes <nmsa@dei.uc.pt>
        João Antunes <jcfa@dei.uc.pt>
        Marco Vieira <mvieira@dei.uc.pt>
   
-->
<html>
    <head>
        <title>DDSS PA2 - Part 1.3</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--
            V3-php info:
            - corrected a few naming bugs in the inputs
            - fixed a few syntax issues in the HTML
            - added some explanations
            - corrected the form actions for php
        -->
    </head>
    <body>
        <div align="center">

            <h1>Design and Development of Secure Software</h1>
            <h2>Practical Assignment #2 - Part 1.3</h2>
            <div align="center">
                DISCLAIMER: This code is to be used in the scope of the <em>DDSS</em> course.
                <b>Important:</b> these sources are merely suggestions of implementations. 
                You should modify everything you deem as necessary and be responsible for all the content that is delivered.
                <em>The contents of this repository do not replace the proper reading of the assignment description.</em>
            </div>
            <br>
            <br>


            <table>

                <tr><td>

                        <form action="/part3_vulnerable.php" method="POST">
                            <input type="hidden" name="v_dbcredentials" value="host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2">


                            <table border="1" cellpadding="1" style="font-size: 10pt; width: 400px; background-color:#f1f1f1">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-size: 12pt;"><b>Part 3.0 - Vulnerable Form</b></th>
                                    </tr>
                                </thead>


                                <tbody>

                                    <tr>
                                        <td valign="middle">Title</td>
                                        <td style="border-width: 1pt"><input type="text"  name="v_name" maxlength="200"  value="<?= $_GET['v_name'] ?? '' ?>" size="20"></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Author</td>
                                        <td style="border-width: 1pt"><input type="text"  name="v_author" maxlength="100"  value="<?= $_GET['v_author'] ?? '' ?>" size="20"></td>
                                    </tr>

                                    <tr>
                                        <td valign="middle">Category</td>
                                        <td style="border-width: 1pt">
                                            <select name="v_category_id">
                                                <option value="">All</option>
                                                <option value="Databases" <?= ($_GET['v_category_id'] ?? '') == 'Databases' ? 'selected' : '' ?>>Databases</option>
                                                <option value="HTML & Web design" <?= ($_GET['v_category_id'] ?? '') == 'HTML & Web design' ? 'selected' : '' ?>>HTML &amp; Web design</option>
                                                <option value="Programming" <?= ($_GET['v_category_id'] ?? '') == 'Programming' ? 'selected' : '' ?>>Programming</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Price more then</td>
                                        <td style="border-width: 1pt"><input type="text"  name="v_pricemin" maxlength="100" value="<?= $_GET['v_pricemin'] ?? '' ?>" size="10"></td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">Price less then</td>
                                        <td style="border-width: 1pt"><input type="text"  name="v_pricemax" maxlength="100" value="<?= $_GET['v_pricemax'] ?? '' ?>" size="10"></td>
                                    </tr>


                                    <tr>
                                        <td colspan="2" align="center" valign="middle">Advanced</td>
                                    </tr>
                                    <tr>
                                        <td valign="middle">
                                            Search For:<br>
                                        </td>
                                        <td >
                                            <input size=35 name="v_search_input" value="<?= $_GET['v_search_input'] ?? '' ?>">
                                        </td>
                                    </tr>
                                    <tr><td valign="middle">
                                            Within: 
                                        </td>
                                        <td><select name="v_search_field" size=1>
                                                <option value="any" <?= ($_GET['v_search_field'] ?? '') == 'any' ? 'selected' : '' ?>>Anywhere</option>
                                                <option value="title" <?= ($_GET['v_search_field'] ?? '') == 'title' ? 'selected' : '' ?>>Title</option>
                                                <option value="authors" <?= ($_GET['v_search_field'] ?? '') == 'authors' ? 'selected' : '' ?>>Authors</option>
                                                <option value="desc" <?= ($_GET['v_search_field'] ?? '') == 'desc' ? 'selected' : '' ?>>Description</option>
                                                <option value="keys" <?= ($_GET['v_search_field'] ?? '') == 'keys' ? 'selected' : '' ?>>Keywords</option>
                                                <option value="notes" <?= ($_GET['v_search_field'] ?? '') == 'notes' ? 'selected' : '' ?>>Notes</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <!-- Allow "any," "all," or "phrase" -->
                                    <tr>
                                        <td valign="middle">
                                            Match: 
                                        </td>
                                        <td>
                                            <input type=radio name="v_radio_match" value="any" <?= ($_GET['v_radio_match'] ?? 'any') == 'any' ? 'checked="checked"' : '' ?>>Any word <br>
                                            <input type=radio name="v_radio_match" value="all" <?= ($_GET['v_radio_match'] ?? null) == 'all' ? 'checked="checked"' : '' ?>>All words <br>
                                            <input type=radio name="v_radio_match" value="phrase" <?= ($_GET['v_radio_match'] ?? null) == 'phrase' ? 'checked="checked"' : '' ?>>Exact phrase<br>
                                        </td>
                                    </tr>
                                    <!-- Date range criteria -->
                                    <tr>
                                        <td colspan="2" align="center">Date</td>
                                    </tr>
                                    <tr>
                                        <td align=right>
                                            <input type=radio name="v_sp_d" value="custom" <?= ($_GET['v_sp_d'] ?? 'custom') == 'custom' ? 'checked="checked"' : '' ?>>
                                        </td>
                                        <td>
                                            <select name="v_sp_date_range" size=1>
                                                <option value=-1 <?= ($_GET['v_sp_date_range'] ?? -1) == -1 ? 'selected' : '' ?>>Anytime</option>
                                                <option value=7 <?= ($_GET['v_sp_date_range'] ?? -1) == 7 ? 'selected' : '' ?>>Within the last week</option>
                                                <option value=14 <?= ($_GET['v_sp_date_range'] ?? -1) == 14 ? 'selected' : '' ?>>Within the last 2 weeks</option>
                                                <option value=30 <?= ($_GET['v_sp_date_range'] ?? -1) == 30 ? 'selected' : '' ?>>Within the last 30 days</option>
                                                <option value=60 <?= ($_GET['v_sp_date_range'] ?? -1) == 60 ? 'selected' : '' ?>>Within the last 60 days</option>
                                                <option value=90 <?= ($_GET['v_sp_date_range'] ?? -1) == 90 ? 'selected' : '' ?>>Within the last 90 days</option>
                                                <option value=180 <?= ($_GET['v_sp_date_range'] ?? -1) == 180 ? 'selected' : '' ?>>Within the last 180 days</option>
                                                <option value=365 <?= ($_GET['v_sp_date_range'] ?? -1) == 365 ? 'selected' : '' ?>>Within the last year</option>
                                                <option value=730 <?= ($_GET['v_sp_date_range'] ?? -1) == 730 ? 'selected' : '' ?>>Within the last two years</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan=2 align=right>
                                            <input type=radio name="v_sp_d" value="specific" <?= ($_GET['v_sp_d'] ?? null) == 'specific' ? 'checked="checked"' : '' ?>>
                                        </td>
                                        <td>From:
                                            <select name="v_sp_start_month" size=1>
                                                <option value=0 <?= ($_GET['v_sp_start_month'] ?? 0) == 0 ? 'selected' : '' ?>></option>
                                                <option value=1 <?= ($_GET['v_sp_start_month'] ?? 0) == 1 ? 'selected' : '' ?>>January</option>
                                                <option value=2 <?= ($_GET['v_sp_start_month'] ?? 0) == 2 ? 'selected' : '' ?>>February</option>
                                                <option value=3 <?= ($_GET['v_sp_start_month'] ?? 0) == 3 ? 'selected' : '' ?>>March</option>
                                                <option value=4 <?= ($_GET['v_sp_start_month'] ?? 0) == 4 ? 'selected' : '' ?>>April</option>
                                                <option value=5 <?= ($_GET['v_sp_start_month'] ?? 0) == 5 ? 'selected' : '' ?>>May</option>
                                                <option value=6 <?= ($_GET['v_sp_start_month'] ?? 0) == 6 ? 'selected' : '' ?>>June</option>
                                                <option value=7 <?= ($_GET['v_sp_start_month'] ?? 0) == 7 ? 'selected' : '' ?>>July</option>
                                                <option value= <?= ($_GET['v_sp_start_month'] ?? 0) == 8 ? 'selected' : '' ?>>August</option>
                                                <option value=9 <?= ($_GET['v_sp_start_month'] ?? 0) == 9 ? 'selected' : '' ?>>September</option>
                                                <option value=10 <?= ($_GET['v_sp_start_month'] ?? 0) == 10 ? 'selected' : '' ?>>October</option>
                                                <option value=11 <?= ($_GET['v_sp_start_month'] ?? 0) == 11 ? 'selected' : '' ?>>November</option>
                                                <option value=12 <?= ($_GET['v_sp_start_month'] ?? 0) == 12 ? 'selected' : '' ?>>December</option>
                                            </select>
                                            <select name="v_sp_start_day" size=1>
                                                <option value=0 <?= ($_GET['v_sp_start_day'] ?? 0) == 0 ? 'selected' : '' ?>></option>
                                                <option value=1 <?= ($_GET['v_sp_start_day'] ?? 0) == 1 ? 'selected' : '' ?>>1</option>
                                                <option value=2 <?= ($_GET['v_sp_start_day'] ?? 0) == 2 ? 'selected' : '' ?>>2</option>
                                                <option value=3 <?= ($_GET['v_sp_start_day'] ?? 0) == 3 ? 'selected' : '' ?>>3</option>
                                                <option value=4 <?= ($_GET['v_sp_start_day'] ?? 0) == 4 ? 'selected' : '' ?>>4</option>
                                                <option value=5 <?= ($_GET['v_sp_start_day'] ?? 0) == 5 ? 'selected' : '' ?>>5</option>
                                                <option value=6 <?= ($_GET['v_sp_start_day'] ?? 0) == 6 ? 'selected' : '' ?>>6</option>
                                                <option value=7 <?= ($_GET['v_sp_start_day'] ?? 0) == 7 ? 'selected' : '' ?>>7</option>
                                                <option value=8 <?= ($_GET['v_sp_start_day'] ?? 0) == 8 ? 'selected' : '' ?>>8</option>
                                                <option value=9 <?= ($_GET['v_sp_start_day'] ?? 0) == 9 ? 'selected' : '' ?>>9</option>
                                                <option value=10 <?= ($_GET['v_sp_start_day'] ?? 0) == 10 ? 'selected' : '' ?>>10</option>
                                                <option value=11 <?= ($_GET['v_sp_start_day'] ?? 0) == 11 ? 'selected' : '' ?>>11</option>
                                                <option value=12 <?= ($_GET['v_sp_start_day'] ?? 0) == 12 ? 'selected' : '' ?>>12</option>
                                                <option value=13 <?= ($_GET['v_sp_start_day'] ?? 0) == 13 ? 'selected' : '' ?>>13</option>
                                                <option value=14 <?= ($_GET['v_sp_start_day'] ?? 0) == 14 ? 'selected' : '' ?>>14</option>
                                                <option value=15 <?= ($_GET['v_sp_start_day'] ?? 0) == 15 ? 'selected' : '' ?>>15</option>
                                                <option value=16 <?= ($_GET['v_sp_start_day'] ?? 0) == 16 ? 'selected' : '' ?>>16</option>
                                                <option value=17 <?= ($_GET['v_sp_start_day'] ?? 0) == 17 ? 'selected' : '' ?>>17</option>
                                                <option value=18 <?= ($_GET['v_sp_start_day'] ?? 0) == 18 ? 'selected' : '' ?>>18</option>
                                                <option value=19 <?= ($_GET['v_sp_start_day'] ?? 0) == 19 ? 'selected' : '' ?>>19</option>
                                                <option value=20 <?= ($_GET['v_sp_start_day'] ?? 0) == 20 ? 'selected' : '' ?>>20</option>
                                                <option value=21 <?= ($_GET['v_sp_start_day'] ?? 0) == 21 ? 'selected' : '' ?>>21</option>
                                                <option value=22 <?= ($_GET['v_sp_start_day'] ?? 0) == 22 ? 'selected' : '' ?>>22</option>
                                                <option value=23 <?= ($_GET['v_sp_start_day'] ?? 0) == 23 ? 'selected' : '' ?>>23</option>
                                                <option value=24 <?= ($_GET['v_sp_start_day'] ?? 0) == 24 ? 'selected' : '' ?>>24</option>
                                                <option value=25 <?= ($_GET['v_sp_start_day'] ?? 0) == 25 ? 'selected' : '' ?>>25</option>
                                                <option value=26 <?= ($_GET['v_sp_start_day'] ?? 0) == 26 ? 'selected' : '' ?>>26</option>
                                                <option value=27 <?= ($_GET['v_sp_start_day'] ?? 0) == 27 ? 'selected' : '' ?>>27</option>
                                                <option value=28 <?= ($_GET['v_sp_start_day'] ?? 0) == 28 ? 'selected' : '' ?>>28</option>
                                                <option value=29 <?= ($_GET['v_sp_start_day'] ?? 0) == 29 ? 'selected' : '' ?>>29</option>
                                                <option value=30 <?= ($_GET['v_sp_start_day'] ?? 0) == 30 ? 'selected' : '' ?>>30</option>
                                                <option value=31 <?= ($_GET['v_sp_start_day'] ?? 0) == 31 ? 'selected' : '' ?>>31</option>
                                            </select>
                                            <!--comma-->,
                                            <input size=4 name="v_sp_start_year" value="<?= ($_GET['v_sp_start_year'] ?? '')?>">
                                        </td></tr>
                                    <tr>
                                        <td>To:

                                            <select name="v_sp_end_month" size=1>
                                                <option value=0 <?= ($_GET['v_sp_end_month'] ?? 0) == 0 ? 'selected' : '' ?>></option>
                                                <option value=1 <?= ($_GET['v_sp_end_month'] ?? 0) == 1 ? 'selected' : '' ?>>January</option>
                                                <option value=2 <?= ($_GET['v_sp_end_month'] ?? 0) == 2 ? 'selected' : '' ?>>February</option>
                                                <option value=3 <?= ($_GET['v_sp_end_month'] ?? 0) == 3 ? 'selected' : '' ?>>March</option>
                                                <option value=4 <?= ($_GET['v_sp_end_month'] ?? 0) == 4 ? 'selected' : '' ?>>April</option>
                                                <option value=5 <?= ($_GET['v_sp_end_month'] ?? 0) == 5 ? 'selected' : '' ?>>May</option>
                                                <option value=6 <?= ($_GET['v_sp_end_month'] ?? 0) == 6 ? 'selected' : '' ?>>June</option>
                                                <option value=7 <?= ($_GET['v_sp_end_month'] ?? 0) == 7 ? 'selected' : '' ?>>July</option>
                                                <option value=8 <?= ($_GET['v_sp_end_month'] ?? 0) == 8 ? 'selected' : '' ?>>August</option>
                                                <option value=9 <?= ($_GET['v_sp_end_month'] ?? 0) == 9 ? 'selected' : '' ?>>September</option>
                                                <option value=10 <?= ($_GET['v_sp_end_month'] ?? 0) == 10 ? 'selected' : '' ?>>October</option>
                                                <option value=11 <?= ($_GET['v_sp_end_month'] ?? 0) == 11 ? 'selected' : '' ?>>November</option>
                                                <option value=12 <?= ($_GET['v_sp_end_month'] ?? 0) == 12 ? 'selected' : '' ?>>December</option>
                                            </select>
                                            <select name="v_sp_end_day" size=1>
                                                <option value=0 <?= ($_GET['v_sp_end_day'] ?? 0) == 0 ? 'selected' : '' ?> selected></option>
                                                <option value=1 <?= ($_GET['v_sp_end_day'] ?? 0) == 1 ? 'selected' : '' ?>>1</option>
                                                <option value=2 <?= ($_GET['v_sp_end_day'] ?? 0) == 2 ? 'selected' : '' ?>>2</option>
                                                <option value=3 <?= ($_GET['v_sp_end_day'] ?? 0) == 3 ? 'selected' : '' ?>>3</option>
                                                <option value=4 <?= ($_GET['v_sp_end_day'] ?? 0) == 4 ? 'selected' : '' ?>>4</option>
                                                <option value=5 <?= ($_GET['v_sp_end_day'] ?? 0) == 5 ? 'selected' : '' ?>>5</option>
                                                <option value=6 <?= ($_GET['v_sp_end_day'] ?? 0) == 6 ? 'selected' : '' ?>>6</option>
                                                <option value=7 <?= ($_GET['v_sp_end_day'] ?? 0) == 7 ? 'selected' : '' ?>>7</option>
                                                <option value=8 <?= ($_GET['v_sp_end_day'] ?? 0) == 8 ? 'selected' : '' ?>>8</option>
                                                <option value=9 <?= ($_GET['v_sp_end_day'] ?? 0) == 9 ? 'selected' : '' ?>>9</option>
                                                <option value=10 <?= ($_GET['v_sp_end_day'] ?? 0) == 10 ? 'selected' : '' ?>>10</option>
                                                <option value=11 <?= ($_GET['v_sp_end_day'] ?? 0) == 11 ? 'selected' : '' ?>>11</option>
                                                <option value=12 <?= ($_GET['v_sp_end_day'] ?? 0) == 12 ? 'selected' : '' ?>>12</option>
                                                <option value=13 <?= ($_GET['v_sp_end_day'] ?? 0) == 13 ? 'selected' : '' ?>>13</option>
                                                <option value=14 <?= ($_GET['v_sp_end_day'] ?? 0) == 14 ? 'selected' : '' ?>>14</option>
                                                <option value=15 <?= ($_GET['v_sp_end_day'] ?? 0) == 15 ? 'selected' : '' ?>>15</option>
                                                <option value=16 <?= ($_GET['v_sp_end_day'] ?? 0) == 16 ? 'selected' : '' ?>>16</option>
                                                <option value=17 <?= ($_GET['v_sp_end_day'] ?? 0) == 17 ? 'selected' : '' ?>>17</option>
                                                <option value=18 <?= ($_GET['v_sp_end_day'] ?? 0) == 18 ? 'selected' : '' ?>>18</option>
                                                <option value=19 <?= ($_GET['v_sp_end_day'] ?? 0) == 19 ? 'selected' : '' ?>>19</option>
                                                <option value=20 <?= ($_GET['v_sp_end_day'] ?? 0) == 20 ? 'selected' : '' ?>>20</option>
                                                <option value=21 <?= ($_GET['v_sp_end_day'] ?? 0) == 21 ? 'selected' : '' ?>>21</option>
                                                <option value=22 <?= ($_GET['v_sp_end_day'] ?? 0) == 22 ? 'selected' : '' ?>>22</option>
                                                <option value=23 <?= ($_GET['v_sp_end_day'] ?? 0) == 23 ? 'selected' : '' ?>>23</option>
                                                <option value=24 <?= ($_GET['v_sp_end_day'] ?? 0) == 24 ? 'selected' : '' ?>>24</option>
                                                <option value=25 <?= ($_GET['v_sp_end_day'] ?? 0) == 25 ? 'selected' : '' ?>>25</option>
                                                <option value=26 <?= ($_GET['v_sp_end_day'] ?? 0) == 26 ? 'selected' : '' ?>>26</option>
                                                <option value=27 <?= ($_GET['v_sp_end_day'] ?? 0) == 27 ? 'selected' : '' ?>>27</option>
                                                <option value=28 <?= ($_GET['v_sp_end_day'] ?? 0) == 28 ? 'selected' : '' ?>>28</option>
                                                <option value=29 <?= ($_GET['v_sp_end_day'] ?? 0) == 29 ? 'selected' : '' ?>>29</option>
                                                <option value=30 <?= ($_GET['v_sp_end_day'] ?? 0) == 30 ? 'selected' : '' ?>>30</option>
                                                <option value=31 <?= ($_GET['v_sp_end_day'] ?? 0) == 31 ? 'selected' : '' ?>>31</option>
                                            </select>
                                            <!--comma-->,
                                            <input size=4 name="v_sp_end_year" value="<?= ($_GET['v_sp_end_year'] ?? '')?>" />
                                        </td></tr>


                                    <tr>
                                        <td colspan="2" align="center"> </td>
                                    </tr>

                                    <!-- List box selects number of results to show per page -->
                                    <tr>
                                        <td valign="middle">
                                            Show: 
                                        </td>
                                        <td>
                                            <select name="v_sp_c">
                                                <option value=5 <?= ($_GET['v_sp_c'] ?? '') == 5 ? 'selected' : '' ?>>5</option>
                                                <option value=10 <?= ($_GET['v_sp_c'] ?? '') == 10 ? 'selected' : '' ?>>10</option>
                                                <option value=25 <?= ($_GET['v_sp_c'] ?? '') == 25 ? 'selected' : '' ?>>25</option>
                                                <option value=50 <?= ($_GET['v_sp_c'] ?? '') == 50 ? 'selected' : '' ?>>50</option>
                                                <option value=100 <?= ($_GET['v_sp_c'] ?? '') == 100 ? 'selected' : '' ?>>100</option>
                                            </select> results 
                                            <!-- Show or hide summaries in search results -->
                                            <select name="v_sp_m" size=1>
                                                <option value=1 <?= ($_GET['v_sp_m'] ?? '') == 1 ? 'selected' : '' ?>>with</option>
                                                <option value=0 <?= ($_GET['v_sp_m'] ?? '') == 0 ? 'selected' : '' ?>>without</option>
                                            </select> summaries<br>
                                        </td>
                                    </tr>
                                    <!-- Sort results by relevance or by date -->
                                    <tr>
                                        <td valign="middle">
                                            Sort by: 
                                        </td>
                                        <td >
                                            <select name="v_sp_s" size=1>
                                                <option value="recomendation" <?= ($_GET['v_sp_s'] ?? '') == 'recomendation' ? 'selected' : '' ?>>relevance</option>
                                                <option value="book_date" <?= ($_GET['v_sp_s'] ?? '') == 'book_date' ? 'selected' : '' ?>>date</option>
                                            </select>
                                        </td>
                                    </tr>









                                    <tr>
                                        <td align="right" colspan="2"><button type="submit">Search</button></td>
                                    </tr>
                                </tbody>
                            </table>


                        </form> 
                    </td>
                    <td>    
                    </td>
                    <td>
                        <form action="/part3_correct.php" method="POST">

                            <table border="1" cellpadding="1" style="font-size: 10pt; width: 400px; background-color: #f19191">
                                <thead>
                                <tr>
                                    <th colspan="2" style="font-size: 12pt;"><b>Part 3.0 - Correct Form</b></th>
                                </tr>
                                </thead>


                                <tbody>

                                <tr>
                                    <td valign="middle">Title</td>
                                    <td style="border-width: 1pt"><input type="text"  name="c_name" maxlength="200"  value="<?=e( $_GET['c_name'] ?? '' )?>" size="20"></td>
                                </tr>
                                <tr>
                                    <td valign="middle">Author</td>
                                    <td style="border-width: 1pt"><input type="text"  name="c_author" maxlength="100"  value="<?=e( $_GET['c_author'] ?? '' )?>" size="20"></td>
                                </tr>

                                <tr>
                                    <td valign="middle">Category</td>
                                    <td style="border-width: 1pt">
                                        <select name="c_category_id">
                                            <option value="">All</option>
                                            <option value="Databases" <?=e( ($_GET['c_category_id'] ?? '') == 'Databases' ? 'selected' : '' )?>>Databases</option>
                                            <option value="HTML & Web design" <?=e( ($_GET['c_category_id'] ?? '') == 'HTML & Web design' ? 'selected' : '' )?>>HTML &amp; Web design</option>
                                            <option value="Programming" <?=e( ($_GET['c_category_id'] ?? '') == 'Programming' ? 'selected' : '' )?>>Programming</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td valign="middle">Price more then</td>
                                    <td style="border-width: 1pt"><input type="text"  name="c_pricemin" maxlength="100" value="<?=e( $_GET['c_pricemin'] ?? '' )?>" size="10"></td>
                                </tr>
                                <tr>
                                    <td valign="middle">Price less then</td>
                                    <td style="border-width: 1pt"><input type="text"  name="c_pricemax" maxlength="100" value="<?=e( $_GET['c_pricemax'] ?? '' )?>" size="10"></td>
                                </tr>


                                <tr>
                                    <td colspan="2" align="center" valign="middle">Advanced</td>
                                </tr>
                                <tr>
                                    <td valign="middle">
                                        Search For:<br>
                                    </td>
                                    <td >
                                        <input size=35 name="c_search_input" value="<?=e( $_GET['c_search_input'] ?? '' )?>">
                                    </td>
                                </tr>
                                <tr><td valign="middle">
                                        Within:
                                    </td>
                                    <td><select name="c_search_field" size=1>
                                            <option value="any" <?=e( ($_GET['c_search_field'] ?? '') == 'any' ? 'selected' : '' )?>>Anywhere</option>
                                            <option value="title" <?=e( ($_GET['c_search_field'] ?? '') == 'title' ? 'selected' : '' )?>>Title</option>
                                            <option value="authors" <?=e( ($_GET['c_search_field'] ?? '') == 'authors' ? 'selected' : '' )?>>Authors</option>
                                            <option value="desc" <?=e( ($_GET['c_search_field'] ?? '') == 'desc' ? 'selected' : '' )?>>Description</option>
                                            <option value="keys" <?=e( ($_GET['c_search_field'] ?? '') == 'keys' ? 'selected' : '' )?>>Keywords</option>
                                            <option value="notes" <?=e( ($_GET['c_search_field'] ?? '') == 'notes' ? 'selected' : '' )?>>Notes</option>
                                        </select>
                                    </td>
                                </tr>
                                <!-- Allow "any," "all," or "phrase" -->
                                <tr>
                                    <td valign="middle">
                                        Match:
                                    </td>
                                    <td>
                                        <input type=radio name="c_radio_match" value="any" <?=e( ($_GET['c_radio_match'] ?? 'any') == 'any' ? 'checked="checked"' : '' )?>>Any word <br>
                                        <input type=radio name="c_radio_match" value="all" <?=e( ($_GET['c_radio_match'] ?? null) == 'all' ? 'checked="checked"' : '' )?>>All words <br>
                                        <input type=radio name="c_radio_match" value="phrase" <?=e( ($_GET['c_radio_match'] ?? null) == 'phrase' ? 'checked="checked"' : '' )?>>Exact phrase<br>
                                    </td>
                                </tr>
                                <!-- Date range criteria -->
                                <tr>
                                    <td colspan="2" align="center">Date</td>
                                </tr>
                                <tr>
                                    <td align=right>
                                        <input type=radio name="c_sp_d" value="custom" <?=e( ($_GET['c_sp_d'] ?? 'custom') == 'custom' ? 'checked="checked"' : '' )?>>
                                    </td>
                                    <td>
                                        <select name="c_sp_date_range" size=1>
                                            <option value=-1 <?=e( ($_GET['c_sp_date_range'] ?? -1) == -1 ? 'selected' : '' )?>>Anytime</option>
                                            <option value=7 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 7 ? 'selected' : '' )?>>Within the last week</option>
                                            <option value=14 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 14 ? 'selected' : '' )?>>Within the last 2 weeks</option>
                                            <option value=30 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 30 ? 'selected' : '' )?>>Within the last 30 days</option>
                                            <option value=60 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 60 ? 'selected' : '' )?>>Within the last 60 days</option>
                                            <option value=90 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 90 ? 'selected' : '' )?>>Within the last 90 days</option>
                                            <option value=180 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 180 ? 'selected' : '' )?>>Within the last 180 days</option>
                                            <option value=365 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 365 ? 'selected' : '' )?>>Within the last year</option>
                                            <option value=730 <?=e( ($_GET['c_sp_date_range'] ?? -1) == 730 ? 'selected' : '' )?>>Within the last two years</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan=2 align=right>
                                        <input type=radio name="c_sp_d" value="specific" <?=e( ($_GET['c_sp_d'] ?? null) == 'specific' ? 'checked="checked"' : '' )?>>
                                    </td>
                                    <td>From:
                                        <select name="c_sp_start_month" size=1>
                                            <option value=0 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 0 ? 'selected' : '' )?>></option>
                                            <option value=1 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 1 ? 'selected' : '' )?>>January</option>
                                            <option value=2 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 2 ? 'selected' : '' )?>>February</option>
                                            <option value=3 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 3 ? 'selected' : '' )?>>March</option>
                                            <option value=4 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 4 ? 'selected' : '' )?>>April</option>
                                            <option value=5 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 5 ? 'selected' : '' )?>>May</option>
                                            <option value=6 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 6 ? 'selected' : '' )?>>June</option>
                                            <option value=7 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 7 ? 'selected' : '' )?>>July</option>
                                            <option value= <?=e( ($_GET['c_sp_start_month'] ?? 0) == 8 ? 'selected' : '' )?>>August</option>
                                            <option value=9 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 9 ? 'selected' : '' )?>>September</option>
                                            <option value=10 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 10 ? 'selected' : '' )?>>October</option>
                                            <option value=11 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 11 ? 'selected' : '' )?>>November</option>
                                            <option value=12 <?=e( ($_GET['c_sp_start_month'] ?? 0) == 12 ? 'selected' : '' )?>>December</option>
                                        </select>
                                        <select name="c_sp_start_day" size=1>
                                            <option value=0 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 0 ? 'selected' : '' )?>></option>
                                            <option value=1 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 1 ? 'selected' : '' )?>>1</option>
                                            <option value=2 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 2 ? 'selected' : '' )?>>2</option>
                                            <option value=3 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 3 ? 'selected' : '' )?>>3</option>
                                            <option value=4 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 4 ? 'selected' : '' )?>>4</option>
                                            <option value=5 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 5 ? 'selected' : '' )?>>5</option>
                                            <option value=6 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 6 ? 'selected' : '' )?>>6</option>
                                            <option value=7 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 7 ? 'selected' : '' )?>>7</option>
                                            <option value=8 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 8 ? 'selected' : '' )?>>8</option>
                                            <option value=9 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 9 ? 'selected' : '' )?>>9</option>
                                            <option value=10 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 10 ? 'selected' : '' )?>>10</option>
                                            <option value=11 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 11 ? 'selected' : '' )?>>11</option>
                                            <option value=12 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 12 ? 'selected' : '' )?>>12</option>
                                            <option value=13 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 13 ? 'selected' : '' )?>>13</option>
                                            <option value=14 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 14 ? 'selected' : '' )?>>14</option>
                                            <option value=15 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 15 ? 'selected' : '' )?>>15</option>
                                            <option value=16 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 16 ? 'selected' : '' )?>>16</option>
                                            <option value=17 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 17 ? 'selected' : '' )?>>17</option>
                                            <option value=18 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 18 ? 'selected' : '' )?>>18</option>
                                            <option value=19 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 19 ? 'selected' : '' )?>>19</option>
                                            <option value=20 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 20 ? 'selected' : '' )?>>20</option>
                                            <option value=21 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 21 ? 'selected' : '' )?>>21</option>
                                            <option value=22 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 22 ? 'selected' : '' )?>>22</option>
                                            <option value=23 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 23 ? 'selected' : '' )?>>23</option>
                                            <option value=24 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 24 ? 'selected' : '' )?>>24</option>
                                            <option value=25 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 25 ? 'selected' : '' )?>>25</option>
                                            <option value=26 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 26 ? 'selected' : '' )?>>26</option>
                                            <option value=27 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 27 ? 'selected' : '' )?>>27</option>
                                            <option value=28 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 28 ? 'selected' : '' )?>>28</option>
                                            <option value=29 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 29 ? 'selected' : '' )?>>29</option>
                                            <option value=30 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 30 ? 'selected' : '' )?>>30</option>
                                            <option value=31 <?=e( ($_GET['c_sp_start_day'] ?? 0) == 31 ? 'selected' : '' )?>>31</option>
                                        </select>
                                        <!--comma-->,
                                        <input size=4 name="c_sp_start_year" value="<?=e( ($_GET['c_sp_start_year'] ?? ''))?>">
                                    </td></tr>
                                <tr>
                                    <td>To:

                                        <select name="c_sp_end_month" size=1>
                                            <option value=0 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 0 ? 'selected' : '' )?>></option>
                                            <option value=1 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 1 ? 'selected' : '' )?>>January</option>
                                            <option value=2 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 2 ? 'selected' : '' )?>>February</option>
                                            <option value=3 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 3 ? 'selected' : '' )?>>March</option>
                                            <option value=4 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 4 ? 'selected' : '' )?>>April</option>
                                            <option value=5 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 5 ? 'selected' : '' )?>>May</option>
                                            <option value=6 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 6 ? 'selected' : '' )?>>June</option>
                                            <option value=7 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 7 ? 'selected' : '' )?>>July</option>
                                            <option value=8 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 8 ? 'selected' : '' )?>>August</option>
                                            <option value=9 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 9 ? 'selected' : '' )?>>September</option>
                                            <option value=10 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 10 ? 'selected' : '' )?>>October</option>
                                            <option value=11 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 11 ? 'selected' : '' )?>>November</option>
                                            <option value=12 <?=e( ($_GET['c_sp_end_month'] ?? 0) == 12 ? 'selected' : '' )?>>December</option>
                                        </select>
                                        <select name="c_sp_end_day" size=1>
                                            <option value=0 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 0 ? 'selected' : '' )?> selected></option>
                                            <option value=1 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 1 ? 'selected' : '' )?>>1</option>
                                            <option value=2 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 2 ? 'selected' : '' )?>>2</option>
                                            <option value=3 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 3 ? 'selected' : '' )?>>3</option>
                                            <option value=4 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 4 ? 'selected' : '' )?>>4</option>
                                            <option value=5 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 5 ? 'selected' : '' )?>>5</option>
                                            <option value=6 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 6 ? 'selected' : '' )?>>6</option>
                                            <option value=7 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 7 ? 'selected' : '' )?>>7</option>
                                            <option value=8 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 8 ? 'selected' : '' )?>>8</option>
                                            <option value=9 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 9 ? 'selected' : '' )?>>9</option>
                                            <option value=10 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 10 ? 'selected' : '' )?>>10</option>
                                            <option value=11 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 11 ? 'selected' : '' )?>>11</option>
                                            <option value=12 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 12 ? 'selected' : '' )?>>12</option>
                                            <option value=13 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 13 ? 'selected' : '' )?>>13</option>
                                            <option value=14 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 14 ? 'selected' : '' )?>>14</option>
                                            <option value=15 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 15 ? 'selected' : '' )?>>15</option>
                                            <option value=16 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 16 ? 'selected' : '' )?>>16</option>
                                            <option value=17 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 17 ? 'selected' : '' )?>>17</option>
                                            <option value=18 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 18 ? 'selected' : '' )?>>18</option>
                                            <option value=19 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 19 ? 'selected' : '' )?>>19</option>
                                            <option value=20 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 20 ? 'selected' : '' )?>>20</option>
                                            <option value=21 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 21 ? 'selected' : '' )?>>21</option>
                                            <option value=22 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 22 ? 'selected' : '' )?>>22</option>
                                            <option value=23 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 23 ? 'selected' : '' )?>>23</option>
                                            <option value=24 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 24 ? 'selected' : '' )?>>24</option>
                                            <option value=25 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 25 ? 'selected' : '' )?>>25</option>
                                            <option value=26 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 26 ? 'selected' : '' )?>>26</option>
                                            <option value=27 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 27 ? 'selected' : '' )?>>27</option>
                                            <option value=28 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 28 ? 'selected' : '' )?>>28</option>
                                            <option value=29 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 29 ? 'selected' : '' )?>>29</option>
                                            <option value=30 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 30 ? 'selected' : '' )?>>30</option>
                                            <option value=31 <?=e( ($_GET['c_sp_end_day'] ?? 0) == 31 ? 'selected' : '' )?>>31</option>
                                        </select>
                                        <!--comma-->,
                                        <input size=4 name="c_sp_end_year" value="<?=e( ($_GET['c_sp_end_year'] ?? ''))?>" />
                                    </td></tr>


                                <tr>
                                    <td colspan="2" align="center"> </td>
                                </tr>

                                <!-- List box selects number of results to show per page -->
                                <tr>
                                    <td valign="middle">
                                        Show:
                                    </td>
                                    <td>
                                        <select name="c_sp_c">
                                            <option value=5 <?=e( ($_GET['c_sp_c'] ?? '') == 5 ? 'selected' : '' )?>>5</option>
                                            <option value=10 <?=e( ($_GET['c_sp_c'] ?? '') == 10 ? 'selected' : '' )?>>10</option>
                                            <option value=25 <?=e( ($_GET['c_sp_c'] ?? '') == 25 ? 'selected' : '' )?>>25</option>
                                            <option value=50 <?=e( ($_GET['c_sp_c'] ?? '') == 50 ? 'selected' : '' )?>>50</option>
                                            <option value=100 <?=e( ($_GET['c_sp_c'] ?? '') == 100 ? 'selected' : '' )?>>100</option>
                                        </select> results
                                        <!-- Show or hide summaries in search results -->
                                        <select name="c_sp_m" size=1>
                                            <option value=1 <?=e( ($_GET['c_sp_m'] ?? '') == 1 ? 'selected' : '' )?>>with</option>
                                            <option value=0 <?=e( ($_GET['c_sp_m'] ?? '') == 0 ? 'selected' : '' )?>>without</option>
                                        </select> summaries<br>
                                    </td>
                                </tr>
                                <!-- Sort results by relevance or by date -->
                                <tr>
                                    <td valign="middle">
                                        Sort by:
                                    </td>
                                    <td >
                                        <select name="c_sp_s" size=1>
                                            <option value="recomendation" <?=e( ($_GET['c_sp_s'] ?? '') == 'recomendation' ? 'selected' : '' )?>>relevance</option>
                                            <option value="book_date" <?=e( ($_GET['c_sp_s'] ?? '') == 'book_date' ? 'selected' : '' )?>>date</option>
                                        </select>
                                    </td>
                                </tr>









                                <tr>
                                    <td align="right" colspan="2"><button type="submit">Search</button></td>
                                </tr>
                                </tbody>
                            </table>


                        </form>
                    </td>
                </tr>
            </table>

            <?php
            $messages = pg_query($db, $_SESSION['sql_books'] ?? "SELECT * FROM books");
            $messages = pg_fetch_all($messages);
            ?>

            <table  style="width: 1500px; margin: 15px 0" border="1" cellpadding="1" >
                <thead>
                <tr>
                    <th colspan="9"><b>Output Box</b></th>
                </tr>
                <tr>
                    <th><b>Title</b></th>
                    <th><b>Authors</b></th>
                    <th><b>Category</b></th>
                    <th><b>Price</b></th>
                    <th><b>Book Date</b></th>
                    <th <?= (($_GET['v_sp_m'] ?? 1) == 0) ? 'style="display: none"' : '' ?>><b>Description</b></th>
                    <th><b>Keywords</b></th>
                    <th><b>Notes</b></th>
                    <th><b>Recommendation</b></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr data-book-id="<?= $message['book_id'] ?>">
                        <td>
                            <?= $message['title'] ?>
                        </td>
                        <td>
                            <?= $message['authors'] ?>
                        </td>
                        <td>
                            <?= $message['category'] ?>
                        </td>
                        <td>
                            <?= $message['price'] ?>
                        </td>
                        <td>
                            <?= $message['book_date'] ?>
                        </td>
                        <td <?= (($_GET['v_sp_m'] ?? 1) == 0) ? 'style="display: none"' : '' ?>>
                            <?= $message['description'] ?>
                        </td>
                        </td>
                        <td>
                            <?= $message['keywords'] ?>
                        </td>
                        <td>
                            <?= $message['notes'] ?>
                        </td>
                        <td>
                            <?= $message['recomendation'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

<?php
unset($_SESSION['sql_books']);
?>