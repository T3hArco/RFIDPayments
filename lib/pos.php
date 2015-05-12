<?php

if(!defined("main"))
   die();

function buildPosIcons($db) {
    $output = "Error building product list";
    
    if($result = mysqli_query($db, "SELECT * FROM products")) {
        $output = "";
        
        while($row = mysqli_fetch_array($result)) {
            if(!file_exists("assets/food/" . $row['picture']))
               $row['picture'] = "unknown.png";
            
            $output .= '<div class="col-xs-6 col-md-3">
                        <a href="#" class="thumbnail" onclick="return addToPosTotal(\'' . $row['name'] . '\', ' . $row['price'] . ');">
                          <!--<img src="assets/food/' . $row['picture'] . '" alt="' . $row['name'] . '" style="height:64px;">-->
                          <img src="assets/food/' . $row['picture'] . '" alt="' . $row['name'] . '" style="height:64px;">
                          <div class="caption">
                            <h3>' . $row['name'] . '</h3>
                            <p>' . $row['price'] . ' bonnetje(s)</p>
                          </div>
                        </a>
                      </div>';
        }

        $output .= '<div class="col-xs-6 col-md-3">
                        <a href="#" class="thumbnail" onclick="return clearPos();">
                          <img src="assets/food/clear.png" alt="Clear" style="height:64px;">
                          <div class="caption">
                            <h3>Begin opnieuw</h3>
                            <p>Reset het winkelmandje</p>
                          </div>
                        </a>
                      </div>';
    }
    
    return $output;
}
