<?php

declare (strict_types=1);
namespace Yabe\Ukiyo\Migrations;

use _YabeUkiyo\Rosua\Migrations\AbstractMigration;
use wpdb;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325064907 extends AbstractMigration
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
        $sql[] = "CREATE TABLE `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_central` (\n            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,\n            `uid` VARCHAR(255) NOT NULL,\n            `status` INT(1) NOT NULL DEFAULT 0,\n            `title` VARCHAR(255) NOT NULL,\n            `url` VARCHAR(255) NOT NULL,\n            `secret_key` TEXT,\n            `created_at` INT(11) NOT NULL,\n            `updated_at` INT(11) DEFAULT NULL,\n            PRIMARY KEY (`id`)\n        ) {$this->collation()};";
        \dbDelta($sql);
        $sql = "ALTER TABLE `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders`\n            ADD COLUMN `external_site` BIGINT UNSIGNED DEFAULT NULL\n        ";
        $wpdb->query($sql);
    }
    public function down() : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        /** @var wpdb $wpdb */
        global $wpdb;
        $sql[] = "ALTER TABLE `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders` \n            DROP COLUMN `external_site`\n        ";
        $sql[] = "DROP TABLE IF EXISTS `{$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_central`";
        foreach ($sql as $query) {
            $wpdb->query($query);
        }
    }
}
