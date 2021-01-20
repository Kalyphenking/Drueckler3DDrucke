
USE Drueckler3DDrucke;

-- -----------------------------------------------------
-- Data for table `Address`.`student`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Address` (`id`, `createdAt`, `updatedAt`, `street`, `number`, `postalCode`, `city`, `country`) VALUES 
(NULL, current_timestamp(), NULL, 'Hans Loch Straße', '2', '99099', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Magdeburger Alle', '7', '99086', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Buddestraße', '18', '99099', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Altonaher Straße', '25', '99085', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Schillerstraße', '31a', '99096', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Eobanstraße', '9', '99084', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Neuwerkstraße', '45-46', '99084', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Mirfältkeinnameein Straße', '9e', '99099', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Domstraße', '3', '99084', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Käthe-Kollwitz-Straße', '11', '99096', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Am Stadpark', '8', '99096', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Gerarer Str.', '11', '99099', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Wilhelm-Leibl-Straße Straße', '10', '99096', 'Erfurt', 'Deutschland');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ContactData`.`login`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `ContactData` (`id`, `createdAt`, `updatedAt`, `addressID`, `firstName`, `lastName`, `phoneNumber`, `emailAddress`, `username`, `password`) VALUES 
(NULL, current_timestamp(), NULL, '1', 'Peter', 'Hase', '03615557738', 'peterhase@lol.com', 'ich', 'passwort'),
(NULL, current_timestamp(), NULL, '2', 'Rainer', 'Zufall', NULL, 'rainerzufall@gmail.com', 'habe', 'passwort'),
(NULL, current_timestamp(), NULL, '3', 'Tom', 'Hanks', '18949948198', 'tomtom@web.com', 'keine', 'password'),
(NULL, current_timestamp(), NULL, '5', 'Ronald', 'McDonald', '8948468949', 'notburgerking@t-online.de', 'ideen', 'passwort'),
(NULL, current_timestamp(), NULL, '7', 'Hans', 'Zimmer', NULL, 'räumdeinzimmerauf@keyweb.de', 'mehr', 'passwoerter'),
(NULL, current_timestamp(), NULL, '9', 'Kevina', 'Lleinzuhaus', '84984118991', 'kevinsmom@de.com', 'für', '19841169'),
(NULL, current_timestamp(), NULL, '10', 'Oliver Mathias', 'Jensen', '228884984/9', 'joollinololli@lol.eu', 'test', 'passwort'),
(NULL, current_timestamp(), NULL, '11', 'Ronalda', 'Schmidt', '419890070', 'schmidtschmitt@gmail.com', 'einträge', 'passwort'),
(NULL, current_timestamp(), NULL, '12', 'Petra', 'Krause', NULL, 'halskrause@lol.com', 'butterkuchen', 'passwort'),
(NULL, current_timestamp(), NULL, '13', 'Ariell', 'Diemeerjungfra', '48915484815156', 'Diemeerjungfra@gmail.com', 'liebe', 'passwort'),

(NULL, current_timestamp(), NULL, NULL, 'Hans', 'Müller', NULL, 'haensel@web.de', 'hans123', '6658994'),
(NULL, current_timestamp(), NULL, '6', 'Max', 'Mausoleum', '036151379521557738', 'max@lol.com', 'grüße', '8191964'),
(NULL, current_timestamp(), NULL, NULL, 'Annette', 'Schmitt', NULL, 'annette@print.com', 'der', '19849489'),
(NULL, current_timestamp(), NULL, NULL, 'Potz', 'Blitz', '0049365485445', 'potzblitz@print.com', 'backend', '9849849649'),
(NULL, current_timestamp(), NULL, '8', 'Andrew Lloyd', 'Webber', '313164975', 'starlightexpress@print.com', 'developer', '123455');

COMMIT;


-- -----------------------------------------------------
-- Data for table `CreditCard`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `CreditCard` (`id`, `createdAt`, `updatedAt`, `number`, `type`, `owner`, `expiryDate`, `securityCode`) VALUES 
(NULL, current_timestamp(), NULL, '123443215678', 'MasterCard', 'Peters Frau', '2022-04-06', '349'),
(NULL, current_timestamp(), NULL, '478498494949', 'VisaCard', 'Hans Zimmer', '2023-07-04', '545'),
(NULL, current_timestamp(), NULL, '516894166496', 'FakeCard', 'Ronalda Schmidt', '2020-02-08', '992'),
(NULL, current_timestamp(), NULL, '118484849899', 'MasterCard', 'Olaf Krause', '2021-09-09', '911'),
(NULL, current_timestamp(), NULL, '225814899299', 'MasterCard', 'Tom Hanks', '2025-01-12', '964');

