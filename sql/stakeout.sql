--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignID` int(24) NOT NULL,
  `caseID` int(48) NOT NULL,
  `username` varchar(48) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignID`),
  ADD KEY `caseID` (`caseID`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignID` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`caseID`) REFERENCES `cases` (`caseID`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user_creds` (`username`) ON UPDATE CASCADE;

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `caseID` int(48) NOT NULL,
  `caseNum` varchar(48) NOT NULL,
  `caseName` varchar(96) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`caseID`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `caseID` int(48) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Table structure for table `observations`
--

CREATE TABLE `observations` (
  `observeID` int(24) NOT NULL,
  `caseID` int(48) NOT NULL,
  `action` varchar(24) DEFAULT NULL,
  `username` varchar(48) NOT NULL,
  `pix` tinyint(1) NOT NULL DEFAULT '0',
  `observeAsset` varchar(200) DEFAULT NULL,
  `description` text NOT NULL,
  `observeTime` datetime NOT NULL,
  `lng` float(10,6) NOT NULL,
  `lat` float(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `observations`
--
ALTER TABLE `observations`
  ADD PRIMARY KEY (`observeID`),
  ADD KEY `caseID` (`caseID`),
  ADD KEY `username` (`username`);

--
-- Constraints for table `observations`
--
ALTER TABLE `observations`
  ADD CONSTRAINT `observations_ibfk_1` FOREIGN KEY (`caseID`) REFERENCES `cases` (`caseID`),
  ADD CONSTRAINT `observations_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user_creds` (`username`);

--
-- AUTO_INCREMENT for table `observations`
--
ALTER TABLE `observations`
  MODIFY `observeID` int(24) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
  
--
-- Table structure for table `user_creds`
--

CREATE TABLE `user_creds` (
  `id` int(12) NOT NULL,
  `username` varchar(48) NOT NULL,
  `forename` varchar(48) NOT NULL,
  `surname` varchar(48) NOT NULL,
  `password` varchar(72) NOT NULL DEFAULT 'password',
  `email` varchar(72) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `tokenCode` varchar(100) NOT NULL,
  `userStatus` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `user_creds`
--
ALTER TABLE `user_creds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for table `user_creds`
--
ALTER TABLE `user_creds`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

COMMIT;
