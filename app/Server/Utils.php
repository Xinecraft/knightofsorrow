<?php

namespace App\Server;

abstract class Utils
{

    protected static $languages = array(
        array('ab', 'abk', 'abk', 'abk', 'Abkhaz', 'аҧсуа бызшәа, аҧсшәа'),
        array('aa', 'aar', 'aar', 'aar', 'Afar', 'Afaraf'),
        array('af', 'afr', 'afr', 'afr', 'Afrikaans', 'Afrikaans'),
        array('ak', 'aka', 'aka', 'aka', 'Akan', 'Akan'),
        array('sq', 'sqi', 'alb', 'sqi', 'Albanian', 'Shqip'),
        array('am', 'amh', 'amh', 'amh', 'Amharic', 'አማርኛ'),
        array('ar', 'ara', 'ara', 'ara', 'Arabic', 'العربية'),
        array('an', 'arg', 'arg', 'arg', 'Aragonese', 'aragonés'),
        array('hy', 'hye', 'arm', 'hye', 'Armenian', 'Հայերեն'),
        array('as', 'asm', 'asm', 'asm', 'Assamese', 'অসমীয়া'),
        array('av', 'ava', 'ava', 'ava', 'Avaric', 'авар мацӀ, магӀарул мацӀ'),
        array('ae', 'ave', 'ave', 'ave', 'Avestan', 'avesta'),
        array('ay', 'aym', 'aym', 'aym', 'Aymara', 'aymar aru'),
        array('az', 'aze', 'aze', 'aze', 'Azerbaijani', 'azərbaycan dili'),
        array('bm', 'bam', 'bam', 'bam', 'Bambara', 'bamanankan'),
        array('ba', 'bak', 'bak', 'bak', 'Bashkir', 'башҡорт теле'),
        array('eu', 'eus', 'baq', 'eus', 'Basque', 'euskara, euskera'),
        array('be', 'bel', 'bel', 'bel', 'Belarusian', 'беларуская мова'),
        array('bn', 'ben', 'ben', 'ben', 'Bengali, Bangla', 'বাংলা'),
        array('bh', 'bih', 'bih', '', 'Bihari', 'भोजपुरी'),
        array('bi', 'bis', 'bis', 'bis', 'Bislama', 'Bislama'),
        array('bs', 'bos', 'bos', 'bos', 'Serbian', 'bosanski jezik'),          // Bosnian actually -> Serbian
        array('br', 'bre', 'bre', 'bre', 'Breton', 'brezhoneg'),
        array('bg', 'bul', 'bul', 'bul', 'Bulgarian', 'български език'),
        array('my', 'mya', 'bur', 'mya', 'Burmese', 'ဗမာစာ'),
        array('ca', 'cat', 'cat', 'cat', 'Catalan', 'català'),
        array('ch', 'cha', 'cha', 'cha', 'Chamorro', 'Chamoru'),
        array('ce', 'che', 'che', 'che', 'Chechen', 'нохчийн мотт'),
        array('ny', 'nya', 'nya', 'nya', 'Chichewa, Chewa, Nyanja', 'chiCheŵa, chinyanja'),
        array('zh', 'zho', 'chi', 'zho', 'Chinese', '中文 (Zhōngwén), 汉语, 漢語'),
        array('cv', 'chv', 'chv', 'chv', 'Chuvash', 'чӑваш чӗлхи'),
        array('kw', 'cor', 'cor', 'cor', 'Cornish', 'Kernewek'),
        array('co', 'cos', 'cos', 'cos', 'Corsican', 'corsu, lingua corsa'),
        array('cr', 'cre', 'cre', 'cre', 'Cree', 'ᓀᐦᐃᔭᐍᐏᐣ'),
        array('hr', 'hrv', 'hrv', 'hrv', 'Serbian', 'hrvatski jezik'),             //Croatian actually -> to Serbian
        array('cs', 'ces', 'cze', 'ces', 'Czech', 'čeština, český jazyk'),
        array('da', 'dan', 'dan', 'dan', 'Danish', 'dansk'),
        array('dv', 'div', 'div', 'div', 'Divehi, Dhivehi, Maldivian', 'ދިވެހި'),
        array('nl', 'nld', 'dut', 'nld', 'Dutch', 'Nederlands, Vlaams'),
        array('dz', 'dzo', 'dzo', 'dzo', 'Dzongkha', 'རྫོང་ཁ'),
        array('en', 'eng', 'eng', 'eng', 'English', 'English'),
        array('eo', 'epo', 'epo', 'epo', 'Esperanto', 'Esperanto'),
        array('et', 'est', 'est', 'est', 'Estonian', 'eesti, eesti keel'),
        array('ee', 'ewe', 'ewe', 'ewe', 'Ewe', 'Eʋegbe'),
        array('fo', 'fao', 'fao', 'fao', 'Faroese', 'føroyskt'),
        array('fj', 'fij', 'fij', 'fij', 'Fijian', 'vosa Vakaviti'),
        array('fi', 'fin', 'fin', 'fin', 'Finnish', 'suomi, suomen kieli'),
        array('fr', 'fra', 'fre', 'fra', 'French', 'français, langue française'),
        array('ff', 'ful', 'ful', 'ful', 'Fula, Fulah, Pulaar, Pular', 'Fulfulde, Pulaar, Pular'),
        array('gl', 'glg', 'glg', 'glg', 'Galician', 'galego'),
        array('ka', 'kat', 'geo', 'kat', 'Georgian', 'ქართული'),
        array('de', 'deu', 'ger', 'deu', 'German', 'Deutsch'),
        array('el', 'ell', 'gre', 'ell', 'Greek (modern)', 'ελληνικά'),
        array('gn', 'grn', 'grn', 'grn', 'Guaraní', 'Avañe\'ẽ'),
        array('gu', 'guj', 'guj', 'guj', 'Gujarati', 'ગુજરાતી'),
        array('ht', 'hat', 'hat', 'hat', 'Haitian, Haitian Creole', 'Kreyòl ayisyen'),
        array('ha', 'hau', 'hau', 'hau', 'Hausa', '(Hausa) هَوُسَ'),
        array('he', 'heb', 'heb', 'heb', 'Hebrew (modern)', 'עברית'),
        array('hz', 'her', 'her', 'her', 'Herero', 'Otjiherero'),
        array('hi', 'hin', 'hin', 'hin', 'Hindi', 'हिन्दी, हिंदी'),
        array('ho', 'hmo', 'hmo', 'hmo', 'Hiri Motu', 'Hiri Motu'),
        array('hu', 'hun', 'hun', 'hun', 'Hungarian', 'magyar'),
        array('ia', 'ina', 'ina', 'ina', 'Interlingua', 'Interlingua'),
        array('id', 'ind', 'ind', 'ind', 'Indonesian', 'Bahasa Indonesia'),
        array('ie', 'ile', 'ile', 'ile', 'Interlingue', 'Originally called Occidental; then Interlingue after WWII'),
        array('ga', 'gle', 'gle', 'gle', 'Irish', 'Gaeilge'),
        array('ig', 'ibo', 'ibo', 'ibo', 'Igbo', 'Asụsụ Igbo'),
        array('ik', 'ipk', 'ipk', 'ipk', 'Inupiaq', 'Iñupiaq, Iñupiatun'),
        array('io', 'ido', 'ido', 'ido', 'Ido', 'Ido'),
        array('is', 'isl', 'ice', 'isl', 'Icelandic', 'Íslenska'),
        array('it', 'ita', 'ita', 'ita', 'Italian', 'italiano'),
        array('iu', 'iku', 'iku', 'iku', 'Inuktitut', 'ᐃᓄᒃᑎᑐᑦ'),
        array('ja', 'jpn', 'jpn', 'jpn', 'Japanese', '日本語 (にほんご)'),
        array('jv', 'jav', 'jav', 'jav', 'Javanese', 'basa Jawa'),
        array('kl', 'kal', 'kal', 'kal', 'Kalaallisut, Greenlandic', 'kalaallisut, kalaallit oqaasii'),
        array('kn', 'kan', 'kan', 'kan', 'Kannada', 'ಕನ್ನಡ'),
        array('kr', 'kau', 'kau', 'kau', 'Kanuri', 'Kanuri'),
        array('ks', 'kas', 'kas', 'kas', 'Kashmiri', 'कश्मीरी, كشميري‎'),
        array('kk', 'kaz', 'kaz', 'kaz', 'Kazakh', 'қазақ тілі'),
        array('km', 'khm', 'khm', 'khm', 'Khmer', 'ខ្មែរ, ខេមរភាសា, ភាសាខ្មែរ'),
        array('ki', 'kik', 'kik', 'kik', 'Kikuyu, Gikuyu', 'Gĩkũyũ'),
        array('rw', 'kin', 'kin', 'kin', 'Kinyarwanda', 'Ikinyarwanda'),
        array('ky', 'kir', 'kir', 'kir', 'Kyrgyz', 'Кыргызча, Кыргыз тили'),
        array('kv', 'kom', 'kom', 'kom', 'Komi', 'коми кыв'),
        array('kg', 'kon', 'kon', 'kon', 'Kongo', 'Kikongo'),
        array('ko', 'kor', 'kor', 'kor', 'Korean', '한국어, 조선어'),
        array('ku', 'kur', 'kur', 'kur', 'Kurdish', 'Kurdî, كوردی‎'),
        array('kj', 'kua', 'kua', 'kua', 'Kwanyama, Kuanyama', 'Kuanyama'),
        array('la', 'lat', 'lat', 'lat', 'Latin', 'latine, lingua latina'),
        array('', '', '', 'lld', 'Ladin', 'ladin, lingua ladina'),
        array('lb', 'ltz', 'ltz', 'ltz', 'Luxembourgish, Letzeburgesch', 'Lëtzebuergesch'),
        array('lg', 'lug', 'lug', 'lug', 'Ganda', 'Luganda'),
        array('li', 'lim', 'lim', 'lim', 'Limburgish, Limburgan, Limburger', 'Limburgs'),
        array('ln', 'lin', 'lin', 'lin', 'Lingala', 'Lingála'),
        array('lo', 'lao', 'lao', 'lao', 'Lao', 'ພາສາລາວ'),
        array('lt', 'lit', 'lit', 'lit', 'Lithuanian', 'lietuvių kalba'),
        array('lu', 'lub', 'lub', 'lub', 'Luba-Katanga', 'Tshiluba'),
        array('lv', 'lav', 'lav', 'lav', 'Latvian', 'latviešu valoda'),
        array('gv', 'glv', 'glv', 'glv', 'Manx', 'Gaelg, Gailck'),
        array('mk', 'mkd', 'mac', 'mkd', 'Macedonian', 'македонски јазик'),
        array('mg', 'mlg', 'mlg', 'mlg', 'Malagasy', 'fiteny malagasy'),
        array('ms', 'msa', 'may', 'msa', 'Malay', 'bahasa Melayu, بهاس ملايو‎'),
        array('ml', 'mal', 'mal', 'mal', 'Malayalam', 'മലയാളം'),
        array('mt', 'mlt', 'mlt', 'mlt', 'Maltese', 'Malti'),
        array('mi', 'mri', 'mao', 'mri', 'Māori', 'te reo Māori'),
        array('mr', 'mar', 'mar', 'mar', 'Marathi (Marāṭhī)', 'मराठी'),
        array('mh', 'mah', 'mah', 'mah', 'Marshallese', 'Kajin M̧ajeļ'),
        array('mn', 'mon', 'mon', 'mon', 'Mongolian', 'монгол'),
        array('na', 'nau', 'nau', 'nau', 'Nauru', 'Ekakairũ Naoero'),
        array('nv', 'nav', 'nav', 'nav', 'Navajo, Navaho', 'Diné bizaad'),
        array('nd', 'nde', 'nde', 'nde', 'Northern Ndebele', 'isiNdebele'),
        array('ne', 'nep', 'nep', 'nep', 'Nepali', 'नेपाली'),
        array('ng', 'ndo', 'ndo', 'ndo', 'Ndonga', 'Owambo'),
        array('nb', 'nob', 'nob', 'nob', 'Norwegian Bokmål', 'Norsk bokmål'),
        array('nn', 'nno', 'nno', 'nno', 'Norwegian Nynorsk', 'Norsk nynorsk'),
        array('no', 'nor', 'nor', 'nor', 'Norwegian', 'Norsk'),
        array('ii', 'iii', 'iii', 'iii', 'Nuosu', 'ꆈꌠ꒿ Nuosuhxop'),
        array('nr', 'nbl', 'nbl', 'nbl', 'Southern Ndebele', 'isiNdebele'),
        array('oc', 'oci', 'oci', 'oci', 'Occitan', 'occitan, lenga d\'òc'),
        array('oj', 'oji', 'oji', 'oji', 'Ojibwe, Ojibwa', 'ᐊᓂᔑᓈᐯᒧᐎᓐ'),
        array('cu', 'chu', 'chu', 'chu', 'Old Church Slavonic, Church Slavonic, Old Bulgarian', 'ѩзыкъ словѣньскъ'),
        array('om', 'orm', 'orm', 'orm', 'Oromo', 'Afaan Oromoo'),
        array('or', 'ori', 'ori', 'ori', 'Oriya', 'ଓଡ଼ିଆ'),
        array('os', 'oss', 'oss', 'oss', 'Ossetian, Ossetic', 'ирон æвзаг'),
        array('pa', 'pan', 'pan', 'pan', 'Panjabi, Punjabi', 'ਪੰਜਾਬੀ, پنجابی‎'),
        array('pi', 'pli', 'pli', 'pli', 'Pāli', 'पाऴि'),
        array('fa', 'fas', 'per', 'fas', 'Persian (Farsi)', 'فارسی'),
        array('pl', 'pol', 'pol', 'pol', 'Polish', 'język polski, polszczyzna'),
        array('ps', 'pus', 'pus', 'pus', 'Pashto, Pushto', 'پښتو'),
        array('pt', 'por', 'por', 'por', 'Portuguese', 'português'),
        array('qu', 'que', 'que', 'que', 'Quechua', 'Runa Simi, Kichwa'),
        array('rm', 'roh', 'roh', 'roh', 'Romansh', 'rumantsch grischun'),
        array('rn', 'run', 'run', 'run', 'Kirundi', 'Ikirundi'),
        array('ro', 'ron', 'rum', 'ron', 'Romanian', 'limba română'),
        array('ru', 'rus', 'rus', 'rus', 'Russian', 'Русский'),
        array('sa', 'san', 'san', 'san', 'Sanskrit (Saṁskṛta)', 'संस्कृतम्'),
        array('sc', 'srd', 'srd', 'srd', 'Sardinian', 'sardu'),
        array('sd', 'snd', 'snd', 'snd', 'Sindhi', 'सिन्धी, سنڌي، سندھی‎'),
        array('se', 'sme', 'sme', 'sme', 'Northern Sami', 'Davvisámegiella'),
        array('sm', 'smo', 'smo', 'smo', 'Samoan', 'gagana fa\'a Samoa'),
        array('sg', 'sag', 'sag', 'sag', 'Sango', 'yângâ tî sängö'),
        array('sr', 'srp', 'srp', 'srp', 'Serbian', 'српски језик'),
        array('gd', 'gla', 'gla', 'gla', 'Scottish Gaelic, Gaelic', 'Gàidhlig'),
        array('sn', 'sna', 'sna', 'sna', 'Shona', 'chiShona'),
        array('si', 'sin', 'sin', 'sin', 'Sinhala, Sinhalese', 'සිංහල'),
        array('sk', 'slk', 'slo', 'slk', 'Slovak', 'slovenčina, slovenský jazyk'),
        array('sl', 'slv', 'slv', 'slv', 'Slovene', 'slovenski jezik, slovenščina'),
        array('so', 'som', 'som', 'som', 'Somali', 'Soomaaliga, af Soomaali'),
        array('st', 'sot', 'sot', 'sot', 'Southern Sotho', 'Sesotho'),
        array('es', 'spa', 'spa', 'spa', 'Spanish', 'español'),
        array('su', 'sun', 'sun', 'sun', 'Sundanese', 'Basa Sunda'),
        array('sw', 'swa', 'swa', 'swa', 'Swahili', 'Kiswahili'),
        array('ss', 'ssw', 'ssw', 'ssw', 'Swati', 'SiSwati'),
        array('sv', 'swe', 'swe', 'swe', 'Swedish', 'svenska'),
        array('ta', 'tam', 'tam', 'tam', 'Tamil', 'தமிழ்'),
        array('te', 'tel', 'tel', 'tel', 'Telugu', 'తెలుగు'),
        array('tg', 'tgk', 'tgk', 'tgk', 'Tajik', 'тоҷикӣ, toçikī, تاجیکی‎'),
        array('th', 'tha', 'tha', 'tha', 'Thai', 'ไทย'),
        array('ti', 'tir', 'tir', 'tir', 'Tigrinya', 'ትግርኛ'),
        array('bo', 'bod', 'tib', 'bod', 'Tibetan Standard, Tibetan, Central', 'བོད་ཡིག'),
        array('tk', 'tuk', 'tuk', 'tuk', 'Turkmen', 'Türkmen, Түркмен'),
        array('tl', 'tgl', 'tgl', 'tgl', 'Tagalog', 'Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔'),
        array('tn', 'tsn', 'tsn', 'tsn', 'Tswana', 'Setswana'),
        array('to', 'ton', 'ton', 'ton', 'Tonga (Tonga Islands)', 'faka Tonga'),
        array('tr', 'tur', 'tur', 'tur', 'Turkish', 'Türkçe'),
        array('ts', 'tso', 'tso', 'tso', 'Tsonga', 'Xitsonga'),
        array('tt', 'tat', 'tat', 'tat', 'Tatar', 'татар теле, tatar tele'),
        array('tw', 'twi', 'twi', 'twi', 'Twi', 'Twi'),
        array('ty', 'tah', 'tah', 'tah', 'Tahitian', 'Reo Tahiti'),
        array('ug', 'uig', 'uig', 'uig', 'Uyghur', 'ئۇيغۇرچە‎, Uyghurche'),
        array('uk', 'ukr', 'ukr', 'ukr', 'Ukrainian', 'українська мова'),
        array('ur', 'urd', 'urd', 'urd', 'Urdu', 'اردو'),
        array('uz', 'uzb', 'uzb', 'uzb', 'Uzbek', 'Oʻzbek, Ўзбек, أۇزبېك‎'),
        array('ve', 'ven', 'ven', 'ven', 'Venda', 'Tshivenḓa'),
        array('vi', 'vie', 'vie', 'vie', 'Vietnamese', 'Việt Nam'),
        array('vo', 'vol', 'vol', 'vol', 'Volapük', 'Volapük'),
        array('wa', 'wln', 'wln', 'wln', 'Walloon', 'walon'),
        array('cy', 'cym', 'wel', 'cym', 'Welsh', 'Cymraeg'),
        array('wo', 'wol', 'wol', 'wol', 'Wolof', 'Wollof'),
        array('fy', 'fry', 'fry', 'fry', 'Western Frisian', 'Frysk'),
        array('xh', 'xho', 'xho', 'xho', 'Xhosa', 'isiXhosa'),
        array('yi', 'yid', 'yid', 'yid', 'Yiddish', 'ייִדיש'),
        array('yo', 'yor', 'yor', 'yor', 'Yoruba', 'Yorùbá'),
        array('za', 'zha', 'zha', 'zha', 'Zhuang, Chuang', 'Saɯ cueŋƅ, Saw cuengh'),
        array('zu', 'zul', 'zul', 'zul', 'Zulu', 'isiZulu')
    );

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

