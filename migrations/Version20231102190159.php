<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102190159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_guitar DROP INDEX UNIQ_ED279DC53DA5256D, ADD INDEX IDX_ED279DC53DA5256D (image_id)');
        $this->addSql('ALTER TABLE image_guitar DROP INDEX UNIQ_ED279DC548420B1E, ADD INDEX IDX_ED279DC548420B1E (guitar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_guitar DROP INDEX IDX_ED279DC53DA5256D, ADD UNIQUE INDEX UNIQ_ED279DC53DA5256D (image_id)');
        $this->addSql('ALTER TABLE image_guitar DROP INDEX IDX_ED279DC548420B1E, ADD UNIQUE INDEX UNIQ_ED279DC548420B1E (guitar_id)');
    }
}
