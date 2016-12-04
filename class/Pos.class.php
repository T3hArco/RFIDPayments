<?php
/**
 * Created by IntelliJ IDEA.
 * User: arnaudcoel
 * Date: 28/09/15
 * Time: 12:03
 */

namespace pos;


class Pos
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function buildProductList()
    {
        $output = "";
        $products = $this->db->query("SELECT * FROM products;");
        $products->execute();

        foreach ($products as $product) {
            if (!file_exists("assets/food/" . $product['picture']))
                $product['picture'] = "unknown.png";

            $output .= '<div class="col-md-4"><a href="#" class="thumbnail" onclick="return addToPosTotal(\'' . $product['name'] . '\', ' . $product['price'] . ', ' . $product['id'] . ');"><div class="thumbnail"><img src="assets/food/' . $product['picture'] . '" alt="' . $product['name'] . '" style="height:64px;"></div><div class="caption"><h3>' . $product['name'] . '</h3><p>' . $product['price'] . ' bonnetje(s)</p></div></a></div>';
        }
        return $output;
    }
}