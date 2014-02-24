
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product_date
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_date`;

CREATE TABLE `product_date`
(
    `id` INTEGER NOT NULL,
    `delivery_time_min` INTEGER,
    `delivery_time_max` INTEGER,
    `restock_time_min` INTEGER,
    `restock_time_max` INTEGER,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_product_date_product_sale_elements_id`
        FOREIGN KEY (`id`)
        REFERENCES `product_sale_elements` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# While the foreign key constraint is broken, insert an invalid id that will be the default one.
INSERT INTO `product_date` VALUES (0,0,0,0,0);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
