-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2015 at 10:21 PM
-- Server version: 5.6.16
-- PHP Version: 5.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel_quickstart`
--

-- --------------------------------------------------------

--
-- Table structure for table `bhpvsspeed`
--

CREATE TABLE IF NOT EXISTS `bhpvsspeed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `speed` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brake_hp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `scfm` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `bhpvsspeed`
--

INSERT INTO `bhpvsspeed` (`id`, `speed`, `brake_hp`, `scfm`, `created_at`, `updated_at`) VALUES
(1, '300', '125.0455253', '1166.661257', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '325', '136.5423647', '1263.883028', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '350', '148.2048008', '1361.1048', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '375', '160.0328336', '1458.326571', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '400', '172.0264632', '1555.548343', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '425', '184.1856896', '1652.770114', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '450', '196.5105127', '1749.991885', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '475', '209.0009326', '1847.213657', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '500', '221.6569492', '1944.435428', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, '525', '234.4785626', '2041.6572', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, '550', '247.4657727', '2138.878971', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, '575', '260.6185796', '2236.100742', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, '600', '273.9369832', '2333.322514', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, '625', '287.4209836', '2430.544285', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, '650', '301.0705808', '2527.766057', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, '675', '314.8857747', '2624.987828', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, '700', '328.8665653', '2722.209599', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, '725', '343.0129527', '2819.431371', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, '750', '357.3249369', '2916.653142', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, '775', '371.8025178', '3013.874914', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, '800', '386.4456955', '3111.096685', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, '825', '401.2544699', '3208.318456', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, '850', '416.2288411', '3305.540228', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, '875', '431.368809', '3402.761999', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, '900', '446.6743737', '3499.983771', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, '925', '462.1455352', '3597.205542', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, '950', '477.7822933', '3694.427314', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, '975', '493.5846483', '3791.649085', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, '1000', '509.5526', '3888.870856', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, '1025', '525.6861484', '3986.092628', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bhpvsspeeds`
--

CREATE TABLE IF NOT EXISTS `bhpvsspeeds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `compressoraftercoolers`
--

CREATE TABLE IF NOT EXISTS `compressoraftercoolers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sss_40psi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sss_30psi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sss_20psi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ss_40psi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ss_30psi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ss_20psi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approach_temp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `selling_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `compressoraftercoolers`
--

INSERT INTO `compressoraftercoolers` (`id`, `sss_40psi`, `sss_30psi`, `sss_20psi`, `ss_40psi`, `ss_30psi`, `ss_20psi`, `approach_temp`, `selling_price`, `weight`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '1', '168', '144', '117', 'SAF-12', '2151', '235', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(2, '168', '144', '117', '285', '247', '200', 'SAF-20', '2748', '405', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(3, '285', '247', '200', '460', '398', '322', 'SAF-32', '3119', '505', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(4, '460', '398', '322', '658', '573', '463', 'SAF-46', '3239', '585', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(5, '658', '573', '463', '760', '660', '535', 'SAF-53', '3525', '715', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(6, '760', '660', '535', '1030', '895', '725', 'SAF-72', '4140', '745', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(7, '1030', '895', '725', '1530', '1330', '1075', 'SAF-105', '4976', '940', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(8, '1530', '1330', '1075', '2100', '1830', '1148', 'SAF-146', '5948', '1105', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(9, '2100', '1830', '1148', '2701', '2335', '1885', 'SAF-194', '7237', '1530', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(10, '2701', '2335', '1885', '3780', '3280', '2650', 'SAF-258', '9311', '2025', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(11, '3780', '3280', '2650', '4310', '3750', '3040', 'SAF-294', '10356', '2115', '2015-05-11 18:45:26', '2015-05-11 18:45:26'),
(12, '4310', '3750', '3040', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2015-05-11 18:45:26', '2015-05-11 18:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `compressordatabase`
--

CREATE TABLE IF NOT EXISTS `compressordatabase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `displ_capacity` int(11) NOT NULL,
  `HP_displ` int(11) NOT NULL,
  `emp_hp_factor` int(11) NOT NULL,
  `nom_rpm` int(11) NOT NULL,
  `max_rpm` int(11) NOT NULL,
  `min_rpm` int(11) NOT NULL,
  `air_ve_part_1` double(8,2) NOT NULL,
  `air_ve_part_2` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `compressordatabases`
--

CREATE TABLE IF NOT EXISTS `compressordatabases` (
  `id` int(2) NOT NULL DEFAULT '0',
  `size` varchar(5) DEFAULT NULL,
  `displ_capacity` int(4) DEFAULT NULL,
  `HP_displ` int(4) DEFAULT NULL,
  `emp_hp_factor` int(2) DEFAULT NULL,
  `nom_rpm` int(4) DEFAULT NULL,
  `max_rpm` int(4) DEFAULT NULL,
  `min_rpm` int(3) DEFAULT NULL,
  `air_ve_part_1` decimal(4,2) DEFAULT NULL,
  `air_ve_part_2` decimal(4,3) DEFAULT NULL,
  `aa_value` int(1) DEFAULT NULL,
  `unloaded_bhp` int(11) NOT NULL,
  `standout` float NOT NULL,
  `blade_thickness` float NOT NULL,
  `wr_2` float(10,2) NOT NULL,
  `wr_2_w_sp_cplg` float(10,2) NOT NULL,
  `each_head` int(11) NOT NULL,
  `intake_flange` int(11) NOT NULL,
  `cylinder_wall_number` int(11) NOT NULL,
  `cylinder_wall_drops` int(11) NOT NULL,
  `lube_feed_each_head` int(11) NOT NULL,
  `lube_feed_intake_flange` int(11) NOT NULL,
  `drops_shaft_seal` int(11) NOT NULL,
  `drops_cylinder_number` int(11) NOT NULL,
  `drops_wall_drops` int(11) NOT NULL,
  `bearing_number` int(11) NOT NULL,
  `seal_drops` int(11) NOT NULL,
  `number_feeds` int(11) NOT NULL,
  `inlet_air` varchar(255) NOT NULL,
  `outlet_air` varchar(255) NOT NULL,
  `inlet_water` varchar(255) NOT NULL,
  `outlet_water` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `volumetric_a` float NOT NULL,
  `volumetric_b` float NOT NULL,
  `column_58` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `compressordatabases`
--

INSERT INTO `compressordatabases` (`id`, `size`, `displ_capacity`, `HP_displ`, `emp_hp_factor`, `nom_rpm`, `max_rpm`, `min_rpm`, `air_ve_part_1`, `air_ve_part_2`, `aa_value`, `unloaded_bhp`, `standout`, `blade_thickness`, `wr_2`, `wr_2_w_sp_cplg`, `each_head`, `intake_flange`, `cylinder_wall_number`, `cylinder_wall_drops`, `lube_feed_each_head`, `lube_feed_intake_flange`, `drops_shaft_seal`, `drops_cylinder_number`, `drops_wall_drops`, `bearing_number`, `seal_drops`, `number_feeds`, `inlet_air`, `outlet_air`, `inlet_water`, `outlet_water`, `weight`, `volumetric_a`, `volumetric_b`, `column_58`) VALUES
(1, 'CC15', 126, 138, 8, 1760, 1940, 725, '97.10', '3.500', 1, 0, 0.999, 0.246, 0.00, 0.00, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '2" FLGD', '2" FLGD', '1/2" FPT', '1" FPT', 970, 97.1, 3.5, 0),
(2, 'C30', 173, 190, 5, 1180, 1500, 725, '97.10', '3.500', 1, 8, 0.812, 0.246, 7.00, 7.00, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '3" FLGD', '1/2" FPT', '1" FPT', 970, 97.1, 3.5, 0),
(3, 'C40', 213, 232, 6, 1180, 1500, 725, '97.10', '3.500', 1, 10, 0.97, 0.246, 7.00, 7.00, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '3" FLGD', '1/2" FPT', '1" FPT', 970, 97.1, 3.5, 0),
(4, 'C50', 254, 276, 6, 1180, 1500, 725, '97.10', '3.500', 1, 11, 1.128, 0.246, 7.00, 7.00, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '3" FLGD', '1/2" FPT', '1" FPT', 970, 97.1, 3.5, 0),
(5, 'CC30', 258, 283, 12, 1760, 1848, 725, '97.10', '3.500', 1, 0, 0.812, 0.246, 7.00, 7.00, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '3" FLGD', '1/2" FPT', '1" FPT', 970, 97.1, 3.5, 0),
(6, 'C60', 303, 324, 7, 880, 1000, 500, '96.50', '3.000', 1, 13, 1.181, 0.246, 22.70, 24.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '4" FLGD', '1/2" FPT', '1" FPT', 1685, 96.5, 3, 0),
(7, 'CC40', 318, 346, 14, 1760, 1848, 725, '97.10', '3.500', 1, 0, 0.97, 0.246, 7.00, 7.00, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '3" FLGD', '1/2" FPT', '1" FPT', 970, 97.1, 3.5, 0),
(8, 'C70', 363, 385, 7, 880, 1000, 500, '96.50', '3.000', 1, 15, 1.378, 0.246, 22.70, 24.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '4" FLGD', '1/2" FPT', '1" FPT', 1685, 96.5, 3, 0),
(9, 'CC50', 379, 412, 14, 1760, 1848, 725, '97.10', '3.500', 1, 0, 1.128, 0.246, 7.00, 7.00, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '3" FLGD', '1/2" FPT', '1" FPT', 970, 97.1, 3.5, 0),
(10, 'CC60', 406, 434, 13, 1180, 1240, 500, '96.50', '3.000', 1, 0, 1.181, 0.246, 22.70, 24.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '4" FLGD', '1/2" FPT', '1" FPT', 1685, 96.5, 3, 0),
(11, 'C80', 430, 460, 9, 880, 1000, 500, '96.50', '3.000', 1, 18, 1.182, 0.246, 30.90, 32.80, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2065, 96.5, 3, 0),
(12, 'CC70', 487, 516, 13, 1180, 1240, 500, '96.50', '3.000', 1, 0, 1.378, 0.246, 22.70, 24.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '4" FLGD', '4" FLGD', '1/2" FPT', '1" FPT', 1685, 96.5, 3, 0),
(13, 'C100', 513, 551, 10, 880, 1000, 500, '96.50', '3.000', 1, 20, 1.378, 0.246, 30.90, 32.80, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2065, 96.5, 3, 0),
(14, 'C110', 573, 609, 11, 705, 800, 400, '97.55', '2.375', 1, 22, 1.512, 0.246, 70.20, 85.10, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2850, 97.55, 2.375, 0),
(15, 'CC80', 576, 617, 17, 1180, 1240, 500, '96.50', '3.000', 1, 0, 1.182, 0.246, 30.90, 32.80, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2065, 96.5, 3, 0),
(16, 'C120', 651, 690, 12, 705, 800, 400, '97.55', '2.375', 1, 25, 1.694, 0.246, 70.20, 85.10, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2850, 97.55, 2.375, 0),
(17, 'CC100', 688, 739, 18, 1180, 1240, 500, '96.50', '3.000', 1, 0, 1.378, 0.246, 30.90, 32.80, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2065, 96.5, 3, 0),
(18, 'CC110', 715, 760, 18, 880, 924, 400, '97.55', '2.375', 1, 0, 1.512, 0.246, 70.20, 85.10, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2850, 97.55, 2.375, 0),
(19, 'C135', 738, 778, 13, 705, 800, 400, '97.55', '2.375', 1, 28, 1.526, 0.246, 86.70, 101.60, 6, 0, 3, 6, 7, 0, 3, 3, 7, 2, 7, 8, '6" FLGD', '5" FLGD', '1" FPT', '1 1/2" FPT', 3650, 97.55, 2.375, 0),
(20, 'CC120', 813, 861, 19, 880, 924, 400, '97.55', '2.375', 1, 0, 1.694, 0.246, 70.20, 85.10, 5, 5, 2, 5, 6, 6, 3, 2, 6, 2, 6, 8, '5" FLGD', '5" FLGD', '3/4" FPT', '1" FPT', 2850, 97.55, 2.375, 0),
(21, 'C150', 831, 877, 13, 705, 800, 400, '97.55', '2.375', 1, 31, 1.694, 0.246, 86.70, 101.60, 6, 0, 3, 6, 7, 0, 3, 3, 7, 2, 7, 8, '6" FLGD', '5" FLGD', '1" FPT', '1 1/2" FPT', 3650, 97.55, 2.375, 0),
(22, 'CC135', 921, 971, 21, 880, 924, 400, '97.55', '2.375', 1, 0, 1.526, 0.246, 86.70, 101.60, 6, 0, 3, 6, 7, 0, 3, 3, 7, 2, 7, 8, '6" FLGD', '5" FLGD', '1" FPT', '1 1/2" FPT', 3650, 97.55, 2.375, 0),
(23, 'C175', 950, 1000, 17, 590, 650, 325, '97.55', '2.375', 1, 35, 1.875, 0.308, 215.00, 232.90, 7, 0, 3, 7, 8, 0, 3, 3, 8, 2, 8, 8, '8" FLGD', '8" FLGD', '1" FPT', '1 1/2" FPT', 5000, 97.55, 2.375, 0),
(24, 'CC150', 1037, 1095, 21, 880, 924, 400, '97.55', '2.375', 1, 0, 1.694, 0.246, 86.70, 101.60, 6, 0, 3, 6, 7, 0, 3, 3, 7, 2, 7, 8, '6" FLGD', '5" FLGD', '1" FPT', '1 1/2" FPT', 3650, 97.55, 2.375, 0),
(25, 'C200', 1120, 1175, 20, 590, 650, 325, '97.55', '2.375', 1, 40, 2.166, 0.308, 215.00, 232.90, 7, 0, 3, 7, 8, 0, 3, 3, 8, 2, 8, 8, '8" FLGD', '8" FLGD', '1" FPT', '1 1/2" FPT', 5000, 97.55, 2.375, 0),
(26, 'CC175', 1135, 1195, 25, 705, 740, 325, '97.55', '2.375', 1, 0, 1.875, 0.308, 215.00, 232.90, 7, 0, 3, 7, 8, 0, 3, 3, 8, 2, 8, 8, '8" FLGD', '8" FLGD', '1" FPT', '1 1/2" FPT', 5000, 97.55, 2.375, 0),
(27, 'C225', 1315, 1382, 23, 590, 650, 325, '97.55', '2.375', 1, 47, 2, 0.308, 253.00, 270.90, 8, 0, 3, 8, 9, 0, 3, 3, 9, 2, 9, 8, '8" FLGD', '8" FLGD', '1" FPT', '1 1/2" FPT', 5600, 97.55, 2.375, 0),
(28, 'CC200', 1338, 1404, 29, 705, 740, 325, '97.55', '2.375', 1, 0, 2.166, 0.308, 215.00, 232.90, 7, 0, 3, 7, 8, 0, 3, 3, 8, 2, 8, 8, '8" FLGD', '8" FLGD', '1" FPT', '1 1/2" FPT', 5000, 97.55, 2.375, 0),
(29, 'C250', 1492, 1572, 26, 590, 650, 325, '97.55', '2.375', 1, 52, 1.92, 0.308, 311.00, 329.40, 7, 0, 5, 7, 8, 0, 3, 5, 8, 2, 8, 10, '8" FLGD', '8" FLGD', '1 1/4" FPT', '2" FPT', 5770, 97.55, 2.375, 0),
(30, 'CC225', 1571, 1651, 33, 705, 740, 325, '97.55', '2.375', 1, 0, 2, 0.308, 253.00, 270.90, 8, 0, 3, 8, 9, 0, 3, 3, 9, 2, 9, 8, '8" FLGD', '8" FLGD', '1" FPT', '1 1/2" FPT', 5600, 97.55, 2.375, 0),
(31, 'C300', 1718, 1800, 30, 590, 650, 325, '97.55', '2.375', 1, 59, 2.166, 0.308, 311.00, 329.40, 7, 0, 5, 7, 8, 0, 3, 5, 8, 2, 8, 10, '8" FLGD', '8" FLGD', '1 1/4" FPT', '2" FPT', 5700, 97.55, 2.375, 0),
(32, 'CC250', 1783, 1878, 38, 705, 740, 325, '97.55', '2.375', 1, 0, 1.92, 0.308, 311.00, 329.40, 7, 0, 5, 7, 8, 0, 3, 5, 8, 2, 8, 10, '8" FLGD', '8" FLGD', '1 1/4" FPT', '2" FPT', 5700, 97.55, 2.375, 0),
(33, 'C350', 2000, 2100, 32, 590, 650, 325, '97.55', '2.375', 1, 68, 2.166, 0.308, 360.00, 378.40, 9, 0, 5, 9, 10, 0, 3, 5, 10, 2, 10, 10, '10" FLGD', '8" FLGD', '1 1/4" FPT', '2" FPT', 6300, 97.55, 2.375, 0),
(34, 'CC300', 2053, 2151, 43, 705, 740, 325, '97.55', '2.375', 1, 0, 2.166, 0.308, 311.00, 329.40, 7, 0, 5, 7, 8, 0, 3, 5, 8, 2, 8, 10, '8" FLGD', '8" FLGD', '1 1/4" FPT', '2" FPT', 5700, 97.55, 2.375, 0),
(35, 'C375', 2130, 2280, 33, 500, 514, 300, '97.55', '2.375', 1, 0, 2.38, 0.43, 0.00, 0.00, 11, 0, 5, 11, 12, 0, 3, 5, 12, 2, 12, 10, '10" FLGD', '8" FLGD', '2 1/2" FPT', '3" FPT', 10400, 97.55, 2.375, 0),
(36, 'C400', 2273, 2425, 35, 500, 514, 300, '97.55', '2.375', 1, 0, 2.166, 0.43, 0.00, 0.00, 11, 0, 5, 11, 12, 0, 3, 5, 12, 2, 12, 10, '10" FLGD', '8" FLGD', '2 1/2" FPT', '3" FPT', 10400, 97.55, 2.375, 0),
(37, 'C450', 2557, 2710, 39, 500, 514, 300, '97.55', '2.375', 1, 0, 2.77, 0.43, 0.00, 0.00, 11, 0, 5, 11, 12, 0, 3, 5, 12, 2, 12, 10, '10" FLGD', '8" FLGD', '2 1/2" FPT', '3" FPT', 10400, 97.55, 2.375, 0),
(38, 'C508', 2778, 2962, 43, 500, 514, 300, '97.55', '2.375', 1, 130, 2.54, 0.43, 798.00, 836.00, 11, 0, 7, 11, 12, 0, 3, 7, 12, 2, 12, 12, '', '', '', '', 12500, 97.55, 2.375, 0),
(39, 'C608', 3238, 3446, 50, 500, 514, 300, '97.55', '2.375', 1, 141, 2.9, 0.43, 798.00, 836.00, 11, 0, 7, 11, 12, 0, 3, 7, 12, 2, 12, 12, '', '', '', '', 12500, 97.55, 2.375, 0),
(40, 'B30', 62, 70, 5, 1180, 1500, 725, '99.00', '7.000', 2, 0, 0.764, 0.246, 4.50, 6.40, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '2" FLGD', '2" FLGD', '3/4" FPT', '3/4" FPT', 440, 99, 7, 1),
(41, 'CB30', 92, 104, 11, 1760, 1848, 725, '99.00', '7.000', 2, 0, 0.764, 0.246, 4.50, 6.40, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '2" FLGD', '2" FLGD', '3/4" FPT', '3/4" FPT', 440, 99, 7, 2),
(42, 'B40', 74, 81, 5, 1180, 1500, 725, '99.00', '7.000', 2, 0, 0.891, 0.246, 4.50, 6.40, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '2" FLGD', '2" FLGD', '3/4" FPT', '3/4" FPT', 480, 99, 7, 3),
(43, 'CB40', 110, 121, 11, 1760, 1848, 725, '99.00', '7.000', 2, 0, 0.891, 0.246, 4.50, 6.40, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '2" FLGD', '2" FLGD', '3/4" FPT', '3/4" FPT', 480, 99, 7, 4),
(44, 'B50', 89, 98, 5, 1180, 1500, 725, '99.00', '7.000', 2, 0, 1.043, 0.246, 4.50, 6.40, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '2" FLGD', '2" FLGD', '3/4" FPT', '3/4" FPT', 520, 99, 7, 5),
(45, 'CB50', 133, 146, 11, 1760, 1848, 725, '99.00', '7.000', 2, 0, 1.043, 0.246, 4.50, 6.40, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '2" FLGD', '2" FLGD', '3/4" FPT', '3/4" FPT', 520, 99, 7, 6),
(46, 'B60', 105, 116, 6, 880, 1000, 500, '97.50', '6.000', 2, 0, 1.181, 0.308, 10.70, 12.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '3" FLGD', '3" FLGD', '3/4" FPT', '3/4" FPT', 950, 97.5, 6, 7),
(47, 'CB60', 141, 156, 11, 1180, 1240, 500, '97.50', '6.000', 2, 0, 1.181, 0.308, 10.70, 12.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '3" FLGD', '3" FLGD', '3/4" FPT', '3/4" FPT', 950, 97.5, 6, 8),
(48, 'B70', 130, 142, 6, 880, 1000, 500, '97.50', '6.000', 2, 0, 1.326, 0.308, 10.70, 12.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '3" FLGD', '3" FLGD', '3/4" FPT', '3/4" FPT', 1000, 97.5, 6, 9),
(49, 'CB70', 174, 190, 11, 1180, 1240, 500, '97.50', '6.000', 2, 0, 1.326, 0.308, 10.70, 12.60, 4, 4, 0, 0, 5, 5, 3, 0, 0, 2, 5, 6, '3" FLGD', '3" FLGD', '3/4" FPT', '3/4" FPT', 1000, 97.5, 6, 10),
(50, 'B80', 146, 158, 9, 880, 1000, 500, '97.50', '6.000', 2, 0, 1.114, 0.308, 12.90, 14.80, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '3" FLGD', '3" FLGD', '1" FPT', '1" FPT', 1200, 97.5, 6, 11),
(51, 'CB80', 196, 212, 16, 1180, 1240, 500, '97.50', '6.000', 2, 0, 1.114, 0.308, 12.90, 14.80, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '3" FLGD', '3" FLGD', '1" FPT', '1" FPT', 1200, 97.5, 6, 12),
(52, 'B100', 174, 190, 9, 880, 1000, 500, '97.50', '6.000', 2, 0, 1.295, 0.308, 12.90, 14.80, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '3" FLGD', '3" FLGD', '1" FPT', '1" FPT', 1300, 97.5, 6, 13),
(53, 'CB100', 233, 255, 16, 1180, 1240, 500, '97.50', '6.000', 2, 0, 1.295, 0.367, 12.90, 14.80, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '3" FLGD', '3" FLGD', '1" FPT', '1" FPT', 1300, 97.5, 6, 14),
(54, 'B110', 200, 218, 10, 705, 800, 400, '97.00', '4.750', 2, 0, 1.375, 0.367, 45.80, 60.70, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '4" FLGD', '4" FLGD', '1" FPT', '1" FPT', 1400, 97, 4.75, 15),
(55, 'CB110', 250, 272, 16, 880, 925, 400, '97.00', '4.750', 2, 0, 1.375, 0.367, 45.80, 60.70, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '4" FLGD', '4" FLGD', '1" FPT', '1" FPT', 1400, 97, 4.75, 16),
(56, 'B120', 226, 245, 10, 705, 800, 400, '97.00', '4.750', 2, 0, 1.532, 0.367, 45.80, 60.70, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '4" FLGD', '4" FLGD', '1" FPT', '1" FPT', 1500, 97, 4.75, 17),
(57, 'CB120', 282, 306, 16, 880, 925, 400, '97.00', '4.750', 2, 0, 1.532, 0.367, 45.80, 60.70, 5, 5, 0, 0, 6, 6, 3, 0, 0, 2, 6, 6, '4" FLGD', '4" FLGD', '1" FPT', '1" FPT', 1500, 97, 4.75, 18),
(58, 'B135', 254, 276, 12, 705, 800, 400, '97.00', '4.750', 2, 0, 1.41, 0.367, 52.30, 67.20, 6, 6, 0, 0, 7, 7, 3, 0, 0, 2, 7, 6, '5" FLGD', '5" FLGD', '1" FPT', '1" FPT', 1700, 97, 4.75, 19),
(59, 'CB135', 317, 345, 19, 880, 925, 400, '97.00', '4.750', 2, 0, 1.41, 0.367, 52.30, 67.20, 6, 6, 0, 0, 7, 7, 3, 0, 0, 2, 7, 6, '5" FLGD', '5" FLGD', '1" FPT', '1" FPT', 1700, 97, 4.75, 20),
(60, 'B150', 286, 312, 12, 705, 800, 400, '97.00', '4.750', 2, 0, 1.559, 0.367, 52.30, 67.20, 6, 6, 0, 0, 7, 7, 3, 0, 0, 2, 7, 6, '5" FLGD', '5" FLGD', '1" FPT', '1" FPT', 1800, 97, 4.75, 21),
(61, 'CB150', 357, 389, 19, 880, 925, 400, '97.00', '4.750', 2, 0, 1.559, 0.367, 52.30, 67.20, 6, 6, 0, 0, 7, 7, 3, 0, 0, 2, 7, 6, '5" FLGD', '5" FLGD', '1" FPT', '1" FPT', 1800, 97, 4.75, 22),
(62, 'B175', 316, 345, 15, 590, 650, 325, '97.10', '3.500', 2, 0, 1.667, 0.43, 113.00, 130.90, 7, 7, 0, 0, 8, 8, 3, 0, 0, 2, 8, 6, '5" FLGD', '5" FLGD', '1 1/4" FPT', '1 1/4" FPT', 2400, 97.1, 3.5, 23),
(63, 'CB175', 377, 412, 21, 705, 740, 325, '97.10', '3.500', 2, 0, 1.667, 0.43, 113.00, 130.90, 7, 7, 0, 0, 8, 8, 3, 0, 0, 2, 8, 6, '5" FLGD', '5" FLGD', '1 1/4" FPT', '1 1/4" FPT', 2400, 97.1, 3.5, 24),
(64, 'B200', 375, 408, 15, 590, 650, 325, '97.10', '3.500', 2, 0, 1.942, 0.43, 113.00, 130.90, 7, 7, 0, 0, 8, 8, 3, 0, 0, 2, 8, 6, '5" FLGD', '5" FLGD', '1 1/4" FPT', '1 1/4" FPT', 2550, 97.1, 3.5, 25),
(65, 'CB200', 448, 488, 21, 705, 740, 325, '97.10', '3.500', 2, 0, 1.942, 0.43, 113.00, 130.90, 7, 7, 0, 0, 8, 8, 3, 0, 0, 2, 8, 6, '5" FLGD', '5" FLGD', '1 1/4" FPT', '1 1/4" FPT', 2550, 97.1, 3.5, 26),
(66, 'B225', 441, 482, 17, 590, 650, 325, '97.10', '3.500', 2, 0, 1.58, 0.43, 146.00, 163.90, 7, 0, 2, 7, 8, 0, 3, 2, 8, 2, 8, 7, '6" FLGD', '5" FLGD', '1 1/2" FPT', '1 1/2" FPT', 2550, 97.1, 3.5, 27),
(67, 'CB225', 527, 576, 24, 705, 740, 325, '97.10', '3.500', 2, 0, 1.58, 0.43, 146.00, 163.90, 7, 0, 2, 7, 8, 0, 3, 2, 8, 2, 8, 7, '6" FLGD', '5" FLGD', '1 1/2" FPT', '1 1/2" FPT', 2550, 97.1, 3.5, 28),
(68, 'B250', 502, 550, 20, 590, 650, 325, '97.10', '3.500', 2, 0, 1.782, 0.43, 146.00, 165.90, 7, 0, 2, 7, 8, 0, 3, 2, 8, 2, 8, 10, '6" FLGD', '5" FLGD', '1 1/2" FPT', '1 1/2" FPT', 3800, 97.1, 3.5, 29),
(69, 'CB250', 600, 657, 29, 705, 740, 325, '97.10', '3.500', 2, 0, 1.782, 0.43, 146.00, 165.90, 7, 0, 2, 7, 8, 0, 3, 2, 8, 2, 8, 10, '6" FLGD', '5" FLGD', '1 1/2" FPT', '1 1/2" FPT', 3800, 97.1, 3.5, 30),
(70, 'B300', 571, 622, 20, 590, 650, 325, '97.10', '3.500', 2, 0, 1.99, 0.43, 146.00, 165.90, 7, 0, 2, 7, 8, 0, 3, 2, 8, 2, 8, 10, '6" FLGD', '5" FLGD', '1 1/2" FPT', '1 1/2" FPT', 4000, 97.1, 3.5, 31),
(71, 'CB300', 682, 743, 29, 705, 740, 325, '97.10', '3.500', 2, 0, 1.99, 0.43, 146.00, 165.90, 7, 0, 2, 7, 8, 0, 3, 2, 8, 2, 8, 10, '6" FLGD', '5" FLGD', '1 1/2" FPT', '1 1/2" FPT', 4000, 97.1, 3.5, 32),
(72, 'B350', 668, 725, 22, 590, 650, 325, '97.10', '3.500', 2, 0, 1.99, 0.43, 165.00, 184.90, 9, 0, 3, 9, 10, 0, 3, 3, 10, 2, 10, 10, '6" FLGD', '5" FLGD', '1 1/2" FPT', '1 1/2" FPT', 4300, 97.1, 3.5, 33);

-- --------------------------------------------------------

--
-- Table structure for table `compressor_database_2`
--

CREATE TABLE IF NOT EXISTS `compressor_database_2` (
  `id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `displ_capacity` int(11) NOT NULL,
  `HP_displ` int(11) NOT NULL,
  `emp_hp_factor` int(11) NOT NULL,
  `nom_rpm` int(11) NOT NULL,
  `max_rpm` int(11) NOT NULL,
  `min_rpm` int(11) NOT NULL,
  `air_ve_part_1` float NOT NULL,
  `air_ve_part_2` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `compressor_database_2`
--

INSERT INTO `compressor_database_2` (`id`, `size`, `displ_capacity`, `HP_displ`, `emp_hp_factor`, `nom_rpm`, `max_rpm`, `min_rpm`, `air_ve_part_1`, `air_ve_part_2`) VALUES
(1, 'cc15', 126, 138, 8, 1760, 1940, 725, 97.1, 3.5),
(2, 'c30', 173, 190, 5, 1180, 1500, 725, 97.1, 3.5),
(3, 'c40', 213, 232, 6, 1180, 1500, 725, 97.1, 3.5),
(4, 'c50', 254, 276, 6, 1180, 1500, 725, 97.1, 3.5),
(5, 'cc30', 258, 283, 12, 1760, 1848, 725, 97.1, 3.5),
(6, 'c60', 303, 324, 7, 880, 1000, 500, 96.5, 3),
(7, 'cc40', 318, 346, 14, 1760, 1848, 725, 97.1, 3.5),
(8, 'c70', 363, 385, 7, 880, 1000, 500, 96.5, 3),
(9, 'cc50', 379, 412, 14, 1760, 1848, 725, 97.1, 3.5),
(10, 'cc60', 406, 434, 13, 1180, 1240, 500, 96.5, 3),
(11, 'c80', 430, 460, 9, 880, 1000, 500, 96.5, 3),
(12, 'cc70', 487, 516, 13, 1180, 1240, 500, 96.5, 3),
(13, 'c100', 513, 551, 10, 880, 1000, 500, 96.5, 3),
(14, 'c110', 573, 609, 11, 705, 800, 400, 97.55, 2.375),
(15, 'cc80', 576, 617, 17, 1180, 1240, 500, 96.5, 3),
(16, 'c120', 651, 690, 12, 705, 800, 400, 97.55, 2.375),
(17, 'cc100', 688, 739, 18, 1180, 1240, 500, 96.5, 3),
(18, 'cc110', 715, 760, 18, 880, 924, 400, 97.55, 2.375),
(19, 'c135', 738, 778, 13, 705, 800, 400, 97.55, 2.375),
(20, 'cc120', 813, 861, 19, 880, 924, 400, 97.55, 2.375),
(21, 'c150', 831, 877, 13, 705, 800, 400, 97.55, 2.375),
(22, 'cc135', 921, 971, 21, 880, 924, 400, 97.55, 2.375),
(23, 'c175', 950, 1000, 17, 590, 650, 325, 97.55, 2.375),
(24, 'cc150', 1037, 1095, 21, 880, 924, 400, 97.55, 2.375),
(25, 'c200', 1120, 1175, 20, 590, 650, 325, 97.55, 2.375),
(26, 'cc175', 1135, 1195, 25, 705, 740, 325, 97.55, 2.375),
(27, 'c225', 1315, 1382, 23, 590, 650, 325, 97.55, 2.375),
(28, 'cc200', 1338, 1404, 29, 705, 740, 325, 97.55, 2.375),
(29, 'c250', 1492, 1572, 26, 590, 650, 325, 97.55, 2.375),
(30, 'cc225', 1571, 1651, 33, 705, 740, 325, 97.55, 2.375),
(31, 'c300', 1718, 1800, 30, 590, 650, 325, 97.55, 2.375),
(32, 'cc250', 1783, 1878, 38, 705, 740, 325, 97.55, 2.375),
(33, 'c350', 2000, 2100, 32, 590, 650, 325, 97.55, 2.375),
(34, 'cc300', 2053, 2151, 43, 705, 740, 325, 97.55, 2.375),
(35, 'c375', 2130, 2280, 33, 500, 514, 300, 97.55, 2.375),
(36, 'c400', 2273, 2425, 35, 500, 514, 300, 97.55, 2.375),
(37, 'c450', 2557, 2710, 39, 500, 514, 300, 97.55, 2.375),
(38, 'c508', 2778, 2962, 43, 500, 514, 300, 97.55, 2.375),
(39, 'c608', 3238, 3446, 50, 500, 514, 300, 97.55, 2.375),
(40, 'b30', 62, 70, 5, 1180, 1500, 725, 99, 7),
(41, 'cb30', 92, 104, 11, 1760, 1848, 725, 99, 7),
(42, 'b40', 74, 81, 5, 1180, 1500, 725, 99, 7),
(43, 'cb40', 110, 121, 11, 1760, 1848, 725, 99, 7),
(44, 'b50', 89, 98, 5, 1180, 1500, 725, 99, 7),
(45, 'cb50', 133, 146, 11, 1760, 1848, 725, 99, 7),
(46, 'b60', 105, 116, 6, 880, 1000, 500, 97.5, 6),
(47, 'cb60', 141, 156, 11, 1180, 1240, 500, 97.5, 6),
(48, 'b70', 130, 142, 6, 880, 1000, 500, 97.5, 6),
(49, 'cb70', 174, 190, 11, 1180, 1240, 500, 97.5, 6),
(50, 'b80', 146, 158, 9, 880, 1000, 500, 97.5, 6),
(51, 'cb80', 196, 212, 16, 1180, 1240, 500, 97.5, 6),
(52, 'b100', 174, 190, 9, 880, 1000, 500, 97.5, 6),
(53, 'cb100', 233, 255, 16, 1180, 1240, 500, 97.5, 6),
(54, 'b110', 200, 218, 10, 705, 800, 400, 97, 4.75),
(55, 'cb110', 250, 272, 16, 880, 925, 400, 97, 4.75),
(56, 'b120', 226, 245, 10, 705, 800, 400, 97, 4.75),
(57, 'cb120', 282, 306, 16, 880, 925, 400, 97, 4.75),
(58, 'b135', 254, 276, 12, 705, 800, 400, 97, 4.75),
(59, 'cb135', 317, 345, 19, 880, 925, 400, 97, 4.75),
(60, 'b150', 286, 312, 12, 705, 800, 400, 97, 4.75),
(61, 'cb150', 357, 389, 19, 880, 925, 400, 97, 4.75),
(62, 'b175', 316, 345, 15, 590, 650, 325, 97.1, 3.5),
(63, 'cb175', 377, 412, 21, 705, 740, 325, 97.1, 3.5),
(64, 'b200', 375, 408, 15, 590, 650, 325, 97.1, 3.5),
(65, 'cb200', 448, 488, 21, 705, 740, 325, 97.1, 3.5),
(66, 'b225', 441, 482, 17, 590, 650, 325, 97.1, 3.5),
(67, 'cb225', 527, 576, 24, 705, 740, 325, 97.1, 3.5),
(68, 'b250', 502, 550, 20, 590, 650, 325, 97.1, 3.5),
(69, 'cb250', 600, 657, 29, 705, 740, 325, 97.1, 3.5),
(70, 'b300', 571, 622, 20, 590, 650, 325, 97.1, 3.5),
(71, 'cb300', 682, 743, 29, 705, 740, 325, 97.1, 3.5),
(72, 'b350', 668, 725, 22, 590, 650, 325, 97.1, 3.5);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_01_27_202349_create_bhp_vs_speed', 1),
('2014_10_12_000000_create_users_table', 2),
('2014_10_12_100000_create_password_resets_table', 2),
('2015_04_02_163048_create_bhpvsspeed_table', 3),
('2015_04_02_163817_create_bhpvsspeeds_table', 4),
('2015_05_09_234921_create_compressor_database', 4),
('2015_05_09_235206_create_compressor_database_table', 4),
('2015_05_10_000243_create_compressordatabases_table', 4),
('2015_05_11_182903_create_compressoraftercoolers_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'denny', 'dw@b2bdd.com', '$2y$10$bif18RruR0DjLM4ssmidzO6yjlT1OpfutCiUh8ZkjZxI8JUpcNXFG', 'sx1NE5I0N6pP3UcqqLhQrnZsP3Mqd9haUuSDrQ8LD6bJHDN3FlwrbhL4dUX2', '2015-04-02 20:09:02', '2015-05-18 18:51:38');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
