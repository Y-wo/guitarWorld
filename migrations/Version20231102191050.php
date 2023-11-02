<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102191050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guitar ADD guitar_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guitar ADD CONSTRAINT FK_423AC30DE8BADEA0 FOREIGN KEY (guitar_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_423AC30DE8BADEA0 ON guitar (guitar_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guitar DROP FOREIGN KEY FK_423AC30DE8BADEA0');
        $this->addSql('DROP INDEX UNIQ_423AC30DE8BADEA0 ON guitar');
        $this->addSql('ALTER TABLE guitar DROP guitar_order_id');
    }
}
