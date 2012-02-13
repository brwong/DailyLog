This is a personal journal program.
I whipped it up in about thirty hours in April of 2010.

It provides an HTML form to enter daily events, meals eaten, notable
thoughts of the day, hours slept the previous night, and even number
of steps taken throughout the day (it requires a pedometer, or someone
with really good memory and concentration).
The form can also retrive past days' entries.

The form also has a HTML5 canvas password protection system.
It displays a series of touch-dots, and a pattern must be drawn across
them to gain access.
Web security was not my strong point (still isn't), so this part needs
improvement.

The backend is an SQL database, accessed by a php script (using mysqli).

The Daily Log requires the following to work:
- a file called "accept.php" of the following format:
	<?php
	$accepted = "xxxxxxxxx";//the password number sequence
	?>
- a file called "access.php" of the following format:
	<?php
		$db = 
		$db = new mysqli(
			'sql.example.com',// host
			'username',// username
			'password',// password
			'mydatabase'// database name
		);
	?>
- lastly, a database with a table "daily" of the following format:
	CREATE TABLE `daily` (
	  `date` date NOT NULL,
	  `steps` mediumint(9) NOT NULL,
	  `meals` text NOT NULL,
	  `sleep` varchar(20) NOT NULL,
	  `events` text NOT NULL,
	  `thoughts` text NOT NULL,
	  UNIQUE KEY `date` (`date`)
	)

Good luck!

-Brandon Wong, February 2012

