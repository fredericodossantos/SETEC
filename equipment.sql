

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `equipment` (`id`, `name`, `description`, `category`, `serial_number`, `status_id`) VALUES
(13, 'DRONE', 'Equipamento de filmagem aérea', 'FOTOREGISTRO', '12222111122', 1);


ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_equipment_status_id` (`status_id`);


ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;


ALTER TABLE `equipment`
  ADD CONSTRAINT `fk_equipment_status_id` FOREIGN KEY (`status_id`) REFERENCES `status_lookup` (`id`);
COMMIT;
