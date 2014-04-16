<?php
class connectMYSQL{
	private static  $db_Server="localhost";
	private static  $db_User="root";
	private static  $db_Pass="";
	private static  $db_Name="looking4museo";
	public static function openConnection(){
		return new mysqli(self::$db_Server,self::$db_User,self::$db_Pass,self::$db_Name);
	}
}

