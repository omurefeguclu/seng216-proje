<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1748269982.
 * Generated on 2025-05-26 16:33:02  */
class PropelMigration_1748269982{
    /**
     * @var string
     */
    public $comment = '';

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL(): array
    {
        $connection_default = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `warehouse_product_stock`;

ALTER TABLE `warehouse_product_stock_log`

  ADD `related_transaction_id` INTEGER AFTER `product_id`;

CREATE INDEX `related_transaction_id` ON `warehouse_product_stock_log` (`related_transaction_id`);

ALTER TABLE `warehouse_product_stock_log` ADD CONSTRAINT `warehouse_product_stock_log_ibfk_3`
    FOREIGN KEY (`related_transaction_id`)
    REFERENCES `stock_transactions` (`id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'default' => $connection_default,
        ];
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL(): array
    {
        $connection_default = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `warehouse_product_stock_log` DROP FOREIGN KEY `warehouse_product_stock_log_ibfk_3`;

DROP INDEX `related_transaction_id` ON `warehouse_product_stock_log`;

ALTER TABLE `warehouse_product_stock_log`

  DROP `related_transaction_id`;

CREATE TABLE `warehouse_product_stock`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `warehouse_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    `amount` INTEGER NOT NULL,
    `created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `warehouse_id` (`warehouse_id`, `product_id`),
    INDEX `product_id` (`product_id`),
    CONSTRAINT `warehouse_product_stock_ibfk_1`
        FOREIGN KEY (`warehouse_id`)
        REFERENCES `warehouses` (`id`),
    CONSTRAINT `warehouse_product_stock_ibfk_2`
        FOREIGN KEY (`product_id`)
        REFERENCES `products` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'default' => $connection_default,
        ];
    }

}
