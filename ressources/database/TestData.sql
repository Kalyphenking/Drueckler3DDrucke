
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
(NULL, current_timestamp(), NULL, 'Mirfälltkeinnameein Straße', '9e', '99099', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Domstraße', '3', '99084', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Käthe-Kollwitz-Straße', '11', '99096', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Am Stadpark', '8', '99096', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Gerarer Str.', '11', '99099', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Wilhelm-Leibl-Straße Straße', '10', '99096', 'Erfurt', 'Deutschland'),

-- BillAddress
(NULL, current_timestamp(), NULL, 'Tschaikowskistraße', '4', '99096', 'Erfurt', 'Deutschland'),
(NULL, current_timestamp(), NULL, 'Friedrich Herbst Str.', '4a', '51097', 'Ferffurt', 'Deutschland');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ContactData`.`login`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `ContactData` (`id`, `createdAt`, `updatedAt`, `Address_id`, `firstName`, `lastName`, `phoneNumber`, `emailAddress`, `username`, `password`) VALUES 
-- Customer
(NULL, current_timestamp(), NULL, '1', 'Peter', 'Hase', '03615557738', 'peterhase@lol.com', 'ich', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '2', 'Rainer', 'Zufall', NULL, 'rainerzufall@gmail.com', 'habe', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '3', 'Tom', 'Hanks', '18949948198', 'tomtom@web.com', 'keine', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '5', 'Ronald', 'McDonald', '8948468949', 'notburgerking@t-online.de', 'ideen', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '7', 'Hans', 'Zimmer', NULL, 'räumdeinzimmerauf@keyweb.de', 'mehr', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '9', 'Kevina', 'Lleinzuhaus', '84984118991', 'kevinsmom@de.com', 'für', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '10', 'Oliver Mathias', 'Jensen', '228884984/9', 'joollinololli@lol.eu', 'test', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '11', 'Ronalda', 'Schmidt', '419890070', 'schmidtschmitt@gmail.com', 'einträge', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '12', 'Petra', 'Krause', NULL, 'halskrause@lol.com', 'butterkuchen', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),
(NULL, current_timestamp(), NULL, '13', 'Ariell', 'Diemeerjungfrau', '48915484815156', 'Diemeerjungfrau@gmail.com', 'liebe', '$2y$12$yC6BfDpJi9wJ4WZ/OVIEmuEcCjPDZ5UKOnq1Zq0cDo0BvRn8rtZ6q'),

-- Employee
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

INSERT INTO `CreditCard` (`id`, `createdAt`, `updatedAt`, `number`, `type`, `owner`, `expiryDate`, `securityCode`, `numberShort`) VALUES 
(NULL, current_timestamp(), NULL, '1234432156781234', 'MasterCard', 'Peters Frau', '06/04', '349', '************5678'),
(NULL, current_timestamp(), NULL, '4784984949123649', 'VisaCard', 'Hans Zimmer', '03/20', '545', '************4949');

COMMIT;

-- -----------------------------------------------------
-- Data for table `Bill`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Bill`(`id`, `createdAt`, `updatedAt`, `Address_id`) VALUES

(NULL, current_timestamp(), NULL, '14'),
(NULL, current_timestamp(), NULL, '8'), -- BillAddress = ShippingAddress
(NULL, current_timestamp(), NULL, '15');

COMMIT;

-- -----------------------------------------------------
-- Data for table `Paypal`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Paypal`(`id`, `createdAt`, `updatedAt`, `emailAddress`, `password`) VALUES

(NULL, current_timestamp(), NULL, 'peterhase@lol.com', 'geheim'),
(NULL, current_timestamp(), NULL, 'kaufen@förma.de', 'geheim'),
(NULL, current_timestamp(), NULL, 'ichkaufeheimlichzeug@gmx.de', 'geheim');

COMMIT;

-- -----------------------------------------------------
-- Data for table `DirectDebit`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `DirectDebit`(`id`, `createdAt`, `updatedAt`, `iban`, `ibanShort`, `owner`, `mandate`) VALUES

(NULL, current_timestamp(), NULL, 'DE13798246729217619572', 'DE****************9572', 'Pipi Langsstrumpf', '0'),
(NULL, current_timestamp(), NULL, 'DE13497568246925497261', 'DE****************7261', 'Rainer Zufall', '1'),
(NULL, current_timestamp(), NULL, 'DE13792794235279526454', 'DE****************6454', 'Auto Brum Brumm GmbH', '1');

COMMIT;

-- -----------------------------------------------------
-- Data for table `PaymentData`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `PaymentData`(`id`, `createdAt`, `updatedAt`, `CreditCard_id`, `DirectDebit_id`, `Bill_id`, `Paypal_id`, `preferedPaymentMethod`) VALUES
(NULL, current_timestamp(), NULL, '1', NULL, NULL, NULL, 'cc'), 
(NULL, current_timestamp(), NULL, NULL, '1', NULL, '3', 'dd'),
(NULL, current_timestamp(), NULL, NULL, NULL, '1', NULL, 'bl'),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL, '1', 'pp'),
(NULL, current_timestamp(), NULL, NULL, '3', NULL, NULL, 'dd'),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL, '2', 'pp'),
(NULL, current_timestamp(), NULL, NULL, NULL, '2', NULL, 'bl'),
(NULL, current_timestamp(), NULL, '2', NULL, '3', NULL, 'bl'),
(NULL, current_timestamp(), NULL, NULL, '2', NULL, NULL, 'dd'),
(NULL, current_timestamp(), NULL, NULL, NULL, NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `Customer`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Customer` (`id`, `createdAt`, `updatedAt`, `PaymentData_id`, `guest`, `ContactData_id`) VALUES 
(NULL, current_timestamp(), NULL, '1', '0', '1'),
(NULL, current_timestamp(), NULL, '2', '0', '2'),
(NULL, current_timestamp(), NULL, '10', '0', '3'),
(NULL, current_timestamp(), NULL, '4', '0', '4'),
(NULL, current_timestamp(), NULL, '3', '0', '5'),
(NULL, current_timestamp(), NULL, '5', '0', '6'),
(NULL, current_timestamp(), NULL, '6', '0', '7'),
(NULL, current_timestamp(), NULL, '7', '0', '8'),
(NULL, current_timestamp(), NULL, '8', '0', '9'),
(NULL, current_timestamp(), NULL, '9', '0', '10');

COMMIT;

-- -----------------------------------------------------
-- Data for table `Employee`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Employee` (`id`, `createdAt`, `updatedAt`, `admin`, `ContactData_id`) VALUES 
(NULL, current_timestamp(), NULL, '1', '11'),
(NULL, current_timestamp(), NULL, '0', '12'),
(NULL, current_timestamp(), NULL, '0', '13'),
(NULL, current_timestamp(), NULL, '1', '14'),
(NULL, current_timestamp(), NULL, '0', '15');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Filaments`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Filaments` (`id`, `createdAt`, `updatedAt`, `color`, `type`, `producer`, `pricePerGramm`) VALUES
(NULL, '2021-01-11 13:09:54', NULL, 'red', 'PLA', 'Sunlu', '0.028'),
(NULL, '2021-01-11 13:10:41', NULL, 'green', 'PLA', 'Sunlu', '0.028'),
(NULL, '2021-01-11 13:10:41', NULL, 'blue', 'PLA', 'Sunlu', '0.028'),
(NULL, '2021-01-11 13:12:47', NULL, 'white', 'ABS', 'Sunlu', '0.033'),
(NULL, '2021-01-11 13:12:47', NULL, 'orange', 'PLA', 'Sunlu', '0.028'),
(NULL, '2021-01-11 13:12:47', NULL, 'black', 'ABS', 'Sunlu', '0.033');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Orders`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Orders` (`id`, `createdAt`, `updatedAt`, `Customer_id`, `price`, `payed`, `Employee_id`) VALUES 
(NULL, current_timestamp(), NULL, '1', '24.95', '1', '1'),
(NULL, current_timestamp(), NULL, '2', '36.74', '0', '2'),
(NULL, current_timestamp(), NULL, '2', '18.64', '0', '1'),
(NULL, current_timestamp(), NULL, '3', '14.77', '0', NULL),
(NULL, current_timestamp(), NULL, '4', '52.12', '0', NULL),
(NULL, current_timestamp(), NULL, '6', '63.27', '0', NULL),
(NULL, current_timestamp(), NULL, '9', '27.41', '0', NULL),
(NULL, current_timestamp(), NULL, '9', '29.34', '0', NULL),
(NULL, current_timestamp(), NULL, '10', '27.41', '0', NULL),
(NULL, current_timestamp(), NULL, '5', '29.34', '0', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `PrintSettings`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `PrintSettings` (`id`, `createdAt`, `updatedAt`, `resolution`, `infill`, `description`) VALUES 
(NULL, current_timestamp(), NULL, '0.12', '0.80', 'presetName'),
(NULL, current_timestamp(), NULL, '0.2', '1.00', 'presetName'),
(NULL, current_timestamp(), NULL, '0.12', '0.70', 'presetName'),
(NULL, current_timestamp(), NULL, '0.16', '0.80', 'presetName'),
(NULL, current_timestamp(), NULL, '0.04', '1.00', 'presetName'),
(NULL, current_timestamp(), NULL, '0.04', '0.90', NULL),
(NULL, current_timestamp(), NULL, '0.16', '0.80', NULL),
(NULL, current_timestamp(), NULL, '0.08', '0.90', NULL),
(NULL, current_timestamp(), NULL, '0.16', '0.70', NULL),
(NULL, current_timestamp(), NULL, '0.24', '0.50', NULL),
(NULL, current_timestamp(), NULL, '0.12', '0.70', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Models`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Models` (`id`, `createdAt`, `updatedAt`, `fileName`, `modelPrice`) VALUES 
(NULL, current_timestamp(), NULL, 'Blume.stl', '9.05'),
(NULL, current_timestamp(), NULL, 'Hund.stl', '42.12'),
(NULL, current_timestamp(), NULL, 'Stock.stl', '5.90'),
(NULL, current_timestamp(), NULL, 'DeckelGriff.stl', '15.34'),
(NULL, current_timestamp(), NULL, 'LaserSchwert.stl', '129.38'),
(NULL, current_timestamp(), NULL, 'Korkenzieher.stl', '7.26'),
(NULL, current_timestamp(), NULL, 'LegoFelge.stl', '21.53'),
(NULL, current_timestamp(), NULL, 'Türgriff.stl', '26.24'),
(NULL, current_timestamp(), NULL, 'MiniYoda.stl', '11.44'),
(NULL, current_timestamp(), NULL, 'Topf.stl', '49.30');

COMMIT;


-- -----------------------------------------------------
-- Data for table `PrintConfig`.`module`
-- -----------------------------------------------------
START TRANSACTION;


INSERT INTO `PrintConfig` (`id`, `createdAt`, `updatedAt`, `Filaments_id`, `Models_id`, `PrintSettings_id`, `Orders_id`, `amount`, `printTime`) VALUES 
(NULL, current_timestamp(), NULL, '1', '1', '1', '1', '1', '24'),
(NULL, current_timestamp(), NULL, '6', '1', '1', '1', '1', '12'),
(NULL, current_timestamp(), NULL, '2', '2', '2', '2', '1', '48'),
(NULL, current_timestamp(), NULL, '1', '7', '3', '3', '1', '72'),
(NULL, current_timestamp(), NULL, '4', '10', '3', '3', '1', '10'),
(NULL, current_timestamp(), NULL, '6', '3', '4', '3', '1', '3'),
(NULL, current_timestamp(), NULL, '3', '4', '5', '4', '1', '21'),
(NULL, current_timestamp(), NULL, '1', '5', '6', '5', '1', '14'),
(NULL, current_timestamp(), NULL, '4', '6', '7', '6', '1', '51'),
(NULL, current_timestamp(), NULL, '6', '3', '8', '7', '4', '5'),
(NULL, current_timestamp(), NULL, '4', '7', '8', '7', '4', '9'),
(NULL, current_timestamp(), NULL, '4', '8', '9', '8', '1', '0'),
(NULL, current_timestamp(), NULL, '2', '9', '10', '9', '2', '2'),
(NULL, current_timestamp(), NULL, '5', '3', '11', '10', '1', '2'),
(NULL, current_timestamp(), NULL, '6', '10', '11', '10', '1', '4');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Pricing`.`module`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `Pricing` (`id`, `createdAt`, `updatedAt`, `shiping`, `workPerHour`, `energyPerHour`, `taxes`, `country`, `grammsPerMinute`, `Currency`) 
VALUES (NULL, current_timestamp(), NULL, '4.95', '3.215', '0.157', '0.19', 'Deutschland', '20.26', 'EUR');

COMMIT;

--
-- START TRANSACTION;
--
-- INSERT INTO `Presets` (`id`, `createdAt`, `updatedAt`, `description`, `PrintSettings_id`, `Filaments_id`)
-- VALUES (NULL, current_timestamp(), NULL, '0', '0', '0');
--
-- COMMIT;



























