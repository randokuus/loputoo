<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'C:/xampp7/htdocs/loputoo/db.php';
include_once 'C:/xampp7/htdocs/loputoo/mobile_menu.php';
include_once 'C:/xampp7/htdocs/loputoo/tournament_header.php';
$id = (int)$_GET['id'];
$result = $mysql->query('SELECT * FROM tournaments AS t 
LEFT JOIN sports as s ON t.sport_id = s.id
LEFT JOIN countries as c ON t.country_id = c.country_id
LEFT JOIN ages as a ON t.age_id = a.id
LEFT JOIN class as cl ON t.class_id = cl.id
LEFT JOIN level as l ON t.level_id = l.id
LEFT JOIN gender as g ON t.gender_id = g.id
WHERE t.Id = "' . $id . '";');

?>
    <div class="info">
        <div class="container" style="padding:0px;">
            <ul class="nav nav-pills nav-justified" style="background-color: white;">
                <li class="active">
                    <a class="nav-link" data-toggle="tab" href="#info">Info <span class="sr-only">(current)</span></a>
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
            <div class="tab-pane fade in active" id="info">
                <h2>Info</h2>
                <hr>
                <?php echo $row['info']; ?>
                <p>
                </p>
            </div>
            <div class="tab-pane fade in" id="rules">
                <div class="col-sm-12">
                    <h2>Rules</h2>
                    <hr>
                    <?php echo $row['rules']; ?>
                </div>
            </div>
            <div class="tab-pane fade in" id="acommodation">
                <?php
                $sql = $mysql->query('SELECT * FROM accommodation
            WHERE tournament_id = "' . $id . '";');

                ?>
                <div class="col-sm-12">
                    <h2>Accomodation</h2>
                    <hr>
                    <?php while ($row = $sql->fetch_assoc()){ ?>
                        <div class="col-sm-12 panel panel-default under-shadow" style="margin-bottom: 25px;">
                            <div class="col-sm-7">
                                <h3 style="text-align: center;"><?php echo $row['name']; ?></h3>
                                <p><i class="fas fa-info-circle" style="font-size:2em; margin-right: 7px;"></i><?php echo $row['information']; ?></p>
                                <p><i class="fas fa-map-marker-alt" style="font-size:1.5em; margin-right: 7px;"></i><?php echo $row['address']; ?></p>
                            </div>
                            <div class="col-sm-5">
                                <?php
                                $logo = 'c:/xampp7/htdocs/loputoo/images/accommodation/'. $row['image_url'];
                                if ($row['image_url'] != '' && file_exists($logo)) {?>
                                    <img class="img-responsive center-block max-height" style="width:350px; height:200px; margin-top: 10px; margin-bottom: 10px;" src="http://localhost:8080/loputoo/images/accommodation/<?php echo $row['image_url']; ?>">
                                <?php }
                                else { ?> <p>No pictures available</p>
                                <?php } ?>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
                </div>
            </div>
            <div class="tab-pane fade in" id="venues">
                <?php
                $sql = $mysql->query('SELECT * FROM venue
            WHERE tournament_id = "' . $id . '";');

                ?>
                <div class="col-sm-12">
                    <h2>Venues</h2>
                    <hr>
                    <?php while ($row = $sql->fetch_assoc()){ ?>
                        <div class="col-sm-12 panel panel-default under-shadow" style="margin-bottom: 25px;">
                            <div class="col-sm-7">
                                <h3 style="text-align: center;"><?php echo $row['venue_name']; ?></h3>
                                <p><i class="fas fa-info-circle" style="font-size:2em; margin-right: 7px;"></i><?php echo $row['venue_description']; ?></p>
                                <p><i class="fas fa-map-marker-alt" style="font-size:1.5em; margin-right: 7px;"></i><?php echo $row['venue_address']; ?></p>
                            </div>
                            <div class="col-sm-5">
                                <?php
                                $logo = 'c:/xampp7/htdocs/loputoo/images/venues/'. $row['venue_image_url'];
                                if ($row['venue_image_url'] != '' && file_exists($logo)) {?>
                                    <img class="img-responsive center-block max-height" style="width:350px; height:200px; margin-top: 10px; margin-bottom: 10px;" src="http://localhost:8080/loputoo/images/venues/<?php echo $row['venue_image_url']; ?>">
                                <?php }
                                else { ?> <p>No pictures available</p>
                                <?php } ?>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
                </div>
            </div>
            <div class="tab-pane fade in" id="leisure">
                <?php
                $sql = $mysql->query('SELECT * FROM leisure
            WHERE tournament_id = "' . $id . '";');

                ?>
                <div class="col-sm-12">
                    <h2>Leisure</h2>
                    <hr>
                    <?php while ($row = $sql->fetch_assoc()){ ?>
                        <div class="col-sm-12 panel panel-default under-shadow" style="margin-bottom: 25px;">
                            <div class="col-sm-7">
                                <h3 style="text-align: center;"><?php echo $row['leisure_name']; ?></h3>
                                <p><i class="fas fa-info-circle" style="font-size:2em; margin-right: 7px;"></i><?php echo $row['leisure_description']; ?></p>
                                <p><i class="fas fa-map-marker-alt" style="font-size:1.5em; margin-right: 7px;"></i><?php echo $row['leisure_address']; ?></p>
                            </div>
                            <div class="col-sm-5">
                                <?php
                                $logo = 'c:/xampp7/htdocs/loputoo/images/leisure/'. $row['leisure_image_url'];
                                if ($row['leisure_image_url'] != '' && file_exists($logo)) {?>
                                    <img class="img-responsive center-block max-height" style="width:350px; height:200px; margin-top: 10px; margin-bottom: 10px;" src="http://localhost:8080/loputoo/images/leisure/<?php echo $row['leisure_image_url']; ?>">
                                <?php }
                                else { ?> <p>No pictures available</p>
                                <?php } ?>
                            </div>
                        </div>
                        <hr>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php include_once 'C:/xampp7/htdocs/loputoo/footer.php'; ?>