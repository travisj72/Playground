<html>
    <head>
        <title>Conversions</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
            $conversions = ["Length", "Mass", "Area", "Volume", "Speed", "Density", "Force", "Energy", "Power","Pressure"];
            if(isset($_POST['convert'])){
                $op = $_POST['convert'];
                switch ($op){
                    case "Length":
                        $op_array = ["Kilometer (km)", "Meter (m)", "Centimeter (cm)", "MilliMeter (mm)", "Micron (µ)", "MilliMicron (mµ)", "Inch (in)", "Foot (ft)", "Yard (yd)", "Mile (mi)"];
                        break;
                    case "Mass":
                        $op_array = ["Kilogram (kg)", "Pound (lb)", "Gram (gm)"];
                        break;
                    case "Area":
                        $op_array = ["Square Meter (m^2)", "Square Mile (mi^2)", "Square Foot (ft^2)", "Acre"];
                        break;
                    case "Volume":
                        $op_array = ["Liter (l)", "Quart (qt)", "Cubic Meter (m^3)", "Cubic Foot (ft^3)", "U.S. Gallon (gal)", "British Gallon (gal)"];
                        break;
                    case "Speed":
                        $op_array = ["km/h", "m/sec", "mi/h", "ft/sec"];
                        break;
                    case "Density":
                        $op_array = ["gm/cm^3", "kg/m^3", "lb/ft^3", "gm/cm^3"];
                        break;
                    case "Force":
                        $op_array = ["Newton (nt)", "dynes", "kgwt", "lbwt", "U.S. short ton", "long ton", "metric ton"];
                        break;
                    case "Energy":
                        $op_array = ["Joule", "Calorie (cal)", "British Thermal Unit (Btu)", "Killowatt Hour (kw hr)", "Electron Volt (ev)"];
                        break;
                    case "Power":
                        $op_array = ["Watt (w)", "Horsepower (hp)", "Kilowatt (kw)"];
                        break;
                    case "Pressure":
                        $op_array = ["Atmosphere (atm)"];
                        break;
                }
            } else {
                $_POST['convert'] = 'Length';
                $op_array = ["Kilometer (km)", "Meter (m)", "Centimeter (cm)", "MilliMeter (mm)", "Micron (µ)", "MilliMicron (mµ)", "Inch (in)", "Foot (ft)", "Yard (yd)", "Mile (mi)"];
            }
            
            if(isset($_POST['convert_from'])){
                $conv_val = $_POST['conv_val'];
                $measure1 = $_POST['convert_from'];
                $measure2 = $_POST['convert_to'];
            }
        ?>

        <div class="jumbotron text-center">
            <h2>Home-Made Conversions</h2>
            <p>Here you can convert everything that you need!</p>
        </div>

        <div class="container">
            <!-- Create the Drop Down for Conversions -->
            <div id="conversion-form">
                <form class="form-inline" id="lookup" method ="POST">
                    <input type='hidden'  name ='topic' value='<?=$topic?>' onchange="rememberField(this)"/>&nbsp;
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-sm-4" for="convert">Choose Your Conversion Type</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="convert" name="convert" onChange="this.form.submit();">
                                        <?php
                                            // Build the conversion drop down list
                                            foreach( $conversions as $option ) {
                                                if ( $op==$option ) {
                                                    $selected=" SELECTED";
                                                } else {
                                                    $selected=" ";
                                                }
                                                echo "<option value='".$option."'".$selected.">".$option."</option>\n";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                Convert: <input type="text" class="form-control mb-2 mr-sm-2" id="conv_val" name="conv_val">
                                <select class="form-control mb-2 mr-sm-2" id="convert_from" name="convert_from">
                                    <?php
                                        foreach( $op_array as $option ) {
                                            if ( $op==$option ) {
                                                $selected=" SELECTED";
                                            } else {
                                                $selected=" ";
                                            }
                                            echo "<option value='".$option."'".$selected.">".$option."</option>\n";
                                        }
                                    ?>
                                </select>
                                <label for="convert_to" class="mr-sm-2">to </label>
                                <select class="form-control mb-2 mr-sm-2" id="convert_to" name="convert_to">
                                    <?php
                                        foreach( $op_array as $option ) {
                                            if ( $op==$option ) {
                                                $selected=" SELECTED";
                                            } else {
                                                $selected=" ";
                                            }
                                            echo "<option value='".$option."'".$selected.">".$option."</option>\n";
                                        }
                                    ?>
                                </select>
                                <button type="submit" class="btn btn-primary mb-2">Calculate</button>
                            </div>
                        </div>
                </form>
            </div>
        </div> 
        <hr>
        
        <?php
            if(isset($conv_val) && $conv_val != "" ){
                echo "<h2 align='center'>Converting $conv_val $measure1 to $measure2</h2>";
                $woo = math1234($op, $conv_val, $measure1, $measure2);
                echo "<h1> $woo $measure2 </h1>";
            }

            function math1234($op, $conv_val, $measure1, $measure2){
                switch ($op){
                    case "Length":
                        $km = [1, 1000, 10000, 100000, 1000000, 39.37, 3.28, 1.093, 0.00062]; // km -> m -> cm -> mm -> mu -> in -> ft -> yard -> mi
                        $m = [1000, 1, ];
                        $cm = [];
                        $mm = [];
                        $mu = [];
                        $in = [];
                        $ft = [0.0003048, 0.3048, smol, smoler , smolest, 12, 1, .3, 5280];
                        $yd = [.0009, .9, smol, smoler, smolest, 36, 3, 0.0005681];
                        $mi = [];
                        break;
                    case "Mass":
                        $kg = [1, 2.2046, 1000];  //kg -> pound -> gram
                        $lb = [0.4535, 1, 453.6]; //kg -> pound -> gram
                        $gm = [0.001, 0.0022, 1]; //kg -> pound -> gram
                        switch ($measure1){
                            case "Kilogram (kg)":
                                $math_array = $kg;
                                break;
                            case "Pound(lb)":
                                $math_array = $lb;
                                break;
                            case "Gram (gm)":
                                $math_array = $gm;
                                break;
                        }
                        if ($measure2 == "Kilogram (kg)"){
                            return $math_array[0] * $conv_val;
                        } else if ($measure2 == "Pound (lb)"){
                            return $math_array[1] * $conv_val;
                        } else if ($measure2 == "Gram (gm)"){
                            return $math_array[2] * $conv_val;
                        }
                        break;
                    case "Area":
                        break;
                    case "Volume":
                        break;
                    case "Speed":
                        break;
                    case "Density":
                        break;
                    case "Force":
                        break;
                    case "Energy":
                        break;
                    case "Power":
                        $w = [1, 0.0013, 1000];   // watt -> horsepower -> kilowatt
                        $hp = [745.7, 1, 0.7457]; // watt -> horsepower -> kilowatt
                        $kw = [1000, 1.3410 , 1]; // watt -> horsepower -> kilowatt
                        switch ($measure1){
                            case "Watt (w)":
                                $math_array = $w;
                                break;
                            case "Horsepower (hp)":
                                $math_array = $hp;
                                break;
                            case "Kilowatt (kw)":
                                $math_array = $kw;
                                break;
                        }
                        if ($measure2 == "Watt (w)"){
                            return $math_array[0] * $conv_val;
                        } else if ($measure2 == "Horsepower (hp)"){
                            return $math_array[1] * $conv_val;
                        } else if ($measure2 == "Kilowatt (kw)"){
                            return $math_array[2] * $conv_val;
                        }
                    case "Pressure":
                        break;
                }
            }
        ?>
    </body>

</html>