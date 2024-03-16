<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD shipping_addr_id INT DEFAULT NULL, ADD billing_addr_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEF104761F FOREIGN KEY (shipping_addr_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE7C62FB0C FOREIGN KEY (billing_addr_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEEF104761F ON orders (shipping_addr_id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE7C62FB0C ON orders (billing_addr_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEF104761F');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE7C62FB0C');
        $this->addSql('DROP INDEX IDX_E52FFDEEF104761F ON orders');
        $this->addSql('DROP INDEX IDX_E52FFDEE7C62FB0C ON orders');
        $this->addSql('ALTER TABLE orders DROP shipping_addr_id, DROP billing_addr_id');
    }
}
