<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240103080113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guitar ADD body VARCHAR(255) NOT NULL, ADD pickup VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE guitar_type DROP body, DROP pickup');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guitar DROP body, DROP pickup');
        $this->addSql('ALTER TABLE guitar_type ADD body VARCHAR(255) DEFAULT NULL, ADD pickup VARCHAR(255) DEFAULT NULL');
    }
}
