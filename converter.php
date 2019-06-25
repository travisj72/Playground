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
                        $op_array = ["Kilometer (km)", "Meter (m)", "Centimeter (cm)", "MilliMeter (mm)", "Micron (µ)", "MilliMicron (mµ)", "Angstrom (A)", "Inch (in)", "Foot (ft)", "Mile (mi)"];
                        break;
                    case "Mass":
                        $op_array = ["Kilogram (kg)", "Pound (lb)", "Slug", "Gram (gm)"];
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
                        $op_array = ["gm/cm^3", "kg/m^3", "lb/ft^3", "slug/ft^3", "gm/cm^3"];
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
                $op_array = ["Kilometer (km)", "Meter (m)", "Centimeter (cm)", "MilliMeter (mm)", "Micron (µ)", "MilliMicron (mµ)", "Angstrom (A)", "Inch (in)", "Foot (ft)", "Mile (mi)"];
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
                math1234($op, $conv_val, $measure1, $measure2);
            }

            function math1234($op, $conv_val, $measure1, $measure2){
                switch ($op){
                    case "Length":
                        break;
                    case "Mass":
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
                        break;
                    case "Pressure":
                        break;
                }
            }
        ?>
    </body>

</html>