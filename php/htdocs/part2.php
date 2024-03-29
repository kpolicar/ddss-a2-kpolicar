<?php require_once __DIR__ . '/vendor/autoload.php';
session_start();
$user = null;
if ($username = $_SESSION['auth'] ?? null) {
    $db = pg_connect("host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2");
    $users = pg_query($db, "SELECT * FROM users WHERE username='$username'");
    $users = pg_fetch_all($users);
    $user = $users[0] ?? null;
}

if (!$user) {
    header("Location: /?message=auth");
    exit();
}
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
        <title>DDSS PA2 - Part 1.2</title>
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
            <h2>Practical Assignment #2 - Part 1.2 </h2>
            <div align="center">
                DISCLAIMER: This code is to be used in the scope of the <em>DDSS</em> course.
                <b>Important:</b> these sources are merely suggestions of implementations. 
                You should modify everything you deem as necessary and be responsible for all the content that is delivered.
                <em>The contents of this repository do not replace the proper reading of the assignment description.</em>
            </div>
            <br>
            <br>


            <form action="/part2_vulnerable.php">
                <input type="hidden" value="<?= $_SESSION['auth'] ?>">
                <?php $errors = $_SESSION['v_errors'] ?? null; ?>
                <table  style="width: 500px ; background-color:#f1f1f1; <?php if(!empty($errors)): ?>border-color: red;<?php endif; ?>" border="1" cellpadding="1" >
                    <thead>
                        <tr>
                            <th>
                                <b>Part 2.0 - Vulnerable Form</b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><textarea style="width: 100%; height: 100px" placeholder="Enter Text" name="v_text" required></textarea>
                            </td>
                        </tr>
                        <?php if($errors['message'] ?? false): ?>
                            <tr>
                                <td align="right" style="color: red; font-size: 12px;"><?= $errors['message'] ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td align="right"><button type="submit">Submit</button></td>
                        </tr>
                    </tbody>
                </table>

            </form> 

            <br>
            <br>

            <form action="/part2_correct.php">
                <table  style="width: 500px ; background-color:#f19191" border="1" cellpadding="1" >
                    <thead>
                        <tr>
                            <th><b>Part 2.1 - Correct Form</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><textarea style="width: 100%; height: 100px" placeholder="Enter Text" name="c_text" required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><button type="submit">Submit</button></td>
                        </tr>
                    </tbody>
                </table>
            </form> 

            <br>
            <br>

            <?php
            $messages = pg_query($db, "SELECT * FROM messages");
            $messages = pg_fetch_all($messages);
            ?>

            <table  style="width: 500px" border="1" cellpadding="1" >
                <thead>
                    <tr>
                        <th><b>Output Box</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td>
                                <?= $message['author'] ?>: <?= $message['message'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

<?php
unset($_SESSION['c_errors']);
unset($_SESSION['v_errors']);
?>