COMMIT;

-- -----------------------------------------------------
-- Data for table `PaymentData`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `PaymentData` (`id`, `createdAt`, `updatedAt`, `iban`, `bill`, `CreditCard_id`) VALUES 
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, NULL, b'0', '1'), 
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, NULL, b'1', NULL),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, NULL, b'0', '2'),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, NULL, b'1', NULL),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, 'DE1234567891', b'0', NULL),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, 'DE8981984981', b'0', NULL),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, NULL, b'0', '3'),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, NULL, b'0', '4'),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, 'DE8949344881', b'0', NULL),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL), (NULL, current_timestamp(), NULL, NULL, b'0', '5');

COMMIT;

-- -----------------------------------------------------
-- Data for table `Customer`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Customer` (`id`, `createdAt`, `updatedAt`, `paymentID`, `guest`, `ContactData_id`) VALUES 
(NULL, current_timestamp(), NULL, '1', b'0', '1'),
(NULL, current_timestamp(), NULL, '2', b'0', '2'),
(NULL, current_timestamp(), NULL, '10', b'0', '3'),
(NULL, current_timestamp(), NULL, '4', b'0', '4'),
(NULL, current_timestamp(), NULL, '3', b'0', '5'),
(NULL, current_timestamp(), NULL, '5', b'0', '6'),
(NULL, current_timestamp(), NULL, '6', b'0', '7'),
(NULL, current_timestamp(), NULL, '7', b'0', '8'),
(NULL, current_timestamp(), NULL, '8', b'0', '9'),
(NULL, current_timestamp(), NULL, '9', b'0', '10');

COMMIT;

-- -----------------------------------------------------
-- Data for table `Employee`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Employee` (`id`, `createdAt`, `updatedAt`, `admin`, `ContactData_id`) VALUES 
(NULL, current_timestamp(), NULL, b'1', '11'),
(NULL, current_timestamp(), NULL, b'0', '12'),
(NULL, current_timestamp(), NULL, b'0', '13'),
(NULL, current_timestamp(), NULL, b'1', '14'),
(NULL, current_timestamp(), NULL, b'0', '15');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Filaments`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Filaments` (`id`, `createdAt`, `updatedAt`, `color`, `type`, `producer`, `pricePerGramm`) VALUES
(NULL, '2021-01-11 13:09:54', NULL, 'sunlu_pla_plus_red.txt', 'red', 'PLA', 'Sunlu', '0,028'),
(NULL, '2021-01-11 13:10:41', NULL, 'sunlu_pla_plus_green.txt', 'green', 'PLA', 'Sunlu', '0,028'),
(NULL, '2021-01-11 13:10:41', NULL, 'sunlu_pla_plus_blue.txt', 'blue', 'PLA', 'Sunlu', '0,028'),
(NULL, '2021-01-11 13:12:47', NULL, 'sunlu_abs_plus_white.txt', 'white', 'ABS', 'Sunlu', '0,033'),
(NULL, '2021-01-11 13:12:47', NULL, 'sunlu_pla_plus_orange.txt', 'orange', 'PLA', 'Sunlu', '0,028'),
(NULL, '2021-01-11 13:12:47', NULL, 'sunlu_abs_plus_black.txt', 'black', 'ABS', 'Sunlu', '0,033');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Orders`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Orders` (`id`, `createdAt`, `updatedAt`, `Customer_id`, `price`, `payed`, `Employee_id`) VALUES 
(NULL, current_timestamp(), NULL, '1', '24.95', b'1', '1'),
(NULL, current_timestamp(), NULL, '2', '36.74', b'0', '2'),
(NULL, current_timestamp(), NULL, '2', '18.64', b'0', '1'),
(NULL, current_timestamp(), NULL, '3', '14.77', b'0', NULL),
(NULL, current_timestamp(), NULL, '4', '52.12', b'0', NULL),
(NULL, current_timestamp(), NULL, '6', '63.27', b'0', NULL),
(NULL, current_timestamp(), NULL, '9', '27.41', b'0', NULL),
(NULL, current_timestamp(), NULL, '9', '29.34', b'0', NULL),
(NULL, current_timestamp(), NULL, '10', '27.41', b'0', NULL),
(NULL, current_timestamp(), NULL, '5', '29.34', b'0', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PrintSettings`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `PrintSettings` (`id`, `createdAt`, `updatedAt`, `resolution`, `infill`) VALUES 
(NULL, current_timestamp(), NULL, '0.12', '0.80'),
(NULL, current_timestamp(), NULL, '0.2', '1.00'),
(NULL, current_timestamp(), NULL, '0.12', '0.70'),
(NULL, current_timestamp(), NULL, '0.16', '0.80'),
(NULL, current_timestamp(), NULL, '0.04', '1.00'),
(NULL, current_timestamp(), NULL, '0.04', '0.90'),
(NULL, current_timestamp(), NULL, '0.16', '0.80'),
(NULL, current_timestamp(), NULL, '0.08', '0.90'),
(NULL, current_timestamp(), NULL, '0.16', '0.70'),
(NULL, current_timestamp(), NULL, '0.24', '0.50'),
(NULL, current_timestamp(), NULL, '0.12', '0.70');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Models`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Models` (`id`, `createdAt`, `updatedAt`, `fileName`) VALUES 
(NULL, current_timestamp(), NULL, 'Blume.stl'),
(NULL, current_timestamp(), NULL, 'Hund.stl'),
(NULL, current_timestamp(), NULL, 'Stock.stl'),
(NULL, current_timestamp(), NULL, 'DeckelGriff.stl'),
(NULL, current_timestamp(), NULL, 'LaserSchwert.stl'),
(NULL, current_timestamp(), NULL, 'Korkenzieher.stl'),
(NULL, current_timestamp(), NULL, 'LegoFelge.stl'),
(NULL, current_timestamp(), NULL, 'Türgriff.stl'),
(NULL, current_timestamp(), NULL, 'MiniYoda.stl'),
(NULL, current_timestamp(), NULL, 'Topf.stl');

COMMIT;


-- -----------------------------------------------------
-- Data for table `PrintConfig`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `PrintConfig` (`id`, `createdAt`, `updatedAt`, `Filaments_id`, `Models_id`, `PrintSettings_id`, `Orders_id`, `amount`) VALUES 
(NULL, current_timestamp(), NULL, '6', '1', '4', '4', '3');

INSERT INTO `PrintConfig` (`id`, `createdAt`, `updatedAt`, `Filaments_id`, `Models_id`, `PrintSettings_id`, `Orders_id`, `amount`) VALUES 
(NULL, current_timestamp(), NULL, '1', '1', '1', '1', '1'),
(NULL, current_timestamp(), NULL, '6', '1', '1', '1', '1'),
(NULL, current_timestamp(), NULL, '2', '2', '2', '2', '1'),
(NULL, current_timestamp(), NULL, '1', '3', '3', '3', '1'),
(NULL, current_timestamp(), NULL, '4', '3', '3', '3', '1'),
(NULL, current_timestamp(), NULL, '6', '3', '4', '3', '1'),
(NULL, current_timestamp(), NULL, '3', '4', '5', '4', '1'),
(NULL, current_timestamp(), NULL, '1', '5', '6', '5', '1'),
(NULL, current_timestamp(), NULL, '4', '6', '7', '6', '1'),
(NULL, current_timestamp(), NULL, '6', '7', '8', '7', '4'),
(NULL, current_timestamp(), NULL, '4', '7', '8', '7', '4'),
(NULL, current_timestamp(), NULL, '4', '8', '9', '8', '1'),
(NULL, current_timestamp(), NULL, '2', '9', '10', '9', '2'),
(NULL, current_timestamp(), NULL, '5', '10', '11', '10', '1'),
(NULL, current_timestamp(), NULL, '6', '10', '11', '10', '1');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Pricing`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Pricing` (`id`, `createdAt`, `updatedAt`, `shiping`, `workPerHour`, `energyPerHour`, `taxes`, `country`, `grammsPerMinute`) 
VALUES (NULL, current_timestamp(), NULL, '4.95', '3.215', '0.157', '0.19', 'Deutschland', '20.26');

COMMIT;



























