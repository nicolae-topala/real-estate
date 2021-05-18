<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AdvertisementsDao extends BaseDao{
    public function __construct(){
        parent::__construct("advertisements");
    }

    public function get_advertisements($offset, $limit, $ad, $order = "-id"){
        list($order_column, $order_direction) = parent::parse_order($order);

        $query="SELECT advertisements.*, descriptions.type_id, descriptions.location_id,
                       locations.name AS location_name, ad_types.name AS type_name,
                       descriptions.rooms, descriptions.floor, descriptions.space,
                       descriptions.price, descriptions.address, descriptions.text,
                       users.first_name, users.last_name
                FROM advertisements
                JOIN descriptions ON advertisements.description_id=descriptions.id
                JOIN locations ON descriptions.location_id=locations.id
                JOIN ad_types ON descriptions.type_id=ad_types.id
                JOIN users ON advertisements.admin_id=users.id
                WHERE LOWER(title) LIKE CONCAT('%','".strtolower($ad['title'])."','%')
                AND address LIKE CONCAT('%','".strtolower($ad['address'])."','%')
                AND floor >= :floors_min
                AND floor <= :floors_max
                AND price >= :price_min
                AND price <= :price_max
                AND space >= :space_min
                AND space <= :space_max
                AND rooms >= :rooms_min
                AND rooms <= :rooms_max ";

        if($ad['location_id'] > 0) $query.="AND location_id = ${ad['location_id']} ";
        if($ad['type_id'] > 0) $query.="AND type_id = ${ad['type_id']} ";
        if($order_column=="id" || $order_column=="title") // search on advertisements only id and title, the rest are on descriptions
            $order_table="advertisements";
        else
            $order_table = "descriptions";

        $query.="ORDER BY ${order_table}.${order_column} ${order_direction} LIMIT ${limit} OFFSET ${offset}";
        return $this->query($query, [
            "floors_min" => $ad['floors_min'],
            "floors_max" => $ad['floors_max'],
            "price_min" => $ad['price_min'],
            "price_max" => $ad['price_max'],
            "space_min" => $ad['space_min'],
            "space_max" => $ad['space_max'],
            "rooms_min" => $ad['rooms_min'],
            "rooms_max" => $ad['rooms_max']
        ]);
    }

    public function get_ad_by_id($id){
        return $this->query_unique("SELECT advertisements.*, descriptions.type_id, descriptions.location_id,
                                           locations.name AS location_name, ad_types.name AS type_name,
                                           descriptions.rooms, descriptions.floor, descriptions.space,
                                           descriptions.price, descriptions.address, descriptions.text,
                                           users.first_name, users.last_name
                                    FROM advertisements
                                    JOIN descriptions ON advertisements.description_id=descriptions.id
                                    JOIN locations ON descriptions.location_id=locations.id
                                    JOIN ad_types ON descriptions.type_id=ad_types.id
                                    JOIN users ON advertisements.admin_id=users.id
                                    WHERE advertisements.id = :id", ["id" => $id]);
    }
}
