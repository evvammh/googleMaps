CREATE TABLE IF NOT EXISTS `reset_password` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `reset_code` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL COMMENT 'Time when link was created and sent to user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
