<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'db.php';
include_once 'mobile_menu.php';
include_once 'tournament_header.php';

if($user->is_logged_in()) {
    $result = $mysql->query("select memberID from members where username ='" . $_SESSION['username'] . "'");
    while ($row = $result->fetch_assoc()){
        $userId = $row['memberID'];
    }
}
$id = (int)$_GET['id'];
$result = $mysql->query('SELECT * FROM tournaments AS t 
LEFT JOIN sports as s ON t.sport_id = s.id
LEFT JOIN countries as c ON t.country_id = c.country_id
LEFT JOIN ages as a ON t.age_id = a.id
LEFT JOIN class as cl ON t.class_id = cl.id
LEFT JOIN level as l ON t.level_id = l.id
LEFT JOIN gender as g ON t.gender_id = g.id
LEFT JOIN tournament_settings as ts ON t.id = ts.tournament_id
WHERE t.Id = "' . $id . '";');

?>

<?php while ($row = $result->fetch_assoc()){ ?>
    <div class="main container" style="background-color: white;">
        <div class="col-sm-12">
            <h2><?php echo $row['name']; ?></h2>
        </div>
        <div class="col-sm-12">
        <?php if($row['sponsors_enabled'] == 1){?>
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="fbFeed">
                    <?php
                    if ($row['facebook'] != '') {
                        $string = $row['facebook'];
                        $last = substr($string, -1);
                        if ($last == '/') {
                            $new = substr_replace($string, "", -1);
                            $facebook = substr($new, strrpos($new, '/') + 1);
                        } else {
                            $facebook = substr($string, strrpos($string, '/') + 1);
                        } ?>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2F<?php echo $facebook; ?>&width=400&colorscheme=light&show_faces=true&border_color&stream=true&header=true&height=630"
                                scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:400px; height:630px; background: white; float:left; " allowTransparency="true">
                        </iframe>
                    <?php } else { ?>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fturniir&width=400&colorscheme=light&show_faces=true&border_color&stream=true&header=true&height=630"
                                scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:400px; height:630px; background: white; float:left; " allowTransparency="true">
                        </iframe>
                    <?php }?>
                </div>
                <div class="fbFeedMobile">
                    <?php
                    if ($row['facebook'] != '') {
                        $string = $row['facebook'];
                        $last = substr($string, -1);
                        if ($last == '/') {
                            $new = substr_replace($string, "", -1);
                            $facebook = substr($new, strrpos($new, '/') + 1);
                        } else {
                            $facebook = substr($string, strrpos($string, '/') + 1);
                        } ?>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2F<?php echo $facebook; ?>&width=300&colorscheme=light&show_faces=true&border_color&stream=true&header=true&height=630"
                                scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:300px; height:630px; background: white; float:left; " allowTransparency="true">
                        </iframe>
                    <?php } else { ?>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fturniir&width=300&colorscheme=light&show_faces=true&border_color&stream=true&header=true&height=630"
                                scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:300px; height:630px; background: white; float:left; " allowTransparency="true">
                        </iframe>
                    <?php }?>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="glyphicon glyphicon-pushpin"></span><span class="tournament-frontpage-title">NOTEBOARD</span>
                        <?php if($user->is_logged_in() && $row['user_id'] == $userId ) { ?>
                            <a style="color:black;" href="http://localhost:8080/loputoo/notes/addNote.php?id=<?php echo $id;?>"><span style="float:right;" class="glyphicon glyphicon-plus">Add</span></a>
                        <?php } else {} ?>
                    </div>
                    <div id="noteboard-container">
                        <?php
                        $sql = $mysql->query('SELECT * FROM notes WHERE tournament_id = "'.$id.'"');
                        while ($row = $sql->fetch_assoc()){
                            if ($row['tournament_id'] == '') {?>
                                <div class="note-content" style="margin-left:10px;">
                                    <p>No notes at the moment</p>
                                </div>
                            <?php }else {?>
                                <div class="note-content" style="margin-left:10px;">
                                    <a style="color:black;" href="http://localhost:8080/loputoo/notes?id=<?php echo $id;?>&noteId=<?php echo $row['id'];?>"><h4><?php echo $row['note_name'] ;?></h4></a>
                                    <p>Added on <?php echo $row['time'];?></p>
                                </div>
                            <?php  } }?>

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12" style="text-align: center">
                <h4><div>Supporters</div></h4>
                <hr>
                <a href="http://www.turniir.ee" target="_blank"><img class="sponsor_img" src="images/logos/turniir_new_0.png" style="max-width:200px; max-height:200px;" /></a>
                <?php
                $sql = $mysql->query('SELECT * FROM sponsors WHERE tournament_id = "'.$id.'"');
                ?>
                <?php while ($row = $sql->fetch_assoc()){ ?>
                    <a href="<?php echo $row['sponsor_site_url'] ?>" target="_blank"><img class="sponsor_img" src="images/sponsorImages/<?php echo $row['sponsor_logo_url']?>" style="max-width:200px; max-height:200px; margin-top:25px;" /></a>
                <?php } ?>
            </div>
        <?php }
        else {?>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div>
                    <?php
                    if ($row['facebook'] != '') {
                        $string = $row['facebook'];
                        $last = substr($string, -1);
                        if ($last == '/') {
                            $new = substr_replace($string, "", -1);
                            $facebook = substr($new, strrpos($new, '/') + 1);
                        } else {
                            $facebook = substr($string, strrpos($string, '/') + 1);
                        } ?>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2F<?php echo $facebook; ?>&width=400&colorscheme=light&show_faces=true&border_color&stream=true&header=true&height=630"
                                scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:400px; height:630px; background: white; float:left; " allowTransparency="true">
                        </iframe>
                    <?php } else { ?>
                        <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fturniir&width=400&colorscheme=light&show_faces=true&border_color&stream=true&header=true&height=630"
                                scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:400px; height:630px; background: white; float:left; " allowTransparency="true">
                        </iframe>
                    <?php }?>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="glyphicon glyphicon-pushpin"></span><span class="tournament-frontpage-title">NOTEBOARD</span>
                        <?php if($user->is_logged_in() && $row['user_id'] == $userId ) { ?>
                            <a style="color:black;" href="http://localhost:8080/loputoo/notes/addNote.php?id=<?php echo $id;?>"><span style="float:right;" class="glyphicon glyphicon-plus">Add</span></a>
                        <?php } else {} ?>
                    </div>
                    <div id="noteboard-container">
                        <?php
                        $sql = $mysql->query('SELECT * FROM notes WHERE tournament_id = "'.$id.'"');
                        while ($row = $sql->fetch_assoc()){
                            if ($row['tournament_id'] == '27') {?>
                                <div class="note-content" style="margin-left:10px;">
                                    <a style="color:black;" href="http://localhost:8080/loputoo/notes?id=<?php echo $id;?>&noteId=<?php echo $row['id'];?>"><h4><?php echo $row['note_name'] ;?></h4></a>
                                    <p>Added on <?php echo $row['time'];?></p>
                                </div>
                            <?php }else {?>
                                No notes at the moment
                            <?php  } }?>

                    </div>
                </div>
            </div>
        <?php }?>
        </div>
    </div>
<?php } ?>
</body>
<?php include_once 'footer.php'; ?>