<?php

require 'Calendar.php';
function h($s){
    return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

ini_set('display_errors', 1);

$cal = new Myapp\Calendar();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>Calendar</title>
<link rel="stylesheet" hrel="styles.css">
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

<![endif]-->
<link rel="stylesheet" href="styles.css">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th><a href="?t=<?php echo h($cal -> prev); ?>">&laquo;</a></th>
                <th colspan="5"><?php echo h($cal -> yearMonth); ?></th>
                <th><a href="?t=<?php echo h($cal -> next); ?>">&raquo;</a></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sun</td>
                <td>Mon</td>
                <td>Tue</td>
                <td>Wed</td>
                <td>Thu</td>
                <td>Fri</td>
                <td>Sat</td>
            </tr>

                <?php echo $cal -> show();?>

        </tbody>
        <tfoot>
            <tr>
                <th colspan="7"><a href="/">today</a></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
