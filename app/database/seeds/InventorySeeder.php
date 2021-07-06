<?php

class InventorySeeder extends Seeder {
    public function run()
  	{  
        DB::table("inventory")->truncate();
       	$data = array(
  	        array("name"=>"Pin", "description"=>"softpin and reload coupon", "quantity_on_hand"=>"0", "min_level"=>"0", "status"=>"active", "created_at"=>new datetime()),
  	        array("name"=>"Pinless", "description"=>"web reload credit", "quantity_on_hand"=>"0", "min_level"=>"0", "status"=>"active", "created_at"=>new datetime()),
  	        array("name"=>"SIM Card", "description"=>"sim card", "quantity_on_hand"=>"0", "min_level"=>"0", "status"=>"active", "created_at"=>new datetime()),
            );
       	DB::table("inventory")->insert( $data );

        DB::table("pin")->truncate();
        $data = array(
            array("serial_no"=>"0000000000", "pin"=>hash('sha512', '000000'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000001", "pin"=>hash('sha512', '000001'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000002", "pin"=>hash('sha512', '000002'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000003", "pin"=>hash('sha512', '000003'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000004", "pin"=>hash('sha512', '000004'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000005", "pin"=>hash('sha512', '000005'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000006", "pin"=>hash('sha512', '000006'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000007", "pin"=>hash('sha512', '000007'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000008", "pin"=>hash('sha512', '000008'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000009", "pin"=>hash('sha512', '000009'), "amount"=>"10", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000010", "pin"=>hash('sha512', '000010'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000011", "pin"=>hash('sha512', '000011'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000012", "pin"=>hash('sha512', '000012'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000013", "pin"=>hash('sha512', '000013'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000014", "pin"=>hash('sha512', '000014'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000015", "pin"=>hash('sha512', '000015'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000016", "pin"=>hash('sha512', '000016'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000017", "pin"=>hash('sha512', '000017'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000018", "pin"=>hash('sha512', '000018'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000019", "pin"=>hash('sha512', '000019'), "amount"=>"30", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000020", "pin"=>hash('sha512', '000020'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000021", "pin"=>hash('sha512', '000021'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000022", "pin"=>hash('sha512', '000022'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000023", "pin"=>hash('sha512', '000023'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000024", "pin"=>hash('sha512', '000024'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000025", "pin"=>hash('sha512', '000025'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000026", "pin"=>hash('sha512', '000026'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000027", "pin"=>hash('sha512', '000027'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000028", "pin"=>hash('sha512', '000028'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000029", "pin"=>hash('sha512', '000029'), "amount"=>"50", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000030", "pin"=>hash('sha512', '000030'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000031", "pin"=>hash('sha512', '000031'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000032", "pin"=>hash('sha512', '000032'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000033", "pin"=>hash('sha512', '000033'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000034", "pin"=>hash('sha512', '000034'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000035", "pin"=>hash('sha512', '000035'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000036", "pin"=>hash('sha512', '000036'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000037", "pin"=>hash('sha512', '000037'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000038", "pin"=>hash('sha512', '000038'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            array("serial_no"=>"0000000039", "pin"=>hash('sha512', '000039'), "amount"=>"100", "branch_id"=>"1", "is_used"=>"0", "expired_at"=>"2015-12-31 23:59:59", "created_at"=>new datetime()),
            );
        DB::table("pin")->insert( $data );

    }
}

?>