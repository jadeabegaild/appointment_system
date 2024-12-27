-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 10:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `service` varchar(255) NOT NULL,
  `appointment_date` datetime DEFAULT NULL,
  `history` text DEFAULT NULL,
  `status` enum('pending','accepted','rejected','completed') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `first_name`, `last_name`, `address`, `contact_number`, `email`, `service`, `appointment_date`, `history`, `status`, `user_id`) VALUES
(1, 'Kenneth', 'Inciong', '127 Mangga St. Guinobatan', '09651254862', 'datinguinoojadeabegail@gmail.com', '6', '2024-12-27 17:15:00', 'jkfgaiufgca ', 'pending', 4);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`) VALUES
(6, 'Speech Audiometry', 'Speech audiometry evaluates how well a person can hear and understand speech. It includes two tests: one measures the volume at which speech can be heard, and the other assesses how clearly speech is understood. This test involves the patient listening to words at different volumes and repeating them. It is typically done in a sound booth, using headphones, and results are reported as speech reception threshold (SRT) and word recognition score (WRS). '),
(7, 'Ear Piercing Care and Treatment', 'Ear piercing closure occurs when the hole made during a piercing heals or closes over time. This is often due to infection or the body’s natural response to a foreign object. Symptoms include pain or tenderness at the piercing site, redness and swelling, pus or discharge, and an itchy or burning sensation.'),
(8, 'Tympanoplasty', 'Tympanoplasty is a surgical procedure used to repair a perforated eardrum or middle ear damage. It improves hearing by closing the hole in the eardrum. Symptoms that lead to tympanoplasty include chronic ear infections, hearing loss, ear drainage, and a persistent feeling of fullness or pressure in the ear.'),
(9, 'Nasal Endoscopy', '\r\nNasal endoscopy involves inserting a thin, flexible tube with a camera into the nasal passages to examine the nose and sinuses. It helps diagnose conditions like sinus infections or nasal polyps. Common symptoms for which nasal endoscopy might be used include nasal congestion, facial pain or pressure, frequent sinus infections, and nasal bleeding.'),
(10, 'Closed Nasal Bone Reduction', '\r\nClosed nasal bone reduction is a non-surgical procedure to realign broken nasal bones, often done after trauma. Symptoms that may indicate the need for this procedure include a misaligned nose, difficulty breathing through the nose, swelling, bruising, and visible deformity of the nasal area following an injury'),
(11, 'Laryngoscopy', '\r\nLaryngoscopy involves examining the larynx (voice box) using a flexible or rigid tube. It is used to diagnose issues like voice disorders, inflammation, or cancer. Symptoms prompting a laryngoscopy include hoarseness, throat pain, difficulty swallowing, and a chronic cough'),
(12, 'Esophagoscopy', '\r\nEsophagoscopy involves using a flexible tube to examine the esophagus. This procedure is typically used to identify conditions such as esophageal reflux, swallowing difficulties, or cancer. Symptoms that may lead to esophagoscopy include difficulty swallowing, chest pain, heartburn, and regurgitation');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `contact_number`, `username`, `password`, `role`, `email`) VALUES
(1, 'JADE ABEGAIL ARDENA DATINGUINOO', '2147483647', 'jadeabegail', '$2y$10$WZcs.tnb9bReICsnBJzke.dGXcO/rtdQjitenJLrFTUGohorke0CW', 'admin', 'datinguinoojadeabegail@gmail.com'),
(2, 'ABEGAIIL DATINGUINOO', '2147483647', 'johnluis', '$2y$10$pkUN7CkyIpLZQ0k6EK3p.uDaeJzvHtXllaWrh7VJP7cmRRt8PvDlC', 'user', 'johnluisalbufera@gmail.com'),
(3, 'Admin', '09155794238', 'admin', '$2y$10$bjUjmHwPx3DKZXXWm9OtFOxnnL3t76.w3Ib/7ZbNuxpA/gt3gHNTi', 'admin', 'admin@gmail.com'),
(4, 'Kenneth Inciong', '09651254862', 'kennethinciong', '$2y$10$aJgtDUjlqWsYUuq.NyYVAukL8UtvgEjMuSAQ3vpPOnN4PuVCCi4bC', 'user', 'datinguinoojadeabegail@gmail.com'),
(5, 'Manolo Alejo', '09154876154', 'manoloalejo', '$2y$10$Vy4F50KpHU4md4ZUBhhe..7v3jA2hdJUH8/74NG4WycaQk1Oq8qk2', 'user', 'manoloalejo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Error reading structure for table appointment_system.users: #1932 - Table &#039;appointment_system.users&#039; doesn&#039;t exist in engine
-- Error reading data for table appointment_system.users: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `appointment_system`.`users`&#039; at line 1

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
