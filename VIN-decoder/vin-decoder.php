<?php
/*
Plugin Name: VIN decoder Plugin
Description: Show details about the car by its VIN code
*/

    function vin_decoder_function() {

        if(array_key_exists('vin_decoder_update', $_POST)) {
            update_option( 'vin-decoder_decode_vin', $_POST['vin_code']);
            $vin_code = get_option( 'vin-decoder_decode_vin', '' );

            ?>
                <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><strong>Settings habe been saved</strong></div>
            <?php
        }

        ?>
            <h2>VIN Decoder</h2>
            <form method="POST" action="" style="margin-bottom: 10px;">
                <label for="vin_code">Enter your VIN to check vehicle details</label>
                <input name="vin_code" class="large-text" placeholder="<?php $vin_code ?>"></input>
                <input type="submit" name="vin_decoder_update" class="button buttom-primary" value="Check">
            </form>
        <?php

        $content = json_decode(get_vin_decoder_response());

        $make = '<strong>'.$content->specification->make.'</strong>';
        $model = '<strong>'.$content->specification->model.'</strong>';
        $year = '<strong>'.$content->specification->year.'</strong>';
        $style = '<strong>'.$content->specification->style.'</strong>';
        $trim_level = '<strong>'.$content->specification->trim_level.'</strong>';
        $made_in = '<strong>'.$content->specification->made_in.'</strong>';
        $steering_type = '<strong>'.$content->specification->steering_type.'</strong>';
        $anti_brake_system = '<strong>'.$content->specification->anti_brake_system.'</strong>';
        $overall_height = '<strong>'.$content->specification->overall_height.'</strong>';
        $overall_length = '<strong>'.$content->specification->overall_length.'</strong>';
        $overall_width = '<strong>'.$content->specification->overall_width.'</strong>';
        $standard_seating = '<strong>'.$content->specification->standard_seating.'</strong>';
        $highway_mileage = '<strong>'.$content->specification->highway_mileage.'</strong>';
        $city_mileage = '<strong>'.$content->specification->city_mileage.'</strong>';
        $fuel_type = '<strong>'.$content->specification->fuel_type.'</strong>';
        $transmission = '<strong>'.$content->specification->transmission.'</strong>';
        $drive_type = '<strong>'.$content->specification->drive_type.'</strong>';

        echo "<div class='grid-container'>".
                "<div class='grid-item make'><i class='fas fa-car'></i> Make: $make</div>".
                "<div class='grid-item model'><i class='fas fa-car-side'></i> Model: $model</div>".
                "<div class='grid-item style'><i class='fas fa-credit-card'></i> Style: $style</div>".
                "<div class='grid-item year'><i class='fas fa-cogs'></i> Year: $year</div>".
                "<div class='grid-item trim_level'> Trim level: $trim_level</div>".
                "<div class='grid-item made_in'><i class='fas fa-globe-europe'></i> Made in: $made_in</div>".
                "<div class='grid-item steering_type'> Steering type: $steering_type</div>".
                "<div class='grid-item anti_brake_system'> Anti brake system: $anti_brake_system</div>".
                "<div class='grid-item overall_height'><i class='fas fa-arrows-alt-v'></i> Overall height: $overall_height</div>".
                "<div class='grid-item overall_length'><i class='fas fa-arrows-alt-h'></i> Overall length: $overall_length</div>".
                "<div class='grid-item overall_width'> Overall width: $overall_width</div>".
                "<div class='grid-item standard_seating'><i class='fas fa-users'></i> Standard seating: $standard_seating</div>".
                "<div class='grid-item highway_mileage'><i class='fas fa-tachometer-alt'></i> Highway mileage: $highway_mileage</div>".
                "<div class='grid-item city_mileage'><i class='fas fa-tachometer-alt'></i> City mileage: $city_mileage</div>".
                "<div class='grid-item fuel_type'><i class='fas fa-gas-pump'></i> Fuel type: $fuel_type</div>".
                "<div class='grid-item transmission'> Transmission: $transmission</div>".
                "<div class='grid-item drive_type'> Drive type: $drive_type</div>".
            "</div>";
    }

    add_shortcode('vin_decoder', 'vin_decoder_function');

    function vin_decoder_admin_menu_options() {
        add_menu_page('VIN decoder', 'VIN decoder', 'manage_options', 'vin_decoder_admin_menu', 'vin_decoder_page', '', 200);
    }

    add_action('admin_menu', 'vin_decoder_admin_menu_options');

    function vin_decoder_page() {

        if(array_key_exists('vin_decoder_update', $_POST)) {
            update_option( 'vin-decoder_host', $_POST['x-rapidapi-host']);
            update_option( 'vin-decoder_key', $_POST['x-rapidapi-key']);
            update_option( 'vin-decoder_decode_vin', $_POST['decode_vin']);
            ?>
                <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><strong>Settings habe been saved</strong></div>
            <?php
        }

        $x_rapidapi_host = get_option( 'vin-decoder_host', 'vindecoder.p.rapidapi.com' );
        $x_rapidapi_key = get_option( 'vin-decoder_key', 'b3d7aa64a6mshd224265ee2311acp1ce24ajsn486d6863550f' );
        $vin = get_option( 'vin-decoder_decode_vin', 'JTHBP5C21B5009664' );

        ?>
            <div class="wrap">
                <h2>VIN Decoder settings</h2>
                <form method="POST" action="">
                    <label for="x-rapidapi-host">x-rapidapi-host:</label>
                    <textarea name="x-rapidapi-host" class="large-text"><?php print $x_rapidapi_host ?></textarea>
                    <label for="x-rapidapi-key">x-rapidapi-key: </label>
                    <textarea name="x-rapidapi-key" class="large-text"><?php print $x_rapidapi_key ?></textarea>
                    <label for="decode_vin">VIN code: </label>
                    <textarea name="decode_vin" class="large-text"><?php print $vin ?></textarea>
                    <input type="submit" name="vin_decoder_update" class="button buttom-primary" value="Update">
                </form>
            </div>
        <?php
    }

    function get_vin_decoder_response() {

        $x_rapidapi_host = get_option( 'vin-decoder_host', 'vindecoder.p.rapidapi.com' );
        $x_rapidapi_key = get_option( 'vin-decoder_key', 'b3d7aa64a6mshd224265ee2311acp1ce24ajsn486d6863550f' );
        $vin = get_option( 'vin-decoder_decode_vin', '' );

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://vindecoder.p.rapidapi.com/v1.1/decode_vin?vin=$vin",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: $x_rapidapi_host",
                "x-rapidapi-key: $x_rapidapi_key"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    function vin_decoder_css() {
        echo '
        <script src="https://kit.fontawesome.com/4c0fefb6d9.js" crossorigin="anonymous"></script>
        <style type="text/css">
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(9, 1fr);
            gap: 10px 60px;
            margin-bottom: 20px;
            grid-template-areas:
              "make year"
              "model style"
              "made_in trim_level"
              "steering_type anti_brake_system"
              "overall_height standard_seating"
              "overall_length highway_mileage"
              "overall_width city_mileage"
              "fuel_type transmission"
              "drive_type .";
          }
          .grid-item strong{
              float: right;
          }
          
          .make { grid-area: make; }
          
          .model { grid-area: model; }
          
          .year { grid-area: year; }
          
          .style { grid-area: style; }
          
          .trim_level { grid-area: trim_level; }
          
          .made_in { grid-area: made_in; }
          
          .steering_type { grid-area: steering_type; }
          
          .anti_brake_system { grid-area: anti_brake_system; }
          
          .overall_height { grid-area: overall_height; }
          
          .overall_length { grid-area: overall_length; }
          
          .overall_width { grid-area: overall_width; }
          
          .standard_seating { grid-area: standard_seating; }
          
          .highway_mileage { grid-area: highway_mileage; }
          
          .city_mileage { grid-area: city_mileage; }
          
          .fuel_type { grid-area: fuel_type; }
          
          .transmission { grid-area: transmission; }
          
          .drive_type { grid-area: drive_type; }
          
        </style>
        ';
    }
    
    add_action( 'wp_head', 'vin_decoder_css' );


?>
