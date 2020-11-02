--
-- Registries - Setup (1.0.0)
--
-- @package Coordinator\Modules\Registries
-- @author  Manuel Zavatta <manuel.zavatta@gmail.com>
-- @link    http://www.coordinator.it
--

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `registries__roles`
--

CREATE TABLE IF NOT EXISTS `registries__roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registries__registries`
--

CREATE TABLE IF NOT EXISTS `registries__registries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `typology` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'private, freelance, company, public',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fiscal` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registries__registries__logs`
--

CREATE TABLE IF NOT EXISTS `registries__registries__logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fkObject` int(11) unsigned NOT NULL,
  `fkUser` int(11) unsigned DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `alert` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `event` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `properties_json` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fkObject` (`fkObject`),
  CONSTRAINT `registries__registries__logs_ibfk_1` FOREIGN KEY (`fkObject`) REFERENCES `registries__registries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registries__registries__join__roles`
--

CREATE TABLE IF NOT EXISTS `registries__registries__join__roles` (
  `fkRegistry` int(11) unsigned NOT NULL,
  `fkRole` int(11) unsigned NOT NULL,
  PRIMARY KEY (`fkRegistry`,`fkRole`),
  KEY `fkRegistry` (`fkRegistry`),
  KEY `fkRole` (`fkRole`),
  CONSTRAINT `registries__registries__join__roles_ibfk_1` FOREIGN KEY (`fkRegistry`) REFERENCES `registries__registries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `registries__registries__join__roles_ibfk_2` FOREIGN KEY (`fkRole`) REFERENCES `registries__roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Authorizations
--

INSERT IGNORE INTO `framework__modules__authorizations` (`id`,`fkModule`,`order`) VALUES
('registries-manage','registries',1),
('registries-usage','registries',2);

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