    /**
     * LANGUAGES
     */
    /*
     * Get language name from ISO-639-1 (two-letters code)
     *
     * @return (string)
     */
    public static function languageByCode1($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[0] == $code) {
                $result = $lang[4];
                break;
            }
        }

        return $result;
    }

    /*
     * Get native language name from ISO-639-1 (two-letters code)
     *
     * @return (string)
     */
    public static function nativeByCode1($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[0] == $code) {
                $result = $lang[5];
                break;
            }
        }

        return $result;
    }

    /*
     * Get language name from ISO-639-2/t (three-letter codes) terminologic
     *
     * @return (string)
     */
    public static function languageByCode2t($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[1] == $code) {
                $result = $lang[4];
                break;
            }
        }

        return $result;
    }

    /*
     * Get native language name from ISO-639-2/t (three-letter codes) terminologic
     *
     * @return (string)
     */
    public static function nativeByCode2t($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[1] == $code) {
                $result = $lang[5];
                break;
            }
        }

        return $result;
    }

    /*
     * Get language name from ISO-639-2/b (three-letter codes) bibliographic
     *
     * @return (string)
     */
    public static function languageByCode2b($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[2] == $code) {
                $result = $lang[4];
                break;
            }
        }

        return $result;
    }

    /*
     * Get native language name from ISO-639-2/b (three-letter codes) bibliographic
     *
     * @return (string)
     */
    public static function nativeByCode2b($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[2] == $code) {
                $result = $lang[5];
                break;
            }
        }

        return $result;
    }

    /*
     * Get language name from ISO-639-3 (three-letter codes)
     *
     * @return (string)
     */
    public static function languageByCode3($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[3] == $code) {
                $result = $lang[4];
                break;
            }
        }

        return $result;
    }

    /*
     * Get native language name from ISO-639-3 (three-letter codes)
     *
     * @return (string)
     */
    public static function nativeByCode3($code)
    {
        $code = strtolower($code);

        $result = '';

        foreach (self::$languages as $lang) {
            if ($lang[3] == $code) {
                $result = $lang[5];
                break;
            }
        }

        return $result;
    }
}