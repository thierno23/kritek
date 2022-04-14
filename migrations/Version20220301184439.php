<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301184439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invocelines (id INT AUTO_INCREMENT NOT NULL, invoce_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, quantity INT NOT NULL, amount NUMERIC(10, 2) DEFAULT NULL, vat_amount NUMERIC(10, 2) DEFAULT NULL, total NUMERIC(10, 2) NOT NULL, INDEX IDX_6E0696C0EED8DFC8 (invoce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invocelines ADD CONSTRAINT FK_6E0696C0EED8DFC8 FOREIGN KEY (invoce_id) REFERENCES facture (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE invocelines');
    }
}
