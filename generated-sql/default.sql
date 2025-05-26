
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- products
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(255) NOT NULL,
    `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `NAME` (`NAME`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- stock_transactions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `stock_transactions`;

CREATE TABLE `stock_transactions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `product_id` INTEGER NOT NULL,
    `from_warehouse_id` INTEGER,
    `to_warehouse_id` INTEGER,
    `vehicle_id` INTEGER,
    `creator_user_id` INTEGER,
    `amount` INTEGER NOT NULL,
    `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `product_id` (`product_id`),
    INDEX `from_warehouse_id` (`from_warehouse_id`),
    INDEX `to_warehouse_id` (`to_warehouse_id`),
    INDEX `vehicle_id` (`vehicle_id`),
    INDEX `creator_user_id` (`creator_user_id`),
    CONSTRAINT `stock_transactions_ibfk_1`
        FOREIGN KEY (`product_id`)
        REFERENCES `products` (`id`),
    CONSTRAINT `stock_transactions_ibfk_2`
        FOREIGN KEY (`from_warehouse_id`)
        REFERENCES `warehouses` (`id`),
    CONSTRAINT `stock_transactions_ibfk_3`
        FOREIGN KEY (`to_warehouse_id`)
        REFERENCES `warehouses` (`id`),
    CONSTRAINT `stock_transactions_ibfk_4`
        FOREIGN KEY (`vehicle_id`)
        REFERENCES `vehicles` (`id`),
    CONSTRAINT `stock_transactions_ibfk_5`
        FOREIGN KEY (`creator_user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `PASSWORD` VARCHAR(255) NOT NULL,
    `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username` (`username`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- vehicles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vehicles`;

CREATE TABLE `vehicles`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `plate_number` VARCHAR(20) NOT NULL,
    `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `plate_number` (`plate_number`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- warehouse_product_stock_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `warehouse_product_stock_log`;

CREATE TABLE `warehouse_product_stock_log`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `warehouse_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    `related_transaction_id` INTEGER,
    `amount` INTEGER NOT NULL,
    `is_received` TINYINT(1) NOT NULL,
    `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `warehouse_id` (`warehouse_id`),
    INDEX `product_id` (`product_id`),
    INDEX `related_transaction_id` (`related_transaction_id`),
    CONSTRAINT `warehouse_product_stock_log_ibfk_1`
        FOREIGN KEY (`warehouse_id`)
        REFERENCES `warehouses` (`id`),
    CONSTRAINT `warehouse_product_stock_log_ibfk_2`
        FOREIGN KEY (`product_id`)
        REFERENCES `products` (`id`),
    CONSTRAINT `warehouse_product_stock_log_ibfk_3`
        FOREIGN KEY (`related_transaction_id`)
        REFERENCES `stock_transactions` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- warehouses
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `warehouses`;

CREATE TABLE `warehouses`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(255) NOT NULL,
    `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `NAME` (`NAME`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
