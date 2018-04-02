<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 16:59
 */
include_once 'db.php';
include_once 'header.php';

$result= $mysql->query("SELECT t.id, t.name, t.country_id, t.logo, t.start_date, t.address, s.sport_name, a.age_name, l.level, g.gender, cl.class_name FROM tournaments AS t 
                    LEFT JOIN sports as s ON t.sport_id = s.id
                    LEFT JOIN ages as a ON t.age_id = a.id
                    LEFT JOIN class as cl ON t.class_id = cl.id
                    LEFT JOIN level as l ON t.level_id = l.id
                    LEFT JOIN gender as g ON t.gender_id = g.id
                    ORDER by t.id DESC");
?>
<body style="font-family: 'Lato', sans-serif;">
<div class="container">
    <div class="col-sm-12">
        <h3>All the tournaments</h3>
        <?php

        while ($row = $result->fetch_assoc()){ ?>
        <div class="row panel panel-default under-shadow col-sm-12" style="margin-right:15px; margin-left:15px; margin-top:20px;">
            <div style="margin-top:15px;" class="col-sm-7">
                        <span style="font-size: 30px;">
                            <?php if ( $row['country_id'] == '1') {?>
                            <img src="images/flags/et-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '2') {?>
                                <img src="images/flags/ru-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '3') {?>
                                <img src="images/flags/lv-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '4') {?>
                                <img src="images/flags/lt-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <?php if ( $row['country_id'] == '5') {?>
                                <img src="images/flags/fi-large.png" style="width:30px; height:22px; border:1px solid black;">
                            <?php } ?>
                            <a href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
                        </span>
                <br />
                        <span class="tournament-info"><i class="fas fa-calendar-alt"></i> <?php echo $row['start_date']; ?>
                            <!--@if(!is_null($tournament->end_date))
                            - {{ date('d.m.Y', strtotime($tournament->end_date)) }}
                            @endif-->
                        </span>
                <br />
                <span class="tournament-info"><i class="fa fa-futbol"></i> Sport: <?php echo $row['sport_name']; ?></span>
                <br />
                <span class="tournament-info"><i class="fa fa-map-marker"></i> Class: <?php echo $row['class_name']; ?> (<?php echo $row['gender']; ?>, <?php echo $row['age_name']; ?>)</span>
                <br />
                <span class="tournament-info"><i class="fa fa-map-marker"></i> Level: <?php echo $row['level']; ?></span>
                <br />
                <span class="tournament-info"><i class="fa fa-map-marker"></i> Adress: <?php echo $row['address']; ?></span>
            </div>
            <div class="tournament-search-result col-sm-5">
                <?php
                $logo = 'c:/xampp7/htdocs/loputoo/images/logos/'. $row['logo'];
                if ($row['logo'] != '' && file_exists($logo)) {?>
                <img class="img-responsive center-block max-height" style="max-width:170px; max-height:140px;" src="images/logos/<?php echo $row['logo']; ?>">
                <?php }
                else { ?> <img class="img-responsive center-block max-height" style="max-width:170px; max-height:140px;" src="images/logos/turniir_new_0.png">
                <?php } ?>
            </div>
        </div>
            <?php
        }
        ?>
    </div>
</div>
<?php include_once 'footer.php'; ?>
</body>
