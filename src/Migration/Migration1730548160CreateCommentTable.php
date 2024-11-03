<?php declare(strict_types=1);

namespace RustyMcFly\CommentCmsPage\Migration;

use DateTime;
use Doctrine\DBAL\Connection;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;

class Migration1730548160CreateCommentTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1730548160;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `comment` (
    `id` BINARY(16) NOT NULL,
    `parent_id` BINARY(16)  NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verified_at` DATETIME(3)  NULL,
    `email_verify_token` VARCHAR(255) NULL,
    `text` TEXT NOT NULL,
    `firstName` TEXT NOT NULL,
    `lastName` TEXT NOT NULL,
    `active` TINYINT(1) COLLATE utf8mb4_unicode_ci default 0,
    `category_id` binary(16) NOT NULL,
    `sales_channel_id` binary(16) NOT NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3),
    PRIMARY KEY (`id`),
    CONSTRAINT `fk.comments.category_id` FOREIGN KEY (`category_id`)
    REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.comments.parent_id` FOREIGN KEY (`parent_id`)
    REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.comments.sales_channel_id` FOREIGN KEY (`sales_channel_id`)
    REFERENCES `sales_channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4
    COLLATE = utf8mb4_unicode_ci;
SQL;

        $connection->executeStatement($sql);

        $mailTemplateId = $this->createMailTemplateType($connection);
    }

    private function getLanguageIdByLocale(Connection $connection, string $locale): ?string
    {
        $sql = <<<SQL
        SELECT `language`.`id`
        FROM `language`
        INNER JOIN `locale` ON `locale`.`id` = `language`.`locale_id`
        WHERE `locale`.`code` = :code
        SQL;

        $languageId = $connection->executeQuery($sql, ['code' => $locale])->fetchOne();

        if (empty($languageId)) {
            return null;
        }

        return $languageId;
    }


    private function createMailTemplateType(Connection $connection): string
    {
        $mailTemplateTypeId = Uuid::randomHex();

        $enGbLangId = $this->getLanguageIdByLocale($connection, 'en-GB');
        $deDeLangId = $this->getLanguageIdByLocale($connection, 'de-DE');

        $englishName = 'Comment E-mail';
        $germanName = 'Kommentar E-mail';

        $connection->executeStatement("
            INSERT IGNORE INTO `mail_template_type`
                (id, technical_name, available_entities, template_data, created_at)
            VALUES
                (:id, :technicalName, :availableEntities, :template_data, :createdAt)
        ",[
            'id' => Uuid::fromHexToBytes($mailTemplateTypeId),
            'technicalName' => 'comment_type',
            'availableEntities' => json_encode(['comment' => 'comment', 'salesChannel' => 'salesChannel']),
            'template_data' => json_encode(['confirmUrl' => 'confirmUrl']),
            'createdAt' => (new DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
        ]);

        if (!empty($enGbLangId)) {
            $connection->executeStatement("
            INSERT IGNORE INTO `mail_template_type_translation`
                (mail_template_type_id, language_id, name, created_at)
            VALUES
                (:mailTemplateTypeId, :languageId, :name, :createdAt)
            ",[
                'mailTemplateTypeId' => Uuid::fromHexToBytes($mailTemplateTypeId),
                'languageId' => $enGbLangId,
                'name' => $englishName,
                'createdAt' => (new DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
            ]);
        }

        if (!empty($deDeLangId)) {
            $connection->executeStatement("
            INSERT IGNORE INTO `mail_template_type_translation`
                (mail_template_type_id, language_id, name, created_at)
            VALUES
                (:mailTemplateTypeId, :languageId, :name, :createdAt)
            ",[
                'mailTemplateTypeId' => Uuid::fromHexToBytes($mailTemplateTypeId),
                'languageId' => $deDeLangId,
                'name' => $germanName,
                'createdAt' => (new DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
            ]);
        }

        return $mailTemplateTypeId;
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
