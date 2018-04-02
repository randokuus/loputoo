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
<div class="info">
    <div class="container">
        <ul class="nav nav-pills nav-justified" style="background-color: white; width:1170px; margin-left:-15px; margin-top:30px;">
            <li class="active">
                <a class="nav-link" data-toggle="tab" href="#general">General <span class="sr-only">(current)</span></a>
            </li>
            <li>
                <a class="nav-link" data-toggle="tab" href="#information">Info</a>
            </li>

            <li>
                <a class="nav-link" data-toggle="tab" href="#rules">Rules</a>
            </li>

            <li>
                <a class="nav-link" data-toggle="tab" href="#acommodation">Acommodation</a>
            </li>

            <li>
                <a class="nav-link" data-toggle="tab" href="#venues">Venues</a>
            </li>

            <li>
                <a class="nav-link" data-toggle="tab" href="#leisure">Leisure</a>
            </li>
        </ul>
    </div>
</div>
<?php while ($row = $result->fetch_assoc()){ ?>
<div class="container" style="background-color: white;">
    <div class="tab-content">
        <div class="tab-pane fade in active" id="general">
            <h2>General settings</h2>
            <hr>
            <?php

            ?>
        <?php if ($row['tournament_id'] == $id) {
                if (isset($_POST['submit8'])){
                    ?>
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            <strong>Success!</strong> info was updated.
                        </div>
                    </div>
                    <?php
                    $periodDuration = $row['period_duration'] = mysqli_real_escape_string($mysql, $_POST['period_duration']);
                    $periodsAmount = $row['periods_amount'] = mysqli_real_escape_string($mysql, $_POST['periods_amount']);
                    $overtimeDuration = $row['overtime_duration'] = mysqli_real_escape_string($mysql, $_POST['overtime_duration']);
                    $background = $row['background_color'] = mysqli_real_escape_string($mysql, $_POST['background_color']);
                    $sponsorsEnabled = $row['sponsors_enabled'] = mysqli_real_escape_string($mysql, $_POST['sponsors_enabled']);
                    $registration = $row['registration_open'] = mysqli_real_escape_string($mysql, $_POST['registration_open']);
                    $tournamentId = $id;
                    $image=($_FILES['tournament_banner']['name']);
                    if (!empty($_FILES['tournament_banner'])) {
                        include_once 'tournament_banner_images.php';
                    }
                    $query = "UPDATE tournament_settings SET periods = '$periodsAmount', period_duration = '$periodDuration', overtime_duration = '$overtimeDuration', background_color = '$background', sponsors_enabled = '$sponsorsEnabled', reg_open = '$registration', banner_path = '$image', tournament_id = '$tournamentId'
                      WHERE tournament_id = '$id'";
                    $_POST = array();
                    if(!$mysql->query($query)){
                        echo'Sisestus ebaõnnestus - ' . $mysql->error;
                    }
                }?>
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Choose period duration (minutes)</label>
                                <input required type="int" id ="period_duration" name="period_duration" class="form-control" value="<?php echo $row['period_duration']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Choose periods amount </label>
                                <input required type="int" id ="periods_amount" name="periods_amount" class="form-control" value="<?php echo $row['periods']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Choose overtime duration (minutes)</label>
                                <input required type="int" id ="overtime_duration" name="overtime_duration" class="form-control" value="<?php echo $row['overtime_duration']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Choose backgorund color</label>
                                <input type="color" name="background_color" id="background_color" value="<?php echo $row['background_color']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Tournament banner *(min-width:1140px) </label>
                                <input type="file" name="tournament_banner" id="tournament_banner" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Registration open </label>
                                <input type="checkbox" id ="registration_open" name="registration_open" value="<?php echo $row['reg_open']; ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sponsors enabled </label>
                                <input type="checkbox" id ="sponsors_enabled" name="sponsors_enabled" value="<?php echo $row['sponsors_enabled']; ?>"/>
                            </div>
                        </div>
                        <button type="submit" id="submit" name="submit8" value="Confirm" class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm</button>
                    </form>
                </div>
                </div>
            <?php } else {
            if (isset($_POST['submit7'])){
                ?>
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        <strong>Success!</strong>.
                    </div>
                </div>
                <?php
                $periodDuration = mysqli_real_escape_string($mysql, $_POST['period_duration']);
                $periodsAmount = mysqli_real_escape_string($mysql, $_POST['periods_amount']);
                $overtimeDuration = mysqli_real_escape_string($mysql, $_POST['overtime_duration']);
                $background = mysqli_real_escape_string($mysql, $_POST['background_color']);
                $sponsorsEnabled = mysqli_real_escape_string($mysql, $_POST['sponsor_enabled']);
                $registration = mysqli_real_escape_string($mysql, $_POST['registration_open']);
                $tournamentId = $id;
                $image=($_FILES['tournament_banner']['name']);
                if (!empty($_FILES['tournament_banner'])) {
                    include_once 'tournament_banner_images.php';
                }
                $query = "INSERT INTO tournament_settings (periods, period_duration, overtime_duration, background_color, sponsors_enabled, reg_open, banner_path, tournament_id)
                VALUES
                ('{$periodsAmount}','{$periodDuration}','{$overtimeDuration}','{$background}','{$sponsorsEnabled}','{$registration}','{$image}','$tournamentId');";
                $_POST = array();
                if(!$mysql->query($query)){
                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            ?>
            <div class="col-sm-12">
            <div class="col-sm-6">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Choose period duration (minutes)</label>
                            <input required type="int" id ="period_duration" name="period_duration" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Choose periods amount </label>
                            <input required type="int" id ="periods_amount" name="periods_amount" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Choose overtime duration (minutes)</label>
                            <input required type="int" id ="overtime_duration" name="overtime_duration" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Choose backgorund color</label>
                            <input type="color" name="background_color" id="background_color" value="#ffffff"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Tournament banner *(min-width:1140px) </label>
                            <input required type="file" name="tournament_banner" id="tournament_banner" class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Registration open </label>
                            <input type="checkbox" id ="registration_open" name="registration_open" value="1"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Sponsor enabled </label>
                            <input type="checkbox" id ="sponsor_enabled" name="sponsor_enabled" value="1"/>
                        </div>
                    </div>
                    <button type="submit" id="submit" name="submit7" value="Confirm" class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm</button>
                </form>
            </div>
            </div>
            <?php } ?>
            <?php
            if (isset($_POST['submit9']) && !empty($_POST['format_id'])){
                ?>
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        <strong>Success!</strong> Class was created.
                    </div>
                </div>
            <?php
                $className = mysqli_real_escape_string($mysql, $_POST['class_name']);
                $matchPeriods= mysqli_real_escape_string($mysql, $_POST['match_periods']);
                $periodLength= mysqli_real_escape_string($mysql, $_POST['period_length']);
                $maxTeams= mysqli_real_escape_string($mysql, $_POST['max_teams']);
                $maxPlayers= mysqli_real_escape_string($mysql, $_POST['max_players']);
                $formatId= mysqli_real_escape_string($mysql, $_POST['format_id']);
                $startTime= mysqli_real_escape_string($mysql, $_POST['start_time']);
                $endTime= mysqli_real_escape_string($mysql, $_POST['end_time']);
                $tournamentId = $id;
                $query = "INSERT INTO classes (class_name, max_teams, match_periods, max_players, format_id, start_time, end_time, tournament_id)
                VALUES
                ('{$className}','{$maxTeams}','{$matchPeriods}','{$maxPlayers}','{$formatId}','{$startTime}','{$endTime}','$tournamentId');";
                $_POST = array();
                if(!$mysql->query($query)){
                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            ?>
            <div class="col-sm-12">
                <h3>Create classes</h3>
                <hr>
                <div class=col-sm-6>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Class name *</label>
                                <input required type="text" id ="class_name" name="class_name" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Match periods *</label>
                                <input required type="int" id ="match_periods" name="match_periods" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Match period length *</label>
                                <input required type="int" id ="period_length" name="period_length" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Max teams *</label>
                                <input required type="int" id ="max_teams" name="max_teams" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Max players per team *</label>
                                <input required type="int" id ="max_players" name="max_players" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Choose format</label>
                            <select class="form-control" name="format_id">
                                <?php

                                $sql = mysqli_query($mysql, "SELECT DISTINCT format_name, format_id FROM tournament_formats");

                                while ($row = $sql->fetch_assoc()){

                                    ?>
                                    <option id="format_id" name='format_id' value=<?php echo $row['format_id']; ?>><?php echo $row['format_name']; ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label>Start time *</label>
                            <div class="form-group">
                                <input required type="date" id ="start_time" name="start_time" class="form-control" value=""/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>End time *</label>
                            <div class="form-group">
                                <input required type="date" id ="end_time" name="end_time" class="form-control" value=""/>
                            </div>
                        </div>
                        <button type="submit" name="submit9" value="Confirm" class="btn btn-primary form-submit" style="margin-top:10px; margin-bottom:10px;">Confirm</button>
                    </form>
                </div>
            </div>
            <h3>Add sponsors</h3>
            <?php
            if (isset($_POST['submit6'])){
                ?>
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        <strong>Success!</strong> Sponsor was added.
                    </div>
                </div>
                <?php
                $sponsorName = mysqli_real_escape_string($mysql, $_POST['sponsor_name']);
                $sponsorSite= mysqli_real_escape_string($mysql, $_POST['sponsor_site']);
                $tournamentId = $id;
                $image=($_FILES['sponsor_logo']['name']);
                if (!empty($_FILES['sponsor_logo'])) {
                    include_once 'sponsor_images.php';
                }
                $query = "INSERT INTO sponsors (sponsor_name, sponsor_site_url, sponsor_logo_url, tournament_id)
                VALUES
                ('{$sponsorName}','{$sponsorSite}','{$image}','$tournamentId');";
                $_POST = array();
                if(!$mysql->query($query)){
                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            ?>
            <div class="col-sm-6">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Sponsor name *</label>
                            <input required type="text" id ="sponsor_name" name="sponsor_name" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Sponsor site *</label>
                            <input required type="text" id ="sponsor_site" name="sponsor_site" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Team logo</label>
                            <input required type="file" name="sponsor_logo" id="sponsor_logo" class="form-control" />
                        </div>
                    </div>
                    <button type="submit" id="submit" name="submit6" value="Confirm" class="btn btn-primary form-submit" style="margin-bottom:10px;">Confirm</button>
                </form>
            </div>
        </div>
<?php } ?>
        <div class="tab-pane fade in" id="information">
            <?php
            $result = $mysql->query('SELECT * FROM tournaments AS t 
                LEFT JOIN sports as s ON t.sport_id = s.id
                LEFT JOIN countries as c ON t.country_id = c.country_id
                LEFT JOIN ages as a ON t.age_id = a.id
                LEFT JOIN class as cl ON t.class_id = cl.id
                LEFT JOIN level as l ON t.level_id = l.id
                LEFT JOIN gender as g ON t.gender_id = g.id
                LEFT JOIN tournament_settings as ts ON t.id = ts.tournament_id
                WHERE t.Id = "' . $id . '";');

            if (isset($_POST['submit'])) {
                $info = $row['info'] = mysqli_real_escape_string($mysql, $_POST['info']);
                $query = "UPDATE tournaments SET info = '$info' WHERE id = '$id'";
                $_POST = array();
                if (!$mysql->query($query)) {
                    echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            ?>

            <?php while ($row = $result->fetch_assoc()){ ?>
            <h2>Info</h2>
            <hr>
            <h4>Change or add information for your tournament</h4>
            <div class="col-sm-6">
                <form method="post" action="">
                    <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
                    <textarea class="ckeditor" name="info" id="info" class="form-control"><?php echo $row['info']; ?></textarea><br/>
                    <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade in" id="rules">
            <?php
            if (isset($_POST['submit2'])) {
                $rules = $row['rules'] = mysqli_real_escape_string($mysql, $_POST['rules']);
                $query = "UPDATE tournaments SET rules = '$rules' WHERE id = '$id'";
                $_POST = array();
                if (!$mysql->query($query)) {
                    echo 'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            ?>
            <h2>Rules</h2>
            <hr>
            <h4>Change or add rules for your tournament</h4>
            <div class="col-sm-6">
                <form method="post" action="">
                    <textarea name="rules" id="rules" class="form-control"><?php echo $row['rules']; ?></textarea><br/>
                    <button type="submit" class="btn btn-primary" name="submit2">Confirm</button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade in" id="acommodation">
            <?php
            if (!empty($_FILES['logo']) || !empty($_FILES['logo2']) || !empty($_FILES['logo3'])) {
                include_once 'accommodation_images.php';
            }
            if (isset($_POST['submit3'])  && !empty($_POST['name']) && !empty($_POST['information']) && !empty($_POST['address'])){
                $name = mysqli_real_escape_string($mysql, $_POST['name']);
                $information = mysqli_real_escape_string($mysql, $_POST['information']);
                $address = mysqli_real_escape_string($mysql, $_POST['address']);
                $logo=($_FILES['logo']['name']);
                $tournamentId = $id;
                $query = "INSERT INTO accommodation (name, information, image_url, tournament_id, address)
                VALUES
                ('{$name}','{$information}','{$logo}','{$tournamentId}','{$address}');";
                $_POST = array();
                if(!$mysql->query($query)){
                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                }

            }
            ?>
            <div class="container">
                <div class="row">
                    <h3>Add information about accommodation</h3>
                    <hr>
                    <div class="col-md-6">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input required type="text" id ="name" name="name" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Information</label>
                                <input required type="text" id ="information" name="information" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input required type="text" id ="address" name="address" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="logo" id="logo" class="form-control" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="submit3">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="venues">
            <?php
            if (!empty($_FILES['venue_image_url'])) {
                include_once 'venue_images.php';
            }
            if (isset($_POST['submit4'])){
                $venueName = mysqli_real_escape_string($mysql, $_POST['venue_name']);
                $venueDescription = mysqli_real_escape_string($mysql, $_POST['venue_description']);
                $venueAddress = mysqli_real_escape_string($mysql, $_POST['venue_address']);
                $image=($_FILES['venue_image_url']['name']);
                $tournamentId = $id;
                $query = "INSERT INTO venue (venue_name, venue_address, venue_image_url, venue_description, tournament_id)
                VALUES
                ('{$venueName}','{$venueAddress}','{$image}','{$venueDescription}','{$tournamentId}');";
                $_POST = array();
                if(!$mysql->query($query)){
                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            ?>
            <div class="container">
                <div class="row">
                    <h3>Add information about Venues</h3>
                    <hr>
                    <div class="col-md-6">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Venue name</label>
                                <input required type="text" id ="venue_name" name="venue_name" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Venue description</label>
                                <input required type="text" id ="venue_description" name="venue_description" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Venue address</label>
                                <input required type="text" id ="venue_address" name="venue_address" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Venue image</label>
                                <input type="file" name="venue_image_url" id="venue_image_url" class="form-control" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="submit4">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="leisure">
            <?php
            include_once 'leisure_images.php';
            if (isset($_POST['submit5'])&& !empty($_POST['leisure_name'])){
                $leisureName = mysqli_real_escape_string($mysql, $_POST['leisure_name']);
                $leisureDescription = mysqli_real_escape_string($mysql, $_POST['leisure_description']);
                $leisureAddress = mysqli_real_escape_string($mysql, $_POST['leisure_address']);
                $image=($_FILES['leisure_image_url']['name']);
                $tournamentId = $id;
                $query = "INSERT INTO leisure (leisure_name, leisure_address, leisure_image_url, leisure_description, tournament_id)
                VALUES
                ('{$leisureName}','{$leisureAddress}','{$image}','{$leisureDescription}','{$tournamentId}');";
                $_POST = array();
                if(!$mysql->query($query)){
                    echo'Sisestus ebaõnnestus - ' . $mysql->error;
                }
            }
            ?>
            <div class="container">
                <div class="row">
                    <h3>Add information about Venues</h3>
                    <hr>
                    <div class="col-md-6">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Leisure name</label>
                                <input required type="text" id ="leisure_name" name="leisure_name" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Leisure description</label>
                                <input required type="text" id ="leisure_description" name="leisure_description" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Leisure address</label>
                                <input required type="text" id ="leisure_address" name="leisure_address" class="form-control" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Leisure image</label>
                                <input type="file" name="leisure_image_url" id="leisure_image_url" class="form-control" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="submit5">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
</body>
<?php include_once 'footer.php'; ?>
