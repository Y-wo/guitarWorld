<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102185813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_guitar (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, guitar_id INT NOT NULL, UNIQUE INDEX UNIQ_ED279DC53DA5256D (image_id), UNIQUE INDEX UNIQ_ED279DC548420B1E (guitar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_guitar ADD CONSTRAINT FK_ED279DC53DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE image_guitar ADD CONSTRAINT FK_ED279DC548420B1E FOREIGN KEY (guitar_id) REFERENCES guitar (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_guitar DROP FOREIGN KEY FK_ED279DC53DA5256D');
        $this->addSql('ALTER TABLE image_guitar DROP FOREIGN KEY FK_ED279DC548420B1E');
        $this->addSql('DROP TABLE image_guitar');
    }
}
