DROP TABLE IF EXISTS users;
-- Table user don't need change used to registration/login/fk 
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS ressources;
-- Table ressources LONGTEXT is use to keep a string for calcul in the back
CREATE TABLE ressources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    power_per_second LONGTEXT NOT NULL,
    total_power LONGTEXT NOT NULL,
    win LONGTEXT NOT NULL,
    last_update INT NOT NULL,

    CONSTRAINT fk_ressource_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS preset_zones;
-- Table preset zones this table can be use to add a new zone 
CREATE TABLE preset_zones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    zone_id INT NOT NULL,
    `name` varchar(50) NOT NULL,
    images varchar(50) NOT NULL,
    power_required LONGTEXT NOT NULL,
    win_required LONGTEXT NOT NULL,
    boss_name VARCHAR(100) NOT NULL,
    last_boss_zone INT NOT NULL,
    boss_zone_kill INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `preset_zones` (`id`, `zone_id`, `name`, `images`, `power_required`, `win_required`, `boss_name`, `last_boss_zone`, `boss_zone_kill`) VALUES
(1, 1, 'Zone 1', 'public/images/zone/zone1.png', 0, 0, '[DIVIN] Slime', 0, 0),
(2, 2, 'Zone 2', 'public/images/zone/zone2.png', 409600, 20480, '[DIVIN] Slime', 1, 10),
(3, 3, 'Zone 3', 'public/images/zone/zone3.png', 13421772800, 671088640, '[DIVIN] Skeleton', 2, 25),
(4, 4, 'Zone 4', 'public/images/zone/zone4.png', 439804651110400, 21990232555520, '[DIVIN] Goblin', 3, 50),
(5, 5, 'Zone 5', 'public/images/zone/zone5.png', 14411518807585587200, 720575940379279360, '[DIVIN] Wolf', 4, 100),
(6, 6, 'Zone 6', 'public/images/zone/zone6.png', 472236648286964521497600, 23611832414348226074880, '[DIVIN] Spider', 5, 150),
(7, 7, 'Zone 7', 'public/images/zone/zone7.png', 15474250491067253437873356800, 773712524553362671893667840, '[DIVIN] Golem', 6, 200),
(8, 8, 'Zone 8', 'public/images/zone/zone8.png', 16615349947280650183491857939434803200, 830767497364032509174592896971740160, '[DIVIN] Dragon', 7, 300);

