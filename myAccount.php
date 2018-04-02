<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'db.php';
include_once 'header.php';
if($user->is_logged_in()) {
    $result = $mysql->query("SELECT memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
if (isset($_GET['delete'])) {
    $query = "DELETE FROM tournaments WHERE id = '". $_GET['tournamentId']."'";

    $mysql->query($query);
    exit();
}

$result = $mysql->query("SELECT DISTINCT * FROM tournaments WHERE user_id ='" . $userId. "'");
?>
<body style="font-family: 'Lato', sans-serif;">
<div class="container">
    <div class="row">
        <div class="col-sm-6 table-cell-content-center">
            <div>
                <a href="http://localhost:8080/loputoo/" title="Trniir" rel="home">
                    <img class="img-responsive center-block" src="http://localhost:8080/loputoo/images/logos/turniir_new_0.png" alt="Trniir">
                </a>
            </div>
        </div>
        <div class="col-sm-6">
            <h3 class="to-upper"><a href="http://localhost:8080/loputoo/create.php">Create new tournament</a></h3>
        </div>
        <div style="font-size:2.0em;border-bottom:12px solid;border-top:3px solid #FDAC43;clear:both;"></div>
    </div>
    <div class="accountTournaments">
        <h4>My tournaments:</h4>
        <?php
        while ($row = $result->fetch_assoc()){
            if($user->is_logged_in() && $row['user_id'] == $userId ){?>
                    <div class="border" style="border:1px solid orange; background-color: #e7e7e7; margin-bottom:5px;">
                            <a style="color:black;" href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id']; ?>">
                                <span style="font-size: 1.7em;"><span class="glyphicon glyphicon-menu-right" style="margin-right:5px;"></span><?php echo $row['name']; ?><span>
                            </a>
                            <span style="float:right; padding:3px;"><button type="submit" name="delete" onclick="deleteTournament(<?php echo $row['id'];?>)" class="btn-danger"><span style="margin-right:3px;" class="glyphicon glyphicon-trash"></span>Delete</button></span>
                    </div>
            <?php } else { ?>
                <p>Sorry! You don't have any tournaments just yet, <a href="http://localhost:8080/loputoo/create.php">Create new tournament</a></p>
          <?php } }?>

    </div>
</div>
<script>
    function deleteTournament (id){
        var url = '&tournamentId=' + id;
        $.ajax({
            type: "POST",
            url: 'http://localhost:8080/loputoo/myAccount.php?delete=1' + url
        });

    }
</script>
<?php include_once 'footer.php'; ?>
</body>
