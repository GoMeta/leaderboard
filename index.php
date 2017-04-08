<?php
require("db.php");

/* Retrieve Leaderboard */
$stmt = $db->prepare("SELECT * FROM leaderboard l WHERE deleted = false AND l.id = ?");
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$leaderboard = $result->fetch_array(MYSQLI_ASSOC);

if ($leaderboard) {
    $stmt = $db->prepare("SELECT * FROM scores s WHERE s.leaderboard = ? ORDER BY s.score DESC");
    $stmt->bind_param("i", $leaderboard['id']);
    $stmt->execute();
    $scores = $stmt->get_result();
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- The first thing in any HTML file should be the charset -->
    <meta charset="utf-8">
    <!-- Make the page mobile compatible -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,500,700" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>
        <?php echo $leaderboard ? "{$leaderboard['name']} Leaderboard" : "Leaderboard Not Found"; ?>
    </title>
</head>
<body>
<?php if ($leaderboard) { ?>
    <div class="logo">
        <img src="<?php echo $leaderboard['logo'] ?>" border="0"/>
    </div>
    <div class="leaderboard">
        <?php echo "{$leaderboard['name']} Leaderboard"; ?>
    </div>
    <div class="description">
        <?php echo $leaderboard['description']; ?>
    </div>
    <table>
        <thead>
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $rank = 1;
        if ($scores->num_rows === 0) {
            ?>
            <tr>
                <td colspan="3"><center>No scores available at this time.</center></td>
            </tr>
            <?php
        } else {
            while ($score = $scores->fetch_array(MYSQLI_ASSOC)) {
                ?>
                <tr <?php if ($_GET['highlight'] == $score['username']) {
                    echo 'class="highlight"';
                } ?>>
                    <td><?php echo $rank; ?></td>
                    <td>
                        <b><?php echo $score['username']; ?></b>
                    </td>
                    <td><?php echo $score['score']; ?></td>
                </tr>
                <?php
                $rank++;
            }
        }
        ?>
        </tbody>
    </table>
<?php } ?>
</body>
</html>