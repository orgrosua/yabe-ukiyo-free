<?php

declare (strict_types=1);
namespace Yabe\Ukiyo\Migrations;

use _YabeUkiyo\Rosua\Migrations\AbstractMigration;
use wpdb;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230713000501 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }
    public function up() : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /** @var wpdb $wpdb */
        global $wpdb;
        $sql[] = "CREATE TABLE `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses` (\n            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n            `uid` VARCHAR(255) NOT NULL,\n            `title` VARCHAR(255) NOT NULL,\n            `status` INT(1) NOT NULL DEFAULT 0,\n            `license_key` TEXT,\n            `max_sites` INT(11) DEFAULT NULL,\n            `user_id` BIGINT UNSIGNED DEFAULT NULL,\n            `expired_at` INT(11) DEFAULT NULL,\n            `created_at` INT(11) NOT NULL,\n            `updated_at` INT(11) DEFAULT NULL,\n            PRIMARY KEY (`id`)\n        ) {$this->collation()};";
        $sql[] = "CREATE TABLE `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites` (\n            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n            `uid` VARCHAR(255) NOT NULL,\n            `status` INT(1) NOT NULL DEFAULT 0,\n            `license_id` BIGINT UNSIGNED NOT NULL,\n            `site_url` VARCHAR(255) NOT NULL,\n            `created_at` INT(11) NOT NULL,\n            `updated_at` INT(11) DEFAULT NULL,\n            PRIMARY KEY (`id`)\n        ) {$this->collation()};";
        $sql[] = "CREATE TABLE `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes` (\n            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n            `uid` VARCHAR(255) NOT NULL,\n            `status` INT(1) NOT NULL DEFAULT 0,\n            `title` VARCHAR(255) NOT NULL,\n            `remote_url` VARCHAR(255) NOT NULL,\n            `license_key` TEXT,\n            `created_at` INT(11) NOT NULL,\n            `updated_at` INT(11) DEFAULT NULL,\n            PRIMARY KEY (`id`)\n        ) {$this->collation()};";
        $sql[] = "CREATE TABLE `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders` (\n            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n            `uid` VARCHAR(255) NOT NULL,\n            `order_status` VARCHAR(255) NOT NULL,\n            `vendor` VARCHAR(255) NOT NULL,\n            `order_id` VARCHAR(255) NOT NULL,\n            `order_type` VARCHAR(255) NOT NULL,\n            `product_id` VARCHAR(255) NOT NULL,\n            `product_type` VARCHAR(255) NOT NULL,\n            `customer_id` BIGINT UNSIGNED DEFAULT NULL,\n            `license_id` BIGINT UNSIGNED NOT NULL,\n            `created_at` INT(11) NOT NULL,\n            `updated_at` INT(11) DEFAULT NULL,\n            PRIMARY KEY (`id`)\n        ) {$this->collation()};";
        \dbDelta($sql);
    }
    public function down() : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        /** @var wpdb $wpdb */
        global $wpdb;
        $sql[] = "DROP TABLE IF EXISTS `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses`";
        $sql[] = "DROP TABLE IF EXISTS `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites`";
        $sql[] = "DROP TABLE IF EXISTS `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes`";
        $sql[] = "DROP TABLE IF EXISTS `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders`";
        foreach ($sql as $query) {
            $wpdb->query($query);
        }
    }
}
