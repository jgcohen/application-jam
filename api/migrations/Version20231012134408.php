<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231012134408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flavor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_flavor (product_id INT NOT NULL, flavor_id INT NOT NULL, INDEX IDX_DE5975F04584665A (product_id), INDEX IDX_DE5975F0FDDA6450 (flavor_id), PRIMARY KEY(product_id, flavor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_flavor ADD CONSTRAINT FK_DE5975F04584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_flavor ADD CONSTRAINT FK_DE5975F0FDDA6450 FOREIGN KEY (flavor_id) REFERENCES flavor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_flavor DROP FOREIGN KEY FK_DE5975F04584665A');
        $this->addSql('ALTER TABLE product_flavor DROP FOREIGN KEY FK_DE5975F0FDDA6450');
        $this->addSql('DROP TABLE flavor');
        $this->addSql('DROP TABLE product_flavor');
    }
}
