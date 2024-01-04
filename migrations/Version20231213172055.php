<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231213172055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_details (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, the_order_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_845CA2C14584665A (product_id), INDEX IDX_845CA2C1C416F85B (the_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, date_order DATE NOT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_E52FFDEE19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C14584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1C416F85B FOREIGN KEY (the_order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE19EB6921 FOREIGN KEY (client_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C14584665A');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1C416F85B');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE19EB6921');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('DROP TABLE orders');
    }
}
