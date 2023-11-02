<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102172732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guitar (id INT AUTO_INCREMENT NOT NULL, guitar_type_id INT NOT NULL, model VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, is_stored TINYINT(1) NOT NULL, deleted TINYINT(1) NOT NULL, price VARCHAR(255) NOT NULL, used TINYINT(1) DEFAULT NULL, INDEX IDX_423AC30D5026D2CB (guitar_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guitar ADD CONSTRAINT FK_423AC30D5026D2CB FOREIGN KEY (guitar_type_id) REFERENCES guitar_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guitar DROP FOREIGN KEY FK_423AC30D5026D2CB');
        $this->addSql('DROP TABLE guitar');
    }
}