DROP TABLE IF EXISTS preset_boss;
-- Table preset boss this can be use to add a new boss 
CREATE TABLE preset_boss (
    id INT AUTO_INCREMENT PRIMARY KEY,
    boss_id INT NOT NULL,
    boss_zone INT NOT NULL,
    boss_name  VARCHAR(100) NOT NULL UNIQUE,
    boss_hp LONGTEXT NOT NULL,
    boss_win LONGTEXT NOT NULL,
    recommended_power LONGTEXT NOT NULL,
    images VARCHAR(100) NOT NULL,

    CONSTRAINT fk_preset_boss_zone_id
    FOREIGN KEY (boss_zone)
    REFERENCES preset_zones(id)
    ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- WARNING!!! only 8 zone available ||||||||| any data from the insert can be changed to adapt your gameplay
INSERT INTO `preset_boss` (`id`, `boss_id`, `boss_zone`, `boss_name`, `boss_hp`, `boss_win`, `recommended_power`, `images`) VALUES
-- ZONE 1 (Slime)
(1, 1, 1, 'Slime', '100', '5', '20', 'public/images/boss/zone1/slime.png'),
(2, 2, 1, 'Giant Slime', '800', '40', '160', 'public/images/boss/zone1/giant_slime.png'),
(3, 3, 1, 'King Slime', '6400', '320', '1280', 'public/images/boss/zone1/king_slime.png'),
(4, 4, 1, 'Titan Slime', '51200', '2560', '10240', 'public/images/boss/zone1/titan_slime.png'),
(5, 5, 1, '[DIVIN] Slime', '409600', '20480', '81920', 'public/images/boss/zone1/divin_slime.png'),

-- ZONE 2 (Skeleton) – scaling ×8 à partir du DIVIN précédent
(6, 6, 2, 'Skeleton', '3276800', '163840', '655360', 'public/images/boss/zone2/skeleton.png'),
(7, 7, 2, 'Giant Skeleton', '26214400', '1310720', '5242880', 'public/images/boss/zone2/giant_skeleton.png'),
(8, 8, 2, 'King Skeleton', '209715200', '10485760', '41943040', 'public/images/boss/zone2/king_skeleton.png'),
(9, 9, 2, 'Titan Skeleton', '1677721600', '83886080', '335544320', 'public/images/boss/zone2/titan_skeleton.png'),
(10, 10, 2, '[DIVIN] Skeleton', '13421772800', '671088640', '2684354560', 'public/images/boss/zone2/divin_skeleton.png'),

-- ZONE 3 (Goblin)
(11, 11, 3, 'Goblin', '107374182400', '5368709120', '21474836480', 'public/images/boss/zone3/goblin.png'),
(12, 12, 3, 'Giant Goblin', '858993459200', '42949672960', '171798691840', 'public/images/boss/zone3/giant_goblin.png'),
(13, 13, 3, 'King Goblin', '6871947673600', '343597383680', '1374389534720', 'public/images/boss/zone3/king_goblin.png'),
(14, 14, 3, 'Titan Goblin', '54975581388800', '2748779069440', '10995116277760', 'public/images/boss/zone3/titan_goblin.png'),
(15, 15, 3, '[DIVIN] Goblin', '439804651110400', '21990232555520', '87960930222080', 'public/images/boss/zone3/divin_goblin.png'),

-- ZONE 4 (Wolf)
(16, 16, 4, 'Wolf', '3518437208883200', '175921860444160', '703687441776640', 'public/images/boss/zone4/wolf.png'),
(17, 17, 4, 'Giant Wolf', '28147497671065600', '1407374883553280', '5629499534213120', 'public/images/boss/zone4/giant_wolf.png'),
(18, 18, 4, 'Alpha Wolf', '225179981368524800', '11258999068426240', '45035996273704960', 'public/images/boss/zone4/king_wolf.png'),
(19, 19, 4, 'Titan Wolf', '1801439850948198400', '90071992547409920', '360287970189639680', 'public/images/boss/zone4/titan_wolf.png'),
(20, 20, 4, '[DIVIN] Wolf', '14411518807585587200', '720575940379279360', '2882303761517117440', 'public/images/boss/zone4/divin_wolf.png'),

-- ZONE 5 (Spider)
(21, 21, 5, 'Spider', '115292150460684697600', '5764607523034234880', '23058430092136939520', 'public/images/boss/zone5/spider.png'),
(22, 22, 5, 'Giant Spider', '922337203685477580800', '46116860184273879040', '184467440737095516160', 'public/images/boss/zone5/giant_spider.png'),
(23, 23, 5, 'Queen Spider', '7378697629483820646400', '368934881474191032320', '1475739525896764129280', 'public/images/boss/zone5/king_spider.png'),
(24, 24, 5, 'Titan Spider', '59029581035870565171200', '2951479051793528258560', '11805916207174113034240', 'public/images/boss/zone5/titan_spider.png'),
(25, 25, 5, '[DIVIN] Spider', '472236648286964521497600', '23611832414348226074880', '94447329657392904299520', 'public/images/boss/zone5/divin_spider.png'),

-- ZONE 6 (Golem)
(26, 26, 6, 'Golem', '3777893186295716171980800', '188894659314785808599040', '755578637259143234792160', 'public/images/boss/zone6/golem.png'),
(27, 27, 6, 'Giant Golem', '30223145490365729375846400', '1511157274518286468792320', '6044629098073145870338560', 'public/images/boss/zone6/giant_golem.png'),
(28, 28, 6, 'Ancient Golem', '241785163922925834966771200', '12089258196146291748338560', '48357032784585166993354240', 'public/images/boss/zone6/king_golem.png'),
(29, 29, 6, 'Titan Golem', '1934281311383406679734169600', '96714065569170333986708480', '386856262276681335946833920', 'public/images/boss/zone6/titan_golem.png'),
(30, 30, 6, '[DIVIN] Golem', '15474250491067253437873356800', '773712524553362671893667840', '3094850098213450687574671360', 'public/images/boss/zone6/divin_golem.png'),

-- ZONE 7 (Minotaur)
(31, 31, 7, 'Minotaur', '123794003928538054998986854400', '6189700196426902749949342720', '24758800785653810999794685440', 'public/images/boss/zone7/minotaur.png'),
(32, 32, 7, 'Giant Minotaur', '990352030428304439991894835200', '49517601521415221999594741760', '198070406085660887998378967040', 'public/images/boss/zone7/giant_minotaur.png'),
(33, 33, 7, 'King Minotaur', '7922816243426435519935158681600', '396140812171321775996757934080', '1584563248685287107987031736320', 'public/images/boss/zone7/king_minotaur.png'),
(34, 34, 7, 'Titan Minotaur', '63382530047411484159481269452800', '3169126502370574207974063472640', '12676506009482296863896253890560', 'public/images/boss/zone7/titan_minotaur.png'),
(35, 35, 7, '[DIVIN] Minotaur', '507060240379291873275850155622400', '25353012018964593663792507781120', '101412096075858374655170031124480', 'public/images/boss/zone7/divin_minotaur.png'),

-- ZONE 8 (Dragon)
(36, 36, 8, 'Dragon', '4056481923035314986206801244979200', '202824096151765749310340062248960', '811296384607063997241360249995840', 'public/images/boss/zone8/dragon.png'),
(37, 37, 8, 'Ancient Dragon', '32451855384282519889654409959833600', '1622592769214125994482720497991680', '12980742188493007955861763967933440', 'public/images/boss/zone8/giant_dragon.png'),
(38, 38, 8, 'Elder Dragon', '259614842926260159117235279678668800', '12980742146313007955861763983933440', '103845937170504063646894223743467520', 'public/images/boss/zone8/king_dragon.png'),
(39, 39, 8, 'Titan Dragon', '2076918743410081272937882237429350400', '103845937170504063646894111871467520', '830767497364032509175152894971740160', 'public/images/boss/zone8/titan_dragon.png'),
(40, 40, 8, '[DIVIN] Dragon', '16615349947280650183491857939434803200', '830767497364032509174592896971740160', '6646139978912260073396743175773922560', 'public/images/boss/zone8/divin_dragon.png');

DROP TABLE IF EXISTS preset_sword;
-- Table preset sword can be use to add new more sword 
CREATE TABLE preset_sword (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sword_name VARCHAR(50) NOT NULL,
    sword_power LONGTEXT NOT NULL,
    sword_power_required LONGTEXT NOT NULL,
    images VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `preset_sword` (`id`, `sword_name`, `sword_power`, `sword_power_required`, `images`) VALUES
(1, 'Épée en bois', '1', '0', 'public/images/sword/wood_sword.png'),
(2, 'Épée en bronze', '4', '120', 'public/images/sword/bronze_sword.png'),
(3, 'Épée en fer', '16', '1440', 'public/images/sword/iron_sword.png'),
(4, 'Épée en acier', '64', '17280', 'public/images/sword/steel_sword.png'),
(5, 'Épée en diamant', '256', '207360', 'public/images/sword/diamond_sword.png'),
(6, 'Épée mythique', '1024', '2488320', 'public/images/sword/mythic_sword.png'),
(7, 'Épée légendaire', '4096', '29859840', 'public/images/sword/legendary_sword.png'),
(8, 'Épée divine', '16384', '358318080', 'public/images/sword/divine_sword.png'),
(9, 'Épée céleste', '65536', '4299816960', 'public/images/sword/celestial_sword.png'),
(10, 'Épée astrale', '262144', '51597803520', 'public/images/sword/astral_sword.png'),
(11, 'Épée du chaos', '1048576', '619173642240', 'public/images/sword/chaos_sword.png'),
(12, "Épée de l'apocalypse", '4194304', '7430083706880', 'public/images/sword/apocalypse_sword.png'),
(13, 'Épée infinie', '16777216', '89161004482560', 'public/images/sword/infinite_sword.png'),
(14, 'Épée du temps', '67108864', '1069932053790720', 'public/images/sword/time_sword.png'),
(15, 'Épée éternelle', '268435456', '12839184645488640', 'public/images/sword/eternal_sword.png'),
(16, 'Épée suprême', '1073741824', '154070215745863680', 'public/images/sword/supreme_sword.png'),
(17, 'Épée divine ultime', '4294967296', '1848842588950356160', 'public/images/sword/divine_ultimate_sword.png'),
(18, 'Épée du créateur', '17179869184', '22186111067404233920', 'public/images/sword/creator_sword.png'),
(19, 'Épée légendaire absolue', '68719476736', '266233332808850806400', 'public/images/sword/legendary_absolute_sword.png'),
(20, 'Épée du roi éternel', '274877906944', '3194799993706210036800', 'public/images/sword/king_eternal_sword.png'),
(21, 'Épée cosmique', '1099511627776', '38337599924474520441600', 'public/images/sword/cosmic_sword.png'),
(22, 'Épée des ténèbres', '4398046511104', '460050998993694245299200', 'public/images/sword/darkness_sword.png'),
(23, "Épée de l'infini", '17592186044416', '5520611987924329943584000', 'public/images/sword/infinity_sword.png'),
(24, "Épée de l'éternité", '70368744177664', '66247343855091959223008000', 'public/images/sword/eternity_sword.png'),
(25, 'Épée céleste absolue', '281474976710656', '794968126261103510676096000', 'public/images/sword/celestial_absolute_sword.png'),
(26, 'Épée du crépuscule', '1125899906842624', '9539617515133242128113152000', 'public/images/sword/twilight_sword.png'),
(27, 'Épée légendaire du temps', '4503599627370496', '114475410181598905537357824000', 'public/images/sword/legendary_time_sword.png'),
(28, 'Épée du destin', '18014398509481984', '1373704922183186866448293888000', 'public/images/sword/destiny_sword.png'),
(29, 'Épée ultime', '72057594037927936', '16484459066198242397379526656000', 'public/images/sword/ultimate_sword.png'),
(30, 'Épée du créateur suprême', '288230376151711744', '197813508794378908768554319872000', 'public/images/sword/supreme_creator_sword.png'),
(31, 'Épée divine suprême', '1152921504606846976', '2373762105532546904222451838464000', 'public/images/sword/divine_supreme_sword.png'),
(32, 'Épée du roi des rois', '4611686018427387904', '28485145266390562850669422061568000', 'public/images/sword/king_of_kings_sword.png'),
(33, 'Épée éternelle absolue', '18446744073709551616', '341821743196686754208032064738816000', 'public/images/sword/eternal_absolute_sword.png'),
(34, 'Épée cosmique suprême', '73786976294838206464', '4101860918352421048496384776865792000', 'public/images/sword/cosmic_supreme_sword.png'),
(35, 'Épée des étoiles', '295147905179352825856', '49222331020229052581956617322389504000', 'public/images/sword/stars_sword.png'),
(36, 'Épée du néant', '1180591620717411303424', '590667972242748631983479407868673228800', 'public/images/sword/void_sword.png'),
(37, 'Épée de la création', '4722366482869645213696', '7088015666912983583801752894424078745600', 'public/images/sword/creation_sword.png'),
(38, 'Épée absolue', '18889465931478580854784', '85056188002955803005621034733088944947200', 'public/images/sword/absolute_sword.png'),
(39, "Épée de l'infini absolu", '75557863725914323419136', '1020674256035469636067452416797067335680000', 'public/images/sword/infinity_absolute_sword.png'),
(40, 'Épée du roi éternel absolu', '302231454903657293676544', '12248091072425635632723528971564808028160000', 'public/images/sword/king_eternal_absolute_sword.png');

DROP TABLE IF EXISTS player_zone;
-- Table player zone is a actual zone where is the player default : 1 it's used to the count time fighting boss
CREATE TABLE player_zone (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    zone_id INT NOT NULL,
    start_boss_time INT NOT NULL,

    CONSTRAINT fk_player_zone
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_player_zone_id
    FOREIGN KEY (zone_id)
    REFERENCES preset_zones(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS requirement_zone;
-- Table requirement zone use to know if zone is unlock with a correct requirement
CREATE TABLE requirement_zone (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    zone_id INT NOT NULL,
    boss_id INT NULL,
    boss_kill INT NOT NULL,
    is_unlocked INT NOT NULL,

    CONSTRAINT fk_user_id_zone
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_requirement_zone
    FOREIGN KEY (zone_id)
    REFERENCES preset_zones(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_boss_zone
    FOREIGN KEY (boss_id)
    REFERENCES preset_boss(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS player_sword;
-- Table player sword use to know wich sword player use
CREATE TABLE player_sword (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sword_id INT NOT NULL,

    CONSTRAINT fk_player_id
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_sword_id
    FOREIGN KEY (sword_id)
    REFERENCES preset_sword(id)
    ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DELIMITER $$
-- TRIGGER after user register 
CREATE TRIGGER after_user_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN

INSERT INTO ressources (
        user_id,
        power_per_second,
        total_power,
        win,
        last_update
    )
    VALUES (
        NEW.id,
        1,
        0,
        0,
        UNIX_TIMESTAMP()
    );

INSERT INTO requirement_zone (user_id, zone_id, boss_id, boss_kill, is_unlocked)
SELECT NEW.id, pz.id, NULLIF(pz.last_boss_zone, 0), 0, 0
FROM preset_zones pz;

INSERT INTO player_zone (
        user_id,
        zone_id,
        start_boss_time
    )
    VALUES (
        NEW.id,
        1,
        0
    );

INSERT INTO player_sword (
        user_id,
        sword_id
        )
        VALUES (
            NEW.id,
            1
        );
END$$

DELIMITER ;