<?php

namespace App\Server;

abstract class Utils
{
    protected static $MapClass = [
        "ABomb",
        "Courthouse",
        "Tenement",
        "JewelryHeist",
        "PowerPlant",
        "FairfaxResidence",
        "Foodwall",
        "MeatBarn",
        "DNA",
        "Casino",
        "Hotel",
        "ConvenienceStore",
        "RedLibrary",
        "Training",
        "Hospital",
        "ArmsDeal",
        "AutoGarage",
        "Arcade",
        "HalfwayHouse",
        "Backstage",
        "Office",
        "DrugLab",
        "Subway",
        "Warehouse"
    ];

    protected static $MapTitle = [
        "A-Bomb Nightclub",
        "Brewer County Courthouse",
        "Children of Taronne Tenement",
        "DuPlessis Diamond Center",
        "Enverstar Power Plant",
        "Fairfax Residence",
        "Food Wall Restaurant",
        "Meat Barn Restaurant",
        "Mt. Threshold Research Center",
        "Northside Vending",
        "Old Granite Hotel",
        "Qwik Fuel Convenience Store",
        "Red Library Offices",
        "Riverside Training Facility",
        "St. Michael's Medical Center",
        "The Wolcott Projects",
        "Victory Imports Auto Center",
        "-EXP- Department of Agriculture",
        "-EXP- Drug Lab",
        "-EXP- Fresnal St. Station",
        "-EXP- FunTime Amusements",
        "-EXP- Sellers Street Auditorium",
        "-EXP- Sisters of Mercy Hostel",
        "-EXP- Stetchkov Warehouse"
    ];

    protected static $EquipmentClass = [
        "None",
        "M4Super90SG",
        "NovaPumpSG",
        "BreachingSG",
        "LessLethalSG",
        "CSBallLauncher",
        "M4A1MG",
        "AK47MG",
        "G36kMG",
        "UZISMG",
        "MP5SMG",
        "SilencedMP5SMG",
        "UMP45SMG",
        "ColtM1911HG",
        "Glock9mmHG",
        "PythonRevolverHG",
        "Taser",
        "VIPColtM1911HG",
        "VIPGrenade",
        "LightBodyArmor",
        "HeavyBodyArmor",
        "gasMask",
        "HelmetAndGoggles",
        "FlashbangGrenade",
        "CSGasGrenade",
        "stingGrenade",
        "PepperSpray",
        "Optiwand",
        "Toolkit",
        "Wedge",
        "C2Charge",
        "detonator",
        "Cuffs",
        "IAmCuffed",
        "ColtAccurizedRifle",
        "HK69GrenadeLauncher",
        "SAWMG",
        "FNP90SMG",
        "DesertEagleHG",
        "TEC9SMG",
        "Stingray",
        "AmmoBandolier",
        "NoBodyArmor",
        "NVGoggles",
        "HK69GL_StingerGrenadeAmmo",
        "HK69GL_CSGasGrenadeAmmo",
        "HK69GL_FlashbangGrenadeAmmo",
        "HK69GL_TripleBatonAmmo"
    ];

    protected static $EquipmentTitle = [
        "None",
        "M4 Super90",
        "Nova Pump",
        "Shotgun",
        "Less Lethal Shotgun",
        "Pepper-ball",
        "Colt M4A1 Carbine",
        "AK-47 Machinegun",
        "GB36s Assault Rifle",
        "Gal Sub-machinegun",
        "9mm SMG",
        "Suppressed 9mm SMG",
        ".45 SMG",
        "M1911 Handgun",
        "9mm Handgun",
        "Colt Python",
        "Taser Stun Gun",
        "VIP Colt M1911 Handgun",
        "CS Gas",
        "Light Armor",
        "Heavy Armor",
        "Gas Mask",
        "Helmet",
        "Flashbang",
        "CS Gas",
        "Stinger",
        "Pepper Spray",
        "Optiwand",
        "Toolkit",
        "Door Wedge",
        "C2 [x3]",
        "The Detonator",
        "Zip-cuffs",
        "IAmCuffed",
        "Colt Accurized Rifle",
        "40mm Grenade Launcher",
        "5.56mm Light Machine Gun",
        "5.7x28mm Submachine Gun",
        "Mark 19 Semi-Automatic Pistol",
        "9mm Machine Pistol",
        "Cobra Stun Gun",
        "Ammo Pouch",
        "No Armor",
        "Night Vision Goggles",
        "Stinger",
        "CS Gas",
        "Flashbang",
        "Baton"
    ];

    protected static $AmmoClass = [
        "None",
        "M4Super90SGAmmo",
        "M4Super90SGSabotAmmo",
        "NovaPumpSGAmmo",
        "NovaPumpSGSabotAmmo",
        "LessLethalAmmo",
        "CSBallLauncherAmmo",
        "M4A1MG_JHP",
        "M4A1MG_FMJ",
        "AK47MG_FMJ",
        "AK47MG_JHP",
        "G36kMG_FMJ",
        "G36kMG_JHP",
        "UZISMG_FMJ",
        "UZISMG_JHP",
        "MP5SMG_JHP",
        "MP5SMG_FMJ",
        "UMP45SMG_FMJ",
        "UMP45SMG_JHP",
        "ColtM1911HG_JHP",
        "ColtM1911HG_FMJ",
        "Glock9mmHG_JHP",
        "Glock9mmHG_FMJ",
        "PythonRevolverHG_FMJ",
        "PythonRevolverHG_JHP",
        "TaserAmmo",
        "VIPPistolAmmo_FMJ",
        "ColtAR_FMJ",
        "HK69GL_StingerGrenadeAmmo",
        "HK69GL_FlashbangGrenadeAmmo",
        "HK69GL_CSGasGrenadeAmmo",
        "HK69GL_TripleBatonAmmo",
        "SAWMG_JHP",
        "SAWMG_FMJ",
        "FNP90SMG_FMJ",
        "FNP90SMG_JHP",
        "DEHG_FMJ",
        "DEHG_JHP",
        "TEC9SMG_FMJ"
    ];

