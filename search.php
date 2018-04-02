<?php
/**
 * Created by PhpStorm.
 * User: rando
 * Date: 11.02.2018
 * Time: 11:58
 */
include_once 'db.php';
include_once 'header.php';
?>
<?php
if (isset($_POST['submit'])) {
    $values['name'] = mysqli_real_escape_string($mysql, $_POST['name']);
    $values['address'] = mysqli_real_escape_string($mysql, $_POST['address']);
    $values['sport_id'] = mysqli_real_escape_string($mysql, $_POST['sport_id']);
    $values['country_id'] = mysqli_real_escape_string($mysql, $_POST['country_id']);
    $values['level_id'] = mysqli_real_escape_string($mysql, $_POST['level_id']);
    $values['age_id'] = mysqli_real_escape_string($mysql, $_POST['age_id']);
    $values['gender_id'] = mysqli_real_escape_string($mysql, $_POST['gender_id']);
    $values['class_id'] = mysqli_real_escape_string($mysql, $_POST['class_id']);
    $values['start_date'] = mysqli_real_escape_string($mysql, $_POST['start_date']);
    $values['to_date'] = mysqli_real_escape_string($mysql, $_POST['to_date']);
}
?>
<body style="font-family: 'Lato', sans-serif;">
<div class="container">
        <div class="col-sm-3">
            <div class="col-md-12 view-box padding-15 clearfix">
                <h3>Search Tournaments</h3>
                <hr>
                <form method="POST" action="/loputoo/search.php">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Location:</label>
                        <input type="text" id="address" name="address" class="form-control" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Select sport:</label>
                        <?php
                        $sportSelectValue = isset($_POST['sport_id']) ? $_POST['sport_id'] :'No selection';
                        ?>
                        <select class="form-control" name="sport_id" value="<?php echo $sportSelectValue; ?>">
                            <option>No selection</option>
                             <?php

                        $sql = mysqli_query($mysql, "SELECT DISTINCT sport_name, id FROM sports");

                        while ($row = $sql->fetch_assoc()){

                            ?>
                                <option <?php if(isset($_POST['sport_id']) && $_POST['sport_id'] == $row['id']){?>selected <?php } ?> id="sport_id" name='sport_id' value="<?php echo $row['id']; ?>">
                                    <?php echo $row['sport_name']; ?></option>


                                <?php
                        }
                        ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Select country:</label>
                        <?php
                        $countrySelectValue = isset($_POST['country_id']) ? $_POST['country_id'] :'No selection';
                        ?>
                        <select class="form-control" name="country_id" value="<?php echo $countrySelectValue; ?>">
                            <option>No selection</option>
                            <?php

                            $sql = mysqli_query($mysql, "SELECT DISTINCT country_name, country_id FROM countries");

                            while ($row = $sql->fetch_assoc()){

                                ?>
                                <option <?php if(isset($_POST['country_id']) && $_POST['country_id'] == $row['country_id']){?>selected <?php } ?> id="country_id" name='sport_id' value="<?php echo $row['country_id']; ?>">
                                    <?php echo $row['country_name']; ?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Select level:</label>
                        <?php
                        $levelSelectValue = isset($_POST['level_id']) ? $_POST['level_id'] :'No selection';
                        ?>
                        <select class="form-control" name="level_id" value="<?php echo $levelSelectValue; ?>">
                            <option>No selection</option>
                            <?php

                            $sql = mysqli_query($mysql, "SELECT DISTINCT level, id FROM level");

                            while ($row = $sql->fetch_assoc()){

                                ?>
                                <option <?php if(isset($_POST['level_id']) && $_POST['level_id'] == $row['id']){?>selected <?php } ?> id="level_id" name='level_id' value="<?php echo $row['id']; ?>">
                                <?php echo $row['level']; ?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Select class:</label>
                        <?php
                        $classSelectValue = isset($_POST['class_id']) ? $_POST['class_id'] :'No selection';
                        ?>
                        <select class="form-control" name="class_id" value="<?php echo $classSelectValue; ?>">
                            <option>No selection</option>
                            <?php

                            $sql = mysqli_query($mysql, "SELECT DISTINCT class_name, id FROM class");

                            while ($row = $sql->fetch_assoc()){

                                ?>
                                <option <?php if(isset($_POST['class_id']) && $_POST['class_id'] == $row['id']){?>selected <?php } ?> id="class_id" name='class_id' value="<?php echo $row['id']; ?>">
                                    <?php echo $row['class_name']; ?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Select age group:</label>
                        <?php
                        $ageSelectValue = isset($_POST['age_id']) ? $_POST['age_id'] :'No selection';
                        ?>
                        <select class="form-control" name="age_id" value="<?php echo $ageSelectValue; ?>">
                            <option>No selection</option>
                            <?php

                            $sql = mysqli_query($mysql, "SELECT DISTINCT age_name, id FROM ages");

                            while ($row = $sql->fetch_assoc()){

                                ?>
                                <option <?php if(isset($_POST['age_id']) && $_POST['age_id'] == $row['id']){?>selected <?php } ?> id="age_id" name='age_id' value="<?php echo $row['id']; ?>">
                                    <?php echo $row['age_name']; ?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Select gender:</label>
                        <?php
                        $genderSelectValue = isset($_POST['gender_id']) ? $_POST['gender_id'] :'No selection';
                        ?>
                        <select class="form-control" name="gender_id" value="<?php echo $genderSelectValue; ?>">
                            <option>No selection</option>
                            <?php

                            $sql = mysqli_query($mysql, "SELECT DISTINCT gender, id FROM gender");

                            while ($row = $sql->fetch_assoc()){

                                ?>
                                <option <?php if(isset($_POST['gender_id']) && $_POST['gender_id'] == $row['id']){?>selected <?php } ?> id="gender_id" name='gender_id' value="<?php echo $row['id']; ?>">
                                    <?php echo $row['gender']; ?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>From date</label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : '' ?>"/>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>To date:</label>
                        <input type="date" name="to_date" class="form-control" value="<?php echo isset($_POST['to_date']) ? htmlspecialchars($_POST['to_date']) : '' ?>"/>
                    </div>
                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary" name="submit">Search</button>
                    </div>
                </form>

            </div>
        </div>
    <?php
    if(isset($_POST['submit'])) {
        $queryString = "SELECT t.id, t.name, t.country_id, t.logo, t.start_date, t.address, s.sport_name, a.age_name, l.level, g.gender, cl.class_name FROM tournaments AS t 
                    LEFT JOIN sports as s ON t.sport_id = s.id
                    LEFT JOIN ages as a ON t.age_id = a.id
                    LEFT JOIN class as cl ON t.class_id = cl.id
                    LEFT JOIN level as l ON t.level_id = l.id
                    LEFT JOIN gender as g ON t.gender_id = g.id";

// ITERATE OVER THE SELECTED VALUES APPENDING TO WHERE CLAUSE
        $i = 1;
        $delete4Characters = false;
        foreach ($values as $key => $value) {
            if ($value == ''|| $value == 'No selection') continue; // SKIP EMPTIES
            if ($i == 1) {$queryString .= ' WHERE ';}
            if ($key == 'name' || $key == 'address'){
                $likeValue = '%' . $value . '%';
                $queryString .= "$key like '$likeValue'";
            }else if ($key == 'start_date'){
                $queryString .= "$key >= '$value'";
            }
            else if ($key == 'to_date'){
                $queryString .= "start_date <= '$value'";
            }else {
                $queryString .= "t.$key = '$value'";
            }
            $queryString .= " AND ";
            $delete4Characters = true;
            $i++;
        }
        if ($delete4Characters) {
            $queryString = substr($queryString, 0, -4);
        }
        $queryString .= " ORDER BY id DESC";
        $result = $mysql->query($queryString);

    } else {
        $result= $mysql->query("SELECT t.id, t.name, t.country_id, t.logo, t.start_date, t.address, s.sport_name, a.age_name, l.level, g.gender, cl.class_name FROM tournaments AS t 
                    LEFT JOIN sports as s ON t.sport_id = s.id
                    LEFT JOIN ages as a ON t.age_id = a.id
                    LEFT JOIN class as cl ON t.class_id = cl.id
                    LEFT JOIN level as l ON t.level_id = l.id
                    LEFT JOIN gender as g ON t.gender_id = g.id
                    ORDER by t.id DESC");
    }
    $row_cnt = $result->num_rows;
    ?>
    <div class="tournament-info" style="margin-top:50px;">
        <strong>Found: <?php echo "$row_cnt"; ?></strong>
    </div>
    <?php if ($row_cnt == '0'){?>
        <h3 style="color:red;">No results found, please try again</h3>
    <?php } else { ?>
    <div class="col-sm-9">
        <div>
            <div class="tournament-search-result">
                <?php
                while ($row = $result->fetch_assoc()){ ?>
                    <div class="row panel panel-default under-shadow">
                        <div class="tournament-search-result col-md-5 col-xs-12">
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
                        <span style="font-size: 22px;"><a style="color:black;" href="http://localhost:8080/loputoo/tournament_home.php?id=<?php echo $row['id']; ?>"><?php echo $row['name'];?></a>
                        </span>
                            <br />
                        <span class="tournament-info"><i class="fas fa-calendar-alt"></i> <?php echo $row['start_date']; ?>
                            <!--@if(!is_null($tournament->end_date))
                            - {{ date('d.m.Y', strtotime($tournament->end_date)) }}
                            @endif-->
                        </span>
                            <br />
                            <span class="tournament-info">Sport: <?php echo $row['sport_name']; ?></span>
                            <br />
                            <span class="tournament-info">Class: <?php echo $row['class_name']; ?> (<?php echo $row['gender']; ?>, <?php echo $row['age_name']; ?>)</span>
                            <br />
                            <span class="tournament-info">Level: <?php echo $row['level']; ?></span>
                            <br />
                            <span class="tournament-info"><i class="fa fa-map-marker"></i> Adress: <?php echo $row['address']; ?></span>
                        </div>
                        <div class="tournament-search-result col-md-4 col-xs-12">
                            <?php
                            $logo = 'c:/xampp7/htdocs/loputoo/images/logos/'. $row['logo'];
                            if ($row['logo'] != '' && file_exists($logo)) {?>
                                <img class="img-responsive center-block max-height" style="max-width:170px; max-height:140px;" src="images/logos/<?php echo $row['logo']; ?>">
                            <?php }
                            else { ?> <img class="img-responsive center-block max-height" style="max-width:170px; max-height:140px; margin-top:25px;" src="images/logos/turniir_new_0.png">
                            <?php } ?>
                        </div>
                        <div class="col-md-3 col-xs-12" style="margin-top:40px;">
                            <button><a href="/loputoo/tournament_registration.php?id=<?php echo $row['id']; ?>" style="color:black;">Register to tournament</a></button>
                            <button><a href="/loputoo/tournament_info.php?id=<?php echo $row['id']; ?>" style="color:black">View information</a></button>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php }?>
</div>
<?php include_once 'footer.php'; ?>
</body>