    protected static $AmmoTitle = [
        "None",
        "00 Buck",
        "12 Gauge Slug",
        "00 Buck",
        "12 Gauge Slug",
        "Beanbags",
        "CS Balls",
        ".223 JHP",
        ".223 FMJ",
        "AK47 FMJ",
        "AK47 JHP",
        ".223 FMJ",
        ".223 JHP",
        "UZI FMJ",
        "UZI JHP",
        "9mm JHP",
        "9mm FMJ",
        ".45 FMJ",
        ".45 JHP",
        ".45 JHP",
        ".45 FMJ",
        "9mm JHP",
        "9mm FMJ",
        "357 Magnum FMJ",
        "357 Magnum FMJ",
        "Cartridge",
        "VIP 9mm FMJ",
        "ColtAR_FMJ",
        "Stinger",
        "Flashbang",
        "CS Gas",
        "Triple Baton Ammo",
        "SAWMG_JHP",
        "SAWMG_FMJ",
        "FNP90SMG_FMJ",
        "FNP90SMG_JHP",
        "DEHG_FMJ",
        "DEHG_JHP",
        "TEC9SMG_FMJ"
    ];

/*$GrenadeClass[0]="stingGrenade";  //lower-case
$GrenadeClass[1]="CSGasGrenade";
$GrenadeClass[2]="VIPGrenade";
$GrenadeClass[3]="FlashbangGrenade";
$GrenadeClass[4]="HK69GL_StingerGrenadeAmmo";
$GrenadeClass[5]="HK69GL_CSGasGrenadeAmmo";
$GrenadeClass[6]="HK69GL_FlashbangGrenadeAmmo";
$GrenadeClass[7]="HK69GL_TripleBatonAmmo";

$GrenadeProjectileClass[0]="StingGrenadeProjectile";
$GrenadeProjectileClass[1]="CSGasGrenadeProjectile";
$GrenadeProjectileClass[2]="VIPGrenadeProjectile";
$GrenadeProjectileClass[3]="FlashbangGrenadeProjectile";
$GrenadeProjectileClass[4]="StingGrenadeProjectile_HK69";
$GrenadeProjectileClass[5]="CSGasGrenadeProjectile_HK69";
$GrenadeProjectileClass[6]="FlashbangGrenadeProjectile_HK69";
$GrenadeProjectileClass[7]="TripleBatonProjectile_HK69";

$UnsafeChars[0]="\\t";
$UnsafeChars[1]="\\\\";

$StunWeapons_Taser=["Taser","Stingray"];
$StunWeapons_LessLethalSG=["LessLethalSG"];
$StunWeapons_Flashbang=["FlashbangGrenade","HK69GL_FlashbangGrenadeAmmo"];
$StunWeapons_Stinger=["stingGrenade","HK69GL_StingerGrenadeAmmo"];
$StunWeapons_Gas=["CSGasGrenade","VIPGrenade","CSBallLauncher","HK69GL_CSGasGrenadeAmmo"];
$StunWeapons_Spray=["PepperSpray"];
$StunWeapons_TripleBaton=["HK69GrenadeLauncher"];*/


    public static function getMapClassById($id)
    {
        $id = abs($id);
        if($id < count(self::$MapClass))
            return self::$MapClass[$id];
        else
            return "Unknown";
    }

    public static function getMapTitleById($id)
    {
        $id = abs($id);
        if($id < count(self::$MapTitle))
            return self::$MapTitle[$id];
        else
            return "Unknown";
    }

    public static function getEquipmentTitleById($id)
    {
        $id = abs($id);
        if($id < count(self::$EquipmentTitle))
            return self::$EquipmentTitle[$id];
        else
            return "Unknown";
    }

    public static function getEquipmentClassById($id)
    {
        $id = abs($id);
        if($id < count(self::$EquipmentClass))
            return self::$EquipmentClass[$id];
        else
            return "Unknown";
    }

    public static function getAmmoClassById($id)
    {
        $id = abs($id);
        if($id < count(self::$AmmoClass))
            return self::$AmmoClass[$id];
        else
            return "Unknown";
    }

    public static function getAmmoTitleById($id)
    {
        $id = abs($id);
        if($id < count(self::$AmmoTitle))
            return self::$AmmoTitle[$id];
        else
            return "Unknown";
    }

    /**
     * Return min and sec in format required(sprintf syntax) for Sec.
     */
    public static function getMSbyS($seconds,$syntax='%d:%d')
    {
        $min = $seconds / 60;
        $sec = $seconds % 60;
        return sprintf($syntax,$min,$sec);
    }

    /**
     * Returns equivalent Hours and Mins of given Secs.
     *
     * @param $time
     * @param string $syntax
     * @return string
     */
    public static function getHMbyS($time,$syntax = "%d:%d") {
        $s = $time % 60;
        $time= floor($time/60);
        $mins = $time % 60;
        $time= floor($time/60);
        $hours = floor($time);
        $str = sprintf($syntax,$hours,$mins);
        return $str;
    }
}